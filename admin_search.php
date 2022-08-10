<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
	$user_data = check_login($conn);
	$keywordfromform = $_GET["keyword"];
	//database connction
	if(!$conn)
		{	
			die("Connection Failed:" . mysqli_connect_error());
		}
		
	
	echo "<h2>Show all words that contain $keywordfromform: </h2>";
	echo "<link  rel='stylesheet' type='text/css' href='style.css'>";	
	echo "<a href='admin.php?'>Return Home Admin</a>";
	echo "<br>";
	echo "<br>";
	
	$sql = "SELECT * FROM user_post WHERE user_name LIKE '%" . $keywordfromform  . "%' order by id desc";
	$result = $conn->query($sql);
			
	if($result->num_rows >0){
		while($row = $result->fetch_assoc()){
					echo "<div class='post'>";
					echo '<a href="admin_profile.php?user_id='. $row["user_id"].'"'."<hr>"."User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"]
					. "<a onClick=\"javascript: return confirm(' Are you sure you want delete this post Admin?');\" href='obliterate.php? id=". $row["id"] ."'> Delete </a>"."<br>" ." Picture: "."<br>"; 
					echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="100%" width="100%"/>'."<br>";
					echo "<hr>" ;
					echo "</div>" ;
				}
			}
			else{
				echo "<script>window.alert('Your searched artist " . $keywordfromform  ."  does not exist ')</script>";
				echo "<script> window.location.href='admin.php';</script>";
				die();
			}

?>