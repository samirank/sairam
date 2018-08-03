<?php
session_start();
include('../class/update.php');
include('../class/view.php');
$update = new update();
$display = new display();
if (isset($_POST['close_loan'])) {
	$loan_id = $_POST['close_loan_id'];
	$account_no = $_POST['account_no'];

	$insert_err = 1;
	$insert_msg = "Failed to close loan. Please contact admin.";

	if ($update->close_loan($loan_id)) {
		$insert_err = 0;
		$insert_msg = "Loan closed successfully.";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);

	$_SESSION['msg'] = $msg;
	header("location:../profile.php?mem=".$account_no."&loan=".$loan_id);
}
?>