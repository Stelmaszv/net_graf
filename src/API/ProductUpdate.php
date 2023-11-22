<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductUpdate extends AbstractAction{

    protected ?string $method = 'POST';

    public function action()
    {
        $this->engin->runQuery($this->buildUpDateQuery(),'');
        return json_encode(['Succes']);
    }

    protected function setValidationRouls() : array 
    { 
       return [
            "name" => 'Required',
            "contact" => 'Required | Email',
       ];
    }

    private function buildUpDateQuery(): string
    {

        $sql = 'UPDATE `pets` SET';
        
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