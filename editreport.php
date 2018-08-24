<?php include('template/head.php'); ?>
<?php include('class/validate.php'); ?>
<?php 
$err = 1;
if (isset($_GET['d'])||isset($_GET['w'])) {
	# code...
}
?>
<?php if ($err==1): ?>
	<!-- Error msg -->
<?php endif ?>
<?php include('template/foot.php'); ?>