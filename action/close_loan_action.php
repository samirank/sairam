<?php
session_start();
include('../class/update.php');
include('../class/insert.php');
include('../class/view.php');
$insert = new insert();
$update = new update();
$display = new display();
if (isset($_POST['close_loan'])) {
	$loan_id = $_POST['close_loan_id'];
	$mem_id = $_POST['mem_id'];
	$loan_no = $display->get_loan_no($loan_id);
	$member_name = $display->get_member_name($mem_id);
	$closed_by = $_SESSION['login_id'];
	$staff_name = $display->get_staff_name($closed_by);
	$time = date('d-M-Y', time());

	$insert_err = 1;
	$insert_msg = "Failed to close loan. Please contact admin.";

	if ($insert->loan_closing($loan_id,$closed_by)) {
		if ($update->close_loan($loan_id)) {
			$insert_err = 0;
			$insert_msg = "Loan closed successfully.";
		}
	}
	$insert->close_loan_msg($closed_by,$loan_id,$member_name,$staff_name,$time,$mem_id,$loan_no);
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);

	$_SESSION['msg'] = $msg;
	$update->refresh_member_status($mem_id);
	header("location:../profile.php?mem=".$mem_id."&loan=".$loan_id);
}
?>