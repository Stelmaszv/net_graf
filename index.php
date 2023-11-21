<?php
use App\DB\Connect;
use App\Api\ProductsList;
require('vendor/autoload.php');

$connect = Connect::getInstance();
$engine = $connect->getEngine();

$view = null;

switch ($_GET['action']) {
    case "list":
        $view = new ProductsList($engine);
        break;
    default:
        echo "Invalid action.";
}

echo $view->action();