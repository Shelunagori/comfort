<?php
require_once('phpmailer/class.phpmailer.php');
require_once("config.php");
require_once("function.php");
require_once("auth.php");
if(isset($_POST['dutyslip_reg']))
{
	extract($_POST);
	@session_start();
 	$counter_id=$_SESSION['counter_id'];
	$login_id=$_SESSION['id'];
	$opening_time = $_POST['opening_time_hh'].":".$_POST['opening_time_mm'].":00";
	$closing_time = $_POST['closing_time_hh'].":".$_POST['closing_time_mm'].":00";
	$total_km = $closing_km-$opening_km;
	
	$main1= strtotime(datefordb($date_from));
	$main2 = strtotime(datefordb($date_to));
	$days=(($main2-$main1)/86400);
	
		
	$result_service=mysql_query("select `type` from `service` where `id`='".$service_id."'");
	$row_service=mysql_fetch_array($result_service);
	if($row_service['type']=='intercity')
	{$days+=1;
		
		$result_cust=mysql_query("select * from `customer_tariff` where `customer_id`='".$customer_id."' and `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
		$extra_km_charge=0;
		$extra_km=0;
		$extra_per_km=0;
		if(mysql_num_rows($result_cust)>0)
		{
			$row_cust=mysql_fetch_array($result_cust);
			$minimum_chg_km=$row_cust['minimum_chg_km'];
			$total_freerun = $minimum_chg_km*$days;
			$extra_km=$total_km-($total_freerun);
			$extra_km_charge=($extra_km)*$row_cust['extra_km_rate'];
			$extra_per_km=$row_cust['extra_km_rate'];
			if($extra_km>0)
			{
				$extra='Km';
				$extra_details=$extra_km;
				$extra_amnt=$extra_km_charge;
			}
		}
		else
		{
			$result_tariff=mysql_query("select * from `tariff_rate` where `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
			$row_tariff=mysql_fetch_array($result_tariff);
			$minimum_chg_km=$row_tariff['minimum_chg_km'];
			$total_freerun = $minimum_chg_km*$days;
			$extra_km=$total_km-($total_freerun);
			$extra_km_charge=($extra_km)*$row_tariff['extra_km_rate'];
			$extra_per_km=$row_tariff['extra_km_rate'];
			if($extra_km>0)
			{
				$extra='Km';
				$extra_details=$extra_km;
				$extra_amnt=$extra_km_charge;
			}
		}
	}
	else if($row_service['type']=='incity')
	{
		if($days==0)
		$days++;
		
		$result_cust=mysql_query("select * from `customer_tariff` where `customer_id`='".$customer_id."' and `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
						$extra_hours=0;
						$extra_hours_charges=0;
						$extra_per_hour=0;
						if(mysql_num_rows($result_cust)>0)
						{
						            $row_cust=mysql_fetch_array($result_cust);
							        $var_first_stamp=datefordb($date_to)." ".$closing_time;
									$var_second_stamp=datefordb($date_from)." ".$opening_time;
									$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
									$extra_hours=$total_time_of_car-(($row_cust['minimum_chg_hourly'])*$days);
									$extra_hours_charges=$extra_hours*$row_cust['extra_hour_rate'];
									$extra_per_hour=$row_cust['extra_hour_rate'];
									if($extra_hours>0)
									{
											$extra='Hours';
											$extra_details=$extra_hours;
											$extra_amnt=$extra_hours_charges;
									}
						}
						else
						{
								$result_tariff=("select * from `tariff_rate` where `car_type_id`='".$car_type_id."' and `service_id`='".$service_id."'");
								$row_tariff=mysql_fetch_array($result_tariff);
								$var_first_stamp=datefordb($date_to)." ".$closing_time;
								$var_second_stamp=datefordb($date_from)." ".$opening_time;
								$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
								$row_time_diff =mysql_fetch_array($result_time_diff);
								$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
								$row_min_diff =mysql_fetch_array($result_min);
								$total_time_of_car= round($row_min_diff[0]);
								
								$extra_hours=$total_time_of_car-(($row_tariff['minimum_chg_hourly'])*$days);
								$extra_hours_charges=$extra_hours*$row_tariff['extra_hour_rate'];
								$extra_per_hour=$row_tariff['extra_hour_rate'];
								if($extra_hours>0)
								{
											$extra='Hours';
											$extra_details=$extra_hours;
											$extra_amnt=$extra_hours_charges;
								}
						}
	}
	
	$tot_amnt=($rate*$days)+$extra_chg+$permit_chg+$parking_chg+$otherstate_chg+$guide_chg+$misc_chg;
	
	$rs=mysql_query("insert into `duty_slip` SET `date`='".date("Y-m-d")."',`guest_name`='".$guest_name."',`mobile_no`='".$mobile_no."',`email_id` = '".$email_id."',`photo_id`='".$photo_id."',`service_id`='".$service_id."',`car_type_id`='".$car_type_id."',`car_id`='".$car_id."',`temp_car_no`='".$temp_car_no."',`customer_id`='".$customer_id."',`detail_no`='".$detail_no."',`driver_id`='".$driver_id."',`temp_driver_name`='".$temp_driver_name."',`opening_km`='".$opening_km."',`closing_km`='".$closing_km."',`opening_time`='".$opening_time."',`closing_time`='".$closing_time."',`date_from`='".datefordb($date_from)."',`date_to`='".datefordb($date_to)."',`extra_chg`='".$extra_chg."',`permit_chg`='".$permit_chg."',`parking_chg`='".$parking_chg."',`otherstate_chg`='".$otherstate_chg."',`guide_chg`='".$guide_chg."',`misc_chg`='".$misc_chg."',`total_km`='".$total_km."',`rate`='".$rate."',`extra`='".$extra."',`extra_details`='".$extra_details."',`extra_amnt`='".$extra_amnt."',`tot_amnt`='".$tot_amnt."',`remarks`='".$remarks."',`reason`='".$reason."',`login_id`='".$login_id."',`counter_id`='".$counter_id."',`billing_status`='no'");

	$result_dutyslip=mysql_query("select max(id) from duty_slip");	
	$row_dutyslip=mysql_fetch_array($result_dutyslip);
	$max_dutyslip_id = $row_dutyslip[0];
	
	$fetch_data=mysql_query("select * from `duty_slip` where `id`='".$max_dutyslip_id."'");
	$row_data=mysql_fetch_array($fetch_data);
	
	$result_driver=mysql_query("select `name`,`mobile_no` from `driver_reg` where `id`='".$row_data['driver_id']."'");
	$row_driver=mysql_fetch_array($result_driver);
	
	$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row_data['car_id']."'");
	$row_car=mysql_fetch_array($result_car);
	$car_tp=$row_car['name'];
	$car_tp=explode(" ",$car_tp);
	
	if($car_tp[0]=='Other')
	$car_number=$row_data['temp_car_no'];
	else
	$car_number=$row_car['name'];
	
	$total_time      = strtotime($closing_time) - strtotime($opening_time);
	$hours      = floor($total_time / 60 / 60);
	$minutes    = round(($total_time - ($hours * 60 * 60)) / 60);
	$time_duration=$hours.'.'.$minutes;
	
	$result_car_type_name=mysql_query("select `name` from `car_type` where `id`='".$car_type_id."'");
	$row_car_type_name=mysql_fetch_array($result_car_type_name);
	$mobile_no=$_POST['mobile_no'];
	if(!empty($mobile_no))
	{
		$working_key='A7a76ea72525fc05bbe9963267b48dd96';
		$sms_sender='COMFRT';
		
		$driver_name=$row_driver['name'];
		$driver_mobile_no=$row_driver['mobile_no'];
		$car_name=$row_car_type_name['name'];
		if(empty($driver_mobile_no))
		{
			$sms=str_replace(' ', '+', 'Greetings from Comfort Travels and Tours, Udaipur. Your car is '.$car_name.' '.$car_number.' with chauffeur '.$driver_name.'. Have a pleasant journey.');
		}
		else
		{
			$sms=str_replace(' ', '+', 'Greeting from Comfort Travels and Tours, Udaipur. Your car is '.$car_name.' '.$car_number.' with chauffeur '.$driver_name.' @ '.$driver_mobile_no.'. Have a pleasant journey.');
		}
		
		file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile_no.'&message='.$sms.'');
 }
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
                        <table width="100%"  cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
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
                               <td colspan="3"><?php echo date("d-M-Y"); ?></td>
                             </tr>
                             <tr>
                               <td><strong>Customer Name</strong></td>
                               <td><?php echo fetchcustomername($row_data['customer_id']); ?></td>
                               <td><strong>Guest:</strong></td>
                               <td colspan="3"><?php echo $row_data['guest_name'];?></td>
                             </tr>

                              <tr>
                               <td><strong>Guest Mobile</strong></td>
                               <td><?php echo $row_data['mobile_no'];?></td>
                               <td><strong>Guest Email</strong></td>
                               <td colspan="3"><?php echo $row_data['email_id'];?></td>
                             </tr>


                             <tr>
                               <td><strong>Service</strong></td>
                               <td colspan="5"><?php echo fetchservicename($row_data['service_id']);?></td>
                             </tr>
                             <tr>
                               <td><strong>Taxi Number</strong></td>
                               <td><?php echo $car_number; ?></td>
                               <td><strong>Driver</strong></td>
                               <td colspan="3"><?php echo $row_driver['name']; ?></td>
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
                               <td><?php echo $total_km; ?></td>
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
                            <td colspan="5"><img src="assets/<?php echo fetchimg(); ?>" style="width: 10%; height: 10% ! important; padding: 5px;"/></td>
                            </tr>
                           </table>
                           <?php  if($i==1)
									   {?>
               <br /> <br />
                  <p style="text-align:center">--------------------<i class="icon-cut"></i>--------------------</p>
               <br /><br />
<?php
$body = '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
<div style="font-family:Arial,sans-serif; font-size:13px; color:#555; width:100%; max-width:600px; line-height:2; margin:0 auto;">
  <div style="border:1px solid #ddd; background:#fff;">
    	<div style="background: #fff; padding: 10px 10px;">
          <div style="display:inline-block;  max-width:100%; vertical-align:top;">
            <a href="#" target="_blank"><img src="http://comforttours.in/assets/logo.jpg" alt="comforttours" title="comforttours" border="0" style="vertical-align:bottom;"></a></div>
            <div style="display: inline-block;line-height: 1.8;padding-top: 1px;padding-left: 10px;font-style: oblique;">
           	"Akruti", 4-New Fatehpura, Opp. Saheliyo ki Badi,<br>
               UDAIPUR-313004 Fax: +91-294-2422131<br>
               <i class="icon-phone"></i> +91-294-2411661/62

            </div>
        </div>
    
         <div style="height:5px; background: #d8c808; background: -moz-linear-gradient(left, #d8c808 0%, #f49414 14%, #e53a24 28%, #594b97 43%, #594b97 43%, #008dd3 57%, #00546d 72%, #009a84 85%, #54af3a 100%); 
         background: -webkit-linear-gradient(left,  #d8c808 0%,#f49414 14%,#e53a24 28%,#594b97 43%,#594b97 43%,#008dd3 57%,#00546d 72%,#009a84 85%,#54af3a 100%); background: linear-gradient(to right,  #d8c808 0%,#f49414 14%,#e53a24 28%,#594b97 43%,#594b97 43%,#008dd3 57%,#00546d 72%,#009a84 85%,#54af3a 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#d8c808, endColorstr=#54af3a,GradientType=1);
    "></div>
    
   	<div style="border-bottom: 1px solid #e6e6e6; background-color: #fafafa; padding:5px 20px 10px; font-size:15px;">
            <p><strong>Hello '. $row_data['guest_name'].'!</strong></p>
            <p>Thank you for Chossing your Travel with Comfort Travels & Tours !<br></p>
         </div>
         
         <div>
           <div style="padding:0 20px;">
   <table cellpadding="0" cellspacing="0" style="border-collapse:collapse; width:100%;">
     <tr>
          <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Booking No</strong></td>
        <td align="center" style="padding:4px 10px; border:1px solid #CCC;"> '. $row_data['id'] .'</td>
        <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Date</strong></td>
<td colspan="3" align="center" style="padding:4px 10px; border:1px solid #CCC;"> '. date("d-M-Y").'</td>
           </tr>
           <tr>
       
       <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Guest Name:</strong></td>
    <td colspan="3" align="center" style="padding:4px 10px; border:1px solid #CCC;">'. $row_data['guest_name'] .'</td>
        </tr>
   <tr>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Service Type</strong></td>
                               <td colspan="5" align="center" style="padding:4px 10px; border:1px solid #CCC;">'. fetchservicename($row_data['service_id']) .'</td>
                             </tr>
                             <tr>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Vehicle Number</strong></td>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;">'.$car_number.'</td>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;"><strong>Driver Name</strong></td>
                               <td colspan="3" align="center" style="padding:4px 10px; border:1px solid #CCC;">'.$row_driver['name'].'</td>
                             </tr>
                             <tr>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;" ><strong>Reporting Date</strong></td>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;" >'. dateforview($row_data['date_from']) .'</td>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;" ><strong>Reporting Time</strong></td>
                               <td align="center" style="padding:4px 10px; border:1px solid #CCC;" >'.$row_data['opening_time'].'</td>
                             </tr>
                           </table>
  </div>
            
            <div style="padding:10px 20px;">
            	<p>For More Details Please Contact On :- <br />
            	  Email -:  operations@comforttours.com , siddhant.chatur@comforttours.com <br />
            	  Phone -:  +91-9829794669 , +91-9602131131
            	  </p>
            </div>
        </div>
    <div style="height:25px; color:#fff; background: #d8c808; background: -moz-linear-gradient(left,  #d8c808 0%, #f49414 14%, #e53a24 28%, #594b97 43%, #594b97 43%, #008dd3 57%, #00546d 72%, #009a84 85%, #54af3a 100%); background: -webkit-linear-gradient(left,  #d8c808 0%,#f49414 14%,#e53a24 28%,#594b97 43%,#594b97 43%,#008dd3 57%,#00546d 72%,#009a84 85%,#54af3a 100%); background: linear-gradient(to right,  #d8c808 0%,#f49414 14%,#e53a24 28%,#594b97 43%,#594b97 43%,#008dd3 57%,#00546d 72%,#009a84 85%,#54af3a 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#d8c808, endColorstr=#54af3a,GradientType=1 );">
			</div>
         <div style="background-color: #fafafa; padding:5px 20px 10px;">
    <div style="padding:0 15px; text-align:center;"> <a href="#" style="display:inline-block; color:#555; text-decoration:none;">Terms &amp; Conditions</a> | <a href="#" style="display:inline-block; color:#555; text-decoration:none;">FAQs</a> | <span style="display:inline-block;">100% Authenticity</span> | <span style="display:inline-block;">Easy Customer Support</span> </div>
    </div>
  </div>
</div>
</body>
</html> ';

 $to  = $row_data['email_id'];
$from = 'shelunagori@gmail.com';
$subject = 'Cab Dispatch details from Comfort Travels and Tours, Udaipur';
} ?>
    </div>
        <?php } 
									
 smtpmailer($to, $from,$subject, $body);


define('GUSER', 'you@gmail.com'); // GMail username
define('GPWD', 'password'); // GMail password
function smtpmailer($to, $from,$subject, $body, $is_gmail = true) { 

  global $error;
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
    if ($is_gmail) {

    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;  
    $mail->Username = 'ankit.sisodiya@spsu.ac.in';  
    $mail->Password = '!QAZSPSU@WSX';   
    $mail->SMTPDebug = 1; 


  } else {

    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;  
    $mail->Username = 'ankit.sisodiya@spsu.ac.in';  
    $mail->Password = '!QAZSPSU@WSX';    
  }        

  $mail->SetFrom($from);
  $HTML = true;  
  $mail->WordWrap = 50; // set word wrap
  $mail->IsHTML($HTML);
  $mail->Subject = $subject;

  $mail->Body = $body;

  $mail->AddAddress($to);
  if(!$mail->Send()) {
    $error = 'Mail error: '.$mail->ErrorInfo;
    //return false;
  } else {
     $error = 'Message sent!';
    //return true;
  }
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