<?php

namespace data;

if (!isset($DB)) {
    $DB = new DBconfig();
}

class DBconfig {

    public static $DB_CONNSTRING = null;
    public static $DB_USERNAME = null;
    public static $DB_PASSWORD = null;

    function __construct() {
        define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
        define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
        define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
        define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
        define('DB_NAME', getenv('OPENSHIFT_APP_NAME'));

        $mysqlCon = mysqli_connect(DB_HOST, DB_USER, DB_PASS, "", DB_PORT) or die("Error: " . mysqli_error($mysqlCon));
        mysqli_select_db($mysqlCon, DB_NAME) or die("Error: " . mysqli_error($mysqlCon));
    }

}

/* class DBConfig {

    public static $DB_CONNSTRING = "mysql:host=localhost;dbname=pizzashop";
    public static $DB_USERNAME = "root";
    public static $DB_PASSWORD = "";
    public $dbh; // handle of the db connexion
    private static $instance;

    private function __construct() {
        $this->dbh = new PDO(self::$DB_CONNSTRING, self::$DB_USERNAME, self::$DB_PASSWORD);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

}
*/