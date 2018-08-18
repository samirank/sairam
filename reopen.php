<?php session_start();
include('class/update.php');
$update = new update();
if ($_SESSION['login_role']=='admin') {
	if ((isset($_GET['acc']))&&(isset($_GET['mem']))) {
		$update->reopen_acc($_GET['acc']);
		header("location:profile.php?mem=".$_GET['mem']."&acc=".$_GET['acc']);
	}
}
?>