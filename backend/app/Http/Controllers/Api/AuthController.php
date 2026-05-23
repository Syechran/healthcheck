<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new account and return a JWT.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->safe()->only(['name', 'email', 'password']));

        $token = auth('api')->login($user);

        return $this->respondWithToken($token, $user, Response::HTTP_CREATED);
    }

    /**
     * Verify credentials and return a JWT.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);

        if ($token === false) {
            throw ValidationException::withMessages([
                'email' => ['Email atau kata sandi salah.'],
            ]);
        }

        return $this->respondWithToken($token, auth('api')->user());
    }

    /**
     * Invalidate the current JWT.
     */
    public function logout(): Response
    {
        auth('api')->logout();

        return response()->noContent();
    }

    /**
     * Exchange the current (still-valid) JWT for a fresh one.
     */
    public function refresh(): JsonResponse
    {
        $token = auth('api')->refresh();

        return $this->respondWithToken($token, auth('api')->user());
    }

    /**
     * The authenticated user plus the profile stats shown on the Profil screen.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        $monthsActive = (int) floor($user->created_at->diffInMonths(now())) + 1;

        return response()->json([
            'user' => new UserResource($user),
            'stats' => [
                'detections' => $user->detections()->count(),
                'months_active' => max(1, $monthsActive),
                'consultations' => 0,
            ],
        ]);
    }

    /**
     * Standard token envelope returned by register / login / refresh.
     */
    protected function respondWithToken(string $token, User $user, int $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60, // seconds
        ], $status);
    }
}
