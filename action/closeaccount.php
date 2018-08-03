<?php 
session_start();
include('../class/insert.php');
$insert = new insert();
if(isset($_POST['closeacc'])){
	$account_no = $_POST['account_no'];
	$amount = $_POST['amount'];
	$staff_id = $_SESSION['login_id'];

	$insert_err = 1;
	$insert_msg = "Failed to close account. Please contact admin.";

	if ($insert->close_acc($account_no,$amount,$staff_id)) {
		$insert_err = 0;
		$insert_msg = "Account closed";
	}
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location:../profile.php?mem=".$account_no);
}
?>