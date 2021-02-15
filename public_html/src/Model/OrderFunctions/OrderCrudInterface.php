<?php

namespace CRDV\Model\OrderFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use \PDO;

interface OrderCrudInterface {
    public function __construct(PDO $pdo);
    public function newOrder(Order $order);
    public function editOrder(Order $order);
    public function delOrder(Int $orderID);
    public function selectAllOrders();
    public function selectOrder(Int $orderID);
}