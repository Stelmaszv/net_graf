<?php

namespace App\Validators;

class RequiredValidator extends AbstractValidate{
    function validate() : ?string
    {
        if ($this->value === null || empty($this->value)){
            return 'This value must conot be empty or null';
        }

        return null;
    }
}