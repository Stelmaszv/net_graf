<?php

namespace App\Api;

class ProductsList extends AbstractAction
{
    protected ?string $method = 'GET';

    public function action()
    {
        $query = $this->engin->getQueryLoop("SELECT id, name, contact FROM `pets`;");
        return json_encode($query);
    }
}