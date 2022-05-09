<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

/**
 * @OA\RequestBody(
 *    request="ForgotPasswordRequest",
 *    @OA\JsonContent(required={"email"},
 *        @OA\Property(property="email", type="string", maxLength=50)
 *    )
 * )
 */
class ForgotPasswordRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:50',
        ];
    }
}
