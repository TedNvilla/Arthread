<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
		$profile = new Profile();
		$profile_data = $profile->get_profile($_GET['user_id']);
		
	

?>
<html>
	<head> 
		<title>
			<?php echo $user_data['user_name'];?> Profile 
		</title>
	</head>
	
	<body>
		<h1><?php echo $user_data['user_name'];?> Profile </h1>
		<a href="index.php">Home</a>
		<br>
		<strong>Your post so far:</strong>
		<?php
			$sql = "SELECT id, user_id, user_name, post_description, post_picture FROM user_post WHERE user_name LIKE '%" . $user_data['user_name'] . "%'";
			$result = $conn->query($sql);
			
			if($result->num_rows >0){
				while($row = $result->fetch_assoc()){
					echo "<hr>"."User: " . $row["user_name"] ."<br>". "  Description: " . $row["post_description"]
					. "<a href='index.php? id=". $row["id"] ."'> Delete </a>"."<br>" ." Picture: "."<br>"; 
					
					echo '<img src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" height="200" width="500"/>'."<br>";
					echo "<br>"."<a href='post_message.php?'>Message</a>";
					echo "<hr>" ;
				}
			}
			else{
				echo "0 Results hahahaa";
			}
		?>
		
	</body>
</html>