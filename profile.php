<?php include('template/head.php'); ?>
<?php include('class/view.php');
$display = new display();

if($_SESSION['login_role']=="staff"){
	if (isset($_GET['mem'])) {
		$profile_type = "member";
		$profile_id = $_GET['mem'];
	}else{
		$profile_type = "staff";
		$profile_id = $_SESSION['login_id'];
	}
}
if($_SESSION['login_role']=="admin"){
	if (isset($_GET['mem'])) {
		$profile_type = "member";
		$profile_id = $_GET['mem'];
	}elseif(isset($_GET['staff'])){
		$profile_type = "staff";
		$profile_id = $_GET['staff'];
	}else{
		$profile_type = "admin";
		$profile_id = $_SESSION['login_id'];
	}
}


if ($profile_type=="member") {
	$cndtn = "account_no=".$profile_id;
	$result = $display->disp_cond("members", $cndtn);

	// Displays member profile
}
if ($profile_type=="staff") {
	$cndtn = "user_id=".$profile_id;
	$result = $display->disp_cond("users", $cndtn);

	// Displays Staff profile
}
if ($profile_type=="admin") {
	$cndtn = "user_id=".$profile_id;
	$result = $display->disp_cond("users", $cndtn);

	// Displays admin profile
}

print_r(mysqli_fetch_assoc($result));
?>

<div class="offset-md-2 col-md-8 text-left">



</div>
<?php include('template/foot.php'); ?>