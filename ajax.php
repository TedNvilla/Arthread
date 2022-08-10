<?php
	if( isset($_REQUEST['action'])){
		
		switch ($_REQUEST['action']){
			
			case "SendMessage":
				echo 'coming from ajax.php file';
			
			break;
		}
	}
?>