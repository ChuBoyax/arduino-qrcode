<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\StudentQrToken;
use App\Models\User;
use Exception;

class StudentQrTokenController extends Controller
{
    public function fetchStudentData(Request $request) {
        try {
            $qrData = $request->url;
    
            if (!$qrData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No QR data received'
                ], 400);
            }

            $qrtoken = last(explode('/', rtrim($qrData, '/')));
            
            $token = User::findOrFail(1)->remember_token;
            if(!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token not found.'
                ], 404);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'x-api-key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3BvcnRhbC5tbGdjbC5lZHUucGgiLCJhdWQiOnsiZG9tYWluIjoiYXR0ZW5kYW5jZS5tbGdjbC5lZHUucGgiLCJzZXJ2aWNlIjp0cnVlLCJ1aWQiOiI5NDQxZWVhNy0yNTdkLTQ1ZWQtODlmZC05NGEwNWJhNmRjODkifSwiaWF0IjoxNzU4NTM5MTEzLCJuYmYiOm51bGx9.ezHqYAldjPWOXv5VkhhJRXq8eAJ4ETlw67BqPg0Tlh8',
                'Authorization' => 'Bearer ' . $token,
                'Origin' => 'attendance.mlgcl.edu.ph'
            ])->withOptions([
                'verify' => false
            ])->get('https://api-portal.mlgcl.edu.ph/api/external/qr-code/user/' . $qrtoken);

            if(!$response->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch data'
                ], 500);
            }
    
            return response()->json([
                'status' => 'success',
                'qr_data' => $qrtoken,
                'data' => $response->json()
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
