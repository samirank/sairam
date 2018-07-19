<?php
include_once ('config.php');
class insert extends dbconnect {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }
  function add_membership($account_no, $member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature, $joining_agent, $joining_date)
  {
    $mysqli       = $this->mysqli;
    $sql = "INSERT INTO `members`(`account_no`, `member_name`, `member_age`, `father_name`, `present_address`, `present_pincode`, `permanent_address`, `permanent_pincode`, `instalment`, `mode`, `period`, `occupation`, `member_phone`, `nominee_name`, `nominee_age`, `relationship`, `joining_agent`, `current_agent`, `joining_date`, `added_on`, `last_updated_on`, `photo`, `signature`) VALUES ('$account_no','$member_name','$member_age','$father_name','$present_address','$present_pincode','$permanent_address','$permanent_pincode','$instalment','$mode','$period','$occupation','$member_phone','$nominee_name','$nominee_age','$relationship','$joining_agent','$joining_agent','$joining_date',now(),now(),'$photo','$signature')";
    if($mysqli->query($sql)){
      return true;
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
  function make_deposit($instalment,$date_of_payment,$accno,$staff_id){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `deposit`(`account_no`, `amount`, `date_of_payment`, `inserted_on`, `staff_id`) VALUES ('$accno','$instalment','$date_of_payment',now(),'$staff_id')";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

  // New loan
  function new_loan($acc_no,$installment,$period,$mode,$rate_of_interest,$interest_calculated,$guarantor_name,$security_particulars,$loan_purpose,$loan_date,$closing_date,$approved_by,$added_by){
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `loans` (`loan_id`, `acc_no`, `installment`, `period`, `mode`, `rate_of_interest`, `interest_calculated`, `guarantor_name`, `security_particulars`, `loan_purpose`, `loan_date`, `closing_date`, `approved_by`, `added_on`, `last_updated_on`, `added_by`, `status`) VALUES (NULL, '$acc_no', '$installment', '$period', '$mode', '$rate_of_interest', '$interest_calculated', '$guarantor_name', '$security_particulars', '$loan_purpose', '$loan_date', '$closing_date', '$approved_by', now(), now(), '$added_by', 'active')";

    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }
}
?>
