<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
 if(isset($_POST['booking_update_info']))
{
	$pick_up_time = $_POST['pickup_time_hh'].":".$_POST['pickup_time_mm'].":00";
	$data_base_connect_object =new DataBaseConnect();
	$id=$_POST['id'];
	$query = "update `booking` set `travel_from`='".DateExact($_POST['travel_from'])."' , `travel_to`='".DateExact($_POST['travel_to'])."' ,
	  `service_id`='".$_POST['service_id']."',
	  `flight_no`='".$_POST['flight_no']."', `pickup_time`='".$pick_up_time."',
	  `pickup_from`='".$_POST['pickup_from']."', `drop_to`='".$_POST['drop_to']."' where id=".$id; 	
		$data_base_connect_object->execute_query_update_booking($query,$_POST['carname_master_id'],$_POST['vehicle'],$_POST['id']);		
}
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
<!--<div>                     
<a href="booking_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="booking_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="booking_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="booking_menu_search.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Update</h4>
                     </div>
                     <div class="portlet-body form">
                	<?php
				if(isset($_GET['id']))
				{
					$id= $_GET['id'];
                  	$qry="select * from booking where id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$travel_from=$row['travel_from'];
							$travel_to=$row['travel_to'];
                            $service_id=$row['service_id'];
                            $flight_no=$row['flight_no'];
                            $pickup_time=$row['pickup_time'];
                            $pickup_from=$row['pickup_from'];
                            $drop_to=$row['drop_to'];
                        }
                       $data_base_object->close_connection();
                 ?>
                <table width="100%">
		        <tr><td> Travel Date From </td><td><input id="dp1" class="m-wrap medium"  type="text" name="travel_from" value="<?php echo $travel_from;?>"/> </td></tr>
				<tr><td> Travel Date To </td><td><input id="dp2" type="text" class="m-wrap medium" name="travel_to" value="<?php echo $travel_to;?>"/> </td></tr>
				<tr><td> Service: </td><td>
				<select name="service_id" class="chosen">
					<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							if($row['service_id']==$service_id)
								echo "<option value=\"".$row['service_id']."\" selected=selected>".$row['name']."</option>";
							else
								echo  "<option value=\"".$row['service_id']."\">".$row['name']."</option>";
						}
					?>
				</select>
				</td></tr>
				<tr><td> Car: </td><td>
				<select name="carname_master_id" class="chosen">
					<?php
						$data_from_booking_car = $mydatabase->execute_query_return("select * from booking_car where booking_id=".$id);
						$roww= mysql_fetch_array($data_from_booking_car);
							$car_name = $roww['carname_master']; 
							$vehicle=$roww['vehicle'];
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							if($row['id']==$car_name)
							 echo '<option value="'.$row['id'].'" selected=\"selected\">'.$row['name'].'</option>';
							else
								 echo '<option value="'.$row['id'].'" >'.$row['name'].'</option>';
						}
						$mydatabase->close_connection();
					?> 
					</select>
				</td></tr>
				<tr><td> Number of Cars: </td><td>
					<input type="text" name="vehicle" class="m-wrap medium" value="<?php echo  $vehicle;?>" /> 
				</td></tr>
				<tr><td> Flight Number: </td><td><input type="text"  class="m-wrap medium" name="flight_no" value="<?php echo  $flight_no;?>"/> </td></tr>
				<tr><td> PickUp Time: </td>
					<td>
				<select name="pickup_time_hh" style="width: 50px;">
						<?php 
						$hh= substr($pickup_time, 0,2);
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									if($hh=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($hh==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
									
							}
						?>
					</select>
					<select name="pickup_time_mm" style="width: 50px;">
						<?php 
						$mm= substr($pickup_time, 3,2);
							for ($i = 1; $i <=60; $i++) {
								if($i<10)
									if($mm=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($mm==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select> 
				</td>
				</tr>
				<tr><td> PickUp Place: </td><td><input type="text"  class="m-wrap medium" name="pickup_from" value="<?php echo  $pickup_from;?>"/> </td></tr>
				<tr><td> Drop Place: </td><td> <input type="text"  class="m-wrap medium" name="drop_to" value="<?php echo  $drop_to;?>"/></td></tr>
				<tr><td></td><td></td></tr>
                </table>
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                <div class="form-actions">
                <button type="submit" style="margin-left:25%" class="btn green"  name="booking_update_info"><i class="icon-question-sign"></i> Save Change</button>
                </div>
                <?php }?>
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