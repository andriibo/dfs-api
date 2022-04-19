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
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
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
 *     @OA\Response(response=400, ref="#/components/responses/400"),
 *     @OA\Response(response=403, ref="#/components/responses/403"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
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
                    return response()->json(['message' => 'A reset email has been sent! Please check your email.']);

                case Password::INVALID_USER:
                    return response()->json(['message' => 'Your email address was not found.'], Response::HTTP_NOT_FOUND);

                default: return response()->json(['message' => trans($response)], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
