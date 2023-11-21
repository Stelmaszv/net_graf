<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductGet extends AbstractAction{
    public function action()
    {
       return json_encode($this->engin->getQueryLoop("SELECT id,name From `product` WHERE id = $this->id;")[0]);
    }
}