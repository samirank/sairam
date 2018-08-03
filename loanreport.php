<?php
include('template/head.php');
include('class/view.php');
$display = new display();
$account_no = $_GET['acc'];
$cond = 'acc_no='.$account_no;
$result = $display->disp_cond('loans',$cond);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="profile.php?mem=<?php echo $_GET['acc']; ?>">Member</a>
	</li>
	<li class="breadcrumb-item active">Deposit report</li>
</ol>

<?php if (mysqli_num_rows($result)!=0): ?>
	<div class="pt-3 pb-3 w-75 mx-auto"><h6>Account no: <?php echo $account_no; ?> &emsp;&emsp;Member name: <?php echo $display->get_member_name($account_no); ?> &emsp;&emsp;Joining date: <?php echo $display->get_joining_date($account_no); ?></h6></div>
	<?php while ($row = mysqli_fetch_assoc($result)) { ?>
		<div class="w-75 mx-auto mt-5 mb-5 pr-2 pl-2 pt-4 pb-4 border border-info">
			<div class="pt-3 pb-3"><h6>Loan id: <?php echo $row['loan_id']; ?> &emsp;&emsp;Loan amount: Rs. <?php echo $row['loan_amount']; ?> &emsp;&emsp;Loan status: <?php echo $row['status']; ?></h6></div>
			<?php 
			$loan_cond = "loan_id=".$row['loan_id'];
			$result_loan = $display->disp_cond("loan_payments",$loan_cond);
			?>

			<table class="table">
				<?php if (mysqli_num_rows($result_loan)!=0): ?>
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Date</th>
							<th scope="col">Amount (Rs.)</th>
							<th scope="col">Total</th>
						</tr>
					</thead>
				<?php endif ?>
				<tbody>
					<?php 
					$total = 0;
					$sl = 1;
					?>
					<?php if (mysqli_num_rows($result_loan)==0): ?>
						<tr>
							<td class="text-center">No record found</td>
						</tr>
					<?php endif ?>
					<?php while ($row_loan=mysqli_fetch_assoc($result_loan)) { ?>
						<?php $total+=$row_loan['amount']; ?>
						<tr>
							<td scope="row"><?php echo $sl; ?></td>
							<td><?php echo $row_loan['date_of_payment']; ?></td>
							<td><?php echo $row_loan['amount']; ?></td>
							<td><?php echo $total; ?></td>
						</tr>
						<?php $sl++; ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
	<?php else: ?>
		<?php echo "No loan found for this account"; ?>
	<?php endif ?>

	<?php include('template/foot.php'); ?>