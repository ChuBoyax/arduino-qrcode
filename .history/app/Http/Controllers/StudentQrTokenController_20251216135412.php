<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\StudentQrToken;

class StudentQrTokenController extends Controller
{
    public function fetchStudentData(Request $request) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'x-api-key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3BvcnRhbC5tbGdjbC5lZHUucGgiLCJhdWQiOnsiZG9tYWluIjoiYXR0ZW5kYW5jZS5tbGdjbC5lZHUucGgiLCJzZXJ2aWNlIjp0cnVlLCJ1aWQiOiI5NDQxZWVhNy0yNTdkLTQ1ZWQtODlmZC05NGEwNWJhNmRjODkifSwiaWF0IjoxNzU4NTM5MTEzLCJuYmYiOm51bGx9.ezHqYAldjPWOXv5VkhhJRXq8eAJ4ETlw67BqPg0Tlh8',
            'Authorization' => '2f92376c2d6db986ec8c19d6eddd1baffb5e9c2a756dec05e49b49af251f22c3',
            'Origin' => 'attendance.mlgcl.edu.ph'
        ])->withOptions([
            'verify' => false
        ])->get('https://api-portal.mlgcl.edu.ph/api/external/' . $request->qr_token);

        if(!$response->successful()){
            Cache::put('scan_result', [
                'status' => 'error',
                'message' => 'Failed to fetch student data from the provided URL.'
            ], now()->addSeconds(2));

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch student data from the provided URL.'
            ], 500);
        }
        
        dd($response->body());
        $studentData = $response->json();

        if(!isset($studentData['full_name'], $studentData['image'])) {
            Cache::put('scan_result', [
                'status' => 'error',
                'message' => $studentData
            ], now()->addSeconds(2));

            return response()->json([
                'status' => 'error',
                'message' => $response->json()
            ], 400);
        }

        Cache::put('scan_result', [
            'status' => 'success',
            'student' => [
                'full_name' => $studentData->data['full_name'],
                'image_url' => $studentData->data['image']
            ]
        ], now()->addSeconds(2));

        Student::create([
            'full_name' => $studentData->data['full_name'],
            'image_url' => $studentData->data['image']
        ]);
        
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
