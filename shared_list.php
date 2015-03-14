<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

//start session if not already
if (!isset($_SESSION)) { //
	session_start();
}
?>

<table class="table_list" cellspacing="2" cellpadding="0">
    <tr class="bg_h">
        <th>To-Do Item</th>
        <th>Description</th>
        <th>Due Date</th>
        <th>Shared By</th>
    </tr>
    <?php
		// display the list of all shared items which are were not created by current user
		$username = $_SESSION['username'];
		
		// including the config file
        include('config.php');
		
		//connect to database
		$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
		if(!$mysqli || $mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		
		//prepare search statement
		if (!($stmt = $mysqli->prepare("SELECT title, description, due_date, user FROM to_do WHERE shared = 1 ORDER BY due_date"))) {
			die("Prepare statement failed in shared_list: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		//execute statement
		if (!$stmt->execute()) {
			die("Execute failed in shared_list: (" . $stmt->errno . ") " . $stmt->error);
		}
        
		//bind results to php variables
		if (!$stmt->bind_result($title, $description, $due_date, $user)) {
			die("Bind failed in user_list: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		//loop through results and create table entries for each
        $bg = 'bg_1'; //this determines row background (bg) color
		while ($stmt->fetch()) {
			if ($user != $username) { //if shared item is not one of current users items display it in table
				?>
				<tr class="<?php echo $bg; ?>">
					<td><?php echo $title; ?></td>
					<td><?php echo $description; ?></td>
					<td><?php echo $due_date; ?></td>
					<td><?php echo $user; ?></td>
				</tr>
				<?php
				if ($bg == 'bg_1') {
					$bg = 'bg_2';
				} else {
					$bg = 'bg_1';
				}
			}
        }
    ?>
</table>