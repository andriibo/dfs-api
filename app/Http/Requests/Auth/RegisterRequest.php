<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="RegisterRequest",
 *    required=true,
 *    @OA\JsonContent(required={"email","password","passwordConfirmation","username","fullname","dob"},
 *        @OA\Property(property="email", type="string", maxLength=50, example="john@gmail.com"),
 *        @OA\Property(property="password", type="string", minLength=6, example="password"),
 *        @OA\Property(property="passwordConfirmation", type="string", example="password"),
 *        @OA\Property(property="username", type="string", minLength=2, maxLength=50, example="john"),
 *        @OA\Property(property="fullname", type="string", minLength=2, maxLength=50, example="John Doe"),
 *        @OA\Property(property="dob", type="string", format="date", example="1993-03-27")
 *    )
 * )
 */
class RegisterRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:user|between:2,50',
            'fullname' => 'required|string|between:2,50',
            'email' => 'required|email|unique:user|max:50',
            'password' => 'required|confirmed|string|min:6',
            'passwordConfirmation' => 'required',
            'dob' => 'required|date_format:Y-m-d',
        ];
    }
}
