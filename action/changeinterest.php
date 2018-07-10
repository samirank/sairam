<?php
session_start();
include('../class/update.php');
$update = new update(); 
if (isset($_POST['change_interest'])) {
	$rate = $_POST['rate_of_interest'];
	$account_no = $_POST['account_no'];
	if ($update->change_interest($rate,$account_no)) {
		$insert_msg = "Rate of interest updated.";
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
	header("location: ../profile.php?mem=".$account_no."&acc=1");
}
?>