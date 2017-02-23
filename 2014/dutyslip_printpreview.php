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
   <style>
   hr {
  border-top: 1px dashed;

}

</style>
<style  media="print">
  
	.dn
	{
		display:none !important;
	}

	</style>
    
  <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
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
         <a class="btn green diplaynone"  role="button"  href="javascript:window.print();" style="text-decoration:none; margin-top:1%;"><i class="icon-print"></i>Print</a>
     <?php menu(); ?>
     <form method="post" >
     <?php
 		if(isset($_POST['generate']))
{
        $find_dutyslip=$_POST['find_dutyslip'];
        $dsid = $_POST['dsid'];
  	    $data_base_connect_object =new DataBaseConnect(); 
        $result=$data_base_connect_object->execute_query_return("select * from `duty_slip` where `dutyslip_id`='".$dsid."'");
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
		$remarks=$row['remarks'];
		$opening_date = DateExact($row['date_from']);
		$opening_date_new = date("d-m-Y",strtotime($opening_date));
		if($opening_date_new=="30-11--0001")
		{
			$opening_date_new="";
		}
		$closing_date = DateExact($row['date_to']);
		$closing_date_new = date("d-m-Y",strtotime($closing_date));
		if($closing_date_new=="30-11--0001")
		{
			$closing_date_new="";
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
		$extra_chg=$row['extra_chg'];
		$permit_chg=$row['permit_chg'];
		$parking_chg=$row['parking_chg'];
		$guide_chg=$row['guide_chg'];
		$misc_chg=$row['misc_chg'];
		$otherstate_chg = $row['otherstate_chg'];
		$total_charges=$extra_chg+$permit_chg+$parking_chg+$guide_chg+$misc_chg+$otherstate_chg;
  for($i=1;$i<=2;$i++)
  {
	  $count++;
	  if($count==2)
	  {
		 echo '<table align="center" width="100%" style="margin-top:20%">';
	  }
	  else
	  {
	   echo '<table align="center" width="100%">';
	  }
	  ?>
               
               <thead>
  <tr >
    <td align="left" width="50%">
    	<img src="images/logo.jpg" style="float:left !important;" />  
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
    </thead>
    </table>
<table  width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:30px">
<thead>
  <tr>
    <td><strong>Duty Slip Id:</strong></td>
    <td colspan="5"><?php echo $dutyslip_id;?></td>
    <td ><strong>Date: </strong></td>
    <td ><?php echo date('d-m-Y');?></td>
  </tr>
  </thead>
  <tbody>
  <tr class="">
  <td><strong>Customer Name:</strong></td>
  	<td><?php echo $customer_name;?></td>
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
    <td><?php echo $opening_date_new;?></td>
    <td><strong>Closing Date:</strong></td>
    <td><?php echo $closing_date_new;?></td>
     <td><strong>Total Days:</strong></td>
    <td colspan="3"><?php echo $days;?></td>
  </tr>
  
  
  <tr class="">
    <td><strong>Opening Time:</strong></td>
    <td><?php echo $opening_time;?></td>
    <td><strong>Closing Time:</strong></td>
    <td><?php echo $closing_time;?></td>
     <td><strong>Used Hours:</strong></td>
    <td colspan="3"><?php echo $time_duration;?></td>
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
    <td><strong>Guest Comments: </strong></td>
    <td colspan="7"><?php echo "_____________________________________________________________________________________________";?></td>
  </tr>
  </tbody>
  <tfoot>
  <tr class="">
    <td><strong>Remarks: </strong></td>
    <td colspan="7"><?php echo $remarks;?></td>
  </tr>
  </tfoot>
</table>
<?php
  }
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>