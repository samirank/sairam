<?php include('template/head.php'); ?>
<?php include('class/view.php'); ?>
<?php include('class/update.php'); ?>
<?php
$display = new display();
$update = new update();
$result =  $display->get_unread_msg($_SESSION['login_id'],$_SESSION['login_role']);

$all_result = $display->disp_all('messages');
?>

<ul class="nav nav-pills" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link <?php if(!isset($_GET['msg'])) echo "active"; ?>" id="unread-tab" data-toggle="tab" href="#unread" role="tab" aria-controls="unread" aria-selected="true">Unread</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="all-msg-tab" data-toggle="tab" href="#all-msg" role="tab" aria-controls="all-msg" aria-selected="false">All messages</a>
	</li>
</ul>
<div class="tab-content" id="myTabContent">

	<!-- Unread messages -->
	<div class="tab-pane fade <?php if(!isset($_GET['msg'])) echo "show active"; ?>" id="unread" role="tabpanel" aria-labelledby="unread-tab">
		<div class="container">
			<table class="table mt-5">
				<tbody>
					<?php if (mysqli_num_rows($result)==0): ?>
						<tr>
							<td class="text-center">No unread message</td>
						</tr>
						<?php else: ?>
							<?php while ($row = mysqli_fetch_assoc($result)) { ?>
								<tr>
									<td><b><?php echo $row['from']; ?></b></td>
									<td><?php echo $row['sub']; ?></td>
									<td><?php echo $row['date']." ".$row['time']; ?></td>
									<td><button class="btn btn-sm btn-primary" onclick="location.href='messages.php?msg=<?php echo $row['msg_id'] ?>'">Read</button></td>
								</tr>
							<?php } ?>
						<?php endif ?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- All messages -->
		<div class="tab-pane fade" id="all-msg" role="tabpanel" aria-labelledby="all-msg-tab">
			<div class="container">
				<table class="table mt-5">
					<tbody>
						<?php if (mysqli_num_rows($all_result)==0): ?>
							<tr>
								<td class="text-center">No message</td>
							</tr>
							<?php else: ?>
								<?php while ($row_all = mysqli_fetch_assoc($all_result)) { ?>
									<tr>
										<td><b><?php echo $row_all['from']; ?></b></td>
										<td><?php echo $row_all['sub']; ?></td>
										<td><?php echo $row_all['date']." ".$row_all['time']; ?></td>
										<td><button class="btn btn-sm btn-primary" onclick="location.href='messages.php?msg=<?php echo $row_all['msg_id'] ?>'">Read</button></td>
									</tr>
								<?php } ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php if(isset($_GET['msg'])): ?>
				<?php
				$cond = "msg_id=".$_GET['msg']; 
				$result_msg = $display->disp_cond("messages",$cond);
				$row_msg = mysqli_fetch_assoc($result_msg);
				?>
				<?php if (mysqli_num_rows($result_msg)==1): ?>
					<div class="tab-pane fade show active" id="all-msg" role="tabpanel" aria-labelledby="all-msg-tab">
						<div class="card w-50 mx-auto mt-5">
							<div class="card-body">
								<h5 class="card-title"><?php echo $row_msg['sub']; ?></h5>
								<h6 class="card-subtitle mb-2 text-muted">From: <?php echo $row_msg['from']; ?></h6>
								<p class="text-muted"><?php echo $row_msg['date']."&emsp;".date("g:i a", strtotime($row_msg['time'])); ?></p>
								<p class="card-text"><?php echo $row_msg['msg']; ?></p>
							</div>
						</div>
					</div>
					<?php $update->mark_as_read($row_msg['msg_id']); ?>
					<?php else: ?>
						<script>
							var unread_tab = document.getElementById("unread-tab");
							unread_tab.classList.add("active");
							var unread = document.getElementById("unread");
							unread.classList.add("show");
							unread.classList.add("active");
						</script>
					<?php endif ?>
				<?php endif ?>
			</div>

			<?php include('template/foot.php'); ?>