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

  // Total loans of one agent
  function total_agent_loans($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(loans.loan_id) AS total FROM loans WHERE loans.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

   // Total active loans of one agent
  function total_agent_active_loans($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(loans.loan_id) AS total FROM loans WHERE loans.status='active' AND loans.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  } 

  // Total closed loans of one agent
  function total_agent_closed_loans($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(loans.loan_id) AS total FROM loans WHERE loans.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id') AND NOT loans.status='active';";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }
//All loan accounts of an agent
  function agent_all_loan_acc($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT loan_no, mem_id FROM loans WHERE loans.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    return $mysqli->query($sql);
  }
  // Total deposit accounts of one agent
  function total_agent_deposit_acc($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(deposit_accounts.acc_id) AS total FROM deposit_accounts WHERE deposit_accounts.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

    // Total active deposit accounts of one agent
  function total_agent_active_deposit_acc($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(deposit_accounts.acc_id) AS total FROM deposit_accounts WHERE deposit_accounts.status='active' AND deposit_accounts.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }
    // Total active deposit accounts of one agent
  function total_agent_closed_deposit_acc($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT COUNT(deposit_accounts.acc_id) AS total FROM deposit_accounts WHERE deposit_accounts.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id') AND NOT deposit_accounts.status='active';";
    if ($val = $mysqli->query($sql)) {
      $val = mysqli_fetch_assoc($val);
      return $val['total'];
    }
  }

//All deposit accounts of an agent
  function agent_all_deposit_acc($agent_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT deposit_accounts.account_no, deposit_accounts.mem_id FROM deposit_accounts WHERE deposit_accounts.status='active' AND deposit_accounts.mem_id IN (SELECT `members`.`mem_id` FROM `members` WHERE `members`.`current_agent`='$agent_id');";
    return $mysqli->query($sql);
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
    $sql = "SELECT loans.loan_amount,loans.interest_amount,loans.loan_no,loans.installment,loans.loan_id,loans.mem_id,loans.status,loans.loan_date,loans.closing_date,members.member_name FROM loans JOIN members ON loans.mem_id=members.mem_id WHERE 1";
    if ($val = $mysqli->query($sql)) return $val;
    else {
      echo $mysqli->error;
    }
  }

// Get member name from mem_id
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

// Get agent datewise loan report
function get_agent_datewise_loan_report($date,$agent){
  $mysqli = $this->mysqli;
  $date = date("Y-m-d", strtotime($date));
  $sql = "SELECT loan_payments.loan_id, loans.loan_no, loan_payments.amount, loan_payments.date_of_payment, loans.mem_id FROM loan_payments JOIN loans ON loan_payments.loan_id=loans.loan_id WHERE loan_payments.loan_id IN (SELECT loans.loan_id FROM loans WHERE loans.mem_id IN (SELECT members.mem_id FROM members WHERE members.current_agent='$agent')) AND loan_payments.date_of_payment='$date';";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }
}

// Get agent datewise account deposit report
function get_agent_datewise_account_deposit_report($date,$agent){
  $mysqli = $this->mysqli;
  $date = date("Y-m-d", strtotime($date));
  $sql = "SELECT deposit_accounts.mem_id, deposit_accounts.account_no, deposit.acc_id, deposit.amount, deposit.date_of_payment FROM deposit JOIN deposit_accounts ON deposit.acc_id=deposit_accounts.acc_id WHERE deposit.acc_id IN (SELECT deposit_accounts.acc_id FROM deposit_accounts WHERE deposit_accounts.mem_id IN (SELECT members.mem_id FROM members WHERE members.current_agent='$agent')) AND deposit.date_of_payment='$date'";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }
}

// Get agent datewise account withdrawal report
function get_agent_datewise_account_withdrawal_report($date,$agent){
  $mysqli = $this->mysqli;
  $date = date("Y-m-d", strtotime($date));
  $sql = "SELECT deposit_accounts.mem_id, deposit_accounts.account_no, withdrawals.acc_id, withdrawals.amount, withdrawals.date_of_withdrawal FROM withdrawals JOIN deposit_accounts ON withdrawals.acc_id=deposit_accounts.acc_id WHERE withdrawals.acc_id IN (SELECT deposit_accounts.acc_id FROM deposit_accounts WHERE deposit_accounts.mem_id IN (SELECT members.mem_id FROM members WHERE members.current_agent='$agent')) AND withdrawals.date_of_withdrawal='$date'";
  $val = $mysqli->query($sql);
  if ($val) {
    return $val;
  }
}

  // Get Agent name from agent_id
function get_agent_name($id){
  $mysqli = $this->mysqli;
  $sql  = "SELECT agent_name from agents where agent_id='$id'";
  $val = $mysqli->query($sql);
  $val = mysqli_fetch_assoc($val);
  $val = $val['agent_name'];
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
  return date("d-m-Y", strtotime($date));
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
  $sql = "SELECT deposit.deposit_id AS id, amount AS deposit_amount, NULL AS withdrawal_amount, date_of_payment AS date, staff_id FROM deposit WHERE deposit.acc_id='$acc_id' UNION ALL SELECT withdrawals.withdrawal_id AS id, NULL AS deposit_amount, amount AS withdrawal_amount, date_of_withdrawal AS date, staff_id FROM withdrawals WHERE withdrawals.acc_id='$acc_id' ORDER BY date ASC";
  return $mysqli->query($sql);
}

// Edit deposit details
function get_deposit($deposit_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT `deposit_id`, `acc_id`, `amount`, `date_of_payment`, `inserted_on`, `staff_id` FROM `deposit` WHERE deposit_id='$deposit_id'";
  $res = $mysqli->query($sql);
  if (mysqli_num_rows($res)==0) {
    return false;
  }else{
    return mysqli_fetch_assoc($res);
  }
}
// Edit withdrawal details
function get_withdrawal($withdrawal_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT `withdrawal_id`, `acc_id`, `amount`, `date_of_withdrawal`, `inserted_on`, `staff_id` FROM `withdrawals` WHERE withdrawal_id='$withdrawal_id'";
  $res = $mysqli->query($sql);
  if (mysqli_num_rows($res)==0) {
    return false;
  }else{
    return mysqli_fetch_assoc($res);
  }
}
// End of class 
}
?>
