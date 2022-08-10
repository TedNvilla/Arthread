<?php
	session_start();
		include("connection.php");
		include("functions.php");
		$user_data = check_login($conn);
	
	if(isset($_POST['delete'])){
		
		$reason = $_POST['reason'];
		$post_id = $_GET['post_id'];
		$user_id = $user_data['user_id'];
		$user_name = $user_data['user_name'];
		if(empty($reason))
		{
			echo "<script>window.alert('Reason are empty! please fill up ')</script>";
			echo "<script> window.location.href='obliterate.php?post_id=".$post_id."';</script>";
			die();			
		}
		$sql = "SELECT * FROM user_post WHERE post_id LIKE '%" . $post_id  . "%' order by id desc limit 1";
		$result = $conn->query($sql);	
		if($result->num_rows >0)
		{
			while($row = $result->fetch_assoc())
			{
				$post_description = $row["post_description"];
				$post_username = $row["user_name"];
				$status = "has been taken down"
				$post_user_id= $row["user_id"];
				
				mysqli_query ($conn, "INSERT INTO user_info (user_id, user_name ,post_id, post_description, post_user, post_user_id,status,report_reason) 
				VALUES('$user_id','$user_name','$post_id','$post_description','$post_username','$post_user_id','$status','$reason')");
				
				$delete = mysqli_query($conn, "DELETE FROM user_post WHERE post_id = '$post_id'");
				
				//$delete_notif = mysqli_query($conn, "DELETE FROM notif_data WHERE post_id = '$post_id'");
				
				echo "<script>window.alert('Successfully take down a post ')</script>";
				echo "<script> window.location.href='admin.php';</script>";
				die();
				
			}
			
				
		}		
	}

?>
<html>
 <body>
		<div id='posts'>
			<?php 
				if(isset($_GET['post_id'])){
						$post_id = $_GET['post_id'];
						$sql = "SELECT * FROM user_post WHERE post_id LIKE '%" . $post_id  . "%' order by id desc limit 1";
						$result = $conn->query($sql);	
						if($result->num_rows >0){
						while($row = $result->fetch_assoc()){
							echo "<form action='obliterate.php?post_id=".$post_id."' method='POST'>";
							echo "<div class='post'>";
							echo '<a href="profile.php?user_id='. $row["user_id"].'"'."<hr>"."User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"]."<br>";
							echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="auto" width="70%"/>'."<br>";
							echo '<textarea type="text" name="reason" placeholder="Reason for taking down this post..."></textarea>';
							echo'<input type="submit" name="delete" value="delete post">';
							echo '</form>';
							echo "<hr>" ;
							echo "</div>" ;
						}
						
					}
				}
			?>
				
		</div>
 </body>
</html>
