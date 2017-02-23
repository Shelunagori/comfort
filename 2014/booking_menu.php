<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
if(isset($_POST['booking']))
{
	session_start();
	$data_base_connect_object =new DataBaseConnect();
	$pick_up_time = $_POST['pickup_time_hh'].":".$_POST['pickup_time_mm'].":00";
	$query = "INSERT INTO `booking` (`current_date`, `time`, `booked_by`, `customer_reg_name`,`customer_mob_number`,`guest_name`,`guest_mob_number`,`travel_from`, `travel_to`,`service_id`, `flight_no`, `pickup_time`, `pickup_from`, `drop_to`,`loginname`,`countername`) 
	VALUES
	('".date('Y-m-d')."',CURTIME(),'".$_POST['booked_by']."',
	 '".$_POST['customer_reg_name']."','".$_POST['customer_mob_number']."','".$_POST['guest_name']."','".$_POST['guest_mob_number']."','".DateExact($_POST['travel_from'])."', '".DateExact($_POST['travel_to'])."',
	  '".$_POST['service_id']."',
	   '".$_POST['flight_no']."',
	    '".$pick_up_time."', '".$_POST['pickup_from']."', '".$_POST['drop_to']."','".$_SESSION['username']."','".$_SESSION['counter']."')";
		$data_base_connect_object->execute_query_update_booking($query,$_POST['carname_master_id'],$_POST['vehicle']);
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('Booking Added SuccessFully .');
		window.location='booking_menu.php';
	</script>
	";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Booking Deleted SuccessFully .');
		window.location='booking_menu.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Booking Infomation Updated Successfully.');
		window.location='booking_menu.php';
	</script>
	";
}
session_start();
if(!isset($_SESSION['login_user']))
{
	header("location:login_page.php");
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
<!--<div>                     
<a href="booking_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<a href="booking_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="booking_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="booking_menu_search.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-bell"></i>Booking</h4>
                    </div>
                    <div class="portlet-body form">
      				     <table width="100%">
             	<tr><td> Customer Name:</td><td>
                 <select name="customer_reg_name"  class="chosen" tabindex="1"  >
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

     </select></td></tr>
             	<tr><td> Customer Mobile Number:</td><td><input type="text" class="m-wrap medium" name="customer_mob_number" /> 
               </td></tr>
              	<tr><td> Guest Name:</td><td><input type="text" name="guest_name" class="m-wrap medium"/> </td></tr>
             	<tr><td> Guest Mobile Number:</td><td><input type="text" name="guest_mob_number" class="m-wrap medium"/> </td></tr>
              	<tr><td>Booking Person Name: </td><td><input type="text" name="booked_by"  class="m-wrap medium"/></td></tr>
				<tr><td> Travel Date From </td><td><input type="text" id="dp1" class="m-wrap medium" name="travel_from" /> </td></tr>
				<tr><td> Travel Date To </td><td><input type="text" id="dp2" class="m-wrap medium" name="travel_to" /> </td></tr>
				<tr><td> Service: </td><td>
				<select name="service_id" class="chosen">
					<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							 echo '<option value="'.$row['service_id'].'">'.$row['name'].'</option>';
						}
					?>
				</select>
				</td></tr>
				<tr><td> Car: </td><td>
				<select name="carname_master_id" class="chosen">
					<?php 
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
						$mydatabase->close_connection();
					?> 
					</select>
				</td></tr>
				<tr><td> Number of Cars: </td><td>
					<input type="text" name="vehicle" class="m-wrap medium" /> 
				</td></tr>
				<tr><td> Flight Number: </td><td><input type="text" class="m-wrap medium" name="flight_no" /> </td></tr>
				<tr><td> PickUp Time: </td>
					<td>
					<select name="pickup_time_hh" style="width: 50px;">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
								echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="pickup_time_mm" style="width: 50px;">
						<?php 
							for ($i = 1; $i <=60; $i++) {
								if($i<10)
								echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					</td>
				</tr>
				<tr><td> PickUp Place: </td><td><input type="text" class="m-wrap medium" name="pickup_from" /> </td></tr>
				<tr><td> Drop Place: </td><td> <input type="text" class="m-wrap medium" name="drop_to" /></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <div class="form-actions">
                     <button type="submit" style="margin-left:33%"   class="btn green" name="booking"/><i class="icon-ok"></i> Submit</button>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>