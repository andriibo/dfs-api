<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResendRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/auth/email/verify/resend",
 *     summary="Verify Resend",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmil.com")
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
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class VerifyResend extends Controller
{
    public function __invoke(VerifyResendRequest $verifyResendRequest, UserService $userService): JsonResponse
    {
        $user = $userService->getUserByEmail($verifyResendRequest->email);
        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification link sent.']);
    }
}
