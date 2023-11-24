<?php

namespace App\Api;

use Exception;

class PetDelete extends AbstractAction
{
    protected ?string $method = "GET";

    public function action()
    {
        if($this->id === null){
            throw new Exception('Id is not defined!');
        }

        $query = sprintf("DELETE FROM pets WHERE `pets`.`id` = %s", $this->id);
        return $this->engine->runQuery($query, '');
    }
}
