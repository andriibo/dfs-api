<?php

namespace App\Factories;

use App\Validators\ConfirmedValidator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class ValidationFactory extends Factory
{
    protected function resolve(array $data, array $rules, array $messages, array $customAttributes): Validator
    {
        if (is_null($this->resolver)) {
            $validator = new ConfirmedValidator($this->translator, $data, $rules, $messages, $customAttributes);
            $validator->setPresenceVerifier(app()['validation.presence']);

            return $validator;
        }

        return call_user_func($this->resolver, $this->translator, $data, $rules, $messages, $customAttributes);
    }
}
