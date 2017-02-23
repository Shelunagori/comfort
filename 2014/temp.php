<?php
require_once("config.php");
$result_ledger=mysql_query("select `bill_number`,`name` from `ledger` where `bill_number`!='' && `type`='' && `ledger_type`='Customer'");
while($row_ledger=@mysql_fetch_array($result_ledger))
{
	       $st++;
		$invoice_id=$row_ledger['bill_number'];
		$cust_name=$row_ledger['name'];
		
		
		$result_invoice=mysql_query("select `grand_total`,`remarks` from `invoice` where `invoice_id`='".$invoice_id."'");
		$row_invoice=mysql_fetch_array($result_invoice);
		$debit_amnt=$row_invoice['grand_total'];
		$remarks=$row_invoice['remarks'];
	
		$ledger_ins_date=mysql_query("select `date`,`cust_supp_name` from `ledger` where `bill_number`='".$invoice_id."' && `type`='' && `ledger_type`='Customer'");	
		$row_ins_date=mysql_fetch_array($ledger_ins_date);
		$date=$row_ins_date['date'];
		$cust_supp_name_customer=$row_ins_date['cust_supp_name'];
		
		$ledger_discount=mysql_query("select `credit`,`cust_supp_name` from `ledger` where `bill_number`='".$invoice_id."' && `type`='' && `ledger_type`='Discount'");	
		$row_discount=mysql_fetch_array($ledger_discount);
		$discount_amnt=$row_discount['credit'];
		$cust_supp_name_discount=$row_discount['cust_supp_name'];
		
		$service_tax=mysql_query("select `credit` from `ledger` where  `type`='' && `bill_number`='".$invoice_id."'  && `name`='Service Tax'");	
		$row_service_tax=mysql_fetch_array($service_tax);
		$service_tax=$row_service_tax['credit'];
		
		$edu_tax=mysql_query("select `credit` from `ledger` where `type`='' && `bill_number`='".$invoice_id."'  && `name`='Education Cess'");	
		$row_edu_tax=mysql_fetch_array($edu_tax);
		$edu_tax=$row_edu_tax['credit'];
		
		
		$high_edu_tax=mysql_query("select `credit` from `ledger` where  `type`='' && `bill_number`='".$invoice_id."'  && `name`='Higher Education Ces'");	
		$row_high_edu_tax=mysql_fetch_array($high_edu_tax);
		$higher_edu_tax=$row_high_edu_tax['credit'];
		
		
		
		
		
		
		echo "delete from `ledger` where `bill_number`='".$invoice_id."' && `type`='' ";
		@mysql_query("delete from `ledger` where `bill_number`='".$invoice_id."' && `type`='' ");	
		
		echo "<br/>";
		
		
		
		
		
		
		$all_amnt=0;
		$result_invoice_detail=mysql_query("select `duty_slip_dutyslip_id`,`duty_slip_car_reg_name`  from `invoice_detail` where `invoice_invoice_id`='".$invoice_id."'");
		while($row_invoice_detail=@mysql_fetch_array($result_invoice_detail))
		{
				$duty_slip_dutyslip_id=$row_invoice_detail['duty_slip_dutyslip_id'];
				$duty_slip_car_reg_name=$row_invoice_detail['duty_slip_car_reg_name'];
				
				$result_ds=mysql_query("select * from `duty_slip` where `dutyslip_id`='".$duty_slip_dutyslip_id."'");	
				$row_ds=mysql_fetch_array($result_ds);
					
					$total_km = $row_ds['total_km'];
					$service_service_id = $row_ds['service_service_id'];
					$carname_master_id = $row_ds['carname_master_id'];
					$customer_reg_name = $row_ds['customer_reg_name'];
			
	$result_tarrif=mysql_query("select `rate` from `customer_tariff` where customer_reg_name='".$customer_reg_name."' and carname_master_id='".$carname_master_id."' and service_service_id='".$service_service_id."'");
	if(mysql_num_rows($result_tarrif)==0)   
	$result_tarrif=mysql_query("select `rate` from `tariff_rate` where service_service_id='".$service_service_id."' and carname_master_id='".$carname_master_id."'");
	$row_tariff = mysql_fetch_array($result_tarrif);
	
	
			$car_details = mysql_query("select `supplier_reg_name` from `car_reg` where `carname_master_id` = '".$carname_master_id."' ");
			$ftc_car_details = mysql_fetch_array($car_details);
			$supplier_reg_name = $ftc_car_details['supplier_reg_name'];
			
			
			$supplier_data = mysql_query("select `supplier_id` from `supplier_reg` where `name_supplier` = '".$supplier_reg_name."' ");
			$num_supplier_data_details = mysql_num_rows($supplier_data);
			$ftc_supplier_datails = mysql_fetch_array($supplier_data);
			$supplier_id = $ftc_supplier_datails['supplier_id'];
			
			
		
			
			$supplier_tariff_data = mysql_query("select * from `supplier_tariff` where ( `supplier_reg_name`='".$supplier_id."' ) && ( carname_master_id='".$carname_master_id."' and service_service_id='".$service_service_id."' ) ORDER BY `supplier_tariff_id` DESC LIMIT 1 ");
			
			$num_supplier=mysql_num_rows($supplier_tariff_data);
			
			if($num_supplier==0)
			$supplier_tariff_data = mysql_query("select * from `supplier_tariff` where ( `supplier_reg_name`='".$supplier_id."' ) || ( carname_master_id='".$carname_master_id."' and service_service_id='".$service_service_id."' ) ORDER BY `supplier_tariff_id` DESC LIMIT 1 ");
			
			
			$ftc_supplier_tariff_data = mysql_fetch_array($supplier_tariff_data);
			$supplier_rate = $ftc_supplier_tariff_data['rate'];
			$minimum_chg_km = $ftc_supplier_tariff_data['minimum_chg_km'];
			$extra_km_rate = $ftc_supplier_tariff_data['extra_km_rate'];
			if($total_km>$minimum_chg_km)
			{
			$amount = $supplier_rate+($total_km-$minimum_chg_km)*$extra_km_rate ;
			$amount = $supplier_rate;
			}
			else 
			{   
			$amount = $supplier_rate;
			}
			$all_amnt+=$amount;
			
			
			
			@mysql_query("insert into  `ledger` set `ledger_type`='Car',`name`='".$duty_slip_car_reg_name."',`credit`='".$amount."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'");
			
		echo	"insert into  `ledger` set `ledger_type`='Car',`name`='".$duty_slip_car_reg_name."',`credit`='".$amount."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'";
		
		
		
		echo '<br/>';
		}
		
		$tax=$service_tax+$edu_tax+$higher_edu_tax;
		

	@mysql_query("insert into  `ledger` set `ledger_type`='Service Tax',`name`='Service Tax',`credit`='".$service_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'");	
	echo  "insert into  `ledger` set `ledger_type`='Service Tax',`name`='Service Tax',`credit`='".$service_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'";
	echo '<br/>';
	
@mysql_query("insert into  `ledger` set `ledger_type`='Service Tax',`name`='Education Cess',`credit`='".$edu_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'");	
	echo  "insert into  `ledger` set `ledger_type`='Service Tax',`name`='Education Cess',`credit`='".$edu_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'";
	
	echo '<br/>';	

@mysql_query("insert into  `ledger` set `ledger_type`='Service Tax',`name`='Higher Education Ces',`credit`='".$higher_edu_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'");	
	echo  "insert into  `ledger` set `ledger_type`='Service Tax',`name`='Higher Education Ces',`credit`='".$higher_edu_tax."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'";
	
	echo '<br/>';	
		
				if($discount_amnt>0)
				{
				$new_grand_total=$debit_amnt+$discount_amnt;
				$car_higher_service_amnt=($new_grand_total-($all_amnt+$tax));
				
@mysql_query("insert into  `ledger` set `ledger_type`='Ledger',`name`='Discount',`credit`='".$discount_amnt."',`cust_supp_name`='".$cust_supp_name_discount."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'");				
	echo  "insert into  `ledger` set `ledger_type`='Ledger',`name`='Discount',`credit`='".$discount_amnt."',`cust_supp_name`='".$cust_supp_name_discount."' ,`date`='".$date."', `bill_number`='".$invoice_id."',`narration`='".$remarks."'";		
	echo '<br/>';
				}
				else
				{
				$car_higher_service_amnt=($debit_amnt-($all_amnt+$tax));
				}
@mysql_query("insert into `ledger` set `ledger_type`='Ledger' , `credit`='".$car_higher_service_amnt."' ,  `name`='Car Hire Services' , `bill_number`='".$invoice_id."', `narration`='".$remarks."'");				
			echo "insert into `ledger` set `ledger_type`='Ledger' , `credit`='".$car_higher_service_amnt."' ,  `name`='Car Hire Services' , `bill_number`='".$invoice_id."', `narration`='".$remarks."'"; 
			echo '<br/>';
@mysql_query("insert into `ledger` set  `ledger_type`='Customer' , `debit`='".$debit_amnt."' , `name`='".$cust_name."' , `cust_supp_name`='".$cust_supp_name_customer."', `bill_number`='".$invoice_id."' , `narration`='".$remarks."'");
	echo "insert into `ledger` set  `ledger_type`='Customer' , `debit`='".$debit_amnt."' , `name`='".$cust_name."' , `cust_supp_name`='".$cust_supp_name_customer."', `bill_number`='".$invoice_id."' , `narration`='".$remarks."'";
		echo '<br/>';	
		
	
		
	echo "--------------------------------------------------------------------------------------------------------------------------------------------------------------------";
	echo "<br/>";	
}
?>