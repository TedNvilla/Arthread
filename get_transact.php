<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);


	echo '<a href="index.php">Home</a>'.'<br>';
	echo "<link  rel='stylesheet' type='text/css' href='style.css'>";	
	if (isset($_GET['tran_id'])){
		$sql = "SELECT * FROM user_trans WHERE tran_id LIKE '%" . $_GET['tran_id'] . "%' order by id desc limit 1";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					echo "<div id ='transaction'>";
					echo "<hr>";
					echo " Requested by: ". $row["user_name"]."<br>";
					echo "Status: ".$row["trans_data"]."<br>";
					echo "Promo Requested: ".$row["promo"]."<br>";
					echo "Requested commision: ".$row["request"]."<br>";
					echo "Requstor's email: ".$row["deliver_email"]."<br>";
					echo " Date: ".$row['date']."<br>";
					echo "<br>";
					if ($row['user_req_id'] == $_SESSION['user_id']){
							if($row['trans_data'] == "Requested a commision"){
								echo "<a onClick=\"javascript: return confirm('Are you sure you want to confirm this request?');\" href='get_transact.php?confirm_id=".$row['tran_id']."'>Confirm</a>";
								echo "<br>";
								echo "<a onClick=\"javascript: return confirm('Are you sure you want to decline this request?');\" href='get_transact.php?decline_id=".$row['tran_id']."'>Decline</a>"; 
							}
						}
					echo "<hr>";
					echo "</div>";
				} 	
			}
	}
	if (isset($_GET['con_id'])){
		$sql = "SELECT * FROM confirm WHERE confirm_id LIKE '%" . $_GET['con_id'] . "%' order by id desc limit 1";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					echo "<div id ='transaction'>";
					echo "<hr>";
					echo " Requested Artist: ". $row["req_artist"]."<br>";
					echo "Status: ".$row["trans_confirm"]."<br>";
					echo "Requested: ".$row["request"]."<br>";
					echo "Reason: ".$row["reason"]."<br>";
					echo "Requeted commision: ".$row["request"]."<br>";
					echo "Requstor's email: ".$row["deliver_email"]."<br>";
					echo " Date: ".$row['date']."<br>";
					echo "<br>";
					if ($row['req_artist_id'] == $_SESSION['user_id']){
							if($row['trans_data'] == "Requested a commision"){
								echo "<a onClick=\"javascript: return confirm('Are you sure you want to confirm this request?');\" href='get_transact.php?confirm_id=".$row['tran_id']."'>Confirm</a>";
								echo "<br>";
								echo "<a onClick=\"javascript: return confirm('Are you sure you want to decline this request?');\" href='get_transact.php?decline_id=".$row['tran_id']."'>Decline</a>"; 
							}
						}
					echo "<hr>";
					echo "</div>";
				} 	
			}
	}
	
	if (isset($_GET['confirm_id'])) {
					{
						$reason = "Absolutely Aprroved";
						$confirm_id = $_GET['confirm_id'];
						
						$trans_confirm = 'Approved';
						
						$sql = "SELECT * FROM user_trans WHERE tran_id LIKE '%" . $_GET['confirm_id'] . "%' order by id desc limit 1";
						$result = $conn->query($sql);
						if($result->num_rows >0){
							while($row = $result->fetch_assoc()){
									
								$user_id = $row['user_id'];
								$user_name = $row['user_name'];
								$req_artist = $row["user"];
								$req = $row["request"];
								$deliver_email= $row['deliver_email'];
								$req_artist_id = $row["user_req_id"];
								
								// attempting to update the data into database
								mysqli_query ($conn, "UPDATE user_trans SET trans_data ='$trans_confirm' WHERE tran_id='$confirm_id'");
									
								mysqli_query ($conn, "INSERT INTO confirm (id, user_id, user_name, trans_confirm, request, deliver_email,confirm_id ,req_artist, req_artist_id,reason) VALUES(NULL,'$user_id','$user_name','$trans_confirm','$req','$deliver_email','$confirm_id','$req_artist','$req_artist_id','$reason')");
									
								echo "<script>window.alert('Successfully created a request! wait for the artist confirmation ')</script>";
								echo "<script> window.location.href='index.php';</script>";
								die();
							}
								
						}
						else{
							echo "<script>window.alert('no data ! ')</script>";
						}
						
					}	
				}
	else if (isset($_GET['decline_id'])) {
					{
					
						$reason = " Denied Miserably";
						
						$decline_id = $_GET['decline_id'];
						
						$trans_denied = 'Denied';
						
						$sql = "SELECT * FROM user_trans WHERE tran_id LIKE '%" . $_GET['decline_id'] . "%' order by id desc limit 1";
						$result = $conn->query($sql);
						if($result->num_rows >0){
							while($row = $result->fetch_assoc()){
									
								$user_id = $row['user_id'];
								$user_name = $row['user_name'];
								$req_artist = $row["user"];
								$req = $row["request"];
								$deliver_email= $row['deliver_email'];
								$req_artist_id = $row["user_req_id"];
								
								mysqli_query ($conn, "UPDATE user_trans SET trans_data ='$trans_denied' WHERE tran_id='$decline_id'");
								mysqli_query ($conn, "INSERT INTO confirm (id, user_id, user_name, trans_confirm, request, deliver_email,confirm_id ,req_artist, req_artist_id,reason) VALUES(NULL,'$user_id','$user_name','$trans_denied','$req','$deliver_email','$decline_id','$req_artist','$req_artist_id','$reason' )");
									
								echo "<script>window.alert('Successfully denied a request! wait for the artist confirmation ')</script>";
								echo "<script> window.location.href='index.php';</script>";
								die();
							}
								
						}
						else{
							echo "<script>window.alert('no data ! ')</script>";
						}
						
					}	
				}
?>
