<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$result = $display->disp_all("members");
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">View members</li>
</ol>
<div class="card mb-3">

	<div class="card-header">
		<i class="fa fa-table"></i> View members</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Account No.</th>
							<th>Name</th>
							<th>Phone No.</th>
							<th>Installment</th>
							<th>Mode</th>
							<th>Period</th>
							<th>Status</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						<?php while($row=mysqli_fetch_assoc($result)){ ?>
							<tr>
								<td><?php echo $row['account_no']; ?></td>
								<td><?php echo $row['member_name']; ?></td>
								<td><?php echo $row['member_phone']; ?></td>
								<td><?php echo $row['instalment']; ?></td>
								<td><?php echo $row['mode']; ?></td>
								<td><?php echo $row['period']; ?></td>
								<td>
									<div class="<?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>">
										<?php echo $row['status']; ?>
									</div>
								</td>
								<td>
									<div class="btn-group" role="group">
										<button id="profileoptions<?php echo $row['user_id']; ?>" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Options
										</button>
										<div class="dropdown-menu" aria-labelledby="profileoptions<?php echo $row['user_id']; ?>">
											<a class="dropdown-item" href="profile.php?mem=<?php echo $row['account_no']; ?>">View</a>
											<?php if ($row['status']=='active'): ?>
												<a class="dropdown-item" href="edit.php?mem=<?php echo $row['account_no']; ?>">Edit</a>
												<a class="dropdown-item"  href="makedeposit.php?acc=<?php echo $row['account_no']; ?>">Deposit</a>
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