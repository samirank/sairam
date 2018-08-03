<?php include('template/head.php'); ?>

<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">Pay installment</li>
</ol>

<?php if ((!isset($_GET['acc']))&&(!isset($_GET['loan']))): ?>
<div class="card card-register mx-auto mt-5 border-primary">
	<div class="card-body">
		<form action="pay_installment.php" method="GET">
			<div class="form-group">
				<label for="inputAccno">Search by account number.</label>
				<div class="input-group mb-3">
					<input name="acc" class="form-control" id="inputAccno" type="text" aria-describedby="nameHelp" placeholder="Enter account number" data-validation="number server" data-validation-param-name="loan_account" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower">
					<div class="input-group-append">
						<button type="submit" class="btn btn-primary"> Submit </button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="card card-register mx-auto mt-5 border-primary">
	<div class="card-body">
		<form action="pay_installment.php" method="GET">
			<div class="form-group">
				<label for="inputLoanID">Search by loan id.</label>
				<div class="input-group mb-3">
					<input name="loan" class="form-control" id="inputLoanID" type="text" aria-describedby="nameHelp" placeholder="Enter loan id" data-validation="number server" data-validation-param-name="check_loan" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower">
					<div class="input-group-append">
						<button type="submit" class="btn btn-primary"> Submit </button>
					</div>
				</div>
			</div>
		</form>	
	</div>
</div>
<?php endif ?>

<?php if (isset($_GET['acc'])&&(!isset($_GET['loan']))): ?>
<?php
include('class/view.php');
include('class/validate.php');
$display = new display();
$validate = new validate();
?>
<?php if ($validate->validate_accno($_GET['acc'])): ?>
	<?php 
	$cond = "acc_no=".$_GET['acc']." AND status='active'";
	$result = $display->disp_cond("loans",$cond);
	?>
	<?php if (mysqli_num_rows($result)>=1): ?>
		<div class="card">
			<div class="card-header">
				<i class="fa fa-list"></i> Loans for account no. <?php echo $_GET['acc']; ?> &emsp;&emsp;&emsp;Member name: <?php echo $display->get_member_name($_GET['acc']); ?>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>Loan id</th>
								<th>Amount</th>
								<th>Installment</th>
								<th>Loan date</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							<?php while($row=mysqli_fetch_assoc($result)){ ?>
								<tr>
									<td><?php echo $row['loan_id']; ?></td>
									<td>Rs. <?php echo $row['loan_amount']; ?></td>
									<td>Rs. <?php echo $row['installment']; ?></td>
									<td><?php echo $row['loan_date']; ?></td>
									<td><div class="<?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $row['status']; ?></div></td>
									<td class="text-right" style="width: 90px;">
										<button class="btn btn-primary btn-sm" onclick="location.href='pay_installment.php?loan=<?php echo $row['loan_id'] ?>'">Pay installment</button>
									</td>
								</tr>
								<?php $i++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php else: ?>
			<div><h3>No active loan for this account.</h3></div>
			<div><a href="pay_installment.php">Go back</a></div>

		<?php endif ?>
		<?php else: ?>
			<div><h3>Account not found.</h3></div>
			<div><a href="pay_installment.php">Go back</a></div>
		<?php endif ?>
	<?php endif ?>

	<?php if (isset($_GET['loan'])): ?>
		<?php 
		include('class/view.php');
		include('class/validate.php');
		$display = new display();
		$validate = new validate();
		?>
		<?php if ($validate->check_loan_status($_GET['loan'])=='active'): ?>
			<?php 
			$cond = "loan_id=".$_GET['loan'];
			$result = $display->disp_cond('loans',$cond);
			$row = mysqli_fetch_assoc($result);
			?>

			<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
				<div class="row p-2 bg-light-gray">
					<div class="col">Member name :</div>
					<div class="col"><?php echo $display->get_member_name($row['acc_no']); ?></div>
				</div>
				<div class="row p-2">
					<div class="col">Loan id :</div>
					<div class="col"><b><?php echo $row['loan_id']; ?></b></div>
				</div>
				<div class="row p-2 bg-light-gray">
					<div class="col">Account number :</div>
					<div class="col"><b><?php echo $row['acc_no']; ?></b></div>
				</div>
				<div class="row p-2">
					<div class="col">Loan amount :</div>
					<div class="col">Rs. <?php echo $row['loan_amount']; ?></div>
				</div>
				<div class="row p-2 bg-light-gray">
					<div class="col">Installment :</div>
					<div class="col">Rs. <?php echo $row['installment']; ?></div>
				</div>
				<div class="row p-2">
					<div class="col">Period :</div>
					<div class="col"><?php echo $row['period']; ?> <?php echo $row['mode']; ?></div>
				</div>
				<div class="row p-2 bg-light-gray">
					<div class="col">Amount paid :</div>
					<div class="col">
						<?php 
						$total_amount = $display->total_loan_amt_paid($_GET['loan']);
						if ($total_amount) {
							echo "Rs. ".$total_amount;
						}else{
							echo "N/A";
						}
						?>
					</div>
				</div>
			</div>
			<div class="offset-md-2 col-md-8 text-left border rounded mt-3 border-primary pb-2 pt-2">
				<form action="action/pay_installment_action.php" method="POST">
					<div class="row p-2">
						<div class="col">Enter amount :	</div>
						<div class="col">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">Rs.</span>
								</div>
								<input type="text" class="form-control" name="amount" data-validation="required number" data-validation-error-msg="Please enter amount." autofocus>
							</div>
						</div>
					</div>

					<div class="row p-2">
						<div class="col">Date of payment :</div>
						<div class="col">
							<input type="date" name="date" class="form-control" data-validation="required">
						</div>
					</div>
					<input type="hidden" name="loan_id" value="<?php echo $row['loan_id']; ?>">
					<input type="hidden" name="account_no" value="<?php echo $row['acc_no']; ?>">
					<button type="submit" name="pay_installment" class="btn btn-primary btn-block">Confirm Payment</button>
				</form>
			</div>
			<?php else: ?>
				<div><h3>Loan status not active.</h3></div>
				<div><a href="pay_installment.php">Go back</a></div>
			<?php endif ?>
		<?php endif ?>

		<?php include('template/foot.php'); ?>