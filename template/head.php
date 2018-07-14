<?php include('session.php'); ?>
<?php $script = null; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sairam Development Society</title>
  <!-- Bootstrap core CSS-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <link href="assets/css/sb-admin.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Sairam <br> <span>Development Society</span></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="dashboard.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>


        <?php if ($_SESSION['login_role']=="admin"): ?>
          <!-- Admin menu -->
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseStaff" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-sitemap"></i>
              <span class="nav-link-text">Staff</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseStaff">
              <li>
                <a href="addstaff.php">Add Staff</a>
              </li>
              <li>
                <a href="viewstaff.php">View Staff</a>
              </li>
            </ul>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseAgent" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-suitcase"></i>
              <span class="nav-link-text">Agent</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseAgent">
              <li>
                <a href="addagent.php">Add Agent</a>
              </li>
              <li>
                <a href="viewagent.php">View Agent</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="viewmembers.php">
              <i class="fa fa-fw fa-user"></i>
              <span class="nav-link-text">View members</span>
            </a>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseloan" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-suitcase"></i>
              <span class="nav-link-text">Loans</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseloan">
              <li>
                <a href="newloan.php">New loan</a>
              </li>
              <li>
                <a href="viewloans.php">View loans</a>
              </li>
            </ul>
          </li>
          <!-- Admin menu ends -->
        <?php endif ?>




        <?php if ($_SESSION['login_role']=="staff"): ?>
          <!-- Staff menu -->
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsemembers" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-sitemap"></i>
              <span class="nav-link-text">Members</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapsemembers">
              <li>
                <a href="addmembership.php">Add members</a>
              </li>
              <li>
                <a href="viewmembers.php">View members</a>
              </li>
            </ul>
          </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapsedeposit" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-money"></i>
              <span class="nav-link-text">Deposit</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapsedeposit">
              <li>
                <a href="makedeposit.php">Make deposit</a>
              </li>
              <!-- <li>
                <a href="viewmembers.php">View members</a>
              </li> -->
            </ul>
          </li>
          <!-- Staff menu ends -->  
        <?php endif ?>
      </ul>




      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-white" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="content-wrapper">
      <div id="contents" class="container-fluid">