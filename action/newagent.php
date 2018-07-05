<?php
session_start();
include ('../class/insert.php');
include ('../class/update.php');
$insert = new insert();
$update = new update();

$insert_err = 0;
$insert_msg = "Agent successfully added";
$upload_err = 0;
$upload_msg = "Photograph not provided. Default photograph applied.";


include ('upload.php');
if (isset($_POST['add_agent'])) {
	$agent_name = $_POST['agent_name'];
	$phno = $_POST['phno'];
	$address = $_POST['address'];
	$age = $_POST['age'];
	$email = $_POST['email'];

	$agent_id = $insert->add_agent($agent_name, $phno, $address, $age, $email);
	if($agent_id!==false){
		if (!empty($_FILES['photograph']['name'])) {
			upload_agent_photo($agent_id);
		}else{
			$upload_err = 1;
		}
		if($upload_err==0){
			$update->upload_agent_pic($agent_id,$agent_photograph);
		}
	}else{
		$insert_msg = "Unable to add agent please check the data you have entered.";
		$insert_err=1;
	}
}
$msg = array(
	'insert_msg' => $insert_msg,
	'insert_err' => $insert_err,
	'upload_err' => $upload_err,
	'upload_msg' => $upload_msg
);
$_SESSION['msg'] = $msg;
header("location: ../addagent.php");
?>