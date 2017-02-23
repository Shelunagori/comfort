<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
$l_name=$_GET['l_name'];
$invoice_ids=$_GET['invoice_ids'];
$data_invoice_ids=explode(',', $invoice_ids);
if(isset($_GET['ledger_type']))
{
	
	if($_GET['ledger_type']!="Others")
	{
		
		   $myobject = new DataBaseConnect();
		   $res=$myobject->execute_query_return("select DISTINCT `name` from `ledger` where `ledger_type`='".$_GET['ledger_type']."'");
			if(isset($_GET['jv']))
				echo "<select name=\"name[]\" class=\"m-wrap small\">";
			else
		   		echo "<select name=\"name\" id=\"name\"  class=\"m-wrap medium\">";
		echo '<option value="0">----Select----</option>';
		   while($obj = mysql_fetch_assoc($res)) 
		   {
			   if($l_name==$obj['name'])
				echo "<option selected='selected'>".$obj['name']."</option>";
				else
				echo "<option>".$obj['name']."</option>";
		   }
		   if($_GET['ledger_type']=="Tax")
		   {
		   		echo "<option>All</option>";
		   }
			echo "</select>";
			$myobject->close_connection();
	}
	else {
			if(isset($_GET['jv']))
				echo "<input type=\"text\" name=\"name[]\" class=\"m-wrap medium\">";
		else 
				echo "<input type=\"text\" name=\"name\" value=".$obj['name']." class=\"m-wrap medium\">";
	}
}
else if(isset($_GET['bank_name']))
{

			$myobject = new DataBaseConnect();
		   $res=$myobject->execute_query_return("select `branch` from `bank_reg` where `name`='".$_GET['bank_name']."'");
			echo "<select name=\"branch\" class=\"m-wrap medium\">";
		   while($obj = mysql_fetch_assoc($res)) 
		   {
				echo "<option>".$obj['branch']."</option>";
			}
			echo "</select>";
			$myobject->close_connection();
}
else if(isset($_GET['customer_name']))
{
	$myinvoice_ids=explode(",",$invoice_ids);
	$mydatabase = new DataBaseConnect();
	if($_GET['type']=='invoice')
		{
			$qry="select * from `customer_reg` where `name`='".$_GET['customer_name']."'";
			$data_base_object = new DataBaseConnect();
			$result= $data_base_object->execute_query_return($qry);
			$row=mysql_fetch_array($result);
		    $cust_id=$row['id'];
	$result= $mydatabase->execute_query_return("select `duty_slip_customer_reg_name`,`grand_total`,`invoice_id` from `invoice` where `duty_slip_customer_reg_name`='".$cust_id."' order by `invoice_id`");
	echo "<select multiple=\"multiple\" name=\"bill_no[]\" id=\"invoice\"  class=\"m-wrap large\" >";
	while($row=mysql_fetch_array($result))
	{
		if(in_array($row['invoice_id'], $data_invoice_ids))
		{
			$selected="selected=selected";
		}
		else
		{
			$selected="";
		}
		echo "<option title=\"Name: ".$row['duty_slip_customer_reg_name']." , Total : ".$row['grand_total']."\" value=\"".$row['invoice_id']."\" ".$selected." >".$row['invoice_id']."</option>";
	}
		}
 else if($_GET['type']=='dutyslip')
		{
		   $qry_object="select * from `customer_reg` where `name`='".$_GET['customer_name']."'";
			$data_base_object_forduty = new DataBaseConnect();
			$result_forduty= $data_base_object_forduty->execute_query_return($qry_object);
			$row_duty=mysql_fetch_array($result_forduty);
		    $cust_duty_id=$row_duty['id'];	
			$mobile_no = $row_duty['mobile_no'];				
		$result= $mydatabase->execute_query_return("select `dutyslip_id`,`customer_reg_name`,`rate` from `duty_slip` where `customer_reg_name`='".$cust_duty_id."' order by `dutyslip_id`");
	echo "<select multiple=\"multiple\" name=\"bill_no[]\"  class=\"m-wrap large\"  id=\"duty\" >";
	while($row=mysql_fetch_array($result))
	{
		if(in_array($row['dutyslip_id'], $data_invoice_ids))
		{
			$selected="selected=selected";
		}
		else
		{
			$selected="";
		}
		echo "<option title=\"Name: ".$row['customer_reg_name']." , Total : ".$row['rate']."\" value=\"".$row['dutyslip_id']."\" ".$selected." >".$row['dutyslip_id']."</option>";
	}
		}
	echo "</select>";
	$mydatabase->close_connection();
}
?>
