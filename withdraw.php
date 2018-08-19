<?php include('template/head.php'); ?>
<?php 
include('class/view.php');
$display = new display();
include('class/validate.php');
$validate = new validate();
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">Withdraw money</li>
</ol>	
<?php if (!isset($_GET['acc'])): ?>
	<?php 
	$result = $display->active_deposit_accounts();
	?>
	<div class="card mb-3">

		<div class="card-header">
			<i class="fa fa-table"></i> View Deposit accounts
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Account no</th>
							<th>Member name</th>
							<th>Opening date</th>
							<th>Maturity date</th>
							<th>Current Balance</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						<?php while($row=mysqli_fetch_assoc($result)){ ?>
							<tr>
								<td><?php echo $row['account_no']; ?></td>
								<td><?php echo $display->get_member_name($row['mem_id']); ?></td>
								<td><?php echo $display->date_dmY($row['joining_date']); ?></td>
								<td><?php $closing_date = date('d-M-Y', strtotime("+".$row['period']." months", strtotime($row['joining_date'])));
								echo $closing_date; ?></td>
								<td>
									<?php 
									$current_balance = $display->display_current_balance($row['acc_id']);
									$row_cb = mysqli_fetch_assoc($current_balance);
									if (empty($row_cb['current_balance'])) {
										echo "N/A";
									}else{
										echo "Rs. ".$row_cb['current_balance'];
									}
									?>
								</td>
								<td>
									<a href="withdraw.php?acc=<?php echo $row['acc_id']; ?>" class="btn btn-sm btn-primary">Withdraw money</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php endif ?>

<?php if (isset($_GET['acc'])): ?>
	<?php if ($validate->get_account_status($_GET['acc'])=='active'): ?>
		<?php
		$cndtn = "acc_id='".$_GET['acc']."'";
		$result = $display->disp_cond("deposit_accounts", $cndtn);
		// Displays member profile 
		$row = mysqli_fetch_assoc($result);
		?>
		<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
			<div class="row p-2">
				<div class="col col-md-4 p-2">
					<img style="max-height: 150px;" class="img-fluid" src="<?php echo $display->get_member_photo($row['mem_id']); ?>" alt="default profile picture">
				</div>
				<div class="col offset-md-3 col-md-5 p-2 media">
					<img class="img-fluid img-thumbnail align-self-end" src="<?php echo $display->get_member_signature($row['mem_id']); ?>" alt="default profile picture">
				</div>
			</div>
			<div class="row p-2">
				<div class="col">Name :</div>
				<div class="col"><b><?php echo $display->get_member_name($row['mem_id']); ?></b></div>
			</div>
			<div class="row p-2 bg-light-gray">
				<div class="col">Account number :</div>
				<div class="col"><b><?php echo $row['account_no']; ?></b></div>
			</div>
			<div class="row p-2 bg-light-gray">
				<div class="col">Current balance :</div>
				<div class="col"><b>Rs. <?php echo $display->current_balance($row['acc_id']); ?></b></div>
			</div>
		</div>
		<form action="action/withdraw.php" method="POST">
			<div class="row m-2 p-2">
				<div class="offset-md-2 col-md-8">
					<div class="form-group">
						<div class="form-row">
							<label for="amount">Enter amount</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"> Rs.</div>
								</div>
								<input name="amount" class="form-control" id="amount" type="text" data-validation="required number" data-validation-allowing="range[1;<?php echo $display->current_balance($row['acc_id']); ?>]" data-validation-error-msg="Enter a valid amount">
							</div>
						</div>
					</div>

					<!-- Date of withdrawal -->
					<div class="form-group">
						<div class="form-row">
							<label for="date_of_withdrawal">Date of withdrawal</label>
							<div class="input-group">
								<input class="form-control datepicker" name="date_of_withdrawal" data-validation="date" data-validation-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
							</div>
						</div>
					</div>
					<button type="button" class="btn btn-primary btn-block" data-toggle="modal" onclick="getAmt()" data-target="#confirm_deposit">
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
							Cick submit to withdraw money from account.
							<br>
							Name : <b><?php echo $display->get_member_name($row['mem_id']); ?></b>
							<br>
							Account No. : <b><?php echo $row['account_no']; ?></b>
							<br>
							Amount : <b>Rs. <span id="amtDiv"></span></b>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="acc_id" value="<?php echo $row['acc_id']; ?>">
							<input type="hidden" name="mem_id" value="<?php echo $row['mem_id']; ?>">
							<button type="submit" name="withdraw" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<?php else: ?>
			<div><h3>Account status not active. Please contact admin</h3></div>
			<div><a href="pay_installment.php">Go back</a></div>
		<?php endif ?>	
	<?php endif ?>


	<?php
	$script = "<script>
	function getAmt(){
		var amount = document.getElementById('amount').value;
		var amtDiv = document.getElementById('amtDiv');
		if (amount == '') {
			amount = '0.00';
		}
		amtDiv.innerHTML = amount;
	}
	</script>";
	?>
	<?php include('template/foot.php'); ?>