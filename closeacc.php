<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$cond = "acc_id='".$_GET['acc']."'";
$result = $display->disp_cond("deposit_accounts",$cond);
$row = mysqli_fetch_assoc($result);
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="viewmembers.php">Members</a>
	</li>
	<li class="breadcrumb-item">
		<a href="profile.php?mem=<?php echo $_GET['acc']; ?>">Profile</a>
	</li>
	<li class="breadcrumb-item active">Close account</li>
</ol>

<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
	<div class="row p-2 bg-primary-color text-white">
		<div class="col text-center"><h6>
			Account closing summary
		</h6></div>
	</div>
	<div class="row p-2">
		<div class="col">Name :</div>
		<div class="col"><?php echo $display->get_member_name($row['mem_id']); ?></div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col">Account number :</div>
		<div class="col"><?php echo $row['account_no']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col">Period :</div>
		<div class="col"><?php echo $row['period']; ?> months</div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col">Months completed :</div>
		<div class="col">
			<?php
			$d1 = date_create($row['joining_date']);
			$d2 = date_create(date('m/d/Y', time()));
			$interval = date_diff($d1, $d2);
			echo $interval->format('%m months');
			?>
		</div>
	</div>
	<div class="row p-2">
		<div class="col">Installment :</div>
		<div class="col">Rs. <?php echo $row['installment']; ?></div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col">Mode :</div>
		<div class="col"><?php echo $row['mode']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col col-md-6">Rate of interest :</div>
		<div class="col"><?php if($row['rate_of_interest']=="") echo "Not set"; else echo $row['rate_of_interest']."%"; ?></div> 
		<div class="col"></div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col">Opening date :</div>
		<div class="col"><?php echo $display->date_dmy( $row['joining_date']); ?></div>
	</div>
	<div class="row p-2">
		<div class="col">Closing date :</div>
		<div class="col">
			<?php
			$closing_date = date('Y-m-d');
			echo $display->date_dmy($closing_date);
			?>
		</div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col"><b>Current balance</b> :</div>
		<div class="col">Rs. 
			<?php 
			$current_balance = $display->display_current_balance($row['acc_id']);
			$row_cb = mysqli_fetch_assoc($current_balance);
			echo $row_cb['current_balance'];
			?>
		</div>
	</div>
	<form action="action/closeaccount.php" method="POST">
		<div class="row p-2">
			<div class="col"><b>Amount to pay</b> :</div>
			<div class="col text-left">
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<div class="input-group-text">Rs.</div>
					</div>
					<input name="amount" type="text" class="form-control" id="amountpayable" placeholder="Enter amount" data-validation="required number" data-validation-error-msg="Please enter correct value" autofocus>
					<input type="hidden" value="<?php echo $row['acc_id']; ?>" name="acc_id">
				</div>
			</div>
		</div>
	</div>
	<div class="row pt-2">
		<div class="col-8 offset-md-2">
			<input type="hidden" name="acc_id" value="<?php echo $row['acc_id']; ?>">
			<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
			<input type="hidden" name="mem_id" value="<?php echo $row['mem_id']; ?>">
			<input type="hidden" name="member_name" value="<?php echo $display->get_member_name($row['mem_id']); ?>">
			<button type="submit" name="closeacc" class="btn btn-block btn-primary">Close Account</button>
		</div>
	</div>
</form>


<?php include('template/foot.php'); ?>