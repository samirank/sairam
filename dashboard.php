<?php include('template/head.php'); ?>
<?php include('class/view.php');
$display = new display();
$total_mem = $display->total_members();
$total_loans = $display->total_loans();
$total_agents = $display->total_agents();
$new_messages = $display->total_new_messages($_SESSION['login_id'],$_SESSION['login_role']);
 ?>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-users"></i>
              </div>
              <div class="mr-5"><?php echo $total_mem; ?> Members!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="viewmembers.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5"><?php echo $total_loans; ?> Loans!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="viewloans.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-suitcase"></i>
              </div>
              <div class="mr-5"><?php echo $total_agents; ?> Agents!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="viewagent.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-envelope"></i>
              </div>
              <div class="mr-5"><?php echo $new_messages; ?> New Messages!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="messages.php">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
<?php include('template/foot.php'); ?>