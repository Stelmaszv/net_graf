<?php

use App\Api\PetAdd;
use App\Api\PetGet;
use App\DB\Connect;
use App\Api\PetList;
use App\Api\PetDelete;
use App\Api\PetUpdate;

require('vendor/autoload.php');

$connect = Connect::getInstance();
$engine = $connect->getEngine();

if (isset($_GET['action'])) {
    $view = null;

    switch ($_GET['action']) {
        case "list":
            $view = new PetList($engine);
            break;
        case "get":
            $view = new PetGet($engine, $_GET);
            break;
        case "delete":
            $view = new PetDelete($engine, $_GET);
            break;
        case "add":
            $view = new PetAdd($engine, null, $_POST);
            break;
        case "update":
            $view = new PetUpdate($engine, $_GET, $_POST);
            break;
        default:
            echo "Invalid action.";
    }

    if ($view) {
        echo $view->getAction();
    }
}