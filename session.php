<?php session_start();
// 10 minutes in seconds
date_default_timezone_set('Asia/Kolkata');
$inactive = 600; 
// ini_set('session.gc_maxlifetime', $inactive); // set the session max lifetime to 10 minutes

if(!isset($_SESSION['login_id'])){
	header('location: logout.php');
}

if (isset($_SESSION['timeout']) && (time() - $_SESSION['timeout'] > $inactive)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for this page
    session_destroy();  // destroy session data
    session_start();	//Start new session
    $_SESSION['msg'] = "Session timed out. Please log in again.";
    $_SESSION['redirect_url'] = $_SERVER["PHP_SELF"]."?".http_build_query($_GET);
    header('location: index.php');
}
$_SESSION['timeout'] = time(); // Update session
 ?>