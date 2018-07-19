<?php
session_start();
include ('../class/insert.php');
if (isset($_POST['add_staff'])) {
	$name = $_POST['name'];
	$user_name = $_POST['user_name'];
	$password = $_POST['password'];
	$encpassword=md5(md5($password));
	$staff_phone = $_POST['staff_phone'];
	$address = $_POST['address'];

	$insert_err = 1;
	$insert_msg = "Failed to create staff account";

	$create = new insert();
	$result = $create->add_staff($name, $user_name, $encpassword, $staff_phone, $address);

	if($result){
		$insert_err = 0;
		$insert_msg = "Staff added successfully";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location:../profile.php?staff=".$result);
}
?>
