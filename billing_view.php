<?php
require_once("config.php");
require_once("function.php");
require_once("auth.php");
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
		body {
		margin:0 !important;
		padding:0 !important;
		}
		
		*{
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
		height:100%;
		margin:0 auto;
		text-align:justify;
		padding-left:10px;
		padding-right:10px;
		}
		
		span,table
		{
		font-family: "Open Sans",sans-serif;
		font-size: 14px;
		direction: ltr;
		}
		th
		{
			text-align:center;
		}
</style>
<style media="print">
.displaynone{
display:none !important;
}
</style>
<script>
 window.onload=init;
		function init()
		{
			var abc="zoom_out";
			fun_zoom(abc);
		}
</script>
</head>
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>      
      <!-- BEGIN PAGE -->  
<div class="page-content" id="zoom_div">
<button class="btn yellow diplaynone" role="button" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();" ><i class="icon-print"></i> Print</button>  <button type="button" class="btn red displaynone" onclick="javascript:;window.close();"><i class="icon-remove"></i> Close</button>
 <a type="button" class="btn blue displaynone" href="update_billing.php?id=<?php echo $_GET['id']; ?>"><i class="icon-edit"></i> Edit Bill</a>
 <a class="btn green displaynone" role="button" onclick="window.open('pdf.php?billing=true&amp;id=<?php echo $_GET['id']; ?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');" target="_blank" style="text-decoration:none;">
    							<i class="icon-download-alt"></i> PDF</a>
<div class="container-fluid">        
<?php menu(); ?>
	<?php 
	$result_invoice=mysql_query("select * from invoice where `id`='".$_GET['id']."'");
	$row_invoice=mysql_fetch_array($result_invoice);
	$othercharges=0;
	$result_guest=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$_GET['id']."' ");
	while($result1_guest=mysql_fetch_array($result_guest))
	{
		$result_guest2=mysql_query("select `guest_name` from `duty_slip` where `id`='".$result1_guest['duty_slip_id']."'");
		$row_guest2=mysql_fetch_array($result_guest2);
		$guest_name=$row_guest2['guest_name'];
	}
	
	/*$result_guest2=mysql_query("select `guest_name` from `duty_slip` where `id`in(".$result_guest.") ");
	$row_guest2=mysql_fetch_array($result_guest2);
	$guest_name=$row_guest2['guest_name'];*/
	
	?>
   				<div class="page">
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
                <table width="100%"  border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;margin-top:1%;margin-bottom: 20px;" bordercolor="#0872BA">
                <tr class="ad"> 
                <td width="15%">Bill To M/s.</td>
                <td width="55%"><strong><?php echo fetchcustomername($row_invoice['customer_id']); ?></strong></td>
                <td width="15%">Invoice No.</td>
                <td width="15%"><strong><?php echo $row_invoice['id']; ?></strong></td>
                </tr>
                <tr class="ad"> 
                <td>Guest Name</td>
                <td><?php echo $guest_name; ?></td>
                <td>Date</td>
                <td><?php echo dateforview($row_invoice['date']); ?></td>
                </tr>
                <tr>
                <td>REF.</td>
                <td colspan="3"></td>
                </tr>
                <tr class="ad">
                <th colspan="2">Description</th>
                <th colspan="2">Amount in INR</th>
                </tr>
				<?php
                $result_invoice_detail=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$row_invoice['id']."' order by `duty_slip_id`");	
                while($row_invoice_detail=mysql_fetch_array($result_invoice_detail))
                {
				
				$result_duty=mysql_query("select * from duty_slip where `id`='".$row_invoice_detail['duty_slip_id']."'");	
				$row_duty=mysql_fetch_array($result_duty);
				if(!empty($row_duty['temp_car_no']))
					$car_no=$row_duty['temp_car_no'];
				else
					$car_no=fetchcarno($row_duty['car_id']);
				
				$result_tariff=mysql_query("select * from `customer_tariff` where customer_id='".$row_duty['customer_id']."' and car_type_id='".$row_duty['car_type_id']."' and service_id='".$row_duty['service_id']."'");
				if(mysql_num_rows($result_tariff)==0)   
				$result_tariff=mysql_query("select * from `tariff_rate` where service_id='".$row_duty['service_id']."' and car_type_id='".$row_duty['car_type_id']."'");
				$row_rariff = mysql_fetch_array($result_tariff);	
				
               $main_amnt=($row_duty['tot_amnt']-($row_duty['extra_chg']+$row_duty['permit_chg']+$row_duty['otherstate_chg']+$row_duty['guide_chg']+$row_duty['misc_chg']+$row_duty['parking_chg']));
			    ?>
                <tr class="ad">
                <td colspan="2" style="text-align:left"><?php echo "Duty Slip No. ".$row_invoice_detail['duty_slip_id']." dated on ".dateforview($row_duty['date'])." "."towards the cost of transport used in Udaipur for the Service ".fetchservicename($row_duty['service_id'])." (".$row_rariff['minimum_chg_hourly']." hrs / ".$row_rariff['minimum_chg_km']." kms) by ".fetchcarname($row_duty['car_type_id'])." ".$car_no ?></td>
                <th colspan="2"><?php echo $main_amnt; ?></th>
                </tr>
					<?php

                    if(!empty($row_duty['extra']))
                    {
                        ?>
                            <tr class="ad">
                            <th colspan="2">Extra <?php echo $row_duty['extra']; ?>: <?php echo $row_duty['extra_details']; ?></th>
                            <th colspan="2"><?php echo $row_duty['extra_amnt']; ?></th>
                            </tr>
                        <?php
                    }
                    if(!empty($row_duty['extra_chg']))
                    {
                    ?>
                            <tr class="ad">
                            <td colspan="2">Toll Tax</td>
                            <th colspan="2"><?php echo $row_duty['extra_chg']; ?></th>
                            </tr>
                    <?php
                    }
                    if(!empty($row_duty['permit_chg']))
                    {
                    ?>
                            <tr class="ad">
                            <td colspan="2">Permit Charges</td>
                            <th colspan="2"><?php echo $row_duty['permit_chg']; ?></th>
                            </tr>
                    <?php
					$othercharges+=$row_duty['permit_chg'];
                    }
					if(!empty($row_duty['parking_chg']))
                    {
                    ?>
                            <tr class="ad">
                            <td colspan="2">Parking Charges</td>
                            <th colspan="2"><?php echo $row_duty['parking_chg']; ?></th>
                            </tr>
                    <?php
$othercharges+=$row_duty['parking_chg'];
                    }
					if(!empty($row_duty['otherstate_chg']))
                    {
                    ?>
                            <tr class="ad">
                            <td colspan="2">Driver Allowance:</td>
                            <th colspan="2"><?php echo $row_duty['otherstate_chg']; ?></th>
                            </tr>
                    <?php
$othercharges+=$row_duty['otherstate_chg'];
                    }
					if(!empty($row_duty['guide_chg']))
                    {
                    ?>
                            <tr class="ad">
                            <td colspan="2">Border Tax:</td>
                            <th colspan="2"><?php echo $row_duty['guide_chg']; ?></th>
                            </tr>
                    <?php
$othercharges+=$row_duty['guide_chg'];
                    }
					if(!empty($row_duty['misc_chg']))
					{
					?>
                      		<tr class="ad">
                            <td colspan="2">Miscellaneous Charges</td>
                            <th colspan="2"><?php echo $row_duty['misc_chg']; ?></th>
                            </tr>
                    <?php
$othercharges+=$row_duty['misc_chg'];
					}
                }
                ?>	
                    <tr class="ad">
                    <th colspan="2">Total</th>
                    <th colspan="2"><?php echo $row_invoice['total']; ?></th>
                    </tr>
                    <?php
if(!empty($row_invoice['discount']))
					{
					?>
                      		<tr class="ad">
                            <th colspan="2">Discount</th>
                            <th colspan="2"><?php echo $row_invoice['discount']; ?></th>
                            </tr>
                    <?php
					}
if(!empty($othercharges))
					{
?>
<tr class="ad">
                            <th colspan="2">Other Charges</th>
                            <th colspan="2"><?php echo $othercharges; ?></th>
                            </tr>
<?php
}
					if(!empty($row_invoice['tax']))
					{
						$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
						while($row_taxrate=mysql_fetch_array($result_taxrate))
						{
							$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
							$row_ledger_master=mysql_fetch_array($ledger_master);
							
							$ledger=mysql_query("select `credit` from `ledger` where `name`='".$row_taxrate['name']."' && `ledger_master_id`='".$row_ledger_master['id']."' && `invoice_id`='".$row_invoice['id']."'");
							while($row_ledger=mysql_fetch_array($ledger))
							{
								if($row_ledger['credit']>0){
								

?>
								<tr class="ad">
								<th colspan="2"><?php echo $row_taxrate['name']; ?></th>
								<th colspan="2"><?php echo $row_ledger['credit']; ?></th>
								</tr>
								<?php
}
							}
						}
					}
					
					?>		
                            <tr class="ad">
                            
                            <th colspan="2">Grand Total</th>
                            <th colspan="2"><?php echo $row_invoice['grand_total']; ?></th>
                            </tr>
                            <tr class="ad">
                            <td colspan="4"><b><?php echo convert_number_to_words($row_invoice['grand_total']); ?></b></td>
                            </tr>
                            <tr class="ad">
                            <td colspan="2"><b>SIGNATURE IN CONFIRMATION</b><br/><span style="font-size: 11px; font-style:italic;">of terms & condition overleaf</span></td>
                            <td colspan="2">For: Comfort Travels & Tours</td>
                            </tr>
                            <tr class="ad"><td colspan="4" style="border-bottom:none;">&nbsp;</td></tr>
                            <tr class="ad"><td colspan="4" style="border-top:none;">&nbsp;</td></tr>
                            <tr class="ad">
                            <td colspan="2">(Name............................................)</td>
                            <td colspan="2"><!--<img src="assets/<?php echo fetchimg(); ?>" style="width: 30%;! important; padding: 5px;"/><br/>-->Authorised Signatory</td>
                            </tr>
                            <tr class="ad">
                            <td colspan="4" style="color:#0872BA;"><b>Other Info.</b> <span>PAN No. AAWPC1369E, Service Tax: AAWPC1369EST001<br /><b>Email:-</b> operations@comforttours.com ,  siddhant.chatur@comforttours.com</span></td>
                            </tr>
                            <tr class="ad">
                            <td colspan="4" style="color:#0872BA;"><strong>For Bookings Contact:</strong> +91-9829794669 , +91-9602131131</td>
                            </tr>
                  </table>
                </div>
                </div>
                <?php
	
	?>
</div>
</div>
</div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 