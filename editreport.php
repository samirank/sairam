<?php 
include('template/head.php');
include('class/view.php');
$display = new display();
?>
<?php
$err = "Insufficient data"; 
if($_SESSION['login_role']!='admin'){
	$err = "You are not authorised to edit report";
}
?>
<?php if ((isset($_GET['d']))&&(isset($_GET['m']))): ?>
	<?php $res = $display->get_deposit($_GET['d']); ?>
	<?php if ($res): ?>
		<?php 
		$err = false;
		print_r($res);
		?>
		<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
			<div class="row p-2">
				<div class="col">Current amount :</div>
				<div class="col"><b>Rs. <?php echo $res['amount']; ?></b></div>
			</div>
			<div class="row p-2">
				<div class="col">Current date of payment :</div>
				<div class="col"><b><?php echo $display->date_dmy($res['date_of_payment']); ?></b></div>
			</div>
		</div>
		<form action="action/deposit.php" method="POST">
			<div class="row m-2 p-2">
				<div class="offset-md-2 col-md-8">
					<div class="form-group">
						<div class="form-row">
							<label for="amount">New amount</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text"> Rs.</div>
								</div>
								<input name="installment" class="form-control" id="amount" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
							</div>
						</div>
					</div>

					<!-- Date of payment -->
					<div class="form-group">
						<div class="form-row">
							<label for="date_of_payment">New date of payment</label>
							<div class="input-group">
								<input class="form-control datepicker" name="date_of_payment" data-validation="date" data-validation-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<button type="submit" class="btn btn-primary btn-block"> Submit </button>
						</div>
						<div class="col">
							<a href="depositreport.php?mem=<?php echo $_GET['m']; ?>" class="btn btn-block btn-danger">Cancel</a>
						</div>
					</div>

				</div>
			</div>
		</form>
		<?php else: ?>
			<?php $err = "Entry not found"; ?>
		<?php endif ?>
	<?php endif ?>

	<?php if ((isset($_GET['w']))&&(isset($_GET['m']))): ?>
		<?php $res = $display->get_withdrawal($_GET['d']); ?>
		<?php if ($res): ?>
			<?php 
			$err = false;
			print_r($res);
			?>
			<?php else: ?>
				<?php $err = "Entry not found"; ?>
			<?php endif ?>
		<?php endif ?>

		<?php 
		if ((!isset($_GET['d']))&&(!isset($_GET['w']))) {
			$err = "Data not found";
		}
		?>
		<?php if ($err): ?>
			<!-- Error msg -->
			<h3><?php echo $err; ?></h3>
		<?php endif ?>
		<?php include('template/foot.php'); ?>