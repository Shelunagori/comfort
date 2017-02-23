<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `booking` where `id`='".$idd."'";
$result=mysql_query($sql);
$row_data = mysql_fetch_array($result);
$num=mysql_num_rows($result);
if($num==0)
{
	echo "<script>alert('Entry not found in database.');window.close();</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title><?php title(); ?></title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
	<?php logo(); ?>
    <?php css(); ?>
    <?php ajax(); ?>
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
     <?php temp(); ?>
    	<form name="form_name" action="Handler.php" method="post">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Booking Edit</h4>
        </div>
        <div class="portlet-body form">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
            <tr>
            <td>Customer Name</td>
            <td>   
            <select name="customer_id"  class="m-wrap medium">
            <option value="">---select customer---</option>
            <?php
            $result=mysql_query("select distinct `id`,`name` from customer_reg");
            while($row= mysql_fetch_array($result))
            {
			if($row_data['customer_id']==$row['id'])	
            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			else
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>
            </td>
            <td>Customer Mobile No.</td>
            <td><input type="text" class="m-wrap medium" id="mobileno" value="<?php echo $row_data['mobile_no']; ?>" name="mobile_no" /></td>
            </tr>
            
            <tr>
            <td> Guest Name:</td><td><input type="text" name="guest_name" value="<?php echo $row_data['guest_name']; ?>" class="m-wrap medium"/> </td>
            <td> Guest Mobile Number:</td><td><input type="text" name="guest_mobile_no"  value="<?php echo $row_data['guest_mobile_no']; ?>" class="m-wrap medium"/> </td>
            </tr>
            
            <tr>
            <td> Travel Date From </td><td><input type="text" class="m-wrap medium date-picker" value="<?php echo dateforview($row_data['travel_from']); ?>" onClick="mydatepick();" name="travel_from" /> </td>
            <td> Travel Date To </td><td><input type="text"  class="m-wrap medium date-picker" value="<?php echo dateforview($row_data['travel_to']); ?>"  onClick="mydatepick();" name="travel_to" /> </td>
            </tr>	
            
            <tr>
            <td> Service: </td>
            <td><select name="service_id" class="m-wrap medium">
            <option value="">---select service---</option>
            <?php 
            $result=mysql_query("select distinct id,name from service");
            while($row=mysql_fetch_array($result))
            {
			if($row['id']==$row_data['service_id'])	
            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			else
	        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
            </select></td>
            <td> Car: </td>
            <td>
            <select name="car_type_id" class="m-wrap medium">
            <option value="">---select car---</option>
            <?php 
            $result=mysql_query("select distinct id,name from car_type");
            while($row=mysql_fetch_array($result))
            {
			if($row['id']==$row_data['car_type_id'])		
            echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
			else
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?> 
            </select>
            </td></tr>
            
            <tr><td> Number of Cars: </td>
            <td>
            <input type="text" name="no_of_car" id="no_of_car" value="<?php echo $row_data['no_of_car']; ?>" onKeyUp="allLetter(this.value,this.id);" class="m-wrap medium" /> 
            </td>
            <td> Flight Number: </td>
            <td><input type="text" class="m-wrap medium" name="flight_no" value="<?php echo $row_data['flight_no']; ?>"/> </td>
            </tr>
                    
           <tr>
           <td> PickUp Time: </td>
                        <td>
                        <select name="pickup_time_hh" class="span3 m-wrap">
                            <?php 
								$hh= substr($row_data['pickup_time'], 0,2);
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
                        <select name="pickup_time_mm" class="span3 m-wrap">
                            <?php 
								$mm= substr($row_data['pickup_time'], 3,2);
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
           <td> PickUp Place: </td><td><input type="text" class="m-wrap medium" name="pickup_place" value="<?php echo $row_data['pickup_place']; ?>"/> </td>
           </tr>      
           <tr>
           <td>Drop Place</td>
           <td><input type="text" class="m-wrap medium" name="drop_place" value="<?php echo $row_data['drop_place']; ?>"/></td>
           <td>Remarks</td>
           <td><textarea rows="2" name="remarks" style="resize:none;" class="m-wrap medium"><?php echo $row_data['remarks']; ?></textarea>
           </td>
           </tr>
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_booking"/><i class="icon-question-sign"></i> Save Change</button>
       	<button type="button"  class="btn yellow" name="reset" onClick="javascript:;window.close();"/><i class="icon-remove"></i> Close</button>
        </div>
        </div>
        </div> 
       <input type="hidden" name="myid" value="<?php echo $idd; ?>" />
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