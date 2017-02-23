<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
	session_start();
	if(!isset($_SESSION['username']) || (trim($_SESSION['username']) == '')) 
	{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
	}
	else if(!isset($_SESSION['counter']) || (trim($_SESSION['counter']) == '')) 
	{
		echo "<meta http-equiv='refresh' content='0;url=login.php'/>";
		exit();
	}	
?>