<?php 
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);

	    //see all the contents of the post database
		$sql = "SELECT * FROM user_post order by id desc ";
		$result = $conn->query($sql);
		if($result->num_rows >0){
			while($row = $result->fetch_assoc()){
						
				echo "<div class='post'>";
				echo '<a id="person" href="profile.php?user_id='. $row["user_id"].'"'."<hr>"."User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"]
				. "<a href='index.php? id=". $row["id"] ."'> Delete </a>"."<br>" ." Picture: "."<br>"; 
				echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="100%" width="100%"/>'."<br>";
				echo "<br>"."<a href='report.php?post_id=".$row["post_id"] ."'>Report this post</a>";
				echo "<hr>" ;
				echo "</div>" ;
				}
			}
				

?>
