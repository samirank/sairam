<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">New loan</li>
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


<?php if (!isset($_GET['acc'])): ?>
	<div class="card card-register mx-auto mt-5 border-primary">
		<div class="card-header bg-primary-light-2">Enter account number</div>
		<div class="card-body">
			<form action="newloan.php" method="GET">

				<!-- Name -->
				<div class="form-group">
					<div class="form-row">
						<label for="exampleInputName">Enter account number</label>
						<input name="acc" class="form-control" id="inputAccno" type="text" aria-describedby="nameHelp" placeholder="12345" data-validation="required number server" data-validation-param-name="deposit_account" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower" autofocus>
					</div>
				</div>
				<!-- Submit -->
				<button type="submit" class="btn btn-primary btn-block"> Submit </button>

			</form>
		</div>
	</div>	
<?php endif ?>

<?php if (isset($_GET['acc'])): ?>
	<?php
	$display = new display();
	$cndtn = "account_no=".$_GET['acc'];
	$result = $display->disp_cond("members", $cndtn);
	// Displays member profile 
	$row = mysqli_fetch_assoc($result);
	?>
	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2">
			<div class="col col-md-4 p-2">
				<?php if ((!empty($row['photo'])) && file_exists($row['photo'])): ?>
				<img style="max-height: 150px;" class="img-fluid" src="<?php echo $row['photo']; ?>" alt="default profile picture">
				<?php else: ?>
					<img style="max-height: 150px;" class="img-fluid" src="assets/img/profile-placeholder.jpg" alt="default profile picture">
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
			<div class="col">Name :</div>
			<div class="col"><b><?php echo $row['member_name']; ?></b></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Account number :</div>
			<div class="col"><b><?php echo $row['account_no']; ?></b></div>
		</div>
<!-- 		<div class="row p-2">
			<div class="col">Age of applicant :</div>
			<div class="col"><?php echo $row['member_age']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Present address :</div>
			<div class="col"><?php echo $row['present_address']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col"></div>
			<div class="col">Pin code: <?php echo $row['present_pincode']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Permanent address :</div>
			<div class="col"><?php echo $row['permanent_address']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col"></div>
			<div class="col">Pin code: <?php echo $row['permanent_pincode']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Father's name :</div>
			<div class="col"><?php echo $row['father_name']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Occupation of applicant :</div>
			<div class="col"><?php echo $row['occupation']; ?></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Applicant's phone number :</div>
			<div class="col"><?php echo $row['member_phone']; ?></div>
		</div> -->
	</div>
	<form action="action/newloan_action.php" method="POST">
		<div class="row m-2 p-2">
			<div class="offset-md-2 col-md-8">

				<!-- Equal loan amount -->
				<div class="form-group">
					<div class="form-row">
						<label for="amount">Enter loan amount</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"> Rs.</div>
							</div>
							<input name="loan_amt" class="form-control" id="amount" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
						</div>
					</div>
				</div>

				<!-- Equal installment amount -->
				<div class="form-group">
					<div class="form-row">
						<label for="amount">Enter installment amount</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"> Rs.</div>
							</div>
							<input name="installment" class="form-control" id="amount" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
						</div>
					</div>
				</div>

				<!-- Period -->
				<div class="form-group">
					<div class="form-row">
						<label for="period">Period</label>
						<div class="input-group">
							<input name="period" class="form-control" id="period" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
							<select class="form-control col-3" name="mode" data-validation="required" data-validation-error-msg="Please select a value">
								<option value="" selected disabled>Select</option>
								<option value="days">days</option>
								<option value="weeks">weeks</option>
								<option value="months">months</option>
								<option value="years">years</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Rate of interest -->
				<div class="form-group">
					<div class="form-row">
						<label for="rate">Enter rate of interest</label>
						<div class="input-group">
							<input name="rate_of_interest" class="form-control" id="rate" type="text" data-validation="number" data-validation-allowing="float">
							<div class="input-group-append">
								<div class="input-group-text">%</div>
							</div>
							<select class="form-control col-2" name="interest_calculated">
								<option value="pa">p/a</option>
								<option value="pm">p/m</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Name of guarantor -->
				<div class="form-group">
					<div class="form-row">
						<label for="exampleInputName">Name of guarantor</label>
						<input name="guarantor_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
					</div>
				</div>

				<!-- Particulars of securities -->
				<div class="form-group">
					<div class="form-row">
						<label for="security_particulars" data-validation="required">Particulars of securities offered</label>
						<input type="text" name="security_particulars" class="form-control" data-validation="required">
					</div>
				</div>

				<!-- Purpose of loan -->
				<div class="form-group">
					<div class="form-row">
						<label for="loan_purpose">Purpose of loan</label>
						<input type="text" class="form-control" name="loan_purpose">
						
					</div>
				</div>

				<!-- Loan date -->
				<div class="form-group">
					<div class="form-row">
						<label for="loan_date">Loan date</label>
						<div class="input-group">
							<input type="date" class="form-control" name="loan_date" data-validation="required" data-validation-error-msg="Please select date">
						</div>
					</div>
				</div>

				<!-- Closing date -->
				<div class="form-group">
					<div class="form-row">
						<label for="closing_date">Closing date</label>
						<div class="input-group">
							<input type="date" class="form-control" name="closing_date" data-validation="required" data-validation-error-msg="Please select date">
						</div>
					</div>
				</div>

				<!-- Approved by -->
				<div class="form-group">
					<div class="form-row">
						<label for="approved_by">Approved by</label>
						<div class="input-group">
							<select class="form-control" name="approved_by" data-validation="required">
								<?php $display = new display();
								$res_agents = $display->disp_all("agents"); ?>
								<option selected disabled>Select</option>
								<?php while ($row_agents = mysqli_fetch_assoc($res_agents)) { ?>
									<?php if ($row_agents['status']=='active'): ?>
										<option value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
									<?php endif ?>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<input type="hidden" name="acc_no" value="<?php echo $row['account_no']; ?>">
				<button type="submit" name="new_loan" class="btn btn-block btn-primary">Submit</button>
				
			</div>
		</div>
	</form>

<?php endif ?>

<?php include('template/foot.php'); ?>