<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="ResetPasswordRequest",
 *    required=true,
 *    @OA\JsonContent(required={"password","passwordConfirmation"},
 *        @OA\Property(property="password", type="string", maxLength=50, example="password2"),
 *        @OA\Property(property="passwordConfirmation", type="string", maxLength=50, example="password2")
 *    )
 * )
 */
class ResetPasswordRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email|max:50',
            'password' => 'required|confirmed|min:6',
            'passwordConfirmation' => 'required',
        ];
    }
}
