<?php
require 'config.php';
header('Content-Type: application/force-download');
header("Pragma: ");
header("Cache-Control: ");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.xls");
date_default_timezone_set('asia/kolkata');

$date_from=$_GET['date_from'];
$date_to=$_GET['date_to'];
$cust_name=$_GET['cust_name'];
?>
<table width="100%" border="1" style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
                        <tr>
                        <td colspan="9" align="center"><b>Excel Report From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_to'])); ?></b></td>
                        </tr>
                    	<thead>
                        <tr>
                        <th>SL.</th>
                        <th>In.No.</th>
                        <th>Ds.No</th>
                        <th>Guest Name</th>
                        <th>Service</th>
                        <th>Gross Amt</th>
                        <th>S.Tax</th>
                        <th>Other Charges</th>
                        <th>Total Amt</th>
                        </tr>
                    </thead>
<?php
if(!empty($cust_name))
$q1=" `duty_slip_customer_reg_name`='".$cust_name."' ";
if(!empty($date_from)&&!empty($date_to))
{
if($q1=="")
$q2=" `date` between '".$date_from."' and  '".$date_to."' ";
else 
$q2=" AND `date` between '".$date_from."' and  '".$date_to."' ";
}
if($q1=="" && $q2=="" )
$qry="select * from invoice ";
else
$qry="select * from invoice where ";
$sql=$qry.$q1.$q2;
$rez= mysql_query($sql);
$array1=array();
while($row=mysql_fetch_array($rez))
{	
	$invoice_id=$row['invoice_id'];
	$fth_dsno=mysql_query("select * from duty_slip where `max_invoice_id`='".$invoice_id."'");
	$num_ds=mysql_num_rows($fth_dsno);
	while($arr_dsno=mysql_fetch_array($fth_dsno))
	{
	$array=array();
	$count++;	
	?>
    <tr>
    <td><?php echo $count; ?></td>
    <td><?php echo $invoice_id; ?></td>
    <td><?php echo $arr_dsno['dutyslip_id']; ?></td>
    <td><?php echo $arr_dsno['guest_name']; ?></td>
    <?php
	$service_service_id=$arr_dsno['service_service_id'];
	
	if(!empty($row['discount']))
	{
		$each_dis=ceil($row['discount']/$num_ds);
	}
	
	$result_what=mysql_query("select `type` from `service` where `service_id`='".$service_service_id."'");
	$row_what=mysql_fetch_assoc($result_what);
	$service_type=$row_what['type'];
	
	$date_from_st=$arr_dsno['date_from'];
	$date_to_ed=$arr_dsno['date_to'];
	$main1= strtotime($date_from_st);
	$main2 = strtotime($date_to_ed);
	$days=(($main2-$main1)/86400);	
	//$tot_chg = $rate+($rate*($days));	
	$new_days=$days+1;
	if($days==0)
	{
	$incity_days=1;
	}
	else
	{
	$incity_days=$days;	
	}		

		
	if($service_type=='intercity')
	{
		 $result_cust=mysql_query("select * from customer_tariff where customer_reg_name='".$row['duty_slip_customer_reg_name']."' and carname_master_id='".$arr_dsno['carname_master_id']."' and service_service_id='".$arr_dsno['service_service_id']."' ");
							
						   $extra_km_charge=0;
						   $extra_km=0;
						   $extra_per_km=0;
			               if(mysql_num_rows($result_cust)>0)
						    {
								$row_cust=mysql_fetch_assoc($result_cust);
								$minimum_chg_km=$row_cust['minimum_chg_km'];
								$total_freerun = $minimum_chg_km*$new_days;
							
								$extra_km=$arr_dsno['total_km']-($total_freerun);
								$extra_km_charge=($extra_km)*$row_cust['extra_km_rate'];
								$extra_per_km=$row_cust['extra_km_rate'];
							}
							else
							{
							$result_tariff=mysql_query("select * from `tariff_rate` where `carname_master_id`='".$arr_dsno['carname_master_id']."' and `service_service_id`='".$service_service_id."'");
							if(mysql_num_rows($result_tariff)>0)
							{
								$row_tariff=mysql_fetch_assoc($result_tariff);
								$minimum_chg_km=$row_tariff['minimum_chg_km'];
								$total_freerun = $minimum_chg_km*$new_days;
								
									$extra_km=$arr_dsno['total_km']-($total_freerun);
									$extra_km_charge=($extra_km)*$row_tariff['extra_km_rate'];
									$extra_per_km=$row_tariff['extra_km_rate'];
								
							}	
							}
	if($extra_km_charge<=0)
	{
	$extra_km_charge=0;
	}
	$tt=ceil(($arr_dsno['rate']+$extra_km_charge)-$each_dis);
								
	}
	else if($service_type=='incity')
	{
					$result_cust=mysql_query("select * from customer_tariff where customer_reg_name='".$row['duty_slip_customer_reg_name']."' and carname_master_id='".$arr_dsno['carname_master_id']."' and service_service_id='".$arr_dsno['service_service_id']."' ");
							
							$extra_hours=0;
							$extra_hours_charges=0;
							$extra_per_hour=0;
							
					if(mysql_num_rows($result_cust)>0)
						{
									$row_cust=mysql_fetch_assoc($result_cust);
					      			$var_first_stamp =$arr_dsno['date_to']." ".$arr_dsno['closing_time'];
									$var_second_stamp =$arr_dsno['date_from']." ".$arr_dsno['opening_time'];
									$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
										$extra_hours=$total_time_of_car-(($row_cust['minimum_chg_hourly'])*$incity_days);
										$extra_hours_charges=$extra_hours*$row_cust['extra_hour_rate'];
										$extra_per_hour=$row_cust['extra_hour_rate'];
						}
						else
						{
							
							
							$result_tariff=mysql_query("select * from `tariff_rate` where `carname_master_id`='".$arr_dsno['carname_master_id']."' and `service_service_id`='".$service_service_id."'");
						        
									$row_tariff=mysql_fetch_assoc($result_tariff);
									$var_first_stamp =$arr_dsno['date_to']." ".$arr_dsno['closing_time'];
									$var_second_stamp =$arr_dsno['date_from']." ".$arr_dsno['opening_time'];
									$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
									$extra_hours=$total_time_of_car-(($row_tariff['minimum_chg_hourly'])*$incity_days);
									$extra_hours_charges=$extra_hours*$row_tariff['extra_hour_rate'];
									$extra_per_hour=$row_tariff['extra_hour_rate'];
							
						}
				if($extra_hours_charges<=0)
				{
					$extra_hours_charges=0;
				}
				$tt=ceil(($arr_dsno['rate']+$extra_hours_charges)-$each_dis);
		
	}
	
	$s_tax=($tt*4.8)/100;
	$e_tax=($s_tax*2)/100;
	$h_tax=($s_tax*1)/100;
	$t_tax=ceil($s_tax+$e_tax+$h_tax);
	$result_service_name=mysql_query("select `name` from `service` where `service_id`='".$service_service_id."'");
	$row_service_name=mysql_fetch_array($result_service_name);

//	$array[]=$row_service_name['name'];
	
	$array[]=$tt;	 ////////////////////////////////************
	$array[]=$t_tax;	 ////////////////////////////////************
	$other_chg=$arr_dsno['extra_chg']+$arr_dsno['permit_chg']+$arr_dsno['parking_chg']+$arr_dsno['otherstate_chg']+$arr_dsno['guide_chg']+$arr_dsno['misc_chg'];	
	$array[]=$other_chg; 
	$g_tt=$tt+$t_tax+$other_chg;
	
	$array[]=$g_tt;	 ////////////////////////////////************
	?>
<td><?php echo $row_service_name['name']; ?></td>
<td><?php echo $tt; ?></td>
<td><?php echo $t_tax; ?></td>
<td><?php echo $other_chg; ?></td>
<td><?php echo $g_tt; ?></td>
</tr>
    <?php
	}
  
}
	
?>



  