<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    // Register new user
    public function register(array $data)
    {
        if (isset($data['profile_photo'])) {
            $path = $data['profile_photo']->store('profiles', 'public');
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_photo' => $path ?? null,
        ]);

        $token = auth('api')->login($user);
        return [
            'success' => true,
            'message' => 'User registered successfully',
            'status_code' => 200,
            'token' => $token,
            'user' => new UserResource($user),
        ];
    }

    // // Login user
    public function login(array $credentials)
    {
        if (!$token = auth('api')->attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'status_code' => 401,
            ];
        }

        $user = auth('api')->user();
        return [
            'success' => true,
            'message' => 'User logged in successfully',
            'status_code' => 200,
            'token' => $token,
            'user' => new UserResource($user),
        ];

    }

    // Get the authenticated user's details
    public function me()
    {
        $user = auth('api')->user();
        if (!$user) {
            return ['success' => false, 'message' => 'Unauthenticated.', 'status_code' => 401,];
        }

        return new UserResource($user);
    }

}
