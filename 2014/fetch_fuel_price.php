<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(!empty($_GET['price']))
{
	
	
		   $myobject = new DataBaseConnect();
		   $res=$myobject->execute_query_return("select DISTINCT `name`,`rate` from `taxation` where `name`='".$_GET['price']."'");
		   $obj = mysql_fetch_assoc($res); 
		  echo "<input type=\"hidden\"  class=\"m-wrap medium\" value=".$obj['rate']." name=\"price\" />";
		 // echo '<input type="text"  class="m-wrap medium"  value="'.$obj['rate'].'" name="price" />';
}
?>
