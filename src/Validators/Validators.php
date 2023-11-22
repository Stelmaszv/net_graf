<?php

namespace App\Validators;

class Validators
{
    public static function getValidator(string $validator): AbstractValidate
    {
        return self::getValidators()[$validator];
    }

    private static function getValidators(): array
    {
        return [
            'Required' => new RequiredValidator(),
            'Email' => new EmailValidator(),
        ];
    }
}