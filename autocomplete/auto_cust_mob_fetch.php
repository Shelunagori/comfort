<?php  
require_once("../config.php");
$q=$_GET['q'];
$rsd = mysql_query("SELECT DISTINCT `mobile_no` From `customer_reg` where `mobile_no` LIKE '%$q%' ");
while($rs = mysql_fetch_array($rsd))
{
$mobile_no = $rs['mobile_no'];
echo "$mobile_no\n";
}
?>
  