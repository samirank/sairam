<?php
include ('../class/insert.php');
if (isset($_POST['add_staff'])) {
  $name = $_POST['name'];
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $encpassword=md5($password);
  $user_role = $_POST['user_role'];
  $status = $_POST['status'];
 
  $create = new insert();
  $result = $create->add_staff($name, $user_name, $encpassword, $user_name, $user_role, $status);
  header("location:../dashboard.php?msg=Success.");;
}
?>
