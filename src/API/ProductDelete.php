<?php

namespace App\Api;

use App\Api\AbstractAction;

class ProductDelete extends AbstractAction{

    protected ?string $method = "DELETE";

    public function action()
    {
        return $this->engin->runQuery("DELETE FROM product WHERE `product`.`id` = $this->id",'');
    }
}