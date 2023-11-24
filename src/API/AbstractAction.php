<?php

namespace App\Api;

use Exception;
use App\DB\DBInterface;
use App\Validators\Validators;

abstract class AbstractAction
{
    protected DBInterface $engine;
    protected ?int $id;
    protected ?string $method;
    protected ?array $data;
    protected array $errors = [];

    public function __construct(DBInterface $engine, int $id = null, array $data = null)
    {
        $this->engine = $engine;
        $this->id = intval($id);
        $this->data = $data;

        if ($this->method === "POST"  ) {
            $this->fieldValidation($data);
        }

        if ($_SERVER['REQUEST_METHOD'] !== $this->method) {
            throw new Exception('Invalid HTTP method!');
        }
    }

    private function validate(): void
    {
        foreach ($this->setValidationRules() as $key => $rule) {
            $fieldValidators = explode(' | ', $rule);
            foreach ($fieldValidators as $validator) {
                $validator = Validators::getValidator($validator);

                $validator->setValue($this->data[$key]);
                $validatorMessage = $validator->validate();

                if ($validatorMessage) {
                    $this->errors[] = [
                        "Column" => $key,
                        "message" => $validatorMessage,
                    ];
                }
            }
        }
    }

    protected function setValidationRules(): array
    {
        return [];
    }

    protected function getColumns()
    {
        return array_map(function (array $element) {
            return $element['column_name'];
        }, $this->engine->getQueryLoop("SELECT column_name FROM information_schema.columns WHERE table_name = 'pets';"));
    }

    private function fieldValidation(array $data)
    {
        foreach (array_keys($data) as $column) {
            if (!in_array($column, $this->getColumns())) {
                $this->errors[] = [
                    "Column" => $column,
                    "message" => "Column '$column' does not exist!",
                ];
            }
        }

        return $this->errors;
    }

    public function getAction()
    {
        $this->validate();

        if (count($this->errors) > 0) {
            return json_encode($this->errors);
        }

        return $this->action();
    }

    abstract public function action();
}
