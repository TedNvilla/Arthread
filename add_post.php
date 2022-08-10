<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);


	$host ="localhost";
	$username = "root";
	$user_pass = "";
	$database_in_use = "login_db";
	$conn = mysqli_connect($host, $username, $user_pass, $database_in_use);
	
	if(!$conn)
		{	
			die("Connection Failed:" . mysqli_connect_error());
		}
		
	if(isset ($_POST ["upload"]))
	{
		$user_id = $user_data['user_id'];
		$user_name = $user_data['user_name'];
		$new_post_description = $_POST["postdescription"];
		$new_post_description = addslashes($new_post_description);
		$notif_message = "Uploaded a photo";
		
		//$new_post_pic = addslashes($new_post_pic);
		
		
		if(!empty($new_post_description)&& !empty($image) && !is_numeric($new_post_description))
		{
				echo " Bawal yan";
				
		}
		else{
			if ($_FILES['postpic']['size'] != 0 )
			{
				$post_id = random_num(20);
				$post_num_id = $post_id;
				if (($_FILES['postpic']['type'] == 'image/png')||($_FILES['postpic']['type'] == 'image/jpeg')){
					$image =  (file_get_contents ($_FILES ['postpic']['tmp_name']));
					$image = addslashes ($image);
					// uploading into post database
					mysqli_query ($conn, "INSERT INTO user_post (id, user_id, post_id ,user_name, post_description, post_picture) VALUES(NULL,'$user_id','$post_id','$user_name','$new_post_description', '$image' )");
					
					//uploading into notification database
					mysqli_query ($conn, "INSERT INTO notif_data (id, user_id, user_name, notif_message, date, post_id) VALUES(NULL,'$user_id','$user_name','$notif_message','', '$post_num_id' )");
					header("Location: index.php");
					die();
				}
				else{
					echo "<script>window.alert('This is not an image! ')</script>";
					echo "<script> window.location.href='index.php';</script>";
					die();
				}
				
				
			}
			echo "<script>window.alert('Fill up necessary details! ')</script>";
			echo "<script> window.location.href='index.php';</script>";
			die();
		}
		
		
	
	}
		
	
?>
