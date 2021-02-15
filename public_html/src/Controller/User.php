<?php

namespace CRDV\Controller;

session_start();

require_once(dirname(__DIR__,2).'/vendor/autoload.php');

use CRDV\Model\Database\MySQLConnection;
use CRDV\Model\UserFunctions\UserDAOMySQL;
use CRDV\Controller\Validations\RequestValidationUser;

header( "HTTP/1.1 200 OK" );
header( "Content-type: application/json; charset=utf-8" );

$db = new MySQLConnection();
$userDb = new UserDAOMySQL($db->connect());
$reqUserValidation = new RequestValidationUser();
$data = $_POST;

if (isset($_POST['action'])){
    if($reqUserValidation->validateParam($_POST['action']))
    {
        $action = strtolower(addslashes(trim($_POST['action'])));
        switch($action)
        {
            case "loginuser":
               $reqUserValidation->validateLoginAction($userDb,$data);
            break;
            case "logoutuser":
                $reqUserValidation->validateLogOutAction();
            break;
            case "registerfisicperson":
                $reqUserValidation->validateRegisterFisicUser($userDb, $data);
            break;
            case "registerjuridicperson":
               $reqUserValidation->validateRegisterJuridicUser($userDb, $data);
            break;
            case "updateuser":
                $reqUserValidation->validateUpdateUser($userDb, $data);
            break;
            case "deleteuser";
                $reqUserValidation->validateDeleteUser($userDb, $data);
            break;
            case "listalluser";
                $reqUserValidation->validateListAllUser($userDb);
            break;
            case "listbynameuser";
                $reqUserValidation->validateListByNameUser($userDb, $data);
            break;
            case "listbyteluser";
                $reqUserValidation->validateListByTelUser($userDb, $data);
            break;
            default:
                echo $reqUserValidation->getDefaultErrorMessage();
            break;
        }
    }
} else {
    echo $reqUserValidation::getActionUndefinedErrorMessage();
}
