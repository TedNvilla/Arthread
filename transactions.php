<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
	
	echo "<a href='index.php'>Home</a>";
	echo "<hr>";
	
?>
<html>
	<body>
	<link  rel='stylesheet' type='text/css' href='style.css'>
	
		<form method ='GET' action='transactions.php'>
		<br>
		
			<div id ='transaction'>
				<strong>Search your artist to request a commision:</strong><br>
				<input type="text"
						name="user" 
						placeholder="Search an your artist commisioner" 
						size="30" 
						value="<?php if(isset ($_GET ["user_name"])){ echo $_GET["user_name"];}?>">
						<br>
				<strong>Type your request:</strong><br>
				<input type="text" name="request" placeholder="Search an your artist commisioner"size="30"><br>
				<strong>Put your email to be adressed by:</strong><br>
				<input type="email"
						name="deliver_email" 
						placeholder="put your email to sent by " 
						size="30" 
						value="<?php echo $user_data['gmail'];?>">
						<br>
				<strong>Choose your price :</strong><br>
				<input type="radio" id="Promo1" name="Promo" value="Basic commision">
				<label for="Promo1"> 200 php for face</label><br>
				<input type="radio" id="Promo2" name="Promo" value="Standard commision">
				<label for="Promo2"> 400 php for half body</label><br>
				<input type="radio" id="Promo3" name="Promo" value="Premium commision">
				<label for="Promo3"> 600 php for whole body</label><br>
				
				<input type="submit" name="submit" value="Select promo">
				<hr>
			</div>
		</form>
		<br>
	
	<?php

	if(isset ($_GET ["submit"])){
		
		$user= $_GET['user'];
		$owner = $user_data['user_name'];
		$request= addslashes($_GET['request']);
		$promo= $_GET['Promo'];
		$deliver_email= $_GET['deliver_email'];
		
		if(empty($user)|| empty($request)|| empty($promo)||empty($deliver_email))
		{
		    echo "<script>window.alert('Missing field, please fill up completely')</script>";
			echo "<script> window.location.href='transactions.php';</script>";
			die();
							
		}
		else
		{
				$sql = "SELECT * FROM users WHERE user_name LIKE '%" . $user  . "%' order by id desc limit 1";
				$result = $conn->query($sql);
			     if($result->num_rows >0)
				{
						while($row = $result->fetch_assoc()){
							
							if ($row['user_name'] == $user_data['user_name'])
							{

								echo "<script>window.alert('Cannot request a commision on yourself')</script>";
								echo "<script> window.location.href='transactions.php';</script>";
								die();
							}
							else if ($row['user_name'] == "Atlaszt"){
								echo "<script>window.alert('Cannot request a commision to Administrator!')</script>";
								echo "<script> window.location.href='transactions.php';</script>";
								die();
							}
							$user = $row["user_name"];
							$trans_id= random_num(20);
							$user_name= $user_data['user_name'];
							$user_id = $user_data['user_id'];
							$trans_data= 'Requested a commision';
							$user_req_id = $row["user_id"];
							
							
							
							
							mysqli_query ($conn, "INSERT INTO user_trans (id, tran_id, user_id, user_name, trans_data, request, promo, deliver_email,user_req_id,user) 
							VALUES(NULL,'$trans_id','$user_id','$user_name','$trans_data','$request','$promo','$deliver_email','$user_req_id','$user' )");
							
							echo "<script>window.alert('Successfully created a request! wait for the artist confirmation ')</script>";
							echo "<script> window.location.href='index.php';</script>";
							die();
						}
						
				}
				else
				{
					echo "<script>window.alert('your artist that you search does not exist or it chance  name ! please try again ! ')</script>";
				}
			
		}
		
		
			
		
	}
	echo "Transaction Details";
	echo "<br>";
	$sql = "SELECT * FROM user_trans WHERE user_req_id LIKE '%" . $user_data["user_id"] . "%' order by id desc ";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
						echo "<div id ='transaction'>";
						echo "<hr>";
						echo " User Name: ". $row["user_name"]."<br>";
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
						echo "</div>";
					
				} 
			}
	echo "<hr>";
	echo "<hr>";
	echo "Request Details";
	$sql = "SELECT * FROM user_trans WHERE user_id LIKE '%" . $user_data["user_id"] . "%' order by id desc ";
			$result = $conn->query($sql);
			if($result->num_rows >0) {
			  // output data of each row
			   while($row = $result->fetch_assoc()) 
				{
						echo "<div id ='transaction'>";
						echo "<hr>";
						echo " Requested Artist: ". $row["user"]."<br>";
						echo "Status: ".$row["trans_data"]."<br>";
						echo "Promo Requeted: ".$row["promo"]."<br>";
						echo "Requeted commision: ".$row["request"]."<br>";
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
						echo "</div>";
					
				} 
			}
	?>
	</body>
</html>