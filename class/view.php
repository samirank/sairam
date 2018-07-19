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

// Function to display current balance
  function display_current_balance($account_no){
    $mysqli = $this->mysqli;
    $sql = "SELECT SUM(amount) AS 'current_balance' FROM `deposit` WHERE account_no='$account_no';";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }

  // Total number of members
  function total_members(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(account_no) AS total FROM members";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

  // Total number of loans
  function total_loans(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(loan_id) AS total FROM loans";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

  // Total number of agents
  function total_agents(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(agent_id) AS total FROM agents";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

  // Total new notification
  function total_new_messages(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(msg_id) AS total FROM messages where status='unread'";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }


// End of class 
}
?>
