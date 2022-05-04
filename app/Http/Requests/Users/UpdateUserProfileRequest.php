<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

class UpdateUserProfileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:user|max:50',
            'username' => 'required|string|unique:user|between:2,50',
            'dob' => 'required|date',
            'fullname' => 'required|string|between:2,50',
        ];
    }
}
