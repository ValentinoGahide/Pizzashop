<?php

namespace Data;

if (!isset($DB)) {
    $DB = new DBconfig();
}

class DBconfig {

    public static $DB_CONNSTRING = null;
    public static $DB_USERNAME = null;
    public static $DB_PASSWORD = null;

    function __construct() {
        $host = getenv("OPENSHIFT_MYSQL_DB_HOST");
        $port = getenv('OPENSHIFT_MYSQL_DB_PORT');
        DBconfig::$DB_USERNAME = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
        DBconfig::$DB_PASSWORD = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
        DBconfig::$DB_CONNSTRING = "mysql:host=$host;port=$port;dbname=pizzashop";
    }

}
