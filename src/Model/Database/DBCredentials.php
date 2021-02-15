<?php

namespace CRDV\Model\Database;

require dirname(__DIR__,3)."/vendor/autoload.php";

use josegonzalez\Dotenv\Loader as ENV;

abstract class DBCredentials {

    protected static String $host;
    protected static String $user;
    protected static String $pass;
    protected static String $dbName;
    protected static String $port;
    protected static String $charset;

    public static function setEnviroments(){
        $Loader = new ENV(dirname(__DIR__,4).'/.env');
        $Loader = $Loader->parse();
        $Loader = $Loader->toArray();
        return $Loader;
    }

    public static function getCredentials(){
        $env = self::setEnviroments();    
        self::$host = $env["DB_HOST"];
        self::$user = $env["DB_USER"];
        self::$pass = $env["DB_PASS"];
        self::$dbName = $env["DB_NAME"];
        self::$port = $env["DB_PORT"];
        self::$charset = $env["DB_CHARSET"];

    }


}