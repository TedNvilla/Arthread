<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			$user_name = $_POST['user_name'];
			$gmail = $_POST['Gmail'];
			$password = $_POST['password'];
			$gcash = " ";
			$bio = " ";
			
			//$profile_img = "<img src='Profile.png' alt= 'profile img'>"
			$sql = mysqli_query($conn, "select user_name from users WHERE user_name LIKE '%" . $user_name  . "%'");
			
			if(mysqli_num_rows($sql)) {
				echo '<script type="text/javascript">';
				echo ' alert("Username does already exist ! ")';  //not showing an alert box.
				echo '</script>';
			}
			
			else if(!empty($user_name)&& !empty($password) && !is_numeric($user_name)&& !empty($gmail)&& !is_numeric($gmail))
			{
				//save to login_db database
				$user_id = random_num(20);
				mysqli_query($conn,"insert into users (user_id,user_name,password,gmail,gcash,bio,user_profile,) values ('$user_id','$user_name','$password','$gmail','$gcash','$bio')");
				
				header("Location: login.php");
				die;
			}
			else
			{
				echo '<script type="text/javascript">';
				echo ' alert("Please enter some valid information! ")';  //not showing an alert box.
				echo '</script>';
			}
		}
?>
<html>
<head>
    <title>Sign-Up</title>
</head>
<body>
	<h1>Hangal</h1>
	<form method="post" >
		<div style="font-size: 20px;margin: 10px;color: black;">Signup</div>
			<img src='Profile.png' width='50' height ='50'><br><br>
			<input type="text" placeholder="Username" name="user_name"><br><br>
			<input type="email" placeholder="Gmail" name="Gmail"><br><br>
			<input type="password" placeholder="Password" name="password"><br><br>
			<input type="submit" value="Signup"><br><br>
			<a href="login.php">Login</a><br><br>
	</form>
</body>
</html>