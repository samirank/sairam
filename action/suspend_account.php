<?php session_start();
include('../class/update.php');
$update = new update();
if (isset($_POST['suspend_account'])) {
	$user_id = $_POST['user_id'];

	$insert_err = 1;
	$insert_msg = "Failed to suspend accouont";

	if ($update->suspend_account($user_id)=="active") {
		$insert_err = 0;
		$insert_msg = "Account suspended";
	}else {
		$insert_err = 0;
		$insert_msg = "Account activated";
	}
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location:../profile.php?staff=".$user_id);
}
?>