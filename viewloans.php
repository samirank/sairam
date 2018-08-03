<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$result=$display->disp_all_loans("loans");
// print_r(mysqli_fetch_assoc($result));
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">All loans</li>
</ol>

<div class="card">
	<div class="card-header">
		<i class="fa fa-list"></i> Loans
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Member name</th>
						<th>A/C No</th>
						<th>Amount</th>
						<th>Installment</th>
						<th>Loan date</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while($row=mysqli_fetch_assoc($result)){ ?>
						<tr>
							<td><?php echo $row['member_name']; ?></td>
							<td><?php echo $row['acc_no']; ?></td>
							<td>Rs. <?php echo $row['loan_amount']; ?></td>
							<td>Rs. <?php echo $row['installment']; ?></td>
							<td><?php echo $row['loan_date']; ?></td>
							<td><div class="<?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $row['status']; ?></div></td>
							<td class="text-right" style="width: 90px;">
								<div class="btn-group" role="group">
									<button id="profileoptions" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Options
									</button>
									<div class="dropdown-menu" aria-labelledby="profileoptions">
										<a class="dropdown-item" href="profile.php?mem=<?php echo $row['acc_no']; ?>&loan=<?php echo $row['loan_id']; ?>">View</a>
										<?php if ($row['status']!='closed'): ?>
											<a class="dropdown-item" href="pay_installment.php?loan=<?php echo $row['loan_id']; ?>">Pay Installment</a>
										<?php endif ?>
									</div>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

	<?php include('template/foot.php'); ?>