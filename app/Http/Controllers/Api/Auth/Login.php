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
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
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
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
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
