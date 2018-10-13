<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">New deposit account</li>
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



<?php if ((!isset($_GET['mex']))&&(!isset($_GET['mem']))): ?>
<div class="card card-register mx-auto mt-5 border-primary">
  <div class="card-body">
    <div class="w-50 mx-auto">
      <a href="new_deposit_acc.php?mem=0" class="btn btn-primary btn-block my-5">New member</a>
      <a href="new_deposit_acc.php?mex=1" class="btn btn-primary btn-block mb-5">Existing member</a>
    </div>
  </div>
</div>
<?php endif ?>

<?php if (isset($_GET['mex'])): ?>
  <?php
  $display = new display();
  $result = $display->disp_all("members");
  ?>
  <div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> View members</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Phone No.</th>
                <th>Status</th>
                <th class="w-25">Options</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row=mysqli_fetch_assoc($result)){ ?>
                <tr>
                  <td><?php echo $row['member_name']; ?></td>
                  <td><?php echo $row['member_phone']; ?></td>
                  <td>
                    <div class="<?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>">
                      <?php echo $row['status']; ?>
                    </div>
                  </td>
                  <td>
                    <a href="new_deposit_acc.php?mem=<?php echo $row['mem_id']; ?>" class="btn btn-primary btn-sm">New deposit account</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif ?>

  <?php if ((isset($_GET['mem']))&&(!isset($_GET['mex']))): ?>
  <?php 
  $display = new display();
  $cond = "mem_id=".$_GET['mem'];
  $result = $display->disp_cond("members",$cond);
  $row = mysqli_fetch_assoc($result);
  ?>
  <div class="card card-register mx-auto mt-5 border-primary">
    <div class="card-header bg-primary-light-2">New Deposit Account</div>
    <div class="card-body">
      <?php if (mysqli_num_rows($result)==1): ?>
          <div class="row p-2">
            <div class="col col-md-4 p-2">
              <?php if ((!empty($row['photo'])) && file_exists($row['photo'])): ?>
              <img style="max-height: 150px;" class="img-fluid" src="<?php echo $row['photo']; ?>" alt="default profile picture">
              <?php else: ?>
                <img style="max-height: 150px;" class="img-fluid" src="assets/img/profile-placeholder.jpg" alt="default profile picture">
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
      <?php endif ?>
      <form action="action/new_deposit.php" method="POST" enctype="multipart/form-data">

        <!-- Account number -->
        <div class="form-group">
          <div class="form-row">
            <label for="inputAccno">Account number</label>
            <input name="accno" class="form-control" id="inputAccno" type="text" aria-describedby="nameHelp" data-validation="required alphanumeric server" data-validation-param-name="account_number" data-validation-url="action/form_validate.php" data-sanitize="trim lower" autofocus>
          </div>
        </div>

        <!-- Name -->
        <div class="form-group">
          <div class="form-row">
            <label for="exampleInputName">Name</label>
            <input name="member_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required custom" data-sanitize="trim capitalize" data-validation-regexp="^([a-zA-Z\s])+$" data-validation-error-msg="Enter full name" <?php if (isset($row['member_name'])){ echo "value='".$row['member_name']."' disabled"; } ?>>
          </div>
        </div>

        <!-- Age -->
        <div class="form-group">
          <div class="form-row">
            <label for="memberAge">Age</label>
            <div class="input-group">
              <input name="member_age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2" <?php if (isset($row['member_name'])){ echo "value='".$row['member_age']."' disabled"; } ?>>
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
            <input name="f_h_name" class="form-control" id="fathersname" type="text" aria-describedby="nameHelp" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" <?php if (isset($row['f_h_name'])){ echo "value='".$row['f_h_name']."' disabled"; } ?>>
          </div>
        </div>

        <!-- Present address -->
        <div class="form-group">
          <div class="form-row">
            <label for="present_address">Present address</label>
            <textarea id="present_address" name="present_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address" <?php if (isset($row['present_address'])){ echo "disabled"; } ?>><?php if (isset($row['present_address'])){ echo $row['present_address']; } ?></textarea>
          </div>
        </div>

        <div class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
          </div>
          <input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="present_pincode" class="form-control" type="text" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6" <?php if (isset($row['present_pincode'])){ echo "value='".$row['present_pincode']."' disabled"; } ?>>
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
            <textarea id="permanent_address" name="permanent_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address" <?php if (isset($row['permanent_address'])){ echo "disabled"; } ?>><?php if (isset($row['permanent_address'])){ echo $row['permanent_address']; } ?></textarea>
          </div>
        </div>
        

        <div class="input-group input-group-sm mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-sm">Pin code</span>
          </div>
          <input id="present_pincode" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" name="permanent_pincode" class="form-control" type="text" placeholder="781023" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code" maxlength="6" <?php if (isset($row['permanent_pincode'])){ echo "value='".$row['permanent_pincode']."' disabled"; } ?>>
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
          <input name="occupation" type="text" class="form-control" data-validation="required custom" data-validation-regexp="^([a-zA-Z\s])+$" data-validation-error-msg="Enter valid occupation" <?php if (isset($row['occupation'])){ echo "value='".$row['occupation']."' disabled"; } ?>>
        </div>
      </div>


      <!-- Phone -->
      <div class="form-group">
        <div class="form-row">
          <label for="phno">Phone</label>
          <input class="form-control" type="text" name="member_phone" maxlength="10" <?php if (isset($row['member_phone'])){ echo "value='".$row['member_phone']."' disabled"; } ?>>
        </div>
      </div>


      <!-- Nominee name -->
      <div class="form-group">
        <div class="form-row">
          <label for="nominee">Nominee name</label>
          <input name="nominee_name" class="form-control" id="nominee" type="text" aria-describedby="nameHelp" data-validation="required custom" data-validation-regexp="^([a-zA-Z\s]+)$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
        </div>
      </div>


      <!-- Age of nominee -->
      <div class="form-group">
        <div class="form-row">
          <label for="nomineeAge">Age of the nominee</label>
          <div class="input-group">
            <input name="nominee_age" class="form-control" id="nomineeAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2">
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
           <input type="text" class="form-control" id="Relationship" name="relationship" data-validation="required custom" data-validation-regexp="^([A-Za-z\s]+)$" data-sanitize="trim capitalize" data-validation-error-msg="Please enter nominee's relationship with the applicant">
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
             <?php if ($row_agents['status']=='active'): ?>
               <option value="<?php echo $row_agents['agent_id']; ?>"><?php echo $row_agents['agent_name']; ?> (<?php echo $row_agents['email']; ?>)</option>
             <?php endif ?>
           <?php } ?>
         </select>
       </div>
     </div>
   </div>

   <!-- joining date -->
   <div class="form-group">
    <div class="form-row">
      <label for="joining_date">Date of joining</label>
      <div class="input-group">
       <input class="form-control datepicker" name="joining_date" data-validation="date" data-validation-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
     </div>
   </div>
 </div>

 <?php if (mysqli_num_rows($result)!=1): ?>
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
<?php endif ?>

<input type="hidden" name="mem_id" value="<?php if(isset($row['mem_id'])) echo $row['mem_id']; ?>">
<button type="submit" name="new_deposit" value="" class="btn btn-primary btn-block"> Submit </button>
</form>
</div>
</div>
<?php endif ?>
<!-- <script>
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
</script> -->
<?php include('template/foot.php'); ?>