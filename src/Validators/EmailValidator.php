<?php

namespace App\Validators;

class EmailValidator extends AbstractValidate
{
    public function validate(): ?string
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            return 'This value is not an email!';
        }

        return null;
    }
}