<?php

namespace CRDV\Model\UserFunctions;

require(dirname(__DIR__,3)."/vendor/autoload.php");

use CRDV\Model\Config\config;
use Exception;
use \Firebase\JWT\JWT;

date_default_timezone_set("America/Sao_Paulo");

abstract class UserSetHeaders{

    public static array $jsonTokenInvalid = array(array("error" => "Token inválido."));

    public static function setTokenAuthorization($email,$userPrivilege,$userName, $userId){
        $key = config::getKeyBase64();
        $expiredAt = strtotime("now +30min");
        $payload = array(
            "iss" => "http://localhost",
            "iat" => strtotime("now"),
            "exp" => $expiredAt,
            "email" => $email,
            "name" => $userName,
            "id" => md5(session_id()),
            "userPrivilege" => $userPrivilege,
            "uId" => $userId
        );
        $jwt = JWT::encode($payload, $key);
        return array(
            "token" => "Bearer " . $jwt,
            "expiredAt" => $expiredAt
        );
    }

    public static function checkTokenAuthorization($token){
        $key = config::getKeyBase64();
        $token = substr($token, 7);
        try {
            $payload = JWT::decode($token, $key, array('HS256'));
            $result = (array) $payload;
            if(isset($result["id"]) AND !is_null($result) AND $result["id"] === md5(session_id())){
                return true;
            }
        } catch (Exception $e) {
            return json_encode(self::$jsonTokenInvalid);
        }
    }

    public static function checkExpOfActualToken(){
        if(isset($_SESSION["token"]) AND !empty($_SESSION["token"])):
            $key = config::getKeyBase64();
            $token = substr($_SESSION["token"], 7);
            try {
                JWT::decode($token, $key, array('HS256'));
                return true;
            } catch (Exception $e) {
                return false;
            }
        else:
            return false;
        endif;
    }

    public static function decodeToken(){
        if(isset($_SESSION["token"])):
            $key = config::getKeyBase64();
            $token = substr($_SESSION["token"], 7);
            try {
                $result = (array) JWT::decode($token, $key, array('HS256'));
                return $result;
            } catch (Exception $e) {
                return false;
            }
        else:
            return false;
        endif;
    }
}