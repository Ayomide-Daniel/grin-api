<?php

namespace App\Http\Controllers;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(
        private readonly AuthenticationService $authenticationService,
    ) {
    }

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["name", "email", "gender", "country", "password"]);

        $auth = $this->authenticationService->register(
            new RegisterDto(
                $validated['name'],
                $validated['email'],
                $validated['gender'],
                $validated['country'],
                $validated['password']
            )
        );

        return response()->json([
            'message' => 'Registration was successful',
            'data' => $auth
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["email", "password"]);

        $auth = $this->authenticationService->login(
            new LoginDto(
                $validated['email'],
                $validated['password']
            )
        );

        return response()->json([
            'message' => 'Login was successful',
            'data' => $auth
        ], 200);
    }

    /**
     * Register a new admin
     */
    public function adminRegister(RegisterRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["name", "email", "gender", "country", "password"]);

        $auth = $this->authenticationService->adminRegister(
            new RegisterDto(
                $validated['name'],
                $validated['email'],
                $validated['gender'],
                $validated['country'],
                $validated['password']
            )
        );

        return response()->json([
            'message' => 'Registration was successful',
            'data' => $auth
        ], 201);
    }

    /**
     * Logout a user
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authenticationService->logout($request->user());

        return response()->json([
            'message' => 'Logout was successful',
        ], 200);
    }

    /**
     * Reset a user's password
     */
    public function requestPasswordReset(PasswordResetRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["email"]);

        $this->authenticationService->requestPasswordReset($validated["email"]);

        return response()->json([
            'message' => 'An email has been sent to your email address containing a link to reset your password',
        ], 200);
    }
}
