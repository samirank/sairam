<?php include('template/head.php'); ?>
<?php include('class/view.php');
include('class/update.php');
$display = new display();
$update = new update();

if($_SESSION['login_role']=="staff"){

	// Uncomment to allow staff to edit member profile
	// if (isset($_GET['mem'])) {
	// 	$profile_type = "member";
	// 	$profile_id = $_GET['mem'];
	// }else{
	$profile_type = "staff";
	$profile_id = $_SESSION['login_id'];
	// }
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

$json = array('user_id' => $profile_id);
$json = json_encode($json);
?>









<?php if ($profile_type=="staff"): ?>
	<?php 
	$cndtn = "user_id=".$profile_id;
	$result = $display->disp_cond("users", $cndtn);
	$row = mysqli_fetch_assoc($result);
	?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="dashboard.php">Dashboard</a>
		</li>
		<?php if ($_SESSION['login_role']=="admin"): ?>
			<li class="breadcrumb-item">
				<a href="viewstaff.php">All staff</a>
			</li>
		<?php endif ?>
		<li class="breadcrumb-item active">Edit staff account</li>
	</ol>



	<?php if (isset($_SESSION['msg'])): ?>
		<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
		<!-- Insert message -->
		<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
			<?php echo $msg['insert_msg']; ?>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			</button>
		</div>
	<?php endif ?>



	<div class="card card-register mx-auto mt-5 border-primary">
		<div class="card-header bg-primary-light-2">Edit staff account</div>
		<div class="card-body">
			<form action="action/editstaff.php" method="POST">
				<div class="form-group">
					<div class="form-row">
						<label for="inputName">Name</label>
						<input name="name" class="form-control" id="inputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" value="<?php echo $row['name']; ?>" autofocus>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<label for="inputUsername">Username</label>
						<input name="user_name" class="form-control" id="inputUsername" type="text" aria-describedby="nameHelp" placeholder="Enter user name" data-validation="required alphanumeric server" data-validation-param-name="change_username" data-validation-req-params='<?php echo $json; ?>' data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower" value="<?php echo $row['user_name']; ?>">
					</div>
				</div>

				<!-- Phone -->
				<div class="form-group">
					<div class="form-row">
						<label for="phno">Phone</label>
						<input class="form-control" data-validation="required number length server" data-validation-param-name="change_staff_phone" data-validation-req-params='<?php echo $json; ?>'	 data-validation-url="action/form_validate.php" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="staff_phone" maxlength="10" value="<?php echo $row['phone']; ?>">
					</div>
				</div>

				<!-- Address -->
				<div class="form-group">
					<div class="form-row">
						<label for="address">Address</label>
						<textarea id="address" name="address" class="form-control" data-validation="required" data-validation-error-msg="Please enter address"><?php echo $row['address']; ?></textarea>
					</div>
				</div>
				<input type="hidden" name="edit_staff" value="<?php echo $profile_id; ?>">
				<button type="submit" class="btn btn-primary btn-block"> Submit </button>
			</form>
		</div>
	</div>
<?php endif ?>







<?php include('template/foot.php'); ?>