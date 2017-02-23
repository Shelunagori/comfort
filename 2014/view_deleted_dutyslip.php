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
   <style>
  @media print {
    a {
        display:none;
    }
} 
</style> 
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
         <?php
		 if(isset($_GET['mode'])){?>
         <a class="btn green diplaynone"  role="button"  href="javascript:window.print();" style="text-decoration:none; margin-top:1%;"><i class="icon-print"></i>Print</a>
         <a class="btn yellow diplaynone" target="_blank"  href="excel_all.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&type=deleted_dutyslip" style="text-decoration:none; margin-top:1%;"><i class="icon-download-alt"></i> Export in Excel</a>
         <?php } ?>
     <?php menu(); ?>
        <?php
			         if(isset($_GET['mode']))
				     {
					     if($_GET['mode']=='view')
					       {
					     $mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip_waveoff` where `date_from` >= '".DateExact($_POST['date_from'])."' and  `date_to`<= '".DateExact($_POST['date_to'])."' ");
						?>
                        
                        
						<table  width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:20px">
                        <thead>
						<tr>
                        <th>DS No.</th>
                         <th>Customer Name</th>
                        <th>Guest Name</th>
                        <th>Service</th>
                        <th>Car</th>
                        <th>Car No.</th>
                        <th>Date</th>
                        <th>Opening KM</th>
                        <th>Closing KM</th>
                        <th>Reason</th>
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['dutyslip_id'];
							$current_date=$row['current_date'];
							$billing_name=$row['guest_name'];
							$customer_reg_name = $row['customer_reg_name'];
							$qry="select * from `customer_reg` where `id`='$customer_reg_name'";
							$data_base_object = new DataBaseConnect();
							$result_cust= $data_base_object->execute_query_return($qry);
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							$service_service_id=$row['service_service_id'];
							$qry_service="select * from `service` where `service_id`='$service_service_id'";
							$data_base_object = new DataBaseConnect();
							$result_service= $data_base_object->execute_query_return($qry_service);
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
							$carname_master_id=$row['carname_master_id'];
							$qry="select * from `carname_master` where `id`='$carname_master_id'";
							$data_base_object = new DataBaseConnect();
							$result_car = $data_base_object->execute_query_return($qry);
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];
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
							
                            $opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $status=$row['status'];
                            $reason=$row['reason'];
						?>
						
                        <td><?php echo $row['dutyslip_id'];?></td>
                         <td><?php echo $cust_name;?></td>
                        <td><?php echo $billing_name;?></td>
                        <td><?php echo $service_name;?></td>
                        <td><?php echo $car_name;?></td>
                        <td><?php echo $car_reg_name_new;?></td>
                        <td><?php echo date("d-M-Y", strtotime($current_date));?></td>
                        <td><?php echo $opening_km;?></td>
                        <td><?php echo $closing_km;?></td>
                         <td><?php echo $reason;?></td>
						<td><a style="color:green"  href="update_dutyslip.php?id=<?php echo $row['dutyslip_id'];?>" target="_new" ><i class="icon-edit"></i></a></td>			
                        </tr>
                        <?php
						}
						?>
                        </tbody>
						</table>
<?php
$mydatabase->close_connection();
					 }
					 }
				else
				{
					?>
     <form method="post" action="view_deleted_dutyslip.php?mode=view" name="form_name">
               <table width="100%">
              	<tr><td  width="20%"> Date From</td><td width="20%"><input type="text" name="date_from"  id="dp1" class="m-wrap medium"/></td><td></td></tr>
				<tr><td> Date To</td><td><input type="text" name="date_to" id="dp2"  class="m-wrap medium"/></td>
			<td><button type="submit" class="btn green" value="Submit" style="margin-left:1%; margin-top:-2% !important"  name="ledger_reg">Go <i class="icon-circle-arrow-right"></i></button></td></tr>
                </table>
              </form>  
                <?php
	}
	?>
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