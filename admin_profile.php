<?php
		session_start();
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
		if(isset($_GET['user_id'])){
			$profile_data = $_GET['user_id'];
			$query = "select * from users where user_id = '$profile_data' limit 1";
			
			$result = mysqli_query($conn,$query);
		
		
			if($result && mysqli_num_rows($result)>0)
			{
				$profile_data = mysqli_fetch_assoc($result);
			}
		
		
			if(is_array($profile_data))
			{
				$user_data = $profile_data;
			}	
		}
		

?>
<html>
	<head> 
		<title>
			<?php echo $user_data['user_name'];?> Profile 
		</title>
		<link  rel='stylesheet' type='text/css' href='style.css'>
	</head>
	
	<body>
		<p>
			<?php
				echo "<br>";
				echo "<h1>".$user_data['user_name']." Profile"."</h1>";
				echo "<a class='home' href='admin.php'>Return Home Admin</a> <br>";
				echo "<br>";
				echo " Gcash: ".$user_data['gcash']."<br>";
				echo " Gmail: " .$user_data['gmail']."<br>";
				echo " Bio: " .$user_data['bio']."<br>";
			?> 
			
		</p>
		
		<?php 
			if ($user_data['user_id'] == $_SESSION['user_id']){
				echo "<h3><a href='update.php?user_id=".$user_data["user_id"]."'>" ." "." Update your profile"."</a>"."</h3>";
					}
			
			
		?>
		
		
		<strong>Your post so far:</strong>
		<br>
		<?php
			$sql = "SELECT * FROM user_post WHERE user_name LIKE '%" . $user_data['user_name'] . "%' order by id desc";
			$result = $conn->query($sql);
			
			if($result->num_rows >0){
				while($row = $result->fetch_assoc()){
					echo "<div class='post'>";
					echo "<hr>".'<a href="profile.php?user_id='. $row["user_id"].'"'."<hr>";
					echo "User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"];
					if ($row['user_id'] == $_SESSION['user_id']){
						echo "<a href='index.php?post_id=".$row["post_id"]."'> Delete </a>";
					}
					echo "<br>"." Picture: "."<br>"; 
					echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="100%" width="100%"/>'."<br>";
					echo "<br>"."<a href='post_message.php?'>Message</a>";
					echo "<hr>" ;
					echo "</div>";
				}
			}
			else{
				echo "0 Results hahahaa";
			}
		?>
		
	</body>
</html>