<?php
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$total_cor=$_POST['total_cor'];
$customer_name=$_POST['customer_name'];
$guest_name=$_POST['guest_name'];
$ref=$_POST['ref'];
$ins_date=$_POST['ins_date'];
$grand_total=$_POST['grand_total'];
$tax_rate=$_POST['tax_rate'];
$service_tax=$_POST['service_tax'];
$discount=$_POST['discount'];
$net_amnt=$_POST['net_amnt'];
$grand_total=$_POST['grand_total'];
@session_start();
$counter_id=$_SESSION['counter_id'];	
$login_id=$_SESSION['id'];
if(isset($_POST['sub_cor']))
{
				for($i=1;$i<=$total_cor;$i++)
				{
					if(!empty($_POST['amount'.$i]))
					{
						$date[]=datefordb($_POST['date'.$i]);
						$service[]=$_POST['service'.$i];
						$rate[]=$_POST['rate'.$i];
						$day[]=$_POST['day'.$i];
						$texi_no[]=$_POST['texi_no'.$i];
						$amount[]=$_POST['amount'.$i];
					}
				}
				@mysql_query("insert into `corporate_billing` set `date`='".datefordb($ins_date)."',`customer_name`='".$customer_name."',`guest_name`='".$guest_name."',`ref`='".$ref."',`service`='".implode(",",$service)."',`service_date`='".implode(",",$date)."',`rate`='".implode(",",$rate)."',`no_of_days`='".implode(",",$day)."',`taxi_no`='".implode(",",$texi_no)."',`amount`='".implode(",",$amount)."',`tot_amnt`='".$grand_total."',`service_tax`='".$service_tax."',`discount`='".$discount."',`net_amnt`='".$net_amnt."',`login_id`='".$login_id."',`counter_id`='".$counter_id."'");
			$invoice_no=mysql_insert_id();
}
else
{
echo "<script language=\"javascript\">alert('Something went wrong. Try Again.');window.close();</script>";	
}
if($discount>0)
{
$cor_credit=(($net_amnt+$discount)-$service_tax);
}
else
{
$cor_credit=$net_amnt-$service_tax;
}
$res_ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$customer_name."' && `ledger_type_id`='1'");
$res_ledger_master=mysql_fetch_array($res_ledger_master);
$ledger_master_auto_id=$res_ledger_master['id'];
$ledger_discount=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
$row_discount_id=mysql_fetch_array($ledger_discount);


if(!empty($net_amnt)&&!empty($cor_credit))
{
///////////////////////////////////////////////--------------------------debit start here----------------------------/////////////////////////////////////////////////////
@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$ledger_master_auto_id."',`name`='".$customer_name."',`credit`='0',`debit`='".$net_amnt."',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$invoice_no."',`current_date`='".date('Y-m-d')."'");
if($discount>0)
@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_discount_id['id']."',`name`='Discount',`credit`='0',`debit`='".$discount."',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$invoice_no."',`current_date`='".date('Y-m-d')."'");
///////////////////////////////////////////////--------------------------debit end here----------------------------////////////////////////////////////////////////////

$cor_bill_id=mysql_query("select `id` from `ledger_master` where `name`='Corporate Billing' && `ledger_type_id`='5'");
$res_bill_id=mysql_fetch_array($cor_bill_id);
$cor_id=$res_bill_id['id'];

$ledger_tax=mysql_query("select `id` from `ledger_master` where `name`='Service Tax' && `ledger_type_id`='8'");
$row_tax=mysql_fetch_array($ledger_tax);

///////////////////////////////////////////////--------------------------credit start here here----------------------------/////////////////////////////////////////////
@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$cor_id."',`name`='Corporate Billing',`credit`='".$cor_credit."',`debit`='0',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$invoice_no."',`current_date`='".date('Y-m-d')."'");
if($service_tax>0)
@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_tax['id']."',`name`='Service Tax',`credit`='".$service_tax."',`debit`='0',`transaction_type`='corporate_billing',`narration`='Corporate Billing $guest_name, $ref',`transaction_id`='".$invoice_no."',`current_date`='".date('Y-m-d')."'");
///////////////////////////////////////////////--------------------------credit end here here----------------------------/////////////////////////////////////////////
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
<button class="btn yellow diplaynone" role="button" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();" ><i class="icon-print"></i> Print</button><button type="button" class="btn red displaynone" onclick="javascript:;window.close();"><i class="icon-remove"></i> Close</button>
<div class="container-fluid">        
<?php menu(); ?>
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
                <h4 style="text-align:center;color:#0872BA;"><b>CORPORATE BILLING</b></h4>
                <table width="100%"  border="1" cellpadding="3" cellspacing="3" style="border-collapse:collapse;margin-top:1%;" bordercolor="#0872BA">
                <tr class="ad"> 
                <td width="15%">Bill To M/s.</td>
                <td width="50%" colspan="2"><strong><?php echo $customer_name; ?></strong></td>
                <td width="15%">Invoice No.</td>
                <td width="20%"><strong><?php echo $invoice_no; ?></strong></td>
                </tr>
                
                <tr class="ad"> 
                <td>Guest Name</td>
                <td colspan="2"><?php echo $guest_name; ?></td>
                <td>Date</td>
                <td><?php echo dateforview($ins_date); ?></td>
                </tr>
                <tr>
                <td>REF.</td>
                <td colspan="4"><?php echo $ref; ?></td>
                </tr>
                
                <tr class="ad">
                <th width="15%">DATE</th>
                <th width="40%">SERVICES</th>
                <th width="15%">TAXI NO./GUIDE Tkt. No.</th>
                <th width="15%">D. S. No.</th>
                <th width="15%">AMOUNT IN INR</th>
                </tr>
                <?php
				for($i=1;$i<=$total_cor;$i++)
				{
					$date=$_POST['date'.$i];
					$service=$_POST['service'.$i];
					$rate=$_POST['rate'.$i];
					$day=$_POST['day'.$i];
					$texi_no=$_POST['texi_no'.$i];
					$amount=$_POST['amount'.$i];
					?>
                        <tr class="ad">
                        <td width="15%" style="text-align:center;"><?php echo $date; ?></td>
                        <td width="40%" style="text-align:center;"><?php echo $service; ?> @ <?php echo $rate; ?>/- x <?php echo $day; ?></td>
                        <td width="15%" style="text-align:center;"><?php echo $texi_no; ?></td>
                        <td width="15%" style="text-align:center;">&nbsp;</td>
                        <td width="15%" style="text-align:center;"><?php echo $amount; ?></td>
                        </tr>
                    <?php
				}
				?>
              
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>TOTAL</th>
                <th><?php echo $grand_total; ?></th>
                </tr>
               
               <?php 
			   if($tax_rate>0){ ?> 
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>SERVICE TAX @<?php echo $tax_rate; ?>%</th>
                <th><?php echo $service_tax; ?></th>
                </tr>
                <?php } ?>
                

               <?php 
			   if($discount>0){ ?> 
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>DISCOUNT</th>
                <th><?php echo $discount; ?></th>
                </tr>
                <?php } ?>
                
                <tr class="ad">
                <th  colspan="3">&nbsp;</th>
                <th>GRAND TOTAL</th>
                <th><?php echo  $net_amnt; ?></th>
                </tr>
                
                <tr class="ad">
                <td colspan="5"><b><?php echo convert_number_to_words($net_amnt); ?></b></td>
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