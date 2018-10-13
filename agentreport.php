<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>

<!-- select agent -->
<form action="agentreport.php" method="GET">
	<div class="row m-2 p-2">
		<div class="offset-md-2 col-md-8">
			<div class="form-group">
				<div class="form-row">
					<label for="amount"></label>
					<div class="input-group">
						<select class="custom-select" name="agent" id="inputGroupSelect04" aria-label="Example select with button addon">
							<option selected disabled>Select Agent</option>
							<?php $display = new display();
							$res_agents = $display->disp_all("agents"); ?>
							<?php while ($row_agents = mysqli_fetch_assoc($res_agents)) { ?>
								<?php if ($row_agents['status']=='active'): ?>
									<option value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
								<?php endif ?>
							<?php } ?>
						</select>
						<div class="input-group-append">
							<button class="btn btn-outline-primary" type="submit">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<?php if (isset($_GET['agent'])): ?>
	<?php 
	$cndtn = "agent_id=".$_GET['agent'];
	$result = $display->disp_cond("agents", $cndtn);
	$row = mysqli_fetch_assoc($result);
	?>
	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2">
			<div class="col">Agent name :</div>
			<div class="col"><b><?php echo $row['agent_name']; ?></b></div>
		</div>
		<div class="row p-2 bg-light-gray">
			<div class="col">Phone :</div>
			<div class="col"><?php echo $row['phno']; ?></div>
		</div>
		<div class="row p-2">
			<div class="col">Email :</div>
			<div class="col"><?php echo $row['email']; ?></div>
		</div>
	</div>

	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2">
			<form action="agent_report_datewise.php" class="w-100">
				<div class="input-group">
					<input class="form-control datepicker" name="date" data-validation="date" data-validation-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off">
					<input type="hidden" name="agent" value="<?php echo $_GET['agent']; ?>">
					<div class="input-group-append">
						<button class="btn btn-dark" type="submit">View date-wise report</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2 bg-primary-color text-white text-center">
			<div class="col"><b>Loan accounts report</b></div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Total number of loans:</div>
			<div class="col col-md-2"><?php echo $display->total_agent_loans($_GET['agent']); ?></div>
			<div class="col col-md-6 text-right">
				<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#allloanacc">
					View all loans accounts
				</button>
			</div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Active loans:</div>
			<div class="col col-md-2"><?php echo $display->total_agent_active_loans($_GET['agent']); ?></div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Closed loans:</div>
			<div class="col col-md-2"><?php echo $display->total_agent_closed_loans($_GET['agent']); ?></div>
		</div>
	</div>

	<!-- All loans account Modal -->
	<div class="modal fade" id="allloanacc" tabindex="-1" role="dialog" aria-labelledby="allloanaccLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="allloanaccLabel">All loan account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="w-100">
						<thead class="bg-primary-color text-white">
							<th class="w-50 p-1">Name</th>
							<th class="w-25 p-1">Account no</th>
							<th class="w-25 p-1"></th>
						</thead>
						<tbody>
							<?php $all_loans = $display->agent_all_loan_acc($_GET['agent']); $i=1; ?>
							<?php while($loans_row = mysqli_fetch_assoc($all_loans)){ ?>
								<tr class="<?php if(($i%2)==0){ echo 'bg-light-gray'; } ?>">
									<td class="p-1"><?php echo $display->get_member_name($loans_row['mem_id']); ?></td>
									<td class="p-1"><?php echo $loans_row['loan_no']; ?></td>
									<td class="p-1"><a href="profile.php?mem=<?php echo $loans_row['mem_id']; ?>&loan">view profile</a></td>
								</tr>
								<?php $i++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
		<div class="row p-2 bg-primary-color text-white text-center">
			<div class="col"><b>Deposit accounts report</b></div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Total deposit accounts:</div>
			<div class="col col-md-2"><?php echo $display->total_agent_deposit_acc($_GET['agent']); ?></div>
			<div class="col col-md-6 text-right">
				<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#alldepositacc">
					View all deposit accounts
				</button>
			</div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Active accounts:</div>
			<div class="col col-md-2"><?php echo $display->total_agent_active_deposit_acc($_GET['agent']); ?></div>
		</div>
		<div class="row p-2">
			<div class="col col-md-4">Closed accounts:</div>
			<div class="col col-md-2"><?php echo $display->	total_agent_closed_deposit_acc($_GET['agent']); ?></div>
		</div>
	</div>

	<!-- All deposit account Modal -->
	<div class="modal fade" id="alldepositacc" tabindex="-1" role="dialog" aria-labelledby="alldepositaccLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="alldepositaccLabel">All account</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="w-100">
						<thead class="bg-primary-color text-white">
							<th class="w-50 p-1">Name</th>
							<th class="w-25 p-1">Account no</th>
							<th class="w-25 p-1"></th>
						</thead>
						<tbody>
							<?php $all_deposit = $display->agent_all_deposit_acc($_GET['agent']); $i=1; ?>
							<?php while($deposit_row = mysqli_fetch_assoc($all_deposit)){ ?>
								<tr class="<?php if($i22==0) echo 'bg-light-gray'; ?>">
									<td class="p-1"><?php echo $display->get_member_name($deposit_row['mem_id']); ?></td>
									<td class="p-1"><?php echo $deposit_row['account_no']; ?></td>
									<td class="p-1"><a href="profile.php?mem=<?php echo $deposit_row['mem_id']; ?>&acc">view profile</a></td>
								</tr>
								<?php $i++; ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

<?php endif ?>

<?php include('template/foot.php'); ?>