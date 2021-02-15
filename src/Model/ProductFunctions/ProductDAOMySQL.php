<?php

namespace CRDV\Model\ProductFunctions;
require dirname(__DIR__,3).'/vendor/autoload.php';
use PDO;

class ProductDAOMySQL implements ProductDAO
{
    private PDO $con;

    public function __construct(PDO $driver){
        $this->con = $driver;
    }

    private function createProductInstance($product){
        $instanceClassProduct = new Product();
        $instanceClassProduct->sku = isset($product["sku"]) ? $product["sku"] : "";
        $instanceClassProduct->name = isset($product["name"]) ? $product["name"] : "";
        $instanceClassProduct->model = isset($product["model"]) ? $product["model"] : "";
        $instanceClassProduct->description = isset($product["desc"]) ? $product["desc"] : "";
        $instanceClassProduct->price = isset($product["price"]) ? $product["price"] : "";
        $instanceClassProduct->amount = isset($product["amount"]) ? $product["amount"] : "";
        $instanceClassProduct->lastStock = isset($product["lastStock"]) ? $product["lastStock"] : "";
        $instanceClassProduct->productImage = isset($product["productImage"]) ? $product["productImage"] : "";
        $instanceClassProduct->productsInStock = isset($product["productsInStock"]) ? $product["productsInStock"] : "";
        $instanceClassProduct->sector = isset($product["sector"]) ? $product["sector"] : "";
        $instanceClassProduct->distributionCenter = isset($product["cd"]) ? $product["cd"] : "";
        $instanceClassProduct->volumnPrice = isset($product["volumnPrice"]) ? $product["volumnPrice"] : "";
        $instanceClassProduct->specifications = isset($product["specifications"]) ? $product["specifications"] : "";
        $instanceClassProduct->weight = isset($product["weight"]) ? $product["weight"] : "";
        $instanceClassProduct->sendFormat = isset($product["sendFormat"]) ? $product["sendFormat"] : "";
        $instanceClassProduct->length = isset($product["length"]) ? $product["length"] : "";
        $instanceClassProduct->width = isset($product["width"]) ? $product["width"] : "";
        $instanceClassProduct->height = isset($product["height"]) ? $product["height"] : "";
        return $product;
    }
    private function execQuery($sql,...$data){
        $stt = $this->con->prepare($sql);
        $stt->execute($data);
        if($stt->rowCount() > 0){
            return $stt;
        }
        return false;
    }
    /**
     * @return array|bool If fail will return False if success will return an Array with the products
     */
    public function selectAll()
    {
        $array = [];
        $stt = $this->execQuery("SELECT * FROM crdv_products");
        if($stt == false){return $stt;}
        $result = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $product){
            $array[] = $this->createProductInstance($product);
        }
        return $array;
    }
    /**
     * @return array|bool If fail will return False if success will return an Array with the products
     */
    public function selectAllForIndex(){
        $array = [];
        $stt = $this->execQuery("SELECT id,name,price,productImage,sku FROM crdv_products");
        if($stt == false){return $stt;}
        $result = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $product){
            $array[] = $product;
        }
        return $array;
    }

    /**
     * @param Int $id
     * @return array|bool
     */
    public function findById(Int $id)
    {
        $sql = "SELECT * FROM crdv_products WHERE id = ?";
        $stt = $this->execQuery($sql,$id);
        if($stt == false){return $stt;}
        $product = $stt->fetch(PDO::FETCH_ASSOC);
        $array[] = $this->createProductInstance($product);
        return $array;
    }

    public function findByName(String $name)
    {
        $array = [];
        $name = "%$name%";
        $sql = "SELECT * FROM crdv_products WHERE name LIKE ?";
        $stt = $this->execQuery($sql,$name);
        if($stt == false){return $stt;}
        $product = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($product as $item){
            $array[] = $this->createProductInstance($item);
        }
        return $array;
    }

    public function findBySKU(String $sku)
    {
        $array = [];
        $sku = "%$sku%";
        $sql = "SELECT * FROM crdv_products WHERE sku LIKE ?";
        $stt = $this->execQuery($sql, $sku);
        if($stt == false){return $stt;}
        $product = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($product as $item){
            $array[] = $this->createProductInstance($item);
        }
        return $array;
    }

    public function findByMSC(String $sector)
    {
        $array = [];
        $sector = "%$sector%";
        $sql = "SELECT * FROM crdv_products WHERE sector LIKE ?";
        $stt = $this->execQuery($sql,$sector);
        if($stt == false){return $stt;}
        $product = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($product as $item){
            $array[] = $this->createProductInstance($item);
        }
        return $array;
    }

    public function findBySector(string $sector)
    {
        $array = [];
        $sql = "SELECT * FROM crdv_products WHERE sector = ?";
        $stt = $this->execQuery($sql,$sector);
        if($stt == false){return $stt;}
        $product = $stt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($product as $item){
            $array[] = $this->createProductInstance($item);
        }
        return $array;
    }

    public function registerProduct(Product $product){
        $sql = "INSERT INTO crdv_products
        (`sku`,`name`, `model`, `desc`, `price`,`amount`,`lastStock`,`productsInStock`,
        `productImage`,`sector`,`cd`,`volumnPrice`,`specifications`, `fabricator`, `weight`,
        `sendFormat`,`length`,`heigth`,`width`,`diameter`) 
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stt = $this->execQuery($sql,
            $product->__get("sku"),             $product->__get("name"),                $product->__get("model"),
            $product->__get("description"),     $product->__get("price"),               $product->__get("amount"),
            $product->__get("lastStock"),       $product->__get("productsInStock"),     $product->__get("productImage"),
            $product->__get("sector"),          $product->__get("distributionCenter"),  $product->__get("volumnPrice"),
            $product->__get("specifications"),  $product->__get("fabricator"),          $product->__get("weight"),
            $product->__get("sendFormat"),      $product->__get("length"),              $product->__get("heigth"),
            $product->__get("width"),           $product->__get("diameter")
        );
        if($stt == false){return $stt;}
        $rowsAffected = $stt->rowCount();
        if( $rowsAffected == 1 ){
            return array(
                "success" => "Cadastro realizado com sucesso.",
                "responseCode" => 200
            );
        } else {
            return array(
                "error" => "O produto não pode ser cadastrado.",
                "responseCode" => 400
            );
        }
    }

    public function alterProduct(Product $product, Int $id){
        $sql = "UPDATE crdv_products SET
        `sku` = COALESCE(NULLIF(?,''),`sku`),
        `name` = COALESCE(NULLIF(?,''),`name`),
        `model` = COALESCE(NULLIF(?,''),`model`),
        `desc` = COALESCE(NULLIF(?,''),`desc`),
        `price` = COALESCE(NULLIF(?,''),`price`),
        `amount` = COALESCE(NULLIF(?,''),`amount`),
        `lastStock` = COALESCE(NULLIF(?,''),`lastStock`),
        `productsInStock` = COALESCE(NULLIF(?,''),`productsInStock`),
        `productImage` = COALESCE(NULLIF(?,''),`productImage`),
        `sector` = COALESCE(NULLIF(?,''),`sector`),
        `cd` = COALESCE(NULLIF(?,''),`cd`),
        `volumnPrice` = COALESCE(NULLIF(?,''),`volumnPrice`),
        `specifications` = COALESCE(NULLIF(?,''),`specifications`),
        `fabricator` = COALESCE(NULLIF(?,''),`fabricator`),
        `weight` = COALESCE(NULLIF(?,''),`weight`),
        `sendFormat` = COALESCE(NULLIF(?,''),`sendFormat`),
        `length` = COALESCE(NULLIF(?,''),`length`),
        `heigth` = COALESCE(NULLIF(?,''),`heigth`),
        `width` = COALESCE(NULLIF(?,''),`width`),
        `diameter` = COALESCE(NULLIF(?,''),`diameter`)
        WHERE `id` = ?";
        $stt = $this->execQuery($sql,
            $product->__get("sku"),             $product->__get("name"),                $product->__get("model"),
            $product->__get("description"),     $product->__get("price"),               $product->__get("amount"),
            $product->__get("lastStock"),       $product->__get("productsInStock"),     $product->__get("productImage"),
            $product->__get("sector"),          $product->__get("distributionCenter"),  $product->__get("volumnPrice"),
            $product->__get("specifications"),  $product->__get("fabricator"),          $product->__get("weight"),
            $product->__get("sendFormat"),      $product->__get("length"),              $product->__get("heigth"),
            $product->__get("width"),           $product->__get("diameter"), $id
        );
        if(gettype($stt) == "object" && $stt->rowCount() > 0){
            return array(
                "success" => "Atualização realizada com sucesso.",
                "responseCode" => 200
            );
        }
        return array(
            "error" => "O produto não pode ser atualizado.",
            "responseCode" => 400
        );
    }

    public function removeProduct(Int $id){
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "DELETE FROM crdv_products WHERE `id` = ?";
        $stt = $this->execQuery($sql, $id);
        if(gettype($stt) == "object" && $stt->rowCount() == "1"){
            return array(
                "success" => "O produto foi removido.",
                "responseCode" => 200
            );
        } else {
            return array(
                "error" => "O produto não pode ser removido.",
                "responseCode" => 400
            );
        }
    }
}