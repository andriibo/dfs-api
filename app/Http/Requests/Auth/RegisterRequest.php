<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

class RegisterRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:user|between:2,50',
            'fullname' => 'required|string|between:2,50',
            'email' => 'required|email|unique:user|max:50',
            'password' => 'required|confirmed|string|min:6',
        ];
    }
}
