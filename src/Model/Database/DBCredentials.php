<?php

namespace CRDV\Model\Database;

require "../vendor/autoload.php";

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
        self::$host = "162.241.203.66";
        self::$user = "crdvco68_host";
        self::$pass = "mdpxxt199410";
        self::$dbName = "crdvco68_crdv";
        self::$port = 3306;
        self::$charset = "utf8";

    }


}