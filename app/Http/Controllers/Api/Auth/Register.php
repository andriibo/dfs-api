<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Post(
 *     path="/auth/register",
 *     summary="Register User",
 *     tags={"Auth"},
 *     @OA\Parameter(ref="#/components/parameters/Accept"),
 *     @OA\Parameter(ref="#/components/parameters/Content-Type"),
 *     @OA\RequestBody(ref="#/components/requestBodies/RegisterRequest"),
 *     @OA\Response(response=201, ref="#/components/responses/201"),
 *     @OA\Response(response=404, ref="#/components/responses/404"),
 *     @OA\Response(response=405, ref="#/components/responses/405"),
 *     @OA\Response(response=422, ref="#/components/responses/422"),
 *     @OA\Response(response=500, ref="#/components/responses/500")
 * )
 */
class Register extends Controller
{
    public function __invoke(RegisterRequest $authRegisterRequest): JsonResponse
    {
        $user = User::create(array_merge(
            $authRegisterRequest->validated(),
            ['password' => Hash::make($authRegisterRequest->password)]
        ));

        event(new Registered($user));

        return response()->json(['message' => 'Thanks for signing up! Please check your email to complete your registration.'], Response::HTTP_CREATED);
    }
}
