<?php

use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\OrderFunctions\Order;
use CRDV\Model\OrderFunctions\OrderCrudMySql;

header ( "Content-type: application/json" );


require_once(dirname(__DIR__,2).'/vendor/autoload.php');

$reqParams = array("success", "products", "receiver", "address", "payment");

foreach($reqParams as $param){
    if(!isset($_POST[$param]) && empty($_POST[$param])){
        die(json_encode(array(
            "error" => "Parâmetro $param não informado"
        )));
    }
}

$result = ($_POST["success"] === "true") ? true : false;

if(!$result){
    die(json_encode(array("error" => "Callback when true, is false.")));
}

$con = new MySQLConnection();
$orders = new OrderCrudMySql($con->connect());

$order = new Order();
$order->receiver = $_POST["receiver"];
$order->address = $_POST["address"];
$order->products = $_POST["products"];
$order->success = $_POST["success"];
$order->payment = $_POST["payment"];

$result = $orders->newOrder($order);

echo json_encode($result);