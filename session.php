<?php session_start();
if(!isset($_SESSION['login_id'])){
	header('location: logout.php');
} ?>