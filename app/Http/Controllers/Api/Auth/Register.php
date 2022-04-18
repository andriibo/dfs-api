<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register User",
 *     tags={"Auth"},
 *     @OA\Parameter(
 *         name="Accept",
 *         in="header",
 *         description="Accept header",
 *         @OA\Schema(type="string", example="application/vnd.api+json")
 *     ),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email","password","password_confirmation","username","fullname"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmil.com"),
 *             @OA\Property(property="password", type="string", minLength=6, example="password"),
 *             @OA\Property(property="password_confirmation", type="string", example="password"),
 *             @OA\Property(property="username", type="string", minLength=2, maxLength=50, example="john"),
 *             @OA\Property(property="fullname", type="string", minLength=2, maxLength=50, example="John Doe")
 *         ),
 *     ),
 *     @OA\Response(response=201, description="Created",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="bool", example="true"),
 *             @OA\Property(property="message", type="string", example="Thanks for signing up! Please check your email to complete your registration.")
 *         )
 *     ),
 *     @OA\Response(response=403, description="Forbidden",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
 *         )
 *     ),
 *     @OA\Response(response=404, description="Resource not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string")
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
 *            @OA\Property(property="error", type="string")
 *         )
 *     )
 * )
 */
class Register extends Controller
{
    public function __invoke(RegisterRequest $authRegisterRequest): JsonResponse
    {
        $user = User::create(array_merge(
            $authRegisterRequest->validated(),
            ['password' => bcrypt($authRegisterRequest->password)]
        ));

        event(new Registered($user));

        return response()->json([
            'success' => true,
            'message' => 'Thanks for signing up! Please check your email to complete your registration.',
        ], Response::HTTP_CREATED);
    }
}
