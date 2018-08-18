<?php
include_once ('config.php');
class insert extends dbconnect {
  function __construct() {
    $connect = new dbconnect();
    $this->mysqli = $connect->con();
  }

  // New member
  function add_membership($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $joining_agent, $added_by, $photo, $signature)
  {
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `members` (`member_name`, `member_age`, `f_h_name`, `present_address`, `present_pincode`, `permanent_address`, `permanent_pincode`, `occupation`, `member_phone`, `joining_agent`, `current_agent`, `added_on`, `added_by`, `last_updated_on`, `status`, `photo`, `signature`) VALUES ('$member_name', '$member_age', '$f_h_name', '$present_address', '$present_pincode', '$permanent_address', '$permanent_pincode', '$occupation', '$member_phone', '$joining_agent', '$joining_agent', now(), '$added_by', now(), 'active', '$photo', '$signature')";
    if($mysqli->query($sql)){
      return $mysqli->insert_id;
    }else{
      echo $mysqli->error;
      die();
      // return false;
    }
  }

  // New deposit accoount
  function new_deposit_acc($account_no, $mem_id, $installment, $mode, $period, $nominee_name, $nominee_age, $nominee_relation, $joining_date, $joining_agent, $added_by){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `deposit_accounts` (`acc_id`,`account_no`, `mem_id`, `installment`, `mode`, `period`, `nominee_name`, `nominee_age`, `nominee_relation`, `joining_date`, `joining_agent`, `added_on`, `added_by`, `last_updated`, `rate_of_interest`, `status`) VALUES (NULL, '$account_no', '$mem_id', '$installment', '$mode', '$period', '$nominee_name', '$nominee_age', '$nominee_relation', '$joining_date', '$joining_agent', now(), '$added_by', now(), NULL, 'active')";
    if($mysqli->query($sql)){
      return $mysqli->insert_id;
    }else{
      echo $mysqli->error;
      die();
      // return false;
    }
  }

// Add staff
  function add_staff($name, $user_name, $password, $staff_phone, $address)
  {
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `users` (`name`, `password`, `user_role`, `user_name` ,`phone`, `address`, `status`) VALUES ('$name', '$password', 'staff', '$user_name', '$staff_phone', '$address', 'active')";
    if($mysqli->query($sql)){
      return $mysqli->insert_id;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }


  // Add agent
  function add_agent($agent_name, $phno, $address, $age, $email)
  {
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `agents` (`agent_name`, `phno`, `address`, `age`, `email`) VALUES ('$agent_name', '$phno', '$address', '$age', '$email')";
    if($mysqli->query($sql)){
      return $mysqli->insert_id;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

  // Make deposit
  function make_deposit($installment,$date_of_payment,$acc_id,$staff_id){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `deposit`(`acc_id`, `amount`, `date_of_payment`, `inserted_on`, `staff_id`) VALUES ('$acc_id','$installment','$date_of_payment',now(),'$staff_id')";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

  // New loan
  function new_loan($loan_no,$mem_id,$installment,$period,$mode,$rate_of_interest,$interest_calculated,$guarantor_name,$security_particulars,$loan_purpose,$loan_date,$closing_date,$added_by,$loan_amt,$interest_amount){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `loans` (`loan_id`, `loan_no`, `mem_id`, `loan_amount`, `installment`, `period`, `mode`, `rate_of_interest`, `interest_amount`, `interest_calculated`, `guarantor_name`, `security_particulars`, `loan_purpose`, `loan_date`, `closing_date`, `added_on`, `last_updated_on`, `added_by`, `status`) VALUES (NULL, '$loan_no', '$mem_id', '$loan_amt', '$installment', '$period', '$mode', '$rate_of_interest', '$interest_amount', '$interest_calculated', '$guarantor_name', '$security_particulars', '$loan_purpose', '$loan_date', '$closing_date', NOW(), NOW(), '$added_by', 'active')";

    if($mysqli->query($sql)){
      return $mysqli->insert_id; 
    }else{
      // die($mysqli->error);
      return false;
    }
  }

// Close account
  function close_acc($acc_id,$amount,$staff_id){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `closings`(`acc_id`, `date_of_closing`, `amount_returned`, `closed_by`) VALUES ('$acc_id',now(),'$amount','$staff_id')";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

// Close loan
  function loan_closing($loan_id,$closed_by){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `loan_closings` (`loan_id`, `date_of_closing`, `closed_by`) VALUES ('$loan_id', now(), '$closed_by')";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

// New loan installment payment function
  function new_payment($loan_id,$amount,$staff_id,$date){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `loan_payments`(`loan_id`, `amount`, `staff_id`, `date_of_payment`, `inserted_on`) VALUES ('$loan_id','$amount','$staff_id','$date',now())";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

  // New maturity alert
  function maturity_alert($sub,$msg){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `messages`(`date`, `time`, `from`, `to`, `sub`, `msg`) VALUES (now(),now(),'SERVER','all','$sub','{$msg}')";
    if($mysqli->query($sql)){
      return true;
    }else{
      echo $msg;
      echo $mysqli->error;
      // return false;
    } 
  }

  // Account closing alert
  function close_acc_msg($staff_id,$acc_id,$account_no,$amount,$member_name,$staff_name,$time,$mem_id){
    $msg = "The account of member ".$member_name." (account number: ".$account_no.") has been closed by ".$staff_name." on ".$time.".<br><a href=\'profile.php?mem=".$mem_id."&acc=".$acc_id."\'>Click here to view account</a>";
    $sub = "Account closed (Ac.No. ".$account_no.")";
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `messages`(`date`, `time`, `from`, `to`, `sub`, `msg`) VALUES (now(),now(),'SERVER','admin','$sub','{$msg}')";
    if($mysqli->query($sql)){
      return true;
    }else{
      echo $msg;
      echo $mysqli->error;
      // return false;
    } 
  }

  // Loan closing alert
  function close_loan_msg($closed_by,$loan_id,$member_name,$staff_name,$time,$mem_id,$loan_no){
    $msg = "The account of member ".$member_name." (loan number: ".$loan_no.") has been closed by ".$staff_name." on ".$time.".<br><a href=\'profile.php?mem=".$mem_id."&loan=".$loan_id."\'>Click here to view account</a>";
    $sub = "Loan closed (Loan.No. ".$loan_no.")";
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `messages`(`date`, `time`, `from`, `to`, `sub`, `msg`) VALUES (now(),now(),'SERVER','admin','$sub','{$msg}')";
    if($mysqli->query($sql)){
      return true;
    }else{
      echo $msg;
      echo $mysqli->error;
      // return false;
    } 
  }

    // Update message as read
  function mark_as_read($msg_id,$user_id){
    $mysqli = $this->mysqli;
    $sql = "SELECT `msg_id` FROM `msg_status` WHERE `user_id`='$user_id' AND `msg_id`='$msg_id';";
    if (mysqli_num_rows($mysqli->query($sql))==0) {
      $sql = "INSERT INTO `msg_status`(`msg_id`, `user_id`) VALUES ('$msg_id','$user_id')";
      if(!$mysqli->query($sql)){
       echo $mysqli->error;
     }
   }
 }

  // End of class
}
?>
