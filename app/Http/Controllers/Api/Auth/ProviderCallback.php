<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

/**
 * @OA\Get(
 *     path="/auth/{provider}/callback",
 *     summary="Google Callback",
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
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class ProviderCallback extends Controller
{
    public function __invoke(string $provider, AuthService $authService): JsonResponse
    {
        $googleUser = Socialite::driver($provider)->stateless()->user();

        $user = User::updateOrCreate([
            'username' => $googleUser->name,
            'email' => $googleUser->email,
        ]);

        $token = auth()->login($user);

        return response()->json(['data' => $authService->createNewToken($token)]);
    }
}
