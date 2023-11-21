<?php

namespace App\DB;

use App\DB\Engines\PDOEngine;
use App\DB\Engines\MysqliEngine;
use App\Infrastructure\DB\DBException;

class Connect
{
    private ?DBInterface $engine;
    private array $engines = ['PDO', 'MYSQLI'];

    private function __construct()
    {
        $this->engine = $this->setEngine();
    }

    private function setEngine(): ?DBInterface
    {
        if (!in_array(DBSettings::ENGINE, $this->engines)) {
            throw new DBException('Invalid Engine!');
        }

        switch(DBSettings::ENGINE) {
            case 'PDO':
                return new PDOEngine();
            case 'MYSQLI':
                return new MysqliEngine();
        }

        return null;
    }

    public function getEngine(): ?DBInterface
    {
        return $this->engine;
    }

    public static function getInstance(): self
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }

        return $instance;
    }
}