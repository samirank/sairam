<?php
date_default_timezone_set('Asia/Kolkata');
class dbconnect extends mysqli {
  protected $DBLOCATION = "localhost";
  protected $DBUSER     = "sairam";
  protected $DBPASS     = "OOFwWpT9q7sSPCxR";
  protected $DBNAME     = "sairam";
  protected $mysqli;
  function __construct() {
    $this->mysqli = new mysqli($this->DBLOCATION, $this->DBUSER, $this->DBPASS, $this->DBNAME);
  }
  function con() {
    $mysqli       = $this->mysqli;
    if ($mysqli->connect_error) {
      echo "Connection error" . $mysqli->connect_error;
    }
    else {
      return $mysqli;
    }
  }
}
$connect = new dbconnect();
$connect->con();
?>