<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentQrTokenController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('userstore',[LoginController::class, 'store']);
Route::get('/show', [LoginController::class, 'index']);


Route::post('/fetch-student-data', [StudentQrTokenController::class, 'fetchStudentData']);
Route::get('/students', [StudentQrTokenController::class, 'fetchStudents']);