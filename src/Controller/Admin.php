<?php

namespace CRDV\Controller\Validations;

session_start();


require_once(dirname(__DIR__,2).'/vendor/autoload.php');


use CRDV\Model\UserFunctions\UserSetHeaders;

class Admin {

    public function checkIfIsAdmin(){
        
        if(isset($_SESSION["token"])){
            $token = UserSetHeaders::decodeToken();
            if($token !== false){
                if(!$token["userPrivilege"] == "1"){
                    die(\json_encode(array(
                        "error" => "Usuário sem privilégios para a requisição."
                    )));
                }
            } else {
                die(\json_encode(array(
                    "error" => "Token inválido."
                )));    
            }
        } else {
            die(\json_encode(array(
                "error" => "Você não está logado."
            )));
        }
    }

}
