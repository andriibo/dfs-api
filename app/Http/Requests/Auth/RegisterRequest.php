<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|between:2,50',
            'fullname' => 'required|string|between:2,50',
            'email' => 'required|email|unique:user|max:50',
            'password' => 'required|confirmed|string|min:6',
        ];
    }
}
