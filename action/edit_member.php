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
	$f_h_name = $_POST['f_h_name'];
	$present_address = $_POST['present_address'];
	$present_pincode = $_POST['present_pincode'];
	$permanent_address = $_POST['permanent_address'];
	$permanent_pincode = $_POST['permanent_pincode'];
	$occupation = $_POST['occupation'];
	$member_phone = $_POST['member_phone'];
	$current_agent = $_POST['current_agent'];
	$mem_id = $_POST['mem_id'];


	$insert_err = 1;
	$insert_msg = "Failed to update account";

	if ($update->edit_member($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $current_agent, $mem_id)) {
		$insert_err = 0;
		$insert_msg = "Account details updated successfully";
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err
	);
	$_SESSION['msg'] = $msg;
	header("location: ../edit.php?mem=".$mem_id);

}

?>