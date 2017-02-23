<?php 

require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `duty_slip` where `id`='".$idd."'";
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
    	<form name="add_form" class="form-horizontal" action="Handler.php" method="post">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>DutySlip Edit</h4>
        </div>
        <div class="portlet-body form">
        
        <div class="control-group">
        <label class="control-label">DutySlip ID</label>
        <div class="controls">
        <input type="text" disabled value="<?php echo $idd; ?>" class="span6 m-wrap" />
        <?php
		if($row_data['waveoff_status']==1)
		{
			?>
            <p><strong>Waveoff DS</strong></p> 
            <?php
		}
		?>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Customer Name</label>
        <div class="controls">
        <select name="customer_id" id="customer_id" class="span6 m-wrap chosen" >	
        <option value="">---select customer---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from customer_reg");
        while($row=mysql_fetch_array($result))
        {
        if($row_data['customer_id']==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
        else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Guest Name</label>
        <div class="controls">
        <input type="text" name="guest_name" value="<?php echo $row_data['guest_name']; ?>" class="span6 m-wrap" />
        </div>
        </div>
        
       
        <div class="control-group">
        <label class="control-label">Mobile Number</label>
        <div class="controls">
        <input type="text" name="mobile_no" id="mobileno" value="<?php echo $row_data['mobile_no']; ?>" class="span6 m-wrap" />
     	</div>
        </div>

        <div class="control-group">
        <label class="control-label">Email Address</label>
        <div class="controls">
        <input type="text" name="email_id" id="email_id" value="<?php echo $row_data['email_id']; ?>" class="span6 m-wrap" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Photo ID</label>
        <div class="controls">
        <select name="photo_id" class="span6 m-wrap">
        <option value="">---select photo ID---</option>
        <option value="Passport Number" <?php if($row_data['photo_id']=='Passport Number'){ ?> selected <?php } ?>>Passport Number</option>
        <option value="Driving Licence" <?php if($row_data['photo_id']=='Driving Licence'){ ?> selected <?php } ?>>Driving Licence</option>
        <option value="EC Card" <?php if($row_data['photo_id']=='EC Card'){ ?> selected <?php } ?> >EC Card</option>
        <option value="Pan Card" <?php if($row_data['photo_id']=='Pan Card'){ ?> selected <?php } ?> >Pan Card</option>
        <option value="Others" <?php if($row_data['photo_id']=='Others'){ ?> selected <?php } ?> >Others</option>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Detail Number</label>
        <div class="controls">
        <input type="text" name="detail_no" value="<?php echo $row_data['detail_no']; ?>" class="span6 m-wrap">
      	</div>
        </div>
        
		<div class="control-group">
        <label class="control-label">Car</label>
        <div class="controls">
        <select name="car_type_id" id="car_type_id" class="span6 m-wrap chosen" >	
	    <option value="">---select car---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_type");
        while($row=mysql_fetch_array($result))
        {
		if($row['id']==$row_data['car_type_id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
     	<div class="control-group">
        <label class="control-label">Car Number</label>
        <div class="controls">
        <select name="car_id" class="span6 m-wrap chosen" onChange="cheak();">	
	    <option value="">---select car no---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_reg");
        while($row=mysql_fetch_array($result))
        {
		if($row['id']==$row_data['car_id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
	    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        <span id="will_be">
        <?php
		if(!empty($row_data['temp_car_no']))
		{?>
        <input type='text' placeholder='Enter car number' required class='m-wrap medium' name='temp_car_no' value='<?php echo $row_data['temp_car_no']; ?>'>
        <?php
		}
		?>
        </span>
        </div>
        </div>
		
		
        <div class="control-group">
        <label class="control-label">Service</label>
        <div class="controls">
        <select name="service_id" id="service_id" class="span6 m-wrap chosen" >	
	    <option value="">---select service---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from service");
        while($row=mysql_fetch_array($result))
        {
		if($row['id']==$row_data['service_id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Driver Name</label>
        <div class="controls">
        <select name="driver_id" class="span6 m-wrap chosen" onChange="cheak_driver();">	
	    <option value="">---select driver---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from driver_reg");
        while($row=mysql_fetch_array($result))
        {
		if($row['id']==$row_data['driver_id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
	    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
         <span id="will_be_driver">
        <?php
		if(!empty($row_data['temp_driver_name']))
		{?>
        <input type='text' placeholder='Enter driver name' required class='m-wrap medium' name='temp_driver_name' value='<?php echo $row_data['temp_driver_name']; ?>'>
        <?php
		}
		?>
        </span>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Rate</label>
        <div class="controls">
        <input type="text" name="rate" value="<?php echo $row_data['rate']; ?>" autocomplete="off" onKeyUp="allLetter(this.value,this.id)" id="rate" onMouseDown="fetch_rate('get_rate');" class="span6 m-wrap" />
        </div>
        </div>
        
      
        <div class="control-group">
        <label class="control-label">Opening KM</label>
        <div class="controls">
        <input type="text" name="opening_km" id="opening_km" value="<?php echo $row_data['opening_km']; ?>" autocomplete="off"  class="span6 m-wrap" />
        </div>
        </div>
        
         <div class="control-group">
        <label class="control-label">Closing KM</label>
        <div class="controls">
        <input type="text" name="closing_km" id="closing_km" value="<?php echo $row_data['closing_km']; ?>" class="span6 m-wrap"  onkeyup="validateCKMS()"/>
        </div>
        </div>
        
         <div class="control-group">
        <label class="control-label">Opening Time</label>
        <div class="controls">
        <select name="opening_time_hh" class="span3 m-wrap">
						<?php 
     						$hh= substr($row_data['opening_time'], 0,2);
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
					<select name="opening_time_mm" class="span3 m-wrap">
						<?php 
 						$mm= substr($row_data['opening_time'], 3,2);
							for ($i = 0; $i <=60; $i++) {
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
        </div>
        </div>
     
         
        <div class="control-group">
        <label class="control-label">Closing Time</label>
        <div class="controls">
        <select name="closing_time_hh" class="span3 m-wrap">
						<?php 
							$hh= substr($row_data['closing_time'], 0,2);
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
					<select name="closing_time_mm" class="span3 m-wrap">
						<?php 
							$mm= substr($row_data['closing_time'], 3,2);
							for ($i = 0; $i <=60; $i++) {
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
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Travel Date From</label>
        <div class="controls">
        <input class="span6 m-wrap date-picker" value="<?php echo dateforview($row_data['date_from']); ?>" onClick="mydatepick();" type="text" name="date_from" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Travel Date To</label>
        <div class="controls">
        <input class="span6 m-wrap date-picker" value="<?php echo dateforview($row_data['date_to']); ?>" onClick="mydatepick();" type="text" name="date_to" />
        </div>
        </div>
        
       
        <div class="control-group">
        <label class="control-label">Toll Tax</label>
        <div class="controls">
        <input class="span6 m-wrap" type="text" value="<?php echo $row_data['extra_chg']; ?>" name="extra_chg" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Permit Charges</label>
        <div class="controls">
        <input class="span6 m-wrap"  type="text" value="<?php echo $row_data['permit_chg']; ?>" name="permit_chg" />
        </div>
        </div>
        
       
        <div class="control-group">
        <label class="control-label">Parking Charges</label>
        <div class="controls">
        <input type="text" value="<?php echo $row_data['parking_chg']; ?>" class="span6 m-wrap"  name="parking_chg" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Driver Allowance</label>
        <div class="controls">
        <input type="text" value="<?php echo $row_data['otherstate_chg']; ?>" class="span6 m-wrap"  name="otherstate_chg" />
        </div>
        </div>
        
       
    	<div class="control-group">
        <label class="control-label">Border Tax</label>
        <div class="controls">
        <input type="text" name="guide_chg"  value="<?php echo $row_data['guide_chg']; ?>" class="span6 m-wrap" />
        </div>
        </div>
        
        
        <div class="control-group">
        <label class="control-label">Miscellaneous Charges</label>
        <div class="controls">
         <input type="text" name="misc_chg" class="span6 m-wrap"  value="<?php echo $row_data['misc_chg']; ?>"/>
        </div>
        </div>
        
        
        <div class="control-group">
        <label class="control-label">Authorized person</label>
        <div class="controls">
         <input type="text" name="auth_person" class="span6 m-wrap" disabled  value="<?php if(!empty($row_data['login_id'])) { echo fetchusername($row_data['login_id']); } else { echo $row_data['authorized_person']; } ?>"/>
        </div>
        </div>
        
		 <div class="control-group">
        <label class="control-label">Remarks</label>
        <div class="controls">
        <input type="text" name="remarks"  class="span6 m-wrap" value="<?php echo $row_data['remarks']; ?>"/>
        </div>
        </div>
       
         <div class="control-group">
        <label class="control-label">Reason</label>
        <div class="controls">
        <input type="text" name="reason"  class="span6 m-wrap" value="<?php echo $row_data['reason']; ?>"/>
        </div>
        </div>
        <?php if($_SESSION['id']=='1' ||$_SESSION['id']=='5') { ?>
        <div class="control-group">
        <label class="control-label">Creation Date</label>
        <div class="controls">
        <input class="span6 m-wrap date-picker" value="<?php echo dateforview($row_data['date']); ?>"  type="text" name="date" />
        </div>
        </div>
        <?php }
		else { ?>
        <input class="span6 m-wrap date-picker" value="<?php echo dateforview($row_data['date']); ?>"  type="hidden" name="date" />
        <?php }?>
        <div class="form-actions">
        <button type="submit"  class="btn green" name="update_dutyslip"/><i class="icon-question-sign"></i> Save Change</button>
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