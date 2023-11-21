<?php

namespace App\Validators;

class EmailValidator extends AbstractValidate{
    function validate() : ?string
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return 'This value is not emial !';
        }

        return null;
    }
}