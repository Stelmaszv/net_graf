<?php

namespace App\Validators;

class RequiredValidator extends AbstractValidate
{
    public function validate(): ?string
    {
        if ($this->value === null || empty($this->value)) {
            return 'This value must not be empty or null';
        }

        return null;
    }
}