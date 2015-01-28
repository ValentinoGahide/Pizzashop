<?php

namespace data;

/* if (!isset($DB)) {
  $DB = new DBConfig();
  }

  class DBConfig {

  public static $DB_CONNSTRING = null;
  public static $DB_USERNAME = null;
  public static $DB_PASSWORD = null;

  function __construct() {
  $host = getenv("OPENSHIFT_MYSQL_DB_HOST");
  $port = getenv('OPENSHIFT_MYSQL_DB_PORT');
  DBConfig::$DB_USERNAME = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
  DBConfig::$DB_PASSWORD = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
  DBConfig::$DB_CONNSTRING = "mysql:host=$host;port=$port;dbname=pizzashop";
  }

  }
 */

class DBConfig {

    public static $DB_CONNSTRING = "mysql:host=localhost;dbname=pizzashop";
    public static $DB_USERNAME = "root";
    public static $DB_PASSWORD = "";

}
