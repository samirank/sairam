<?php
include_once ('class/config.php');
$connect = new dbconnect();
$mysqli = $connect->con();
$flag = 0;


// Create users table
$sql = "CREATE TABLE `sairam`.`users` ( `user_id` INT NOT NULL AUTO_INCREMENT , `user_name` VARCHAR(50) NOT NULL , `password` VARCHAR(100) NOT NULL , `user_role` VARCHAR(20) NOT NULL , `name` VARCHAR(50) NOT NULL , `status` VARCHAR(15) NOT NULL , PRIMARY KEY (`user_id`), UNIQUE (`user_name`)) ENGINE = InnoDB;";
if ($mysqli->query($sql)) {
	echo "Created users table<br>";
	$flag = 1;
}

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
?>