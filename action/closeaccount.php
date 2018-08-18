<?php 
session_start();
print_r($_POST);
include('../class/insert.php');
include('../class/view.php');
include('../class/update.php');
$insert = new insert();
$display = new display();
$update = new update();
if(isset($_POST['closeacc'])){
	$acc_id = $_POST['acc_id'];
	$amount = $_POST['amount'];
	$account_no = $_POST['account_no'];
	$member_name = $_POST['member_name'];
	$staff_id = $_SESSION['login_id'];
	$mem_id = $_POST['mem_id'];
	$staff_name = $display->get_staff_name($_SESSION['login_id']);
	$time = date('d-M-Y', time());

	$insert_err = 1;
	$insert_msg = "Failed to close account. Please contact admin.";
	if ($insert->close_acc($acc_id,$amount,$staff_id)) {
		if ($update->close_account_status($acc_id)) {
			$insert_err = 0;
			$insert_msg = "Account closed";
			$update->refresh_member_status($mem_id);
		}
	}

	$insert->close_acc_msg($staff_id,$acc_id,$account_no,$amount,$member_name,$staff_name,$time,$mem_id);
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location:../profile.php?mem=".$_POST['mem_id']."&acc=".$acc_id);
}
?>