<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
		//delete function in the post 
		if (isset($_GET['post_id'])) {
					{
						$post_id = $_GET['post_id'];
						$delete = mysqli_query($conn, "DELETE FROM user_post WHERE post_id = '$post_id'");
						$delete_notif = mysqli_query($conn, "DELETE FROM notif_data WHERE post_id = '$post_id'");
					}	
				}
		
?>

<html>
	<link  rel='stylesheet' type='text/css' href='style.css'>
	<body>
	<div class='container'>
		<h1> Tanginamo <a href="profile.php"> <?php echo $user_data['user_name'];?> </a></h1>
		<h3><a class='request' href='transactions.php'> Make a Request</a></h3> 
		<br>
		<form action="search_keyword.php">
			 Search:<br>
			<input type="text" name="keyword" placeholder="Search"><br>
			<input type="submit" value="Search User">
		</form>
		<hr>
		<?php 
			echo "<strong> Your Request Poll: </strong>"."<br>";
			$sql = "SELECT * FROM user_trans WHERE user_req_id LIKE '%" . $user_data["user_id"] . "%' order by id desc limit 5";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					if ($row['trans_data']=="Requested a commision"){
						echo "<strong><a href='get_transact.php?tran_id=".$row["tran_id"] ."' >". $row["user_name"] ." ".$row["trans_data"]."  in ".$row["promo"]."</a>"."</strong>"."<br>";
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
					echo "<strong><a href='get_transact.php?con_id=".$row["confirm_id"] ."'> Your requested commission has been ".$row["trans_confirm"]." by ".$row['req_artist']."<br>"."</a></strong>";
				} 
			}
			echo "<hr>";
			echo " <strong> Notice : </strong>"."<br>";
			$sql = "SELECT * FROM user_info WHERE post_user_id LIKE '%" . $user_data["user_id"] . "%' order by id desc limit 10";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
					echo "<strong>"." <a href ='' >"."Your post ".$row['status']. " by ".$row['user_name']."</a>"."</strong>"."<br>";
				} 
			}
		?>
		<hr>
		<h5> Notifications: </h5>
		<strong id="notif_num"></strong>
		<hr>
		<br>
		<br>
		
		<a href="logout.php">Logout</a><br>
		<br>
		<br>
		<form action="add_post.php" method="POST" enctype="multipart/form-data">
		<div id='posts'>
			
			Post description: <br>
			<input type="text" name="postdescription"><br>
			
			Insert Picture:<br>
			<input type="file"  name="postpic"><br>
			
			<?php 
				$user = $user_data['user_name'];	
			?>
			
			<input type="submit" name="upload"value="upload">
		</div>
		</form>
		<hr>
		<div id ="view">
		</div>
		<hr>
		<form method="POST" action="dataout.php">
			ID:<input type="text" name="id" ><br>
			<input type="Submit" name="delete" value="delete">
		</form>
	</div>
	</body>
	<script type="text/javascript">
		function loadDoc() {
		  setInterval(function(){
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
				if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("notif_num").innerHTML = this.responseText;
					}
				};
		  xhttp.open("GET", "data.php", true);
		  xhttp.send();
			  
			  
		  },400);
		  
		}
		loadDoc();
	</script>
	<script type="text/javascript">
		function loadView() {
		  setInterval(function(){
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() 
				{
				if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("view").innerHTML = this.responseText;
					}
				};
		  xhttp.open("POST", "view.php", true);
		  xhttp.send();
			  
			  
		  },400);
		  
		}
		loadView();
	</script>
	
</html>