<?php 
include('class/view.php');
include('class/insert.php');
include('class/update.php');

$display = new display();
$insert = new insert();
$update = new update();

// Deposit account maturity notifier
function maturity_notif(){
	$display = $GLOBALS['display'];
	$insert = $GLOBALS['insert'];
	$result = $display->get_maturity_list();
	while ($row = mysqli_fetch_assoc($result)) {
		$datetime1 = date_create(date('Y-m-d'));
		$datetime2 = date_create($row['closing_date']);
		$interval = date_diff($datetime1, $datetime2);
		$diff = $interval->format('%R%a')."<br>";
		$diff = (int)$diff;
		if (($diff>0)&&($diff<=15)) {
			$cond = "sub='Maturity alert (Ac.No. ".$row['account_no'].")'";
			if (mysqli_num_rows($display->disp_cond("messages",$cond))==0) {
				$msg = "The account of member ".$row['member_name']." (account number ".$row['account_no'].") will be closed on ".$row['closing_date'].".";
				$sub = "Maturity alert (Ac.No. ".$row['account_no'].")";
				$insert->maturity_alert($row['account_no'],$sub,$msg);
			}
		}
	}
}
maturity_notif();

?>