<?php

namespace data;

class DBConfig {

    public $dbh; // handle of the db connexion
    private static $instance;

    function __construct() {
        $DB_HOST = getenv('OPENSHIFT_MYSQL_DB_HOST');
        $DB_PORT = getenv('OPENSHIFT_MYSQL_DB_PORT');
        $DB_USER = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
        $DB_PASS = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
        $DB_NAME = getenv('OPENSHIFT_GEAR_NAME');

        $dsn = 'mysql:dbname=' . $DB_NAME . ';host=' . $DB_HOST . ';port=' . $DB_PORT;
        $this->dbh = new PDO($dsn, $DB_USER, $DB_PASS);
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

}

/*
  class DBConfig {

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