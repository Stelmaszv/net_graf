<?php

namespace App\Api;

use App\DB\DBInterface;

abstract class AbstractAction{

    protected DBInterface $engin;
    protected ?int $id;

    function __construct(DBInterface $engin,int $id = null)
    {
        $this->engin = $engin;
        $this->id = intval($id);
    }

    abstract public function action();
}