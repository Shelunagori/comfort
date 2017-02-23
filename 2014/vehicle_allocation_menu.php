<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
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
     <?php menu(); ?>
     <form method="post" name="form_name">
<div>      
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '7' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($view_status==1)
	{    
	?>                  
<a href="vehicle_allocation_menu.php" class="btn red"><i class="icon-edit"></i> Search</a>
<a href="pdf_codes/myex.php?tab=vehicle_allocation" class="btn blue"><i class="icon-download-alt"></i> Pdf Download</a>
<?php
	}
?>
</div> 
<br />
<?php
	if($view_status==1)
	{
		?>
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-truck"></i>Vehicle Allocation</h4>
                    </div>
                    <div class="portlet-body form">
                      <table width="100%">
						 <tr><td> Travel Date From : </td><td><input type="text" class="m-wrap medium" id="dp1" name="travel_from"  /> </td></tr>
						 <tr><td> Travel Date To : </td><td><input type="text" name="travel_to" class="m-wrap medium" id="dp2"/> <button type="submit" style="margin-left:2%" class="btn green" name="vehicle_allocation"><i class="icon-search"></i> Search</button></td></tr>
						 <tr><td></td><td>&nbsp;</td></tr>
						 </table>
                         <br />
                   	<?php
				if(isset($_POST['vehicle_allocation']))
				{
					?> 
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%" class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th >Booking Person Name</th>
                        <th >Customer Name</th>
                        <th >Booked From</th>
                        <th >Booked To</th>
                        <th >Travel Place</th>
                        <th >Name Car</th>
                        <th >Cars</th>
                        <th >View</th>
                        </tr>
                    </thead>
                    	<tbody>
                    <?php           
				$q4="";$q5="";
				if(!empty($_POST['travel_from']))
				{
					$q4=DateExact($_POST['travel_from']);
				}
				if(!empty($_POST['travel_to']))
				{
					$q5=DateExact($_POST['travel_to']);
				}

				if($q4=="" && $q5=="")
				{
					$qry="select * from booking";
				}
				else if($q4!="" && $q5=="")
				{
					$qry="select * from booking where travel_from>= '".$q4."'";
				}
				else if($q4=="" && $q5!="")
				{
					$qry="select * from booking where travel_to>='".$q5."'";
				}
				else 
				{
					$qry="select * from booking where travel_from>= '".$q4."' and travel_to>='".$q4."'";
				}
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
                        	$result2= $data_base_object->execute_query_return("select * from booking_car where booking_id=".$idd);
                        	$myrow=mysql_fetch_array($result2);
							$booked_by=$row['booked_by'];
							$customer_reg_name=$row['customer_reg_name'];
							$qry_booking="select * from `customer_reg` where `id`='$customer_reg_name'";
							$data_base_object = new DataBaseConnect();
							$result_booking= $data_base_object->execute_query_return($qry_booking);
							$row_booking=mysql_fetch_array($result_booking);
							$customer_name=$row_booking['name'];
							$travel_from=$row['travel_from'];
							$travel_to=$row['travel_to'];
                            $service_id=$row['service_id'];
							$qry_service="select * from `service` where `service_id`='$service_id'";
							$result_service = $data_base_object->execute_query_return($qry_service);
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
                            $car_name = $myrow['carname_master'];
							$qry_car="select * from `carname_master` where `id`='$car_name'";
							$result_car = $data_base_object->execute_query_return($qry_car);
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];
                            $vehicle = $myrow['vehicle'];
                       ?>
						
                            <tr>
                            <td><?php echo $booked_by;?></td>
                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $travel_from;?></td>
                            <td><?php echo $travel_to;?></td>
                            <td><?php echo $service_name;?></td>
                            <td><?php echo $car_name;?></td>
                            <td><?php echo $vehicle;?></td>
                            <td>
                            <a class="btn mini red"  role="button" href="view_vehicle_allocation.php?booking=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                              <?php }?>
                              </tr>
                               
                       <?php  }
                        $data_base_object->close_connection();
                        }   
						?>  
                        </tbody>
                        </table>	
                         </div>   
	                   </div>
                     </div> 
                      <?php
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