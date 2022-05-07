<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

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
