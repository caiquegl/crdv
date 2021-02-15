<?php

namespace CRDV\Model\ProductFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use CRDV\Model\Database\MySQLConnection;
use PHPUnit\Framework\TestCase;

class ProductDAOMySQLTest extends TestCase{

    protected function assertPreConditions(): void
    {
        parent::assertTrue(class_exists("CRDV\Model\ProductFunctions\ProductDAOMySQL"));
    }

    public function testInstanceOfClassProduct()
    {
        $product = new Product();
        $product->id = 99;
        $product->sku = "SKU-999999";
        $product->name = "Nobreak APC";
        $product->model = "BZ600-BR";
        $product->description = "Nobreak de alta potência";
        $product->price = 123.45;
        $product->amount = 99;
        $product->lastStock = "2020/03/02";
        $product->productImage = "";
        $product->sector = "Tecnologia";
        $product->distributionCenter = "Microsoft";
        $product->volumnPrice = 678.90;
        $product->specifications = "Bateria 10000VA";
        $product->fabricator = "APC";
        $product->weight = 10.0;
        $product->sendFormat = 1;
        $product->length = 10.0;
        $product->height = 10.0;
        $product->width = 10.0;
        var_dump($product);

        parent::assertIsObject($product);
    }

    public function testSelectAllProductsWithMySQL(){
        $msg_error = "O valor retornado não é um array";
        $pdo = new MySQLConnection();
        $productDAO = new ProductDAOMySQL($pdo->connect());
        $result = $productDAO->selectAll();
        var_dump($result);
        parent::assertIsArray($result, $msg_error);
    }

    public function testSelectAllForIndex(){
        $msg_error = "O valor retornado não é um array";
        $pdo = new MySQLConnection();
        $productDAO = new ProductDAOMySQL($pdo->connect());
        $result = $productDAO->selectAllForIndex();
        var_dump($result);
        parent::assertIsArray($result, $msg_error);
    }

    public function testRegisterProduct(){ 
        $msg_error = "Não foi possível cadastrar o produto";
        $product = new Product();
        $con = new MySQLConnection();
        $productDAO = new ProductDAOMySQL($con->connect());
        $product->__set("sku","SKU-233");
        $product->__set("name","Controle XBOX 360°");
        $product->__set("model","KAOWIAJAJXIA");
        $product->__set("description","Controle do console XBOX ONE");
        $product->__set("price", 59.99);
        $product->__set("amount", "1");
        $product->__set("lastStock", date("Y-m-d"));
        $product->__set("productsInStock", rand(0, 100));
        $product->sector = "Lazer";
        $product->productImage = "watch.jpeg";
        $product->__set("distributionCenter","Centro de Distribuição de São Carlos");
        $product->__set("volumnPrice",27.00);
        $product->__set("specifications","Contrle preto do XBOX 360, não vem com pilhas");
        $product->__set("fabricator","CHINA INDUSTRY LTDA");
        $product->__set("weight", "10.00");
        $product->__set("sendFormat", "2");
        $product->__set("length","5.0");
        $product->__set("height","5.0");
        $product->__set("width","5.0"); 
        $product->__set("diameter","5.0");
        var_dump($product);
        $result = $productDAO->registerProduct($product);
        var_dump($result);
        parent::assertTrue(isset($result["success"]),$msg_error);
    }

}
