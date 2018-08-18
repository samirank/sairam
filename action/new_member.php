<?php session_start();
include ('../class/insert.php');
include ('../class/update.php');
include ('upload.php');

$insert = new insert();
$update = new update();

$upload_err = 0;
$upload_msg = null;
$insert_msg = "Member added successfully";
$insert_err = 0;

if (isset($_POST['new_member'])) {
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
	$joining_agent = $_POST['joining_agent'];
	$added_by = $_SESSION['login_id'];


	$mem_id = $insert->add_membership($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $joining_agent, $added_by, NULL, NULL);
	if ($mem_id) {
		// Upload photo and signature
		!empty($_FILES['photograph']['name']) ? upload_photo($mem_id) : $photo = null;
		!empty($_FILES['signature']['name']) ? upload_signature($mem_id) : $signature = null;
		if(!is_null($photo)){ $update->change_member_photo($mem_id,$photo); }
		if(!is_null($signature)){ $update->change_member_signature($mem_id,$signature); }
	}


	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
		'upload_err' => $upload_err,
		'upload_msg' => $upload_msg
	);
	$_SESSION['msg'] = $msg;
	header("location: ../addmember.php");

}
?>