<?php 
session_start();
include ('../class/insert.php');
include ('../class/update.php');
include ('upload.php');

$insert = new insert();
$update = new update();

$upload_err = 0;
$upload_msg = null;
$insert_msg = "Loan added successfully";
$insert_err = 0;

if (isset($_POST['new_loan'])) {
	print_r($_POST);
	$installment = $_POST['installment'];
	$period = $_POST['period'];
	$mode = $_POST['mode'];
	$rate_of_interest = $_POST['rate_of_interest'];
	$interest_calculated = $_POST['interest_calculated'];
	$guarantor_name = $_POST['guarantor_name'];
	$security_particulars = $_POST['security_particulars'];
	$loan_purpose = $_POST['loan_purpose'];
	$loan_no = $_POST['loan_no'];
	$loan_date = $_POST['loan_date'];
	$loan_date = date("Y-m-d", strtotime($loan_date));
	$closing_date = $_POST['closing_date'];
	$closing_date = date("Y-m-d", strtotime($closing_date));
	$loan_amt = $_POST['loan_amt'];
	$mem_id = $_POST['mem_id'];
	$interest_amount = $_POST['interest'];
	$added_by = $_SESSION['login_id'];
	$photo = NULL;
	$signature = NULL;

  // New member
	if (empty($_POST['mem_id'])) {
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

		$new_mem_id = $insert->add_membership($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $joining_agent, $added_by, $photo, $signature);
		if(!$new_mem_id){
			$insert_msg = "Unable to add member please check the data you have entered.";
			$insert_err=1;
		}
		$mem_id = $new_mem_id;
		echo $new_mem_id;
	}



	if ($mem_id) {
		 // Upload photo and signature
		!empty($_FILES['photograph']['name']) ? upload_photo($mem_id) : $photo = null;
		!empty($_FILES['signature']['name']) ? upload_signature($mem_id) : $signature = null;
		if(!is_null($photo)){ $update->change_member_photo($mem_id,$photo); }
		if(!is_null($signature)){ $update->change_member_signature($mem_id,$signature); }

		$loan_id = $insert->new_loan($loan_no,$mem_id,$installment,$period,$mode,$rate_of_interest,$interest_calculated,$guarantor_name,$security_particulars,$loan_purpose,$loan_date,$closing_date,$added_by,$loan_amt,$interest_amount);
		if(!loan_id){
			$insert_msg = "Unable to create loan please check the data you have entered.";
			$insert_err=1;
		}
	}else{
		$insert_msg = "Unable to add member please check the data you have entered.";
		$insert_err=1;
	}

	if ($insert_err==0) {
		$insert_msg = $insert_msg." <a href='profile.php?mem=".$mem_id."&loan=".$loan_id."'>Click here to view loan.</a>";
	}


	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
		'upload_err' => $upload_err,
		'upload_msg' => $upload_msg
	);
	$_SESSION['msg'] = $msg;
	$update->refresh_member_status($mem_id);
	header("location: ../newloan.php");
}
?>