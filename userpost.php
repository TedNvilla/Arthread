<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
	echo "<link  rel='stylesheet' type='text/css' href='style.css'>";	
	echo "<a href='index.php'> Home </a>";	
	echo "<div id='get'>";
	if(isset($_GET['post_id'])){
		
		$sql = "SELECT * FROM user_post WHERE post_id LIKE '%" . $_GET['post_id'] . "%' limit 1";
			$result = $conn->query($sql);
			
			if($result->num_rows >0){
				while($row = $result->fetch_assoc()){
						echo "<div class='post'>";
						echo "<div class='image'>"."<hr>".'<a display = "flex" align-items="center" href="profile.php?user_id='. $row["user_id"].'"'."<hr>"."<img src='Profile.png' width='50' height ='50' alt='". $row["user_name"]." Profile' margin-right='100px'>" . $row["user_name"] ."</a>"."<br>"."<br>". "  Description: " . $row["post_description"];
						if ($row['user_id'] == $user_data['user_id']){
							echo "<a href='index.php?post_id=".$row["post_id"]."'> Delete </a>";
						}
						echo "<br>"." Picture: "."<br>"; 
						echo "<a href='userpost.php?post_id=".$row["post_id"] ."' >";
						echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="100%" width="100%"/>'."<br>";
						echo "</a>";
						echo "<hr>"."</div>";
						echo "</div>" ;
				}
			}
			else{
				echo "0 Results hahahaa";
			}
		
		
	}
	echo "</div>";
	
?>