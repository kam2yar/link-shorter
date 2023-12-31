<?php

namespace App\Services\Validation;

use Rakit\Validation\Validator;

class FormValidator
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->addValidator('unique', new UniqueRule());
        $this->validator->addValidator('exist', new ExistRule());
    }

    public function validate(array $inputs = [], array $rules = [], array $messages = []): void
    {
        $validation = $this->validator->validate($inputs, $rules, $messages);

        if ($validation->fails()) {
            response()->httpCode(422)->json([
                'success' => false,
                'errors' => $validation->errors()->all()
            ]);
        }
    }
}