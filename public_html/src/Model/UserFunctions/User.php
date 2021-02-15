<?php

namespace CRDV\Model\UserFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use CRDV\Model\Config\config;
use phpDocumentor\Reflection\Types\Boolean;

class User {

    public $id = 0;
    public $cpf = "";
    public $cnpj = "";
    public $stateRegistration = "isento";
    public $socialReason = "";
    public $name = "";
    public $surname = "";
    public $email = "";
    public $password = "";
    public $address = "";
    public $telephone = "";
    public $residentialPhone = "";


    /**
     * SETTERS
     */
    public function setAddress(String $address){
        if(json_encode($address))
        {
            $this->address = addslashes(trim($address));
        }
    }

    /**
     * Validate for mask 00.000.000/0000-00
     * and checks for length == 18
     */
    public function setCnpj($cnpj){
        if(strlen($cnpj) == 18)
        {
            $this->cnpj = addslashes(trim($cnpj));
        }
    }

    /**
     * Validate for mask 000.000.000-00
     * and checks for length == 11
     */
    public function setCpf($cpf){
        if(strlen($cpf) >= 11)
        {
            $this->cpf = str_replace(['.','-'],"",addslashes(trim($cpf)));
        }
    }

    public function setEmail(String $email){
        $this->email = addslashes(trim(filter_var($email, FILTER_VALIDATE_EMAIL)));
    }

    public function setId(Int $id){
        $this->id = $id;
    }

    /**
     * Checks for length >= 3
     */
    public function setName(String $name){
        if(strlen($name) >= 3)
        {
            $this->name = addslashes(trim($name));
        } else {
            http_response_code(400);
            die(json_encode(
                array(
                    "error"=> "Nome não definido ou inválido."
                )
            ));
        }
    }

    /**
     * Validate for mask (00) 0000-0000
     * and checks for length == 14
     */
    public function setResidentialPhone($residentialPhone){
        if(strlen($residentialPhone) == 14)
        {
            $this->residentialPhone = addslashes(trim($residentialPhone));
        }
    }

    /**
     * Escapes invalid characters
     * and hash password using Argon2 encryption
     */
    public function setPassword(String $password){
        $password = (String) config::getKey().addslashes(trim($password));
        $hash = password_hash($password,PASSWORD_ARGON2ID);
        if($hash instanceof Boolean){return false;}
        $this->password = $hash;
    }

    /**
     * Validate for mask 000.000.000.000
     * and checks for length == 15
     */
    public function setStateRegistration($stateRegistration){
        if(strlen($stateRegistration) == 15)
        {
            $this->stateRegistration = addslashes(trim($stateRegistration));
        }
    }

    public function setSocialReason($socialReason){
        $this->socialReason = addslashes(trim($socialReason));
    }

    /**
     * Validate for only alpha type character
     * and checks for length >= 3
     */
    public function setSurname(String $surname){
        if(strlen($surname) >= 3)
        {
            $this->surname = addslashes(trim($surname));
        }
    }

    /**
     * Validate for mask (00) 0 0000-0000
     * and checks for length between 14 and 16 characters
     */
    public function setTelephone($telephone){
        if(strlen($telephone) >= 14 && strlen($telephone) <= 16)
        {
            $this->telephone = addslashes(trim($telephone));
        }
    }


    /**
     * GETTERS
     */
    public function getAddress(): String{
        return $this->address;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function getCnpj(){
        return $this->cnpj;
    }

    public function getEmail(): String{
        return $this->email;
    }

    public function getId(): Int{
        return $this->id;
    }

    public function getName(): String{
        return $this->name;
    }

    public function getResidentialPhone(){
        return $this->residentialPhone;
    }

    public function getSocialReason(){
        return $this->socialReason;
    }

    public function getStateRegistration() {
        return $this->stateRegistration;
    }

    public function getSurname(): String{
        return $this->surname;
    }

    public function getPassword(): String{
        return $this->password;
    }

    public function getTelephone(){
        return $this->telephone;
    }
}

$u = new User();
$u->setPassword("12345678");
