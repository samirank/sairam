<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Add member</li>
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
  <div class="card-header bg-primary-light-2">Add new member</div>
  <div class="card-body">
    <form action="action/newmembership.php" method="POST" enctype="multipart/form-data">

      <!-- Account number -->
      <div class="form-group">
        <div class="form-row">
          <label for="inputAccno">Account number</label>
          <input name="accno" class="form-control" id="inputAccno" type="text" aria-describedby="nameHelp" placeholder="12345" data-validation="required number server" data-validation-param-name="account_number" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower" autofocus>
        </div>
      </div>

      <!-- Name -->
      <div class="form-group">
        <div class="form-row">
          <label for="exampleInputName">Name</label>
          <input name="member_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="John Doe" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
        </div>
      </div>

      <!-- Age -->
      <div class="form-group">
        <div class="form-row">
          <label for="memberAge">Age</label>
          <div class="input-group">
            <input name="member_age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" placeholder="45" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2">
            <div class="input-group-append">
              <div class="input-group-text">years</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Father's Name -->
      <div class="form-group">
        <div class="form-row">
          <label for="fathersname">Father's name</label>
          <input name="father_name" class="form-control" id="fathersname" type="text" aria-describedby="nameHelp" placeholder="Jack Doe" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
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
        <input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="present_pincode" class="form-control" type="text" placeholder="781023" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6">
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


      <!-- Installment -->
      <div class="form-group">
        <div class="form-row">
          <label for="Installment">Installment</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text"> Rs.</div>
            </div>
            <input name="instalment" class="form-control" id="Installment" type="text" data-validation="required number" data-validation-error-msg="Enter a valid amount">
          </div>
        </div>
      </div>


      <!-- Mode of deposit -->
      <div class="form-group">
        <div class="form-row">
          <label for="modeOfInstallment">Mode of deposit</label>
          <div class="input-group">
            <select class="custom-select" name="mode" data-validation="required" data-validation-error-msg="Please select a value">
              <option selected disabled>select</option>
              <option value="daily">Daily</option>
              <option value="weekly">Weekly</option>
              <option value="monthly">Monthly</option>
            </select>
          </div>
        </div>
      </div>


      <!-- Period -->
      <div class="form-group">
        <div class="form-row">
          <label>Period</label>
          <div class="input-group">
            <select class="custom-select" name="period" data-validation="required" data-validation-error-msg="Please select a value">
             <option selected disabled>select</option>
             <option value="12">12 months</option>
             <option value="24">24 months</option>
             <option value="36">36 months</option>
           </select>
         </div>
       </div>
     </div>


     <!-- Occupation -->
     <div class="form-group">
      <div class="form-row">
        <label>Occupation &emsp;</label>
        <div class="custom-control custom-radio custom-control-inline">
          <input value="service" type="radio" id="occupation" name="occupation" class="custom-control-input">
          <label class="custom-control-label" for="occupation">Service</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input value="business" type="radio" id="customRadioInline2" name="occupation" class="custom-control-input" data-validation="required">
          <label class="custom-control-label" for="customRadioInline2">Business&emsp;&emsp;</label>
        </div>
      </div>
    </div>


    <!-- Phone -->
    <div class="form-group">
      <div class="form-row">
        <label for="phno">Phone</label>
        <input class="form-control" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="member_phone" maxlength="10">
      </div>
    </div>


    <!-- Nominee name -->
    <div class="form-group">
      <div class="form-row">
        <label for="nominee">Nominee name</label>
        <input name="nominee_name" class="form-control" id="nominee" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
      </div>
    </div>


    <!-- Age of nominee -->
    <div class="form-group">
      <div class="form-row">
        <label for="nomineeAge">Age of the nominee</label>
        <div class="input-group">
          <input name="nominee_age" class="form-control" id="nomineeAge" type="text" aria-describedby="nameHelp" placeholder="Age of the nominee" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2">
          <div class="input-group-append">
            <div class="input-group-text">years</div>
          </div>
        </div>
      </div>
    </div>


    <!-- Relationship -->
    <div class="form-group">
      <div class="form-row">
        <label for="Relationship">Relationship with applicant</label>
        <div class="input-group">
         <input type="text" class="form-control" id="Relationship" name="relationship" data-validation="required custom" data-validation-regexp="^([A-Za-z]+)$" data-sanitize="trim capitalize" data-validation-error-msg="Please enter nominee's relationship with the applicant">
       </div>
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
           <option value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
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

<button type="submit" name="add_member" value="Add Staff" class="btn btn-primary btn-block"> Submit </button>
</form>
</div>
</div>
<script>
  $(function(){
    ("#sameAbove").click(function(){
      if($(this).is(':checked')){     
        var present_address=$("#present_address").val();
        var present_pincode=$("#present_pincode").val();
        $("#permanent_address").val(present_address);
        $("#permanent_pincode").val(present_pincode);
      }
    });
  });
</script>
<?php include('template/foot.php'); ?>