<?php

namespace App\Api;

class PetUpdate extends AbstractAction
{
    protected ?string $method = 'POST';

    public function action()
    {
        $this->engin->runQuery($this->buildUpdateQuery(), '');
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
            $setValues[] = '`' . $key . '` = "' . $this->engin->escapeString($value) . '"';
        }

        $sql .= implode(', ', $setValues);
        $sql .= ' WHERE `id` = ' . intval($this->id);

        return $sql;
    }
}