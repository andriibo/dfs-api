<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractFormRequest;

class VerifyResendRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:50',
        ];
    }
}
