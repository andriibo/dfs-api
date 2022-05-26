<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="LoginRequest",
 *    required=true,
 *    @OA\JsonContent(required={"email","password"},
 *       @OA\Property(property="email", type="string", maxLength=50, example="john@gmail.com"),
 *       @OA\Property(property="password", type="string", minLength=6, example="password"),
 *       @OA\Property(property="rememberMe", type="bool", example="false")
 *    )
 * )
 */
class LoginRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'rememberMe' => 'boolean',
        ];
    }
}
