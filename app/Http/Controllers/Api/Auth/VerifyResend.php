<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyResendRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/email/verify/resend",
 *     summary="Verify Resend",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmil.com")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="Verification link sent")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Invalid signature.")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="false"),
 *             @OA\Property(property="error", type="string", example="Your email address was not found")
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
class VerifyResend extends Controller
{
    public function __invoke(VerifyResendRequest $verifyResendRequest): JsonResponse
    {
        $user = User::where('email', $verifyResendRequest->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => 'Your email address was not found.'],
            ], Response::HTTP_NOT_FOUND);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Verification link sent.',
        ]);
    }
}
