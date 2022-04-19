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
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\RequestBody(
 *         @OA\JsonContent(required={"email","password","password_confirmation","username","fullname"},
 *             @OA\Property(property="email", type="string", maxLength=50, example="john@gmil.com"),
 *             @OA\Property(property="password", type="string", minLength=6, example="password"),
 *             @OA\Property(property="password_confirmation", type="string", example="password"),
 *             @OA\Property(property="username", type="string", minLength=2, maxLength=50, example="john"),
 *             @OA\Property(property="fullname", type="string", minLength=2, maxLength=50, example="John Doe")
 *         ),
 *     ),
 *     @OA\Response(response=201, ref="#/components/responses/201"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
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

        return response()->json(['message' => 'Thanks for signing up! Please check your email to complete your registration.'], Response::HTTP_CREATED);
    }
}
