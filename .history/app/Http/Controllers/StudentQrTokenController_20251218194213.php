<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\StudentQrToken;

class StudentQrTokenController extends Controller
{
    public function fetchStudentData(Request $request) {
        $qrData = $request->url; // same key you send from ESP32

        if (!$qrData) {
            return response()->json([
                'status' => 'error',
                'message' => 'No QR data received'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'qr_data' => $qrData
        ], 200);
    }

}
