<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
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
    	<?php
		if(isset($_POST['customer_edit']))
		{
							if(isset($_GET['booking_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Booking Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['booking_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Booking Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i>Booking Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>SL.</th>
                        <th>Booking Person Name</th>
                        <th>Customer Name</th>
                        <th>Booked From</th>
                        <th>Booked To</th>
                        <th>Travel Place</th>
                         <?php
							if(isset($_GET['booking_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['booking_delete']))
							{
								?>
                                 <th>Delete</th>
                                 <?php
							}
							else 
							{
								?>
                                 <th>Edit</th>
                                 <?php
							}
							
							?>
                        </tr>
                    </thead>
                   	<tbody>
                    <?php
				$q1="";	$q2="";	$q3="";	
				if(!empty($_POST['customer_id']))
				{
					$customer_id=$_POST['customer_id'];
					$q1="customer_id='".$customer_id."'";
				}
				if(!empty($_POST['mobile_no']))
				{
					$mobile_no=$_POST['mobile_no'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_no."'";
					else 
						$q2=" AND mobile_no='".$mobile_no."'";
				}
				if(!empty($_POST['login_id']))
				{
					$login_id=$_POST['login_id'];
					if($q1=="" && $q2=="")
						$q3=" login_id='".$login_id."'";
					else 
						$q3=" AND login_id='".$login_id."'";
				}
                if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from booking";
                else    
					$qry="select * from booking where ";
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$customer_id=$row['customer_id'];
							$cust_name=fetchcustomername($customer_id);
							$login_id=$row['login_id'];
							$username=fetchusername($login_id);
							$service_id=$row['service_id'];
							$serve_name=fetchservicename($service_id);
					?>
                      		<tr id="<?php echo $i; ?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $cust_name; ?></td>
                            <td><?php echo dateforview($row['travel_from']); ?></td>
                            <td><?php echo dateforview($row['travel_to']); ?></td>
                            <td><?php echo $serve_name;?></td>
                         <?php
							if(isset($_GET['booking_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?booking=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['booking_delete']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $serve_name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_booking(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_booking.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
                                </td>
                                 <?php
							}
							
							?>
                            </tr>
                            <?php
						}
						}
						?>
                    </tbody>
                    </table>   
                    </div>
                    </div>
                    </div>
               <?php
		}
		else if(isset($_GET['mode']))
		{
			if($_GET['mode']=='edit')
			{
				?>
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Booking Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="booking_menu.php?booking_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td>
                        <select name="customer_id"  class="m-wrap medium">
                        <option value="">---select customer---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        <td>Flight Number:</td>
                        <td>
                        <select name="flight_no"  class="m-wrap medium">
                        <option value="">---select flight no---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`flight_no` from booking");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['flight_no'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Username:</td>
                        <td>
                        <select name="login_id"  class="m-wrap medium">
                        <option value="">---select username---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`username` from login");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['username'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                 <?php
			}
			else if($_GET['mode']=='del')
			{
				?>
                		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-trash"></i>Booking Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                  	<form action="booking_menu.php?booking_delete=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td>
                        <select name="customer_id"  class="m-wrap medium">
                        <option value="">---select customer---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        <td>Flight Number:</td>
                        <td>
                        <select name="flight_no"  class="m-wrap medium">
                        <option value="">---select flight no---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`flight_no` from booking");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['flight_no'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Username:</td>
                        <td>
                        <select name="login_id"  class="m-wrap medium">
                        <option value="">---select username---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`username` from login");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['username'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
			else if($_GET['mode']=='view')
			{
				?>
                		<div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Booking View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="booking_menu.php?booking_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td>
                        <select name="customer_id"  class="m-wrap medium">
                        <option value="">---select customer---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        <td>Flight Number:</td>
                        <td>
                        <select name="flight_no"  class="m-wrap medium">
                        <option value="">---select flight no---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`flight_no` from booking");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['flight_no'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Username:</td>
                        <td>
                        <select name="login_id"  class="m-wrap medium">
                        <option value="">---select username---</option>
                        <?php
                        $result=mysql_query("select distinct `id`,`username` from login");
                        while($row= mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['username'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
		}
		else
		{
		?>
        <form  name="form_name" action="Handler.php" method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Booking Add</h4>
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
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
     	</td>
        <td>Customer Mobile No.</td>
        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
        </tr>
        
        <tr>
        <td> Guest Name:</td><td><input type="text" name="guest_name" class="m-wrap medium"/> </td>
        <td> Guest Mobile Number:</td><td><input type="text" name="guest_mobile_no" class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Travel Date From </td><td><input type="text" class="m-wrap medium date-picker" onClick="mydatepick();" name="travel_from" /> </td>
        <td> Travel Date To </td><td><input type="text"  class="m-wrap medium date-picker"  onClick="mydatepick();" name="travel_to" /> </td>
        </tr>	
		
        <tr>
        <td> Service: </td>
        <td><select name="service_id" class="m-wrap medium">
        <option value="">---select service---</option>
        <?php 
        $result=mysql_query("select distinct id,name from service");
        while($row=mysql_fetch_array($result))
        {
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
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?> 
        </select>
		</td></tr>
        
        <tr><td> Number of Cars: </td>
        <td>
		<input type="text" name="no_of_car" id="no_of_car" onKeyUp="allLetter(this.value,this.id);" class="m-wrap medium" /> 
		</td>
        <td> Flight Number: </td>
        <td><input type="text" class="m-wrap medium" name="flight_no" /> </td>
        </tr>
                
       <tr>
       <td> PickUp Time: </td>
					<td>
					<select name="pickup_time_hh" class="span3 m-wrap">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
								echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="pickup_time_mm" class="span3 m-wrap">
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
	   <td> PickUp Place: </td><td><input type="text" class="m-wrap medium" name="pickup_place" /> </td>
       </tr>      
       <tr>
       <td>Drop Place</td>
       <td><input type="text" class="m-wrap medium" name="drop_place" /></td>
       <td>Remarks</td>
       <td><textarea rows="2" name="remarks" style="resize:none;" class="m-wrap medium"></textarea>
       </td>
       </tr>
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="booking_reg"/><i class="icon-ok"></i> Submit</button>
        </div>
        </div>
        </div> 
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
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>