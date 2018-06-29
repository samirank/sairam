<?php
session_start();
include ('../class/insert.php');
include ('upload.php');
$msg = "Member added successfully";
$err = 0;

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
  $agent_id = $_POST['agent_id'];


  !empty($_FILES['photograph']['name']) ? upload_photo($account_no) : $photo = null;
  !empty($_FILES['signature']['name']) ? upload_signature($account_no) : $signature = null;

  print_r($_FILES);


  $create = new insert();
  $result = $create->add_membership($account_no, $member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature, $agent_id);
  

  $_SESSION['msg'] = $msg;
  if($err==0){
    header("location: ../addmembership.php");
  }else{
    header("location: ../addmembership.php?err=1");
  }
}
?>
