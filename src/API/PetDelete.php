<?php

namespace App\Api;

class PetDelete extends AbstractAction
{
    protected ?string $method = "GET";

    public function action()
    {
        $query = sprintf("DELETE FROM pets WHERE `pets`.`id` = %s", $this->id);
        return $this->engine->runQuery($query, '');
    }
}
