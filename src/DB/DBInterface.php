<?php

namespace App\DB;

interface DBInterface
{
    function getQueryLoop(string $sql,$array=[]) : array;
    function runQuery(string $sql,string $message,$array=[]) : string;
}