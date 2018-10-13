<?php session_start();
include('../class/insert.php'); 
include('../class/validate.php'); 
$insert = new insert();
$validate = new validate();
if (isset($_POST['withdraw'])) {
	print_r($_POST);
	$amount = $_POST['amount'];
	if (isset($_POST['date_of_withdrawal'])) {
		$date_of_withdrawal = date("Y-m-d", strtotime($_POST['date_of_withdrawal']));
	} else {
		$date_of_withdrawal = date("Y-m-d");
	}
	$acc_id = $_POST['acc_id'];
	$staff_id = $_SESSION['login_id'];
	
	if (!$validate->same_day_withdraw($date_of_withdrawal,$acc_id)) {
		if ($insert->withdraw_money($amount,$date_of_withdrawal,$acc_id,$staff_id)) {
			$insert_msg = "Withdrawal successful.";
			$insert_err = 0;
		}else{
			$insert_msg = "Withdrawal failed.";
			$insert_err = 1;
		}
	}else{
		$insert_msg = "Withdrawal failed. Same date withdrawal not allowed.";
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