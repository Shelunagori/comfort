<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Comfort</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
  <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post">
<div>                     
<a href="dutyslip_menu.php" class="btn blue diplaynone"><i class="icon-ok"></i> Add</a>
<a href="dutyslip_menu_edit.php" class="btn blue diplaynone"><i class="icon-edit"></i> Edit</a>
<a href="dutyslip_menu_edit_serch.php" class="btn red diplaynone"><i class="icon-search"></i> Search | Waveoff</a>
<a href="dutyslip_menu_print.php?ds_id=<?php echo $_GET['id']; ?>" class="btn blue diplaynone"><i class="icon-print"></i> Print</a>
</div> 
<br />

                            <?php
if(isset($_GET['dutyslip']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `duty_slip` where `dutyslip_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
		
		$row=mysql_fetch_array($result);
		$dutyslip_id=$row['dutyslip_id'];
		$guest_name=$row['guest_name'];
		$service_service_id=$row['service_service_id'];
		$service_all=mysql_query("select * from `service` where `service_id` = '$service_service_id'  ");
		$ftc_service=mysql_fetch_array($service_all);
		$service_name = $ftc_service['name'];
		$carname_master_id=$row['carname_master_id'];
		$car_reg_name=$row['car_reg_name'];
		$new_car_no = $row['new_car_no'];
		
		$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
		$data_base_object = new DataBaseConnect();
		$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
		$row_carid = mysql_fetch_array($result_carid);
		$car_reg_name_new=$row_carid['name'];
		if($car_reg_name_new=="Others")
		{
			$car_reg_name_new=$new_car_no;
		}
	
		$customer_reg_name=$row['customer_reg_name'];
		$qry="select * from `customer_reg` where `id`='".$customer_reg_name."'";
		$data_base_object_short = new DataBaseConnect();
		$result_cust_name= $data_base_object_short->execute_query_return($qry);
		$row_cust=mysql_fetch_array($result_cust_name);
		$customer_name=$row_cust['name'];
		$booked_by=$row['detail_number'];
		$driver_reg_driver_id=$row['driver_reg_driver_id'];
		$driver_all=mysql_query("select * from `driver_reg` where `driver_id` = '$driver_reg_driver_id' ");
		$ftc_driver=mysql_fetch_array($driver_all);
		$driver_name = $ftc_driver['name'];
		$opening_km=$row['opening_km'];
		$opening_time=$row['opening_time'];
		$closing_km=$row['closing_km'];
		$closing_time=$row['closing_time'];
		if($opening_time!="00:00:00"&&$closing_time!="00:00:00")
		{
$total_time      = strtotime($closing_time) - strtotime($opening_time);
$hours      = floor($total_time / 60 / 60);
$minutes    = round(($total_time - ($hours * 60 * 60)) / 60);
$time_duration=$hours.'.'.$minutes;
		}
		else
		{
			$time_duration="";
		}
		$date_from=$row['date_from'];
		$date_to=$row['date_to'];
		$opening_date = DateExact($row['date_from']);
		if($opening_date=="31-12-1969")
		{
			$opening_date="";
		}
		$closing_date = DateExact($row['date_to']);
		if($closing_date=="31-12-1969")
		{
			$closing_date="";
		}
		if(($opening_date_new=="")||($closing_date_new==""))
		{
		 $days="";
		}
		else
		{
		$main1= strtotime($opening_date);
		$main2 = strtotime($closing_date);
		$days=(($main2-$main1)/86400);
		}
		$remarks=$row['remarks'];
		$extra_chg=$row['extra_chg'];
		$permit_chg=$row['permit_chg'];
		$parking_chg=$row['parking_chg'];
		$guide_chg=$row['guide_chg'];
		$misc_chg=$row['misc_chg'];
		$otherstate_chg = $row['otherstate_chg'];
		$total_charges=$extra_chg+$permit_chg+$parking_chg+$guide_chg+$misc_chg+$otherstate_chg;
		
?>
	<table align="center" width="100%">
  <tr >
    <td align="left" width="50%">
    	<img src="images/logo.jpg" width="200"  style="float:left !important;" />  
    </td>
    <td align="right" width="50%">Comfort Travels &amp; Tours
      <br/>
      "Akruti" , 4- New Fatehpura, Opp. Saheliyo ki Badi,      
      <br/>
      UDAIPUR-313004 Fax : +91-294-2422131
      <br/>
      +91-294-2411661/62
      </td>
    </tr> 
    </table>
<table  width="100%" align="center" class="table table-striped table-hover" style="border:1px solid silver;">
<thead>
  <tr>
    <td><strong>Duty Slip Id:</strong></td>
    <td colspan="5"><?php echo $dutyslip_id;?></td>
    <td ><strong>Date: </strong></td>
    <td ><?php echo date('d-m-Y');?></td>
  </tr>
  </thead>
  
  <tr class="">
     <td><strong>Customer</strong></td>
  	<td ><?php echo $customer_name;?></td>
     <td><strong>Guest:</strong></td>
  	<td colspan="5"><?php echo $guest_name;?></td>
  </tr>
  
  <tr class="">
    <td><strong>Service: </strong></td>
    <td colspan="7"><?php echo $service_name;?></td> 
  </tr>
  
  <tr class="">
    <td><strong>Taxi Number:</strong></td>
    <td><?php echo $car_reg_name_new;?></td>
    <td><strong>Driver:</strong></td>
    <td><?php echo $driver_name;?></td>
    <td colspan="4"></td>
  </tr>
  
   <tr class="">
    <td><strong>Opening Date:</strong></td>
    <td><?php echo date("d-M-Y",strtotime($opening_date));?></td>
    <td><strong>Closing Date:</strong></td>
    <td><?php echo date("d-M-Y",strtotime($closing_date));?></td>
     <td><strong>Total Days:</strong></td>
    <td colspan="3"><?php echo $days; ?></td>
  </tr>
  
  <tr class="">
    <td><strong>Opening Time:</strong></td>
    <td><?php echo $opening_time;?></td>
    <td><strong>Closing Time:</strong></td>
    <td><?php echo $closing_time;?></td>
     <td><strong>Used Hours:</strong></td>
    <td colspan="3"><?php echo $time_duration;  ?></td>
  </tr>
   
  <tr class="">
    <td ><strong>Opening KM:</strong></td>
    <td ><?php echo $opening_km;?></td>
    <td ><strong>Closing KM:</strong></td>
    <td ><?php echo $closing_km;?></td>
    <td ><strong>Running KM:</strong></td>
    <td colspan="3"><?php echo $closing_km-$opening_km;?></td>
  </tr>
 
  <tr class="">
    <td><strong>Charges: </strong></td>
    <td colspan="7"><?php echo Rs."&nbsp;".$total_charges;?></td>
  </tr>
 
  <tr class="">
    <td><strong>Guest Comments: </strong></td>
    <td colspan="7"><?php echo "_____________________________________________________________________________________________";?></td>
  </tr>
  
  <tr class="">
    <td><strong>Remarks: </strong></td>
    <td colspan="7"><?php echo $remarks;?></td>
  </tr>
  
</table>
                
<?php 
}
$data_base->close_connection();
}
else 
if(isset($_GET['dutyslipwaveoff']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `duty_slip_waveoff` where `dutyslip_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$dutyslip_id=$row['dutyslip_id'];
	$current_date=$row['current_date'];
	$guest_name=$row['guest_name'];
	$contactnumber=$row['contactnumber'];
	$photo_id=$row['photo_id'];
	$service_service_id=$row['service_service_id'];
	$carname_master_id=$row['carname_master_id'];
	$car_reg_name=$row['car_reg_name'];
	$customer_reg_name=$row['customer_reg_name'];
	$detail_number=$row['detail_number'];
	
	$driver_reg_driver_id=$row['driver_reg_driver_id'];
	$opening_km=$row['opening_km'];
	$opening_time=$row['opening_time'];
	$closing_km=$row['closing_km'];
	$closing_time=$row['closing_time'];
	$date_from=$row['date_from'];
	$date_to=$row['date_to'];
	$extra_chg=$row['extra_chg'];
	$permit_chg=$row['permit_chg'];
	$parking_chg=$row['parking_chg'];
	$otherstate_chg=$row['otherstate_chg'];
	$guide_chg=$row['guide_chg'];
	$misc_chg=$row['misc_chg'];
	$remarks=$row['remarks'];
	$billed_complimentary=$row['billed_complimentary'];
	$total_km=$row['total_km'];
	$rate=$row['rate'];
	$amount=$row['amount'];
	$loginname=$row['loginname'];
	$countername=$row['countername'];
	
?>
<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Duty Slip<?php echo $dutyslip_id;?></strong></td>
    <td><input type="button" onclick="javascript: window.print()" value="print"/></td>
  </tr>
  <tr>
    <td width="156"><strong>Duty Slip Id:</strong></td>
    <td width="156"><?php echo $dutyslip_id;?></td>
    <td width="156"><strong>Duty Slip Date:</strong></td>
    <td width="156"><?php echo $current_date;?></td>
     <td><strong>Guest Name :</strong></td>
    <td><?php echo $guest_name; ?></td>
     <td><strong>Contact Number:</strong></td>
    <td><?php echo $contactnumber; ?></td>
    </tr>
    <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
     <td><strong>Photo Id :</strong></td>
    <td><?php echo $photo_id; ?></td>
    <td><strong>Service Name :</strong></td>
    <td><?php echo $service_service_id; ?></td>
    <td><strong>Car Name:</strong></td>
    <td><?php echo $carname_master_id;?></td>
    <td><strong>Car Number:</strong></td>
    <td><?php echo $car_reg_name;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
     <td><strong>Driver Name:</strong></td>
    <td><?php echo $driver_reg_driver_id;?></td>
     <td><strong>Opening KM:</strong></td>
    <td><?php echo $opening_km;?></td>
    <td><strong>Opening Time</strong></td>
    <td><?php echo $opening_time;?></td>
    <td><strong>Closing KM:</strong></td>
    <td><?php echo $closing_km;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Closing Time:</strong></td>
    <td><?php echo $closing_time;?></td>
    <td><strong>Date From:</strong></td>
    <td><?php echo $date_from;?></td>
    <td><strong>Date To:</strong></td>
    <td><?php echo $date_to;?></td>
    <td><strong>Extra Charges</strong></td>
    <td><?php echo $extra_chg;?></td>  
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Permit Charges:</strong></td>
    <td><?php echo $permit_chg;?></td>
    <td><strong>Parking Charges:</strong></td>
    <td><?php echo $parking_chg;?></td>
    <td><strong>Other State Charges:</strong></td>
    <td><?php echo $otherstate_chg;?></td>
    <td><strong>Guide Charges:</strong></td>
    <td><?php echo $guide_chg;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Remarks:</strong></td>
    <td><?php echo $remarks;?></td>
    <td><strong>Billed Complimentary:</strong></td>
    <td><?php echo $billed_complimentary;?></td>
    <td><strong>Misc. Charges:</strong></td>
    <td><?php echo $misc_chg;?></td>
     <td><strong>Rate:</strong></td>
    <td><?php echo $rate;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Amount:</strong></td>
    <td><?php echo $amount;?></td>
    <td><strong>Total KM.:</strong></td>
    <td><?php echo $total_km;?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"></td>
  </tr>
</table>
<?php 
}
$data_base->close_connection();
}
?>
             
                       </form>	
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>