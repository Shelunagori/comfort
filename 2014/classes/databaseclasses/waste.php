<?php

$connection = mysql_connect("localhost","root");


mysql_select_db("comfort",$connection);

$result=mysql_query("select * from duty_slip where dutyslip_id='6'");

if(mysql_num_rows($result)>0)
{
	echo "Data return";
}
else {
	
	echo "Nothing returned";
}

mysql_close($connection);
?>