<?php

require_once 'login_status.php';
require_once 'connectdb.php';

$error = "";
$username = "";
$password = "";

if($loggedin)
{
	header("Location: admin.php");
}
else if (isset($_POST['username']))
{
	$username = $connection->real_escape_string($_POST['username']);
	$password = $connection->real_escape_string($_POST['password']);

	if ($username == "" && $password == "")
		$error = "Please enter in your username and password.<br/>";
	else if ($username == "")
		$error = "Please enter your username.<br/>";
	else if ($password == "")
		$error = "Please enter your password<br/>";
	else
	{
		$query = "SELECT username, password FROM administration
			WHERE username='$username' AND password='$password'";
		$result = query_database($connection, $query);

		if ($result->num_rows == 0)
		{
			$error = "Username/Password Invalid";
		}
		else
		{
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;

			header("Location: admin.php");

		}
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Twitter Bootstrap 3 Responsive Layout Example</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../js/bootstrap.js"></script>
</head>
<body>
    <div class="container">
        <div class="jumbotron">
            <h1 align="center">CS3319 Assignment 3</h1>
            <p align="center">By: Alex MacLean & Will Callaghan</p>
        </div>
        <h2> Login to access secretary privileges:</h2>
        <div class=>
        <div class="span12">
            <form class="form-horizontal" action='login.php' method="POST">
              <fieldset>
                <div class="control-group">
                  <!-- Username -->
                  <label class="control-label"  for="username">Username</label>
                  <div class="controls">
                    <input type="text" id="$username" name="username" placeholder="" class="input-xlarge">
                  </div>
                </div>
                <div class="control-group">
                  <!-- Password-->
                  <label class="control-label" for="password">Password</label>
                  <div class="controls">
                    <input type="password" id="$password" name="password" placeholder="" class="input-xlarge">
                  </div>
                </div>
                <br/>
                <div class="control-group">
                  <!-- Button -->
                  <div class="controls">
                    <button class="btn btn-success">Login</button>
                  </div>
                </div>
              </fieldset>
            </form>
        </div>
    </div>
    </div>
</body>
</html>                                     