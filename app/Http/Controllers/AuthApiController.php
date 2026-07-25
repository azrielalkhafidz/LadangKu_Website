<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    /**
     * POST /api/login
     * Dipakai oleh app mobile Flutter untuk login dan mendapatkan
     * Bearer token (Sanctum), bukan session seperti login web.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah',
            ], 401);
        }

        $token = $user->createToken('ladangku-mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'name'  => $user->name,
                'email' => $user->email,
            ],
        ]);
    }
}