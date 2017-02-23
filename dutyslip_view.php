<?php
require_once("config.php");
require_once("function.php");
require_once("auth.php");
if(isset($_GET['id']) && isset($_GET['dutyslip']))
{
	$result=mysql_query("select * from duty_slip where `id`='".$_GET['id']."'");
	$row_data=mysql_fetch_array($result);
	
	//$result_driver=mysql_query("select `name` from `driver_reg` where `id`='".$row_data['driver_id']."'");
	//$row_driver=mysql_fetch_array($result_driver);
	
	$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row_data['car_id']."'");
	$row_car=mysql_fetch_array($result_car);
	
	$name_ty=$row_car['name'];
	$car_anem=explode(' ', $name_ty);
 	if($car_anem[0]=='Other')
	$car_number=$row_data['temp_car_no'];
	else
	$car_number=$row_car['name'];
	//echo $car_anem[0]; exit;
	if(!empty($row_data['temp_driver_name']))
	$driver_name=$row_data['temp_driver_name'];
	else
	$driver_name=fetchdrivername($row_data['driver_id']);
	
	$total_time      = strtotime($closing_time) - strtotime($opening_time);
	$hours      = floor($total_time / 60 / 60);
	$minutes    = round(($total_time - ($hours * 60 * 60)) / 60);
	$time_duration=$hours.'.'.$minutes;
	
	$main1= strtotime(datefordb($row_data['date_from']));
	$main2 = strtotime(datefordb($row_data['date_to']));
	$days=(($main2-$main1)/86400);
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
<style type="text/css">
<style>
    body {
        margin: 0 !important;
        padding:0 !important;
    }
	* {
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box; 
	box-sizing: border-box;
	}
	
	.page{
	width:100%;
	height:100%;
	margin:0 auto;
	}
	
	.left {
	float: left;
	width: 100%;
	height: 50%;
	margin:0 auto;
	text-align:justify;
	padding-left:10px;
	padding-right:10px;
	}
	
	span,table
	{
		font-family: "Open Sans",sans-serif;
		font-size: 13px;
		direction: ltr;
	}
</style>
<style media="print">
.displaynone{
display:none !important;
}
</style>
</head>
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>      
      <!-- BEGIN PAGE -->  
      <div class="page-content" id="zoom_div">
      <button class="btn yellow diplaynone" role="button" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();" ><i class="icon-print"></i> Print</button>    <button type="button" class="btn red displaynone" onclick="javascript:;window.close();"><i class="icon-remove"></i> Close</button>
 
         <div class="container-fluid">        
     <?php menu(); ?>

 								<div class="page">
                                <?php
								for($i=1;$i<=2;$i++)
								{
									?>
<div class="left">
                        <table width="100%"  cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        <tr>
                        <td><img src="assets/logo.jpg" alt="logo" style="float:left; border:2px solid #2E3192;" /></td>
                        <td style="float:right;color:#0872BA;"><span style="font-size:16px !important;"><b>Comfort Travels &amp; Tours</b></span>
                        <br/><span>"Akruti", 4-New Fatehpura, Opp. Saheliyo ki Badi,</span><br/>
                        <span>UDAIPUR-313004 Fax: +91-294-2422131</span><br/>
                        <span><i class="icon-phone"></i> +91-294-2411661/62</span>
                        </td>
                        </tr>
                        </table>
                           <table width="100%"  border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin-top:1%;"  bordercolor="#0872BA">
                             <tr>
                               <td><strong>DutySlip ID</strong></td>
                               <td><?php echo $row_data['id']; ?></td>
                               <td><strong>Date</strong></td>
                               <td colspan="3"><?php echo dateforview($row_data['date']); ?></td>
                             </tr>
                             <tr>
                               <td><strong>Customer Name</strong></td>
                               <td><?php echo fetchcustomername($row_data['customer_id']); ?></td>
                               <td><strong>Guest:</strong></td>
                               <td colspan="3"><?php echo $row_data['guest_name'];?></td>
                             </tr>
                             <tr>
                               <td><strong>Service</strong></td>
                               <td colspan="5"><?php echo fetchservicename($row_data['service_id']);?></td>
                             </tr>
                             <tr>
                               <td><strong>Taxi Number</strong></td>
                               <td><?php echo $car_number; ?></td>
                               <td><strong>Driver</strong></td>
                               <td colspan="3"><?php echo $driver_name; ?></td>
                             </tr>
                             <tr>
                               <td><strong>Opening Date</strong></td>
                               <td><?php echo dateforview($row_data['date_from']); ?></td>
                               <td><strong>Closing Date</strong></td>
                               <td><?php echo dateforview($row_data['date_to']); ?></td>
                               <td><strong>Total Days</strong></td>
                               <td><?php echo $days; ?></td>
                             </tr>
                             <tr>
                               <td><strong>Opening Time</strong></td>
                               <td><?php echo $row_data['opening_time']; ?></td>
                               <td><strong>Closing Time</strong></td>
                               <td><?php echo $row_data['closing_time']; ?></td>
                               <td><strong>Total Hours</strong></td>
                               <td><?php echo $time_duration; ?></td>
                             </tr>
                             <tr>
                               <td><strong>Opening KM</strong></td>
                               <td><?php echo $row_data['opening_km']; ?></td>
                               <td><strong>Closing KM</strong></td>
                               <td><?php echo $row_data['closing_km']; ?></td>
                               <td><strong>Total Run</strong></td>
                               <td><?php echo $row_data['total_km']; ?></td>
                             </tr>
                             <tr>
                               <td><strong>Guest Comment</strong></td>
                               <td colspan="5"></td>
                             </tr>
                            <tr>
                            <td><strong>Remarks</strong></td>
                            <td colspan="5"><?php echo $row_data['remarks']; ?></td>
                            </tr>
                            <tr>
                            <td><strong>Autorized Signature</strong></td>
                            <td colspan="5"><!--<img src="assets/<?php echo fetchimg(); ?>" style="width: 10%; height: 10% ! important; padding: 5px;"/>--></td>
                            </tr>
                           </table>
                           <?php
									   if($i==1)
									   {?>
                                        <br />
                                        <br />
                                        <p style="text-align:center">--------------------<i class="icon-cut"></i>--------------------</p>
                                        <br />
                                        <br />
<?php } ?>
                                       </div>
                                       <?php
								}
									?>
                               </div>
 </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 