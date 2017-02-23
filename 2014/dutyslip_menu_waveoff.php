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
<script type="text/javascript">
function WaveOff(id)
{
	var reason=prompt("Reason for waveoff ?","");	
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			if(ajaxRequest.responseText=="completed")
			{
				location.reload();
			}
			else
			{
				alert("Problem");
			}
		}
	}

		
		ajaxRequest.open("GET", "get_teriff_rate.php?waveoff="+id+"&reason="+reason, true);
		ajaxRequest.send(null);
}
</script>
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
     <form method="post">
<!--<div>                     
<a href="dutyslip_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="dutyslip_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="dutyslip_menu_edit_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
<a href="dutyslip_menu_waveoff.php" class="btn red"><i class="icon-bar-chart"></i> Waveoff</a>
<a href="dutyslip_menu_print.php" class="btn blue"><i class="icon-print"></i> Print</a>
</div> -->
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-bar-chart"></i>Waveoff</h4>
                     </div>
                     <div class="portlet-body form">
                    <?php
			             $mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip_waveoff`");
						?>
						<table class="table table-bordered table-hover" width="100%" id="sample_1" style="border-collapse:collapse">
                        <thead>
						<tr>
                        <th>Duty Slip No.</th>
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
                        if($result)
                        {
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
							$qry="select * from `service` where `service_id`='$service_service_id'";
							$data_base_object = new DataBaseConnect();
							$result_service= $data_base_object->execute_query_return($qry);
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
							$carname_master_id=$row['carname_master_id'];
							$qry="select * from `carname_master` where `id`='$carname_master_id'";
							$data_base_object = new DataBaseConnect();
							$result_car = $data_base_object->execute_query_return($qry);
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];
							$car_reg_name=$row['car_reg_name'];
                            $opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $status=$row['status'];
                            $reason=$row['reason'];
						?>
						
                        <td><a href="update_dutyslip.php?id=<?php echo $row['dutyslip_id'];?>" target="_new" ><b><?php echo $row['dutyslip_id'];?></b></a></td>
                         <td><?php echo $cust_name;?></td>
                        <td><?php echo $billing_name;?></td>
                        <td><?php echo $service_name;?></td>
                        <td><?php echo $car_name;?></td>
                        <td><?php echo $car_reg_name;?></td>
                        <td><?php echo date("d-M-Y", strtotime($current_date));?></td>
                        <td><?php echo $opening_km;?></td>
                        <td><?php echo $closing_km;?></td>
                         <td><?php echo $reason;?></td>
										
						<?php
						
						?>
                        </tr>
                        <?php
						}}
						?>
                        </tbody>
						</table>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>