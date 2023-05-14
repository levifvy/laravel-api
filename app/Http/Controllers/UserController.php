<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|unique:users,email',
            'nickname' => 'nullable|unique:users,nickname',
        ]);

        $user = new User;
        $user->email = $validatedData['email'];
        $user->nickname = $request->input('nickname', 'Anonymus');
        $user->registration_date = now();
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();
        //$token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'User logged in successfully',
            //'access_token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        //$user->token()->revoke();

        return response()->json([
            'message' => 'User logged out successfully'
        ]);
    }

    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'data' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
