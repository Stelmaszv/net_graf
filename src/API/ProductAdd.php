<?php

namespace App\Api;

use Exception;
use App\Api\AbstractAction;

class ProductAdd extends AbstractAction{

    protected ?string $method = 'POST';

    public function action()
    {
        return $this->engin->runQuery($this->buildInsertQuery(),'');
    }

    protected function setValidationRouls() : array 
    { 
       return [
            "name" => 'Required',
            "quantity" => 'Required | Email',
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
            'product',
            implode(', ', $columns),
            implode(', ', $values)
        );
    }


}