<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Register method
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->validated());
        return response()->json($response, $response['status_code']);
    }

    // Login method
    public function login(LoginRequest $request)
    {
        // Validate the request data
        $credentials  = $request->validated();

        $response = $this->authService->login($credentials);

        return response()->json($response, $response['status_code']);
    }

    // Get the authenticated user's details
    public function me()
    {
        $response = $this->authService->me();
        return response()->json($response, $response['status_code'] ?? 200);
    }

    // Logout method
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['success' => true, 'message' => 'Successfully logged out']);
    }
}
