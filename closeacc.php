<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$cond = "account_no=".$_GET['acc'];
$result = $display->disp_cond("members",$cond);
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
		<div class="col"><?php echo $row['member_name']; ?></div>
	</div>
	<div class="row p-2 bg-light-gray">
		<div class="col">Account number :</div>
		<div class="col"><?php echo $row['account_no']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col">Current balance :</div>
		<div class="col">
			<?php 
			$current_balance = $display->display_current_balance($row['account_no']);
			$row_cb = mysqli_fetch_assoc($current_balance);
			echo $row_cb['current_balance'];
			?>
		</div>
	</div>
	<div class="row p-2 bg-light-gray">
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
		<div class="col">Rs. <?php echo $row['instalment']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col">Mode :</div>
		<div class="col"><?php echo $row['mode']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col col-md-6">Rate of interest :</div>
		<div class="col"><?php if($row['rate_of_interest']=="") echo "Not set"; else echo $row['rate_of_interest']."%"; ?></div> 
		<div class="col"></div>
	</div>
	<div class="row p-2">
		<div class="col">Opening date :</div>
		<div class="col"><?php echo $row['joining_date']; ?></div>
	</div>
	<div class="row p-2">
		<div class="col">Closing date :</div>
		<div class="col">
			<?php
			$closing_date = date('Y-m-d', time());
			echo $closing_date;
			?>
		</div>
	</div>
	<div class="row p-2">
		<div class="col">Amount payable</div>
		<div class="col"></div>
	</div>
</div>


<?php include('template/foot.php'); ?>