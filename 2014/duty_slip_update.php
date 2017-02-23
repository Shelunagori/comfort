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
      <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-table"></i>Duty Slip Update</h4>
                    </div>
                    <div class="portlet-body form">
                    <?php
	if(isset($_GET['mode']))
				{
					if($_GET['mode']=='view')
					{
					
						?>						
						<table  style="border:1px solid silver;" class="table table-bordered table-hover">
                        <?php 
							$id = $_POST['dutyslip_id'];
							$mydatabase = new DataBaseConnect();
						$resultup= $mydatabase->execute_query_return("select * from   `duty_slip_updation` where `dutyslip_id`='".$_POST['dutyslip_id']."'");					
						
						$resultor=$mydatabase->execute_query_return("select * from   `duty_slip` where `dutyslip_id`='".$_POST['dutyslip_id']."'");
						$row1=mysql_fetch_array($resultor);
						$qry_carname="select * from `carname_master` where `id`='".$row1['carname_master_id']."'";
						$data_base_object = new DataBaseConnect();
						$result_car = $data_base_object->execute_query_return($qry_carname);
						$row_car=mysql_fetch_array($result_car);
						$car_name=$row_car['name'];		
						$total_rows= mysql_num_rows($resultup);
						$qry_service="select * from `service` where `service_id`='".$row1['service_service_id']."'";
						$result_service = $data_base_object->execute_query_return($qry_service);
						$row_service=mysql_fetch_array($result_service);
						$service_name=$row_service['name'];	
						$qry="select * from `customer_reg` where `id`='".$row1['customer_reg_name']."'";
						$data_base_object = new DataBaseConnect();
						$result= $data_base_object->execute_query_return($qry);
						$row=mysql_fetch_array($result);
						$customer_name=$row['name'];
						?>
						<tr><th style="text-align:center">Fields</th><th>Original</th>
						<?php
							for($i=0;$i<$total_rows;$i++)
							{
						?>
						
						<th>Update <?php echo ($i+1);?> </th>
						<?php 
						}
						$allrows=array();
						for($i=0;$i<$total_rows;$i++)
						$allrows[]=mysql_fetch_array($resultup);
						?>
						</tr>
						<tr><th>Guest Name</th><td><?php echo $row1['guest_name']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['guest_name']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Contact No.</th><td><?php echo $row1['contactnumber']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['contactnumber']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Photo Id</th><td><?php echo $row1['photo_id']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['photo_id']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Service</th><td><?php echo $service_name; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
                        <?php $qry_service="select * from `service` where `service_id`='".$allrows[$i]['service_service_id']."'";
						$result_service = $data_base_object->execute_query_return($qry_service);
						$row_service=mysql_fetch_array($result_service);
						$service_name=$row_service['name'];	 ?>
						<td> <?php echo $service_name; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Car Name</th><td><?php echo $car_name; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?><?php $qry_carname="select * from `carname_master` where `id`='".$allrows[$i]['carname_master_id']."'";
						$data_base_object = new DataBaseConnect();
						$result_car = $data_base_object->execute_query_return($qry_carname);
						$row_car=mysql_fetch_array($result_car);
						$car_name=$row_car['name'];	?>
						<td> <?php echo $car_name; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Service Id</th><td><?php echo $row1['carname_master_id']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['carname_master_id']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Car No.</th><td><?php echo $row1['car_reg_name']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['car_reg_name']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Customer Name</th><td><?php echo $customer_name; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
                        <?php
						$qry="select * from `customer_reg` where `id`='".$allrows[$i]['customer_reg_name']."'";
						$data_base_object = new DataBaseConnect();
						$result= $data_base_object->execute_query_return($qry);
						$row=mysql_fetch_array($result);
						$customer_name=$row['name'];
						?>
						<td> <?php echo $customer_name; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Detail Number</th><td><?php echo $row1['detail_number']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['detail_number']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Driver Name</th><td><?php echo $row1['driver_reg_driver_id']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['driver_reg_driver_id']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Opening KM.</th><td><?php echo $row1['opening_km']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['opening_km']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Opening Time</th><td><?php echo $row1['opening_time']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['opening_time']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Closing KM.</th><td><?php echo $row1['closing_km']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['closing_km']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Closing Time</th><td><?php echo $row1['closing_time']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['closing_time']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Date From</th><td><?php echo $row1['date_from']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['date_from']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Date To</th><td><?php echo $row1['date_to']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['date_to']; ?> </td>
						<?php
						}
						?>
						</tr>		
						<tr><th>Extra Charge</th><td><?php echo $row1['extra_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['extra_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Permit Charge</th><td><?php echo $row1['permit_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['permit_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Parking Charge</th><td><?php echo $row1['parking_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['parking_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Other State Charge</th><td><?php echo $row1['otherstate_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['otherstate_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Guide Charge</th><td><?php echo $row1['guide_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['guide_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Miscellaneous Charge</th><td><?php echo $row1['misc_chg']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['misc_chg']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Remarks</th><td><?php echo $row1['remarks']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['remarks']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Billed Complementry</th><td><?php echo $row1['billed_complimentary']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['billed_complimentary']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Authorized Person</th><td><?php echo $row1['authorized_person']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['authorized_person']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Date Authorization</th><td><?php echo $row1['date_authorization']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['date_authorization']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Reason</th><td><?php echo $row1['reason']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['reason']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Status</th><td><?php echo $row1['status']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['status']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Total KM</th><td><?php echo $row1['total_km']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['total_km']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Rate</th><td><?php echo $row1['rate']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['rate']; ?> </td>
						<?php
						}
						?>
						</tr>
						<tr><th>Amount</th><td><?php echo $row1['amount']; ?></td>
						<?php 
						for($i=0;$i<$total_rows;$i++)
						{
						?>
						<td> <?php echo $allrows[$i]['amount']; ?> </td>
						<?php
						}
						?>
						</tr>
						</table>
						<br /><br />
						<?php
					}
				}
				else
				{
					?>
     <form action="duty_slip_update.php?mode=view" name="form_name"  method="post">
               <table width="100%" >
              <tr><td width="25%"> Duty Slip Id : </td>
              <td width="22%"> <input type="text" name="dutyslip_id"  class="m-wrap medium"/></td>
              <td ><button type="submit" value="Submit" class="btn green" style="margin-top:-2%"  name="ledger_reg"><i class="icon-ok"></i> Submit</button></td>
              </tr>
                </table>
              </form>  
               <?php
	}
	?>
    </div>
    </div>
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