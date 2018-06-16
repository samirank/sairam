<?php include('template/head.php'); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Add staff</li>
</ol>

<div class="card card-register mx-auto mt-5 border-primary">
  <div class="card-header bg-primary-light-2">Create staff account</div>
  <div class="card-body">
    <form action="action/newstaff.php" method="POST">
      <div class="form-group">
        <div class="form-row">
          <label for="exampleInputName">Name</label>
          <input name="name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" placeholder="Enter your full name" autofocus>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <label for="inputUsername">Username</label>
          <input name="user_name" class="form-control" id="inputUsername" type="text" aria-describedby="nameHelp" placeholder="Enter user name" data-validation="required alphanumeric server" data-validation-param-name="username" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower">
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" data-validation="strength" data-validation-strength="1">
          </div>
          <div class="col-md-6">
            <label for="exampleConfirmPassword">Confirm password</label>
            <input name="cnf-pass" class="form-control" id="exampleConfirmPassword" type="password" placeholder="Confirm password" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Entered value do not match with your password.">
          </div>
        </div>
      </div>
      <button type="submit" name="add_staff" value="Add Staff" class="btn btn-primary btn-block"> Submit </button>
    </form>
  </div>
</div>

<?php include('template/foot.php'); ?>