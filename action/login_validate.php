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
    $_SESSION['login_id'] = $user;
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