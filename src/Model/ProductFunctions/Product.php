<?php

namespace CRDV\Model\ProductFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

class Product {

    private $id;
    private $sku;
    private $name;
    private $model;
    private $description;
    private $price;
    private $amount;
    private $lastStock;
    private $productsInStock;
    private $productImage = "produto_sem_imagem.jpeg";
    private $sector;
    private $distributionCenter;
    private $volumnPrice;
    private $specifications;
    private $fabricator;
    private $weight;
    private $sendFormat;
    private $length;
    private $height;
    private $width;
    private $diameter;

    /**
     * Validates attributes length before 
     */
    public function __set($atrib, $value){
        (($atrib == "id") && (is_int($value))) ? $this->$atrib=filter_var($value, FILTER_VALIDATE_INT):"";
        (($atrib == "sku" && (strpos($value,"SKU") !== false))) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "name") && (strlen($value) >= 4)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "model") && (strlen($value) >= 5)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "description") && (strlen($value) >= 10)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "price") && (is_float((Float) $value))) ? $this->$atrib = addslashes(number_format(str_replace(['-', ','], '.', (String) $value), 2)) : "";
        (($atrib == "amount") && (is_integer((Int) $value))) ? $this->$atrib = addslashes($value) : "";
        ($atrib == "lastStock") ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "productImage") && (!empty($value))) ? $this->$atrib = $value : "";
        (($atrib == "productsInStock") && (is_integer((Int) $value))) ? $this->$atrib = $value : "";
        (($atrib == "sector") && is_string($value)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "distributionCenter") && is_string($value)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "volumnPrice") && (is_float((Float) $value))) ? $this->$atrib = addslashes(number_format(str_replace(['-', ','], ',', (Float) $value), 2)) : "";
        (($atrib == "specifications")) && (strlen($value) >= 10) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "fabricator") && (strlen($value) >= 3)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "weight") && (is_float((Float) $value)) && ((Float) $value > 0.0)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "sendFormat") && (in_array((Int) $value, array(1,2,3)))) ? $this->$atrib = addslashes(trim($value)): "";
        (($atrib == "length") && (is_float((Float) $value)) && ((Float) $value > 0.0)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "heigth") && (is_float((Float) $value)) && ((Float) $value > 0.0)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "width") && (is_float((Float) $value)) && ((Float) $value > 0.0)) ? $this->$atrib = addslashes(trim($value)) : "";
        (($atrib == "diameter") && (is_float((Float) $value)) && ((Float) $value > 0.0)) ? $this->$atrib = addslashes(trim($value)) : "";
    }

    public function __get($atrib){
        return $this->$atrib;
    }
}
