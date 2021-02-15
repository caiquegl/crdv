<?php

session_start();

unset($_SESSION["orderErrorCount"]);

if(isset($_SESSION["orderErrorCount"])):
    if($_SESSION["orderErrorCount"] > 3):
        die(json_encode(array(
            "error" => "Muitas tentativas. Tente novamente mais tarde."
        )));
    endif;
else:
    $_SESSION["orderErrorCount"] = 1;
endif;

require_once(dirname(__DIR__,2).'/vendor/autoload.php');

use CRDV\Controller\Validations\RequestValidationOrder;
use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\OrderFunctions\OrderCrudMySql;

header("Content-Type: application/json; charset=utf-8");

$conn = new MySQLConnection();
$orderDAO = new OrderCrudMySql($conn->connect());
$reqValidation = new RequestValidationOrder();

if($reqValidation->validateParam($_POST['action'])){
    $action = strtolower(addslashes(trim($_POST['action'])));
    switch($action)
    {
        case "selectall":
            $reqValidation->validateListAllOrder($orderDAO);
        break;
        case "addorder":
            $reqParams = array("receiver","address","products","payment");
            foreach($reqParams as $param){
                if(!isset($_POST[$param]) OR empty($_POST[$param]) or (json_decode($_POST[$param]) == False)) {
                    // $_SESSION["orderErrorCount"] += 1;
                    die(json_encode(array(
                        "error" => "Parâmetro $param inválido."
                    )));
                }
            }
            $reqValidation->validateAddOrder($orderDAO, $_POST);
        break;
        case "updateorder":
            if(isset($_POST["oId"])):
                $reqParams = array("receiver","address","products","payment");
                foreach($reqParams as $param){
                    if(!isset($_POST[$param]) OR empty($_POST[$param]) or (json_decode($_POST[$param]) == False)) {
                        // $_SESSION["orderErrorCount"] += 1;
                        die(json_encode(array(
                            "error" => "Parâmetro $param inválido."
                        )));
                    }
                }
                $reqValidation->validateUpdateOrder($orderDAO, $_POST);
            endif;
        break;
        case "delorder":
            if(isset($_POST["oId"])):
                $id = addslashes(trim($_POST["oId"]));
                $reqValidation->validateRemoveOrder($orderDAO, $id);
            else:
                die(json_encode(array(
                    "error" => "Parâmetro oId inválido."
                )));
            endif;
        break;
        case "idorder":
            if(isset($_POST["oId"])):
                $id = addslashes(trim($_POST["oId"]));
                $reqValidation->validateListByIdOrder($orderDAO, $id);
            else:
                die(json_encode(array(
                    "error" => "Parâmetro oId inválido."
                )));
            endif;
        break;
        default:
            echo $reqValidation->getDefaultErrorMessage();
        break;
    }

}