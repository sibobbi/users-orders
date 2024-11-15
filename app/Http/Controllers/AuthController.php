<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse|array
    {
        $credentials = $request->validated();
        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api');

        return ['token' => $token->plainTextToken];
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->status(200);
    }
}
