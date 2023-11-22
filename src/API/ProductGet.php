<?php

namespace App\Api;

use Exception;

class ProductGet extends AbstractAction
{
    protected ?string $method = 'GET';

    public function action()
    {
        $query = $this->engin->getQueryLoop("SELECT name, contact FROM `pets` WHERE id = $this->id;");
        
        if (!empty($query)) {
            return json_encode($query[0]);
        }

        throw new Exception('Not Found');
    }
}