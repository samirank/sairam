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


if (isset($_POST['deposit_account'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "account_number" is missing.'
	);

	$validate = new validate();
	$user     = $validate->validate_accno($_POST['deposit_account']);

	if (!$user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Account does not exist'
		);
	}
	elseif($validate->get_account_status($_POST['deposit_account'])!='active') {
		// Account status not active
		$response = array(
			'valid'          => false,
			'message'        => 'Account closed. Please contact admin'
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

// Validate account no for installment payment
if (isset($_POST['loan_account'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "account_number" is missing.'
	);

	$validate = new validate();
	$user     = $validate->validate_accno($_POST['loan_account']);

	if (!$user) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Account does not exist'
		);
	}
	elseif(!$validate->get_acc_loans($_POST['loan_account'])) {
	// Account status not active
		$response = array(
			'valid'          => false,
			'message'        => 'No active loan found for this account'
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

// Validate loan and loan status
if (isset($_POST['check_loan'])) {
	$response = array(
		'valid'          => false,
		'message'        => 'Post argument "account_number" is missing.'
	);

	$validate = new validate();
	$loan     = $validate->validate_loan($_POST['check_loan']);

	if (!$loan) {
    // User name is registered on another account
		$response = array(
			'valid'          => false,
			'message'        => 'Incorrect loan id'
		);
	}
	elseif($validate->check_loan_status($_POST['check_loan'])!="active") {
	// Account status not active
		$response = array(
			'valid'          => false,
			'message'        => 'Loan is not active. Please contact admin.'
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