<?php

namespace CRDV\Controller\Validations;

use CRDV\Model\UserFunctions\UserDAO;
use CRDV\Model\UserFunctions\User;
use CRDV\Model\UserFunctions\UserSetHeaders;
use \Exception;

class RequestValidationUser {

    private static array $actionUndefinedErrorMessage = array("error" => "Nenhuma requisição foi informada.");
    private static array $defaultErrorMessage = array("error" => "Não foi possível realizar a requisição.");
    private static array $loginErrorMessage = array("error" => "Email e/ou senha incorreto(as)");
    private static String $loginSuccessMessage = "Login realizado com sucesso!";
    private static array $registerSuccessMessage = array("sucesso" => "Registro efetivado com sucesso.");
    private static array $registerErrorMessage = array("error" => "Não foi possível registrar no servidor.");
    private static array $notLoggedErrorMessage = array("error" => "Você não está logado");
    private static array $userLoggedOutMessage = array("sucesso" => "Você saiu do sistema.");
    private static array $updateSuccessMessage = array("sucesso" => "Informações atualizadas com sucesso.");
    private static array $removeErrorMessage = array("error" => "Não foi possível remover o usuário.");
    private static array $removeSuccessMessage = array("sucesso" => "Usuário removido com sucesso.");

    public static function validateParam($action)
    {
        if(isset($action) && !empty($action)): return true;
        else: http_response_code(200); echo json_encode(self::$actionUndefinedErrorMessage);
        endif;
    }

    public static function validateLoginAction(UserDAO $userDb, $data){
        try {
            $email = addslashes(trim($data['email']));
            $password = addslashes(trim($data['password']));
            $result = $userDb->login($email,$password);
            /**
             * $result[0] = User Privilege 0 for Normal 1 for Admin
             * $result[1] = Name of people
             * $result[2] = Login Result - True or False
             */
            if(isset($result[2])): 
                if(UserSetHeaders::checkExpOfActualToken() === false):
                    $goto = "index.php";
                    if($result[0] == "1") {$goto = "adminPage/html/index.php";}
                    $token = UserSetHeaders::setTokenAuthorization($email,$result[0], $result[1], $result[3]);
                    $_SESSION["token"] = $token["token"];
                    echo json_encode(array(
                        "sucesso" => self::$loginSuccessMessage,
                        "goto" => $goto,
                        "jwt" => $token["token"],
                        "expiredAt" => $token["expiredAt"],
                        "email"=>$data['email']
                    ));
                else:
                    http_response_code(200);
                    echo json_encode(array(
                        "error" => "Você já está logado."
                    ));
                endif;
            else: http_response_code(200); echo json_encode(self::$loginErrorMessage);
            endif;
        } catch (Exception $e){

            echo self::getDefaultErrorMessage();
        }

    }

    public static function validateLogOutAction(){ // TODO
 
        if(isset($_SESSION["token"]) AND !empty($_SESSION["token"])): unset($_SESSION["token"]); session_regenerate_id(); echo json_encode(self::$userLoggedOutMessage);
        else: 
            http_response_code(200);
            echo json_encode(self::$notLoggedErrorMessage);
        endif;
    }

    public static function validateRegisterFisicUser(UserDAO $userDb, $data){
        try
        {
            $user = new User();
            $user->setEmail(addslashes(trim($data['email'])));
            $user->setPassword(addslashes(trim($data['password'])));
            $user->setName(addslashes(trim($data['name'])));
            $user->setSurname(addslashes(trim($data['surname'])));
            $user->setCpf(addslashes(trim($data['cpf'])));
            $user->setAddress(addslashes(trim($data['address'])));
            $user->setTelephone(addslashes(trim($data['telephone'])));
            $user->setResidentialPhone(addslashes(trim($data['residentialPhone'])));
            if($userDb->addFisicUser($user) instanceof User)
            {
                echo json_encode(self::$registerSuccessMessage);
            } else {
                echo json_encode(self::$registerErrorMessage);
            }
        }
        catch (Exception $e)
        {
            echo self::getDefaultErrorMessage();
        }
    }

    public static function validateRegisterJuridicUser(UserDAO $userDb, $data){
        try {
            $user = new User();
            $user->setEmail(addslashes(trim($data['email'])));
            $user->setPassword(addslashes(trim($data['password'])));
            $user->setName(addslashes(trim($data['name'])));
            $user->setSurname(addslashes(trim($data['surname'])));
            $user->setCnpj(addslashes(trim($data['cnpj'])));
            $user->setSocialReason(addslashes(trim($data['socialReason'])));
            $user->setStateRegistration(addslashes(trim($data['stateRegistration'])));
            $user->setAddress(addslashes(trim($data['address'])));
            $user->setTelephone(addslashes(trim($data['telephone'])));
            $user->setResidentialPhone(addslashes(trim($data['residentialPhone'])));
            if($userDb->addJuridicUser($user) instanceof User){echo json_encode(self::$registerSuccessMessage);}
            else{echo json_encode(self::$registerErrorMessage);}
        } catch (Exception $e){
            echo self::getDefaultErrorMessage();
        }
    }
    
    public function validateUpdateUser(UserDAO $userDb, $data){
        try {
            $user = new User();
            $user->setEmail(addslashes(trim($data['email'])));
            $user->setPassword(addslashes(trim($data['password'])));
            $user->setName(addslashes(trim($data['name'])));
            $user->setSurname(addslashes(trim($data['surname'])));
            $user->setCnpj(addslashes(trim($data['cnpj'])));
            $user->setCpf(addslashes(trim($data['cpf'])));
            $user->setSocialReason(addslashes(trim($data['socialReason'])));
            $user->setStateRegistration(addslashes(trim($data['stateRegistration'])));
            $user->setAddress(addslashes(trim($data['address'])));
            $user->setTelephone(addslashes(trim($data['telephone'])));
            $user->setResidentialPhone(addslashes(trim($data['residentialPhone'])));
            $user->setId(\addslashes(\trim($data["uId"])));
            if($userDb->update($user)){echo json_encode(self::$updateSuccessMessage);}
            else{echo json_encode(self::$registerErrorMessage);}
        } catch (Exception $e){
            echo self::getDefaultErrorMessage();
        }
    }
    public function validateDeleteUser(UserDAO $userDb, $data){
        try{
            if($userDb->delete($data["uId"])){
                echo \json_encode(self::$removeSuccessMessage);
            } else {
                echo \json_encode(self::$removeErrorMessage);
            }
        } catch (Exception $e) {
            echo self::getDefaultErrorMessage();
        }
    }

    public function validateListAllUser(UserDAO $userDb){
        try {
            $results = $userDb->findAll();
            if(\is_array($results)) {
                echo \json_encode($results);
            } else {
                echo \json_encode($results);
            }
        } catch (\Exception $e) {
            echo self::getDefaultErrorMessage();
        }
    }

    public function validateListByNameUser(UserDAO $userDb, $data){
        try {
            $results = $userDb->findByName(addslashes(trim($data["name"])));
            if(\is_array($results)) {
                echo \json_encode($results);
            } else {
                echo \json_encode($results);
            }
        } catch (\Exception $e) {
            echo self::getDefaultErrorMessage();
        }
    }

    public function validateListByTelUser(UserDAO $userDb, $data){
        try {
            $results = $userDb->findByTelephone(addslashes(trim($data["tel"])));
            if(\is_array($results)) {
                echo \json_encode($results);
            } else {
                echo \json_encode($results);
            }
        } catch (\Exception $e) {
            echo self::getDefaultErrorMessage();
        }
    }

    public static function getDefaultErrorMessage()
    {
        http_response_code(200);
        return json_encode(self::$defaultErrorMessage);
    }

    public static function getActionUndefinedErrorMessage(){
        return json_encode(self::$actionUndefinedErrorMessage);
    }

}
