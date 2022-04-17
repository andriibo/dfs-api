<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/forgot/password",
 *     summary="Forgot Password",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/json")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email"},
 *             @OA\Property(property="email", type="string", maxLength=50)
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
 *             @OA\Property(property="message", type="string", example="Unprocessable entity"),
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
class ForgotPassword extends Controller
{
    public function __invoke(ForgotPasswordRequest $recoverPasswordRequest): JsonResponse
    {
        try {
            $response = Password::sendResetLink($recoverPasswordRequest->only('email'));

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json([
                        'success' => true,
                        'message' => 'A reset email has been sent! Please check your email.',
                    ]);

                case Password::INVALID_USER:
                    return response()->json([
                        'success' => false,
                        'message' => 'Your email address was not found.',
                    ], Response::HTTP_NOT_FOUND);

                default: return response()->json([
                    'success' => false,
                    'message' => trans($response),
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
