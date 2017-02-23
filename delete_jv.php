<?php
require_once("config.php");
$trans_id=$_GET["trans_id"];
$type=$_GET["type"];

	$select_receipt=mysql_query("select distinct `invoice_id` from ledger where transaction_id='".$trans_id."' && transaction_type='".$type."'");
	$result_receipt=mysql_fetch_array($select_receipt);
	$invoice_list=$result_receipt['invoice_id'];
	$inv_list=explode(",",$invoice_list);
	foreach($inv_list as $value){
	$rs_update=@mysql_query("update `invoice` set `payment_status`='no' where `id`='".$value."'");
	}
	@mysql_query("delete from ledger where `transaction_id`='".$trans_id."' && `transaction_type`='".$type."'");
?>
<script>
alert("JV Deleted successfully.");
 window.close();  
</script>