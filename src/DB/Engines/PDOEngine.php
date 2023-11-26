<?php

namespace App\DB\Engines;


use PDO;
use PDOException;
use App\DB\DBSettings;
use App\DB\DBException;
use App\DB\DBInterface;

class PDOEngine implements DBInterface
{
    private PDO $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DBSettings::HOST . ";dbname=" . DBSettings::DBNAME,
                DBSettings::USERNAME,
                DBSettings::PASSWORD
            );

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw new DBException($exception->getMessage());
        }
    }

    public function getQueryLoop(string $sql, $array = []): array
    {
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute($array);

            $records = [];
            while ($row = $query->fetch()) {
                $records[] = $row;
            }

            return $records;
        } catch (PDOException $exception) {
            throw new DBException($exception->getMessage());
        }
    }

    public function runQuery(string $sql, string $message, $array = []): string
    {
        try {
            $query = $this->pdo->prepare($sql);
            $success = $query->execute($array);

            if ($success) {
                return $message;
            }
        } catch (PDOException $exception) {
            throw new DBException($exception->getMessage());
        }

        return '';
    }
}