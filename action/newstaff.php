<?php
include ('../class/insert.php');
if (isset($_POST['add_staff'])) {
  $name = $_POST['name'];
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $encpassword=md5(md5($password));
  $staff_phone = $_POST['staff_phone'];
  $address = $_POST['address'];
 
  $create = new insert();
  $result = $create->add_staff($name, $user_name, $encpassword, $user_name, $staff_phone, $address);
  header("location:../dashboard.php?msg=Success.");;
}
?>
