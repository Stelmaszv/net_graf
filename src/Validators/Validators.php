<?php

namespace App\Validators;

use App\Validators\EmailValidator;
use App\Validators\AbstractValidate;
use App\Validators\RequiredValidator;

class Validators{

    public static function getValidator(string $validator) : AbstractValidate
    {
        return self::getValidators()[$validator];
    }

    private static function getValidators() : array
    {
        return [
            'Required' => new RequiredValidator(),
            'Email' => new EmailValidator() 
        ];
    }

}