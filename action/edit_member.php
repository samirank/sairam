<?php 
session_start();
include('../class/update.php');
$update = new update();
include('../class/view.php');
$display = new display();

if (isset($_POST['edit_member'])) {
	print_r($_POST);

	$member_name = $_POST['member_name'];
	$member_age = $_POST['member_age'];
	$father_name = $_POST['father_name'];
	$present_address = $_POST['present_address'];
	$present_pincode = $_POST['present_pincode'];
	$permanent_address = $_POST['permanent_address'];
	$permanent_pincode = $_POST['permanent_pincode'];
	$instalment = $_POST['instalment'];
	$mode = $_POST['mode'];
	$period = $_POST['period'];
	$member_phone = $_POST['member_phone'];
	$nominee_name = $_POST['nominee_name'];
	$nominee_age = $_POST['nominee_age'];
	$relationship = $_POST['relationship'];
	$current_agent = $_POST['current_agent'];
	$edit_member = $_POST['edit_member'];
	$account_no = $_POST['account_no'];
	$joining_date = $display->get_joining_date($account_no);
	$closing_date = date('Y-m-d', strtotime("+".$period." months", strtotime($joining_date)));


	$insert_err = 1;
	$insert_msg = "Failed to update account";

	if ($update->edit_member($member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $member_phone, $nominee_name, $nominee_age, $relationship, $current_agent, $edit_member, $account_no, $closing_date)) {
		$insert_err = 0;
		$insert_msg = "Account details updated successfully";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location: ../edit.php?mem=".$account_no);

}

?>