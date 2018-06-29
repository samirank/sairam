<?php 
// Function to upload photo (returns URL)
function upload_photo($account_no){
  $GLOBALS['upload_err'] = 0;
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
    $GLOBALS['upload_msg'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

    // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $GLOBALS['upload_msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $GLOBALS['upload_err'] = 1;
    return false;
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["photograph"]["tmp_name"], $target_file)) {
      $GLOBALS['photo'] = ltrim($target_file, "../");
      $GLOBALS['upload_msg'] = "Picture uploaded successfully";
      return true;
    }
    else {
      $GLOBALS['upload_msg'] = "Sorry, there was an error uploading your file.";
      $GLOBALS['upload_err'] = 1;
      return false;
    }
  }
}

// Function to upload signature (returns URL)
function upload_signature($account_no){
  $GLOBALS['upload_err'] = 0;
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
    $GLOBALS['upload_msg'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

    // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $GLOBALS['upload_msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $GLOBALS['upload_err'] = 1;
    return false;
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
      $GLOBALS['signature'] = ltrim($target_file, "../");
      $GLOBALS['upload_msg'] = "Signature uploaded successfully";
      return true;
    }
    else {
      $GLOBALS['upload_msg'] = "Sorry, there was an error uploading your file.";
      $GLOBALS['upload_err'] = 1;
      return false;
    }
  }
}



// Function to upload signature (returns URL)
function upload_agent_photo($account_no){
  $GLOBALS['upload_err'] = 0;
  $imageFileType    = pathinfo($_FILES["photograph"]["name"], PATHINFO_EXTENSION);
  $target_dir = "../uploads/";
  $target_file = $target_dir.$account_no."_agent.".$imageFileType;
  $uploadOk = 1;
  $GLOBALS['photograph'] = null;

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
    $GLOBALS['upload_msg'] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

    // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    $GLOBALS['upload_msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

    // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $GLOBALS['upload_err'] = 1;
    return false;
  }
  // if everything is ok, try to upload file
  else {
    if (move_uploaded_file($_FILES["photograph"]["tmp_name"], $target_file)) {
      $GLOBALS['agent_photograph'] = ltrim($target_file, "../");
      $GLOBALS['upload_msg'] = "Photo uploaded successfully";
      return true;
    }
    else {
      $GLOBALS['upload_msg'] = "Sorry, there was an error uploading your file.";
      $GLOBALS['upload_err']
       = 1;
      return false;
    }
  }
}
?>