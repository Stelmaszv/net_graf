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

    public function __construct(DBInterface $engine, array $get = [], array $post = [])
    {
        $this->validator = new Validator($post);
        $this->engine = $engine;
        $this->id = (isset($get['id'])) ? intval($get['id']) : null;
        $this->data = $post;

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
        if ($this->validator) {
            $this->validateData();
    
            if ($this->hasValidationErrors()) {
                return $this->getJsonErrorResponse();
            }
        }
    
        return $this->executeAction();
    }
    
    private function validateData(): void
    {
        $this->validator->validate($this->setValidationRules());
    }
    
    private function hasValidationErrors(): bool
    {
        return count($this->validator->getErrors()) > 0;
    }
    
    private function getJsonErrorResponse(): string
    {
        return json_encode($this->validator->getErrors());
    }
    
    private function executeAction()
    {
        return $this->action();
    }

    abstract public function action();
}