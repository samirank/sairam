<?php 
session_start();
include('../class/update.php');
$update = new update();

if (isset($_POST['edit_agent'])) {
	print_r($_POST);

	$agent_name = $_POST['agent_name'];
	$phno = $_POST['phno'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$age = $_POST['age'];
	$agent_id = $_POST['agent_id'];

	$insert_err = 1;
	$insert_msg = "Failed to update account";

	if ($update->edit_agent($agent_name, $phno, $email, $address, $age, $agent_id)) {
		$insert_err = 0;
		$insert_msg = "Account details updated successfully";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location: ../edit.php?agent=".$agent_id);
}
?>