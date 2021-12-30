<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'status' => 401,
                'message' => "Credentials Do not Match",
            ]);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json([
            'status' => True,
            'message' => $user,
            'token'     =>  $token,
        ]);
    }

    public function checkUser()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        $logout = Auth::user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => "Logout Succesfull",
        ]);
    }
}
