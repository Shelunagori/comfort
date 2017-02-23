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
     <?php menu(); ?>
     <form  name="form_name" method="post">
      <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-inbox"></i>Total KM Report</h4>
                    </div>
                    <div class="portlet-body form">
                  <table width="100%">
		           <tr><td> Car Number</td><td><input type="text" name="car_number" class="m-wrap medium" id="autocomplete_car_name" /></td></tr>
              	<tr><td> Date From</td><td><input type="text" name="date_from" class="m-wrap medium" id="dp1"/></td></tr>
				<tr><td> Date To</td><td><input type="text" name="date_to"  class="m-wrap medium"  id="dp2"/><button type="submit" style="margin-left:1%;"  class="btn green" name="ledger_reg" />Go <i class="icon-circle-arrow-right"></i></button></td></tr>
				<tr><td></td><td></td></tr>
                </table>
                <?php
                    if(isset($_POST['ledger_reg']))
					{
					$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `fuel`
						 where `car_number`='".$_POST['car_number']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."'  ORDER BY `date`");
						?>
						<table  width="100%" style="border-collapse:collapse">
						<tr>
						<th>Supplier Name</th>
						<th>Date</th>
						<th>Car Number</th>
						<th>Previous Reading</th>
						<th>Current Reading</th>
						<th>Fuel Qty.</th>
						<th>Fuel Amount</th>
						</tr>
						<?php
						$toal_amount=0;
						$fuel_qty=0;
						$opening_start=0;
						$closing_km=0;
						while($row=mysql_fetch_array($result))
						{
							?>
							<tr align="center">
							<td><?php echo $row['supplier_name'];?></td>
							<td><?php echo DisplayDate($row['date']);?></td>						
							<td><?php echo $row['car_number'];?></td>
							<td><?php echo $row['opening_km'];?></td>
							<td><?php echo $row['closing_km'];?></td>
							<td><?php echo $row['fuel_qty'];?></td>
							<td><?php echo $row['fuel_amount'];?></td>
							<?php 
							if($opening_start==0)
							{
								$opening_start=$row['opening_km'];
							}
							$fuel_qty+=$row['fuel_qty'];
							$toal_amount+=$row['fuel_amount'];
							$closing_km=$row['closing_km'];
							?>
							</tr>				
							<?php
						}
						?>
						<tr  align="center">
						<th colspan="3"> Total :</th>
						<td colspan="2"><?php echo ($closing_km-$opening_start);?></td>
						<td><?php echo $fuel_qty;?></td>
						<td><?php echo $toal_amount;?></td>
						</tr>
						<tr align="center">
						<th colspan="6" > Average :</th>
						
						<td><?php
						if($fuel_qty!=0)
							echo ($closing_km-$opening_start)/$fuel_qty;
						else 
							echo ($closing_km-$opening_start);
						?></td>
						</tr>
						</table>
						<?php
						$mydatabase->close_connection();
					}
				
   					?>
   
  
   </div></div>
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