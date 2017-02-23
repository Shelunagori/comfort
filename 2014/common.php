<?php
require 'classes/databaseclasses/DataBaseConnect.php';
if(isset($_GET['supplier_master_type']))
{
		echo "<select name=\"supplier_master_name_id\" class='m-wrap medium' >";	
		$database=new DataBaseConnect();
		$result= $database->execute_query_return("select * from supplier_master_type where supplier_master_type='".$_GET['supplier_master_type']."'");
		while($row=mysql_fetch_array($result))
		{
			echo "<option value=\"".$row['id']."\" >".$row['name']."</option>";
		}
	echo "</select>";
	$database->close_connection();
}
?>