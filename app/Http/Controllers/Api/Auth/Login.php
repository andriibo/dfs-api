<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Post(
 *     path="/auth/login",
 *     summary="Login",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(ref="#/components/requestBodies/LoginRequest"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data",
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
        $ttl = config('jwt.ttl');
        if ($authLoginRequest->get('rememberMe', false)) {
            $ttl = config('jwt.remember-ttl');
        }

        if (!$token = auth()->setTTL($ttl)->attempt($authLoginRequest->only(['email', 'password']))) {
            return response()->json(['message' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }

        if (!auth()->user()->hasVerifiedEmail()) {
            return response()->json([
                'error' => 'Please verify your email address before logging in. You may request a new email verify if your verification has expired.',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json(['data' => $authService->createNewToken($token)]);
    }
}
