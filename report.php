<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
		if(isset($_POST['report'])){
		
		$reason = $_POST['reason'];
		$post_id = $_GET['post_id'];
		$user_id = $user_data['user_id'];
		$user_name = $user_data['user_name'];
		
		if(empty($reason))
		{
			echo "<script>window.alert('Reason are empty! please fill up ')</script>";
			echo "<script> window.location.href='report.php?post_id=".$post_id."';</script>";	
		}
		
		$sql = "SELECT * FROM user_post WHERE post_id LIKE '%" . $post_id  . "%' order by id desc limit 1";
		$result = $conn->query($sql);	
		if($result->num_rows >0)
		{
			while($row = $result->fetch_assoc())
			{
				$post_description = $row["post_description"];
				$post_username = $row["user_name"];
				$status = "has been reported";
				$post_user_id= $row["user_id"];
				
				mysqli_query ($conn, "INSERT INTO user_info (user_id, user_name ,post_id, post_description, post_user, post_user_id,status,report_reason) 
				VALUES('$user_id','$user_name','$post_id','$post_description','$post_username','$post_user_id','$status','$reason')");
				
				echo "<script>window.alert('Post has reported')</script>";
				echo "<script> window.location.href='index.php';</script>";
				die();
				
			}
			
				
		}		
	}
	if(isset($_POST['report_user'])){
		
		$reason = $_POST['reason_name'];
		$user_reported = $_GET['reported_user'];
		$user_id = $user_data['user_id'];
		$user_name = $user_data['user_name'];
		
		if(empty($reason))
		{
			echo "<script>window.alert('Reason are empty! please fill up ')</script>";
			echo "<script> window.location.href='report.php?reported_user=".$reported_user."';</script>";	
		}
		else{
			mysqli_query ($conn, "INSERT INTO report_user (user_id, user_name , rep_user_name, reason) 
			VALUES('$user_id','$user_name','$user_reported','$reason')");
					
			echo "<script>window.alert('User has been reported')</script>";
			echo "<script> window.location.href='index.php';</script>";
			die();
		}
					
		
				
					
	}
		
?>
<html>
 <body>
		<div id='posts'>
			<?php 
				if(isset($_GET['post_id'])){
						$post_id = $_GET['post_id'];
						$owner = $user_data['user_name'];
						$result = mysqli_query($conn, "select * from user_info WHERE user_name = '$owner' and post_id='$post_id'");
						if ($result) {
							if (mysqli_num_rows($result) > 0) {
								echo "<script>window.alert('Cannot report again!')</script>";
								echo "<script> window.location.href='index.php';</script>";
								die();
							} 
							else {
								
								$sql = "SELECT * FROM user_post WHERE post_id ='$post_id' ";
								$result = $conn->query($sql);
								if($result->num_rows >0){
									while($row = $result->fetch_assoc()){
										echo "<form action='report.php?post_id=".$post_id."' method='POST'>";
										echo "<div class='post'>";
										echo '<a href="profile.php?user_id='. $row["user_id"].'"'."<hr>"."User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"]."<br>";
										echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="auto" width="70%"/>'."<br>";
										echo '<textarea type="text" name="reason" placeholder="Reason for reporting down this post..."></textarea>';
										echo '<br>';
										echo'<input type="submit" name="report" value="report this post">';
										echo '</form>';
										echo "<hr>" ;
										echo "</div>" ;
									}
								}
							} 
						
						}
					}
					if(isset($_GET['reported_user'])){
						$reported_user = $_GET['reported_user'];
						$owner = $user_data['user_name'];
						$result = mysqli_query($conn, "select * from report_user WHERE user_name = '$owner' and rep_user_name ='$reported_user'");
						if ($result) {
							if (mysqli_num_rows($result) > 0) 
							{
								echo "<script>window.alert('Cannot report again!')</script>";
								echo "<script> window.location.href='index.php';</script>";
								die();
							} 
							else 
							{
									
								echo "<form action='report.php?reported_user=".$reported_user."' method='POST'>";
								echo "<div class='report_user'>";
								echo '<textarea type="text" name="reason_name" placeholder="Reason for reporting this User..."></textarea>';
								echo '<br>';
								echo'<input type="submit" name="report_user" value="report this user">';
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