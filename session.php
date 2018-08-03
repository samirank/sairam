<?php session_start();
// 2 hours in seconds
$inactive = 600; 
ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 2 hours

if(!isset($_SESSION['login_id'])){
	header('location: logout.php');
}

if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout'] > $inactive)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();  // destroy session data
    session_start();	//Start new session
    $_SESSION['msg'] = "Session timed out. Please log in again.";
    header('location: index.php');
}
$_SESSION['timeout'] = time(); // Update session
 ?>