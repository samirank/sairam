<?php include('template/head.php'); ?>
<?php include('class/view.php'); 
$display = new display();
?>
<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
	<div class="pt-2 pl-2">
		<b>Showing Records For</b>
		<hr>
	</div>
	<div class="row p-2">
		<div class="col col-md-6">Agent name: <?php echo $display->get_agent_name($_GET['agent']); ?></div>
	</div>
	<div class="row p-2 pl-3">
		<!-- <div class="col col-md-6">Date: <?php echo $_GET['date']; ?></div> -->
		<div>
			<form action="agent_report_datewise.php" class="w-100">
				<div class="input-group">
					<input class="form-control datepicker" name="date" data-validation="date" data-validation-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off" value="<?php echo $_GET['date']; ?>">
					<input type="hidden" name="agent" value="<?php echo $_GET['agent']; ?>">
					<input type="hidden" name="type" value="loan">
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit">Change Date</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Loan account report -->
<div class="offset-md-2 col-md-8 text-left border rounded mt-3 pb-3">
	<div class="row p-2 bg-primary-color text-white text-center">
		<div class="col">All loan transactions under agent <b><?php echo $display->get_agent_name($_GET['agent']); ?></b> on <b><?php echo $_GET['date']; ?></b></div>
	</div>
	<table class="w-100">
		<thead>
			<th>Member name</th>
			<th>Loan no</th>
			<th>Amount received</th>
			<th>View loan</th>
		</thead>
		<tbody>
			<?php $result = $display->get_agent_datewise_loan_report($_GET['date'],$_GET['agent']); ?>
			<?php if (mysqli_num_rows($result)!=0): ?>
				<?php $i=0; $amount=0; ?>
				<?php while($row = mysqli_fetch_assoc($result)){ ?>
					<tr class="<?php if($i%2==0) echo "bg-light-gray"; ?>">
						<td class="p-1"><?php echo $display->get_member_name($row['mem_id']); ?></td>
						<td class="p-1"><?php echo $row['loan_no']; ?></td>
						<td class="p-1"><?php echo $row['amount']; ?></td>
						<td class="p-1"><a href="profile.php?mem=<?php echo $row['mem_id']; ?>&loan=<?php echo $row['loan_id']; ?>">View loan</a></td>
					</tr>
					<?php 
					$i++;
					$amount+=$row['amount'];
					?>
				<?php } ?>
				<tr>
					<td colspan="4"><b>Total: Rs. <?php echo $amount; ?></b></td>
				</tr>
				<?php else: ?>
					<tr>
						<td colspan="4" class="text-center bg-light-gray">
							No records found
						</td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
	</div>

	<!-- Deposit account report -->
	<div class="offset-md-2 col-md-8 text-left border rounded mt-3 pb-3">
		<div class="row p-2 bg-primary-color text-white text-center">
			<div class="col">All deposit account transactions under agent <b><?php echo $display->get_agent_name($_GET['agent']); ?></b> on <b><?php echo $_GET['date']; ?></b></div>
		</div>
		<h5 class="pt-2">Deposits</h5>
		<hr>
		<table class="w-100">
			<thead>
				<th>Member name</th>
				<th>Account no</th>
				<th>Amount received</th>
				<th>View account</th>
			</thead>
			<tbody>
				<?php $result = $display->get_agent_datewise_account_deposit_report($_GET['date'],$_GET['agent']); ?>
				<?php if (mysqli_num_rows($result)!=0): ?>
					<?php $i=0; $amount=0; ?>
					<?php while($row = mysqli_fetch_assoc($result)){ ?>
						<tr class="<?php if($i%2==0) echo "bg-light-gray"; ?>">
							<td class="p-1"><?php echo $display->get_member_name($row['mem_id']); ?></td>
							<td class="p-1"><?php echo $row['account_no']; ?></td>
							<td class="p-1"><?php echo $row['amount']; ?></td>
							<td class="p-1"><a href="profile.php?mem=<?php echo $row['mem_id']; ?>&acc=<?php echo $row['acc_id']; ?>">View account</a></td>
						</tr>
						<?php $i++;
						$amount+=$row['amount']; ?>
					<?php } ?>
					<tr>
						<td colspan="4"><b>Total: <?php echo $amount; ?></b></td>
					</tr>
					<?php else: ?>
						<tr>
							<td colspan="4" class="text-center bg-light-gray">
								No records found
							</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
			<hr>
			<h5>Withdrawals</h5>
			<hr>
			<table class="w-100">
				<thead>
					<th>Member name</th>
					<th>Account no</th>
					<th>Amount withdrawn</th>
					<th>View account</th>
				</thead>
				<tbody>
					<?php $result = $display->get_agent_datewise_account_withdrawal_report($_GET['date'],$_GET['agent']); ?>
					<?php if (mysqli_num_rows($result)!=0): ?>
						<?php $i=0; $amount=0; ?>
						<?php while($row = mysqli_fetch_assoc($result)){ ?>
							<tr class="<?php if($i%2==0) echo "bg-light-gray"; ?>">
								<td class="p-1"><?php echo $display->get_member_name($row['mem_id']); ?></td>
								<td class="p-1"><?php echo $row['account_no']; ?></td>
								<td class="p-1"><?php echo $row['amount']; ?></td>
								<td class="p-1"><a href="profile.php?mem=<?php echo $row['mem_id']; ?>&acc=<?php echo $row['acc_id']; ?>">View account</a></td>
							</tr>
							<?php $i++;
							$amount+=$row['amount']; ?>
						<?php } ?>
						<tr>
							<td colspan="4"><b>Total: Rs. <?php echo $amount; ?></b></td>
						</tr>
						<?php else: ?>
							<tr>
								<td colspan="4" class="text-center bg-light-gray">
									No records found
								</td>
							</tr>
						<?php endif ?>
					</tbody>
				</table>
			</div>
			<?php include('template/foot.php'); ?>