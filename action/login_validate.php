<?php
session_start();
include ('../class/validate.php');
include ('../class/view.php');
if (isset($_POST['login'])) {
  $user     = $_POST['username'];
  $pswd     = $_POST['enc'];
  $pswd     = md5($pswd);

  $validate = new validate();
  if ($validate->validate_login($user, $pswd)) {
    $_SESSION['login_user'] = $user;
    
    $display = new display();
    $result=$display->disp_cond("users","user_name='{$user}'");
    $row=mysqli_fetch_assoc($result);
    $_SESSION['login_id'] = $row['user_id'];
    $_SESSION['login_role'] = $row['user_role'];
    header("location: ../dashboard.php");
  }
  else {
    $_SESSION['msg'] = "Incorrect username/password";
    header("location: ../index.php");
  }
}
else{
  $_SESSION['msg'] = "Incorrect username/password";
  header("location: ../index.php");
}
?>