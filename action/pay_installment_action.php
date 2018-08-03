<?php
session_start();
include('../class/insert.php');
$insert = new insert();
if (isset($_POST['pay_installment'])) {
	print_r($_POST);
	$amount = $_POST['amount'];
	$date = $_POST['date'];
	$loan_id = $_POST['loan_id'];
	$account_no = $_POST['account_no'];
	$staff_id = $_SESSION['login_id'];

	$insert_err = 1;
	$insert_msg = "Failed to pay installment. Please contact admin.";

	if ($insert->new_payment($loan_id,$amount,$staff_id,$date)) {
		$insert_err = 0;
		$insert_msg = "Installment paid successfully.";
	}


	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);

	$_SESSION['msg'] = $msg;
	header("location:../profile.php?mem=".$account_no."&loan=".$loan_id);
}
?>