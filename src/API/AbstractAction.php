<?php

namespace App\Api;

use Exception;
use App\DB\DBInterface;
use App\Validators\Validator;

abstract class AbstractAction
{
    protected DBInterface $engine;
    protected ?int $id;
    protected ?string $method;
    protected ?array $data;
    private Validator $validator;

    public function __construct(DBInterface $engine, int $id = null, array $data = [])
    {

        $this->validator = new Validator($data);
        $this->engine = $engine;
        $this->id = intval($id);
        $this->data = $data;

        if ($this->method === "POST"  ) {
            $this->validator->fieldValidation($this->getColumns());
        }

        if ($_SERVER['REQUEST_METHOD'] !== $this->method) {
            throw new Exception('Invalid HTTP method!');
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

    public function getAction()
    {
        $this->validator->validate($this->setValidationRules());

        if (count($this->validator->getErrors()) > 0) {
            return json_encode($this->validator->getErrors());
        }

        return $this->action();
    }

    abstract public function action();
}
