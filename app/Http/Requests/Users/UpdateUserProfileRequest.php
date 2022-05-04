<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

class UpdateUserProfileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:user,' . $this->id . ',id|max:50',
            'username' => 'required|string|unique:user,' . $this->id . ',id|between:2,50',
            'dob' => 'required|date',
            'fullname' => 'required|string|between:2,50',
        ];
    }
}
