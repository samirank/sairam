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

  // Display all loans
  function disp_all_loans(){
    $mysqli = $this->mysqli;
    $sql = "SELECT loans.loan_amount,loans.installment,loans.loan_id,loans.acc_no,loans.status,loans.loan_date,members.member_name FROM loans JOIN members ON loans.acc_no=members.account_no WHERE 1";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }

// Get member name from account no
  function get_member_name($account_no){
    $mysqli = $this->mysqli;
    $sql  = "SELECT member_name from members where account_no='$account_no'";
    $val = $mysqli->query($sql);
    $val = mysqli_fetch_assoc($val);
    $val = $val['member_name'];
    if ($val){
     return $val;
   }else {
    return "Unknown";
  }
}

// Get member joining date
function get_joining_date($account_no){
  $mysqli = $this->mysqli;
  $sql  = "SELECT joining_date from members where account_no='$account_no'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['joining_date'];
  if ($val){
   return $val;
 }else {
  return false;
}
}

// Total loan amount paid
function total_loan_amt_paid($loan_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT SUM(amount) AS 'sum' FROM `loan_payments` WHERE loan_id='$loan_id';";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['sum'];
  if ($val){
    return $val;
  }else {
    return false;
  }
}

// List of list of closing dates of active accounts
function get_maturity_list(){
  $mysqli = $this->mysqli;
  $sql = "SELECT account_no,member_name,closing_date FROM members WHERE status='active';";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }else{
    die($mysqli->error);
  }
}

// Get unread messages
function get_unread_msg($user_id,$role){
  $mysqli = $this->mysqli;
  $sql = "SELECT * from messages where status='unread'";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }else{
    die($mysqli->error);
  } 
}

// End of class 
}
?>
