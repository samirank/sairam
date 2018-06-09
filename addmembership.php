<?php include('template/head.php'); ?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
</li>
<li class="breadcrumb-item active">Add member</li>
</ol>

<div class="card card-register mx-auto mt-5 border-primary">
  <div class="card-header bg-primary-light-2">Add new member</div>
  <div class="card-body">
    <form action="action/newmembership.php" method="POST">

        <!-- Name -->
        <div class="form-group">
            <div class="form-row">
                <label for="exampleInputName">Name</label>
                <input name="member_name" class="form-control" id="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" autofocus>
            </div>
        </div>

        <!-- Age -->
        <div class="form-group">
            <div class="form-row">
                <label for="memberAge">Age</label>
                <div class="input-group">
                  <input name="member_age" class="form-control" id="memberAge" type="text" aria-describedby="nameHelp" placeholder="Age of the member" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age">
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
            <input name="father_name" class="form-control" id="fathersname" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only">
        </div>
    </div>

    <!-- Present ddress -->
    <div class="form-group">
        <div class="form-row">
            <label for="address">Present address</label>
            <textarea name="present_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address"></textarea>
            <input name="present_pincode" class="form-control" type="text" aria-describedby="nameHelp" placeholder="Enter PIN code" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code">
        </div>
    </div>

    <!-- Permanent ddress -->
    <div class="form-group">
        <div class="form-row">
            <label for="address">Permanent address</label>
            <textarea name="permanent_address" class="form-control" data-validation="required" data-validation-error-msg="Please enter present address"></textarea>
            <input name="permanent_pincode" class="form-control" type="text" aria-describedby="nameHelp" placeholder="Enter PIN code" data-validation="required number length" data-validation-length="6" data-validation-error-msg="Please enter pin code">
        </div>
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
        <label>Occupation</label>
    </div class="form-row">
    <div class="custom-control custom-radio custom-control-inline">
      <input value="service" type="radio" id="occupation" name="occupation" class="custom-control-input" data-validation="required">
      <label class="custom-control-label" for="occupation">Service</label>
  </div>
  <div class="custom-control custom-radio custom-control-inline">
      <input value="business" type="radio" id="customRadioInline2" name="occupation" class="custom-control-input">
      <label class="custom-control-label" for="customRadioInline2">Business</label>
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
        <input name="nominee_name" class="form-control" id="nominee" type="text" aria-describedby="nameHelp" placeholder="Enter first name and last name" data-validation="required custom" data-validation-regexp="^([a-zA-Z]+\s)([a-zA-Z])+$" data-sanitize="trim capitalize"  data-validation-allowing=" " data-validation-error-msg="Enter first and last name only" autofocus>
    </div>
</div>

<!-- Age of nominee -->
<div class="form-group">
    <div class="form-row">
        <label for="nomineeAge">Age of the nominee</label>
        <div class="input-group">
            <input name="nominee_age" class="form-control" id="nomineeAge" type="text" aria-describedby="nameHelp" placeholder="Age of the nominee" data-validation="required number" data-validation-length="10-100" data-validation-error-msg="Enter a valid age">
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


<!-- Username -->
<div class="form-group">
    <div class="form-row">
        <label for="inputUsername">Username</label>
        <input name="user_name" class="form-control" id="inputUsername" type="text" aria-describedby="nameHelp" placeholder="Enter user name" data-validation="required alphanumeric server" data-validation-param-name="username" data-validation-url="action/form_validate.php"  data-validation-allowing="_" data-sanitize="trim lower" placeholder="Enter username">
    </div>
</div>




<div class="form-group">
    <div class="form-row">
      <div class="col-md-6">
        <label for="exampleInputPassword1">Password</label>
        <input name="password" class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" data-validation="strength" data-validation-strength="2">
    </div>
    <div class="col-md-6">
        <label for="exampleConfirmPassword">Confirm password</label>
        <input name="cnf-pass" class="form-control" id="exampleConfirmPassword" type="password" placeholder="Confirm password" data-validation="confirmation" data-validation-confirm="password" data-validation-error-msg="Entered value do not match with your password.">
    </div>
</div>
</div>

<button type="submit" name="add_member" value="Add Staff" class="btn btn-primary btn-block"> Submit </button>
</form>
</div>
</div>
<?php include('template/foot.php'); ?>