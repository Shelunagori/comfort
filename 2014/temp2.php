<?php
require_once("config.php");
$result_ledger=mysql_query("select `date`,`bill_number` from `ledger` where `bill_number`!='' && `type`='' && `date`='0000-00-00'");
while($row_ledger=@mysql_fetch_array($result_ledger))
{
	$result_invoice=mysql_query("select `date` from `invoice` where `invoice_id`='".$row_ledger['bill_number']."'");
	$row_invoice=mysql_fetch_array($result_invoice);
	echo "Invoice ID ".$row_ledger['bill_number'].", Invoice Date".$row_invoice['date'];
	echo "<br/>";
	echo "update ledger set `date`='".$row_invoice['date']."' where `bill_number`='".$row_ledger['bill_number']."' && type=''";
	@mysql_query("update ledger set `date`='".$row_invoice['date']."' where `bill_number`='".$row_ledger['bill_number']."' && type=''");
	echo "<br/>";
	echo "------------------------------------------------------------------------------------------------------------------------------------------------";
}
?>