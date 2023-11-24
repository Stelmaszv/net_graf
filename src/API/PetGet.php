<?php

namespace App\Api;

use Exception;

class PetGet extends AbstractAction
{
    protected ?string $method = 'GET';

    public function action()
    {
        if($this->id === null){
            throw new Exception('Id is not defined!');
        }

        $query = $this->engine->getQueryLoop("SELECT name, contact FROM `pets` WHERE id = $this->id;");
        
        if (!empty($query)) {
            return json_encode($query[0]);
        }

        throw new Exception('Pet Not Found');
    }
}