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
  <li class="breadcrumb-item active">View staff</li>
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
              <th>Phone</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
        <tbody>
          <?php while($row=mysqli_fetch_assoc($result)){ ?>
            <?php if ($row['user_role']!="admin"): ?>
              <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td class="text-right">
                  <div class="btn-group" role="group">
                    <button id="profileoptions" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Options
                    </button>
                    <div class="dropdown-menu" aria-labelledby="profileoptions">
                      <a class="dropdown-item" href="profile.php?staff=<?php echo $row['user_id']; ?>">View</a>
                      <a class="dropdown-item" href="edit.php?staff=<?php echo $row['user_id']; ?>">Edit</a>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endif ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<?php include('template/foot.php'); ?>