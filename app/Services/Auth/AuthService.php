<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthService
{
    // Register new user
    public function register(array $data)
    {
        $path = null;

        try {
            DB::beginTransaction();

            // Handle profile photo upload
            if (isset($data['profile_photo'])) {
                $path = $data['profile_photo']->store('profiles', 'public');
            }

            // Create user
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'profile_photo' => $path,
            ]);

            // Commit the transaction
            DB::commit();

            return [
                'success' => true,
                'message' => 'User registered successfully',
                'status_code' => 201,
            ];
        } catch (\Exception $e) {
            // Rollback database changes
            DB::rollback();

            // Delete uploaded file if exists
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return [
                'success' => false,
                'message' => 'User registration failed',
                'error' => $e->getMessage(),
                'status_code' => 500,
            ];
        }
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
