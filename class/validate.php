<?php
include_once ('config.php');
class validate extends dbconnect {

  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }

// Function to validate login
  function validate_login($user, $pswd) {
    $mysqli = $this->mysqli;
    $u_name = $mysqli->real_escape_string($user);
    $pass   = $mysqli->real_escape_string($pswd);
    $sql    = "SELECT user_id, status FROM users WHERE user_name='$u_name' and password='$pass'";
    $result = $mysqli->query($sql);
    $status = mysqli_fetch_assoc($result);
    $status = $status['status'];
    if (mysqli_num_rows($result) == 1) {
      return $status;
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

  // Same day deposit
  function same_day_deposit($date,$acc_id){
    $mysqli = $this->mysqli;
    $sql    = "SELECT * FROM deposit WHERE date_of_payment='$date' AND acc_id='$acc_id'";
    if (mysqli_num_rows($mysqli->query($sql)) >= 1) {
      return true;
    }
    else {
      return false;
    }
  }
    // Same day withdrawal
  function same_day_withdraw($date,$acc_id){
    $mysqli = $this->mysqli;
    $sql    = "SELECT * FROM withdrawals WHERE date_of_withdrawal='$date' AND acc_id='$acc_id'";
    if (mysqli_num_rows($mysqli->query($sql)) >= 1) {
      return true;
    }
    else {
      return false;
    }
  }

    // Same day installment
  function same_day_installment($date,$loan_id){
    $mysqli = $this->mysqli;
    $sql    = "SELECT * FROM loan_payments WHERE date_of_payment='$date' AND loan_id='$loan_id'";
    if (mysqli_num_rows($mysqli->query($sql)) >= 1) {
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
    $sql    = "SELECT account_no FROM deposit_accounts WHERE account_no='$accno'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }  

  // Function to change account number
  function change_accno($accno,$acc_id){
    $mysqli = $this->mysqli;
    $accno = $mysqli->real_escape_string($accno);
    $sql    = "SELECT account_no FROM deposit_accounts WHERE account_no='$accno' AND NOT acc_id='$acc_id'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }

    // Function to validate loan number
  function validate_loanno($loan_no){
    $mysqli = $this->mysqli;
    $accno = $mysqli->real_escape_string($loan_no);
    $sql    = "SELECT loan_id FROM loans WHERE loan_no='$loan_no'";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }

  // Function to chaneg loan number
  function change_loanno($loan_no,$loan_id){
    $mysqli = $this->mysqli;
    $accno = $mysqli->real_escape_string($loan_no);
    $sql    = "SELECT loan_id FROM loans WHERE loan_no='$loan_no' AND NOT loan_id='$loan_id';";
    if (mysqli_num_rows($mysqli->query($sql)) == 1) {
      return true;
    }
    else {
      return false;
    }
  }



  // Validate staff phone number
  function validate_staff_phone($staff_phone){
   $mysqli = $this->mysqli;
   $staff_phone = $mysqli->real_escape_string($staff_phone);
   $sql    = "SELECT phone FROM users WHERE phone='$staff_phone'";
   if (mysqli_num_rows($mysqli->query($sql)) == 1) {
    return true;
  }
  else {
    return false;
  } 
}

  // Validate staff phone number
function validate_member_phone($member_phone){
 $mysqli = $this->mysqli;
 $member_phone = $mysqli->real_escape_string($member_phone);
 $sql    = "SELECT member_phone FROM members WHERE member_phone='$member_phone'";
 if (mysqli_num_rows($mysqli->query($sql)) == 1) {
  return true;
}
else {
  return false;
} 
}


// Change user name
function change_username($username,$user_id){
  $mysqli = $this->mysqli;
  $username = $mysqli->real_escape_string($username);
  $user_id = $mysqli->real_escape_string($user_id);
  $sql    = "SELECT user_id FROM users WHERE NOT user_id='$user_id' AND user_name='$username'";
  if (mysqli_num_rows($mysqli->query($sql)) == 1) {
    return true;
  }
  else {
    return false;
  }
}

// Validate staff phone number
function change_staff_phone($staff_phone,$user_id){
 $mysqli = $this->mysqli;
 $staff_phone = $mysqli->real_escape_string($staff_phone);
 $sql    = "SELECT phone FROM users WHERE NOT user_id='$user_id' AND phone='$staff_phone'";
 if (mysqli_num_rows($mysqli->query($sql)) == 1) {
  return true;
}else {
  return false;
} 
}

// Validate member phone number
function change_member_phone($member_phone,$user_id){
 $mysqli = $this->mysqli;
 $member_phone = $mysqli->real_escape_string($member_phone);
 $sql    = "SELECT member_phone FROM members WHERE NOT mem_id='$user_id' AND member_phone='$member_phone'";
 if (mysqli_num_rows($mysqli->query($sql)) == 1) {
  return true;
}else {
  return false;
} 
}

// Check if account has active loan
function get_acc_loans($mem_id){
  $mysqli = $this->mysqli;
  $sql = "SELECT loan_id FROM loans WHERE mem_id='$mem_id' AND status='active';";
  if (mysqli_num_rows($mysqli->query($sql))>=1) {
    return true;
  }else{
    return false;
  }
}

// Validate account status
function get_account_status($acc_id){
  $mysqli = $this->mysqli;
  $sql =  "SELECT status FROM deposit_accounts WHERE acc_id='$acc_id';";
  if ($val = $mysqli->query($sql)) {
    $val = mysqli_fetch_assoc($val);
    $val = $val['status'];
    return $val;
  }
  else{
    echo $mysqli->error;
  }
}

// Check if a loan exist
function validate_loan($loan_id){
  $mysqli = $this->mysqli;
  $sql =  "SELECT loan_id FROM loans WHERE loan_id='$loan_id';";
  if (mysqli_num_rows($mysqli->query($sql))==1) {
    return true;
  }else{
    return false;
  }
}

// Check loan status
function check_loan_status($loan_id){
  $mysqli = $this->mysqli;
  $sql =  "SELECT status FROM loans WHERE loan_id='$loan_id';";
  if ($val = $mysqli->query($sql)) {
    $val = mysqli_fetch_assoc($val);
    $val = $val['status'];
    return $val;
  }
}




// End of class
}
?>