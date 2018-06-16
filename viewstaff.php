<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php 
$display = new display();
$result=$display->disp_all("users");
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="dashboard.php">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Add staff</li>
</ol>
<div class="card mb-3">

  <div class="card-header">
    <i class="fa fa-table"></i> Data Table Example</div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Role</th>
              <th>Status</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Role</th>
              <th>Status</th>
            </tr>
          </tr>
        </tfoot>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($result)){ ?>
            <?php if ($row['user_role']!="admin"): ?>
              <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['user_role']; ?></td>
                <td><?php echo $row['status']; ?></td>
              </tr>
            <?php endif ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include('template/foot.php'); ?>