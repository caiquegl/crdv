<?php

namespace CRDV\Model\OrderFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use \PDO;

class OrderCrudMySql implements OrderCrudInterface{

    private PDO $con;

    public function __construct(PDO $driver){
        $this->con = $driver;
    }

    private function execQuery($sql,...$data){
        $stt = $this->con->prepare($sql);
        $stt->execute($data);
        if($stt->rowCount() > 0){
            return $stt;
        }
        return false;
    }

    public function newOrder(Order $order){
        $sql = "INSERT INTO crdv_orders(`receiver`,`address`,`products`,`payment`) 
        VALUES(?,?,?,?)";
        $stt = $this->execQuery($sql,
            $order->receiver,
            $order->address,
            $order->products,
            $order->payment
        );
        if($stt == false){
            return array(
                "error" => "O pedido não pode ser cadastrado [0].",
                "responseCode" => 400
            );
        }
        if($stt->rowCount() > 0) {
            return array(
                "success" => "Novo pedido cadastrado com sucesso.",
                "responseCode" => 200
            );
        } else {
            array(
                "error" => "O pedido não pode ser cadastrado. [1]",
                "responseCode" => 400
            );
        }
    }

    public function editOrder(Order $order){
        $sql = "UPDATE crdv_orders SET
        `receiver` = COALESCE(NULLIF(?,''),`receiver`),
        `address` = COALESCE(NULLIF(?,''),`address`),
        `products` = COALESCE(NULLIF(?,''),`products`),
        `payment` = COALESCE(NULLIF(?,''),`payment`)
        WHERE `id` = ?";
        $stt = $this->execQuery($sql,
            $order->receiver,
            $order->address,
            $order->products,
            $order->payment,
            $order->id
        );
        if($stt == false){
            return array(
                "error" => "O pedido não pode ser atualizado [0].",
                "responseCode" => 400
            );
        }
        if($stt->rowCount() > 0) {
            return array(
                "success" => "Edição realizada com sucesso.",
                "responseCode" => 200
            );
        } else {
            array(
                "error" => "O pedido não pode ser atualizado.",
                "responseCode" => 400
            );
        }
    }

    public function delOrder(Int $orderID){
        $orderID = filter_var($orderID, FILTER_VALIDATE_INT);
        $sql = "DELETE FROM crdv_orders WHERE `id` = ?";
        $statement = $this->con->prepare($sql);
        $statement->execute([$orderID]);
        if($statement->rowCount() == 1){
            return array(
                "success" => "O pedido foi removido.",
                "responseCode" => 200
            );
        }
        return array(
            "error" => "O pedido não pode ser removido.",
            "responseCode" => 400
        );
    }
    public function selectAllOrders() {
        $array = [];
        $sql = "SELECT * FROM crdv_orders";
        $stt = $this->execQuery($sql);
        if($stt == false){
            return array(
                "error" => "Não foi possível selecionar os pedidos.",
                "responseCode" => 400
            );
        }
        $result = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $order){
            $array[] = $order;
        }
        return $array;
        
    }

    public function selectOrder(Int $orderID) {
        $array = [];
        $sql = "SELECT * FROM crdv_orders WHERE `id` = ?";
        $stt = $this->execQuery($sql, $orderID);
        if($stt == false){
            return array(
                "error" => "Não foi possível selecionar o pedido.",
                "responseCode" => 400
            );
        }
        $result = $stt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}