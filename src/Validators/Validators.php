<?php

namespace App\Validators;

class Validators
{
    public static function getValidator(string $validator): AbstractValidate
    {
        $validators = self::getValidators();
        $formattedValidator = ucfirst($validator);
    
        if (isset($validators[$formattedValidator])) {
            return $validators[$formattedValidator];
        }

        return null;
   }

    private static function getValidators(): array
    {
        return [
            'Required' => new RequiredValidator(),
            'Email' => new EmailValidator(),
        ];
    }
}