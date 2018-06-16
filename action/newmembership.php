<?php
session_start();
include ('../class/insert.php');
$msg = "Member added successfully";
$err = 0;


// Function to upload photo (returns URL)
function upload_photo($account_no){
  $imageFileType    = pathinfo($_FILES["photograph"]["name"], PATHINFO_EXTENSION);
  $target_dir = "../uploads/";
  $target_file = $target_dir.$account_no."_sign.".$imageFileType;
  $uploadOk = 1;
  $GLOBALS['photo'] = null;

  //check if the file is an image
  $check = getimagesize($_FILES["photograph"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  }
  else {
    $uploadOk = 0;
  }

    // Check file size
  if ($_FILES["photograph"]["size"] > 500000) {
    $GLOBALS['msg'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

    // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $GLOBALS['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $GLOBALS['err'] = 1;
    return false;
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["photograph"]["tmp_name"], $target_file)) {
      $GLOBALS['photo'] = ltrim($target_file, "../");
      return true;
    }
    else {
      $GLOBALS['msg'] = "Sorry, there was an error uploading your file.";
      $GLOBALS['err'] = 1;
      return false;
    }
  }
}

// Function to upload signature (returns URL)
function upload_signature($account_no){
  $imageFileType    = pathinfo($_FILES["signature"]["name"], PATHINFO_EXTENSION);
  $target_dir = "../uploads/";
  $target_file = $target_dir.$account_no."_sign.".$imageFileType;
  $uploadOk = 1;
  $GLOBALS['signature'] = null;

  //check if the file is an image
  $check = getimagesize($_FILES["signature"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  }
  else {
    $uploadOk = 0;
  }

    // Check file size
  if ($_FILES["signature"]["size"] > 500000) {
    $GLOBALS['msg'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

    // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $GLOBALS['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $GLOBALS['err'] = 1;
    return false;
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
      $GLOBALS['signature'] = ltrim($target_file, "../");
      return true;
    }
    else {
      $GLOBALS['msg'] = "Sorry, there was an error uploading your file.";
      $GLOBALS['err'] = 1;
      return false;
    }
  }
}

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


  isset($_FILES['photograph']) ? upload_photo($account_no) : $photo = null;
  isset($_FILES['signature']) ? upload_signature($account_no) : $signature = null;


  $create = new insert();
  $result = $create->add_membership($account_no, $member_name, $member_age, $father_name, $present_address, $present_pincode, $permanent_address, $permanent_pincode, $instalment, $mode, $period, $occupation, $member_phone, $nominee_name, $nominee_age, $relationship, $photo, $signature);
  

  $_SESSION['msg'] = $msg;
  if($err==0){
    header("location: ../addmembership.php");
  }else{
    header("location: ../addmembership.php?err=1");
  }
}
?>
