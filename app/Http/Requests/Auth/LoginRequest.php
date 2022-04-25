<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

class LoginRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }
}
