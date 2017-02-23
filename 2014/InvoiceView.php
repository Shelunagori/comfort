<?php 
require 'classes/databaseclasses/DataBaseConnect.php';
require_once("auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>
<script	type="text/javascript">
	function HideRow()
	{
		document.getElementById('downrow').style.display='none';	
		window.print() ;
	}
	function SaveDocx()
	{
		var inv=document.getElementById('invoice_id').value;	
		window.open("InvoiceView.php?invoiceid="+inv+"&savedocx=1",'_blank');
	}
	function EMAILIT()
	{
		var inv=document.getElementById('invoice_id').value;	
		window.open("InvoiceView.php?invoiceid="+inv+"&mail=1",'_blank');
	}
</script>

<style type="text/css">
	.container
	{
		width:1000px;
		margin:0 auto;
		color:#009;
		font-family:calibri;
		text-align:center;
		font-size:20px;
	}
	.rowheight
	{
		height:30px;	
	}
</style>
</head>
<body>
<?php
	if(isset($_GET['savedocx']))
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=invoice_.doc");
	}
	else if(isset($_GET['mail']))
	{
		error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

//require_once('../class.phpmailer.php');
require_once 'PHPMailer_5.2.1/class.phpmailer.php';
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = file_get_contents('InvoiceView.php');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp.gmail.com"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "rajsinghravi25.87@gmail.com";  // GMAIL username
$mail->Password   = "***********";            // GMAIL password

$mail->SetFrom('rajsinghravi25.87@gmail.com', 'Ravindra Singh');

$mail->AddReplyTo("rajsinghravi25.87@gmail.com","Ravindra Singh");

$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML("");

$address = "rajsinghravi25.87@gmail.com";
$mail->AddAddress($address, "Ravindra Singh");

//$mail->AddAttachment("vehicle.pdf");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  
}
		
	}
?>
<div class="container">
<?php 
$data = new DataBaseConnect();
$result_invoice_pre= $data->execute_query_return("select `duty_slip_customer_reg_name`,`date`,`total`,`discount`,`tax`,`grand_total` from `invoice` where `invoice_id`='".$_GET['invoiceid']."'");
if(mysql_num_rows($result_invoice_pre)>0)
{
	$row_invoice_pre=mysql_fetch_assoc($result_invoice_pre);
	$result_cust1=$data->execute_query_return("select * from `customer_reg` where `id`='".$row_invoice_pre['duty_slip_customer_reg_name']."'");
	$row_cust_name=mysql_fetch_assoc($result_cust1);
	$customer_name=$row_cust_name['name'];
?>
<input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo $_GET['invoiceid'];?>"/>
  <table width="100%" border="0" style="border-collapse:collapse; text-align: center;">
  <tr class="rowheight">
    <td>
    	<img src="images/logo.jpg" />  
    </td>
    <td>Comfort Travels &amp; Tours
      <br/>
      "Akruti" , 4- New Fatehpura, Opp. Saheliyo ki Badi,  UDAIPUR-313004    
      <br/>
      :+91-294-2411661/62 , Fax : +91-294-2422131 
      <br/>
       Pan No. AAWPC1369E , Service tax: AAWPC1369EST001 
       <br />
      Email:- operations@comforttours.com ,  siddhant.chatur@comforttours.com
      </td>
    </tr> 
    <tr><td colspan="2">&nbsp;</td></tr>
    </table>
<table width="100%" border="1" style="border-collapse:collapse; text-align: center;">
  <tr class="rowheight">
    <td width="20%">Bill To M/s.</td>
    <td colspan="2" align="left">&nbsp;&nbsp;<?php echo $customer_name;?></td>
    <td width="15%">Invoice Number:</td>
    <td width="13%"><?php echo $_GET['invoiceid'];?></td>
  </tr>
  <?php 
  //$result_invoice= $data->execute_query_return("select `duty_slip_dutyslip_id`,`amount` from `invoice_detail` where `invoice_invoice_id`='".$_GET['invoiceid']."' order by `duty_slip_dutyslip_id`");
  ?>
  <tr class="rowheight">
    <td width="20%">Guest Name:</td>
    <td colspan="2" align="left" style="padding-left: 10px;">
    <?php 
	
    	$result_invoice= $data->execute_query_return("select `duty_slip_dutyslip_id` from `invoice_detail` where `invoice_invoice_id`='".$_GET['invoiceid']."' order by `duty_slip_dutyslip_id`");
  		$row=mysql_fetch_assoc($result_invoice);
	
    	$result_duty=$data->execute_query_return("select `guest_name` from `duty_slip` where `dutyslip_id`='".$row['duty_slip_dutyslip_id']."'");
    	echo '<pre>';
    	//print_r($result_duty);
    	echo '</pre>';
  		$row_dutyslip=mysql_fetch_assoc($result_duty);
  		echo $row_dutyslip['guest_name'];
    ?>
    </td>
    <td>Date:</td>
    <td><?php echo date("d-M-Y", strtotime($row_invoice_pre['date']));?></td>
  </tr>
  <tr class="rowheight">
    <td width="20%">Ref:</td>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr class="rowheight" style="font-weight:bolder;">
   
 	<td colspan="3">Description</td>
    <td colspan="2">Amount in INR</td>
  </tr>
  
  <tbody>
  <?php 

  	$result_invoice= $data->execute_query_return("select `duty_slip_dutyslip_id`,`amount` from `invoice_detail` where `invoice_invoice_id`='".$_GET['invoiceid']."' order by `duty_slip_dutyslip_id`");
  	$var=0;
	$new_days=0;
  	while($row=mysql_fetch_assoc($result_invoice))
  	{
  		//echo $row['duty_slip_dutyslip_id'];
  		$result_duty=$data->execute_query_return("select * from `duty_slip` where `dutyslip_id`='".$row['duty_slip_dutyslip_id']."'");
  		$row_duty=mysql_fetch_assoc($result_duty);
		$service_service_id=$row_duty['service_service_id'];
		$new_car_no=$row_duty['new_car_no'];
		$rate=$row_duty['rate'];
		
		$date_from_st=$row_duty['date_from'];
		$date_to_ed=$row_duty['date_to'];
		$main1= strtotime($date_from_st);
		$main2 = strtotime($date_to_ed);
		$days=(($main2-$main1)/86400);
		
		
		$tot_chg = $rate+($rate*($days));	
		$new_days=$days+1;
		
		
		if($days==0)
		{
		$incity_days=1;
		}
		else
		{
		$incity_days=$days;	
		}		

		$qry_fetch_carid="select * from `car_reg` where `car_id`='".$row_duty['car_reg_name']."'";
		$data_base_object = new DataBaseConnect();
		$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
		$row_carid = mysql_fetch_array($result_carid);
		$car_reg_name_new=$row_carid['name'];
		
		if($car_reg_name_new=="Others")
		{
			$car_reg_name_new=$new_car_no;
		}
		
		
		$result_service_name=$data->execute_query_return("select * from `service` where `service_id`='".$row_duty['service_service_id']."'");
  		$row_service_name=mysql_fetch_assoc($result_service_name);
		$service_name_fetch=$row_service_name['name'];

	//	$car_nm=$data->execute_query_return("select * from car_reg where `car_id`='".$row_duty['car_reg_name']."'");
	//	$row_car=mysql_fetch_array($car_nm);
		
		$result_car_name=$data->execute_query_return("select * from `carname_master` where `id`='".$row_duty['carname_master_id']."'");
  		$row_car_name=mysql_fetch_assoc($result_car_name);
		$car_name_fetch=$row_car_name['name'];
		
	   $result_cust=$data->execute_query_return("select * from customer_tariff where customer_reg_name='".$row_invoice_pre['duty_slip_customer_reg_name']."' and carname_master_id='".$row_duty['carname_master_id']."' and service_service_id='".$row_duty['service_service_id']."' ");
		$row_cust=mysql_fetch_assoc($result_cust);
  	?>
  		<tr class="rowheight">
	    	<td colspan="3" width="20%" align="left"><?php echo "Duty slip no. ".$row['duty_slip_dutyslip_id']." dated on ".date("d-M-Y",strtotime($row_duty['current_date']))." "."towards the cost of transport used in Udaipur for the Service ".$service_name_fetch." (".$row_cust['minimum_chg_hourly']." hrs / ".$row_cust['minimum_chg_km']." kms) by ".$car_name_fetch." ".$car_reg_name_new; ?>
				</td>
			<td colspan="2"><?php echo $tot_chg; ?></td>
			</tr>
	  
    	  	<?php
			
			///////////////////////////////////////////
			
		
					  	  
						  
						$result_what=$data->execute_query_return("select `type` from `service` where `service_id`='".$service_service_id."'");
						$row_what=mysql_fetch_assoc($result_what);
						$service_type=$row_what['type'];
						if($service_type=='intercity')
						{
					
						 $result_cust=$data->execute_query_return("select * from customer_tariff where customer_reg_name='".$row_invoice_pre['duty_slip_customer_reg_name']."' and carname_master_id='".$row_duty['carname_master_id']."' and service_service_id='".$row_duty['service_service_id']."' ");
							
						   $extra_km_charge=0;
						   $extra_km=0;
						   $extra_per_km=0;
			               if(mysql_num_rows($result_cust)>0)
						    {
							$row_cust=mysql_fetch_assoc($result_cust);
							$minimum_chg_km=$row_cust['minimum_chg_km'];
							$total_freerun = $minimum_chg_km*$new_days;
							
								$extra_km=$row_duty['total_km']-($total_freerun);
								$extra_km_charge=($extra_km)*$row_cust['extra_km_rate'];
								$extra_per_km=$row_cust['extra_km_rate'];
							}
							else
							{
							$result_tariff=$data->execute_query_return("select * from `tariff_rate` where `carname_master_id`='".$row_duty['carname_master_id']."' and `service_service_id`='".$service_service_id."'");
							if(mysql_num_rows($result_tariff)>0)
							{
								$row_tariff=mysql_fetch_assoc($result_tariff);
								$minimum_chg_km=$row_tariff['minimum_chg_km'];
								$total_freerun = $minimum_chg_km*$new_days;
								
									$extra_km=$row_duty['total_km']-($total_freerun);
									$extra_km_charge=($extra_km)*$row_tariff['extra_km_rate'];
									$extra_per_km=$row_tariff['extra_km_rate'];
								
							}	
							}
							
							if($extra_km>0)
							{
							?>
	                           <tr><td colspan="3">
	                            <b>Extra Km:</b>
								  
	                            <?php echo $extra_km;?></td>
	                            <td colspan="2"> <?php echo $extra_km_charge;?>
									   </td>
	                           </tr>
	                            <?php 
							}
						}
						else if($service_type=='incity')
						{
					
							
					$result_cust=$data->execute_query_return("select * from customer_tariff where customer_reg_name='".$row_invoice_pre['duty_slip_customer_reg_name']."' and carname_master_id='".$row_duty['carname_master_id']."' and service_service_id='".$row_duty['service_service_id']."' ");
							
							$extra_hours=0;
							$extra_hours_charges=0;
							$extra_per_hour=0;
							
					if(mysql_num_rows($result_cust)>0)
						{
					      $var_first_stamp =$row_duty['date_to']." ".$row_duty['closing_time'];
									$var_second_stamp =$row_duty['date_from']." ".$row_duty['opening_time'];
									$result_time_diff=$data->execute_query_return("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=$data->execute_query_return("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
										$extra_hours=$total_time_of_car-(($row_cust['minimum_chg_hourly'])*$incity_days);
										$extra_hours_charges=$extra_hours*$row_cust['extra_hour_rate'];
										$extra_per_hour=$row_cust['extra_hour_rate'];
						}
						else
						{
							
							
							$result_tariff=$data->execute_query_return("select * from `tariff_rate` where `carname_master_id`='".$row_duty['carname_master_id']."' and `service_service_id`='".$service_service_id."'");
						        
									$var_first_stamp =$row_duty['date_to']." ".$row_duty['closing_time'];
									$var_second_stamp =$row_duty['date_from']." ".$row_duty['opening_time'];
									$result_time_diff=$data->execute_query_return("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=$data->execute_query_return("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
									
										$extra_hours=$total_time_of_car-(($row_tariff['minimum_chg_hourly'])*$incity_days);
										$extra_hours_charges=$extra_hours*$row_tariff['extra_hour_rate'];
										$extra_per_hour=$row_tariff['extra_hour_rate'];
							
						}
									
						if($extra_hours>0)
						{
                            ?>
								    <tr><td colspan="3">
                            <b>Extra Hours:</b>
                            <?php echo $extra_hours;?></td>
                        <td colspan="2">    <?php echo $extra_hours_charges;?>
									</td>
										</tr>
                         <?php 
						}
						}

			///////////////////////////////////////////////////
    	   
	     	?>
				
	  <?php
	  if( $row_duty['extra_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Toll Tax</td>
		  <td colspan="2"><?php echo $row_duty['extra_chg']; ?></td>
	  </tr>
  	<?php 
		}
		 if( $row_duty['permit_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Permit Charges</td>
		  <td colspan="2"><?php echo $row_duty['permit_chg']; ?></td>
	  </tr>
  	<?php 
		}
		if( $row_duty['parking_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Parking Charges</td>
		  <td colspan="2"><?php echo $row_duty['parking_chg']; ?></td>
	  </tr>
  	<?php 
		}
		if( $row_duty['otherstate_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Driver Allowance:</td>
		  <td colspan="2"><?php echo $row_duty['otherstate_chg']; ?></td>
	  </tr>
  	<?php 
		}
		if( $row_duty['guide_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Border Tax: </td>
		  <td colspan="2"><?php echo $row_duty['guide_chg']; ?></td>
	  </tr>
  	<?php 
		}
		if( $row_duty['misc_chg']>0)
	  { ?>
	  <tr>
	  	<td colspan="3" align="left">Miscellaneous Charges</td>
		  <td colspan="2"><?php echo $row_duty['misc_chg']; ?></td>
	  </tr>
  	<?php 
		}
  	$var++;
  	}
  	$data->close_connection();
  	$total_height = $var*30;
  ?>
  <tr><td colspan="3">&nbsp;</td>
  <td colspan="2">&nbsp;</td>
 
  </tr>
  </tbody>
  <tr class="rowheight" style="font-weight:bolder;">
  		
  		  <td colspan="3">Total:</td>
  		  <td colspan="2"><?php echo $row_invoice_pre['total']; ?></td>
    </tr>
    <?php 
    if($row_invoice_pre['discount']!=0)
    {
    ?>
  <tr class="rowheight" style="font-weight:bolder;">
  
    <td colspan="3">Discount:</td>
    <td colspan="2"><?php echo $row_invoice_pre['discount']; ?></td>
  </tr>
  <?php 
    }
  ?>
  <tr class="rowheight" style="font-weight:bolder;">
   
    <td colspan="3">Service Tax:</td>
    <td colspan="2"><?php echo $row_invoice_pre['tax']; ?></td>
  </tr>
  <tr class="rowheight" style="font-weight:bolder;">
   
    <td colspan="3">Grand Total:</td>
    <td colspan="2"><?php echo $row_invoice_pre['grand_total']; ?></td>
  </tr>
  <tr align="left" class="rowheight" style="font-weight:bolder;">
    <td width="20%" colspan="5">Rupees :
    <?php 
    
$one=array(" "," One"," Two"," Three"," Four"," Five"," Six"," Seven","
Eight"," Nine"," Ten"," Eleven"," Twelve"," Thirteen"," Fourteen","
Fifteen"," Sixteen"," Seventeen"," Eighteen"," Nineteen");
$ten=array(" "," "," Twenty"," Thirty"," Forty"," Fifty"," Sixty","
Seventy"," Eighty"," Ninety");
$n=$row_invoice_pre['grand_total'];
                  pw(round($n/10000000)," Crore");
                  pw(round(($n/100000)%100)," Lakh");
                  pw(round(($n/1000)%100)," Thousand");
                  pw(round(($n/100)%10)," Hundred");
                  pw(round($n%100)," ");
                  echo " Only /-";

?>
    </td>
  </tr>
  <tr align="left" class="rowheight" style="font-weight:bolder; font-size: 15px;">
    <td width="20%" colspan="3">SIGNATURE IN CONFIRMATION<br/>
    <span style="font-size: 10px; font-style:italic;">of terms &amp; condition overleaf</span>
    </td>
    <td colspan="2">For: Comfort Travels &amp; Tours </td>
  </tr>
  <tr><td colspan="5" style="border-bottom: none;">&nbsp;</td></tr>
  <tr><td colspan="5" style="border-top: none;">&nbsp;</td></tr>
  <tr align="left" class="rowheight" style="font-weight:bolder; font-size: 15px;">
    <td colspan="3">(Name............................................)</td>
	 
     <td colspan="2">Authorised Signatory</td>
	  
  </tr>

  
</table>
<?php 
}

function pw($n,$ch)
{
	global $one;
	global $ten;
 if($n>19)echo $ten[$n/10],$one[$n%10];
 else echo $one[$n];
 if($n)echo $ch;
}
?>
</div>
</body>
</html>