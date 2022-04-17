<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/reset/password",
 *     summary="Reset Password",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\Parameter(
 *        name="token",
 *        required=true,
 *        in="query",
 *        @OA\Schema(type="string")
 *     ),
 *     @OA\Parameter(
 *        name="email",
 *        required=true,
 *        in="query",
 *        @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"password","password_confirmation"},
 *             @OA\Property(property="password", type="string", maxLength=50, example="password2"),
 *             @OA\Property(property="password_confirmation", type="string", maxLength=50, example="password2")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="A reset email has been sent! Please check your email.")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Bad Request",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="false"),
 *             @OA\Property(property="error", type="string")
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
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="errors", type="object")
 *         )
 *     ),
 *     @OA\Response(response=500, description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Internal Server Error")
 *         )
 *     )
 * )
 */
class ResetPassword extends Controller
{
    public function __invoke(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        try {
            $response = Password::reset($resetPasswordRequest->only('email', 'token', 'password', 'password_confirmation'), function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                event(new PasswordReset($user));
            });
            if ($response == Password::PASSWORD_RESET) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password reset successfully.',
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Email could not be sent to this email address.',
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
