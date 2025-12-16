<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\StudentQrToken;

class StudentQrTokenController extends Controller
{
    public function fetchStudentData(Request $request) {

        if(empty($request)) {
            Cache::put('scan_result', [
                'status' => 'error',
                'message' => 'No data received'
            ], now()->addSeconds(2));

            return response()->json([
                'status' => 'error',
                'message' => 'No data received'
            ], 400);
        }

        Cache::put('scan_result', [
            'status' => 'success',
            'student' => [
                'full_name' => $studentData->data['full_name'],
                'image_url' => $studentData->data['image']
            ]
        ], now()->addSeconds(2));

        return response()->json([
            'status' => 'success'
        ], 200);
    }
}
