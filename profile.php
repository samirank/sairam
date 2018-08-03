<?php include('template/head.php'); ?>
<?php include('class/view.php');
$display = new display();

if($_SESSION['login_role']=="staff"){
	if (isset($_GET['mem'])) {
		$profile_type = "member";
		$profile_id = $_GET['mem'];
	}else{
		$profile_type = "staff";
		$profile_id = $_SESSION['login_id'];
	}
}
if($_SESSION['login_role']=="admin"){
	if (isset($_GET['mem'])) {
		$profile_type = "member";
		$profile_id = $_GET['mem'];
	}elseif(isset($_GET['staff'])){
		$profile_type = "staff";
		$profile_id = $_GET['staff'];
	}else{
		$profile_type = "admin";
		$profile_id = $_SESSION['login_id'];
	}
}
if (isset($_GET['agent'])) {
	$profile_type = "agent";
	$profile_id = $_GET['agent'];
}
?>

<?php 
$script = <<<EOD
<script>
$(function () {
	$(".closeloanbtn").click(function () {
		var my_id_value = $(this).data('id');
		$(".modal-footer #close_loan_id").val(my_id_value);
		})
		});
		</script>
EOD;
		?>





		<?php if ($profile_type=="member"): ?>
			<?php
			$cndtn = "account_no=".$profile_id;
			$result = $display->disp_cond("members", $cndtn);
	// Displays member profile 
			$row = mysqli_fetch_assoc($result);
			?>

			<!-- Button group -->
			<div class="row">
				<div class="col mb-3 p-3">
					<div class="btn-group" role="group">
						<button class="btn btn-primary" type="button" onclick="location.href='edit.php?mem=<?php echo $profile_id; ?>'" <?php if ($row['status']=='closed') echo 'disabled'; ?>>Edit profile</button>
						<button class="btn btn-primary" onclick="location.href='makedeposit.php?acc=<?php echo $profile_id; ?>'"<?php if ($row['status']=='closed') echo 'disabled'; ?>>Deposit</button>
						<button class="btn btn-primary" onclick="location.href='closeacc.php?acc=<?php echo $profile_id; ?>'"<?php if ($row['status']=='closed') echo 'disabled'; ?>>Close account</button>
						<div class="btn-group" role="group">
							<button id="viewreport" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								View report
							</button>
							<div class="dropdown-menu" aria-labelledby="viewreport">
								<a class="dropdown-item" href="depositreport.php?acc=<?php echo $profile_id; ?>">Account report</a>
								<a class="dropdown-item" href="loanreport.php?acc=<?php echo $row['account_no']; ?>">Loan report</a>
							</div>
						</div>
					</div>	
				</div>
			</div>

			<!-- Display message -->
			<?php if (isset($_SESSION['msg'])): ?>
				<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
				<!-- Insert message -->
				<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
					<?php echo $msg['insert_msg']; ?>
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<?php if (isset($msg['upload_msg'])): ?>
					<?php if ($msg['upload_err']==1): ?>
						<div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
							<?php echo $msg['upload_msg']; ?>
							<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
								<span aria-hidden='true'>&times;</span>
							</button>
						</div>
					<?php endif ?>
				<?php endif ?>
			<?php endif ?>


			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link <?php if(!(isset($_GET['acc']) || isset($_GET['loan']))){ echo 'active'; } ?>" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="<?php if(!isset($_GET['acc'])){ echo 'true'; } ?>">Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($_GET['acc'])){ echo 'active'; } ?>" id="account-tab" data-toggle="tab" href="#account_details" role="tab" aria-controls="account_details" aria-selected="<?php if(isset($_GET['acc'])){ echo 'true'; } ?>">Account details</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($_GET['loan'])){ echo 'active'; } ?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Loan details</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<!-- Profile tab -->
				<div class="tab-pane fade <?php if(!(isset($_GET['acc']) || isset($_GET['loan']))){ echo 'show active'; } ?>" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
						<div class="row p-2">
							<div class="col col-md-4 p-2">
								<?php if ((!empty($row['photo'])) && file_exists($row['photo'])): ?>
								<img style="max-width: 150px;" class="img-fluid" src="<?php echo $row['photo']; ?>" alt="profile picture">
								<?php else: ?>
									<img style="max-width: 150px;" class="img-fluid" src="assets/img/profile-placeholder.jpg" alt="default profile picture">
								<?php endif ?>
							</div>
							<div class="col offset-md-3 col-md-5 p-2 media">
								<?php if ((!empty($row['signature'])) && file_exists($row['signature'])): ?>
								<img class="img-fluid img-thumbnail align-self-end" src="<?php echo $row['signature']; ?>" alt="default profile picture">
								<?php else: ?>
									<img class="img-fluid img-thumbnail align-self-end" src="assets/img/placeholder-signature.jpg" alt="default profile picture">
								<?php endif ?>
							</div>
						</div>
						<?php if ($row['status']=='active'): ?>
							<div class="row p-2 ">
								<div class="col"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePhotoModal">Change photo</button></div>
								<div class="col text-right">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeSignatureModal">Change Signature</button>
								</div>
							</div>
						<?php endif ?>
						<div class="row p-2">
							<div class="col">Name :</div>
							<div class="col"><b><?php echo $row['member_name']; ?></b></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Account number :</div>
							<div class="col"><b><?php echo $row['account_no']; ?></b></div>
						</div>
						<div class="row p-2">
							<div class="col">Age :</div>
							<div class="col"><?php echo $row['member_age']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Father's name :</div>
							<div class="col"><?php echo $row['father_name']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Present address :</div>
							<div class="col"><?php echo $row['present_address']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col"></div>
							<div class="col">Pin code: <?php echo $row['present_pincode']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Permanent address :</div>
							<div class="col"><?php echo $row['permanent_address']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col"></div>
							<div class="col">Pin code: <?php echo $row['permanent_pincode']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Phone number :</div>
							<div class="col"><?php echo $row['member_phone']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Installment :</div>
							<div class="col">Rs. <?php echo $row['instalment']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Mode :</div>
							<div class="col"><?php echo $row['mode']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Period :</div>
							<div class="col"><?php echo $row['period']; ?> months</div>
						</div>
						<div class="row p-2">
							<div class="col">Occupation :</div>
							<div class="col"><?php echo $row['occupation']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Nominee name :</div>
							<div class="col"><?php echo $row['nominee_name']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Nominee age :</div>
							<div class="col"><?php echo $row['nominee_age']; ?> years</div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Relationship :</div>
							<div class="col"><?php echo $row['relationship']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Joining agent :</div>
							<div class="col">
								<?php 
								$cndtn = "agent_id=".$row['joining_agent'];
								$result_joining_agnt = $display->disp_cond("agents", $cndtn);
								$row_joining_agent = mysqli_fetch_assoc($result_joining_agnt);
								echo $row_joining_agent['agent_name'];
								?>
							</div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Current agent :</div>
							<div class="col">
								<?php 
								$cndtn = "agent_id=".$row['current_agent'];
								$result_joining_agnt = $display->disp_cond("agents", $cndtn);
								$row_current_agent = mysqli_fetch_assoc($result_joining_agnt);
								echo $row_current_agent['agent_name'];
								?>
							</div>
						</div>
						<div class="row p-2">
							<div class="col">Joining date :</div>
							<div class="col"><?php echo $row['joining_date']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Last updated on :</div>
							<div class="col"><?php echo $row['last_updated_on']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Status :</div>
							<div class="col <?php if($row['status']=='closed') echo 'text-danger'; else echo 'text-success'; ?>"><b><?php echo $row['status']; ?></b></div>
						</div>
					</div>
				</div>
				<!-- Account tab -->
				<div class="tab-pane fade <?php if(isset($_GET['acc'])){ echo 'show active'; } ?>" id="account_details" role="tabpanel" aria-labelledby="account-tab">
					<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
						<div class="row p-2">
							<div class="col">Name :</div>
							<div class="col"><?php echo $row['member_name']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Account number :</div>
							<div class="col"><?php echo $row['account_no']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Current balance :</div>
							<div class="col">
								<?php 
								$current_balance = $display->display_current_balance($row['account_no']);
								$row_cb = mysqli_fetch_assoc($current_balance);
								if (empty($row_cb['current_balance'])) {
									echo "N/A";
								}else{
									echo $row_cb['current_balance'];
								}
								?>
							</div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Period :</div>
							<div class="col"><?php echo $row['period']; ?> months</div>
						</div>
						<div class="row p-2">
							<div class="col">Installment :</div>
							<div class="col">Rs. <?php echo $row['instalment']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Mode :</div>
							<div class="col"><?php echo $row['mode']; ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Opening date :</div>
							<div class="col"><?php echo $row['joining_date']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Closing date :</div>
							<div class="col">
								<?php
								$closing_date = date('Y-m-d', strtotime("+".$row['period']." months", strtotime($row['joining_date'])));
								echo $closing_date;
								?>
							</div>
						</div>
						<div class="row p-2">
							<div class="col col-md-6">Rate of interest :</div>
							<div class="col"><?php if($row['rate_of_interest']=="") echo "Not set"; else echo $row['rate_of_interest']."%"; ?></div> 
							<?php if ($row['status']!='closed'): ?>
								<div class="col">
									<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changerate">Set rate of interest</button>
								</div>
							<?php endif ?>
						</div>
					</div>
				</div>
				<!-- Loan Tab -->
				<div class="tab-pane fade <?php if(isset($_GET['loan'])){ echo 'show active'; } ?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<?php 
					$cndtn = "acc_no=".$profile_id;
					$loan_res = $display->disp_cond("loans", $cndtn);
					$num_loan = mysqli_num_rows($loan_res);
			// echo $num_loan;
					?>
					<?php if ($num_loan==1): ?>
						<?php $loan_row = mysqli_fetch_assoc($loan_res); ?>
						<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
							<div class="row p-2 mt-2 mb-2">
								<div class="col">
									<button class="btn btn-primary" type="button" onclick="location.href='pay_installment.php?loan=<?php echo $loan_row['loan_id'] ?>'" <?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Pay Installment</button>
								</div>
								<div class="col text-right">
									<button type="button" class="btn btn-danger closeloanbtn" data-toggle="modal" data-target="#closeloanmodal" data-id="<?php echo $loan_row['loan_id']; ?>"<?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Close loan</button>
								</div>
							</div>
							<div class="row p-1">
								<div class="col">Name :</div>
								<div class="col"><b><?php echo $row['member_name']; ?></b></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Loan id :</div>
								<div class="col"><b><?php echo $loan_row['loan_id']; ?></b></div>
							</div>
							<div class="row p-1">
								<div class="col">Loan amount :</div>
								<div class="col"><b>Rs. <?php echo $loan_row['loan_amount']; ?></b></div>
							</div>
							<div class="row p-2 bg-light-gray">
								<div class="col">Amount paid :</div>
								<div class="col"><b>
									<?php 
									$total_amount = $display->total_loan_amt_paid($loan_row['loan_id']);
									if ($total_amount) {
										echo "Rs. ".$total_amount;
									}else{
										echo "N/A";
									}
									?></b>
								</div>
							</div>
							<div class="row p-1">
								<div class="col">Loan installment :</div>
								<div class="col">Rs. <?php echo $loan_row['installment']; ?></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Loan period :</div>
								<div class="col"><?php echo $loan_row['period'].' '.$loan_row['mode']; ?></div>
							</div>
							<div class="row p-1">
								<div class="col">Rate of interest :</div>
								<div class="col">
									<?php echo $loan_row['rate_of_interest'].'% '.$loan_row['interest_calculated']; ?>
								</div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Guarantor name :</div>
								<div class="col"><?php echo $loan_row['guarantor_name']; ?></div>
							</div>
							<div class="row p-1">
								<div class="col">Security particulars :</div>
								<div class="col"><?php echo $loan_row['security_particulars']; ?></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Loan purpose :</div>
								<div class="col"><?php if(!empty($loan_row['loan_purpose'])) echo $loan_row['loan_purpose']; else echo "N/A"; ?></div>
							</div>
							<div class="row p-1">
								<div class="col">Loan date :</div>
								<div class="col"><?php echo $loan_row['loan_date']; ?></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Closing date :</div>
								<div class="col"><?php echo $loan_row['closing_date']; ?></div>
							</div>
							<div class="row p-1">
								<div class="col">Loan status :</div>
								<div class="col <?php if($loan_row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $loan_row['status']; ?></div>
							</div>
						</div>
						<?php else: ?>
							<div class="container p-5">
								<div class="row">
									<div class="col-3">
										<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
											<?php $i = 1; ?>
											<?php while($loan_row = mysqli_fetch_assoc($loan_res)){ ?>
												<a class="nav-link <?php if(($i==1) && (!isset($_GET['loan']))) echo 'active'; elseif($_GET['loan']==$loan_row['loan_id']) echo 'active'; ?>" id="v-pills-loan-<?php echo $i; ?>-tab" data-toggle="pill" href="#v-pills-loan-<?php echo $i; ?>" role="tab" aria-controls="v-pills-loan-<?php echo $i; ?>" aria-selected="true">Loan <?php echo $i; if($loan_row['status']!='active') echo ' (closed)'; ?></a>
												<?php $i++; ?>
											<?php }
											mysqli_data_seek($loan_res,0);
											?>
										</div>
									</div>
									<div class="col-9">
										<div class="tab-content" id="v-pills-tabContent">
											<?php $i = 1; ?>
											<?php while($loan_row = mysqli_fetch_assoc($loan_res)){ ?>
												<div class="tab-pane fade show <?php if(($i==1) && (!isset($_GET['loan']))) echo 'active'; elseif($_GET['loan']==$loan_row['loan_id']) echo 'active'; ?>" id="v-pills-loan-<?php echo $i; ?>" role="tabpanel" aria-labelledby="v-pills-loan-<?php echo $i; ?>-tab">
													<div class="offset-md-2 col-md-8 text-left border rounded">
														<div class="row p-2 mt-2 mb-2">
															<div class="col">
																<button class="btn btn-primary" type="button" onclick="location.href='pay_installment.php?loan=<?php echo $loan_row['loan_id'] ?>'" <?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Pay Installment for loan <?php echo $i; ?></button>
															</div>
															<div class="col text-right">
																<button type="button" class="btn btn-danger closeloanbtn" data-toggle="modal" data-target="#closeloanmodal" data-id="<?php echo $loan_row['loan_id']; ?>"<?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Close loan</button>
															</div>
														</div>
														<div class="row p-1">
															<div class="col">Name :</div>
															<div class="col"><b><?php echo $row['member_name']; ?></b></div>
														</div>
														<div class="row p-1 bg-light-gray">
															<div class="col">Loan id :</div>
															<div class="col"><b><?php echo $loan_row['loan_id']; ?></b></div>
														</div>
														<div class="row p-1">
															<div class="col">Loan amount :</div>
															<div class="col"><b>Rs. <?php echo $loan_row['loan_amount']; ?></b></div>
														</div>
														<div class="row p-2 bg-light-gray">
															<div class="col">Amount paid :</div>
															<div class="col"><b>
																<?php 
																$total_amount = $display->total_loan_amt_paid($loan_row['loan_id']);
																if ($total_amount) {
																	echo "Rs. ".$total_amount;
																}else{
																	echo "N/A";
																}
																?></b>
															</div>
														</div>
														<div class="row p-1">
															<div class="col">Loan installment :</div>
															<div class="col">Rs. <?php echo $loan_row['installment']; ?></div>
														</div>
														<div class="row p-1 bg-light-gray">
															<div class="col">Loan period :</div>
															<div class="col"><?php echo $loan_row['period'].' '.$loan_row['mode']; ?></div>
														</div>
														<div class="row p-1">
															<div class="col">Rate of interest :</div>
															<div class="col">
																<?php echo $loan_row['rate_of_interest'].'% '.$loan_row['interest_calculated']; ?>
															</div>
														</div>
														<div class="row p-1 bg-light-gray">
															<div class="col">Guarantor name :</div>
															<div class="col"><?php echo $loan_row['guarantor_name']; ?></div>
														</div>
														<div class="row p-1">
															<div class="col">Security particulars :</div>
															<div class="col"><?php echo $loan_row['security_particulars']; ?></div>
														</div>
														<div class="row p-1 bg-light-gray">
															<div class="col">Loan purpose :</div>
															<div class="col"><?php if(!empty($loan_row['loan_purpose'])) echo $loan_row['loan_purpose']; else echo "N/A"; ?></div>
														</div>
														<div class="row p-1">
															<div class="col">Loan date :</div>
															<div class="col"><?php echo $loan_row['loan_date']; ?></div>
														</div>
														<div class="row p-1 bg-light-gray">
															<div class="col">Closing date :</div>
															<div class="col"><?php echo $loan_row['closing_date']; ?></div>
														</div>
														<div class="row p-1">
															<div class="col">Loan status :</div>
															<div class="col <?php if($loan_row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $loan_row['status']; ?></div>
														</div>
													</div>
												</div>
												<?php $i++; ?>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif ?>
					</div>
				</div>

				<!-- Close loan modal -->
				<div class="modal fade" id="closeloanmodal" tabindex="-1" role="dialog" aria-labelledby="closeloanmodalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/close_loan_action.php" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="closeloanmodalLabel">Close loan</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Are you sure you want to close loan?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
									<input type="hidden" name="close_loan_id" id="close_loan_id" value="">
									<input type="hidden" name="account_no" value="<?php echo $profile_id; ?>">
									<button type="submit" name="close_loan" class="btn btn-primary">Yes</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Change Rate of interest modal -->
				<div class="modal fade" id="changerate" tabindex="-1" role="dialog" aria-labelledby="changeratemodal" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/changeinterest.php" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="changeratemodal">Select profile photo</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Enter rate of interest -->
									<div class="form-group">
										<div class="form-row">
											<label for="rate">Enter rate of interest</label>
											<div class="input-group">
												<input name="rate_of_interest" class="form-control" id="rate" type="text" data-validation="number" data-validation-allowing="float">
												<div class="input-group-append">
													<div class="input-group-text">%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
									<button type="submit" name="change_interest" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Change photo modal -->
				<div class="modal fade" id="changePhotoModal" tabindex="-1" role="dialog" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/change_image.php" method="POST" enctype="multipart/form-data">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="changePhotoModalLabel">Select profile photo</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Photograph -->
									<div class="input-group mb-3">
										<div class="custom-file">
											<input name="photograph" type="file" class="custom-file-input" id="inputGroupFile01">
											<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
									<button type="submit" name="change_member_photo" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- Change signature modal -->
				<div class="modal fade" id="changeSignatureModal" tabindex="-1" role="dialog" aria-labelledby="changeSignatureModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/change_image.php" method="POST" enctype="multipart/form-data">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="changeSignatureModalLabel">Select Signature</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Photograph -->
									<div class="input-group mb-3">
										<div class="custom-file">
											<input name="signature" type="file" class="custom-file-input" id="inputGroupFile01">
											<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="account_no" value="<?php echo $row['account_no']; ?>">
									<button type="submit" name="change_signature" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php endif ?>






			<?php if ($profile_type=="staff"): ?>
				<?php 
				$cndtn = "user_id=".$profile_id;
				$result = $display->disp_cond("users", $cndtn);
				$row = mysqli_fetch_assoc($result);
				?>

				<!-- Display message -->
				<?php if (isset($_SESSION['msg'])): ?>
					<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
					<!-- Insert message -->
					<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
						<?php echo $msg['insert_msg']; ?>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
					</div>

					<?php if (isset($msg['upload_err'])): ?>
						<?php if ($msg['upload_err']==1): ?>
							<div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
								<?php echo $msg['upload_msg']; ?>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							</div>
						<?php endif ?>
					<?php endif ?>
				<?php endif ?>

				<!-- Top buttons -->
				<div class="row">
					<div class="col offset-md-2">
						<div class="btn-group" role="group">
							<button class="btn btn-primary" type="button" onclick="location.href='edit.php?staff=<?php echo $profile_id; ?>'">Edit profile</button>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
							<?php if ($_SESSION['login_role']=="admin"): ?>						
								<button class="btn btn-primary" data-toggle="modal" data-target="#suspendAccount"><?php if($row['status']=='active') echo 'Suspend'; else echo 'Activate'; ?> account</button>
							<?php endif ?>
						</div>	
					</div>
				</div>

				<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
					<div class="row p-2">
						<div class="col">Name :</div>
						<div class="col"><b><?php echo $row['name']; ?></b></div>
					</div>
					<div class="row p-2 bg-light-gray">
						<div class="col">Username :</div>
						<div class="col"><?php echo $row['user_name']; ?></div>
					</div>
					<div class="row p-2">
						<div class="col">Phone :</div>
						<div class="col"><?php echo $row['phone']; ?></div>
					</div>
					<div class="row p-2 bg-light-gray">
						<div class="col">Address :</div>
						<div class="col"><?php echo $row['address']; ?></div>
					</div>
					<div class="row p-2">
						<div class="col">Account status :</div>
						<div class="col"><?php echo $row['status']; ?></div>
					</div>
				</div>


				<!-- Change Password modal -->
				<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/change_password.php" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<div class="form-row">
											<label for="exampleInputPassword1">Enter Password</label>
											<input name="password" class="form-control" id="exampleInputPassword1" type="password" placeholder="Password">
										</div>
									</div>
									<div class="form-group">
										<div class="form-row">
											<label for="exampleConfirmPassword">Confirm password</label>
											<input name="cnf-pass" class="form-control" id="exampleConfirmPassword" type="password" placeholder="Confirm password" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Entered value do not match with your password.">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="role" value="<?php echo $row['user_role']; ?>">
									<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
									<button type="submit" name="change_password" class="btn btn-primary">Update password</button>
								</div>
							</div>
						</form>
					</div>
				</div>


				<!-- suspend account modal -->
				<div class="modal fade" id="suspendAccount" tabindex="-1" role="dialog" aria-labelledby="suspendAccountLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/suspend_account.php" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="suspendAccountLabel"><?php if($row['status']=='active') echo 'Suspend'; else echo 'Activate'; ?> Account</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Are you sure you want to <?php if($row['status']=='active') echo 'suspend'; else echo 'activate'; ?> account?<br>
									Click 'yes' to proceed.
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
									<button type="submit" name="suspend_account" class="btn btn-primary">Yes</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php endif ?>



			<?php if ($profile_type=="agent"): ?>

				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="dashboard.php">Dashboard</a>
					</li>
					<li class="breadcrumb-item">
						<a href="viewagent.php">All agents</a>
					</li>
					<li class="breadcrumb-item active">Agent profile</li>
				</ol>

				<!-- Display message -->
				<?php if (isset($_SESSION['msg'])): ?>
					<?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
					<!-- Insert message -->
					<div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
						<?php echo $msg['insert_msg']; ?>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
					</div>

					<?php if (isset($msg['upload_err'])): ?>
						<?php if ($msg['upload_err']==1): ?>
							<div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
								<?php echo $msg['upload_msg']; ?>
								<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
									<span aria-hidden='true'>&times;</span>
								</button>
							</div>
						<?php endif ?>
					<?php endif ?>
				<?php endif ?>

				<?php 
				$cndtn = "agent_id=".$profile_id;
				$result = $display->disp_cond("agents", $cndtn);
				$row = mysqli_fetch_assoc($result);
				?>

				<?php if ($_SESSION['login_role']=='admin'): ?>
					<!-- Top buttons -->
					<div class="row">
						<div class="col offset-md-2">
							<div class="btn-group" role="group">
								<button class="btn btn-primary" type="button" onclick="location.href='edit.php?agent=<?php echo $profile_id; ?>'" <?php if($row['status']!='active') echo 'disabled'; ?>>Edit profile</button>						
								<button class="btn btn-primary" data-toggle="modal" data-target="#deactivateAccount"><?php if($row['status']=='active') echo 'Deactivate'; else echo 'Activate'; ?> account</button>
							</div>	
						</div>
					</div>	
				<?php endif ?>


				<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
					<div class="row p-2">
						<div class="col col-3 pt-3">
							<?php if ((!empty($row['profile_pic'])) && file_exists($row['profile_pic'])): ?>
							<img class="img-fluid" src="<?php echo $row['profile_pic']; ?>" alt="default profile picture">
							<?php else: ?>
								<img class="img-fluid" src="assets/img/profile-placeholder.jpg" alt="default profile picture">
							<?php endif ?>
						</div>
					</div>
					<?php if (($row['status']=='active')&&($_SESSION['login_role']=='admin')): ?>
						<div class="row p-2 ">
							<div class="col">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePhotoModal">Change photo</button>
							</div>
						</div>
					<?php endif ?>
					<div class="row p-2">
						<div class="col">Name :</div>
						<div class="col"><b><?php echo $row['agent_name']; ?></b></div>
					</div>
					<div class="row p-2 bg-light-gray">
						<div class="col">Phone :</div>
						<div class="col"><?php echo $row['phno']; ?></div>
					</div>
					<div class="row p-2">
						<div class="col">Address :</div>
						<div class="col"><?php echo $row['address']; ?></div>
					</div>
					<div class="row p-2 bg-light-gray">
						<div class="col">Age :</div>
						<div class="col"><?php echo $row['age']; ?></div>
					</div>
					<div class="row p-2">
						<div class="col">Email :</div>
						<div class="col"><?php echo $row['email']; ?></div>
					</div>
					<div class="row p-2 bg-light-gray">
						<div class="col">Account status :</div>
						<div class="col <?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><b><?php echo $row['status']; ?></b></div>
					</div>
				</div>

				<!-- suspend account modal -->
				<div class="modal fade" id="deactivateAccount" tabindex="-1" role="dialog" aria-labelledby="deactivateAccountLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/deactivate_agent.php" method="POST">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="deactivateAccountLabel"><?php if($row['status']=='active') echo 'Deactivate'; else echo 'Activate'; ?> Account</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									Are you sure you want to <?php if($row['status']=='active') echo 'deactivate'; else echo 'activate'; ?> account?<br>
									Click 'yes' to proceed.
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="agent_id" value="<?php echo $profile_id; ?>">
									<button type="submit" name="deactivate_account" class="btn btn-primary">Yes</button>
								</div>
							</div>
						</form>
					</div>
				</div>


				<!-- Change photo modal -->
				<div class="modal fade" id="changePhotoModal" tabindex="-1" role="dialog" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<form action="action/change_image.php" method="POST" enctype="multipart/form-data">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="changePhotoModalLabel">Select profile photo</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Photograph -->
									<div class="input-group mb-3">
										<div class="custom-file">
											<input name="photograph" type="file" class="custom-file-input" id="inputGroupFile01">
											<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<input type="hidden" name="agent_id" value="<?php echo $row['agent_id']; ?>">
									<button type="submit" name="change_agent_photo" class="btn btn-primary">Save changes</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			<?php endif ?>


<!-- if ($profile_type=="admin") {
$cndtn = "user_id=".$profile_id;
$result = $display->disp_cond("users", $cndtn);

// Displays admin profile
} -->

<?php include('template/foot.php'); ?>