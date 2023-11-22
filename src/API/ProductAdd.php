<?php

namespace App\Api;

use Exception;
use App\Api\AbstractAction;

class ProductAdd extends AbstractAction{

    protected ?string $method = 'POST';

    public function action()
    {
        $this->engin->runQuery($this->buildInsertQuery(),'');
        return json_encode(['Succes']);
    }

    protected function setValidationRouls() : array 
    { 
       return [
            "name" => 'Required',
            "contact" => 'Required | Email',
       ];
    }

    private function buildInsertQuery(): string
    {
        $columns = array_map(function($key) {
            return $key;
        }, array_keys($this->data));

        $values = array_map(function($value) {
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