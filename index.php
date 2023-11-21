<?php
use App\DB\Connect;
use App\Api\ProductAdd;
use App\Api\ProductGet;
use App\Api\ProductsList;
use App\Api\ProductDelete;
require('vendor/autoload.php');

$connect = Connect::getInstance();
$engine = $connect->getEngine();

$view = null;

$POST = [
    'name' => 'fewff',
    'quantity' => 'dwqd@fqef.com',
    'type' => 'dwqd'
];

if(isset($_GET['action'])){
    switch ($_GET['action']) {
        case "list":
            $view = new ProductsList($engine);
            break;
        case "get":
            $view = new ProductGet($engine,$_GET['id']);
            break;
        case "delete":
            $view = new ProductDelete($engine,$_GET['id']);
            break;
        case "add":
            $view = new ProductAdd($engine,null,$POST);
            break;
        default:
            echo "Invalid action.";
    }

    echo $view->getAction();
}
