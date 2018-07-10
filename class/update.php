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

// End of class
}
?>