<?php session_start();
include('../class/update.php');
$update = new update();

if (isset($_POST['deactivate_account'])) {
	$agent_id = $_POST['agent_id'];

	$insert_err = 1;
	$insert_msg = "Failed to suspend accouont";

	if ($update->deactivate_account($agent_id)=="active") {
		$insert_err = 0;
		$insert_msg = "Account deactivated";
	}else {
		$insert_err = 0;
		$insert_msg = "Account activated";
	}
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location:../profile.php?agent=".$agent_id);
}

?>