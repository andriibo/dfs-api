<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

abstract class AbstractFormRequest extends FormRequest
{
    abstract public function rules(): array;

    /**
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $formattedErrors = $this->transformErrors($errors);
        $response = new JsonResponse(['errors' => $formattedErrors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);

        throw new ValidationException($validator, $response);
    }

    private function transformErrors(MessageBag $errors): array
    {
        $transformed = [];

        foreach ($errors->messages() as $field => $messages) {
            $transformed[] = [
                'field' => $field,
                'messages' => $messages,
            ];
        }

        return $transformed;
    }
}
