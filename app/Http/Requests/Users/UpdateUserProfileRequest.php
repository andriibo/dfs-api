<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\AbstractFormRequest;

class UpdateUserProfileRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:user,id,' . $this->id . '|max:50',
            'username' => 'required|string|unique:user,id' . $this->id . '|between:2,50',
            'dob' => 'required|date_format:Y-m-d',
            'fullname' => 'required|string|between:2,50',
        ];
    }
}
