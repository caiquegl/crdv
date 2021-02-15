<?php

namespace CRDV\Controller\Validations;

use CRDV\Model\OrderFunctions\Order;
use CRDV\Model\OrderFunctions\OrderCrudInterface;

class RequestValidationOrder {
    
    private static array $actionUndefinedErrorMessage = array("error" => "Nenhuma requisição foi informada.");
    private static array $defaultErrorMessage = array("error" => "Não foi possível realizar a requisição.");

    public static function validateParam($action)
    {
        if(isset($action) && !empty($action)): return true;
        else: http_response_code(200); echo json_encode(self::$actionUndefinedErrorMessage);
        endif;
    }

    public function validateAddOrder(OrderCrudInterface $con, $data){
        $order = new Order();
        $order->receiver = \addslashes(\trim($data["receiver"]));
        $order->address = \addslashes(\trim($data["address"]));
        $order->products = \addslashes(\trim($data["products"]));
        $order->payment = \addslashes(\trim($data["payment"]));
        $result = $con->newOrder($order);
        echo \json_encode($result);
    }

    public function validateUpdateOrder(OrderCrudInterface $con, $data){
        $order = new Order();
        $order->id = \addslashes(\trim($data["oId"]));
        $order->receiver = \addslashes(\trim($data["receiver"]));
        $order->address = \addslashes(\trim($data["address"]));
        $order->products = \addslashes(\trim($data["products"]));
        $order->payment = \addslashes(\trim($data["payment"]));
        $result = $con->editOrder($order);
        echo \json_encode($result);
    }

    public function validateRemoveOrder(OrderCrudInterface $con, $id){
        $result = $con->delOrder($id);
        echo \json_encode($result);
    }

    public function validateListAllOrder(OrderCrudInterface $con){
        $result = $con->selectAllOrders();
        echo \json_encode($result);
    }

    public function validateListByIdOrder(OrderCrudInterface $con, $id){
        $result = $con->selectOrder($id);
        echo \json_encode($result);
    }

    public static function getDefaultErrorMessage()
    {
        http_response_code(200);
        return json_encode(self::$defaultErrorMessage);
    }

}