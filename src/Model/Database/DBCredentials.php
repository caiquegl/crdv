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
        self::$host = "ao9moanwus0rjiex.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
        self::$user = "ebgkuji0hwhxlcro";
        self::$pass = "nl5vbvndn1uztimm";
        self::$dbName = "z1a53ktwv8mz58re";
        self::$port = 3306;
        self::$charset = "utf8";

    }


}