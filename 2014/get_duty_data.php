<?php
require 'classes/databaseclasses/DataBaseConnect.php';

if(isset($_GET['id']) && isset($_GET['pay_fetch']))
{
	$myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select * from `ledger` where `ledger_type`='".$_GET['ledger_type']."' and `name`='".$_GET['ledger_name']."' and `date` between '".DateExact($_GET['date_from'])."' and '".DateExact($_GET['date_to'])."' and `type`='Payment' and `id` ".$_GET['what']." '".$_GET['id']."' order by `id` limit 1");
   
   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_array($res);
   		echo DisplayDate($row['date']).",".$row['type_id'].",";
		if($row['name']=='')
		{	
			echo $row['cust_supp_name'];
		}
		else
		{
			echo $row['name'];
		}
		echo ",".$row['narration'].",".$row['credit'].",".$row['debit'].",".$row[0];
		echo ",<a href=\"view.php?payment=true&id=".$row['id']."\" target=\"_blank\">view</a>
                              /
                            	<a href=\"javascript:deleteInvoice(".$row['type_id'].")\" style=\"text-decoration:none; font-size:10px;\">Delete</a>";
   }
   else {
   		echo "NA,NA,NA,NA,NA,NA,".$_GET['id'];
		echo ",<a href=\"view.php?payment=true&id=".$_GET['id']."\" target=\"_blank\">view</a>
                              /
                            	<a href=\"javascript:deleteInvoice(0)\" style=\"text-decoration:none; font-size:10px;\">Delete</a>";
   }
   $myobject->close_connection();
}
else if(isset($_GET['id']) && isset($_GET['rec_fetch']))
{
	$myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select * from `ledger` where `ledger_type`='".$_GET['ledger_type']."' and `name`='".$_GET['ledger_name']."' and `date` between '".DateExact($_GET['date_from'])."' and '".DateExact($_GET['date_to'])."' and `type`='Receipt' and `id` ".$_GET['what']." '".$_GET['id']."' order by `id` limit 1");
   
   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_array($res);
   		echo DisplayDate($row['date']).",".$row['type_id'].",";
		if($row['name']=='')
		{	
			echo $row['cust_supp_name'];
		}
		else
		{
			echo $row['name'];
		}
		echo ",".$row['narration'].",".$row['credit'].",".$row['debit'].",".$row[0];
		echo ",<a href=\"view.php?payment=true&id=".$row['id']."\" target=\"_blank\">view</a>
                              /
                            	<a href=\"javascript:deleteInvoice(".$row['type_id'].")\" style=\"text-decoration:none; font-size:10px;\">Delete</a>";
   }
   else {
   		echo "NA,NA,NA,NA,NA,NA,".$_GET['id'];
		echo ",<a href=\"view.php?payment=true&id=".$_GET['id']."\" target=\"_blank\">view</a>
                              /
                            	<a href=\"javascript:deleteInvoice(0)\" style=\"text-decoration:none; font-size:10px;\">Delete</a>";
   }
   $myobject->close_connection();
}
else if(isset($_GET['iddd']) && isset($_GET['what']) && isset($_GET['ledger_type']) && isset($_GET['ledger_name']))
{
	$myobject = new DataBaseConnect();
   if($_GET['what']=='next')
   {
   		$res=$myobject->execute_query_return("select * from `ledger` where `id`>'".$_GET['iddd']."' and
		`ledger_type`='".$_GET['ledger_type']."' and `name`='".$_GET['ledger_name']."' and `narration` <> '' order by `id` LIMIT 1");	
   }
   else {
   		$res=$myobject->execute_query_return("select * from `ledger` where `id`<'".$_GET['iddd']."' and
		`ledger_type`='".$_GET['ledger_type']."' and `name`='".$_GET['ledger_name']."' and `narration` <> '' order by `id` DESC LIMIT 1");
   }

   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_assoc($res);
   		echo $row['ledger_type'].",".$row['name'].",".$row['credit'].",".$row['debit'].",".$row['date'].",".$row['narration'].",".$row['id'];
   }
   else {
   		echo "NA,NA,NA,NA,NA,NA,".$_GET['iddd'];
   }
   $myobject->close_connection();
}
 else if(isset($_GET['id']))
 {
   $myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select * from `receipts` where id=".$_GET['id']);
   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_array($res);
   		echo $row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5].",".$row[6].",".$row[7];
   }
   else {
   		echo "NA,NA,NA,NA,NA,NA,NA";
   }
   $myobject->close_connection();
 }
 else if(isset($_GET['del_id']))
 {
 	$myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select `invoice_ids` from `receipts` where `id`='".$_GET['del_id']."'");
   if(mysql_num_rows($res)>0)
   {
   		$row=mysql_fetch_array($res);
   		$ids=array();
   		$ids=explode(",", $row['invoice_ids']);
   foreach ($ids as $value) {
		$myobject->execute_query_update("update `invoice` set `status`='no' where `invoice_id`='".$value."'", "invoice_status");
	}
	$myobject->execute_query_update("delete from `receipts` where id='".$_GET['del_id']."'", "invoice_status");
	$myobject->execute_query_update("delete from `ledger` where `bill_number`='".$row['invoice_ids']."'", "invoice_status");
   	echo "Deletion Successfull";
   }
   else {
   		echo "No Data Found";
   }
   $myobject->close_connection();
 }
 else if(isset($_GET['del_pay_id']))
 {
 	$myobject = new DataBaseConnect();
	$myobject->execute_query_update("delete from `payment` where id='".$_GET['del_pay_id']."'", "invoice_status");
	$myobject->execute_query_update("delete from `ledger` where `payment_id`='".$_GET['del_pay_id']."'", "invoice_status");
   	echo "Deletion Successfull";
   	$myobject->close_connection();
 }
 else if(isset($_GET['idd']))
 {
   $myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select * from payment where id=".$_GET['idd']);
   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_array($res);
   		echo $row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5].",".$row[6].",".$row[7].",".$row[8].",".$row[9].",".$row[11].",".$row[10];
   }
   $myobject->close_connection();
 }
 else if(isset($_GET['iddd']))
 {
   $myobject = new DataBaseConnect();
   $res=$myobject->execute_query_return("select * from journal where id=".$_GET['iddd']);
   if(mysql_num_rows($res)>0)
   {
   		$row = mysql_fetch_array($res);
   		echo $row[1].",".$row[2].",".$row[3].",".$row[4].",".$row[5].",".$row[6].",".$row[7].",".$row[8].",".$row[9].",".$row[11].",".$row[10];
   }
   $myobject->close_connection();
 }
?>