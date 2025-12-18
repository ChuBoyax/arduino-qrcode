<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentQrTokenController extends Controller
{
    public function fetchStudentData(Request $request) {
        $response = Http::withHeaders([
            'Accept' => 'appplication/json'
        ])->get($request);

        if(!$response->success){
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch data from the server.'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => $response->json()
        ]);
    }
}
