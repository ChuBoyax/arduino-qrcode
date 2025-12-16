<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\StudentQrTokenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/fetch-student-data', [StudentQrTokenController::class, 'fetchStudentData']);
Route::get('/scan-result', function() {
    return Cache::get('scan_result');
});