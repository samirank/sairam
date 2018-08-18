<?php session_start();
include("../class/update.php");
$update = new update();
if (isset($_POST['edit_deposit'])) {
	print_r($_POST);

	$account_no = $_POST['account_no'];
	$installment = $_POST['installment'];
	$mode = $_POST['mode'];
	$period = $_POST['period'];
	$nominee_name = $_POST['nominee_name'];
	$nominee_age = $_POST['nominee_age'];
	$relationship = $_POST['relationship'];
	$joining_date = $_POST['joining_date'];
	$joining_date = date('Y-m-d', strtotime($joining_date));
	$rate_of_interest = $_POST['rate_of_interest'];
	$acc_id = $_POST['acc_id'];
	$mem_id = $_POST['mem_id'];

	if ($update->edit_acc($account_no, $installment, $mode, $period, $nominee_name, $nominee_age, $relationship, $joining_date, $acc_id, $mem_id, $rate_of_interest)) {
		$insert_msg = "Account details successfully updated.";
		$insert_err = 0;
	}else{
		$insert_msg = "Update failed.";
		$insert_err = 1;
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$mem_id."&acc=".$acc_id);
}
?>