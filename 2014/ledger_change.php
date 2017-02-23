<?php
			include("config.php");
		
			$invoice_data = mysql_query("select * from `invoice` where `invoice_type_type_id` = 'Car' ");
			while($ftc_invoice=mysql_fetch_array($invoice_data))
    {
			$invoice_id = $ftc_invoice['invoice_id'];
			$date = $ftc_invoice['date'];
			if(!empty($invoice_id))
		{
			 
		    $ledger_data = mysql_query("select * from `ledger` where `ledger_type` = 'Car' && `bill_number`='".$invoice_id."' ");
			$num_leger = mysql_num_rows($ledger_data);
			if($num_leger>0)
			{
			}
			else
			{
		    $invoice_details = mysql_query("select * from `invoice_detail` where `invoice_invoice_id` = '".$invoice_id."' ");
			
			$num_invoice_details = mysql_num_rows($invoice_details); 
			 
			if($num_invoice_details>0)
			{ 
			while($ftc_invoice_detail = mysql_fetch_array($invoice_details))
			{
			$invoice_invoice_id = $ftc_invoice_detail['invoice_invoice_id'];
			$duty_slip_dutyslip_id = $ftc_invoice_detail['duty_slip_dutyslip_id'];
			$duty_slip_service_service_id = $ftc_invoice_detail['duty_slip_service_service_id'];
			$duty_slip_car_reg_name = $ftc_invoice_detail['duty_slip_car_reg_name'];
			
		    $dutyslip_data = mysql_query("select * from `duty_slip` where `dutyslip_id` = '".$duty_slip_dutyslip_id."' && `service_service_id`='".$duty_slip_service_service_id."' ");
			$num_dutyslip_details = mysql_num_rows($dutyslip_data); 
			$ftc_dutyslip_data = mysql_fetch_array($dutyslip_data);
			$total_km = $ftc_dutyslip_data['total_km'];
			$service_service_id = $ftc_dutyslip_data['service_service_id'];
			$carname_master_id = $ftc_dutyslip_data['carname_master_id'];
			$customer_reg_name = $ftc_dutyslip_data['customer_reg_name'];
			
		
		
		   $car_details = mysql_query("select * from `car_reg` where `carname_master_id` = '".$carname_master_id."' ");
		   $ftc_car_details = mysql_fetch_array($car_details);
           $supplier_reg_name = $ftc_car_details['supplier_reg_name'];
		   
		   
		   $supplier_data = mysql_query("select * from `supplier_reg` where `name_supplier` = '".$supplier_reg_name."' ");
		   $num_supplier_data_details = mysql_num_rows($supplier_data);
		   $ftc_supplier_datails = mysql_fetch_array($supplier_data);
           $supplier_id = $ftc_supplier_datails['supplier_id'];

		  
		
	
		   $supplier_tariff_data = mysql_query("select * from `supplier_tariff` where `supplier_reg_name`='".$supplier_id."' and carname_master_id='".$carname_master_id."' and service_service_id='".$service_service_id."' ORDER BY `supplier_tariff_id` DESC LIMIT 1 ");
			$ftc_supplier_tariff_data = mysql_fetch_array($supplier_tariff_data);
			$supplier_rate = $ftc_supplier_tariff_data['rate'];
			$minimum_chg_km = $ftc_supplier_tariff_data['minimum_chg_km'];
			$extra_km_rate = $ftc_supplier_tariff_data['extra_km_rate'];
	    	        if($total_km>$minimum_chg_km)
					{
						$amount = $supplier_rate+($total_km-$minimum_chg_km)*$extra_km_rate ;
					}
					else 
					{   
						$amount = $supplier_rate;
					}
		
	
			
			echo	$mysql_query="insert into  `ledger` set `ledger_type`='Car',`name`='".$duty_slip_car_reg_name."',`credit`='".$amount."' ,`date`='".$date."', `bill_number`='".$invoice_id."'";
			//mysql_query("insert into  `ledger` set `ledger_type`='Car',`name`='".$duty_slip_car_reg_name."',`credit`='".$amount."' , `date`='".$date."', `bill_number`='".$invoice_id."'");
			echo '<br />';
			echo '<br />';
	
			
			
			}
			}
			else
			{
				
			$dutyslip_2 = mysql_query("select * from `duty_slip` where `max_invoice_id`='".$invoice_id."' ");
			$num_dutyslip_details2 = mysql_num_rows($dutyslip_2); 
			while($ftc_dutyslip_data2 = mysql_fetch_array($dutyslip_2))
			{
			$total_km2 = $ftc_dutyslip_data2['total_km'];
			$service_service_id2 = $ftc_dutyslip_data2['service_service_id'];
			$carname_master_id2 = $ftc_dutyslip_data2['carname_master_id'];
			$customer_reg_name2 = $ftc_dutyslip_data2['customer_reg_name'];
			$car_reg_name2 = $ftc_dutyslip_data2['car_reg_name'];
			
				$result_carid= mysql_query("select * from `car_reg` where `car_id`='".$car_reg_name2."'");
				$row_carid = mysql_fetch_array($result_carid);
				$car_reg_name_new=$row_carid['name'];
				if($car_reg_name_new=="Others")
				{
				$car_reg_name_new="Others";
				}
				
			  $car_details2 = mysql_query("select * from `car_reg` where `carname_master_id` = '".$carname_master_id2."' ");
		   $ftc_car_details2 = mysql_fetch_array($car_details2);
           $supplier_reg_name2 = $ftc_car_details2['supplier_reg_name'];
		   
		   
		   $supplier_data2 = mysql_query("select * from `supplier_reg` where `name_supplier` = '".$supplier_reg_name2."' ");
		   $num_supplier_data_details2 = mysql_num_rows($supplier_data2);
		   $ftc_supplier_datails2 = mysql_fetch_array($supplier_data2);
           $supplier_id2 = $ftc_supplier_datails2['supplier_id'];

		  
		
	
		   $supplier_tariff_data2 = mysql_query("select * from `supplier_tariff` where `supplier_reg_name`='".$supplier_id2."' and carname_master_id='".$carname_master_id2."' and service_service_id='".$service_service_id2."' ORDER BY `supplier_tariff_id` DESC LIMIT 1 ");
			$ftc_supplier_tariff_data2 = mysql_fetch_array($supplier_tariff_data2);
			$supplier_rate2 = $ftc_supplier_tariff_data2['rate'];
			$minimum_chg_km2 = $ftc_supplier_tariff_data2['minimum_chg_km'];
			$extra_km_rate2 = $ftc_supplier_tariff_data2['extra_km_rate'];
	    	        if($total_km2>$minimum_chg_km2)
					{
						$amount2 = $supplier_rate2+($total_km2-$minimum_chg_km2)*$extra_km_rate2 ;
					}
					else 
					{   
						$amount2 = $supplier_rate2;
					}
		
	
			
			echo	$mysql_query="insert into  `ledger` set `ledger_type`='Car',`name`='".$car_reg_name_new."',`credit`='".$amount2."' , `date`='".$date."',`bill_number`='".$invoice_id."'";
			//	mysql_query("insert into  `ledger` set `ledger_type`='Car',`name`='".$car_reg_name_new."',`credit`='".$amount2."' , `date`='".$date."', `bill_number`='".$invoice_id."'");
			echo '<br />';
			echo '<br />';
	
			}
			}
	        }
		}
		
   }
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>