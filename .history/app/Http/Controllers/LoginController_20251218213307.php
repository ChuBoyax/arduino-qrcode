<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Exception;

class LoginController extends Controller
{
    public function index()
        {
            try {
                return response()->json(Student::all(), 200);
            } catch (Exception $e) {
                return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
        }
    public function login(Request $request)
    {
        try {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $user = Auth::user();
                $token = $user->createToken('Mytoken')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'role' => $user->role,
                ], 200);
            }
            return response()->json([
                'message' => 'Invalid email and password',
            ], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
    public function store(Request $request){
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

}
