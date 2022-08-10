<?php
	session_start();
			include("connection.php");
			include("functions.php");
		
		$user_data = check_login($conn);
?>
		
	<html>
	<link  rel='stylesheet' type='text/css' href='style.css'>
	<body>
	<div class='container'>
		<h1> Hello Admin <?php echo $user_data['user_name'];?> </h1>
		<br>
		<form action="admin_search.php">
			 Search:<br>
			<input type="text" name="keyword" placeholder="Search"><br>
			<input type="submit" value="Search User">
		</form>
		<hr>
		<?php
			echo " <strong> Notice : </strong>"."<br>";
			$sql = "SELECT * FROM user_info order by id desc";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					if ($row['status'] == "has been reported"){
						echo "<strong>"." <a href ='' >"."This  post is ".$row['status']. " by ".$row['user_name']."</a>"."</strong>"."<br>";
					}
							
				} 
			}
			else
			{
				echo "no reports so far";
			}
		?>
		<hr>
		<a href="logout.php">Logout</a><br>
		<br>
		<hr>
		<div class="admin_post_view">
			<?php
				$sql = "SELECT * FROM user_post order by id desc ";
				$result = $conn->query($sql);
				if($result->num_rows >0){
				while($row = $result->fetch_assoc()){
							
					echo "<div class='post'>";
					echo '<a id="person" href="admin_profile.php?user_id='. $row["user_id"].'"'."<hr>"."User: " . $row["user_name"] ."</a>"."<br>". "  Description: " . $row["post_description"]
					. "<a onClick=\"javascript: return confirm(' Are you sure you want delete this post Admin?');\" href='obliterate.php?post_id=". $row["post_id"] ." ' > Delete </a>"."<br>" ." Picture: "."<br>"; 
					echo '<img alt="'. $row["user_name"].' Post Image" src="data:image/jpeg;base64,'.base64_encode ($row ['post_picture']).'" max-height="100%" width="100%"/>'."<br>";
					echo "<br>"."<a href='post_message.php?'>Reports</a>";
					echo "<hr>" ;
					echo "</div>" ;
					}
				}
			
			?>
			
		</div>
		<hr>
	<div class ="transactions">
		<?php
				echo "Transaction Details";
	echo "<br>";
	$sql = "SELECT * FROM confirm order by id desc limit 10 ";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
						echo "<div id ='transaction'>";
						echo "<hr>";
						echo " Requestor's Username: ". $row["user_name"]."<br>";
						echo " Artist's Username: ". $row["req_artist"]."<br>";
						echo " Status: ".$row["trans_confirm"]."<br>";
						if($row["trans_confirm"]!= "Approved"){
							echo " Reason: ".$row['reason']."<br>";
						}
						echo " Requested commision: ".$row["request"]."<br>";
						echo " Requstor's email: ".$row["deliver_email"]."<br>";
						//dapat yung email nung artist nandito
						//echo " Requstor's email: ".$row["deliver_email"]."<br>";
						echo " Date: ".$row['date']."<br>";
						echo "<br>";
						echo "</div>";
				} 
			}
	echo "<hr>";
	?>
	</div>
	</div>
	</body>
	<script type="text/javascript">
		
	</script>
	
</html>	
		