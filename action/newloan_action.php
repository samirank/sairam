<?php 
session_start();
include('../class/insert.php');
$insert = new insert();
if (isset($_POST['new_loan'])) {
	// var_dump($_POST);
	$installment = $_POST['installment'];
	$period = $_POST['period'];
	$mode = $_POST['mode'];
	$rate_of_interest = $_POST['rate_of_interest'];
	$interest_calculated = $_POST['interest_calculated'];
	$guarantor_name = $_POST['guarantor_name'];
	$security_particulars = $_POST['security_particulars'];
	$loan_purpose = $_POST['loan_purpose'];
	$acc_no = $_POST['acc_no'];
	$loan_date = $_POST['loan_date'];
	$closing_date = $_POST['closing_date'];
	$approved_by = $_POST['approved_by'];
	$loan_amt = $_POST['loan_amt'];
	$added_by = $_SESSION['login_id'];


	$loan_id = $insert->new_loan($acc_no,$installment,$period,$mode,$rate_of_interest,$interest_calculated,$guarantor_name,$security_particulars,$loan_purpose,$loan_date,$closing_date,$approved_by,$added_by,$loan_amt);
	if ($loan_id) {
		$insert_msg = "Loan added successfully";
		$insert_err = 0;
	}else{
		$insert_msg = "Failed to add new loan.";
		$insert_err = 1;
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	if($loan_id){
		header("location: ../profile.php?mem=".$acc_no."&loan=".$loan_id);
	}else{
		header("location: ../newloan.php?acc=".$acc_no);
		//echo "<script>window.history.back();</script>";
	}
}
?>