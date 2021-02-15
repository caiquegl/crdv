<?php

namespace CRDV\Model\OrderFunctions;

use CRDV\Model\UserFunctions\User;
use PhpParser\Node\Expr\Cast\Array_;

require dirname(__DIR__,3)."/vendor/autoload.php";

class Order {

    private String $receiver;
    private String $address;
    private String $products;
    private String $payment;
    
    private static Array $paymentForms = array("billet","credit","debit");

    public function __get($atrib)
    {
        return $this->$atrib;
    }

    public function __set($atrib, $value)
    {
        (($atrib == "id") && (is_int((Int) $value))) ? $this->$atrib = strip_tags(addslashes(trim($value))) : "";
        (($atrib == "receiver") && (!empty($value)) && (json_encode($value))) ? $this->$atrib = strip_tags(addslashes(trim($value))) : "";
        (($atrib == "address") && (!empty($value))) ? $this->$atrib = strip_tags(addslashes(trim($value))) : "";
        (($atrib == "products") && (!empty($value))) ? $this->$atrib = strip_tags(addslashes(trim($value))) : "";
        (($atrib == "payment") && (!empty($value))) ? $this->$atrib = strip_tags(addslashes(trim($value))) : "" ;
    }

}