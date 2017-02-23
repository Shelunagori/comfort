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
    	<form method="post" name="form_name">
        <?php
if(isset($_GET['corporate']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `corporate_billing` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$service_date=@explode(",",$row['service_date']);
	$service=@explode(",",$row['service']);
	$rate=@explode(",",$row['rate']);
	$no_of_days=@explode(",",$row['no_of_days']);
	$taxi_no=@explode(",",$row['taxi_no']);
	$amount=@explode(",",$row['amount']);
	
}
?>
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
                <h4 style="text-align:center;color:#0872BA;"><b>CORPORATE BILLING</b></h4>
                <table width="100%"  border="1" cellpadding="3" cellspacing="3" style="border-collapse:collapse;margin-top:1%;" bordercolor="#0872BA">
                <tr class="ad"> 
                <td width="15%">Bill To M/s.</td>
                <td width="50%" colspan="2"><strong><?php echo $row['customer_name']; ?></strong></td>
                <td width="15%">Invoice No.</td>
                <td width="20%"><strong><?php echo $_GET['id']; ?></strong></td>
                </tr>
                
                <tr class="ad"> 
                <td>Guest Name</td>
                <td colspan="2"><?php echo $row['guest_name']; ?></td>
                <td>Date</td>
                <td><?php echo dateforview($row['date']); ?></td>
                </tr>
                <tr>
                <td>REF.</td>
                <td colspan="4"><?php echo $row['ref']; ?></td>
                </tr>
                
                <tr class="ad">
                <th width="15%">DATE</th>
                <th width="40%">SERVICES</th>
                <th width="15%">TAXI NO./GUIDE Tkt. No.</th>
                <th width="15%">D. S. No.</th>
                <th width="15%">AMOUNT IN INR</th>
                </tr>
                <?php
				for($i=0;$i<sizeof($amount);$i++)
				{
					if(!empty($amount))
					?>
                        <tr class="ad">
                        <td width="15%" style="text-align:center;"><?php echo dateforview($service_date[$i]); ?></td>
                        <td width="40%" style="text-align:center;"><?php echo $service[$i]; ?> @ <?php echo $rate[$i]; ?>/- x <?php echo $no_of_days[$i]; ?></td>
                        <td width="15%" style="text-align:center;"><?php echo $taxi_no[$i]; ?></td>
                        <td width="15%" style="text-align:center;">&nbsp;</td>
                        <td width="15%" style="text-align:center;"><?php echo $amount[$i]; ?></td>
                        </tr>
                    <?php
				}
				?>
              
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>TOTAL</th>
                <th><?php echo $row['tot_amnt']; ?></th>
                </tr>
               
               <?php 
			   if($row['service_tax']>0){ ?> 
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>SERVICE TAX</th>
                <th><?php echo $row['service_tax']; ?></th>
                </tr>
                <?php } ?>
                

               <?php 
			   if($row['discount']>0){ ?> 
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>DISCOUNT</th>
                <th><?php echo $row['discount']; ?></th>
                </tr>
                <?php } ?>
                
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>GRAND TOTAL</th>
                <th><?php echo  $row['net_amnt']; ?></th>
                </tr>
                
                <tr class="ad">
                <td colspan="5"><b><?php echo convert_number_to_words($row['net_amnt']); ?></b></td>
                </tr>
                <tr class="ad">
                <td colspan="3"><b>SIGNATURE IN CONFIRMATION</b><br/><span style="font-size: 11px; font-style:italic;">of terms & condition overleaf</span></td>
                <td colspan="2">For: Comfort Travels & Tours</td>
                </tr>
                <tr class="ad"><td colspan="5" style="border-bottom:none;">&nbsp;</td></tr>
                <tr class="ad"><td colspan="5" style="border-top:none;">&nbsp;</td></tr>
                <tr class="ad">
                <td colspan="3">(Name............................................)</td>
                <td colspan="2"><!--<img src="assets/<?php echo fetchimg(); ?>" style="width: 30%;! important; padding: 5px;"/><br/>-->Authorised Signatory</td>
                </tr>
                <tr class="ad">
                <td colspan="5" style="color:#0872BA;"><b>Other Info.</b> <span>PAN No. AAWPC1369E, Service Tax: AAWPC1369EST001<br /><b>Email:-</b> operations@comforttours.com ,  siddhant.chatur@comforttours.com</span></td>
                </tr>
                  </table>
<?php
}
?>
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