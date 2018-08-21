<?php include('template/head.php'); ?>
<?php 
include('class/view.php');
$display = new display();
$result = $display->deposit_accounts();
?>
	<div class="card mb-3">

		<div class="card-header">
			<i class="fa fa-table"></i>Deposit accounts</div>
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
								<th>Status</th>
								<th>Option</th>
							</tr>
						</thead>
						<tbody>
							<?php while($row=mysqli_fetch_assoc($result)){ ?>
								<tr>
									<td><?php echo $row['account_no']; ?></td>
									<td><?php echo $display->get_member_name($row['mem_id']); ?></td>
									<td><?php echo $display->date_dmY($row['joining_date']); ?></td>
									<td><?php $closing_date = date('d-m-Y', strtotime("+".$row['period']." months", strtotime($row['joining_date'])));
									echo $closing_date; ?></td>
									<td>
										<?php echo $display->current_balance($row['acc_id']); ?>
									</td>
									<td>
										<?php echo $row['status'] ?>
									</td>
									<td>
										<div class="btn-group" role="group">
										<button id="profileoptions<?php echo $row['mem_id']; ?>" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Options
										</button>
										<div class="dropdown-menu" aria-labelledby="profileoptions<?php echo $row['mem_id']; ?>">
											<a class="dropdown-item" href="profile.php?mem=<?php echo $row['mem_id']; ?>&acc=<?php echo $row['acc_id'] ?>">View</a>
											<?php if ($row['status']=='active'): ?>
												<a class="dropdown-item" href="edit.php?acc=<?php echo $row['acc_id']; ?>">Edit</a>
												<a class="dropdown-item" href="makedeposit.php?acc=<?php echo $row['acc_id']; ?>">Make deposit</a>
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