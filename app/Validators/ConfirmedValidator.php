<?php

namespace App\Validators;

use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\Validator;

class ConfirmedValidator extends Validator
{
    use ValidatesAttributes;

    public function validateConfirmed($attribute, $value): bool
    {
        return $this->validateSame($attribute, $value, [$attribute . 'Confirmation']);
    }
}
