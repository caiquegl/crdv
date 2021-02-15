<?php

namespace CRDV\Model\Database;

require dirname(__DIR__,3)."/vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use CRDV\Model\Database\MySQLConnection;

class MySQLConnectionTest extends TestCase{

    public function assertPreConditions() : void{
        $this->assertTrue(class_exists("CRDV\Model\Database\MySQLConnection"),"A Classe MySQLConnection não existe.");
    }

    public function testConnection(){
        $con = new MySQLConnection();
        $con = $con->connect();
        $this->assertIsObject($con);
    }
}