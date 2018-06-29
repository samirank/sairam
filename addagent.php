<?php include('template/head.php'); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Add agent</li>
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
  <div class="card-header bg-primary-light-2">Add new agent</div>
  <div class="card-body">
    <form action="action/newagent.php" method="POST" enctype="multipart/form-data">

      <!-- Name -->
      <div class="form-group">
        <div class="form-row">
          <label for="exampleInputName">Name</label>
          <input name="agent_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
        </div>
      </div>

      <!-- Phone -->
      <div class="form-group">
        <div class="form-row">
          <label for="phno">Phone</label>
          <input class="form-control" data-validation="required number length" data-validation-length="10" data-validation-error-msg="Please enter 10 digit mobile number" type="text" name="phno" maxlength="10">
        </div>
      </div>
      
      <!-- Email -->
      <div class="form-group">
       <div class="form-row">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" data-validation="required email" aria-describedby="emailHelp">
      </div>
    </div>

    <!-- Address -->
    <div class="form-group">
      <div class="form-row">
        <label for="address">Address</label>
        <textarea id="address" name="address" class="form-control" data-validation="required" data-validation-error-msg="Please enter address"></textarea>
      </div>
    </div>

    <!-- Age -->
    <div class="form-group">
      <div class="form-row">
        <label for="memberAge">Age</label>
        <div class="input-group">
          <input name="age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age" maxlength="2">
          <div class="input-group-append">
            <div class="input-group-text">years</div>
          </div>
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

    <!-- Submit -->
    <button type="submit" name="add_agent" class="btn btn-primary btn-block"> Submit </button>

  </form>
</div>
</div>
<?php include('template/foot.php'); ?>