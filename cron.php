<?php 
include('class/view.php');
include('class/insert.php');

$display = new display();
$insert = new insert();

// Deposit account maturity notifier
function maturity_notif(){
	$display = $GLOBALS['display'];
	$insert = $GLOBALS['insert'];
	$result = $display->get_maturity_list();
	while ($row = mysqli_fetch_assoc($result)) {
		$closing_date = date('Y-m-d', strtotime("+".$row['period']." months", strtotime($row['joining_date'])));
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create($closing_date);
		$interval = date_diff($datetime1, $datetime2);
		$diff = $interval->format('%R%a')."<br>";
		$diff = (int)$diff;
		if (($diff>0)&&($diff<=15)) {
			$msg = "The account of member ".$display->get_member_name($row['mem_id'])." (account number ".$row['account_no'].") will be closed on ".date('d-m-Y', strtotime($closing_date)).".<br><a href=\'profile.php?mem=".$row['mem_id']."&acc=".$row['acc_id']."\'>Click here to view account</a>";
			$sub = "Maturity alert (Ac.No. ".$row['account_no'].")";
			$insert->maturity_alert($sub,$msg);
		}
	}
}
maturity_notif();

function loan_closing(){
	$display = $GLOBALS['display'];
	$insert = $GLOBALS['insert'];
	$result_loan = $display->get_active_loans();
	while ($row_loan = mysqli_fetch_assoc($result_loan)) {
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create($row_loan['closing_date']);
		$interval = date_diff($datetime1, $datetime2);
		$diff = $interval->format('%R%a')."<br>";
		$diff = (int)$diff;
		if (($diff>0)&&($diff<=15)) {
			$msg = "The loan with loan no ".$row_loan['loan_no']." issued to ".$display->get_member_name($row_loan['mem_id'])." will be closed on ".date('d-m-Y', strtotime($row_loan['closing_date'])).".<br><a href=\'profile.php?mem=".$row_loan['mem_id']."&loan=".$row_loan['loan_id']."\'>Click here to view loan</a>";
			$sub = "Loan closing (".$row_loan['loan_no'].")";
			$insert->maturity_alert($sub,$msg);
		}
	}
}
loan_closing();

?>