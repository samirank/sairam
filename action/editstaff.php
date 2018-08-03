<?php
session_start(); 
include('../class/update.php');
$update = new update();

if (isset($_POST['edit_staff'])) {
	$name = $_POST['name'];
	$user_name = $_POST['user_name'];
	$staff_phone = $_POST['staff_phone'];
	$address = $_POST['address'];
	$user_id = $_POST['edit_staff'];

	$insert_err = 1;
	$insert_msg = "Failed to update account";

	if ($update->update_staff($name,$user_name,$staff_phone,$address,$user_id)) {
		$insert_err = 0;
		$insert_msg = "Account details updated successfully";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location: ../edit.php?staff=".$user_id);

}
?>