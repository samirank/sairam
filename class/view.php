<?php
include_once ('config.php');
class display extends dbconnect {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }



  /*
   *To select all the data from any table
  */
  function disp_all($tab_name) {
    $mysqli = $this->mysqli;
    $sql = "SELECT * FROM $tab_name";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }



  /*
   *To select all from a table with a condition
  */
  function disp_cond($tab_name, $cndtn) {
    $mysqli = $this->mysqli;
    $sql = "SELECT * FROM $tab_name WHERE $cndtn";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }
}
?>