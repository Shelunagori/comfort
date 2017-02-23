<?php  
require_once("../config.php");
$q=$_GET['q'];
$rsd = mysql_query("SELECT DISTINCT `email_id` From `customer_reg` where `email_id` LIKE '%$q%' ");
while($rs = mysql_fetch_array($rsd))
{
$email_id = $rs['email_id'];
echo "$email_id\n";
}
?>
  