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
  function current_balance($acc_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT SUM(amount) AS 'total_deposit' FROM `deposit` WHERE acc_id='$acc_id';";
    $total_deposit = mysqli_fetch_array($mysqli->query($sql));
    $total_deposit = $total_deposit['0'];
    $sql = "SELECT SUM(amount) AS 'total_withdraw' FROM `withdrawals` WHERE acc_id='$acc_id';";
    $total_withdraw = mysqli_fetch_array($mysqli->query($sql));
    $total_withdraw = $total_withdraw['0'];

    $current_balance = $total_deposit - $total_withdraw;
    return $current_balance;
  }

  // Total number of members
  function total_members(){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(mem_id) AS total FROM members";
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
  function total_new_messages($user_id,$role){
    $mysqli = $this->mysqli;
    $val = $this->get_unread_msg($user_id,$role);
    return mysqli_num_rows($val);
  }

  // Total existing loan of a member
  function existingloans($mem_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT mem_id from loans where mem_id='$mem_id'";
    return mysqli_num_rows($mysqli->query($sql));
  }

  // Total active loan of a member
  function activeloans($mem_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT mem_id from loans where mem_id='$mem_id' AND status='active'";
    return mysqli_num_rows($mysqli->query($sql));
  }

  // Display all loans
  function disp_all_loans(){
    $mysqli = $this->mysqli;
    $sql = "SELECT loans.loan_amount,loans.interest_amount,loans.loan_no,loans.installment,loans.loan_id,loans.mem_id,loans.status,loans.loan_date,members.member_name FROM loans JOIN members ON loans.mem_id=members.mem_id WHERE 1";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }

// Get member name from account no
  function get_member_name($id){
    $mysqli = $this->mysqli;
    $sql  = "SELECT member_name from members where mem_id='$id'";
    $val = $mysqli->query($sql);
    $val = mysqli_fetch_assoc($val);
    $val = $val['member_name'];
    if ($val){
     return $val;
   }else {
    return "Unknown";
  }
}

  // Get staff name from user_id
function get_staff_name($id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT name from users where user_id='$id'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['name'];
  if ($val){
   return $val;
 }else {
  return "Unknown";
}
} 

// Get loan number
function get_loan_no($loan_id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT loan_no from loans where loan_id='$loan_id'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['loan_no'];
  if ($val){
   return $val;
 }else {
  return "Unknown";
}
}

// Get member photo from account no
function get_member_photo($id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT photo from members where mem_id='$id'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['photo'];
  if (!empty($val)){
   return $val;
 }else {
  return "assets/img/profile-placeholder.jpg";
}
}
// Get member signature from account no
function get_member_signature($id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT signature from members where mem_id='$id'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['signature'];
  if (!empty($val)){
   return $val;
 }else {
  return "assets/img/placeholder-signature.jpg";
}
}

// Get member joining date
function get_joining_date($acc_id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT joining_date from deposit_accounts where acc_id='$acc_id'";
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
  $sql = "SELECT * FROM deposit_accounts WHERE status='active';";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }else{
    die($mysqli->error);
  }
}

// List of list of closing dates of active loans
function get_active_loans(){
  $mysqli = $this->mysqli;
  $sql = "SELECT loan_id,loan_no,mem_id,closing_date FROM loans WHERE status='active';";
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
  if($role=="admin"){
    $sql = "SELECT * FROM `messages` WHERE `to` IN ('all','admin','$user_id') AND NOT msg_id IN (SELECT msg_id FROM msg_status WHERE user_id='$user_id') ORDER BY `msg_id` DESC;";
  }
  if($role=="staff"){
    $sql = "SELECT * FROM `messages` WHERE `to` IN ('all','staff','$user_id') AND NOT msg_id IN (SELECT msg_id FROM msg_status WHERE user_id='$user_id') ORDER BY `msg_id` DESC;";
  }
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }else{
    die($mysqli->error);
  } 
}

// Display all messages
function disp_all_msg($user_id,$role){
  $mysqli = $this->mysqli;
  if($role=="admin"){
    $sql = "SELECT * FROM `messages` WHERE `to` IN ('all','admin','$user_id') ORDER BY `msg_id` DESC;";
  }
  if($role=="staff"){
    $sql = "SELECT * FROM `messages` WHERE `to` IN ('all','staff','$user_id') ORDER BY `msg_id` DESC;";
  }
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }else{
    die($mysqli->error);
  } 
}


// Get user name, takes user id as argument, returns username
function get_user_name($id){
  $mysqli = $this->mysqli;
  $sql = "SELECT user_name FROM users WHERE user_id = '$id'";
  $val = $mysqli->query($sql);
  if (mysqli_num_rows($val)==1) {
    $val = mysqli_fetch_assoc($val);
    return $val['user_name'];
  }else{
    return false;
  }
}

// Format date to DD-MMM-YYYY
function date_dmy($date){
  return date("d-M-Y", strtotime($date));
}

// Format date to YYYY-MM-DD
function date_ymd($date){
  return date("Y-m-d", strtotime($date));
}

// Account closed by
function account_closed_by($acc_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT closed_by FROM closings WHERE acc_id='$acc_id'";
  $staff_id = mysqli_fetch_assoc($mysqli->query($sql));
  $staff_id = $staff_id['closed_by'];
  $staff_name = $this->get_user_name($staff_id);
  return $staff_name;
}

// Account closed by
function loan_closed_by($loan_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT closed_by FROM loan_closings WHERE loan_id='$loan_id'";
  $staff_id = mysqli_fetch_assoc($mysqli->query($sql));
  $staff_id = $staff_id['closed_by'];
  $staff_name = $this->get_user_name($staff_id);
  return $staff_name;
}

// All deposit accounts
function deposit_accounts(){
  $mysqli = $this->mysqli;
  $sql = "SELECT * FROM deposit_accounts";
    return $mysqli->query($sql);
}
// All active accounts
function active_deposit_accounts(){
  $mysqli = $this->mysqli;
  $sql = "SELECT * FROM deposit_accounts WHERE status='active'";
    return $mysqli->query($sql);
}

// Get loan report
function get_loan_report($loan_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT * FROM loan_payments WHERE loan_id='$loan_id' ORDER BY date_of_payment ASC";
  return $mysqli->query($sql);
}

// Get Deposit report
function get_deposit_report($acc_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT * FROM deposit WHERE acc_id='$acc_id' ORDER BY date_of_payment ASC";
  return $mysqli->query($sql);
}
// End of class 
}
?>
