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
        <th>Delete Item</th>
		<th>Toggle Sharing Setting</th>
    </tr>
    <?php
		// display the list of all items for current user
		$username = $_SESSION['username'];
		
		// including the config file
        include('config.php');
		
		//connect to database
		$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
		if(!$mysqli || $mysqli->connect_errno) {
			die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
		}
		
		//prepare search statement
		if (!($stmt = $mysqli->prepare("SELECT id, user, title, description, due_date, shared FROM to_do WHERE user = '$username' ORDER BY due_date"))) {
			die("Prepare statement failed in user_list: (" . $mysqli->errno . ") " . $mysqli->error);
		}
		
		//execute statement
		if (!$stmt->execute()) {
			die("Execute failed in user_list: (" . $stmt->errno . ") " . $stmt->error);
		}
        
		//bind results to php variables
		if (!$stmt->bind_result($id, $user, $title, $description, $due_date, $shared)) {
			die("Bind failed in user_list: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		//loop through results and create table entries for each
        $bg = 'bg_1'; //this determines row background (bg) color
		while ($stmt->fetch()) {
			?>
			<tr class="<?php echo $bg; ?>">
				<td><?php echo $title; ?></td>
				<td><?php echo $description; ?></td>
				<td><?php echo $due_date; ?></td>
				<td><a href="#" class="delete_m" onclick="delete_to_do(<?php echo $id; ?>)"> <img src="images/delete.png"> Delete </a></td>
				<?php
				if ($shared == 0) { //task is private
					?> 
					<td><a href="#" class="share" onclick="toggle_share(<?php echo $id; ?>, 1)"> <img src="images/share_icon.jpg"> Share Task Publicly </a></td>
					<?php
				} else { //task is shared publicly
					?>
					<td><a href="#" class="share" onclick="toggle_share(<?php echo $id; ?>, 0)"> <img src="images/private_icon.jpg"> Make Task Private </a></td>
					<?php
				}
				?>
					
			</tr>
			<?php
			if ($bg == 'bg_1') {
				$bg = 'bg_2';
			} else {
				$bg = 'bg_1';
            }
        }
    ?>
</table>