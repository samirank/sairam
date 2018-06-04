<?php
include ('../class/insert.php');
if (isset($_POST['add_member'])) {
  $member_name = $_POST['member_name'];
  $member_age = $_POST['member_age'];
  $father_name = $_POST['father_name'];
  $present_address = $_POST['present_address'];
  $present_pincode = $_POST['present_pincode'];
  $permanent_address = $_POST['permanent_address'];
  $permanent_pincode = $_POST['permanent_pincode'];
  $instalment = $_POST['instalment'];
  $mode = $_POST['mode'];
  $period = $_POST['period'];
  $occupation = $_POST['occupation'];
  $member_phone = $_POST['member_phone'];
  $nominee_name = $_POST['nominee_name'];
  $nominee_age = $_POST['nominee_age'];
  $relationship = $_POST['relationship'];
  $photo = $_POST['photo'];
  $signature = $_POST['signature'];



  $create = new insert();
  $result = $create->add_membership($member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature);
  header("location:../dashboard.php?msg=Success.");;
}
?>
