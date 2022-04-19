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
 *         @OA\Schema(type="string", example="application/vnd.api+json")
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
 *                 @OA\Property(property="accessToken", type="string"),
 *                 @OA\Property(property="tokenType", type="string", example="bearer"),
 *                 @OA\Property(property="expiresIn", type="integer", example="3600")
 *             )
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
 *     @OA\Response(response=405, description="Method Not Allowed",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The current method is not supported for this route. Supported methods: POST.")
 *         )
 *     ),
 *     @OA\Response(response=422, description="Unprocessable entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="Server Error")
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
