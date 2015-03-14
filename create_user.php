<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php');

//connect to database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
if(!$mysqli || $mysqli->connect_errno) {
	die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
//create new user in db

//prepare insert statement
if (!($stmt = $mysqli->prepare("INSERT INTO users(user, pass) VALUES (?, ?)"))) {
	die("Prepare statement failed in create_user: (" . $mysqli->errno . ") " . $mysqli->error);
}

//bind parameters
if (!$stmt->bind_param("ss", $_POST['username'], $_POST['password'])) {
	die("Binding parameters failed in create_user: (" . $stmt->errno . ") " . $stmt->error);
}

//execute statement
if (!$stmt->execute()) {
	if ($stmt->errno === 1062) { //duplicate title
      die('1062');
	}
	else { //some other error
	  die("Execute failed in create_user: (" . $stmt->errno . ") " . $stmt->error);
	}
}

//close statement
if (!$stmt->close()) {
	die("Close failed in create_user: (" . $stmt->errno . ") " . $stmt->error);
}

//successfully created user. now start a fresh session and save username
session_start();
$_SESSION = array();
$_SESSION['username'] = $_POST['username']; //save username to be utilized on content page

?>