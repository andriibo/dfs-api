<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="ChangePasswordRequest",
 *    @OA\JsonContent(required={"currentPassword","password","passwordConfirmation"},
 *       @OA\Property(property="currentPassword", type="string", example="password"),
 *       @OA\Property(property="password", type="string", minLength=6, example="newpassword"),
 *       @OA\Property(property="passwordConfirmation", type="string", example="newpassword")
 *    )
 * )
 */
class ChangePasswordRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'currentPassword' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'passwordConfirmation' => 'required',
        ];
    }
}
