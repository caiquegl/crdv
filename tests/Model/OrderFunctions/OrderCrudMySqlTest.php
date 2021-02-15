<?php

namespace CRDV\Model\OrderFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use CRDV\Model\Database\MySQLConnection;
use PHPUnit\Framework\TestCase;

class OrderCrudMySqlTest extends TestCase {
    protected function assertPreConditions(): void
    {
        parent::assertTrue(class_exists("CRDV\Model\OrderFunctions\OrderCrudMySql"));
    }

    public function testCreateNewOrder(){
        $order = new Order();
        $order->__set("receiver",'{
            "name" : "Hugo Henrique S. A. C.",
            "email" : "mxhugoxm@gmail.com",
            "cpf" : "000.000.000-00",
            "cnpj" : null,
            "telephone" : "(79) 9 9833-7417",
            "residentialPhone" : null
        }');
        $order->__set("address",'{
            "cep":"49160-000",
            "rua":"Avenida B",
            "bairro":"Conjunto João Alves",
            "cidade":"Nossa Senhora do Socorro",
            "uf":"SE",
            "numero":"26"
        }');
        $order->__set("products",'[
            {"id" : "1","name" : "Smart Watch Samsung","sku" : "SKU-123","price" :  "42.99","amount" : "1"
            },
            {"id" : "2","name" : "Smart TV Samsung","sku" : "SKU-133","price" :  "4199.99","amount" : "1"
            }
        ]');
        $order->__set("payment",'{
            "paymentForm" : "credit",
            "sendPrice" : "170.00",
            "total" : "4243.00"
        }');
        \var_dump($order);
        parent::assertIsObject($order);
    }

    public function testCreateNewOrderInDB(){
        $order = new Order();
        $order->receiver = '{"name" : "Hugo Henrique S. A. C.","email" : "mxhugoxm@gmail.com", "cpf" : "000.000.000-00", "cnpj" : null, "telephone" : "(79) 9 9833-7417", "residentialPhone" : null}';
        $order->address = '{"cep":"49160-000","rua":"Avenida B","bairro":"Conjunto João Alves","cidade":"Nossa Senhora do Socorro","numero":"26"}';
        $order->products = '[{"id" : "1","name" : "Smart Watch Samsung","sku" : "SKU-123","price" :  "42.99","amount" : "1"},{"id" : "2","name" : "Smart TV Samsung","sku" : "SKU-133","price" :  "4199.99","amount" : "1"}]';
        $order->payment = '{"paymentForm" : "credit","sendPrice" : "170.00","total" : "4243.00"}';
        $db = new MySQLConnection();
        $crud = new OrderCrudMySql($db->connect());
        $result = $crud->newOrder($order);
        \var_dump($result);
        if(isset($result["success"])){
            $result = true;
        } else {
            $result = false;
        }
        parent::assertTrue($result);
    }
}