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
          <a class="btn green diplaynone" href="ntclskm_menu_all.php"  role="button"  style="text-decoration:none; margin-top:1%;"><i class="icon-table"></i> View All</a>
          <?php
		  if(!empty($_POST['duty_slip_customer_reg_name']))
		  {
			  ?>
          <a class="btn green diplaynone"  role="button"  href="javascript:window.print();" style="text-decoration:none; margin-top:1%;"><i class="icon-print"></i>Print</a>
          <?php
		  }
		  ?>
     <?php menu(); ?>
      <?php
	if(isset($_GET['mode']))
				{
					if($_GET['mode']=='view')
					{
			$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip` where `customer_reg_name`='".$_POST['duty_slip_customer_reg_name']."' && `closing_km`='0'   ORDER BY `current_date` ASC");
				$i=0;
						?>
						<table  width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px">
                        <thead>
							<tr><td colspan="8" align="center"><b>Report of Open DS. dated on <?php echo date("d-M-Y") ?></b></td></tr>
						<tr>
                        <th>Sr. No.</th>
                        <th>Duty Slip No.</th>
						<th>Car No.</th>
						<!--<th>Car Name</th>-->
						<th>Service Name</th>
						<th>Customer Name</th>
						<th>Date</th>
						<th>Opening KM.</th>
						<th>Closing KM.</th>
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
						while($row=mysql_fetch_array($result))
						{
						 $i++;
						$dutyslip_id =  $row['dutyslip_id'];
						
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
	
						
						$service_service_id = $row['service_service_id'];
						$qry="select * from `service` where `service_id`='$service_service_id'";
						$data_base_object1 = new DataBaseConnect();
						$result_service = $data_base_object1->execute_query_return($qry);
						$row_service=mysql_fetch_array($result_service);
						$service_name=$row_service['name'];
						
						$customer_reg_name =$row['customer_reg_name'];
						$qry_cust="select * from `customer_reg` where `id`='$customer_reg_name'";
						$result_cust = $data_base_object->execute_query_return($qry_cust);
						$row_customer=mysql_fetch_array($result_cust);
						$customer_name=$row_customer['name'];
						$opening_km = $row['opening_km'];
						$closing_km =$row['closing_km'];
						?>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['dutyslip_id'];?></td>
						<td><?php echo $car_reg_name_new;?></td>
						<!--<td><?php // echo $row['carname_master_id'];?></td>-->					
						<td><?php echo $service_name ?></td>
						<td><?php echo $customer_name?></td>
						<td><?php echo date("d-M-Y", strtotime($row['current_date']));?></td>
						<td><?php echo $row['opening_km'];?></td>
						<td><?php echo $row['closing_km'];?></td>
						</tr>				
						<?php
						}
						?>
                        </tbody>
						</table>
                        <?php
					}
				}
						else
				{
					?>
     <form method="post" action="ntclskm_menu.php?mode=view" name="form_name">
               <table width="100%">
              	<tr><td> Customer Name. </td><td><select name="duty_slip_customer_reg_name"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$row['id'].'">'.$name.'</option>';
									}
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>