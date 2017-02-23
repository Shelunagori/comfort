<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");

if(isset($_POST['customer_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `customer_reg` where `name`='".$name."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{	
			echo "<script language=\"javascript\">alert('Entry Already Exist.');location='customer_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `customer_reg` SET `name`='".$name."',`address`='".$address."',`Contact_person`='".$Contact_person."',`office_no`='".$office_no."',`Residence_no`='".$Residence_no."',`mobile_no`='".$mobile_no."',`email_id`='".$email_id."',`fax_no`='".$fax_no."',`opening_bal`='".$opening_bal."',`closing_bal`='".$closing_bal."',`srvctaxregno`='".$srvctaxregno."',`panno`='".$panno."',`creditlimit`='".$creditlimit."',`block_status`='".$block_status."',`servicetax_status`='".$servicetax_status."'");
	if(!empty($_POST['cop_custtariff']))
	{
		$res_lastest_cust_id=mysql_query("select `id` from `customer_reg` where `name`='".$name."'");
		$row_lastest_cust_id=mysql_fetch_array($res_lastest_cust_id);
		
		$res_tariff=mysql_query("select * from `customer_tariff` where `customer_id`='".$_POST['cop_custtariff']."'");
		while($row_tariff=mysql_fetch_array($res_tariff))
		{
			$res_tariff_sub=@mysql_query("insert into `customer_tariff` set `customer_id`='".$row_lastest_cust_id['id']."',`car_type_id`='".$row_tariff['car_type_id']."',`service_id`='".$row_tariff['service_id']."',`rate`='".$row_tariff['rate']."',`minimum_chg_km`='".$row_tariff['minimum_chg_km']."',`extra_km_rate`='".$row_tariff['extra_km_rate']."',`minimum_chg_hourly`='".$row_tariff['minimum_chg_hourly']."',`extra_hour_rate`='".$row_tariff['extra_hour_rate']."'");
		}
	}
	
	@mysql_query("insert into `ledger_master` set `ledger_type_id`='1',`name`='".$name."',`group_name`='Sundry Debtors',`group_belongs_to`='B/S-Assets'");
	
	if($opening_bal>0)
	{
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$name."' && `ledger_type_id`='1'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
$rs_ledger=mysql_query("insert into `ledger` set `ledger_master_id`='".$row_ledger_master['id']."',`name`='".$name."',`credit`='".$opening_bal."',`debit`='0',`date`='".date("Y-m-d")."',`narration`='Opening Balance For Customer $name'");

$rs_ledger2=mysql_query("insert into `ledger` set `ledger_master_id`='".cash_account_id()."',`name`='Cash Account',`credit`='0',`debit`='".$opening_bal."',`date`='".date("Y-m-d")."',`narration`='Opening Balance For Customer $name'");
	}
		
	if($rs || $rs_ledger ||$rs_ledger2){
			echo "<script  language=\"javascript\">alert('Customer Added Successfully.');location='customer_menu.php';</script>";	 
	}
	else {
				
				echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='customer_menu.php';</script>";	 
	}
	}
	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_customer']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	$res_name=mysql_query("select `name` from `customer_reg` where `id`='".$idd."'");
	$row_name=mysql_fetch_array($res_name);
	$result_ledger=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='1' && `name`='".$row_name['name']."'");
	$row_ledger=mysql_fetch_array($result_ledger);
	$rs=mysql_query("update  `customer_reg` SET `name`='".$name."',`address`='".$address."',`Contact_person`='".$Contact_person."',`office_no`='".$office_no."',`Residence_no`='".$Residence_no."',`mobile_no`='".$mobile_no."',`email_id`='".$email_id."',`fax_no`='".$fax_no."',`opening_bal`='".$opening_bal."',`closing_bal`='".$closing_bal."',`srvctaxregno`='".$srvctaxregno."',`panno`='".$panno."',`creditlimit`='".$creditlimit."',`block_status`='".$block_status."',`servicetax_status`='".$servicetax_status."' where `id`='".$idd."'");
	$rs_ledger=mysql_query("update `ledger_master` set `name`='".$name."' where `id`='".$row_ledger['id']."'");
	$rs_ledger_2=mysql_query("update `ledger` set `name`='".$name."' where `ledger_master_id`='".$row_ledger['id']."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_customer.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_customer.php?id=".$idd."'</script>";	 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['supplier_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `supplier_reg` where `name`='".$name."' && `supplier_type_id`='".$supplier_type_id."' && `supplier_type_sub_id`='".$supplier_type_sub_id."' ";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='supplier_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `supplier_reg` SET `supplier_type_id`='".$supplier_type_id."',`supplier_type_sub_id`='".$supplier_type_sub_id."',`name`='".$name."',`address`='".$address."',`contact_name`='".$contact_name."',`office_no`='".$office_no."',`residence_no`='".$residence_no."',`mobile_no`='".$mobile_no."',`email_id`='".$email_id."',`fax_no`='".$fax_no."',`opening_bal`='".$opening_bal."',`closing_bal`='".$closing_bal."',`due_days`='".$due_days."',`servicetax_no`='".$servicetax_no."',`pan_no`='".$pan_no."',`account_no`='".$account_no."',`servicetax_status`='".$servicetax_status."'");
	
	if(!empty($_POST['cop_supptariff']))
	{
		$res_lastest_supp_id=mysql_query("select `id` from `supplier_reg` where `name`='".$name."'");
		$row_lastest_supp_id=mysql_fetch_array($res_lastest_supp_id);
		
		$res_tariff=mysql_query("select * from `supplier_tariff` where `supplier_id`='".$_POST['cop_supptariff']."'");
		while($row_tariff=mysql_fetch_array($res_tariff))
		{
			$res_tariff_sub=@mysql_query("insert into `supplier_tariff` set `supplier_id`='".$row_lastest_supp_id['id']."',`car_type_id`='".$row_tariff['car_type_id']."',`service_id`='".$row_tariff['service_id']."',`rate`='".$row_tariff['rate']."',`minimum_chg_km`='".$row_tariff['minimum_chg_km']."',`extra_km_rate`='".$row_tariff['extra_km_rate']."',`minimum_chg_hourly`='".$row_tariff['minimum_chg_hourly']."',`extra_hour_rate`='".$row_tariff['extra_hour_rate']."'");
		}
	}
	
	
    @mysql_query("insert into `ledger_master` set 	`ledger_type_id`='2',`name`='".$name."',`group_name`='Sundry Creditors',`group_belongs_to`='B/S-Liabities'");
	
	if($opening_bal>0)
	{
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$name."' && `ledger_type_id`='2'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
	
	$supp_ledger=mysql_query("insert into `ledger` set `ledger_master_id`='".$row_ledger_master['id']."',`name`='".$name."',`credit`='".$opening_bal."',`debit`='0',`date`='".date("Y-m-d")."',`narration`='Opening Balance For Supplier $name'");
	$supp_ledger2=mysql_query("insert into `ledger` set `ledger_master_id`='".cash_account_id()."',`name`='Cash Account',`credit`='0',`debit`='".$opening_bal."',`date`='".date("Y-m-d")."',`narration`='Opening Balance For Supplier $name'");
	}
	
	if($rs || $res_tariff_sub || $supp_ledger) {
		echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='supplier_menu.php';</script>";		
	}
	else {
		echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='supplier_menu.php';</script>";	 	
	}
	}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_supplier']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	$res_name=mysql_query("select `name` from `supplier_reg` where `id`='".$idd."'");
	$row_name=mysql_fetch_array($res_name);
	
	$result_ledger=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='2' && `name`='".$row_name['name']."'");
	$row_ledger=mysql_fetch_array($result_ledger);
	$rs=mysql_query("update `supplier_reg` SET `supplier_type_id`='".$supplier_type_id."',`supplier_type_sub_id`='".$supplier_type_sub_id."',`name`='".$name."',`address`='".$address."',`contact_name`='".$contact_name."',`office_no`='".$office_no."',`residence_no`='".$residence_no."',`mobile_no`='".$mobile_no."',`email_id`='".$email_id."',`fax_no`='".$fax_no."',`opening_bal`='".$opening_bal."',`closing_bal`='".$closing_bal."',`due_days`='".$due_days."',`servicetax_no`='".$servicetax_no."',`pan_no`='".$pan_no."',`account_no`='".$account_no."',`servicetax_status`='".$servicetax_status."' where `id`='".$idd."'");
	$rs_ledger=mysql_query("update `ledger_master` set `name`='".$name."' where `id`='".$row_ledger['id']."'");
	$rs_ledger_2=mysql_query("update `ledger` set `name`='".$name."' where `ledger_master_id`='".$row_ledger['id']."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_supplier.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_supplier.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['driver_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `driver_reg` where `name`='".$name."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='employee_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `driver_reg` SET `name`='".$name."',`mobile_no`='".$mobile_no."',`present_add`='".$present_add."',`father_name`='".$father_name."',`qualification`='".$qualification."',`address`='".$address."',`dob`='".datefordb($dob)."',`esi_no`='".$esi_no."',`pf_no`='".$pf_no."',`designation`='".$designation."',`basicsalary`='".$basicsalary."',`dearness`='".$dearness."',`houserent`='".$houserent."',`conveyance`='".$conveyance."',`phone_amnt`='".$phone_amnt."',`medical_amnt`='".$medical_amnt."',`professiontax`='".$professiontax."',`providentfund`='".$providentfund."',`fpf`='".$fpf."',`esic`='".$esic."',`incometaxtds`='".$incometaxtds."',`bank_account_number`='".$bank_account_number."',`bank_name`='".$bank_name."',`driver_doj`='".datefordb($driver_doj)."',`blood_group`='".$blood_group."',`ref_name`='".$ref_name."',`lic_no`='".$lic_no."',`lic_issue_date`='".datefordb($lic_issue_date)."',`lic_issue_place`='".$lic_issue_place."',`lic_exp_date`='".datefordb($lic_exp_date)."',`badge_no`='".$badge_no."',`dob_leave`='".datefordb($dob_leave)."',`leave_reason`='".$leave_reason."'");
	
	
	@mysql_query("insert into `ledger_master` set 	`ledger_type_id`='3',`name`='".$name."',`group_name`='Sundry Creditors',`group_belongs_to`='B/S-Liabities'");
		
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='employee_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='employee_menu.php';</script>";		
	}
	}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_employee']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	$res_name=mysql_query("select `name` from `driver_reg` where `id`='".$idd."'");
	$row_name=mysql_fetch_array($res_name);
	
	$result_ledger=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='3' && `name`='".$row_name['name']."'");
	$row_ledger=mysql_fetch_array($result_ledger);
	$rs=mysql_query("update `driver_reg` SET `name`='".$name."',`mobile_no`='".$mobile_no."',`present_add`='".$present_add."',`father_name`='".$father_name."',`qualification`='".$qualification."',`address`='".$address."',`dob`='".datefordb($dob)."',`esi_no`='".$esi_no."',`pf_no`='".$pf_no."',`designation`='".$designation."',`basicsalary`='".$basicsalary."',`dearness`='".$dearness."',`houserent`='".$houserent."',`conveyance`='".$conveyance."',`phone_amnt`='".$phone_amnt."',`medical_amnt`='".$medical_amnt."',`professiontax`='".$professiontax."',`providentfund`='".$providentfund."',`fpf`='".$fpf."',`esic`='".$esic."',`incometaxtds`='".$incometaxtds."',`bank_account_number`='".$bank_account_number."',`bank_name`='".$bank_name."',`driver_doj`='".datefordb($driver_doj)."',`blood_group`='".$blood_group."',`ref_name`='".$ref_name."',`lic_no`='".$lic_no."',`lic_issue_date`='".datefordb($lic_issue_date)."',`lic_issue_place`='".$lic_issue_place."',`lic_exp_date`='".datefordb($lic_exp_date)."',`badge_no`='".$badge_no."',`dob_leave`='".datefordb($dob_leave)."',`leave_reason`='".$leave_reason."' where `id`='".$idd."'");
	$rs_ledger=mysql_query("update `ledger_master` set `name`='".$name."' where `id`='".$row_ledger['id']."'");
	$rs_ledger_2=mysql_query("update `ledger` set `name`='".$name."' where `ledger_master_id`='".$row_ledger['id']."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_employee.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_employee.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['car_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `car_reg` where `name`='".$name."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='car_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `car_reg` SET `car_type_id`='".$car_type_id."',`name`='".$name."',`supplier_id`='".$supplier_id."',`engine_no`='".$engine_no."',`chasis_no`='".$chasis_no."',`rto_tax_date`='".datefordb($rto_tax_date)."',`insurance_date_from`='".datefordb($insurance_date_from)."',`insurance_date_to`='".datefordb($insurance_date_to)."',`authorization_date`='".datefordb($authorization_date)."',`permit_date`='".datefordb($permit_date)."',`fitness_date`='".datefordb($fitness_date)."',`puc_date`='".datefordb($puc_date)."'");
	
	@mysql_query("insert into `ledger_master` set `ledger_type_id`='4',`name`='".$name."',`group_name`='Sundry Creditors',`group_belongs_to`='B/S-Liabities'");
	
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='car_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='car_menu.php';</script>";
	}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_car']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	
	$res_name=mysql_query("select `name` from `car_reg` where `id`='".$idd."'");
	$row_name=mysql_fetch_array($res_name);

	$result_ledger=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='4' && `name`='".$row_name['name']."'");
	$row_ledger=mysql_fetch_array($result_ledger);
	
$rs=mysql_query("UPDATE `car_reg` SET `car_type_id`='".$car_type_id."',`name`='".$name."',`supplier_id`='".$supplier_id."',`engine_no`='".$engine_no."',`chasis_no`='".$chasis_no."',`rto_tax_date`='".datefordb($rto_tax_date)."',`insurance_date_from`='".datefordb($insurance_date_from)."',`insurance_date_to`='".datefordb($insurance_date_to)."',`authorization_date`='".datefordb($authorization_date)."',`permit_date`='".datefordb($permit_date)."',`fitness_date`='".datefordb($fitness_date)."',`puc_date`='".datefordb($puc_date)."' WHERE `id`='".$idd."'");

	$rs_ledger=mysql_query("update `ledger_master` set `name`='".$name."' where `id`='".$row_ledger['id']."'");
	$rs_ledger_2=mysql_query("update `ledger` set `name`='".$name."' where `ledger_master_id`='".$row_ledger['id']."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_car.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_car.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['tariff_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `tariff_rate` where `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='tariff_rate_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `tariff_rate` SET `service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."'");
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='tariff_rate_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='tariff_rate_menu.php';</script>";
	}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_tariff']))
{
	extract($_POST);
	$idd=$_POST['myid'];
$rs=mysql_query("update `tariff_rate` SET `service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."' where `id`='".$idd."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_tariff.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_tariff.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['bank_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `bank_reg` where `name`='".$name."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Bank Already Exist.');location='bank_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into bank_reg set name='".$name."',branch='".$branch."',accno='".$accno."',code='".$code."',`ifsccode`='".$ifsccode."'");
	
	@mysql_query("insert into `ledger_master` set 	`ledger_type_id`='6',`name`='".$name."',`group_name`='Current Assets',`group_belongs_to`='B/S-Assets'");
	
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='bank_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='bank_menu.php';</script>";
	}
	}
	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['service_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `service` where `name`='".$name."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='service_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into service set `name`='".$name."',`type`='".$type."'");
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='service_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='service_menu.php';</script>";
	}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$reg_ll=@mysql_query("select `id` from `service` ");
while ($row = mysql_fetch_array($reg_ll)) 											
	{
		$j++;
		if(isset($_POST['update_service'.$j]))
		{
			$s_name=$_POST['s_name'.$j];
			$s_type=$_POST['s_type'.$j];
			$service_id=$_POST['service_id'.$j];
			if(!empty($s_name)&&!empty($s_type)&&!empty($service_id)){
			$rs=@mysql_query("update `service` set `name`='".$s_name."',`type`='".$s_type."' where `id`='".$service_id."'");}
			if($rs){
			echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='service_menu.php?mode=view';</script>";		
			}
			else{
			echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='service_menu.php?mode=view';</script>";
			}	
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['customer_tariff_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `customer_tariff` where `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' && `customer_id`='".$customer_id."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='customer_tariff_rate_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `customer_tariff` SET `customer_id`='".$customer_id."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."'");
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='customer_tariff_rate_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='customer_tariff_rate_menu.php';</script>";
	}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_customer_tariff']))
{
	extract($_POST);
	$idd=$_POST['myid'];
$rs=mysql_query("update `customer_tariff` SET `customer_id`='".$customer_id."', `service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."' where `id`='".$idd."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_customer_tariff.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_customer_tariff.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['supplier_tariff_reg']))
{
	extract($_POST);
	$sql="SELECT `id` from `supplier_tariff` where `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' && `supplier_id`='".$supplier_id."'";
	$result=mysql_query($sql);
	$num=mysql_num_rows($result);
	if($num>0)
	{
		echo "<script language=\"javascript\">alert('Entry Already Exist.');location='supplier_tariff_rate_menu.php';</script>";		
	}
	else
	{
	$rs=mysql_query("insert into `supplier_tariff` SET `supplier_id`='".$supplier_id."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."'");
	if($rs){
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='supplier_tariff_rate_menu.php';</script>";		
	}
	else{
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='supplier_tariff_rate_menu.php';</script>";
	}
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_supplier_tariff']))
{
	extract($_POST);
	$idd=$_POST['myid'];
$rs=mysql_query("update `supplier_tariff` SET `supplier_id`='".$supplier_id."', `service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."' where `id`='".$idd."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_supplier_tariff.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_supplier_tariff.php?id=".$idd."';</script>";		
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['counter']))
{
	$name=$_POST['name'];
	$find_f=mysql_query("select `id` from counter where `name`='".$name."'");
	$num_rows=mysql_num_rows($find_f);
	if($num_rows>0)
	{
		echo "<script language=\"javascript\">alert('Counter already Exist.');location='counter_setup.php';</script>";		
	
	}
	else
	{
	$rs=@mysql_query("insert into counter set name='".$name."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='counter_setup.php';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='counter_setup.php';</script>";	
	}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['tax_rate']))
{
	$count=$_POST['count'];
	for($i=1;$i<=$count;$i++)
	{
		$idd=$_POST['idd'.$i];
		$rate=$_POST['rate'.$i];
		if(!empty($idd))
		{
			$rs=mysql_query("update `taxation` set `rate`='".$rate."' where `id`='".$idd."'");
		}
	}
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='tax_rate.php';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='tax_rate.php';</script>";	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['booking_reg']))
{
	extract($_POST);
	@session_start();
 	$counter_id=$_SESSION['counter_id'];
	$login_id=$_SESSION['id'];
	$pick_up_time = $_POST['pickup_time_hh'].":".$_POST['pickup_time_mm'].":00";
	$rs=@mysql_query("insert into `booking` SET `customer_id`='".$customer_id."',`mobile_no`='".$mobile_no."',`guest_name`='".$guest_name."',`guest_mobile_no`='".$guest_mobile_no."',`travel_from`='".datefordb($travel_from)."',`travel_to`='".datefordb($travel_to)."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`no_of_car`='".$no_of_car."',`flight_no`='".$flight_no."',`pickup_time`='".$pick_up_time."',`pickup_place`='".$pickup_place."',`drop_place`='".$drop_place."',`login_id`='".$login_id."',`counter_id`='".$counter_id."',`remarks`='".$remarks."',`date`='".date("Y-m-d")."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='booking_menu.php';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='booking_menu.php';</script>";	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_booking']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	@session_start();
 	$counter_id=$_SESSION['counter_id'];
	$login_id=$_SESSION['id'];
	$pick_up_time = $_POST['pickup_time_hh'].":".$_POST['pickup_time_mm'].":00";
	$rs=@mysql_query("update `booking` SET `customer_id`='".$customer_id."',`mobile_no`='".$mobile_no."',`guest_name`='".$guest_name."',`guest_mobile_no`='".$guest_mobile_no."',`travel_from`='".datefordb($travel_from)."',`travel_to`='".datefordb($travel_to)."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`no_of_car`='".$no_of_car."',`flight_no`='".$flight_no."',`pickup_time`='".$pick_up_time."',`pickup_place`='".$pickup_place."',`drop_place`='".$drop_place."',`login_id`='".$login_id."',`counter_id`='".$counter_id."',`remarks`='".$remarks."',`date`='".date("Y-m-d")."' where `id`='".$idd."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_booking.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_booking.php?id=".$idd."';</script>";	
	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_dutyslip']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	@session_start();
 	$counter_id=$_SESSION['counter_id'];
	$login_id=$_SESSION['id'];
	$opening_time = $_POST['opening_time_hh'].":".$_POST['opening_time_mm'].":00";
	$closing_time = $_POST['closing_time_hh'].":".$_POST['closing_time_mm'].":00";
	$total_km = $closing_km-$opening_km;
	
	$main1= strtotime(datefordb($date_from));
	$main2 = strtotime(datefordb($date_to));
	$days=(($main2-$main1)/86400);
	
	$result_service=mysql_query("select `type` from `service` where `id`='".$service_id."'");
	$row_service=mysql_fetch_array($result_service);
	if($row_service['type']=='intercity')
	{
		$days++;
		$result_cust=mysql_query("select * from `customer_tariff` where `customer_id`='".$customer_id."' and `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
		$extra_km_charge=0;
		$extra_km=0;
		$extra_per_km=0;
		if(mysql_num_rows($result_cust)>0)
		{
			$row_cust=mysql_fetch_array($result_cust);
			$minimum_chg_km=$row_cust['minimum_chg_km'];
			$total_freerun = $minimum_chg_km*$days;
			$extra_km=$total_km-($total_freerun);
			$extra_km_charge=($extra_km)*$row_cust['extra_km_rate'];
			$extra_per_km=$row_cust['extra_km_rate'];
			if($extra_km>0)
			{
				$extra='Km';
				$extra_details=$extra_km;
				$extra_amnt=$extra_km_charge;
			}
		}
		else
		{
			$result_tariff=mysql_query("select * from `tariff_rate` where `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
			$row_tariff=mysql_fetch_array($result_tariff);
			$minimum_chg_km=$row_tariff['minimum_chg_km'];
			$total_freerun = $minimum_chg_km*$days;
			$extra_km=$total_km-($total_freerun);
			$extra_km_charge=($extra_km)*$row_tariff['extra_km_rate'];
			$extra_per_km=$row_tariff['extra_km_rate'];
			if($extra_km>0)
			{
				$extra='Km';
				$extra_details=$extra_km;
				$extra_amnt=$extra_km_charge;
			}
		}
	}
	else if($row_service['type']=='incity')
	{		
		if($days==0)
		$days++;
		$result_cust=mysql_query("select * from `customer_tariff` where `customer_id`='".$customer_id."' and `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
						$extra_hours=0;
						$extra_hours_charges=0;
						$extra_per_hour=0;
						if(mysql_num_rows($result_cust)>0)
						{
						            $row_cust=mysql_fetch_array($result_cust);
							        $var_first_stamp=datefordb($date_to)." ".$closing_time;
									$var_second_stamp=datefordb($date_from)." ".$opening_time;
									$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
									$extra_hours=$total_time_of_car-(($row_cust['minimum_chg_hourly'])*$days);
									$extra_hours_charges=$extra_hours*$row_cust['extra_hour_rate'];
									$extra_per_hour=$row_cust['extra_hour_rate'];
									if($extra_hours>0)
									{
											$extra='Hours';
											$extra_details=$extra_hours;
											$extra_amnt=$extra_hours_charges;
									}
						}
						else
						{
								$result_tariff=("select * from `tariff_rate` where `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
								$row_tariff=mysql_fetch_array($result_tariff);
								$var_first_stamp=datefordb($date_to)." ".$closing_time;
								$var_second_stamp=datefordb($date_from)." ".$opening_time;
								$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
								$row_time_diff =mysql_fetch_array($result_time_diff);
								$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
								$row_min_diff =mysql_fetch_array($result_min);
								$total_time_of_car= round($row_min_diff[0]);
								
								$extra_hours=$total_time_of_car-(($row_tariff['minimum_chg_hourly'])*$days);
								$extra_hours_charges=$extra_hours*$row_tariff['extra_hour_rate'];
								$extra_per_hour=$row_tariff['extra_hour_rate'];
								if($extra_hours>0)
								{
											$extra='Hours';
											$extra_details=$extra_hours;
											$extra_amnt=$extra_hours_charges;
								}
						}
	}
	
	$tot_amnt=($rate*$days)+$extra_chg+$permit_chg+$parking_chg+$otherstate_chg+$guide_chg+$misc_chg;
	///////
	 $date_update=datefordb($date);
	
	/////////
	$rs=mysql_query("update `duty_slip` SET `date`='".$date_update."',`guest_name`='".$guest_name."',`mobile_no`='".$mobile_no."',`email_id` = '".$email_id."' ,`photo_id`='".$photo_id."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`car_id`='".$car_id."',`temp_car_no`='".$temp_car_no."',`customer_id`='".$customer_id."',`detail_no`='".$detail_no."',`driver_id`='".$driver_id."',`temp_driver_name`='".$temp_driver_name."',`opening_km`='".$opening_km."',`closing_km`='".$closing_km."',`opening_time`='".$opening_time."',`closing_time`='".$closing_time."',`date_from`='".datefordb($date_from)."',`date_to`='".datefordb($date_to)."',`extra_chg`='".$extra_chg."',`permit_chg`='".$permit_chg."',`parking_chg`='".$parking_chg."',`otherstate_chg`='".$otherstate_chg."',`guide_chg`='".$guide_chg."',`misc_chg`='".$misc_chg."',`total_km`='".$total_km."',`rate`='".$rate."',`extra`='".$extra."',`extra_details`='".$extra_details."',`extra_amnt`='".$extra_amnt."',`tot_amnt`='".$tot_amnt."',`remarks`='".$remarks."',`reason`='".$reason."',`login_id`='".$login_id."',`counter_id`='".$counter_id."',`billing_status`='no' where `id`='".$idd."'");
	if($rs)
	echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_dutyslip.php?id=".$idd."';</script>";		
	else
	echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_dutyslip.php?id=".$idd."';</script>";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_billing']))
{
$guest_name=$_POST['guest_name'];
$count=$_POST['count'];
$total=$_POST['total'];

$tax=0;
$h=0;
$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
while($row_taxrate=mysql_fetch_array($result_taxrate))
{$h++;
	$tax+=$_POST['taxation'.$h];
}
$discount=$_POST['discount'];
$grand_total=$_POST['grand_total'];
$invoice_id=$_POST['invoice_id'];
$customer_id=$_POST['customer_id'];
$date=datefordb($_POST['date']);
$current_date=datefordb($_POST['current_date']);
$remarks=$_POST['remarks'];
$invoice_update=mysql_query("update `invoice` set `date`='".$date."',`customer_id`='".$customer_id."',`total`='".$total."',`discount`='".$discount."',`tax`='".$tax."',`grand_total`='".$grand_total."',`remarks`='".$remarks."',`current_date`='".$current_date."' where `id`='".$invoice_id."'");
@mysql_query("delete from ledger where `invoice_id`='".$invoice_id."' && `transaction_type`=''");
		for($k=1;$k<=$count;$k++)
		{
		  $main_amnt=$_POST['main_amnt'.$k];
		  $extra_amnt=$_POST['extra_amnt'.$k];	
		  $extra_chg=$_POST['extra_chg'.$k];
		  $permit_chg=$_POST['permit_chg'.$k];
		  $parking_chg=$_POST['parking_chg'.$k];
		  $otherstate_chg=$_POST['otherstate_chg'.$k];
		  $guide_chg=$_POST['guide_chg'.$k];
		  $misc_chg=$_POST['misc_chg'.$k];
		  $duty_slip_id=$_POST['duty_slip_id'.$k];
		  $invoice_detail_id=$_POST['invoice_detail_id'.$k];
		  
		  $tot_amnt=$main_amnt+$extra_chg+$permit_chg+$parking_chg+$otherstate_chg+$guide_chg+$misc_chg;
		  
		  $amount=$main_amnt+$extra_chg+$permit_chg+$parking_chg+$otherstate_chg+$guide_chg+$misc_chg+$extra_amnt;
	
$duty_slip_update=mysql_query("update `duty_slip` set `guest_name`='".$guest_name."',`extra_amnt`='".$extra_amnt."',`extra_chg`='".$extra_chg."',`permit_chg`='".$permit_chg."',`parking_chg`='".$parking_chg."',`otherstate_chg`='".$otherstate_chg."',`guide_chg`='".$guide_chg."',`misc_chg`='".$misc_chg."',`tot_amnt`='".$tot_amnt."' where `id`='".$duty_slip_id."'");
 	
$invoice_detail_update=mysql_query("update `invoice_detail` set `amount`='".$amount."' where `id`='".$invoice_detail_id."'");	
		
	
	
		$ledger_date=@mysql_query("select `date` from `ledger` where `invoice_id`='".$invoice_id."' && `transaction_type`=''");
		$row_ledger_date=@mysql_fetch_array($ledger_date);
		$ledger_date=$row_ledger_date['date'];

		$rs_dss=mysql_query("select `date_from`,`date_to`,`opening_time`,`closing_time`,`service_id`,`car_id`,`car_type_id`,`total_km` from `duty_slip` where `id`='".$duty_slip_id."'");
		$row_ds=mysql_fetch_array($rs_dss);
		
		$date_from=$row_ds['date_from'];
		$date_to=$row_ds['date_to'];
		$service_id=$row_ds['service_id'];
		$car_id=$row_ds['car_id'];
		$car_type_id=$row_ds['car_type_id'];
		$total_km=$row_ds['total_km'];
		
		$main1= strtotime($date_from);
		$main2 = strtotime($date_to);
		$days=(($main2-$main1)/86400);
		$closing_time=$row_ds['opening_time'];
		$opening_time=$row_ds['closing_time'];
		
		
	/*	$result_car=mysql_query("select `temp_car_no` from `duty_slip` where `car_id`='".$car_id."'");
		$row_car=mysql_fetch_array($result_car);
		$temp_car_no=$row_car['temp_car_no'];
		if(!empty($temp_car_no))
		$car_number=$temp_car_no;
		else
		$car_number=fetchcarno($car_id);
	*/	

		$car_number=fetchcarno($car_id);
		$result_tarrif=mysql_query("select `rate` from `customer_tariff` where customer_id='".$customer_id."' and car_type_id='".$car_type_id."' and service_id='".$service_id."'");
		if(mysql_num_rows($result_tarrif)==0)   
		$result_tarrif=mysql_query("select `rate` from `tariff_rate` where service_id='".$service_id."' and car_type_id='".$car_type_id."'");
		$row_tariff = mysql_fetch_array($result_tarrif);
		
		 $res_supplier_id=mysql_query("select `supplier_id`,`car_type_id` from `car_reg` where `id`='".$car_id."'");
			 $row_supplier_id=mysql_fetch_array($res_supplier_id);
			 $supplier_id=$row_supplier_id['supplier_id'];
			 $car_type_id=$row_supplier_id['car_type_id'];
			 $result_supplier_tariff=mysql_query("select * from `supplier_tariff` where  `supplier_id`='".$supplier_id."'  &&  `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' ");
			
			 
			 $num_supplier_tariff=mysql_num_rows($result_supplier_tariff);
			 if($num_supplier_tariff==0)
			  $result_supplier_tariff=mysql_query("select * from `supplier_tariff` where  `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' ");
			 $row_supplier_tariff=mysql_fetch_array($result_supplier_tariff);
			 $supplier_rate = $row_supplier_tariff['rate'];
			 $minimum_chg_km = $row_supplier_tariff['minimum_chg_km'];
			 $extra_km_rate = $row_supplier_tariff['extra_km_rate'];
			 $extra_hour_rate = $row_supplier_tariff['extra_hour_rate'];
			 $minimum_chg_hourly = $row_supplier_tariff['minimum_chg_hourly'];
			 
		///////////////////////////////////////////-----------calculate supplier amount------------------///////////////////////////////////////
		$result_service=mysql_query("select `type` from `service` where `id`='".$service_id."'");
		$row_service=mysql_fetch_array($result_service);
		if($row_service['type']=="intercity")
		{	
			$days+=1;
			$total_freerun = $minimum_chg_km*$days;
			$extra_km=$total_km-($total_freerun);
			if($extra_km>0)
			$extra_charge=$extra_km*$extra_km_rate;
			$supp_main_amnt=$supplier_rate*$days;
		}
		else
		{
			if($days==0)
			$days++;
			$var_first_stamp=($date_to)." ".$closing_time;
			$var_second_stamp=($date_from)." ".$opening_time;
			$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
			$row_time_diff =mysql_fetch_array($result_time_diff);
			$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
			$row_min_diff =mysql_fetch_array($result_min);
			$total_time_of_car= round($row_min_diff[0]);
			$total_freerun = $minimum_chg_hourly*$days;
			$extra_hours=$total_time_of_car-($total_freerun);
			if($extra_hours>0)
			$extra_charge=$extra_hours*$extra_hour_rate;
			$supp_main_amnt=$supplier_rate*$days;
		}

		$amount_supplier = $supp_main_amnt+$extra_charge;
		$amount_to_cars+=$amount_supplier;	

		 $ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".fetchcarno($car_id)."' && `ledger_type_id`='4'");
		 $row_ledger_master=mysql_fetch_array($ledger_master);
	

		@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='".fetchcarno($car_id)."',`credit`='".$amount_supplier."',`debit`='0',`narration`='".$remarks."',`current_date`='".$current_date."'");	
		
		}
		if($discount>0)
		{
			$new_grand_total=$grand_total+$discount;
			$car_higher_service_amnt=($new_grand_total-($amount_to_cars+$tax));
			
			$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
			$row_ledger_master=mysql_fetch_array($ledger_master);
			
			@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='Discount',`credit`='0',`debit`='".$discount."',`narration`='".$remarks."',`current_date`='".$current_date."'");	
			
		}
		else
		{
			$car_higher_service_amnt=($grand_total-($amount_to_cars+$tax));
		}
		
		$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".fetchcustomername($customer_id)."' && `ledger_type_id`='1'");
		$row_ledger_master=mysql_fetch_array($ledger_master);
				
		@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='".fetchcustomername($customer_id)."',`credit`='0',`debit`='".$grand_total."',`narration`='".$remarks."',`current_date`='".$current_date."'");			
			
		if($tax>0)
		{
			$h=0;
			$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
			while($row_taxrate=mysql_fetch_array($result_taxrate))
			{$h++;
				if($_POST['taxation'.$h])
				{
					
						$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
						$row_ledger_master=mysql_fetch_array($ledger_master);
							
						@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='".$row_taxrate['name']."',`credit`='".$_POST['taxation'.$h]."',`debit`='0',`narration`='".$remarks."',`current_date`='".$current_date."'");	
					
				}
			}
		}
		
	
			$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Car Hire Services' && `ledger_type_id`='5'");
			$row_ledger_master=mysql_fetch_array($ledger_master);
	
			@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='Car Higher Services',`credit`='".$car_higher_service_amnt."',`debit`='0',`narration`='".$remarks."',`current_date`='".$current_date."'");				
		//	$total_credit=$tax+$car_higher_service_amnt+$amount_to_cars;
		//	$total_debit=$discount+$grand_total;
		
if($invoice_update&&$duty_slip_update&&$invoice_detail_update)
echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='update_billing.php?invoice=true&id=".$invoice_id."';</script>";		
else
echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='update_billing.php?invoice=true&id=".$invoice_id."';</script>";			
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['login_wise']))
{
	$login_id=$_POST['mylogin'];
	mysql_query("delete from `user_right` where  `login_id`='".$login_id."'");
	$chk=$_POST['check_menu'];
	if (is_array($chk))
	{
		foreach ($chk as $value)
		{
			$check_sub=$_POST['check_sub'.$value];			
			if(!empty($check_sub))
			{
				foreach ($check_sub as $value_sub)
				{
				$check_subsub=$_POST['check_subsub'.$value.$value_sub];
				
					if(!empty($check_subsub))	
					{
							foreach ($check_subsub as $value_subsub)
							{
							  @mysql_query("insert into `user_right` set `login_id`='".$login_id."',`role_id`='0',`submodule_id`='".$value_sub."' ,`module_id`='".$value."',`sub_submodule_id`='".$value_subsub."'");
							}
					}
					else
					{
						 @mysql_query("insert into `user_right` set `login_id`='".$login_id."',`role_id`='0',`submodule_id`='".$value_sub."' ,`module_id`='".$value."'");
					}
				}
			}
			else
			{
				 @mysql_query("insert into `user_right` set `login_id`='".$login_id."',`role_id`='0',`submodule_id`='0' ,`module_id`='".$value."'");
			}
	     }
	}
	echo "<script>alert('Entry added to database.'); location = 'user_right.php?mode=user';</script>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['role_wise']))
{
	$role = $_POST['role'];
	mysql_query("delete from `user_right` where `role_id`='".$role."'");
	$chk=$_POST['check_menu'];
	if (is_array($chk))
	{
		foreach ($chk as $value)
		{
			$check_sub=$_POST['check_sub'.$value];			
			if(!empty($check_sub))
			{
				foreach ($check_sub as $value_sub)
				{
				$check_subsub=$_POST['check_subsub'.$value.$value_sub];
				
					if(!empty($check_subsub))	
					{
							foreach ($check_subsub as $value_subsub)
							{
							  @mysql_query("insert into `user_right` set `login_id`='0',`role_id`='".$role."',`submodule_id`='".$value_sub."' ,`module_id`='".$value."',`sub_submodule_id`='".$value_subsub."'");
							}
					}
					else
					{
						 @mysql_query("insert into `user_right` set `login_id`='0',`role_id`='".$role."',`submodule_id`='".$value_sub."' ,`module_id`='".$value."'");
					}
				}
			}
			else
			{
				 @mysql_query("insert into `user_right` set `login_id`='0',`role_id`='".$role."',`submodule_id`='0' ,`module_id`='".$value."'");
			}
	     }
	}
	echo "<script>alert('Entry added to database.'); location = 'user_right.php?mode=role';</script>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['create_login']))
{
$check_first=mysql_query("select `id` from `login` where `login_id`='".$_POST['login_id']."'");	
$num_rows=mysql_num_rows($check_first);
if($num_rows>0)
{
echo "<script>alert('Sorry Login ID already exist please create new.'); location = 'user_right.php';</script>";	
}
else
{
$result=@mysql_query("insert into `login` set `login_id`='".$_POST['login_id']."',`password`='".md5($_POST['pass'])."',`username`='".$_POST['user']."',`counter_id`='".$_POST['counter_id']."',`ldrview`='".$_POST['ldrview']."',`email`='".$_POST['email']."'");
    if($result) 
	echo "<script>alert('Entry added to database.'); location = 'user_right.php';</script>";
	else
    echo "<script>alert('You have enter nothing please try again.'); location = 'user_right.php';</script>";
}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['ledger_reg']))
{
$check_first=mysql_query("select `id` from `ledger_master` where `name`='".$_POST['name']."'");	
$num_rows=mysql_num_rows($check_first);
if($num_rows>0)
{
echo "<script>alert('Sorry Ledger Name already exist please create new.'); location = 'ledger_menu.php';</script>";	
}
else
{
if(!empty($_POST['group_name_other']))	
{
$result=@mysql_query("insert into `ledger_master` set `ledger_type_id`='5',`name`='".$_POST['name']."',`group_name`='".$_POST['group_name_other']."',`group_belongs_to`='".$_POST['group_belongs_to']."'");
}
else
{
$result=@mysql_query("insert into `ledger_master` set `ledger_type_id`='5',`name`='".$_POST['name']."',`group_name`='".$_POST['group_name']."',`group_belongs_to`='".$_POST['group_belongs_to']."'");
}
if(!empty($_POST['opening_bal']))
{
	
	$rs_ledger=mysql_query("insert into `ledger` set `ledger_master_id`='".$row_fetch['id']."',`name`='".$_POST['name']."',`credit`='".$_POST['opening_bal']."',`debit`='0',`date`='".date("Y-m-d")."',`narration`='Difference in opening balance in ".$_POST['name']."'");

	
$rs_ledger2=mysql_query("insert into `ledger` set `ledger_master_id`='".cash_account_id()."',`name`='Cash Account',`credit`='0',`debit`='".$_POST['opening_bal']."',`date`='".date("Y-m-d")."',`narration`='Difference in opening balance in ".$_POST['name']."'");

}
if($result) 
echo "<script>alert('Entry added to database.'); location = 'ledger_menu.php';</script>";
else
echo "<script>alert('You have enter nothing please try again.'); location = 'ledger_menu.php';</script>";
}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$reg_ll=@mysql_query("select `id` from `ledger_master` ");
while ($row = mysql_fetch_array($reg_ll)) 											
	{
		$flag++;
		if(isset($_POST['update_ledger'.$flag]))
		{
			$gr_name=$_POST['gr_name'.$flag];
			$gr_belongs_to=$_POST['gr_belongs_to'.$flag];
			$ledger_id=$_POST['ledger_id'.$flag];
			$opening_bal=$_POST['opening_bal'.$flag];
			if(!empty($gr_name)&&!empty($gr_belongs_to)&&!empty($ledger_id)){
			$rs=@mysql_query("update `ledger_master` set `group_name`='".$gr_name."',`group_belongs_to`='".$gr_belongs_to."' where `id`='".$ledger_id."'");}
			if($rs){
			echo "<script language=\"javascript\">alert('Entry Updated Successfully.');location='ledger_menu.php';</script>";		
			}
			else{
			echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');location='ledger_menu.php';</script>";
			}	
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['fuel_reg']))
{
	extract($_POST);
	$fuel_qty=@$fuel_amount/$price;
	$f_qty=@round($fuel_qty,2);
	$name=fetchsuppliername($supplier_id);
	
 $result_fuel=@mysql_query("insert into `fuel` set `supplier_id`='".$supplier_id."',`name`='".$name."',`date`='".datefordb($date)."',`car_id`='".$car_id."',`opening_km`='".$opening_km."',`closing_km`='".$closing_km."',`fuel_qty`='".$f_qty."',`fuel_rate`='".$price."',`fuel_amount`='".$fuel_amount."',`fuel_type`='".$fuel_type."',`remarks`='".$remarks."'");
	
	$res_fule_id=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='2' && `name`='".$name."'");
	$row_fule=mysql_fetch_array($res_fule_id);
	

	$query1=@mysql_query("insert into `ledger` set `ledger_master_id`='".$row_fule['id']."',`name`='".fetchsuppliername($supplier_id)."',`credit`='".$_POST['fuel_amount']."',`debit`='0',`date`='".datefordb($date)."',`narration`='".$_POST['remarks']."'");
	
	$car_name=fetchcarno($car_id);
	
	$car_ledger=mysql_query("select `id` from `ledger_master` where `name`='".$car_name."' && `ledger_type_id`='4'");
 	$row_car_ledger=mysql_fetch_array($car_ledger);
	
   $query2=@mysql_query("insert into `ledger` set `ledger_master_id`='".$row_car_ledger['id']."',`name`='".fetchcarno($_POST['car_id'])."',`credit`='0',`debit`='".$_POST['fuel_amount']."',`date`='".datefordb($date)."',`narration`='".$_POST['remarks']."'"); 
   
if($result_fuel && $query1 && $query2) 
echo "<script>alert('Entry added to database.'); location = 'fuel_menu.php';</script>";
else
echo "<script>alert('You have enter nothing please try again.'); location = 'fuel_menu.php';</script>";
   
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_fuel']))
{
	extract($_POST);
	$idd=$_POST['myid'];
	$fuel_qty=@$fuel_amount/$price;
	$f_qty=@round($fuel_qty,2);

 $update_fuel=@mysql_query("update `fuel` set `opening_km`='".$opening_km."',`closing_km`='".$closing_km."',`fuel_qty`='".$f_qty."',`fuel_rate`='".$price."',`fuel_amount`='".$fuel_amount."',`fuel_type`='".$fuel_type."',`remarks`='".$remarks."' where `id`='".$idd."'");
 
if($update_fuel) 
echo "<script>alert('Entry Updated to database.');location='update_fuel.php?id=".$idd."';</script>";
else
echo "<script>alert('You have enter nothing please try again.');location='update_fuel.php?id=".$idd."';</script>";

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['payment_submit']))
{
	$payment_type=$_POST['payment_type'];
	
	$result_whom=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$_POST['ledger_type_id']."' && `name`='".$_POST['ledger_name']."'");
	$res_whom=mysql_fetch_array($result_whom);
	
	if($payment_type=='cash')
	{
		
$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$_POST['ledger_name']."',`ledger_master_id`='".$res_whom['id']."',`credit`='0',`debit`='".$_POST['amount']."',`transaction_type`='payment',`transaction_id`='".$_POST['payment_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
							
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Cash Account',`ledger_master_id`='".cash_account_id()."',`credit`='".$_POST['amount']."',`debit`='0',`transaction_type`='payment',`transaction_id`='".$_POST['payment_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
	}
	else
	{
		$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$_POST['ledger_name']."',`ledger_master_id`='".$res_whom['id']."',`credit`='0',`debit`='".$_POST['amount']."',`transaction_type`='payment',`transaction_id`='".$_POST['payment_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
			
		$bank_res=mysql_query("select `name` from `bank_reg` where `id`='".$_POST['bank_id']."'");
		$row_bank=mysql_fetch_array($bank_res);
		
		$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_bank['name']."' && `ledger_type_id`='6'");
		$row_ledger_master=mysql_fetch_array($ledger_master);
		
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$row_bank['name']."',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='".$_POST['amount']."',`debit`='0',`transaction_type`='payment',`transaction_id`='".$_POST['payment_id']."',`narration`='".$_POST['narration']."',`bank_id`='".$_POST['bank_id']."',`branch_id`='".$_POST['branch_id']."',`cheque_no`='".$_POST['cheque_no']."',`cheque_date`='".datefordb($_POST['cheque_date'])."',`drawn_branch`='".$_POST['drawn_branch']."',`current_date`='".date("Y-m-d")."'");
		
	}
	if($rs && $rs1) 
	echo "<script>alert('Entry Updated to database.');location='payment_menu.php';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='payment_menu.php';</script>";	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['receipt_submit']))
{
	$receipt_type=$_POST['receipt_type'];
	$ledger_name=$_POST['ledger_name'];
	$ledger_type_id=$_POST['ledger_type_id'];
	
	$result_whom=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$_POST['ledger_type_id']."' && `name`='".$ledger_name."'");
	$res_whom=mysql_fetch_array($result_whom);
	@$invoice_list=implode(",",$_POST['invoice_list']);
	
	if(is_array($_POST['invoice_list']))
	{
		foreach($_POST['invoice_list'] as $value)
		{
			if(!empty($value))	
			{   
		   		
				$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$value."' && `due_amnt`>'0'");
				if(mysql_num_rows($check_receipt_detail)>0)
				{
					$row_receipt_detail=@mysql_fetch_array($check_receipt_detail);
					 $grand_total=$row_receipt_detail['due_amnt'];
				}
				else
				{
					$result=mysql_query("select `grand_total` from `invoice` where `id`='".$value."'");
					$row=mysql_fetch_array($result);
					$grand_total=$row['grand_total'];	
				}
				///////////////
				
				
					if(!empty($_POST['discount'])&&!empty($_POST['tds_amnt']))
					{ 
					 $main_amnt=($_POST['amount']-($_POST['discount']+$_POST['tds_amnt']));
					 $main_amnt1=($_POST['amount']+($_POST['discount']+$_POST['tds_amnt']));
					}
					else if(!empty($_POST['discount']))
					{ 
						$main_amnt=$_POST['amount']-$_POST['discount'];
						$main_amnt1=$_POST['amount']+$_POST['discount'];
					}
					else if(!empty($_POST['tds_amnt']))
					{
						$main_amnt=$_POST['amount']-$_POST['tds_amnt'];	
						$main_amnt1=$_POST['amount']+$_POST['tds_amnt'];	
					}
					else
					{
					 $main_amnt=$_POST['amount'];
					 $main_amnt1=$_POST['amount'];
					}
					  $ins_amnt=$main_amnt;
					  $total_amount_wth_discount=$main_amnt1;
				///////////////
					
				
				
				    $remain_amnt=$main_amnt1-$grand_total; 
				  
				   
				if($total_amount_wth_discount == $grand_total || $total_amount_wth_discount > $grand_total)
				{
					//echo ">>>>>>>>>>";exit;
					$rs_update=@mysql_query("update `invoice` set `payment_status`='yes' where `id`='".$value."'");
					if($rs_update)
					@mysql_query("update `receipt_detail` set `due_amnt`='0' where `invoice_id`='".$value."'");
				}
				else
				{ //echo "<<<<<<<<<<<<<";exit;
					$receipt_fetch=mysql_query("select `id` from `receipt_detail` where `invoice_id`='".$value."'");
					if(mysql_num_rows($receipt_fetch)>0)
					{
						@mysql_query("update `receipt_detail` set `due_amnt`='".abs($remain_amnt)."' where `invoice_id`='".$value."'");
						break;
					}
					else
					{
						@mysql_query("insert into `receipt_detail` set `invoice_id`='".$value."',`due_amnt`='".abs($remain_amnt)."' ");
						break;
					}
				}
	
				
			}
		}
	}
	else
	{
		if(!empty($_POST['discount'])&&!empty($_POST['tds_amnt']))
		{ 
		 $main_amnt=($_POST['amount']-($_POST['discount']+$_POST['tds_amnt']));
		 $main_amnt1=($_POST['amount']+($_POST['discount']+$_POST['tds_amnt']));
		}
		else if(!empty($_POST['discount']))
		{ 
			$main_amnt=$_POST['amount']-$_POST['discount'];
			$main_amnt1=$_POST['amount']+$_POST['discount'];
		}
		else if(!empty($_POST['tds_amnt']))
		{
			$main_amnt=$_POST['amount']-$_POST['tds_amnt'];	
			$main_amnt1=$_POST['amount']+$_POST['tds_amnt'];	
		}
		else
		{
		 $main_amnt=$_POST['amount'];
		 $main_amnt1=$_POST['amount'];
		}
		$ins_amnt=$main_amnt;
		$total_amount_wth_discount=$main_amnt1;
	}
	if($receipt_type=="cash")
	{		
	$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$ledger_name."',`ledger_master_id`='".$res_whom['id']."',`credit`='".$_POST['amount']."',`debit`='0',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
			
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Cash Account',`ledger_master_id`='".cash_account_id()."',`credit`='0',`debit`='".$main_amnt."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
		if(!empty($_POST['discount']))
		{
			$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
			$row_ledger_master=mysql_fetch_array($ledger_master);
			
			$rs2=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Discount',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$_POST['discount']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		}
		
		if(!empty($_POST['tds_amnt']))
		{
			$ledger_master_tds=mysql_query("select `id` from `ledger_master` where `name`='Tds Deducted' && `ledger_type_id`='5'");
			$row_ledger_master_tds=mysql_fetch_array($ledger_master_tds);
			
	$rs3=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Tds Deducted',`ledger_master_id`='".$row_ledger_master_tds['id']."',`credit`='0',`debit`='".$_POST['tds_amnt']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");				
		}
	}
	else
	{
		$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$ledger_name."',`ledger_master_id`='".$res_whom['id']."',`credit`='".$_POST['amount']."',`debit`='0',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
	  
	$bank_res=mysql_query("select `name` from `bank_reg` where `id`='".$_POST['bank_id']."'");
	$row_bank=mysql_fetch_array($bank_res);
	
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_bank['name']."' && `ledger_type_id`='6'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
			
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$row_bank['name']."',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$main_amnt."',`invoice_id`='".$invoice_list."',`bank_id`='".$_POST['bank_id']."',`branch_id`='".$_POST['branch_id']."',`cheque_no`='".$_POST['cheque_no']."',`cheque_date`='".datefordb($_POST['cheque_date'])."',`drawn_branch`='".$_POST['drawn_branch']."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
	
		if(!empty($_POST['discount']))
		{
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
	$row_ledger_master=mysql_fetch_array($ledger_master);

	$rs2=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Discount',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$_POST['discount']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		}		
		
		if(!empty($_POST['tds_amnt']))
		{
			$ledger_master_tds=mysql_query("select `id` from `ledger_master` where `name`='Tds Deducted' && `ledger_type_id`='5'");
			$row_ledger_master_tds=mysql_fetch_array($ledger_master_tds);
			
	$rs3=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Tds Deducted',`ledger_master_id`='".$row_ledger_master_tds['id']."',`credit`='0',`debit`='".$_POST['tds_amnt']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");				
		}
	}
	
	if($rs || $rs1 || $rs_update || $rs3) 
	echo "<script>alert('Entry Updated to database.');location='receipt_menu.php';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='receipt_menu.php';</script>";	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_receipt']))
{
	$receipt_id=$_POST['receipt_id'];
	
	$result_ledger=mysql_query("select `invoice_id`,`date` from ledger where transaction_id='".$receipt_id."' && transaction_type='receipt'");
	$row_ledger=@mysql_fetch_array($result_ledger);
	$invoice_id=$row_ledger['invoice_id'];
	$date=$row_ledger['date'];
	//$invoice_list=$_POST['invoice_list'];
	$exp_invoice_id=@explode(',',$invoice_id);
	@$invoice_list=implode(",",$_POST['invoice_list']);
	foreach($exp_invoice_id as $value)
	{
		@mysql_query("update `invoice` set `payment_status`='no' where `id`='".$value."'");
	}
	
	@mysql_query("delete from `ledger` where transaction_id='".$receipt_id."' && transaction_type='receipt' ");
	
	$receipt_type=$_POST['receipt_type'];
	$ledger_name=$_POST['ledger_name'];
	$ledger_type_id=$_POST['ledger_type_id'];
	
	$result_whom=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$_POST['ledger_type_id']."' && `name`='".$ledger_name."'");
	$res_whom=mysql_fetch_array($result_whom);
	
	$amount=$_POST['amount'];
	if(!empty($_POST['discount'])&&!empty($_POST['tds_amnt']))
	{
	$main_amnt=($_POST['amount']-($_POST['discount']+$_POST['tds_amnt']));
	}
	else if(!empty($_POST['discount']))
	{
	$main_amnt=$_POST['amount']-$_POST['discount'];
	}
	else if(!empty($_POST['tds_amnt']))
	{
	$main_amnt=$_POST['amount']-$_POST['tds_amnt'];	
	}
	else
	{
	$main_amnt=$_POST['amount'];
	}

	$ins_amnt=$main_amnt;
	if(is_array($_POST['invoice_list']))
	{
		foreach($_POST['invoice_list'] as $value)
		{
			if(!empty($value))	
			{   
		   
				$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$value."' && `due_amnt`>'0'");
				if(mysql_num_rows($check_receipt_detail)>0)
				{
				$row_receipt_detail=@mysql_fetch_array($check_receipt_detail);
				$grand_total=$row_receipt_detail['due_amnt'];
				}
				else
				{
				$result=mysql_query("select `grand_total` from `invoice` where `id`='".$value."'");
				$row=mysql_fetch_array($result);	
				$grand_total=$row['grand_total'];	
				}
				
				$remain_amnt=$amount-$grand_total;
				
				if($remain_amnt>=0)
				{
					$ins_amnt=$remain_amnt;
					$rs_update=@mysql_query("update `invoice` set `payment_status`='yes' where `id`='".$value."'");
					if($rs_update)
					@mysql_query("update `receipt_detail` set `due_amnt`='0' where `invoice_id`='".$value."'");
				}
				else
				{
					$receipt_fetch=mysql_query("select `id` from `receipt_detail` where `invoice_id`='".$value."'");
					if(mysql_num_rows($receipt_fetch)>0)
					{
						@mysql_query("update `receipt_detail` set `due_amnt`='".abs($remain_amnt)."' where `invoice_id`='".$value."'");
						break;
					}
					else
					{
						@mysql_query("insert into `receipt_detail` set `invoice_id`='".$value."',`due_amnt`='".abs($remain_amnt)."' ");
						break;
					}
				}
			}
		}
	}

	if($receipt_type=="cash")
	{			
	$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$ledger_name."',`ledger_master_id`='".$res_whom['id']."',`credit`='".$_POST['amount']."',`debit`='0',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
			
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Cash Account',`ledger_master_id`='".cash_account_id()."',`credit`='0',`debit`='".$main_amnt."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
		if(!empty($_POST['discount']))
		{
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
			
$rs2=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Discount',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$_POST['discount']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		}
		
		if(!empty($_POST['tds_amnt']))
		{
			$ledger_master_tds=mysql_query("select `id` from `ledger_master` where `name`='Tds Deducted' && `ledger_type_id`='5'");
			$row_ledger_master_tds=mysql_fetch_array($ledger_master_tds);
			
	$rs3=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Tds Deducted',`ledger_master_id`='".$row_ledger_master_tds['id']."',`credit`='0',`debit`='".$_POST['tds_amnt']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");				
		}
	}
	else
	{
		$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$ledger_name."',`ledger_master_id`='".$res_whom['id']."',`credit`='".$_POST['amount']."',`debit`='0',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
	  
	$bank_res=mysql_query("select `name` from `bank_reg` where `id`='".$_POST['bank_id']."'");
	$row_bank=mysql_fetch_array($bank_res);
	
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_bank['name']."' && `ledger_type_id`='6'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
			
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='".$row_bank['name']."',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$main_amnt."',`invoice_id`='".$invoice_list."',`bank_id`='".$_POST['bank_id']."',`branch_id`='".$_POST['branch_id']."',`cheque_no`='".$_POST['cheque_no']."',`cheque_date`='".datefordb($_POST['cheque_date'])."',`drawn_branch`='".$_POST['drawn_branch']."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
	
		if(!empty($_POST['discount']))
		{
	$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
	$row_ledger_master=mysql_fetch_array($ledger_master);
	
	$rs2=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Discount',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='0',`debit`='".$_POST['discount']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		}		
		
		if(!empty($_POST['tds_amnt']))
		{
			$ledger_master_tds=mysql_query("select `id` from `ledger_master` where `name`='Tds Deducted' && `ledger_type_id`='5'");
			$row_ledger_master_tds=mysql_fetch_array($ledger_master_tds);
			
	$rs3=mysql_query("insert into `ledger` set `date`='".datefordb($_POST['date'])."',`name`='Tds Deducted',`ledger_master_id`='".$row_ledger_master_tds['id']."',`credit`='0',`debit`='".$_POST['tds_amnt']."',`invoice_id`='".$invoice_list."',`transaction_type`='receipt',`transaction_id`='".$_POST['receipt_id']."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");				
		}
	}
	if($rs || $rs1 || $rs_update || $rs3) 
	echo "<script>alert('Entry Updated to database.');location='update_receipt.php?id=".$receipt_id."';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='update_receipt.php?id=".$receipt_id."';</script>";	
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['journal_reg']))
{
	$invoice_list1=implode(",",$_POST['invoice_list1']);
	
	$count=$_POST['count'];
	for($k=1;$k<=$count;$k++)
	{
		$main_amnt=$_POST['amount'.$k];
		if(!empty($_POST['amount'.$k]))
		{
			$ledger_type_id=$_POST['ledger_type_id'.$k];
			if($ledger_type_id==1){
				$invoice_list=$_POST['invoice_list'.$k];
				foreach($invoice_list as $invoice_id){
					
					$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$invoice_id."' && `due_amnt`>'0'");
					if(mysql_num_rows($check_receipt_detail)>0)
					{
						$row_receipt_detail=@mysql_fetch_array($check_receipt_detail);
						 $grand_total=$row_receipt_detail['due_amnt'];
					}
					else
					{
						$result=mysql_query("select `grand_total` from `invoice` where `id`='".$invoice_id."'");
						$row=mysql_fetch_array($result);
						$grand_total=$row['grand_total'];	
					}
					
					$remain_amnt=$main_amnt-$grand_total;
					
					if($main_amnt == $grand_total || $main_amnt > $grand_total)
					{
						echo "one";
						$rs_update=@mysql_query("update `invoice` set `payment_status`='yes' where `id`='".$invoice_id."'");
						if($rs_update)
						@mysql_query("update `receipt_detail` set `due_amnt`='0' where `invoice_id`='".$invoice_id."'");
					}
					else
					{
						echo "two";
						$receipt_fetch=mysql_query("select `id` from `receipt_detail` where `invoice_id`='".$invoice_id."'");
						if(mysql_num_rows($receipt_fetch)>0)
						{
							@mysql_query("update `receipt_detail` set `due_amnt`='".abs($remain_amnt)."' where `invoice_id`='".$invoice_id."'");
							break;
						}
						else
						{
							@mysql_query("insert into `receipt_detail` set `invoice_id`='".$invoice_id."',`due_amnt`='".abs($remain_amnt)."' ");
							break;
						}
					}
				$main_amnt=abs($remain_amnt);	
				}
			}
			
			
			$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$_POST['ledger_master_id'.$k]."' && `ledger_type_id`='".$_POST['ledger_type_id'.$k]."' ORDER BY `id` DESC LIMIT 1");
			$row_ledger_master=mysql_fetch_array($ledger_master);
			
			if($_POST['credit_debit'.$k]=="Credit")
			{
			 $rs_credit=mysql_query("insert into `ledger` set `ledger_master_id`='".$row_ledger_master['id']."',`name`='".$_POST['ledger_master_id'.$k]."',`credit`='".$_POST['amount'.$k]."',`date`='".datefordb($_POST['date'.$k])."',`invoice_id`='".$invoice_list1."',`narration`='".$_POST['narration']."',`transaction_type`='jv',`transaction_id`='".$_POST['transaction_id']."',`current_date`='".date("Y-m-d")."'");
			}
			else
			{
				 $rs_debit=mysql_query("insert into `ledger` set `ledger_master_id`='".$row_ledger_master['id']."',`name`='".$_POST['ledger_master_id'.$k]."',`debit`='".$_POST['amount'.$k]."',`date`='".datefordb($_POST['date'.$k])."',`narration`='".$_POST['narration']."',`transaction_type`='jv',`transaction_id`='".$_POST['transaction_id']."',`current_date`='".date("Y-m-d")."'");
			}
		}
	}
    if($rs_credit && $rs_debit) 
	echo "<script>alert('Entry Updated to database.');location='jv_menu.php';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='jv_menu.php';</script>";	
	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_jv']))
{
	$count=$_POST['count'];
	$trancation_id=$_POST['trancation_id'];
	$i=0;
	for($i=1;$i<=$count;$i++)
	{
		$ledger_type_id=$_POST['ledger_type_id'.$i];
		$ledger_master_id=$_POST['ledger_master_id'.$i];
		$credit=$_POST['credit'.$i];
		$debit=$_POST['debit'.$i];
		$narration=$_POST['narration'.$i];
		$myid=$_POST['myid'.$i];
		$date=$_POST['date'.$i];
		if(!empty($credit)||!empty($debit))
		{
		$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$ledger_master_id."' && `ledger_type_id`='".$ledger_type_id."' ORDER BY `id` DESC LIMIT 1");
		$row_ledger_master=mysql_fetch_array($ledger_master);
		$rs=@mysql_query("update `ledger` set `name`='".$ledger_master_id."',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='".$credit."',`debit`='".$debit."',`narration`='".$narration."',`date`='".datefordb($date)."',`current_date`='".date("Y-m-d")."' where `id`='".$myid."'");
		}
		else
		{
		$rs=@mysql_query("delete from `ledger` where `id`='".$myid."'");	
		}
	}
	if($rs) 
	echo "<script>alert('Entry Updated to database.');location='update_jv.php?trans_id=".$trancation_id."&type=jv';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='update_jv.php?trans_id=".$trancation_id."&type=jv';</script>";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_corporate']))
{	
		@session_start();
		$counter_id=$_SESSION['counter_id'];	
		$login_id=$_SESSION['id'];
		$myid=$_POST['myid'];
		$customer_name=$_POST['customer_name'];
		$guest_name=$_POST['guest_name'];
		$ref=$_POST['ref'];
		$ins_date=$_POST['ins_date'];
		$grand_total=$_POST['grand_total'];
		$service_tax=$_POST['service_tax'];
		$discount=$_POST['discount'];
		$net_amnt=$_POST['net_amnt'];
		$total_cor=$_POST['total_cor'];
		for($s=0;$s<=$total_cor;$s++)
		{
					if(!empty($_POST['amount'.$s]))
					{
						$service_date[]=datefordb($_POST['service_date'.$s]);
						$service[]=$_POST['service'.$s];
						$rate[]=$_POST['rate'.$s];
						$day[]=$_POST['day'.$s];
						$taxi_no[]=$_POST['taxi_no'.$s];
						$amount[]=$_POST['amount'.$s];
					}
		}
	
	$rs=mysql_query("update `corporate_billing` set  `date`='".datefordb($ins_date)."',`customer_name`='".$customer_name."',`guest_name`='".$guest_name."',`ref`='".$ref."',`service`='".implode(",",$service)."',`service_date`='".implode(",",$service_date)."',`rate`='".implode(",",$rate)."',`no_of_days`='".implode(",",$day)."',`taxi_no`='".implode(",",$taxi_no)."',`amount`='".implode(",",$amount)."',`tot_amnt`='".$grand_total."',`service_tax`='".$service_tax."',`discount`='".$discount."',`net_amnt`='".$net_amnt."',`login_id`='".$login_id."',`counter_id`='".$counter_id."' where `id`='".$myid."'");
		
	if($discount>0)
	{
	$cor_credit=(($net_amnt+$discount)-$service_tax);
	}
	else
	{
	$cor_credit=$net_amnt-$service_tax;
	}
		
	$res_ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$customer_name."' && `ledger_type_id`='1'");
	$res_ledger_master=mysql_fetch_array($res_ledger_master);	
	
	$ledger_discount=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
	$row_discount_id=mysql_fetch_array($ledger_discount);

	$fetch_ledger=mysql_query("select `date` from `ledger` where `transaction_id`='".$myid."' && `transaction_type`='corporate_billing' ");
	$date_ledger=mysql_fetch_array($fetch_ledger);
	
	@mysql_query("delete from `ledger` where `transaction_id`='".$myid."' && `transaction_type`='corporate_billing'");
	
	if(!empty($net_amnt)&&!empty($cor_credit))
{
///////////////////////////////////////////////--------------------------debit start here----------------------------/////////////////////////////////////////////////////
@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`ledger_master_id`='".$res_ledger_master['id']."',`name`='".$customer_name."',`credit`='0',`debit`='".$net_amnt."',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$myid."',`current_date`='".date("Y-m-d")."'");
if($discount>0)
@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`ledger_master_id`='".$row_discount_id['id']."',`name`='Discount',`credit`='0',`debit`='".$discount."',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$myid."',`current_date`='".date("Y-m-d")."'");
///////////////////////////////////////////////--------------------------debit end here----------------------------////////////////////////////////////////////////////

$cor_bill_id=mysql_query("select `id` from `ledger_master` where `name`='Corporate Billing' && `ledger_type_id`='5'");
$res_bill_id=mysql_fetch_array($cor_bill_id);
$cor_id=$res_bill_id['id'];

$ledger_tax=mysql_query("select `id` from `ledger_master` where `name`='Service Tax' && `ledger_type_id`='8'");
$row_tax=mysql_fetch_array($ledger_tax);

///////////////////////////////////////////////--------------------------credit start here here----------------------------/////////////////////////////////////////////
@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`ledger_master_id`='".$cor_id."',`name`='Corporate Billing',`credit`='".$cor_credit."',`debit`='0',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$myid."',`current_date`='".date("Y-m-d")."'");
if($service_tax>0)
@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`ledger_master_id`='".$row_tax['id']."',`name`='Service Tax',`credit`='".$service_tax."',`debit`='0',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$myid."',`current_date`='".date("Y-m-d")."'");
///////////////////////////////////////////////--------------------------credit end here here----------------------------/////////////////////////////////////////////
}

	
	if($rs) 
	echo "<script>alert('Entry Updated to database.');location='update_corporate_billing.php?id=".$myid."';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='update_corporate_billing.php?id=".$myid."';</script>";
}
///////////////////////////////////////////////--------------------------credit end here here----------------------------/////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['update_payment']))
{
	$myid=$_POST['myid'];
	$payment_type=$_POST['payment_type'];
	
	$fetch_ledger=mysql_query("select `date` from `ledger` where `transaction_id`='".$myid."' && `transaction_type`='payment' ");
	$date_ledger=mysql_fetch_array($fetch_ledger);
	
	@mysql_query("delete from `ledger` where `transaction_id`='".$myid."' && `transaction_type`='payment'");
	
	
	$result_whom=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$_POST['ledger_type_id']."' && `name`='".$_POST['ledger_name']."'");
	$res_whom=mysql_fetch_array($result_whom);
	
	if($payment_type=='cash')
	{
		
$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`name`='".$_POST['ledger_name']."',`ledger_master_id`='".$res_whom['id']."',`credit`='0',`debit`='".$_POST['amount']."',`transaction_type`='payment',`transaction_id`='".$myid."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
							
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`name`='Cash Account',`ledger_master_id`='".cash_account_id()."',`credit`='".$_POST['amount']."',`debit`='0',`transaction_type`='payment',`transaction_id`='".$myid."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
		
	}
	else
	{
		$rs=@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`name`='".$_POST['ledger_name']."',`ledger_master_id`='".$res_whom['id']."',`credit`='0',`debit`='".$_POST['amount']."',`transaction_type`='payment',`transaction_id`='".$myid."',`narration`='".$_POST['narration']."',`current_date`='".date("Y-m-d")."'");
			
		$bank_res=mysql_query("select `name` from `bank_reg` where `id`='".$_POST['bank_id']."'");
		$row_bank=mysql_fetch_array($bank_res);
		
		$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_bank['name']."' && `ledger_type_id`='6'");
		$row_ledger_master=mysql_fetch_array($ledger_master);
		
	$rs1=@mysql_query("insert into `ledger` set `date`='".datefordb($date_ledger['date'])."',`name`='".$row_bank['name']."',`ledger_master_id`='".$row_ledger_master['id']."',`credit`='".$_POST['amount']."',`debit`='0',`transaction_type`='payment',`transaction_id`='".$myid."',`narration`='".$_POST['narration']."',`bank_id`='".$_POST['bank_id']."',`branch_id`='".$_POST['branch_id']."',`cheque_no`='".$_POST['cheque_no']."',`cheque_date`='".datefordb($_POST['cheque_date'])."',`drawn_branch`='".$_POST['drawn_branch']."',`current_date`='".date("Y-m-d")."'");
		
	}
	if($rs && $rs1) 
	echo "<script>alert('Entry Updated to database.');location='update_payment.php?id=".$myid."';</script>";
	else
	echo "<script>alert('You have enter nothing please try again.');location='update_payment.php?id=".$myid."';</script>";	
	 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

