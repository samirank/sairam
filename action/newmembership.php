<?php
session_start();
include ('../class/insert.php');
include ('upload.php');

$upload_err = 0;
$upload_msg = null;
$insert_msg = "Member added successfully";
$insert_err = 0;

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
  $account_no = $_POST['accno'];
  $joining_agent = $_POST['joining_agent'];


  !empty($_FILES['photograph']['name']) ? upload_photo($account_no) : $photo = null;
  !empty($_FILES['signature']['name']) ? upload_signature($account_no) : $signature = null;

  print_r($_FILES);


  $create = new insert();
  if(!$create->add_membership($account_no, $member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature, $joining_agent)){
    $insert_msg = "Unable to add agent please check the data you have entered.";
    $insert_err=1;
  }
  $msg = array(
    'insert_msg' => $insert_msg,
    'insert_err' => $insert_err,
    'upload_err' => $upload_err,
    'upload_msg' => $upload_msg
  );
  $_SESSION['msg'] = $msg;
  header("location: ../addmembership.php");
}
?>
