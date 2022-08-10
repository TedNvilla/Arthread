<?php
	Class Profile
	{
		function get_profile()
		{
			$DB = new Database($user_id);
			$query = "select * from users where user_id = '$user_id' limit 1";
			return $DB->read($query);
		}
	
	}



?>