<?php

	session_start();
		
	if (isset($_SESSION['search_count']))
	{
		echo "[ " . $_SESSION["search_count"] . " ] records";
	}
	
	

?>