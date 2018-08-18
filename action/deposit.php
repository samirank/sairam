<?php
session_start();
include('../class/insert.php'); 
include('../class/validate.php'); 
$insert = new insert();
$validate = new validate();
if (isset($_POST['make_deposit'])) {
	// print_r($_POST);
	$installment = $_POST['installment'];
	$date_of_payment = $_POST['date_of_payment'];
	$date_of_payment = date("Y-m-d", strtotime($date_of_payment));
	$acc_id = $_POST['acc_id'];
	$staff_id = $_SESSION['login_id'];
	
	if (!$validate->same_day_deposit($date_of_payment,$acc_id)) {
		if ($insert->make_deposit($installment,$date_of_payment,$acc_id,$staff_id)) {
			$insert_msg = "Deposit successful.";
			$insert_err = 0;
		}else{
			$insert_msg = "Deposit failed.";
			$insert_err = 1;
		}
	}else{
		$insert_msg = "Deposit failed. Same date deposit not allowed.";
		$insert_err = 1;
	}
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$_POST['mem_id']."&acc=".$acc_id);
}
?>