<?php
require 'classes/databaseclasses/DataBaseConnect.php';
   
  if(isset($_GET['waveoff']))
   {
   	   $myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select * from `duty_slip` where `dutyslip_id`='".$_GET['waveoff']."'");
	  
	   $row = mysql_fetch_array($res);
	   $newquery="INSERT INTO `duty_slip_waveoff` (`dutyslip_id`, `current_date`, `guest_name`, `contactnumber`, `photo_id`, `service_service_id`, `carname_master_id`, `car_reg_name`,`new_car_no`,`customer_reg_name`, `detail_number`, `driver_reg_driver_id`, `opening_km`, `opening_time`, `closing_km`, `closing_time`, `date_from`, `date_to`, `extra_chg`, `permit_chg`, `parking_chg`, `otherstate_chg`, `guide_chg`, `misc_chg`, `remarks`, `billed_complimentary`, `authorized_person`, `date_authorization`, `reason`, `status`, `total_km`, `rate`, `amount`,`loginname`,`countername`) VALUES 
		('".$row['dutyslip_id']."', '".$row['current_date']."', '".$row['guest_name']."', '".$row['contactnumber']."','".$row['photo_id']."', '".$row['service_service_id']."', '".$row['carname_master_id']."', '".$row['car_reg_name']."', '".$row['new_car_no']."','".$row['customer_reg_name']."', '".$row['detail_number']."', '".$row['driver_reg_driver_id']."', '".$row['opening_km']."', '".$row['opening_time']."', '".$row['closing_km']."','".$row['closing_time']."','".$row['date_from']."','".$row['date_to']."','".$row['extra_chg']."','".$row['permit_chg']."',
		'".$row['parking_chg']."','".$row['otherstate_chg']."','".$row['guide_chg']."','".$row['misc_chg']."',
		'".$row['remarks']."','".$row['billed_complimentary']."','".$row['authorized_person']."',
		'".$row['date_authorization']."','".$_GET['reason']."','".$row['status']."','".$row['total_km']."','".$row['rate']."','".$row['amount']."','".$row['loginname']."','".$row['countername']."')";
	   $w1=$myobject->execute_query_update($newquery, "waveoff");
	   $w2=$myobject->execute_query_update("delete from `duty_slip` where dutyslip_id='".$_GET['waveoff']."'", "waveoff");
	   $myobject->close_connection();
	   if($w1=="success" && $w2=="success")
	   {
	   		echo "completed";
	   }
	   else {
	   		echo "problem";
	   }
   }
   else if(isset($_GET['invoicedelete']))
   {
   		session_start();
   	   $myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select * from `invoice_detail` where `invoice_invoice_id`='".$_GET['invoicedelete']."'");

	   while ($row=mysql_fetch_array($res))
	   {
		   
	   		$myobject->execute_query_update("update `duty_slip` set `status`='no' where dutyslip_id='".$row['duty_slip_dutyslip_id']."'", "waveoff");
	   		$result_temp=$myobject->execute_query_return("select `customer_reg_name` from `duty_slip` where `dutyslip_id`='".$row['duty_slip_dutyslip_id']."'","waveoff");
	   		$row_temp=mysql_fetch_assoc($result_temp);
	   		$myobject->execute_query_update("INSERT INTO `invoice_deleted` (`duty_slip_customer_reg_name`,`date`,`loginname`,`reason`,`invoice_invoice_id`,`duty_slip_dutyslip_id`,`duty_slip_service_service_id`,`duty_slip_car_reg_name`,`amount`) VALUES ('".$row_temp['customer_reg_name']."', '".date('Y-m-d')."', '".$_SESSION['username']."','".$_GET['reason']."','".$_GET['invoicedelete']."','".$row['duty_slip_dutyslip_id']."','".$row['duty_slip_service_service_id']."','".$row['duty_slip_car_reg_name']."','".$row['amount']."')", "waveoff");
	   }
	   
	   $w1=$myobject->execute_query_update("delete from `invoice` where `invoice_id`='".$_GET['invoicedelete']."'", "waveoff");
	   $w2=$myobject->execute_query_update("delete from `invoice_detail` where `invoice_invoice_id`='".$_GET['invoicedelete']."'", "waveoff");
	   $w3=$myobject->execute_query_update("delete from `ledger` where `bill_number`='".$_GET['invoicedelete']."'", "waveoff");
	   $myobject->close_connection();
	   if($w1=="success" && $w2=="success" && $w3=="success")
	   {
	   		echo "completed";
	   }
	   else {
	   		echo "problem";
	   }
   }
	else if(isset($_GET['customer_reg_name']) && isset($_GET['carname_master_id']) && isset($_GET['service_service_id']))
	{
		$myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select rate from customer_tariff where customer_reg_name='".$_GET['customer_reg_name']."' and carname_master_id='".$_GET['carname_master_id']."' and service_service_id='".$_GET['service_service_id']."'");
	   if(mysql_num_rows($res)!=0)   
	   {
	   		$row = mysql_fetch_array($res);
	   		echo $row['rate'];
	   }
	   else 
	   {
			$res=$myobject->execute_query_return("select rate from tariff_rate where service_service_id='".$_GET['service_service_id']."' and carname_master_id='".$_GET['carname_master_id']."'");
			if(mysql_num_rows($res)!=0)
			{
				$row = mysql_fetch_array($res);
	   			echo $row['rate'];
			}	
			else 
			{
				echo "0";
			}		
	   }
	   $myobject->close_connection();
	}
   else if(isset($_GET['dutyslip_id']))
   {
   		$myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select billing_name , customer_reg_name from duty_slip where dutyslip_id='".$_GET['dutyslip_id']."'");
	   if(mysql_num_rows($res)!=0)   
	   {
	   		$row = mysql_fetch_array($res);
	   		echo $row['billing_name'].",".$row['customer_reg_name'];
	   }
	   else 
	   {
			echo "nothing found";
	   }
	   $myobject->close_connection();
   }
   else if(isset($_GET['carname_master_id']))
   {
   	   $myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select `closing_km` from `duty_slip` where `car_reg_name`='".$_GET['carname_master_id']."' ORDER BY `dutyslip_id` DESC");
	   if(mysql_num_rows($res)!=0)   
	   {
	   		$row = mysql_fetch_array($res);
	   		
	   		if($row['closing_km']==0)
	   		{
	   			echo "0";
	   		}
	   		else 
			{
	   		echo $row['closing_km'];
	   		}
	   }
	   $myobject->close_connection();
   }
	 else if(isset($_GET['carname_master_id_fuel']))
   {
   	   $myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select `closing_km` from `fuel` where `car_number`='".$_GET['carname_master_id_fuel']."' ORDER BY `id` DESC");
	   if(mysql_num_rows($res)!=0)   
	   {
	   		$row = mysql_fetch_array($res);
	   		
	   		if($row['closing_km']==0)
	   		{
	   			echo "0";
	   		}
	   		else 
			{
	   		echo $row['closing_km'];
	   		}
	   }
	   $myobject->close_connection();
   }
   else if(isset($_GET['isDutySlipEditable']))
   {
//   	   $myobject = new DataBaseConnect();
//	   $res=$myobject->execute_query_return("select `status` from `duty_slip` where `dutyslip_id`='".$_GET['isDutySlipEditable']."'");
//	   if(mysql_num_rows($res)!=0)   
//	   {
//	   		$row = mysql_fetch_array($res);
//	   		if($row['status']=="yes")
//	   		{
//	   			echo "1";
//	   		}
//	   		else {
//	   			echo "0";
//	   		}
//	   }
//	   else {
//	   	echo "0";
//	   }
//	   $myobject->close_connection();
		echo $_GET['isDutySlipEditable'];
   }
   else 
   {
   	   $myobject = new DataBaseConnect();
	   $res=$myobject->execute_query_return("select rate from customer_tariff where customer_reg_name='".$_GET['customer_reg_name']."' and carname_master_id='".$_GET['carname_master_id']."'");
	   if(mysql_num_rows($res)!=0)   
	   {
	   		$row = mysql_fetch_array($res);
	   		echo $row['rate'];
	   }
	   else 
	   {
			echo "0";
	   }
	   $myobject->close_connection();	
   }
	
?>