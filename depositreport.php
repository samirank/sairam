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
	<li class="breadcrumb-item active">Account report</li>
</ol>

<?php if (mysqli_num_rows($result)!=0): ?>
	<div class="pt-3 pb-3 w-75 mx-auto"><h6>Member name: <?php echo $display->get_member_name($mem_id); ?></h6></div>
	<?php while ($row = mysqli_fetch_assoc($result)) { ?>
		<div class="w-75 mx-auto mt-5 mb-5 pr-2 pl-2 pt-4 pb-4 border border-info">
			<div class="pt-3 pb-3"><h6>Account no: <?php echo $row['account_no']; ?> &emsp;&emsp;Current balance: <?php 
			echo $display->current_balance($row['acc_id']);
			?> &emsp;&emsp;Account status: <?php echo $row['status']; ?></h6></div>
			<?php 
			$result_acc = $display->get_deposit_report($row['acc_id']);
			?>

			<table class="table">
				<?php if (mysqli_num_rows($result_acc)!=0): ?>
					<thead>
						<tr>
							<th class="text-center" scope="col">#</th>
							<th class="text-center" scope="col">Date</th>
							<th class="text-center" scope="col">Deposit(Rs.)</th>
							<th class="text-center" scope="col">Withdrawal(Rs.)</th>
							<th class="text-center" scope="col">Total (Rs.)</th>
							<th class="text-center" scope="col"></th>
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
						<?php $total+=($row_acc['deposit_amount']-$row_acc['withdrawal_amount']); ?>
						<tr>
							<td scope="row"><?php echo $sl; ?></td>
							<td class="text-center"><?php echo date('d/m/Y', strtotime($row_acc['date'])); ?></td>
							<td class="text-center"><?php if(empty($row_acc['deposit_amount'])) echo "-"; else echo $row_acc['deposit_amount']; ?></td>
							<td class="text-center"><?php if(empty($row_acc['withdrawal_amount'])) echo "-"; else echo $row_acc['withdrawal_amount']; ?></td>
							<td class="text-center"><?php echo $total; ?></td>
							<td class="text-center"><a href="editreport.php?<?php if(empty($row_acc['deposit_amount'])) echo "w=".$row_acc['id']; else echo "d=".$row_acc['id']; ?>">edit</a></td>
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