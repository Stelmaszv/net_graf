<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductsList extends AbstractAction{

    protected ?string $method = 'GET';

    public function action()
    {
       return json_encode($this->engin->getQueryLoop("SELECT id,name,contact From `pets`;"));
    }
}