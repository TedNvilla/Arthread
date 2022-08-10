<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
		if (isset($_POST["update"]))
		{
            $user_name = $_POST['username'];
			$gcash = $_POST['gcash'];
			$bio = $_POST['bio'];
			$image =  "";
            $owner = $user_data['user_id'];
    		//update to users table
			
			$sql = mysqli_query($conn, "select user_name from users WHERE user_name LIKE '%" . $user_name  . "%' limit 1" );
			
			if(mysqli_num_rows($sql)) {
				echo '<script type="text/javascript">';
				echo ' alert("Username does already been used  ! ")';  //not showing an alert box.
				echo '</script>';
			}
			else{
				mysqli_query ($conn, "UPDATE users SET user_name='$user_name', gcash='$gcash', bio='$bio' WHERE user_id='$owner'");
				echo "<script>window.alert('Sucessfully edited your profile! ')</script>";
				//echo "<script> window.location.href='index.php';</script>";
				//die();
			}
			
				
		}
	
?>
<html>
<head>
    <title>Update Profile</title>
</head>
<body>
	<h1>Profile update</h1>
	<a href="index.php">Home</a>
	<div> <h1>Update</h1>
    	<form method="POST" action='update.php'enctype="multipart/form-data">
    			<input type="text" name="username" placeholder="user name" value="<?php echo $user_data['user_name']?>"><br><br>
				<input type="num"  name="gcash" placeholder="user name" value="<?php echo $user_data['gcash']?>"><br><br>
				<input type="text" name="bio" placeholder="bio" value="<?php echo $user_data['bio']?>"><br><br>
				<input type="submit" name="update" value="update">
    	</form>
		<script>
	</div>
	

	
</body>
</html>