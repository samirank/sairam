<?php
session_start();
include('../class/insert.php'); 
$insert = new insert();
if (isset($_POST['make_deposit'])) {
	print_r($_POST);
	$instalment = $_POST['instalment'];
	$date_of_payment = $_POST['date_of_payment'];
	$accno = $_POST['accno'];
	$staff_id = $_SESSION['login_id'];
	if ($insert->make_deposit($instalment,$date_of_payment,$accno,$staff_id)) {
		$insert_msg = "Deposit successful.";
		$insert_err = 0;
	}else{
		$insert_msg = "Deposit failed.";
		$insert_err = 1;
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$accno."&acc=1");
}
?>