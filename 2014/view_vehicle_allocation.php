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
<a href="vehicle_allocation_menu.php" class="btn red"><i class="icon-edit"></i> Search</a>
<a href="pdf_codes/myex.php?tab=vehicle_allocation" class="btn blue"><i class="icon-download-alt"></i> Pdf Download</a>
</div> 
<br />
 <div class="portlet box yellow">
							<div class="portlet-title">
								<h4><i class="icon-table"></i>View</h4>
							</div>
							<div class="portlet-body">
 <?php                
 if(isset($_GET['booking']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `booking` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$booking_id=$row['id'];
	$booked_by=$row['booked_by'];
	$customer_reg_name=$row['customer_reg_name'];
	$qry_booking="select * from `customer_reg` where `id`='$customer_reg_name'";
	$data_base_object = new DataBaseConnect();
	$result_booking= $data_base_object->execute_query_return($qry_booking);
	$row_booking=mysql_fetch_array($result_booking);
	$customer_name=$row_booking['name'];
	$customer_mob_number=$row['customer_mob_number'];
	$guest_name=$row['guest_name'];
	$guest_mob_number=$row['guest_mob_number'];
	$travel_from=$row['travel_from'];
	$travel_to=$row['travel_to'];
	$service_id=$row['service_id'];
	$qry_service="select * from `service` where `service_id`='$service_id'";
	$result_service = $data_base_object->execute_query_return($qry_service);
	$row_service=mysql_fetch_array($result_service);
	$service_name=$row_service['name'];
	$flight_no=$row['flight_no'];
	$pickup_time=$row['pickup_time'];
	$pickup_from=$row['pickup_from'];
	$drop_to=$row['drop_to'];
	$result=$data_base->execute_query_return("select * from `booking_car` where `booking_id`='".$booking_id."'");
	$row=mysql_fetch_array($result);
	$carname_master=$row['carname_master'];
	$qry_car="select * from `carname_master` where `id`='$carname_master'";
	$result_car = $data_base_object->execute_query_return($qry_car);
	$row_car=mysql_fetch_array($result_car);
	$car_name=$row_car['name'];
	$vehicle=$row['vehicle'];
?>
 <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
<table width="100%" align="center" class="table table-bordered table-hover" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Results for <?php echo 'Booking';?></strong></td>
    <td><!--<input type="button" onclick="javascript: window.print()" value="print"/>--></td>
  </tr>
  <tr>
    <td><strong>Booked By:</strong></td>
    <td><?php echo $booked_by;?></td>
    <td><strong>Customer Name:</strong></td>
    <td><?php echo $customer_name; ?></td>
    <td><strong>Customer Mobile:</strong></td>
    <td><?php echo $customer_mob_number; ?></td>
    <td><strong>Guest Name:</strong></td>
    <td><?php echo $guest_name;?></td>
     </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    
    <td><strong>Guest Mobile:</strong></td>
    <td><?php echo $guest_mob_number;?></td>
      <td><strong>Travel From:</strong></td>
    <td><?php echo $travel_from;?></td>
      <td><strong>Travel Date To:</strong></td>
    <td><?php echo $travel_to;?></td>
    <td><strong>Service Name</strong></td>
    <td><?php echo $service_name;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Flight Number: </strong></td>
    <td><?php echo $flight_no;?></td>
    <td><strong>PickUp Time: </strong></td>
    <td><?php echo $pickup_time;?></td>
    <td><strong>PickUp From: </strong></td>
    <td><?php echo $pickup_from;?></td>
    <td><strong>Drop To: </strong></td>
    <td><?php echo $drop_to;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
   
    <td><strong>Car Name: </strong></td>
    <td><?php echo $car_name;?></td>
    <td><strong>Number: </strong></td>
    <td><?php echo $vehicle;?></td>
    <td></td>
    <td></td><td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="140px"></td>
    <td width="130px"></td>
    <td width="160px;">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
</div>
<?php 
}
$data_base->close_connection();
}?>

                 </div>
                   </div>  
                    </div>	
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