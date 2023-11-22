<?php

namespace App\Api;

use Exception;
use App\Api\AbstractAction;

class ProductGet extends AbstractAction{

    protected ?string $method = 'GET';

    public function action()
    {
        $query = $this->engin->getQueryLoop("SELECT name,quantity From `product` WHERE id = $this->id;");
        
        if(count($query) > 0){
            return json_encode($query[0]);
        }

        throw new Exception('Not Found');
    }
}