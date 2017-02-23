<?php
		require_once ("config.php");
		@session_start();
		if(!isset($_SESSION['login_id'])) 
		{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
		}
		if(!isset($_SESSION['id'])) 
		{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
		}
		else if(!isset($_SESSION['username'])) 
		{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
		}	
		else if(!isset($_SESSION['counter_id'])) 
		{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
		}
		
?>