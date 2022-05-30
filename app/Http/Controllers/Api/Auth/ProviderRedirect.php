<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

/**
 * @OA\Get(
 *     path="/auth/{provider}/redirect",
 *     summary="Redirect to Provider",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/provider"),
 *     @OA\Response(response=200, description="Ok"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class ProviderRedirect extends Controller
{
    public function __invoke(string $provider): JsonResponse
    {
        $targetUrl = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json(['data' => ['targetUrl' => $targetUrl]]);
    }
}
