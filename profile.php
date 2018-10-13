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
			$cndtn = "mem_id=".$profile_id;
			$result = $display->disp_cond("members", $cndtn);
			// Displays member profile 
			$row = mysqli_fetch_assoc($result);
			?>

			<!-- Button group -->
			<div class="row">
				<div class="col mb-3 p-3">
					<div class="btn-group" role="group">
						<button class="btn btn-primary" type="button" onclick="location.href='edit.php?mem=<?php echo $profile_id; ?>'" <?php if ($row['status']=='closed') echo 'disabled'; ?>>Edit profile</button>
						<button class="btn btn-primary" onclick="location.href='new_deposit_acc.php?mem=<?php echo $profile_id; ?>'"<?php if ($row['status']=='closed') echo 'disabled'; ?>>New deposit account</button>
						<button class="btn btn-primary" onclick="location.href='newloan.php?mem=<?php echo $profile_id; ?>'"<?php if ($row['status']=='closed') echo 'disabled'; ?>>New loan</button>
						<div class="btn-group" role="group">
							<button id="viewreport" type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								View report
							</button>
							<div class="dropdown-menu" aria-labelledby="viewreport">
								<a class="dropdown-item" href="depositreport.php?mem=<?php echo $profile_id; ?>">Account report</a>
								<a class="dropdown-item" href="loanreport.php?mem=<?php echo $profile_id; ?>">Loan report</a>
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
					<a class="nav-link <?php if(isset($_GET['acc'])){ echo 'active'; } ?>" id="account-tab" data-toggle="tab" href="#account_details" role="tab" aria-controls="account_details" aria-selected="<?php if(isset($_GET['acc'])){ echo 'true'; } ?>">Deposit accounts</a>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php if(isset($_GET['loan'])){ echo 'active'; } ?>" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Loan Accounts</a>
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
						<div class="row p-2">
							<div class="col">Age :</div>
							<div class="col"><?php echo $row['member_age']; ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Father's / Husband's name :</div>
							<div class="col"><?php echo $row['f_h_name']; ?></div>
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
						<div class="row p-2">
							<div class="col">Occupation :</div>
							<div class="col"><?php echo $row['occupation']; ?></div>
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
						<div class="row p-2 bg-light-gray">
							<div class="col">Created by :</div>
							<div class="col"><?php echo $display->get_user_name($row['added_by']); ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Created on :</div>
							<div class="col"><?php echo $display->date_dmy($row['added_on']); ?></div>
						</div>
						<div class="row p-2 bg-light-gray">
							<div class="col">Last updated on :</div>
							<div class="col"><?php echo $display->date_dmy($row['last_updated_on']); ?></div>
						</div>
						<div class="row p-2">
							<div class="col">Status :</div>
							<div class="col <?php if($row['status']=='closed') echo 'text-danger'; else echo 'text-success'; ?>"><b><?php echo $row['status']; ?></b></div>
						</div>
					</div>
				</div>
				<!-- Account tab -->
				<?php 
				$cond = "mem_id=".$row['mem_id'];
				$res_acc = $display->disp_cond("deposit_accounts",$cond);
				?>
				<div class="tab-pane fade <?php if(isset($_GET['acc'])){ echo 'show active'; } ?>" id="account_details" role="tabpanel" aria-labelledby="account-tab">
					<?php if (mysqli_num_rows($res_acc)==0): ?>
						<div class="mx-auto py-4 text-center">
							NO DEPOSIT ACOUNT FOUND
						</div>
					<?php endif ?>
					<?php if (mysqli_num_rows($res_acc)==1): ?>
						<?php $row_acc = mysqli_fetch_assoc($res_acc); ?>
						<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
							<div class="row p-2 mt-2 mb-2">
								<div class="col">
									<button class="btn btn-primary" type="button" onclick="location.href='makedeposit.php?acc=<?php echo $row_acc['acc_id'] ?>'" <?php if ($row_acc['status']=='closed') echo 'disabled'; ?>>
										Make deposit
									</button>
									<button class="btn btn-primary" type="button" onclick="location.href='withdraw.php?acc=<?php echo $row_acc['acc_id'] ?>'" <?php if ($row_acc['status']=='closed') echo 'disabled'; ?>>
										Withdraw
									</button>
								</div>
								<div class="col text-right">
									<?php if ($_SESSION['login_role']=='admin'): ?>
										<button class="btn btn-warning" onclick="location.href='reopen.php?mem=<?php echo $row_acc['mem_id']; ?>&acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']=='active') echo 'hidden'; ?>>Reopen account</button>
										<button class="btn btn-primary" onclick="location.href='edit.php?acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']!='active') echo 'hidden'; ?>>Edit account</button>
									<?php endif ?>
									<button class="btn btn-danger" onclick="location.href='closeacc.php?acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']=='closed') echo 'disabled'; ?>>Close account</button>
								</div>
							</div>
							<div class="row p-2">
								<div class="col">Name :</div>
								<div class="col"><?php echo $row['member_name']; ?></div>
							</div>
							<div class="row p-2 bg-light-gray">
								<div class="col">Account number :</div>
								<div class="col"><?php echo $row_acc['account_no']; ?></div>
							</div>
							<div class="row p-2">
								<div class="col">Current balance :</div>
								<div class="col">
									<b>Rs. <?php echo $display->current_balance($row_acc['acc_id']); ?></b>
								</div>
							</div>
							<div class="row p-2 bg-light-gray">
								<div class="col">Period :</div>
								<div class="col"><?php echo $row_acc['period']; ?> months</div>
							</div>
							<div class="row p-2">
								<div class="col">Installment :</div>
								<div class="col">Rs. <?php echo $row_acc['installment']; ?></div>
							</div>
							<div class="row p-2 bg-light-gray">
								<div class="col">Mode :</div>
								<div class="col"><?php echo $row_acc['mode']; ?></div>
							</div>
							<div class="row p-2">
								<div class="col">Opening date :</div>
								<div class="col"><?php echo $display->date_dmY($row_acc['joining_date']); ?></div>
							</div>
							<div class="row p-2 bg-light-gray">
								<div class="col">Closing date :</div>
								<div class="col">
									<?php
									$closing_date = date('d-M-Y', strtotime("+".($row_acc['period']+1)." months", strtotime($row_acc['joining_date'])));
									echo $display->date_dmy($closing_date);
									?>
								</div>
							</div>
							<div class="row p-2">
								<div class="col col-md-6">Rate of interest :</div>
								<div class="col"><?php if($row_acc['rate_of_interest']=="") echo "Not set"; else echo $row_acc['rate_of_interest']."%"; ?></div>
							</div>
							<div class="row p-2">
								<div class="col">Account status :</div>
								<div class="col <?php if($row_acc['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $row_acc['status']; ?></div>
							</div>
							<?php if ($row_acc['status']=='closed'): ?>
								<div class="row p-2">
									<div class="col">Account closed by :</div>
									<div class="col"><?php echo $display->account_closed_by($row_acc['acc_id']); ?></div>
								</div>
							<?php endif ?>
						</div>
					<?php endif ?>
					<?php if (mysqli_num_rows($res_acc)>1): ?>
						<div class="container p-5">
							<div class="row">
								<div class="col-2">
									<div class="nav flex-column nav-pills" id="v-pills-tab-acc" role="tablist" aria-orientation="vertical">
										<?php $i = 1;
										$active_acc_counter = 1;
										if (isset($_GET['acc'])) {
											while($row_acc = mysqli_fetch_assoc($res_acc)){
												if ($_GET['acc']==$row_acc['acc_id']){
													$active_acc_counter = $i;
												}
												$i++;
											}
											mysqli_data_seek($res_acc,0);
										}
										?>

										<?php $i = 1; ?>
										<?php while($row_acc = mysqli_fetch_assoc($res_acc)){ ?>
											<a class="nav-link <?php if($i==$active_acc_counter) echo 'active'; ?>" id="v-pills-acc-<?php echo $i; ?>-tab" data-toggle="pill" href="#v-pills-acc-<?php echo $i; ?>" role="tab" aria-controls="v-pills-acc-<?php echo $i; ?>" aria-selected="true">Account <?php echo $i; if($row_acc['status']!='active') echo ' (closed)'; ?></a>
											<?php $i++; ?>
										<?php }
										mysqli_data_seek($res_acc,0);
										?>
									</div>
								</div>
								<div class="col-10">
									<div class="tab-content" id="v-pills-tab-accContent">
										<?php $i = 1; ?>
										<?php while($row_acc = mysqli_fetch_assoc($res_acc)){ ?>
											<div class="tab-pane fade show <?php if($i==$active_acc_counter) echo 'active'; ?>" id="v-pills-acc-<?php echo $i; ?>" role="tabpanel" aria-labelledby="v-pills-acc-<?php echo $i; ?>-tab">
												<div class="offset-md-2 text-left border rounded">
													<div class="row p-2 mt-2 mb-2">
														<div class="col">
															<button class="btn btn-primary" type="button" onclick="location.href='makedeposit.php?acc=<?php echo $row_acc['acc_id'] ?>'" <?php if ($row_acc['status']=='closed') echo 'disabled'; ?>>
																Make deposit for account <?php echo $i; ?>
															</button>
															<button class="btn btn-primary" type="button" onclick="location.href='withdraw.php?acc=<?php echo $row_acc['acc_id'] ?>'" <?php if ($row_acc['status']=='closed') echo 'disabled'; ?>>
																Withdraw <?php echo $i; ?>
															</button>
														</div>
														<div class="col text-right">
															<?php if ($_SESSION['login_role']=='admin'): ?>
																<button class="btn btn-warning" onclick="location.href='reopen.php?mem=<?php echo $row_acc['mem_id']; ?>&acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']=='active') echo 'hidden'; ?>>Reopen account</button>
																<button class="btn btn-primary" onclick="location.href='edit.php?acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']!='active') echo 'hidden'; ?>>Edit account</button>
															<?php endif ?>
															<button class="btn btn-primary" onclick="location.href='closeacc.php?acc=<?php echo $row_acc['acc_id']; ?>'"<?php if ($row_acc['status']=='closed') echo 'hidden'; ?>>Close account</button>
														</div>
													</div>
													<div class="row p-1">
														<div class="col">Name :</div>
														<div class="col"><b><?php echo $row['member_name']; ?></b></div>
													</div>
													<div class="row p-1 bg-light-gray">
														<div class="col">Account no. :</div>
														<div class="col"><b><?php echo $row_acc['account_no']; ?></b></div>
													</div>
													<div class="row p-1">
														<div class="col">Installment amount :</div>
														<div class="col"><b>Rs. <?php echo $row_acc['installment']; ?></b></div>
													</div>
													<div class="row p-2 bg-light-gray">
														<div class="col">Current Balance :</div>
														<div class="col">
															<b>Rs. <?php echo $display->current_balance($row_acc['acc_id']); ?></b>
														</div>
													</div>
													<div class="row p-2 bg-light-gray">
														<div class="col">Period :</div>
														<div class="col"><?php echo $row_acc['period']; ?> months</div>
													</div>
													<div class="row p-2">
														<div class="col">Installment :</div>
														<div class="col">Rs. <?php echo $row_acc['installment']; ?></div>
													</div>
													<div class="row p-2 bg-light-gray">
														<div class="col">Mode :</div>
														<div class="col"><?php echo $row_acc['mode']; ?></div>
													</div>
													<div class="row p-2">
														<div class="col">Opening date :</div>
														<div class="col"><?php echo $display->date_dmy($row_acc['joining_date']); ?></div>
													</div>
													<div class="row p-2 bg-light-gray">
														<div class="col">Closing date :</div>
														<div class="col">
															<?php
															$closing_date = date('d-M-Y', strtotime("+".($row_acc['period']+1)." months", strtotime($row_acc['joining_date'])));
															echo $display->date_dmy($closing_date);
															?>
														</div>
													</div>
													<div class="row p-2">
														<div class="col col-md-6">Rate of interest :</div>
														<div class="col"><?php if($row_acc['rate_of_interest']=="") echo "Not set"; else echo $row_acc['rate_of_interest']."%"; ?></div>
													</div>
													<div class="row p-2">
														<div class="col">Account status :</div>
														<div class="col <?php if($row_acc['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $row_acc['status']; ?></div>
													</div>
													<?php if ($row_acc['status']=='closed'): ?>
														<div class="row p-2">
															<div class="col">Account closed by :</div>
															<div class="col"><?php echo $display->account_closed_by($row_acc['acc_id']); ?></div>
														</div>
													<?php endif ?>
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
				<!-- Loan Tab -->
				<div class="tab-pane fade <?php if(isset($_GET['loan'])){ echo 'show active'; } ?>" id="contact" role="tabpanel" aria-labelledby="contact-tab">
					<?php 
					$cndtn = "mem_id=".$profile_id;
					$loan_res = $display->disp_cond("loans", $cndtn);
					$num_loan = mysqli_num_rows($loan_res);
					?>
					<?php if ($num_loan==0): ?>
						<div class="mx-auto py-4 text-center">
							NO LOAN ACOUNT FOUND
						</div>
					<?php endif ?>
					<?php if ($num_loan==1): ?>
						<?php $loan_row = mysqli_fetch_assoc($loan_res); ?>
						<div class="offset-md-2 col-md-8 text-left border rounded mt-3">
							<div class="row p-2 mt-2 mb-2">
								<div class="col">
									<button class="btn btn-primary" type="button" onclick="location.href='pay_installment.php?loan=<?php echo $loan_row['loan_id'] ?>'" <?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Pay Installment</button>
								</div>
								<div class="col text-right">
									<?php if ($_SESSION['login_role']=='admin'): ?>
										<button class="btn btn-primary" onclick="location.href='edit.php?loan=<?php echo $loan_row['loan_id']; ?>'"<?php if ($loan_row['status']!='active') echo 'hidden'; ?>>Edit loan</button>
										<?php if ($loan_row['status']=='closed'): ?>
											<a href="reopen.php?loan=<?php echo $loan_row['loan_id']; ?>" class="btn btn-primary">Reopen loan</a>
										<?php endif ?>
									<?php endif ?>
									<?php 
									$remaining_amt = ($loan_row['interest_amount']+$loan_row['loan_amount'])-$display->total_loan_amt_paid($loan_row['loan_id']);
									?>
									<button type="button" class="btn btn-danger closeloanbtn" data-toggle="modal" data-target="#closeloanmodal" data-id="<?php echo $loan_row['loan_id']; ?>"<?php if (($loan_row['status']=='closed')||($remaining_amt!=0)) echo 'disabled'; ?>>Close loan</button>
								</div>
							</div>
							<div class="row p-1">
								<div class="col">Name :</div>
								<div class="col"><b><?php echo $row['member_name']; ?></b></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Loan no :</div>
								<div class="col"><b><?php echo $loan_row['loan_no']; ?></b></div>
							</div>
							<div class="row p-1">
								<div class="col">Loan amount :</div>
								<div class="col"><b>Rs. <?php echo $loan_row['loan_amount']; ?></b></div>
							</div>
							<div class="row p-1">
								<div class="col">Interest amount :</div>
								<div class="col">Rs. <?php echo $loan_row['interest_amount']; ?></div>
							</div>
							<div class="row p-1">
								<div class="col">Total loan amount :</div>
								<div class="col">Rs. <?php echo ($loan_row['interest_amount']+$loan_row['loan_amount']); ?></div>
							</div>
							<div class="row p-1 bg-light-gray">
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
							<div class="row p-1 bg-light-gray">
								<div class="col">Remaining amount :</div>
								<div class="col"><b>Rs. <?php echo $remaining_amt; ?></b>
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
								<div class="col"><?php echo date("d-M-Y", strtotime($loan_row['loan_date'])); ?></div>
							</div>
							<div class="row p-1 bg-light-gray">
								<div class="col">Closing date :</div>
								<div class="col"><?php echo date("d-M-Y", strtotime($loan_row['closing_date'])); ?></div>
							</div>	
							<div class="row p-1">
								<div class="col">Loan status :</div>
								<div class="col <?php if($loan_row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $loan_row['status']; ?></div>
							</div>
							<?php if ($loan_row['status']=='closed'): ?>
								<div class="row p-2">
									<div class="col">Loan closed by :</div>
									<div class="col"><?php echo $display->loan_closed_by($loan_row['loan_id']); ?></div>
								</div>
							<?php endif ?>
						</div>
					<?php endif ?>

					<?php if ($num_loan>1): ?>
						<?php $i = 1;
						$active_loan_counter = 1;
						if (isset($_GET['loan'])) {
							while($loan_row = mysqli_fetch_assoc($loan_res)){
								if ($_GET['loan']==$loan_row['loan_id']){
									$active_loan_counter = $i;
								}
								$i++;
							}
							mysqli_data_seek($loan_res,0);
						}
						?>
						<div class="container p-5">
							<div class="row">
								<div class="col-3">
									<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
										<?php $i = 1; ?>
										<?php while($loan_row = mysqli_fetch_assoc($loan_res)){ ?>
											<a class="nav-link <?php if($i==$active_loan_counter) echo 'active'; elseif($_GET['loan']==$loan_row['loan_id']) echo 'active'; ?>" id="v-pills-loan-<?php echo $i; ?>-tab" data-toggle="pill" href="#v-pills-loan-<?php echo $i; ?>" role="tab" aria-controls="v-pills-loan-<?php echo $i; ?>" aria-selected="true">Loan <?php echo $i; if($loan_row['status']!='active') echo ' (closed)'; ?></a>
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
											<div class="tab-pane fade show <?php if($i==$active_loan_counter) echo 'active'; elseif($_GET['loan']==$loan_row['loan_id']) echo 'active'; ?>" id="v-pills-loan-<?php echo $i; ?>" role="tabpanel" aria-labelledby="v-pills-loan-<?php echo $i; ?>-tab">
												<div class="offset-md-2 p-3 text-left border rounded">
													<div class="row p-2 mt-2 mb-2">
														<div class="col">
															<button class="btn btn-primary" type="button" onclick="location.href='pay_installment.php?loan=<?php echo $loan_row['loan_id'] ?>'" <?php if ($loan_row['status']=='closed') echo 'disabled'; ?>>Pay Installment for loan <?php echo $i; ?></button>
														</div>
														<div class="col text-right">
															<?php if ($_SESSION['login_role']=='admin'): ?>
																<button class="btn btn-primary" onclick="location.href='edit.php?loan=<?php echo $loan_row['loan_id']; ?>'"<?php if ($loan_row['status']!='active') echo 'hidden'; ?>>Edit loan</button>
																<?php if ($loan_row['status']=='closed'): ?>
																	<a href="reopen.php?mem=<?php echo $loan_row['mem_id']; ?>&loan=<?php echo $loan_row['loan_id']; ?>" class="btn btn-primary">Reopen loan</a>
																<?php endif ?>
															<?php endif ?>
															<?php 
															$remaining_amt = ($loan_row['interest_amount']+$loan_row['loan_amount'])-$display->total_loan_amt_paid($loan_row['loan_id']);
															?>
															<button type="button" class="btn btn-danger closeloanbtn" data-toggle="modal" data-target="#closeloanmodal" data-id="<?php echo $loan_row['loan_id']; ?>"<?php if (($loan_row['status']=='closed')||($remaining_amt!=0)) echo 'disabled'; ?>>Close loan</button>
														</div>
													</div>
													<div class="row p-1">
														<div class="col">Name :</div>
														<div class="col"><b><?php echo $row['member_name']; ?></b></div>
													</div>
													<div class="row p-1 bg-light-gray">
														<div class="col">Loan no :</div>
														<div class="col"><b><?php echo $loan_row['loan_no']; ?></b></div>
													</div>
													<div class="row p-1">
														<div class="col">Loan amount :</div>
														<div class="col"><b>Rs. <?php echo $loan_row['loan_amount']; ?></b></div>
													</div>
													<div class="row p-1">
														<div class="col">Interest amount :</div>
														<div class="col">Rs. <?php echo $loan_row['interest_amount']; ?></div>
													</div>
													<div class="row p-1">
														<div class="col">Total loan amount :</div>
														<div class="col">Rs. <?php echo ($loan_row['interest_amount']+$loan_row['loan_amount']); ?></div>
													</div>
													<div class="row p-1 bg-light-gray">
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
													<div class="row p-1 bg-light-gray">
														<div class="col">Remaining amount :</div>
														<div class="col"><b>Rs. <?php echo $remaining_amt; ?></b>
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
														<div class="col"><?php echo date("d-M-Y", strtotime($loan_row['loan_date'])); ?></div>
													</div>
													<div class="row p-1 bg-light-gray">
														<div class="col">Closing date :</div>
														<div class="col"><?php echo date("d-M-Y", strtotime($loan_row['closing_date'])); ?></div>
													</div>
													<div class="row p-1">
														<div class="col">Loan status :</div>
														<div class="col <?php if($loan_row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $loan_row['status']; ?></div>
													</div>
													<?php if ($loan_row['status']=='closed'): ?>
														<div class="row p-2">
															<div class="col">Loan closed by :</div>
															<div class="col"><?php echo $display->loan_closed_by($loan_row['loan_id']); ?></div>
														</div>
													<?php endif ?>
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
								<input type="hidden" name="mem_id" value="<?php echo $profile_id; ?>">
								<button type="submit" name="close_loan" class="btn btn-primary">Yes</button>
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

	<?php if ($profile_type=="admin"): ?>
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
		<!-- Top buttons -->
		<div class="row">
			<div class="col offset-md-2">
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePasswordModal">Change Password</button>
				</div>	
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

	<?php endif ?>

	<?php include('template/foot.php'); ?>