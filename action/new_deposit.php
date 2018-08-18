<?php
session_start();
include ('../class/insert.php');
include ('../class/update.php');
include ('upload.php');

$insert = new insert();
$update = new update();

$upload_err = 0;
$upload_msg = null;
$insert_msg = "Deposit account created successfully";
$insert_err = 0;


// New deposit account
if (isset($_POST['new_deposit'])) {
  print_r($_POST);

  $account_no = $_POST['accno'];
  $installment = $_POST['instalment'];
  $mode = $_POST['mode'];
  $period = $_POST['period'];
  $nominee_name = $_POST['nominee_name'];
  $nominee_age = $_POST['nominee_age'];
  $relationship = $_POST['relationship'];
  $joining_agent = $_POST['joining_agent'];
  $joining_date = $_POST['joining_date'];
  $joining_date = date("Y-m-d", strtotime($joining_date));
  $mem_id = $_POST['mem_id'];
  $added_by = $_SESSION['login_id'];
  $photo = NULL;
  $signature = NULL;

  // New member
  if (empty($_POST['mem_id'])) {
    $member_name = $_POST['member_name'];
    $member_age = $_POST['member_age'];
    $f_h_name = $_POST['f_h_name'];
    $present_address = $_POST['present_address'];
    $present_pincode = $_POST['present_pincode'];
    $permanent_address = $_POST['permanent_address'];
    $permanent_pincode = $_POST['permanent_pincode'];
    $occupation = $_POST['occupation'];
    $member_phone = $_POST['member_phone'];

    $new_mem_id = $insert->add_membership($member_name, $member_age, $f_h_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $occupation, $member_phone, $joining_agent, $added_by, $photo, $signature);
    if(!$new_mem_id){
      $insert_msg = "Unable to add member please check the data you have entered.";
      $insert_err=1;
    }
    $mem_id = $new_mem_id;
    echo $new_mem_id;
  }


  if ($mem_id) {
    // Upload photo and signature
    !empty($_FILES['photograph']['name']) ? upload_photo($mem_id) : $photo = null;
    !empty($_FILES['signature']['name']) ? upload_signature($mem_id) : $signature = null;
    if(!is_null($photo)){ $update->change_member_photo($mem_id,$photo); }
    if(!is_null($signature)){ $update->change_member_signature($mem_id,$signature); }
    $acc_id = $insert->new_deposit_acc($account_no, $mem_id, $installment, $mode, $period, $nominee_name, $nominee_age, $relationship, $joining_date, $joining_agent, $added_by);
    if(!$acc_id){
      $insert_msg = "Unable to create deposit account please check the data you have entered.";
      $insert_err=1;
    }
  }else{
    $insert_msg = "Unable to add member please check the data you have entered.";
    $insert_err=1;
  }

  if ($insert_err==0) {
    $insert_msg = $insert_msg." <a href='profile.php?mem=".$mem_id."&acc=".$acc_id."'>Click here to view account.</a>";
  }

  $msg = array(
    'insert_msg' => $insert_msg,
    'insert_err' => $insert_err,
    'upload_err' => $upload_err,
    'upload_msg' => $upload_msg
  );
  $_SESSION['msg'] = $msg;
  $update->refresh_member_status($mem_id);
  header("location: ../new_deposit_acc.php");
}
?>
