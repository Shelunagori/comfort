<?php
require_once("config.php");
$result=mysql_query("select `invoice_id`,`duty_slip_customer_reg_name` from invoice");
while($row=mysql_fetch_array($result))
{

	$result_invoice=mysql_query("select `detail_id` from `invoice_detail` where `invoice_invoice_id`='".$row['invoice_id']."'");
	$num_invoice=mysql_num_rows($result_invoice);
	if($num_invoice==0)
	{
		echo $row['invoice_id'];
		echo "\t";
		$find_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['duty_slip_customer_reg_name']."'");
		$row_cust=mysql_fetch_array($find_cust);
		echo $row_cust['name'];
		echo "<br />";
		
	}
}
?>