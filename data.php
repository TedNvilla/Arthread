<?php
	$host ="localhost";
	$username = "root";
	$user_pass = "";
	$database_in_use = "login_db";
	$conn = mysqli_connect($host, $username, $user_pass, $database_in_use);
	//database connction
	if(!$conn)
	{	
		die("Connection Failed:" . mysqli_connect_error());
	}


	$sql = "SELECT * FROM notif_data order by id desc limit 5";
	$result = $conn->query ($sql);
	if($result->num_rows >0) {
	  // output data of each row
	   while($row = $result->fetch_assoc()) 
		{
		  echo "<a href='userpost.php?post_id=".$row["post_id"] ."' >". $row["user_name"] ."  ".$row["notif_message"]."</a>"."<br>" ;
		} 
	}
	 else 
	 {
	   echo "0 results";
	 }
	$conn->close();
?>