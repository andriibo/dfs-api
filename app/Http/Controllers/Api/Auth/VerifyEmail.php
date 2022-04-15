<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Get(
 *     path="/auth/email/verify/{id}/{hash}",
 *     summary="Verify Email",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *        name="id",
 *        required=true,
 *        in="path",
 *        @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *        name="hash",
 *        required=true,
 *        in="path",
 *        @OA\Schema(type="string")
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="Account verified.")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="false"),
 *             @OA\Property(property="error", type="string", example="Your email address was not found")
 *         )
 *     ),
 *     @OA\Response(response=422, description="Unprocessable entity",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Unprocessable entity")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Internal Server Error")
 *         )
 *     )
 * )
 */
class VerifyEmail extends Controller
{
    public function __invoke(int $userId): JsonResponse
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => 'Your email address was not found.'],
            ], Response::HTTP_NOT_FOUND);
        }

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
