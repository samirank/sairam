<?php session_start();
include ('../class/update.php');
$update = new update();
if(isset($_POST['change_password'])){
	print_r($_POST);
	$pass = md5($_POST['password']);
	$pass = md5($pass);
	echo $pass;
	$user_id = $_POST['user_id'];
	if ($update->change_password($pass,$user_id)) {
		$insert_msg = "Password changed successfully.";
		$insert_err = 0;
	}else{
		$insert_msg = "Failed to change password";
		$insert_err = 1;
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?".$_POST['role']."=".$user_id);
}
?>