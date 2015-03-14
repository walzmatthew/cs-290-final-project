<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('config.php');

//delete to-do task (id) for current user
$id = $_POST['id'];

//connect to database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
if(!$mysqli || $mysqli->connect_errno) {
	die("Failed to connect to MySQL in delete_to_do: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

//prepare delete statement
if (!($stmt = $mysqli->prepare("DELETE FROM to_do WHERE id = ?"))) {
	die("Prepare statement failed in delete_to_do: (" . $mysqli->errno . ") " . $mysqli->error);
}

//bind parameters
if (!$stmt->bind_param("i", $id)) {
	die("Binding parameters failed in delete_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//execute statement
if (!$stmt->execute()) {
	die("Execute failed in delete_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//close statement
if (!$stmt->close()) {
	die("Close failed in delete_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//successfully deleted task from to-do database. now regenerate user tasks table
include('user_list.php');

?>