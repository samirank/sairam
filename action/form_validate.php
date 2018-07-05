<?php
/*Can be used in various modules to validate form data*/
include ('../class/validate.php');
if (isset($_POST['username'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "inputUsername" is missing.'
	);

	$validate = new validate();
	$user     = $validate->validate_username($_POST['username']);

	if ($user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'This user name is already registered.'
		);
	}
	else {
    // User name is available
		$response = array(
			'valid' => true
		);
	}
	echo json_encode($response);
}

if (isset($_POST['account_number'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "account_number" is missing.'
	);

	$validate = new validate();
	$user     = $validate->validate_accno($_POST['account_number']);

	if ($user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Account already exist'
		);
	}
	else {
    // User name is available
		$response = array(
			'valid' => true
		);
	}
	echo json_encode($response);
}

// Validate staff phone number
if (isset($_POST['staff_phone'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "staff_phone" is missing.'
	);

	$validate = new validate();
	$user     = $validate->validate_staff_phone($_POST['staff_phone']);

	if ($user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Phone number already registered'
		);
	}
	else {
    // User name is available
		$response = array(
			'valid' => true
		);
	}
	echo json_encode($response);
}


// Change username
if (isset($_POST['change_username'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "change_username" is missing.'
	);

	$validate = new validate();
	$user     = $validate->change_username($_POST['change_username'],$_POST['user_id']);

	if ($user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'This user name is already registered.'
		);
	}
	else {
    // User name is available
		$response = array(
			'valid' => true
		);
	}
	echo json_encode($response);
}


if (isset($_POST['change_staff_phone'])) {
		$response = array(
		'valid'          => false,
		'message'        => 'Post argument "change_staff_phone" is missing.'
	);

	$validate = new validate();
	$user     = $validate->change_staff_phone($_POST['change_staff_phone'],$_POST['user_id']);

	if ($user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Phone number already registered'
		);
	}
	else {
    // User name is available
		$response = array(
			'valid' => true
		);
	}
	echo json_encode($response);
}
?>