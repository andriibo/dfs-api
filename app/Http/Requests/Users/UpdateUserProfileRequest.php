<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="UpdateUserProfileRequest",
 *    required=true,
 *    @OA\JsonContent(required={"email","username","dob","fullname"},
 *       @OA\Property(property="email", type="string", maxLength=50, example="john@gmail.com"),
 *       @OA\Property(property="username", type="string", minLength=6, example="john"),
 *       @OA\Property(property="dob", type="string", format="date", example="1988-07-21"),
 *       @OA\Property(property="fullname", type="string", example="John Doe")
 *    )
 * )
 */
class UpdateUserProfileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:user,id,' . $this->id . '|max:50',
            'username' => 'required|string|unique:user,id' . $this->id . '|between:2,50',
            'dob' => 'required|date_format:Y-m-d|before:-18 years',
            'fullname' => 'required|string|between:2,50',
        ];
    }
}
