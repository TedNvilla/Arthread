<?php
	$host ="localhost";
	$username = "root";
	$user_pass = "";
	$database_in_use = "login_db";
	if(!$conn = mysqli_connect($host, $username, $user_pass, $database_in_use))
	{
		die("failed to connect!");
	}
?>