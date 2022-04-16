<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/login",
 *     summary="Login",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/json")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email","password"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmil.com"),
 *             @OA\Property(property="password", type="string", minLength=6, example="password")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="access_token", type="string"),
 *                 @OA\Property(property="token_type", type="string", example="bearer"),
 *                 @OA\Property(property="expires_in", type="integer", example="3600")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=401, description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="false"),
 *             @OA\Property(property="error", type="string", example="Unauthorized")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="false"),
 *             @OA\Property(property="error", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Resource not found")
 *         )
 *     ),
 *     @OA\Response(response=422, description="Unprocessable entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unprocessable entity")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Internal Server Error")
 *         )
 *     )
 * )
 */
class Login extends Controller
{
    public function __invoke(LoginRequest $authLoginRequest, AuthService $authService): JsonResponse
    {
        if (!$token = auth()->attempt($authLoginRequest->validated())) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'error' => 'Please verify your email address before logging in. You may request a new link here [xyz.com] if your verification has expired.',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'success' => true,
            'data' => $authService->createNewToken($token),
        ]);
    }
}
