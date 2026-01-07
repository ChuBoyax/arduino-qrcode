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
                'x-api-key' => env('API_KEY'),
                'Origin' => env('ORIGIN')
            ])->withOptions([
                'verify' => false
            ])->get('https://hnvs-id-be.creativedevlabs.com/api/qr_code/verify/' . $qrtoken);

            if(!$response->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch data'
                ], 500);
            }

            $studentData = $response->json();
            Student::create([
                'first_name' => $studentData['data']['firstname'] ?? null,
                'last_name'  => $studentData['data']['lastname'] ?? null,
                'image_url'  => $studentData['data']['image'] ?? null,
            ]);
    
            return response()->json([
                'status' => 'success',
                'qr_data' => $qrtoken,
                'data' => $studentData
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchStudents() {
        return response()->json([
            'data' => Student::all()
        ], 200);
    }

}
