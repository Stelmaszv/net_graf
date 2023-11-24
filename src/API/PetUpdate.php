<?php

namespace App\Api;

use Exception;

class PetUpdate extends AbstractAction
{
    protected ?string $method = 'POST';

    public function action()
    {
        if($this->id === null){
            throw new Exception('Id is not defined!');
        }

        $this->engine->runQuery($this->buildUpdateQuery());
        return json_encode(['Success']);
    }

    protected function setValidationRules(): array
    {
        return [
            "name" => 'Required',
            "contact" => 'Required | Email',
        ];
    }

    private function buildUpdateQuery(): string
    {
        $sql = 'UPDATE `pets` SET';

        $setValues = [];
        foreach ($this->data as $key => $value) {
            $setValues[] = '`' . $key . '` = "' . $this->engine->escapeString($value) . '"';
        }

        $sql .= implode(', ', $setValues);
        $sql .= ' WHERE `id` = ' . intval($this->id);

        return $sql;
    }
}