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
									<a href="profile.php?mem=<?php echo $row['account_no']; ?>">View</a>
									&nbsp;
									<a href="edit_profile.php?mem=<?php echo $row['account_no']; ?>">Edit</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
	<?php include('template/foot.php'); ?>