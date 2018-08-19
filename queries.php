<?php
include_once ('class/config.php');
$connect = new dbconnect();
$mysqli = $connect->con();
$flag = 0;


// Create users table
$sql = "CREATE TABLE `users` ( `user_id` INT NOT NULL AUTO_INCREMENT , `user_name` VARCHAR(50) NOT NULL , `password` VARCHAR(100) NOT NULL , `user_role` VARCHAR(20) NOT NULL , `name` VARCHAR(50) NOT NULL , `status` VARCHAR(15) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE (`user_name`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created users table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `users` ADD `phone` VARCHAR(10) NOT NULL AFTER `name`, ADD `address` TEXT NOT NULL AFTER `phone`;";
$mysqli->query($sql);

// Change default status of user to 'active'
$sql = "ALTER TABLE `users` CHANGE `status` `status` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active';";
$mysqli->query($sql);


// Create admin account
$password = md5(md5("123"));
$sql = "INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_role`, `name`, `status`) VALUES (NULL, 'admin', '$password', 'admin', 'admin', 'active')";
if ($mysqli->query($sql)) {
	echo "<b>Created admin account<br><span style='color: green;'> username: 'admin'<br> password: '123'<br></b></span>";
	$flag = 1;
}

// Create members table
$sql ="CREATE TABLE `members` (
  `mem_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(50) NOT NULL,
  `member_age` int(50) NOT NULL,
  `f_h_name` varchar(50) NOT NULL,
  `present_address` text NOT NULL,
  `present_pincode` varchar(10) NOT NULL,
  `permanent_address` text NOT NULL,
  `permanent_pincode` varchar(10) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `member_phone` varchar(12) NOT NULL,
  `joining_agent` int(11) NOT NULL,
  `current_agent` int(11) NOT NULL,
  `added_on` date NOT NULL,
  `added_by` int(11) NOT NULL,
  `last_updated_on` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `photo` varchar(50) DEFAULT NULL,
  `signature` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`mem_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
if ($mysqli->query($sql)) {
	echo "Created members table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `members` ADD UNIQUE(`member_phone`);";
$mysqli->query($sql);


// Create table deposit_accouonts
$sql = "CREATE TABLE `deposit_accounts` ( `acc_id` INT(11) NOT NULL AUTO_INCREMENT , `account_no` VARCHAR(20) NOT NULL , `mem_id` INT NOT NULL , `installment` INT NOT NULL , `mode` VARCHAR(10) NOT NULL , `period` INT NOT NULL , `nominee_name` VARCHAR(50) NOT NULL , `nominee_age` INT NOT NULL , `nominee_relation` VARCHAR(20) NOT NULL , `joining_date` DATE NOT NULL , `joining_agent` INT NOT NULL , `added_on` DATE NOT NULL , `added_by` INT NOT NULL , `last_updated` DATE NOT NULL , `status` VARCHAR(20) NOT NULL , PRIMARY KEY (`acc_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created deposit_accounts table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `deposit_accounts` ADD UNIQUE(`account_no`);";
$mysqli->query($sql);


// Create agents table
$sql = "CREATE TABLE `agents` ( `agent_id` INT NOT NULL AUTO_INCREMENT , `agent_name` VARCHAR(50) NOT NULL , `phno` VARCHAR(10) NOT NULL , `address` TEXT NOT NULL , `age` INT NOT NULL , `email` VARCHAR(50) NOT NULL , `status` VARCHAR(10) NOT NULL , PRIMARY KEY (`agent_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created agents table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `agents` ADD `profile_pic` VARCHAR(50) NULL AFTER `email`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `agents` CHANGE `status` `status` VARCHAR(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'active';";
$mysqli->query($sql);
$sql = "ALTER TABLE `agents` ADD UNIQUE(`email`);";
$mysqli->query($sql);
$sql = "ALTER TABLE `agents` ADD UNIQUE(`phno`);";
$mysqli->query($sql);

// Deposit table
$sql="CREATE TABLE `deposit` ( `deposit_id` INT NOT NULL AUTO_INCREMENT , `account_id` INT NOT NULL , `amount` INT NOT NULL , `date` DATE NOT NULL , `staff_id` INT NOT NULL , PRIMARY KEY (`deposit_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created deposit table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `deposit` CHANGE `date` `date_of_payment` DATE NOT NULL;";
$mysqli->query($sql);
$sql = "ALTER TABLE `deposit` CHANGE `account_id` `account_no` INT(11) NOT NULL;";
$mysqli->query($sql);
$sql = "ALTER TABLE `deposit` ADD `inserted_on` DATE NOT NULL AFTER `date_of_payment`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `deposit_accounts` ADD `rate_of_interest` FLOAT(2) NULL AFTER `last_updated`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `deposit` CHANGE `account_no` `acc_id` INT(11) NOT NULL;";
$mysqli->query($sql);


// Loan table
$sql = "CREATE TABLE `loans` ( `loan_id` INT NOT NULL AUTO_INCREMENT , `acc_no` INT NOT NULL , `installment` INT NOT NULL , `period` INT NOT NULL , `mode` VARCHAR(10) NOT NULL , `rate_of_interest` FLOAT(2) NOT NULL , `interest_calculated` VARCHAR(5) NOT NULL , `guarantor_name` VARCHAR(50) NOT NULL , `security_particulars` VARCHAR(100) NOT NULL , `loan_purpose` VARCHAR(100) NOT NULL , `loan_date` DATE NOT NULL , `closing_date` DATE NOT NULL , `approved_by` INT NOT NULL , `added_on` DATE NOT NULL , `last_updated_on` DATE NOT NULL , `added_by` INT NOT NULL , `status` VARCHAR(10) NOT NULL , PRIMARY KEY (`loan_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created loan table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `loans` ADD `loan_amount` INT NOT NULL AFTER `acc_no`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `loans` ADD `loan_no` VARCHAR(20) NOT NULL AFTER `loan_id`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `loans` CHANGE `acc_no` `mem_id` INT(11) NOT NULL;";
$mysqli->query($sql);
$sql = "ALTER TABLE `loans` ADD UNIQUE(`loan_no`);";
$mysqli->query($sql);
$sql = "ALTER TABLE `loans` ADD `interest_amount` INT NOT NULL AFTER `rate_of_interest`;";
$mysqli->query($sql);
$sql = "ALTER TABLE `loans` DROP `approved_by`;";
$mysqli->query($sql);

// Messages table
$sql = "CREATE TABLE `messages` ( `msg_id` INT NOT NULL AUTO_INCREMENT , `date` DATE NOT NULL , `time` TIME NOT NULL , `from` VARCHAR(50) NOT NULL , `sub` TEXT NOT NULL , `msg` TEXT NOT NULL , PRIMARY KEY (`msg_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created messages table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `messages` ADD `to` VARCHAR(10) NOT NULL AFTER `from`;";
$mysqli->query($sql);

// Message status table
$sql = "CREATE TABLE `msg_status` ( `msg_id` INT NOT NULL , `user_id` INT NOT NULL ) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created message status table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `msg_status` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);";
$mysqli->query($sql);

// Closings table
$sql = "CREATE TABLE `closings` ( `account_no` INT NOT NULL , `date_of_closing` DATE NOT NULL , `amount_returned` INT NOT NULL , `closed_by` INT NOT NULL , PRIMARY KEY (`account_no`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created closings table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `closings` CHANGE `account_no` `account_no` VARCHAR(20) NOT NULL;";
$mysqli->query($sql);
$sql = "ALTER TABLE `closings` CHANGE `account_no` `acc_id` INT(20) NOT NULL;";
$mysqli->query($sql);

// Loan closing table
$sql = "CREATE TABLE `loan_closings` ( `loan_id` INT NOT NULL , `date_of_closing` DATE NOT NULL , `closed_by` INT NOT NULL ) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created loan closings table<br>";
	$flag = 1;

// Create CLose trigger
// $sql = "CREATE TRIGGER close_account
// AFTER INSERT ON closings
// FOR EACH ROW
// UPDATE members SET members.status='closed'
// WHERE members.account_no=NEW.account_no;";
// if ($mysqli->query($sql)) {
// 	echo "Created trigger close_account<br>";
// 	$flag = 1;
// }
// Create loan payments table
$sql = "CREATE TABLE `loan_payments` ( `payment_id` INT NOT NULL AUTO_INCREMENT , `loan_id` INT NOT NULL , `amount` INT NOT NULL , `staff_id` INT NOT NULL , `date_of_payment` DATE NOT NULL , `inserted_on` DATE NOT NULL , PRIMARY KEY (`payment_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created loan_payments table<br>";
	$flag = 1;
}
$sql = "ALTER TABLE `loan_closings` ADD `slno` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`slno`);";
$mysqli->query($sql);
}

// Loan closing table
$sql = "CREATE TABLE `sairam`.`withdrawals` ( `withdrawal_id` INT NOT NULL AUTO_INCREMENT , `acc_id` INT NOT NULL , `amount` INT NOT NULL , `date_of_withdrawal` DATE NOT NULL , `inserted_on` DATE NOT NULL , `staff_id` INT NOT NULL , PRIMARY KEY (`withdrawal_id`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created withdrawals table<br>";
	$flag = 1;
}


// All query goes above this
// No changes
if ($flag==0) {
	echo "Nothing to change";
}
?>