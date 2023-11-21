<?php
use App\DB\Connect;
require('vendor/autoload.php');

$connect = Connect::getInstance();
$engine = $connect->getEngine();
