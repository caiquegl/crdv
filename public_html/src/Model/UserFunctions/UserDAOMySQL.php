<?php
namespace CRDV\Model\UserFunctions;

require(dirname(__DIR__,3)."/vendor/autoload.php");

use CRDV\Model\Config\config;
use PDO;
use PhpParser\Node\Expr\Cast\Bool_;

class UserDAOMySQL implements UserDAO{

    /**
     * @var PDO|null
     */
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }

    /**
     * @param User $u
     * @return User|bool
     */
    public function addFisicUser(User $u)
    {
        if($this->findByEmail($u->getEmail()) instanceof User){
            die(\json_encode(array(
                "error" => "Email já cadastrado."
            )));
        }
        if($this->findByCPF($u->getCpf()) instanceof User){
            die(\json_encode(array(
                "error" => "CPF já cadastrado."
            )));
        }
        $data = [
            $u->getEmail(),
            $u->getPassword(),
            $u->getName(),
            $u->getSurname(),
            $u->getCpf(),
            $u->getAddress(),
            $u->getTelephone(),
            $u->getResidentialPhone()
        ];
        $statement = $this->pdo->prepare("INSERT INTO `crdv_users` (`email`,`password`,`name`,`surname`,`cpf`,`address`,`telephone`,`residential_phone`) VALUES (?,?,?,?,?,?,?,?)");
        $statement->execute($data);
        if($statement->rowCount() > 0){
            $u->setId($this->pdo->lastInsertId());
            return $u;
        }
        return false;

    }

    /**
     * @param User $u
     * @return mixed
     */
    public function addJuridicUser(User $u)
    {
        if($this->findByEmail($u->getEmail()) instanceof User){
            die(\json_encode(array(
                "error" => "Email já cadastrado."
            )));
        }
        if($this->findByCNPJ($u->getCnpj()) instanceof User){
            die(\json_encode(array(
                "error" => "CRNPJ já cadastrado."
            )));
        }
        $data = [
            $u->getEmail(),
            $u->getPassword(),
            $u->getName(),
            $u->getSurname(),
            $u->getCnpj(),
            $u->getSocialReason(),
            $u->getStateRegistration(),
            $u->getAddress(),
            $u->getTelephone(),
            $u->getResidentialPhone()
        ];
        $sql = "INSERT INTO `crdv_users` (`email`,`password`,`name`,`surname`,`cnpj`,`social_reason`,`state_registration`,`address`,`telephone`,`residential_phone`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($data);
        if($statement->rowCount() > 0){
            $u->setId($this->pdo->lastInsertId());
            return $u;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function findAll() : Array
    {
        $array = [];
        $statement = $this->pdo->query("SELECT * FROM crdv_users");
        if($statement->rowCount() > 0){
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $user){
                $u = new User();
                $u->setId($user["id"]);
                $u->setEmail($user["email"]);
                $u->setCpf($user["cpf"]);
                $u->setCnpj($user["cnpj"]);
                $u->setStateRegistration($user["state_registration"]);
                $u->setSocialReason($user["social_reason"]);
                $u->setName($user["name"]);
                $u->setSurname($user["surname"]);
                $u->setAddress($user["address"]);
                $u->setTelephone($user["telephone"]);
                $u->setResidentialPhone($user["residential_phone"]);
                $array[] = $u;
            }
        }
        return $array;
    }

    /**
     * @param String $email
     * @return User|bool
     */
    public function findByEmail(String $email)
    {
        $sql = "SELECT * FROM crdv_users WHERE email = ?";
        $statement = $this->pdo->prepare($sql);
        $email = addslashes(filter_var($email, FILTER_VALIDATE_EMAIL));
        $statement->execute([$email]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCpf($data["cpf"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param Int $cpf
     * @return User|bool
     */
    public function findByCPF(String $cpf)
    {
        $sql = "SELECT * FROM crdv_users WHERE cpf = ?";
        $statement = $this->pdo->prepare($sql);
        $cpf = addslashes(trim($cpf));
        $statement->execute([$cpf]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCpf($data["cpf"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param String $cnpj
     * @return User|false
     */
    public function findByCNPJ(String $cnpj){
        $sql = "SELECT * FROM crdv_users WHERE cnpj = ?";
        $statement = $this->pdo->prepare($sql);
        $cnpj = addslashes(trim($cnpj));
        $statement->execute([$cnpj]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCnpj($data["cnpj"]);
            $u->setSocialReason($data["social_reason"]);
            $u->setStateRegistration($data["state_registration"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param String $residentialT
     * @return User|bool
     */
    public function findByResidentialPhone(String $residentialT)
    {
        $sql = "SELECT * FROM crdv_users WHERE residential_phone = ?";
        $statement = $this->pdo->prepare($sql);
        $residentialT = addslashes(trim($residentialT));
        $statement->execute([$residentialT]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCpf($data["cpf"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param String $stateR
     * @return User|bool
     */
    public function findByStateRegistration(String $stateR)
    {
        $sql = "SELECT * FROM crdv_users WHERE state_registration = ?";
        $statement = $this->pdo->prepare($sql);
        $stateR = addslashes(trim($stateR));
        $statement->execute([$stateR]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCpf($data["cpf"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param Int $id
     * @return User|Bool
     */
    public function findById(String $id)
    {
        $sql = "SELECT * FROM crdv_users WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $statement->execute([$id]);
        if($statement->rowCount() > 0){
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $u = new User();
            $u->setId($data["id"]);
            $u->setEmail($data["email"]);
            $u->setCpf($data["cpf"]);
            $u->setName($data["name"]);
            $u->setSurname($data["surname"]);
            $u->setAddress($data["address"]);
            $u->setTelephone($data["telephone"]);
            $u->setResidentialPhone($data["residential_phone"]);
            return $u;
        }
        return false;
    }

    /**
     * @param String $name
     * @return array|bool Return an Array[] on SUCCESS, return an bool(false) on FAILURE
     */
    public function findByName(string $name)
    {
        $array = [];
        $name = addslashes(trim($name));
        $sql = "SELECT * FROM crdv_users WHERE name LIKE '%$name%'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0){
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $user){
                $u = new User();
                $u->setId($user["id"]);
                $u->setEmail($user["email"]);
                $u->setCpf($user["cpf"]);
                $u->setName($user["name"]);
                $u->setSurname($user["surname"]);
                $u->setAddress($user["address"]);
                $u->setTelephone($user["telephone"]);
                $u->setResidentialPhone($user["residential_phone"]);
                $array[] = $u;
            }
            return $array;
        }
        return false;
    }

    /**
     * @param String $surname
     * @return array|bool
     */
    public function findBySurname(string $surname)
    {
        $array = [];
        $surname = addslashes(trim($surname));
        $sql = "SELECT * FROM crdv_users WHERE surname LIKE '%$surname%'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0){
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $user){
                $u = new User();
                $u->setId($user["id"]);
                $u->setEmail($user["email"]);
                $u->setCpf($user["cpf"]);
                $u->setName($user["name"]);
                $u->setSurname($user["surname"]);
                $u->setAddress($user["address"]);
                $u->setTelephone($user["telephone"]);
                $u->setResidentialPhone($user["residential_phone"]);
                $array[] = $u;
            }
            return $array;
        }
        return false;
    }

    /**
     * @param String $telephone
     * @return mixed
     */
    public function findByTelephone(string $telephone)
    {
        $array = [];
        $telephone = addslashes(trim($telephone));
        $sql = "SELECT * FROM crdv_users WHERE telephone LIKE '%$telephone%'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0){
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $user){
                $u = new User();
                $u->setId($user["id"]);
                $u->setEmail($user["email"]);
                $u->setCpf($user["cpf"]);
                $u->setName($user["name"]);
                $u->setSurname($user["surname"]);
                $u->setAddress($user["address"]);
                $u->setTelephone($user["telephone"]);
                $u->setResidentialPhone($user["residential_phone"]);
                $array[] = $u;
            }
            return $array;
        }
        return false;
    }

    /**
     * @param String $cep
     * @return mixed
     */
    public function findByCEP(string $cep)
    {
        $array = [];
        $cep = addslashes(trim($cep));
        $sql = "SELECT * FROM crdv_users WHERE address LIKE '%$cep%'";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        if($statement->rowCount() > 0){
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $user){
                $u = new User();
                $u->setId($user["id"]);
                $u->setEmail($user["email"]);
                $u->setCpf($user["cpf"]);
                $u->setName($user["name"]);
                $u->setSurname($user["surname"]);
                $u->setAddress($user["address"]);
                $u->setTelephone($user["telephone"]);
                $u->setResidentialPhone($user["residential_phone"]);
                $array[] = $u;
            }
            return $array;
        }
        return false;
    }

    /**
     * @param User $u
     * @return mixed
     */
    public function update(User $u) : bool
    {

            $sql = "UPDATE crdv_users SET 
                `email` = COALESCE(NULLIF(?,''),`email`),
                `password` = COALESCE(NULLIF(?,''),`password`),
                `name` = COALESCE(NULLIF(?,''),`name`),
                `surname` = COALESCE(NULLIF(?,''),`surname`),
                `cpf` = COALESCE(NULLIF(?,''),`cpf`),
                `cnpj` = COALESCE(NULLIF(?,''),`cnpj`),
                `social_reason` = COALESCE(NULLIF(?,''),`social_reason`),
                `state_registration` = COALESCE(NULLIF(?,''),`state_registration`),
                `address` = COALESCE(NULLIF(?,''),`address`), 
                `telephone` = COALESCE(NULLIF(?,''),`telephone`),
                `residential_phone` = COALESCE(NULLIF(?,''),`residential_phone`)
                WHERE `id` = ?";
            $statement = $this->pdo->prepare($sql);
            $statement->execute([
                $u->getEmail(),
                $u->getPassword(),
                $u->getName(),
                $u->getSurname(),
                $u->getCpf(),
                $u->getCnpj(),
                $u->getSocialReason(),
                $u->getStateRegistration(),
                $u->getAddress(),
                $u->getTelephone(),
                $u->getResidentialPhone(),
                $u->getId()
            ]);
            if($statement->rowCount() > 0){
                return true;
            }
            return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete(String $id) : bool
    {
        $id = filter_var($id, FILTER_VALIDATE_INT);
        $sql = "DELETE FROM crdv_users WHERE `id` = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);
        if($statement->rowCount() == 1){
            return true;
        }
        return false;
    }

    /**
     * 
     * @param String $email
     * @param String $password
     * @return mixed Return an array with 2 indexes if the login is successfully, the first is userPrivilege, and the second True. Return false if login failed.
     */
    public function login(String $email, String $password)
    {
        $results = array();
        $password = config::getKey().addslashes(trim($password));
        $sql = "SELECT `id`,`name`,`email`,`password`,`userLevel` FROM `crdv_users` WHERE `email` = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([$email]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if(!$data){
            return false;
        }
        $result = password_verify($password,$data["password"]);
        if($statement->rowCount() == 1){
            if($result){
                array_push($results, $data["userLevel"], $data["name"], true, $data["id"]);
                return $results;
            }
        }
        return false;
    }
}