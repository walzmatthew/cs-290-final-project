<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

//start session to check for valid login. if not, redirect to login page
session_start();
if (!isset($_SESSION['username'])) {
	header("Location: login.php", true);
	die();
}
?>

<html>
<head>
<meta charset="utf-8">
<title>What To-Do! Personalized To-Do Lists</title>
<link rel="stylesheet" href="css/final-style.css" />
<script type="text/javascript" src="js/final-jscript.js"></script>
</head>

<body>
    <div class="container">
        <div class="header">
        </div><!-- header -->
        <h1 class="main_title">What To-Do! Personalized To-Do Lists <a class="logout_button" href="login.php"> Logout </a></h1>
        <div class="content">
			<br></br>
            <fieldset class="field_form">
                <legend> <img src="images/plus.gif"> Add a new To-Do List Task, <?php echo "$_SESSION[username]"; ?> </legend>
                <form>
                    <label class="frm_label">To-Do List Task Name: <input type="text" id="title" class="frm_input_title" placeholder="Become Andy's Favorite Toy">
                    <label class="frm_label">Task Description (optional) (100 character max): <input type="text" id="description" class="frm_input_description" placeholder="Need to beat out Woody and Buzz">
                    <label class="frm_label">Due Date: <input type="date" id="due_date" class="frm_input_date" placeholder="mm/dd/yyyy">
					<label class="frm_label">Sharing Setting: <select id="share" class="frm_input_share"><option selected value="0">Private Entry</option><option value="1">Share Publicly</option></select>
                    <input type="button" class="frm_button" value="Add Task" onclick="add_to_do()">
                </form>
            </fieldset>
            <br></br>
			<fieldset class="field_container">
                <legend> <?php echo "$_SESSION[username]"; ?>'s To-Do List </legend>
                <div id="user_table">
                    <?php 
                        //call user_list.php to create list of user's tasks
                        include('user_list.php'); 
                    ?>
                </div><!-- user_table -->
            </fieldset>
			<br></br>
			<fieldset class="field_container">
                <legend> To-Do Tasks shared by other users </legend>
                <div id="shared_table">
                    <?php 
						//call shared_list.php to create list of shared tasks
                        include('shared_list.php'); 
                    ?>
                </div><!-- shared_table -->
            </fieldset>
        </div><!-- content -->    
    </div><!-- container -->
</body>
</html>
