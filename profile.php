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
?>



















<?php if ($profile_type=="member"): ?>
	<?php
	$cndtn = "account_no=".$profile_id;
	$result = $display->disp_cond("members", $cndtn);
	// Displays member profile 
	$row = mysqli_fetch_assoc($result);
	?>


	<!-- Display message -->
	<?php if (isset($_SESSION['msg'])): ?>
		<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
		<!-- Insert message -->
		<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
			<?php echo $msg['insert_msg']; ?>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			</button>
		</div>

		<?php if ($msg['upload_err']==1): ?>
			<div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
				<?php echo $msg['upload_msg']; ?>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>
		<?php endif ?>
	<?php endif ?>


	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2">
			<div class="col col-md-4 p-2">
				<?php if ((!empty($row['photo'])) && file_exists($row['photo'])): ?>
				<img class="img-fluid" src="<?php echo $row['photo']; ?>" alt="default profile picture">
				<?php else: ?>
					<img class="img-fluid" src="assets/img/profile-placeholder.jpg" alt="default profile picture">
				<?php endif ?>
			</div>
			<div class="col offset-md-3 col-md-5 p-2 media">
				<?php if ((!empty($row['signature'])) && file_exists($row['signature'])): ?>
				<img class="img-fluid img-thumbnail align-self-end" src="<?php echo $row['signature']; ?>" alt="default profile picture">
				<?php else: ?>
					<img class="img-fluid img-thumbnail align-self-end" src="assets/img/placeholder-signature.jpg" alt="default profile picture">
				<?php endif ?>
			</div>
		</div>
		<div class="row p-2">
			<div class="col"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePhotoModal">Change photo</button></div>
			<div class="col text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeSignatureModal">Change Signature</button>
			</div>
		</div>
		<div class="row p-2">
			<div class="col">Name :</div>
			<div class="col"><b><?php echo $row['member_name']; ?></b></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Account number :</div>
			<div class="col"><b><?php echo $row['account_no']; ?></b></div>
		</div>
		<div class="row p-2">
			<div class="col">Age :</div>
			<div class="col"><?php echo $row['member_age']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Father's name :</div>
			<div class="col"><?php echo $row['father_name']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Present address :</div>
			<div class="col"><?php echo $row['present_address']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col"></div>
			<div class="col">Pin code: <?php echo $row['present_pincode']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Permanent address :</div>
			<div class="col"><?php echo $row['permanent_address']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col"></div>
			<div class="col">Pin code: <?php echo $row['permanent_pincode']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Phone number :</div>
			<div class="col"><?php echo $row['member_phone']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Installment :</div>
			<div class="col">Rs. <?php echo $row['instalment']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Mode :</div>
			<div class="col"><?php echo $row['mode']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Period :</div>
			<div class="col"><?php echo $row['period']; ?> months</div>
		</div>
		<div class="row p-2">
			<div class="col">Occupation :</div>
			<div class="col"><?php echo $row['occupation']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Nominee name :</div>
			<div class="col"><?php echo $row['nominee_name']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Nominee age :</div>
			<div class="col"><?php echo $row['nominee_age']; ?> years</div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Relationship :</div>
			<div class="col"><?php echo $row['relationship']; ?></div>
		</div>
	</div>

	<!-- Change photo modal -->
	<div class="modal fade" id="changePhotoModal" tabindex="-1" role="dialog" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="action/change_image.php" method="POST" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="changePhotoModalLabel">Select profile photo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Photograph -->
						<div class="input-group mb-3">
							<div class="custom-file">
								<input name="photograph" type="file" class="custom-file-input" id="inputGroupFile01">
								<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
						<button type="submit" name="change_member_photo" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Change signature modal -->
	<div class="modal fade" id="changeSignatureModal" tabindex="-1" role="dialog" aria-labelledby="changeSignatureModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="action/change_image.php" method="POST" enctype="multipart/form-data">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="changeSignatureModalLabel">Select Signature</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- Photograph -->
						<div class="input-group mb-3">
							<div class="custom-file">
								<input name="signature" type="file" class="custom-file-input" id="inputGroupFile01">
								<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
						<button type="submit" name="change_signature" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endif ?>













<?php if ($profile_type=="staff"): ?>
	<?php 
	$cndtn = "user_id=".$profile_id;
	$result = $display->disp_cond("users", $cndtn);
	$row = mysqli_fetch_assoc($result);
	?>

	<!-- Display message -->
	<?php if (isset($_SESSION['msg'])): ?>
		<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
		<!-- Insert message -->
		<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
			<?php echo $msg['insert_msg']; ?>
			<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
				<span aria-hidden='true'>&times;</span>
			</button>
		</div>

		<?php if ($msg['upload_err']==1): ?>
			<div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
				<?php echo $msg['upload_msg']; ?>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
			</div>
		<?php endif ?>
	<?php endif ?>

	<div class="row">
		<div class="col offset-md-2">
			<div class="btn-group" role="group">
				<button class="btn btn-primary" type="button" onclick="location.href='edit.php?staff=<?php echo $profile_id; ?>'">Edit profile</button>
				<button class="btn btn-primary">Change password</button>
				<?php if ($_SESSION['login_role']=="admin"): ?>						
					<button class="btn btn-primary">Suspend account</button>
				<?php endif ?>
			</div>	
		</div>
	</div>

	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2">
			<div class="col">Name :</div>
			<div class="col"><b><?php echo $row['name']; ?></b></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Username :</div>
			<div class="col"><?php echo $row['user_name']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Phone :</div>
			<div class="col"><?php echo $row['phone']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Address :</div>
			<div class="col"><?php echo $row['address']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Account status</div>
			<div class="col"><?php echo $row['status']; ?></div>
		</div>
	</div>

<?php endif ?>


<!-- if ($profile_type=="admin") {
$cndtn = "user_id=".$profile_id;
$result = $display->disp_cond("users", $cndtn);

// Displays admin profile
} -->

<?php include('template/foot.php'); ?>