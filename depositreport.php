<?php
include('template/head.php');
include('class/view.php');
$display = new display();
$mem_id = $_GET['mem'];
$cond = 'mem_id='.$mem_id;
$result = $display->disp_cond('deposit_accounts',$cond);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="profile.php?mem=<?php echo $_GET['mem']; ?>">Member</a>
	</li>
	<li class="breadcrumb-item active">Deposit report</li>
</ol>

<?php if (mysqli_num_rows($result)!=0): ?>
	<div class="pt-3 pb-3 w-75 mx-auto"><h6>Member name: <?php echo $display->get_member_name($mem_id); ?></h6></div>
	<?php while ($row = mysqli_fetch_assoc($result)) { ?>
		<div class="w-75 mx-auto mt-5 mb-5 pr-2 pl-2 pt-4 pb-4 border border-info">
			<div class="pt-3 pb-3"><h6>Account no: <?php echo $row['account_no']; ?> &emsp;&emsp;Current balance: <?php 
			$current_balance = $display->display_current_balance($row['acc_id']);
			$row_cb = mysqli_fetch_assoc($current_balance);
			if (empty($row_cb['current_balance'])) {
				echo "N/A";
			}else{
				echo "Rs. ".$row_cb['current_balance'];
			}
			?> &emsp;&emsp;Account status: <?php echo $row['status']; ?></h6></div>
			<?php 
			$result_acc = $display->get_deposit_report($row['acc_id']);
			?>

			<table class="table">
				<?php if (mysqli_num_rows($result_acc)!=0): ?>
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
					<?php if (mysqli_num_rows($result_acc)==0): ?>
						<tr>
							<td class="text-center">No record found</td>
						</tr>
					<?php endif ?>
					<?php while ($row_acc=mysqli_fetch_assoc($result_acc)) { ?>
						<?php $total+=$row_acc['amount']; ?>
						<tr>
							<td scope="row"><?php echo $sl; ?></td>
							<td><?php echo date('d/m/Y', strtotime($row_acc['date_of_payment'])); ?></td>
							<td><?php echo $row_acc['amount']; ?></td>
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