<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		
		if(isset($_POST['login']))
		{
			$user_name = $_POST['user_name'];
			$password = $_POST['password'];
			
			if(!empty($user_name)&& !empty($password) && !is_numeric($user_name))
			{
				//read to login_db database
				$query = "select * from users where user_name = '$user_name' limit 1";
				$result = mysqli_query($conn,$query);
				
				if($result)
				{
					if($result && mysqli_num_rows($result)>0)
					{
						$user_data = mysqli_fetch_assoc($result);
						
						 
						if (($user_name == "Atlaszt")&&($password == $user_data['password']) ){
							
							$_SESSION['user_id'] = $user_data['user_id'];
							
							header("Location: admin.php");
							die;
						}
						else if($user_data['password']== $password)
						{
							$_SESSION['user_id'] = $user_data['user_id'];
							
							header("Location: index.php");
							die;
						}
					}
				}
				
				echo '<script type="text/javascript">';
				echo ' alert("wrong username or password! ")';  //not showing an alert box.
				echo '</script>';
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
    <title>Login</title>
</head>
<body>
	<h1>Hangal</h1>
	<form method="post" action="login.php">
		<div style="font-size: 20px;margin: 10px;color: black;">Login</div>
			<img src='Profile.png' width='50' height ='50'><br><br>
			<input type="text" placeholder="Username" name="user_name" ><br><br>
			<input type="password" placeholder="Password" name="password"><br><br>
			<input type="submit" name="login" value="Login"><br><br>
			<a href="signup.php">Signup</a><br><br>
	</form>
</body>
</html>