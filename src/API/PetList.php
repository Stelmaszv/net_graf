<?php

namespace App\Api;

class PetList extends AbstractAction
{
    protected ?string $method = 'GET';

    public function action()
    {
        $query = $this->engine->getQueryLoop("SELECT id, name, contact FROM `pets`;");
        return json_encode($query);
    }
}