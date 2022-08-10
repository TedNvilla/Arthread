<?php
	$conn = mysqli_connect("localhost","root","","login_db");
	//database connction
	if(!$conn)
	{	
		die("Connection Failed:" . mysqli_connect_error());
	}
	if(isset ($_POST ["submit"]))
	{
		$image = addslashes (file_get_contents ($_FILES ['f1']['tmp_name']));
		mysqli_query ($conn,"insert into image (id,imahe) values ('','$image')");
		header("Location: picture upload demo.php");
		die();
	}

?>