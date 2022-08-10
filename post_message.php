<?php
	session_start();
		
		include("connection.php");
		include("functions.php");
		
		$user_data = check_login($conn);
		
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Message Box</title>
	<style>
	*
	{
		padding: 0px;
		margin:0px;
		
	}
	.centeralised
	{
		margin:10px auto;
		width:1000px;
		text-align:center;
	}
	.chathistory{
		min-height:400px;
		width:600px;
		nargin:10px auto;
		padding: 10px;
		background:#f1fif1;
	}
	.txtarea{
		min-height:100px;
		width:600px;
		margin:10px auto;
		padding: 10px;	
    }		
	
	</style>
	<script
		  src="https://code.jquery.com/jquery-3.6.0.js"
		  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
		  crossorigin="anonymous">
	 </script>
</head>
<body>
	<div class="centeralised">
    <div class="chathistory"></div>
		<div class="chatbox">
			 <form action=""  method="POST">
				 <textarea class="txtarea"id = "message" name= "message"></textarea>
			 </form>
		</div>
	</div>
	<script>
		$('#message').keyup(function(e){
			var message = $(this).val();
			if (e.which == 13 ){
			   $.post('ajax.php?action=SendMessage&message='+message, function (response){
				   alert(response);
				});
			}
		});
	</script>
</body>
</html>