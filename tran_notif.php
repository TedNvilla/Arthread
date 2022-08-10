<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);

	$sql = "SELECT * FROM user_trans WHERE user_req_id LIKE '%" . $user_data["user_id"] . "%' order by id desc limit 5";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					if ($row['trans_data']=="Requested a commision"){
						echo "<strong><a href='get_transact.php?tran_id=".$row["tran_id"] ."' >". $row["user_name"] ."  ".$row["trans_data"]." in ".$row["promo"]."</a>"."</strong>"."<br>";
					}
					
				} 
			}
			
			echo "<hr>";
			echo " <strong> Confirmation: </strong>"."<br>";
			$sql = "SELECT * FROM confirm WHERE user_id LIKE '%" . $user_data["user_id"] . "%' order by id desc limit 5";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					echo "<strong><a href='get_transact.php?tran_id=".$row["confirm_id"] ."'> Your requested commission has been ".$row["trans_confirm"]." by ".$row['req_artist']."<br>"."</a></strong>";
				} 
			}
?>