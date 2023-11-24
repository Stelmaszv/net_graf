<?php
namespace App\Validators;

class Validator{

    public array $data = [];
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data; 
    }

    public function validate(array $setValidationRules): void
    {
        foreach ($setValidationRules as $key => $rule) {
            $this->validateField($key, $rule);
        }
    }

    public function fieldValidation(array $columns)
    {
        foreach (array_keys($this->data) as $column) {
            if (!in_array($column, $columns)) {
                $this->errors[] = [
                    "Column" => $column,
                    "message" => "Column '$column' does not exist!",
                ];
            }
        }

        return $this->errors;
    }

    public function getErrors() :array {
        return $this->errors;
    }
    
    private function validateField(string $key, string $rule): void
    {
        $fieldValidators = explode(' | ', $rule);
    
        foreach ($fieldValidators as $validatorName) {
            $validator = Validators::getValidator($validatorName);

            if ($this->isFieldValueSet($key)) {
                $validator->setValue($this->data[$key]);
            }
    
            $validatorMessage = $validator->validate();
    
            if ($validatorMessage) {
                $this->addError($key, $validatorMessage);
            }
        }
    }
    
    private function isFieldValueSet(string $key): bool
    {
        return isset($this->data[$key]);
    }
    
    private function addError(string $key, string $message): void
    {
        $this->errors[] = [
            "Column" => $key,
            "message" => $message,
        ];
    }
}