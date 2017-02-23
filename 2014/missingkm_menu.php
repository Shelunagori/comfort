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
                     <?php
	if(isset($_GET['mode']))
				{
					if($_GET['mode']=='view')
					{
						$p1=$p2=$p3="";
						if(!empty($_POST['car_no']))
							{
							$p1=" AND car_reg_name='".$_POST['car_no']."'";
							}
						if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
							{
								$p2=" AND  `current_date` between '".DateExact($_POST['date_from'])."' and  '".DateExact($_POST['date_to'])."' ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
							}
						if(!empty($_POST['car_no']))
							{
							$p1=" AND car_reg_name='".$_POST['car_no']."'";
							if($p2=="")
								{
									$p1=" AND car_reg_name='".$_POST['car_no']."' ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
								}
							}
						if($p1=="" AND $p2=="")
							{
								$p3=" ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
							}
					$mydatabase = new DataBaseConnect();
						
						$result= $mydatabase->execute_query_return("select * from `duty_slip` where (1=1)$p1$p2$p3");
						?>
					<?php $row=mysql_fetch_array($result);
					
					$temp=0; $tt=0; $i=0; $tot=0; $ch=$k=0;
					?>
					
					<br/>
					
						
						<?php
						$car_no="";
						while($row=mysql_fetch_array($result))
						{
						$carname_master_id =  $row['carname_master_id'];
						$car_reg_name =  $row['car_reg_name'];
							
						$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
						$data_base_object = new DataBaseConnect();
						$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
						$row_carid = mysql_fetch_array($result_carid);
						$car_reg_name_new=$row_carid['name'];
						
					    $qry_carname="select * from `carname_master` where `id`='$carname_master_id'";
						$data_base_object = new DataBaseConnect();
						$result_car = $data_base_object->execute_query_return($qry_carname);
						$row_car=mysql_fetch_array($result_car);
						$car_name=$row_car['name'];			
							if($row['car_reg_name']!=$car_no)
								{ 
								if($ch != 0)
								{
								?>
									</table>
								<?php
									} 
								
							?>
                      <a class="btn green displaynone" style="float:right;"  href="excel_all.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&car_no=<?php echo $_POST['car_no']; ?>&type=missing" target="_blank"><i class="icon-download-alt"></i> Export in Excel</a>
                             
					<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px;margin-top:4%">
						<tr><td colspan="8" style="text-align:center;"><b>Report of Missing Km.</b></td></tr>
						<tr><td colspan="8" style="text-align:center;"><b>Car No. </b><?php echo $car_reg_name_new?></td></tr>
						<tr><td colspan="8" style="text-align:center;"><b>Car Name </b><?php echo $car_name;?></td></tr>
						<tr>
						<th>Sr. No.</th>
						<th>Driver Name</th>
						
						<th>Date</th>
						<th>Closing KM.</th>
							<th>Driver Name</th>
						<th>Date</th>
						<th>Opening KM.</th>
							
						<th>Missing KM.</th>
						</tr>
						
							
							<?php $ch++;	
									
						$car_no=$row['car_reg_name'];
						$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
						$data_base_object_driver = new DataBaseConnect();
						$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
						$row_driver=mysql_fetch_array($result_driver);
						$driver_name_main=$row_driver['name'];		
							}
						
							if($tt==0)
								{
								$temp_t=$row['closing_km'];
								 $date_close_t=date("d-M-Y", strtotime($row['current_date']));
								$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
								$data_base_object_driver = new DataBaseConnect();
								$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
								$row_driver=mysql_fetch_array($result_driver);
								$driver_name_main_t=$row_driver['name'];	
								$driver_close_t =  $driver_name_main_t;
								$tt++;
								}
							else
								{
								 $tot=$row['opening_km']-$temp_t;
								
								$temp=$row['closing_km'];
								 $date_close=date("d-M-Y", strtotime($row['current_date']));
								 	$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
								$data_base_object_driver = new DataBaseConnect();
								$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
								$row_driver=mysql_fetch_array($result_driver);
								$driver_name_main_close=$row_driver['name'];	
								$driver_close =  $driver_name_main_close;
								}
							if($tot != 0)
								{
								
							$i++;
						?>
						<tr>
						
						<td><?php echo $i;?></td>			
						<td><?php echo $driver_close_t;?></td>
						<td><?php echo $date_close_t; ?></td>
						<td><?php echo $temp_t;?></td>
							<td><?php echo $driver_close; ?></td>
						<td><?php echo date("d-M-Y", strtotime($row['current_date']));?></td>
						<td><?php echo $row['opening_km'];?></td>
						
						<td><?php 
							
								echo $tot;
								
						
							?></td>
						</tr>				
						<?php
								$temp_t=$temp;
								$date_close_t=$date_close;
								$driver_close_t=$driver_close;
								}
						}
						?>
						</table>
						<?php
					}
				}
				else
				{
					?>
     <form method="post" action="missingkm_menu.php?mode=view" name="form_name">
               <table width="100%">
              	<tr><td> Date From</td><td><input type="text" name="date_from"  id="dp1" class="m-wrap medium"/></td></tr>
				<tr><td> Date To</td><td><input type="text" name="date_to" id="dp2"  class="m-wrap medium"/></td></tr>
              	<tr><td> Car No. </td><td>  <select name="car_no" class="chosen">	
						<option value="">Select Type</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from car_reg");
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=".$row['car_id'].">".$row['name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select> <button type="submit" class="btn green" value="Submit" style="margin-left:1%; margin-top:-3% !important"  name="ledger_reg">Go <i class="icon-circle-arrow-right"></i></button></td></tr>
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