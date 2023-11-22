<?php

use App\DB\Connect;
use App\Api\ProductsList;
use App\Api\ProductAdd;
use App\Api\ProductGet;
use App\Api\ProductDelete;
use App\Api\ProductUpdate;

require('vendor/autoload.php');

$connect = Connect::getInstance();
$engine = $connect->getEngine();

if (isset($_GET['action'])) {
    $view = null;

    switch ($_GET['action']) {
        case "list":
            $view = new ProductsList($engine);
            break;
        case "get":
            $view = new ProductGet($engine, $_GET['id']);
            break;
        case "delete":
            $view = new ProductDelete($engine, $_GET['id']);
            break;
        case "add":
            $view = new ProductAdd($engine, null, $_POST);
            break;
        case "update":
            $view = new ProductUpdate($engine, $_GET['id'], $_POST);
            break;
        default:
            echo "Invalid action.";
    }

    if ($view) {
        echo $view->getAction();
    }
}