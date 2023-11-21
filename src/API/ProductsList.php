<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductsList extends AbstractAction{
    public function action()
    {
       return json_encode($this->engin->getQueryLoop("SELECT id,name From `product`;"));
    }
}