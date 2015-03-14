<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

//start session if not already
if (!isset($_SESSION)) { //
	session_start();
}

include('config.php');

//toggle to-do task (id) sharing setting
$id = $_POST['id'];
$share = $_POST['share'];

//connect to database
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
if(!$mysqli || $mysqli->connect_errno) {
	die("Failed to connect to MySQL in share_to_do: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

//prepare statement to toggle sharing
if (!($stmt = $mysqli->prepare("UPDATE to_do SET shared = ? WHERE id = ?"))) {
	die("Prepare statement failed in share_to_do: (" . $mysqli->errno . ") " . $mysqli->error);
}

//bind parameters
if (!$stmt->bind_param("ii", $share, $id)) {
	die("Binding parameters failed in share_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//execute statement
if (!$stmt->execute()) {
	die("Execute failed in share_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//close statement
if (!$stmt->close()) {
	die("Close failed in share_to_do: (" . $stmt->errno . ") " . $stmt->error);
}

//successfully deleted task from to-do database. now regenerate user tasks table
include('user_list.php');

?>