<?php
//error reporting. comment out once code is working
error_reporting(E_ALL);
ini_set('display_errors', 1);

//clear session data
session_start();
$_SESSION = array();
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
        <h1 class="main_title">Welcome to What To-Do! The Personalized To-Do List Creator</h1>
        <div class="content">
			<br></br>
            <fieldset class="field_form">
                <legend> Create New Account </legend>
                <form>
                    <input type="text" class="frm_input_login" id="username1" placeholder="username"/>
                    <input type="password" class="frm_input_login" id="password1" placeholder="password"/>
                    <input type="button" class="frm_button_create" value="Create Account" onclick="create_user()"/>
                </form>
            </fieldset>
			<br></br>
            <fieldset class="field_form">
                <legend> Sign-In with Existing Account </legend>
                <form>
                    <input type="text" class="frm_input_login" id="username2" class="frm_input" placeholder="username" required oninvalid="this.setCustomValidity('You must enter a username to create an account')" oninput="setCustomValidity('')"/>
                    <input type="password" class="frm_input_login" id="password2" class="frm_input" placeholder="password" required oninvalid="this.setCustomValidity('You must enter a password to create an account')" oninput="setCustomValidity('')"/>
                    <input type="button" class="frm_button" value="Sign-In" onclick="sign_in()"/>
                </form>
            </fieldset>
        </div><!-- content -->    
    </div><!-- container -->
</body>
</html>
