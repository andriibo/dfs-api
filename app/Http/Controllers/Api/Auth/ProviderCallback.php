<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\SocialiteService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/auth/{provider}/callback",
 *     summary="OAuth Provider Callback",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/provider"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="data",
 *                 @OA\Property(property="accessToken", type="string"),
 *                 @OA\Property(property="tokenType", type="string", example="bearer"),
 *                 @OA\Property(property="expiresIn", type="integer", example="3600")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class ProviderCallback extends Controller
{
    public function __invoke(
        string $provider,
        SocialiteService $socialiteService,
        AuthService $authService
    ): JsonResponse {
        $token = $socialiteService->handle($provider);

        return response()->json(['data' => $authService->createNewToken($token)]);
    }
}
