<?php include('template/head.php'); ?>
<?php include('class/view.php') ?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item active">New member</li>
</ol>

<?php if (isset($_SESSION['msg'])): ?>
  <?php $msg = $_SESSION['msg']; unset($_SESSION['msg']); ?>
  <!-- Insert message -->
  <div class='alert alert-<?php if($msg['insert_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
    <?php echo $msg['insert_msg']; ?>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>

  <?php if ($msg['upload_err']==1): ?>
    <div class='alert alert-<?php if($msg['upload_err']==0){echo "success";}else{echo "danger";} ?> alert-dismissible fade show col-sm-11' role='alert'>
      <?php echo $msg['upload_msg']; ?>
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>
  <?php endif ?>
<?php endif ?>

<div class="card card-register mx-auto mt-5 border-primary">

	<div class="card-header bg-primary-light-2">New member</div>
	<div class="card-body">
		<form action="action/new_member.php" method="POST" enctype="multipart/form-data">

			<!-- Name -->
			<div class="form-group">
				<div class="form-row">
					<label for="exampleInputName">Name</label>
					<input name="member_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required custom" data-sanitize="trim capitalize" data-validation-regexp="^([a-zA-Z\s])+$" data-validation-error-msg="Enter full name">
				</div>
			</div>

			<!-- Age -->
			<div class="form-group">
				<div class="form-row">
					<label for="memberAge">Age</label>
					<div class="input-group">
						<input name="member_age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2">
						<div class="input-group-append">
							<div class="input-group-text">years</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Father's / Husband's Name -->
			<div class="form-group">
				<div class="form-row">
					<label for="fathersname">Father's / Husband's name</label>
					<input name="f_h_name" class="form-control" id="fathersname" type="text" aria-describedby="nameHelp" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
				</div>
			</div>

			<!-- Present address -->
			<div class="form-group">
				<div class="form-row">
					<label for="present_address">Present address</label>
					<textarea id="present_address" name="present_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address"></textarea>
				</div>
			</div>

			<div class="input-group input-group-sm mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
				</div>
				<input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="present_pincode" class="form-control" type="text" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6">
			</div>

			<!-- Permanent address -->
			<div class="form-group">
				<div class="form-row">
					<br>
					<label for="permanent_address">Permanent address</label>
				</div>

         <!--  <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="sameAbove">
            <label class="form-check-label" for="sameAbove">
              Same as above
            </label>
        </div> -->

        <div class="form-row">
        	<textarea id="permanent_address" name="permanent_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address"></textarea>
        </div>
    </div>


    <div class="input-group input-group-sm mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
    	</div>
    	<input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="permanent_pincode" class="form-control" type="text" placeholder="781023" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6">
    </div>


    <!-- Occupation -->
    <div class="form-group">
    	<div class="form-row">
    		<label>Occupation &emsp;</label>
    		<input name="occupation" type="text" class="form-control" data-validation="required custom" data-validation-regexp="^([a-zA-Z\s])+$" data-validation-error-msg="Enter valid occupation">
    	</div>
    </div>


    <!-- Phone -->
    <div class="form-group">
    	<div class="form-row">
    		<label for="phno">Phone</label>
    		<input class="form-control" type="text" name="member_phone" maxlength="10">
    	</div>
    </div>


    <!-- Agent -->
    <div class="form-group">
    	<div class="form-row">
    		<label for="agent">Agent name</label>
    		<div class="input-group">
    			<select class="form-control" name="joining_agent" data-validation="required">
    				<?php $display = new display();
    				$res_agents = $display->disp_all("agents"); ?>
    				<option selected disabled>Select</option>
    				<?php while ($row_agents = mysqli_fetch_assoc($res_agents)) { ?>
    					<?php if ($row_agents['status']=='active'): ?>
    						<option value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
    					<?php endif ?>
    				<?php } ?>
    			</select>
    		</div>
    	</div>
    </div>


    <!-- Photograph -->
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Photograph</span>
    	</div>
    	<div class="custom-file">
    		<input name="photograph" type="file" class="custom-file-input" id="inputGroupFile01">
    		<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
    	</div>
    </div>

    <!-- signature -->
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Signature</span>
    	</div>
    	<div class="custom-file">
    		<input name="signature" type="file" class="custom-file-input" id="inputGroupFile01">
    		<label class="custom-file-label" for="inputGroupFile01">Choose file</label>
    	</div>
    </div>

    <button type="submit" name="new_member" value="" class="btn btn-primary btn-block"> Submit </button>
</form>
</div>

</div>
<?php include('template/foot.php'); ?>