<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

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
