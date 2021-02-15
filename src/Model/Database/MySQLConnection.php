<?php 

namespace CRDV\Model\Database;

require dirname(__DIR__,3)."/vendor/autoload.php";

use PDO;
use PDOException;

class MySQLConnection extends DBCredentials implements DBConnectionInterface{
    protected static String $host;
    protected static String $user;
    protected static String $passwd;
    protected static String $database;
    protected static String $charset;

    private static function setCredentials(){
        parent::getCredentials();
        self::$host = parent::$host;
        self::$user = parent::$user;
        self::$passwd = parent::$pass;
        self::$database = parent::$dbName;
        self::$charset = parent::$charset;
    }

    public static function connect() : PDO{
        try{
            self::setCredentials();
            $con = new PDO("mysql:host=".self::$host.";dbname=".self::$database.";charset=".self::$charset,self::$user,self::$passwd);
            return $con;
        } catch (PDOException $e){
            throw new PDOException($e->getMessage());
        }
    }
}