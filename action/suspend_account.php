<?php session_start();
include('../class/update.php');
$update = new update();
if (isset($_POST['suspend_account'])) {
	$user_id = $_POST['user_id'];
	if ($update->suspend_account($user_id)) {
	
	}
}
?>