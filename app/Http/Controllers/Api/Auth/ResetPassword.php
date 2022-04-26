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
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\Parameter(name="token", required=true, in="query", @OA\Schema(type="string")),
 *     @OA\Parameter(name="email", required=true, in="query", @OA\Schema(type="string"), example="john@gmail.com"),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"password","passwordConfirmation"},
 *             @OA\Property(property="password", type="string", maxLength=50, example="password2"),
 *             @OA\Property(property="passwordConfirmation", type="string", maxLength=50, example="password2")
 *         ),
 *     ),
 *     @OA\Response(response=200, description="Ok",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="A reset email has been sent! Please check your email.")
 *         )
 *     ),
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=401, ref="#/components/responses/401"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class ResetPassword extends Controller
{
    public function __invoke(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        try {
            $response = Password::reset($resetPasswordRequest->only('email', 'token', 'password', 'passwordConfirmation'), function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                event(new PasswordReset($user));
            });
            if ($response == Password::PASSWORD_RESET) {
                return response()->json(['message' => 'Password reset successfully.']);
            }

            return response()->json(['error' => 'Email could not be sent to this email address.'], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
