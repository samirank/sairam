<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>

<?php if (!isset($_GET['acc'])): ?>
	<div class="card card-register mx-auto mt-5 border-primary">
		<div class="card-header bg-primary-light-2">Add new agent</div>
		<div class="card-body">
			<form action="makedeposit.php" method="GET">

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
	</div>
	<form action="action/deposit.php" method="POST">
		<div class="row m-2 p-2">
			<div class="offset-md-2 col-md-8">
				<div class="form-group">
					<div class="form-row">
						<label for="amount">Enter amount</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"> Rs.</div>
							</div>
							<input name="instalment" class="form-control" id="amount" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
						</div>
					</div>
				</div>

				<!-- Date of payment -->
				<div class="form-group">
					<div class="form-row">
						<label for="date_of_payment">Date of payment</label>
						<div class="input-group">
							<input type="date" class="form-control" name="date_of_payment" data-validation="required" data-validation-error-msg="Please select date">
						</div>
					</div>
				</div>
				<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#confirm_deposit">
					Submit
				</button>
				
			</div>
		</div>
		<!-- Deposit modal -->
		<div class="modal fade" id="confirm_deposit" tabindex="-1" role="dialog" aria-labelledby="confirm_deposit" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="confirm_deposit">Please confirm submit.</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						Cick submit to make dposit to the account.
						<br>
						Name : <b><?php echo $row['member_name']; ?></b>
						<br>
						Account No. : <b><?php echo $row['account_no']; ?></b>
					</div>
					<div class="modal-footer">
						<button type="submit" name="make_deposit" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</div>
	</form>

<?php endif ?>



<?php include('template/foot.php'); ?>