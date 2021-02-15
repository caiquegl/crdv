<?php
namespace CRDV\Model\UserFunctions;

require dirname(__DIR__,3)."/vendor/autoload.php";

use CRDV\Model\Database\MySQLConnection;
use PHPUnit\Framework\TestCase;

class UserDAOMySQLTest extends TestCase{

    public function assertPreConditions(): void
    {
        $this->assertTrue(class_exists("CRDV\Model\UserFunctions\UserDAOMySQL"));
    }

    public function testFindAllUsersWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $data = $userDAO->findAll();
        var_dump($data);
        $this->assertIsArray($data);
    }

    public function testFindUserByEmailWithMySQL(){
        $email = "mxhugoxm@gmail.com";
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $data = $userDAO->findByEmail($email);
        var_dump($data);
        $this->assertIsObject($data);
    }

    public function testAddUserWithMySQLWillFailOnEmailExisting(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $u = new User();
        $u->setEmail("mxhugoxm@gmail.com");
        $u->setPassword("12345678");
        $u->setName("Hugo Henrique");
        $u->setSurname("Santos Aguiar Campos");
        $u->setAddress("{'cep':49170-000,'rua':'avenida h','numero':24}");
        $u->setTelephone("(79) 9 9123-4567");
        $result = $userDAO->addFisicUser($u);
        var_dump($result);
        $this->assertFalse($result);
    }

    public function testAddUserdFisicWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo::connect());
        $u = new User();
        $u->setEmail("mxhugoxm@gmail.com");
        $u->setPassword("12345678");
        $u->setName("Crux Sacra");
        $u->setCpf("000.000.000-00");
        $u->setSurname("Sit Mihi Lux");
        $u->setAddress("{\"cep\":49170000,\"rua\":\"avenida h\",\"numero\":24}");
        $u->setTelephone("(79) 9 9333-4567");
        $u->setResidentialPhone("");
        $result = $userDAO->addFisicUser($u);
        var_dump($result);
        $this->assertIsObject($result, "Email já existente/Ou falha no SQL");
    }

    public function testAddUserJuridicWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo::connect());
        $u = new User();
        $u->setEmail("mxhugoxm1@gmail.com");
        $u->setPassword("12345678");
        $u->setName("Crux Sacra");
        $u->setCnpj("123456789123456789");
        $u->setStateRegistration("123456789123456");
        $u->setSocialReason("BUAHGEYEHAUY");
        $u->setSurname("Sit Mihi Lux");
        $u->setAddress("{\"cep\":49170000,\"rua\":\"avenida h\",\"numero\":24}");
        $u->setTelephone("(79) 9 9342-4567");
        $u->setResidentialPhone("");
        $result = $userDAO->addJuridicUser($u);
        var_dump($result);
        $this->assertIsObject($result, "Email já existente/Ou falha no SQL");
    }

    public function testFindByIdWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo::connect());
        $id = 12;
        $result = $userDAO->findById($id);
        var_dump($result);
        $this->assertIsObject($result);
    }

    public function testFindByNameWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $name = "Hugo";
        $result = $userDAO->findByName($name);
        var_dump($result);
        $this->assertIsArray($result);
    }

    public function testFindBySurnameWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $surname = "Santos";
        $result = $userDAO->findBySurname($surname);
        var_dump($result);
        $this->assertIsArray($result);
    }

    public function testFindByTelephoneWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $telephone = "(79)";
        $result = $userDAO->findByTelephone($telephone);
        var_dump($result);
        $this->assertIsArray($result);
    }

    public function testFindByCEPWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $cep = "49160000";
        $result = $userDAO->findByCEP($cep);
        var_dump($result);
        $this->assertIsArray($result);
    }

    public function testUpdateWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $u = new User();
        $u->setId(9);
    
        $u->setPassword("12345678");
        $result = $userDAO->update($u);
        var_dump($result);
        $this->assertTrue($result, "Falha no SQL");
    }

    public function testLoginWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $email = "mxhugoxm@gmail.com";
        $password = "12345678";
        $result = $userDAO->login($email,$password);
        var_dump($result);
        $this->assertTrue($result[1], "Falha no SQL");
    }

    public function testDeleteWithMySQL(){
        $pdo = new MySQLConnection();
        $userDAO = new UserDAOMySQL($pdo->connect());
        $id = 23;
        $result = $userDAO->delete($id);
        var_dump($result);
        $this->assertTrue($result,"O dado não pode ser deletado.");
    }
}