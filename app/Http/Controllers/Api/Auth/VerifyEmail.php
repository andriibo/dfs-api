<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserActivatedEvent;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/auth/email/verify/{id}/{hash}",
 *     summary="Verify Email",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/accept"),
 *     @OA\Parameter(ref="#/components/parameters/сontentType"),
 *     @OA\Parameter(ref="#/components/parameters/id"),
 *     @OA\Parameter(ref="#/components/parameters/hash"),
 *     @OA\Parameter(name="expires", required=true, in="query", @OA\Schema(type="integer"), example="1650560625"),
 *     @OA\Parameter(name="signature", required=true, in="query", @OA\Schema(type="string")),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
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
    public function __invoke(int $userId, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->getUserById($userId);

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Account already verified.']);
        }

        if ($user->markEmailAsVerified()) {
            event(new UserActivatedEvent($user));
        }

        return response()->json(['message' => 'You have successfully verified your email address.']);
    }
}
