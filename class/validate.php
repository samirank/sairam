<?php
include ('config.php');
class validate {

  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }

// Function to validate login
  function validate_login($user, $pswd) {
    $mysqli = $this->mysqli;
    $u_name = $mysqli->real_escape_string($user);
    $pass   = $mysqli->real_escape_string($pswd);
    $sql    = "SELECT user_id FROM users WHERE user_name='$u_name' and password='$pass'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }


  // function to validate username
  function validate_username($user) {
    $mysqli = $this->mysqli;
    $u_name = $mysqli->real_escape_string($user);
    $sql    = "SELECT user_id FROM users WHERE user_name='$u_name'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }


  // Function to validate account number
  function validate_accno($accno){
    $mysqli = $this->mysqli;
    $accno = $mysqli->real_escape_string($accno);
    $sql    = "SELECT account_no FROM members WHERE account_no='$accno'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }
}
?>