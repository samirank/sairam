<?php 
session_start();
include('upload.php');
include('../class/update.php');
$update = new update();

$upload_err = 0;
$upload_msg = "Unable to upload file";

// Change member profile photo
if (isset($_POST['change_member_photo'])) {
	$account_no = $_POST['account_no'];
	!empty($_FILES['photograph']['name']) ? upload_photo($account_no) : $upload_err=1;
	if($upload_err == 0){
		$update->change_member_photo($account_no,$photo);
		$upload_msg = "Member photograph successfully changed";
	}
	$insert_msg = $upload_msg;
	$insert_err = $upload_err;
	$upload_err = 0;
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
		'upload_err' => $upload_err,
		'upload_msg' => $upload_msg
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$account_no);
}


// Change signature
if (isset($_POST['change_signature'])) {
	$account_no = $_POST['account_no'];
	!empty($_FILES['signature']['name']) ? upload_signature($account_no) : $upload_err=1;
	if($upload_err == 0){
		$update->change_member_signature($account_no,$signature);
		$upload_msg = "Member signature successfully changed";
	}
	$insert_msg = $upload_msg;
	$insert_err = $upload_err;
	$upload_err = 0;
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
		'upload_err' => $upload_err,
		'upload_msg' => $upload_msg
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$account_no);
}

// Change agent photo
if (isset($_POST['change_agent_photo'])) {
	$agent_id = $_POST['agent_id'];
	if (!empty($_FILES['photograph']['name'])) {
		upload_agent_photo($agent_id);
	}else{
		$upload_err = 1;
	}
	if($upload_err==0){
		$update->upload_agent_pic($agent_id,$agent_photograph);
	}
	$insert_msg = $upload_msg;
	$insert_err = $upload_err;
	$upload_err = 0;
	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?agent=".$agent_id);
}
?>