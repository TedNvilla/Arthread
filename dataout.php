<?php
	$connection = mysqli_connect("localhost", "root","");
	$db = mysqli_select_db($connection, "login_db");
	
	if(isset($_POST['delete']))
	{

		$id = $_POST['id'];
		$query = "DELETE FROM user_post WHERE user_id ='$id' " ;
		$query_run = mysqli_query($connection,$query);
	}
	
	header("Location: index.php");
	die;