<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductUpdate extends AbstractAction{

    protected ?string $method = 'POST';

    public function action()
    {
        return $this->engin->runQuery($this->buildUpDateQuery(),'');
    }

    protected function setValidationRouls() : array 
    { 
       return [
            "name" => 'Required',
            "quantity" => 'Required | Email',
       ];
    }

    private function buildUpDateQuery(): string
    {

        $sql = 'UPDATE `product` SET';
        
        $count = 0;
        foreach($this->data as $key => $value){
            if( $count !== 0 && count($this->data)>0 ){
                $sql.=',';
            }

            $sql.= ' `'.$key .'` = "'.$this->engin->escapeString($value).'"';
            $count++;
        }

        $sql.=' WHERE `id` = '.intval($this->id);

        return $sql;
    }

}