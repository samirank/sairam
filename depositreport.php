<?php
include('template/head.php');
include('class/view.php');
$display = new display();
$account_no = $_GET['acc'];
$cond = 'account_no='.$account_no;
$result = $display->disp_cond('deposit',$cond);
?>
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="dashboard.php">Dashboard</a>
	</li>
	<li class="breadcrumb-item">
		<a href="profile.php?mem=<?php echo $_GET['acc']; ?>">Member</a>
	</li>
	<li class="breadcrumb-item active">Deposit report</li>
</ol>

<div class="w-75 mx-auto">
	<div class="pt-3 pb-3"><h6>Account no: <?php echo $account_no; ?> &emsp;&emsp;Member name: <?php echo $display->get_member_name($account_no); ?> &emsp;&emsp;Joining date: <?php echo $display->get_joining_date($account_no); ?></h6></div>
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Date</th>
	      <th scope="col">Amount (Rs.)</th>
	      <th scope="col">Total</th>
	    </tr>
	  </thead>
	  <tbody>
	<?php 
	$total = 0;
	$sl = 1;
	?>
	<?php while ($row=mysqli_fetch_assoc($result)) { ?>
		<?php $total+=$row['amount']; ?>
			<tr>
				<td scope="row"><?php echo $sl; ?></td>
				<td><?php echo $row['date_of_payment']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $total; ?></td>
			</tr>
		<?php $sl++; ?>
	<?php } ?>
	  </tbody>
	</table>
</div>

<?php include('template/foot.php'); ?>