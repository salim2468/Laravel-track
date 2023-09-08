<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:4'],
        ]);

        $newUser = User::create($validatedData);
        $token = $newUser->createToken("auth_token")->accessToken;

        return response()->json(
            [
                'token' => $token,
                'user' => $newUser,
                'message' => 'User created successfully',
                'status' => 201
            ]
        );
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($validatedData)) {
            return response()->json([
                'message' => 'Invalid Credentials',
                'status' => 401
            ]);
        } else {
            // get authenticated user
            $user = auth()->user();
            if ($user) {
                $token = $user->createToken("auth_token")->accessToken;
                return response()->json(
                    [
                        'token' => $token,
                        'user' => $user,
                        'message' => 'Logined successfully.',
                        'status' => 200
                    ]
                );
            }
        }
    }
}
