<?php include('template/head.php'); ?>
<?php include('class/view.php');
include('class/update.php');
$display = new display();
$update = new update();

if($_SESSION['login_role']=="staff"){

	// Uncomment to allow staff to edit member profile
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
	}elseif(isset($_GET['agent'])){
		$profile_type = "agent";
		$profile_id = $_GET['agent'];
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




<?php if ($profile_type=="member"): ?>
	<?php 
	$cndtn = "account_no=".$profile_id;
	$result = $display->disp_cond("members", $cndtn);
	$row = mysqli_fetch_assoc($result);
	?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="dashboard.php">Dashboard</a>
		</li>
		<?php if ($_SESSION['login_role']=="admin"): ?>
			<li class="breadcrumb-item">
				<a href="viewmembers.php">Members</a>
			</li>
		<?php endif ?>
		<li class="breadcrumb-item active">Edit account</li>
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
		<div class="card-header bg-primary-light-2">Edit member account</div>
		<div class="card-body">
			<form action="action/edit_member.php" method="POST">

				<!-- Name -->
				<div class="form-group">
					<div class="form-row">
						<label for="exampleInputName">Name</label>
						<input name="member_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" value="<?php echo $row['member_name']; ?>">
					</div>
				</div>

				<!-- Age -->
				<div class="form-group">
					<div class="form-row">
						<label for="memberAge">Age</label>
						<div class="input-group">
							<input name="member_age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2" value="<?php echo $row['member_age']; ?>">
							<div class="input-group-append">
								<div class="input-group-text">years</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Father's Name -->
				<div class="form-group">
					<div class="form-row">
						<label for="fathersname">Father's name</label>
						<input name="father_name" class="form-control" id="fathersname" type="text" aria-describedby="nameHelp" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" value="<?php echo $row['father_name']; ?>">
					</div>
				</div>

				<!-- Present address -->
				<div class="form-group">
					<div class="form-row">
						<label for="present_address">Present address</label>
						<textarea id="present_address" name="present_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address" ><?php echo $row['present_address']; ?></textarea>
					</div>
				</div>

				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
					</div>
					<input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="present_pincode" type="text" value="<?php echo $row['present_pincode']; ?>" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6">
				</div>

				<!-- Permanent address -->
				<div class="form-group">
					<div class="form-row">
						<br>
						<label for="permanent_address">Permanent address</label>
					</div>
					<div class="form-row">
						<textarea id="permanent_address" name="permanent_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address"><?php echo $row['permanent_address']; ?></textarea>
					</div>
				</div>


				<div class="input-group input-group-sm mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
					</div>
					<input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="permanent_pincode" type="text" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6" value="<?php echo $row['permanent_pincode']; ?>">
				</div>


				<!-- Installment -->
				<div class="form-group">
					<div class="form-row">
						<label for="Installment">Installment</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"> Rs.</div>
							</div>
							<input name="instalment" class="form-control" id="Installment" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount" value="<?php echo $row['instalment']; ?>">
						</div>
					</div>
				</div>


				<!-- Mode of deposit -->
				<div class="form-group">
					<div class="form-row">
						<label for="modeOfInstallment">Mode of deposit</label>
						<div class="input-group">
							<select class="custom-select" name="mode" data-validation="required" data-validation-error-msg="Please select a value">
								<option <?php if($row['mode']=='daily') echo 'selected'; ?> value="daily">Daily</option>
								<option <?php if($row['mode']=='weekly') echo 'selected'; ?> value="weekly">Weekly</option>
								<option <?php if($row['mode']=='monthly') echo 'selected'; ?> value="monthly">Monthly</option>
							</select>
						</div>
					</div>
				</div>


				<!-- Period -->
				<div class="form-group">
					<div class="form-row">
						<label>Period</label>
						<div class="input-group">
							<select class="custom-select" name="period" data-validation="required" data-validation-error-msg="Please select a value">
								<option <?php if($row['period']=='12') echo 'selected'; ?> value="12">12 months</option>
								<option <?php if($row['period']=='24') echo 'selected'; ?> value="24">24 months</option>
								<option <?php if($row['period']=='36') echo 'selected'; ?> value="36">36 months</option>
							</select>
						</div>
					</div>
				</div>


				<!-- Phone -->
				<div class="form-group">
					<div class="form-row">
						<label for="phno">Phone</label>
						<input class="form-control" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="member_phone" maxlength="10" value="<?php echo $row['member_phone']; ?>">
					</div>
				</div>


				<!-- Nominee name -->
				<div class="form-group">
					<div class="form-row">
						<label for="nominee">Nominee name</label>
						<input name="nominee_name" class="form-control" id="nominee" type="text" aria-describedby="nameHelp" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize" data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" value="<?php echo $row['nominee_name']; ?>">
					</div>
				</div>


				<!-- Age of nominee -->
				<div class="form-group">
					<div class="form-row">
						<label for="nomineeAge">Age of the nominee</label>
						<div class="input-group">
							<input name="nominee_age" class="form-control" id="nomineeAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2" value="<?php echo $row['nominee_age']; ?>">
							<div class="input-group-append">
								<div class="input-group-text">years</div>
							</div>
						</div>
					</div>
				</div>


				<!-- Relationship -->
				<div class="form-group">
					<div class="form-row">
						<label for="Relationship">Relationship with applicant</label>
						<div class="input-group">
							<input type="text" class="form-control" id="Relationship" name="relationship" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" data-sanitize="trim capitalize" data-validation-error-msg="Please enter nominee's relationship with the applicant" value="<?php echo $row['relationship']; ?>">
						</div>
					</div>
				</div>


				<!-- Agent -->
				<div class="form-group">
					<div class="form-row">
						<label for="agent">Agent name</label>
						<div class="input-group">
							<select class="form-control" name="current_agent" data-validation="required">
								<?php $display = new display();
								$res_agents = $display->disp_all("agents"); ?>
								<?php while ($row_agents = mysqli_fetch_assoc($res_agents)) { ?>
									<?php if (($row_agents['status']=='active')||($row['current_agent']==$row_agents['agent_id'])): ?>
									<option <?php if($row['current_agent']==$row_agents['agent_id']) echo 'selected'; ?> value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
								<?php endif ?>
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
			<button type="submit" name="edit_member" class="btn btn-primary btn-block"> Submit </button>
		</form>
	</div>
</div>
<?php endif ?>

<?php if ($profile_type=="agent"): ?>
	<?php 
	$cndtn = "agent_id=".$profile_id;
	$result = $display->disp_cond("agents", $cndtn);
	$row = mysqli_fetch_assoc($result);
	?>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
  	<a href="viewagent.php">View agents</a>
  </li>
  <li class="breadcrumb-item active">Edit agent</li>
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
		<div class="card-header bg-primary-light-2">Add new agent</div>
		<div class="card-body">
			<form action="action/editagent.php" method="POST">

				<!-- Name -->
				<div class="form-group">
					<div class="form-row">
						<label for="exampleInputName">Name</label>
						<input name="agent_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" value="<?php echo $row['agent_name']; ?>">
					</div>
				</div>

				<!-- Phone -->
				<div class="form-group">
					<div class="form-row">
						<label for="phno">Phone</label>
						<input class="form-control" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="phno" maxlength="10" value="<?php echo $row['phno']; ?>">
					</div>
				</div>
				
				<!-- Email -->
				<div class="form-group">
					<div class="form-row">
						<label for="exampleInputEmail1">Email address</label>
						<input type="email" name="email" class="form-control" id="exampleInputEmail1" data-validation="required email" aria-describedby="emailHelp" value="<?php echo $row['email']; ?>">
					</div>
				</div>

				<!-- Address -->
				<div class="form-group">
					<div class="form-row">
						<label for="address">Address</label>
						<textarea id="address" name="address" class="form-control" data-validation="required" data-validation-error-msg="Please enter address"><?php echo $row['address']; ?></textarea>
					</div>
				</div>

				<!-- Age -->
				<div class="form-group">
					<div class="form-row">
						<label for="memberAge">Age</label>
						<div class="input-group">
							<input name="age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2" value="<?php echo $row['age']; ?>">
							<div class="input-group-append">
								<div class="input-group-text">years</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Submit -->
				<input type="hidden" name="agent_id" value="<?php echo $row['agent_id']; ?>">
				<button type="submit" name="edit_agent" class="btn btn-primary btn-block"> Submit </button>

			</form>
		</div>
	</div>
<?php endif ?>

<?php include('template/foot.php'); ?>