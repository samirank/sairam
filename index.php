<?php session_start(); ?>
<?php if(isset($_SESSION['login_id'])){
	header('location: dashboard.php');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sairam Development Society</title>
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
	<div class="container">
		<div id="login-box">
			<div id="login-header">
				<h2>Sign in</h2>
			</div>
			<form action="action/login_validate.php" method="POST">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" name=username id="username" placeholder="Enter email">
					<small id="emailHelp" class="form-text text-muted">Please enter your username.</small>
				</div>
				<div class="form-group">
					<label for="pass">Password</label>
					<input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
				</div>
				<input type="hidden" name="enc" id="enc" value="">
				<button type="submit" name="login" class="btn btn-primary"  onclick="return encrypt();">Submit</button>
			</form>	
		</div>
		<?php if (isset($_SESSION['msg'])): ?>
			<div class="msg-box">
				<?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
			</div>
		<?php endif ?>
	</div>
	<footer>
		<div class="text-center">&copy; Sairam Development Society 2018</div>
	</footer>
</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/crypto.js"></script>
<script>
  function encrypt(){
    var pass = document.getElementById("pass").value;
    var hash = CryptoJS.MD5(pass);
    document.getElementById('enc').value = hash;
    document.getElementById('pass').value = hash;
    return true;
  }
</script>
</html>