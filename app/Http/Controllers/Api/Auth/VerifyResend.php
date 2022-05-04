<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResendRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/email/verify/resend",
 *     summary="Verify Resend",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmail.com")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Verification link sent")
 *         )
 *     ),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=429, ref="#/components/responses/429"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class VerifyResend extends Controller
{
    public function __invoke(VerifyResendRequest $verifyResendRequest, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->getUserByEmail($verifyResendRequest->email);
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Account already verified.'], Response::HTTP_FORBIDDEN);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => "We just sent you the verification link at your email ({$user->email}) again, please check it."]);
    }
}
