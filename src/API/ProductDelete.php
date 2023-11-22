<?php

namespace App\Api;

class ProductDelete extends AbstractAction
{
    protected ?string $method = "GET";

    public function action()
    {
        $query = sprintf("DELETE FROM pets WHERE `pets`.`id` = %s", $this->id);
        return $this->engin->runQuery($query, '');
    }
}
