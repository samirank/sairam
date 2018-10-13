<?php
session_start();
include('../class/insert.php');
include('../class/validate.php');
$validate = new validate();
$insert = new insert();
if (isset($_POST['pay_installment'])) {
	print_r($_POST);
	$amount = $_POST['amount'];
	if (isset($_POST['date'])) {
		$date = date("Y-m-d", strtotime($_POST['date']));
	} else {
		$date = date("Y-m-d");
	}
	$loan_id = $_POST['loan_id'];
	$mem_id = $_POST['mem_id'];
	$staff_id = $_SESSION['login_id'];

	$insert_err = 1;
	$insert_msg = "Failed to pay installment. Please contact admin.";

	if (!$validate->same_day_installment($date,$loan_id)) {
		if ($insert->new_payment($loan_id,$amount,$staff_id,$date)) {
			$insert_err = 0;
			$insert_msg = "Installment paid successfully.";
		}
	}else{
		$insert_msg = "Payment failed. Same date payment not allowed.";
		$insert_err = 1;
	}


	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);

	$_SESSION['msg'] = $msg;
	header("location:../profile.php?mem=".$mem_id."&loan=".$loan_id);
}
?>