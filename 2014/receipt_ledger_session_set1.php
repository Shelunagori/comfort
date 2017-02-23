<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_GET['ledger_type']))
{
				
				if(isset($_GET['jv']))
				{
				$myobject = new DataBaseConnect();
				$res=$myobject->execute_query_return("select DISTINCT `name` from `ledger` where `ledger_type`='".$_GET['ledger_type']."'");
				echo "<select  name=\"name".$_GET['jv']."\"  class=\"m-wrap small\">";
				echo '<option value="0">----Select----</option>';
				while($obj = mysql_fetch_assoc($res)) 
				{
				echo "<option>".$obj['name']."</option>";
				}
				echo "</select>";
				$myobject->close_connection();
				}
	
}
?>
