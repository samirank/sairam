<?php 
include_once ('config.php');
class update extends dbconnect {
	function __construct() {
		$connect      = new dbconnect();
		$this->mysqli = $connect->con();
	}

  // Upload agent pic
	function upload_agent_pic($agent_id,$agent_photograph){
		$mysqli = $this->mysqli;
		$sql = "UPDATE agents SET profile_pic='$agent_photograph' WHERE agent_id='$agent_id'";
		if($mysqli->query($sql)){
			return true;
		}else{
			echo $mysqli->error;
		}
	}

	// Update member photo
	function change_member_photo($account_no,$photo){
		$mysqli = $this->mysqli;
		$sql = "UPDATE members SET photo='$photo' WHERE account_no='$account_no'";
		if($mysqli->query($sql)){
			return true;
		}else{
			echo $mysqli->error;
		}	
	}

	// Upload signature
	function change_member_signature($account_no,$signature){
		$mysqli = $this->mysqli;
		$sql = "UPDATE members SET signature='$signature' WHERE account_no='$account_no'";
		if($mysqli->query($sql)){
			return true;
		}else{
			echo $mysqli->error;
		}	
	}

	// Update staff profile
	function update_staff($name,$user_name,$staff_phone,$address,$user_id){
		$mysqli = $this->mysqli;
		$sql = "UPDATE `users` SET `user_name`='$user_name',`name`='$name',`phone`='$staff_phone',`address`='$address' WHERE `user_id`='$user_id'";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}	
	}

	// Change rate of interest
	function change_interest($rate,$account_no){
		$mysqli = $this->mysqli;
		$sql = "UPDATE members SET `rate_of_interest`='$rate' WHERE `account_no`='$account_no';";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Change Password
	function change_password($pass,$user_id){	
		$mysqli = $this->mysqli;
		$sql = "UPDATE users SET password='$pass' WHERE user_id='$user_id';";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}
	// Suspend account
	function suspend_account($user_id) {
		$mysqli = $this->mysqli;
		$sql = "SELECT status from users WHERE user_id='$user_id';";
		$result = mysqli_fetch_assoc($mysqli->query($sql));
		$status = $result['status'];

		if ($status=="active") {
			$sql = "UPDATE users SET status='suspended' WHERE user_id='$user_id';";
		}else{
			$sql = "UPDATE users SET status='active' WHERE user_id='$user_id';";
		}
		
		if($mysqli->query($sql)){
			return $status;
		}else{
			// echo $mysqli->error;
			return false;
		}	
	}

	// Deactivate agent account
	function deactivate_account($agent_id){
		$mysqli = $this->mysqli;
		$sql = "SELECT status from agents WHERE agent_id='$agent_id';";
		$result = mysqli_fetch_assoc($mysqli->query($sql));
		$status = $result['status'];

		if ($status=="active") {
			$sql = "UPDATE agents SET status='inactive' WHERE agent_id='$agent_id';";
		}else{
			$sql = "UPDATE agents SET status='active' WHERE agent_id='$agent_id';";
		}
		
		if($mysqli->query($sql)){
			return $status;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}


	// Update member profile
	function edit_member($member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $member_phone, $nominee_name, $nominee_age, $relationship, $current_agent, $edit_member, $account_no, $closing_date) {
		$mysqli = $this->mysqli;
		$sql = "UPDATE `members` SET `member_name`='$member_name',`member_age`='$member_age',`father_name`='$father_name',`present_address`='$present_address',`present_pincode`='$present_pincode',`permanent_address`='$permanent_address',`permanent_pincode`='$permanent_pincode',`instalment`='$instalment',`mode`='$mode',`period`='$period',`member_phone`='$member_phone',`nominee_name`='$nominee_name',`nominee_age`='$nominee_age',`relationship`='$relationship',`current_agent`='$current_agent',`last_updated_on`=now(),`closing_date`='$closing_date' WHERE account_no='$account_no'";

		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Update agent profile
	function edit_agent($agent_name, $phno, $email, $address, $age, $agent_id) {
		$mysqli = $this->mysqli;
		$sql = "UPDATE `agents` SET `agent_name`='$agent_name',`phno`='$phno',`address`='$address',`age`='$age',`email`='$email' WHERE agent_id = '$agent_id';";

		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Close loan
	function close_loan($loan_id){
		$mysqli = $this->mysqli;
		$sql = "UPDATE loans SET status='closed',closing_date=now(),last_updated_on=now() WHERE loan_id='$loan_id';";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Update message as read
	function mark_as_read($msg_id){
		$mysqli = $this->mysqli;
		$sql = "UPDATE messages SET status='read' WHERE msg_id='$msg_id';";
		if($mysqli->query($sql)){
			return true;
		}else{
			echo $mysqli->error;
			// return false;
		}
	}

// End of class
}
?>