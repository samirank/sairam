<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$result=$display->disp_all("agents");
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">View agents</li>
</ol>

<div class="card">
  <div class="card-header">
  <i class="fa fa-table"></i> Staff</div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Agent name</th>
            <th>email id</th>
            <th>Phone</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($result)){ ?>
            <tr>
              <td><?php echo $row['agent_name']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['phno']; ?></td>
              <td><div class="<?php if($row['status']=='active') echo 'text-success'; else echo 'text-danger'; ?>"><?php echo $row['status']; ?></div></td>
              <td class="text-right" style="width: 90px;">
                <div class="btn-group" role="group">
                  <button id="profileoptions" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="profileoptions">
                    <a class="dropdown-item" href="profile.php?agent=<?php echo $row['agent_id']; ?>">View</a>
                    <?php if (($row['status']=="active") && ($_SESSION['login_role']=='admin')): ?>
                    <a class="dropdown-item" href="edit.php?agent=<?php echo $row['agent_id']; ?>">Edit</a>
                  <?php endif ?>
                </div>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('template/foot.php'); ?>