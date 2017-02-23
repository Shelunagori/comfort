<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
//echo $_GET['type'];
if(isset($_GET['customer_name']))
{
		$qry_custname="select * from `customer_reg` where `name`='".$_GET['customer_name']."'";
		$data_base_object = new DataBaseConnect();
		$result_custname = $data_base_object->execute_query_return($qry_custname);
		$row_cust=mysql_fetch_array($result_custname);
		$cust_id=$row_cust['id'];
	$mydatabase = new DataBaseConnect();
	$tot=0;
	$bill=$_GET['bill_id'];
	$ints  = explode(",", $bill);
	if($_GET['type']=='invoice')
		{
		
for($i = 0; $i < sizeof($ints); $i++)
{
	$result= $mydatabase->execute_query_return("select `duty_slip_customer_reg_name`,`grand_total`,`invoice_id` from `invoice` where `status`='no' and `duty_slip_customer_reg_name`='".$cust_id."' and `invoice_id`='".$ints[$i]."'");
	$row=mysql_fetch_array($result);
	$row['grand_total'];
		$tot+=$row['grand_total'];
	
	}
	
		
	
		}
 else if($_GET['type']=='dutyslip')
		{
		$qry_duty_cust="select * from `customer_reg` where `name`='".$_GET['customer_name']."'";
		$data_base_object_duty = new DataBaseConnect();
		$result_duty_cust = $data_base_object_duty->execute_query_return($qry_duty_cust);
		$row_duty_cust=mysql_fetch_array($result_duty_cust);
		$duty_cust_id=$row_duty_cust['id'];
	// $string_array = explode(",",$_GET['bill_id']);
for($i = 0; $i < sizeof($ints); $i++)
{
		$result= $mydatabase->execute_query_return("select `dutyslip_id`,`customer_reg_name`,`rate` from `duty_slip` where `status`='no' and `customer_reg_name`='".$duty_cust_id."' and `dutyslip_id`='".$ints[$i]."'");
	$row=mysql_fetch_array($result);
	$tot+=$row['rate'];
	}
		
		}
	?>
<tr id="txtamt"><td> Amount: </td><td><input type="text" name="amount" class="m-wrap medium"  id="amount" value="<?php echo $tot; ?>" ondblclick="getamount()" /> </td></tr>

<?php
	
	$mydatabase->close_connection();
	
}



?>