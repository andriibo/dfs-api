<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/auth/email/verify/{id}/{hash}",
 *     summary="Verify Email",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Parameter(ref="#/components/parameters/hash"),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="Account verified.")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class VerifyEmail extends Controller
{
    public function __invoke(int $userId, UserService $userService): JsonResponse
    {
        $user = $userService->getUserById($userId);

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => true,
                'message' => 'Account already verified.',
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json([
            'success' => true,
            'message' => 'You have successfully verified your email address.',
        ]);
    }
}
