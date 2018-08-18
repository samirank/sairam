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
	function change_member_photo($mem_id,$photo){
		$mysqli = $this->mysqli;
		$sql = "UPDATE members SET photo='$photo' WHERE mem_id='$mem_id'";
		if($mysqli->query($sql)){
			return true;
		}else{
			echo $mysqli->error;
		}	
	}

	// Upload signature
	function change_member_signature($mem_id,$signature){
		$mysqli = $this->mysqli;
		$sql = "UPDATE members SET signature='$signature' WHERE mem_id='$mem_id'";
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
	function edit_member($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $current_agent, $mem_id) {
		$mysqli = $this->mysqli;
		$sql = "UPDATE `members` SET `member_name`='$member_name',`member_age`='$member_age',`f_h_name`='$f_h_name',`present_address`='$present_address',`present_pincode`='$present_pincode',`occupation`='$occupation',`permanent_address`='$permanent_address',`permanent_pincode`='$permanent_pincode',`member_phone`='$member_phone',`current_agent`='$current_agent',`last_updated_on`=now() WHERE mem_id='$mem_id'";

		if($mysqli->query($sql)){
			return true;
		}else{
			// die($mysqli->error);
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

	// Edit deposit account
	function edit_acc($account_no, $installment, $mode, $period, $nominee_name, $nominee_age, $relationship, $joining_date, $acc_id, $mem_id, $rate_of_interest){
		$mysqli = $this->mysqli;
		$sql = "UPDATE `deposit_accounts` SET `account_no`='$account_no',`installment`='$installment',`mode`='$mode',`period`='$period',`nominee_name`='$nominee_name',`nominee_age`='$nominee_age',`nominee_relation`='$relationship',`joining_date`='$joining_date',`last_updated`=now(),`rate_of_interest`='$rate_of_interest' WHERE acc_id='$acc_id';";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Edit loan
	function edit_loan($loan_no, $loan_amt, $rate_of_interest, $interest_calculated, $interest, $installment, $period, $mode, $guarantor_name, $security_particulars, $loan_purpose, $loan_date, $closing_date, $mem_id, $loan_id){
		$mysqli = $this->mysqli;
		$sql = "UPDATE `loans` SET `loan_no`='$loan_no',`loan_amount`='$loan_amt',`installment`='$installment',`period`='$period',`mode`='$mode',`rate_of_interest`='$rate_of_interest',`interest_amount`='$interest',`interest_calculated`='$interest_calculated',`guarantor_name`='$guarantor_name',`security_particulars`='$security_particulars',`loan_purpose`='$loan_purpose',`loan_date`='$loan_date',`closing_date`='$closing_date',`last_updated_on`=now() WHERE loan_id='$loan_id';";
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
		$sql = "UPDATE loans SET status='closed',last_updated_on=now() WHERE loan_id='$loan_id';";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Close account
	function close_account_status($acc_id){
		$mysqli = $this->mysqli;
		$sql = "UPDATE deposit_accounts SET status='closed' WHERE acc_id='$acc_id'";
		if($mysqli->query($sql)){
			return true;
		}else{
			// echo $mysqli->error;
			return false;
		}
	}

	// Refresh member status
	function refresh_member_status($mem_id){
		$mysqli = $this->mysqli;
		$active_accounts = mysqli_num_rows($mysqli->query("SELECT acc_id FROM deposit_accounts WHERE mem_id='$mem_id' AND status='active'"));
		$active_loans = mysqli_num_rows($mysqli->query("SELECT loan_id FROM loans WHERE mem_id='$mem_id' AND status='active'"));
		if (($active_accounts==0)&&($active_loans==0)) {
			$sql = "UPDATE members SET status='inactive' WHERE mem_id='$mem_id'";
			if($mysqli->query($sql)){
				return true;
			}else{
			// echo $mysqli->error;
				return false;
			}
		}else{
			$sql = "UPDATE members SET status='active' WHERE mem_id='$mem_id'";
			if($mysqli->query($sql)){
				return true;
			}else{
			// echo $mysqli->error;
				return false;
			}
		}
	}

	// Reopen acc
	function reopen_acc($acc_id){
		$mysqli = $this->mysqli;
		$sql = "DELETE FROM `closings` WHERE `acc_id` = '$acc_id'";
		if ($mysqli->query($sql)) {
			$sql = "UPDATE deposit_accounts SET status='active' WHERE acc_id='$acc_id'";
			if ($mysqli->query($sql)){
				return true;
			}else{
			// echo $mysqli->error;
				return false;
			}
		}else{
			// echo $mysqli->error;
			return false;
		}
	}


// End of class
}
?>