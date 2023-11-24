<?php

namespace App\Api;

use Exception;

class PetAdd extends AbstractAction
{
    protected ?string $method = 'POST';

    public function action()
    {
        $this->engine->runQuery($this->buildInsertQuery(), '');
        return json_encode(['Success']);
    }

    protected function setValidationRules(): array
    {
        return [
            "name" => 'Required',
            "contact" => 'Required | Email',
        ];
    }

    private function buildInsertQuery(): string
    {
        $columns = array_keys($this->data);
        $values = array_map(function ($value) {
            return "'$value'";
        }, $this->data);

        return sprintf(
            'INSERT INTO `%s` (%s) VALUES (%s);',
            'pets',
            implode(', ', $columns),
            implode(', ', $values)
        );
    }
}