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
            'Accept' => 'application/json'
        ])->get($request->url);

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
        
        $studentData = $response->json();

        if(!isset($studentData->data['full_name'], $studentData->data['image'])) {
            Cache::put('scan_result', [
                'status' => 'error',
                'message' => 'Invalid qr data.'
            ], now()->addSeconds(2));

            return response()->json([
                'status' => 'error',
                'message' => 'Invalid qr data.'
            ], 500);
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
