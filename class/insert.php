<?php
include_once ('config.php');
class insert extends dbconnect {
  function __construct() {
    $connect      = new dbconnect();
    $this->mysqli = $connect->con();
  }
  function add_membership($account_no, $member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature)
  {
    $mysqli       = $this->mysqli;
    $sql = "INSERT INTO `members` (`account_no`, `member_name`, `member_age`, `father_name`, `present_address`, `present_pincode`, `permanent_address`, `permanent_pincode`, `instalment`, `mode`, `period`, `occupation`, `member_phone`, `nominee_name`, `nominee_age`, `relationship`, `agent_id`, `photo`, `signature`) VALUES ('$account_no', '$member_name', '$member_age', '$father_name', '$present_address', '$present_pincode', '$permanent_address', '$permanent_pincode', '$instalment', '$mode', '$period', '$occupation', '$member_phone', '$nominee_name', '$nominee_age', '$relationship', '$agent_id', '$photo', '$signature')";
    if($mysqli->query($sql)){
      return true;
    }else{
      // echo $mysqli->error;
      return false;
    }
  }

// Add staff
  function add_staff($name, $user_name, $password)
  {
    $mysqli = $this->mysqli;
    $sql = "INSERT INTO `users` (`user_id`, `name`, `password`, `user_role`, `user_name`, `status`) VALUES (NULL, '$name', '$password', 'staff', '$user_name', 'active')";
    if($mysqli->query($sql)){
      return true;
    }else{
      echo $mysqli->error;
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
}
?>
