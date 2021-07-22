<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('LaravelAuthApp')->accessToken;

        $response = [
            'user' => UserResource::make($user->refresh()),
            'token' => $token,
        ];
        return response($response);
    }

    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'Bad creds'
            ]);
        }

        $token = $user->createToken('LaravelAuthApp')->accessToken;
        $response = [
            'user' => UserResource::make($user),
            'token' => $token,
        ];
        return response($response);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
