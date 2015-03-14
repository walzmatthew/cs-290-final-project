<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php');

//add to-do task for current user
session_start();
$username = $_SESSION['username'];

//connect to database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
if(!$mysqli || $mysqli->connect_errno) {
	die("Failed to connect to MySQL in add_to_do: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
//add new to-do task in db

//prepare insert statement
if (!($stmt = $mysqli->prepare("INSERT INTO to_do(user, title, description, due_date, shared) VALUES (?, ?, ?, ?, ?)"))) {
	die("Prepare statement failed in add_to_do: (" . $mysqli->errno . ") " . $mysqli->error);
}

//bind parameters
if (!$stmt->bind_param("ssssi", $username, $_POST['title'], $_POST['description'], $_POST['date'], $_POST['share'])) {
	die("Binding parameters failed in add_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//execute statement
if (!$stmt->execute()) {
	die("Execute failed in add_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//close statement
if (!$stmt->close()) {
	die("Close failed in add_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//successfully added task to to-do database. now regenerate user tasks table
include('user_list.php');

?>