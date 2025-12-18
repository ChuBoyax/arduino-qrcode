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
            
            $token = User::findOrFail(1)->remember_token;
            if(!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token not found.'
                ], 404);
            }

            $response = Http::withHeaders([
                'Accept': 'application/json',
            ])
    
            return response()->json([
                'status' => 'success',
                'qr_data' => $qrData
            ], 200);
        }catch(Exception $e) {
            return response()->json([
                'status' => 'erorr',
                'message' => $e->getMessage();
            ], 500);
        }
    }

}
