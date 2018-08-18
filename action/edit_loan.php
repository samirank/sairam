<?php session_start();
include("../class/update.php");
$update = new update();
if (isset($_POST['edit_loan'])) {
	print_r($_POST);

	$loan_no = $_POST['loan_no'];
	$loan_amt = $_POST['loan_amt'];
	$rate_of_interest = $_POST['rate_of_interest'];
	$interest_calculated = $_POST['interest_calculated'];
	$interest = $_POST['interest'];
	$installment = $_POST['installment'];
	$period = $_POST['period'];
	$mode = $_POST['mode'];
	$guarantor_name = $_POST['guarantor_name'];
	$security_particulars = $_POST['security_particulars'];
	$loan_purpose = $_POST['loan_purpose'];
	$loan_date = $_POST['loan_date'];
	$loan_date = date('Y-m-d', strtotime($loan_date));
	$closing_date = $_POST['closing_date'];
	$closing_date = date('Y-m-d', strtotime($closing_date));
	$mem_id = $_POST['mem_id'];
	$loan_id = $_POST['loan_id'];

	if ($update->edit_loan($loan_no, $loan_amt, $rate_of_interest, $interest_calculated, $interest, $installment, $period, $mode, $guarantor_name, $security_particulars, $loan_purpose, $loan_date, $closing_date, $mem_id, $loan_id)) {
		$insert_msg = "Loan details successfully updated.";
		$insert_err = 0;
	}else{
		$insert_msg = "Update failed.";
		$insert_err = 1;
	}

	$msg = array(
		'insert_msg' => $insert_msg,
		'insert_err' => $insert_err,
	);
	$_SESSION['msg'] = $msg;
	header("location: ../profile.php?mem=".$mem_id."&loan=".$loan_id);
}
?>