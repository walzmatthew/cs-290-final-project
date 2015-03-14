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
//search for user and password in db
$username = $_POST['username'];
//prepare search statement
if (!($stmt = $mysqli->prepare("SELECT (pass) FROM users WHERE user = '$username'"))) {
	die("Prepare statement failed in sign-in: (" . $mysqli->errno . ") " . $mysqli->error);
}

//execute statement
if (!$stmt->execute()) {
	die("Execute failed in sign-in: (" . $stmt->errno . ") " . $stmt->error);
}

//bind results to php variables
if (!$stmt->bind_result($password)) {
	die("Bind failed in sign-in: (" . $stmt->errno . ") " . $stmt->error);
}

//check if any username returned any results. if yes, check if password matches. return necessary feedback to user
if ($stmt->fetch()) { //username found. check password
	if ($password == $_POST['password']) { //password and username match. start a fresh session and save username
		session_start();
		$_SESSION = array();
		$_SESSION['username'] = $_POST['username']; //save username to be utilized on content page
		die('match');
	} else { //username found, but password doesn't match
		die('password');
	}
} else { //username not found
	die('username');
}

?>