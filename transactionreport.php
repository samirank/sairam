<?php 
include('class/view.php');
$display = new display();
$account_no = $_GET['acc'];
$cond = 'account_no='.$account_no;
$result = $display->disp_cond('deposit',$cond);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transaction report</title>
</head>
<body>
<table cellspacing="8" cellpadding="2">
	<thead>
		<th>Sl. No.</th>
		<th>Date</th>
		<th>Amount</th>
		<th>Total</th>
	</thead>
	<?php 
	$total = 0;
	$sl = 1;
	?>
	<?php while ($row=mysqli_fetch_assoc($result)) { ?>
		<?php $total+=$row['amount']; ?>
		<tbody>
			<tr>
				<td><?php echo $sl; ?></td>
				<td><?php echo $row['date_of_payment']; ?></td>
				<td><?php echo $row['amount']; ?></td>
				<td><?php echo $total; ?></td>
			</tr>
		</tbody>
		<?php $sl++; ?>
	<?php } ?>
</table>	
</body>
</html>