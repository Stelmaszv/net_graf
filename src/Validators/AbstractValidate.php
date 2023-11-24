<?php

namespace App\Validators;

abstract class AbstractValidate
{
    protected mixed $value = null;

    public function setValue(mixed $value)
    {
        $this->value = $value;
    }

    abstract public function validate(): ?string;
}
