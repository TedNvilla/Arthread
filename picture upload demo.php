<html>
<head>Upload Demo</head>

<body>
	<form name="form1" action ='insert.php' method="post" enctype="multipart/form-data">
    <p>Select file:</p>
	<input type="file" name="f1">
	<input type="submit" name="submit" value="upload">
	<br>
	<br>



<?php
    $conn = mysqli_connect("localhost","root","","login_db");
	//database connction
	if(!$conn)
	{	
		die("Connection Failed:" . mysqli_connect_error());
	}
	
	"<br>";
	$sql = "SELECT id, imahe FROM image ";
	$result = $conn->query($sql);
	if ($result->num_rows> 0) {
	  // output data of each row
	   while($row = $result->fetch_assoc()) 
		{
		  
		   echo '<img src="data:image/jpeg;base64,'.base64_encode ($row ['imahe']).'" height="500" width="1000"/>'."<br>";
		   
		} 
	}
	 else 
	 {
	   echo "0 results";
	 }
	$conn->close();		
	
	
?>
</body>
</html>