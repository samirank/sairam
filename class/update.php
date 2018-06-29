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

}
?>