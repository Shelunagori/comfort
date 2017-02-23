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
.centerme{
	text-align:center !important;
}
</style>
<script>
function abc()
{
	window.location="billing_menu.php";
}
function GetExtraChargeKM(value,i)
{
document.getElementById('extra_amnt'+i).value=document.getElementById('extra'+i).value*document.getElementById('extrarate'+i).value;	
}
/*function HideAuth()
{
	
	if(document.getElementById('authperson_row').style.display == 'none') {
        document.getElementById('authperson_row').style.display = '';
		document.getElementById('r3').checked=false;
		document.getElementById('r4').checked=true;
    	}
	else {
        document.getElementById('authperson_row').style.display = 'none';
		document.getElementById('r4').checked=false;
		document.getElementById('r3').checked=true;
    	}
}
*/
function amount_validation(check_id)
{
	
	var total=0;
	var j=0;
	var total_other=0;
    var discount_rate=eval(document.getElementById('discount').value);
	var _total=eval(document.getElementById('total').value);
	
	var i = check_id.substr(5);  // returns "cde"
		if(document.getElementById(check_id).checked==true)
		{	
					
			var extra_amnt=eval(document.getElementById('extra_amnt'+i).value);
			var main_amnt=eval(document.getElementById('main_amnt'+i).value);
			total+=extra_amnt+main_amnt;
		
			<!-- calculate other charge -->
			
			var extra_chg=eval(document.getElementById('extra_chg'+i).value);
			var permit_chg=eval(document.getElementById('permit_chg'+i).value);
			var parking_chg=eval(document.getElementById('parking_chg'+i).value);
			var otherstate_chg=eval(document.getElementById('otherstate_chg'+i).value);
			var guide_chg=eval(document.getElementById('guide_chg'+i).value);
			var misc_chg=eval(document.getElementById('misc_chg'+i).value);
			total_other+=extra_chg+permit_chg+parking_chg+otherstate_chg+guide_chg+misc_chg;
			<!-- calculate discount --->
			if(document.getElementById('per').checked==true)
			{
				var discount_amnt=Math.round((total)*discount_rate/100);
			}
			else
			{
				var discount_amnt=discount_rate;
			}
			var total_tax_amnt=0;
			<!-- calculate service tax and education cess and higher  education cess s-->
			if((document.getElementById('servicetax_status').value=='yes')&&(document.getElementById('comple').value!='1'))
			{
				var val=(total-(discount_amnt));
				var tax=0;
				var tax_amnt=0;
				
				<?php
				$h=0;
				$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
				while($row_taxrate=mysql_fetch_array($result_taxrate))
				{$h++; ?>
					tax=eval(document.getElementById('tax_rate<?php echo $h; ?>').value);
					tax_amnt= val*tax/100;
 					total_tax_amnt+=tax_amnt;
					
				<?php
				} ?>
			}
		
			var grand_total=(total+total_other+total_tax_amnt)-discount_amnt;
		 	if(_total>0)
			{
				
			}
			else if(grand_total<=0)
			{
				document.getElementById(check_id).checked=false;
			}
		}
}
function cal_amount()
{
	var total=0;
	var j=0;
	var total_other=0;
	var total_amtt=0;
	var count=eval(document.getElementById("count").value);
    var discount_rate=eval(document.getElementById('discount').value);
	for(var i=1; i<=count; i++)
	{
		if(document.getElementById('check'+i).checked==true)
		{	
			document.getElementById('fillme'+i).style.backgroundColor='#FFC';
			document.getElementById('fillme_sub'+i).style.backgroundColor='#FFC';
			document.getElementById('extra'+i).readOnly=true;		
			document.getElementById('extra_amnt'+i).readOnly=true;			
			var extra_amnt=eval(document.getElementById('extra_amnt'+i).value);
			var main_amnt=eval(document.getElementById('main_amnt'+i).value);
			total+=extra_amnt+main_amnt;
		
			<!-- calculate other charge -->
			 
			var extra_chg=eval(document.getElementById('extra_chg'+i).value);
			var permit_chg=eval(document.getElementById('permit_chg'+i).value);
			var parking_chg=eval(document.getElementById('parking_chg'+i).value);
			var otherstate_chg=eval(document.getElementById('otherstate_chg'+i).value);
			var guide_chg=eval(document.getElementById('guide_chg'+i).value);
			var misc_chg=eval(document.getElementById('misc_chg'+i).value);
			total_other+=extra_chg+permit_chg+parking_chg+otherstate_chg+guide_chg+misc_chg;
			<!-- calculate discount --->
			var total_amtt = total-total_other;
			 
 			if(document.getElementById('per').checked==true)
			{
				var discount_amnt=Math.round((total_amtt)*discount_rate/100);
			}
			else
			{
				var discount_amnt=discount_rate;
			}
			 
			if(total_other!=0)
			{
			 document.getElementById("other_charges").value=total_other;
			}
			document.getElementById("discout_final").value=discount_amnt;
			<!-- calculate service tax and education cess and higher  education cess s-->
			var total_tax_amnt=0;
			var val=total_amtt;
		 
			if((document.getElementById('servicetax_status').value=='yes')&&(document.getElementById('comple').value!='1'))
			{
				  val=(total_amtt-(discount_amnt));
				 
				//var tax_val=val-total_other;
				var tax=0;
				var tax_amnt=0;
				
				<?php
				$h=0;
				$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
				while($row_taxrate=mysql_fetch_array($result_taxrate))
				{$h++; ?>
					tax=eval(document.getElementById('tax_rate<?php echo $h; ?>').value);
					 
					tax_amnt= val*tax/100 ;
					 
					total_tax_amnt+=tax_amnt;
 					var taxx = tax_amnt.toFixed(2); 
 					document.getElementById('taxation<?php echo $h; ?>').value=taxx;
				<?php
				} ?>
			}
			if(discount_amnt>0){
 			 var after_dis=(total_amtt-(discount_amnt));	
			  
			}else
			{
			var after_dis=total_amtt;
			}
			
		
		 	document.getElementById("grand_total").value=(Math.round((after_dis+total_other+total_tax_amnt)));
			
		}
		else if(j==0)
		{
			document.getElementById('extra'+i).readOnly=false;	
			document.getElementById('extra_amnt'+i).readOnly=false;					
			document.getElementById("fillme"+i).style.backgroundColor='';
			document.getElementById('fillme_sub'+i).style.backgroundColor='';
		}
	}
	if(total==0)
	{
			<?php
			$h=0;
			$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
			while($row_taxrate=mysql_fetch_array($result_taxrate))
			{$h++; ?>
				
				document.getElementById('taxation<?php echo $h; ?>').value=0;
			<?php
			} ?>
			
		 	document.getElementById("grand_total").value=0;
			document.getElementById("discount").value=0;
	}
	 
	document.getElementById("total").value=total_amtt;
}
</script>
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
     <?php
	 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		if(isset($_GET['exe']))
		{
			 
			if($_GET['exe']=='final')
			{
	    $count=$_POST['count'];
		$payment_type=$_POST['payment_type'];
		$remarks=$_POST['remarks'];
		$customer_id=$_POST['customer_id'];
		$invoice_type_id=$_POST['invoice_type_id'];
		$total=$_POST['total'];
		$discount=$_POST['discout_final'];
		$tax=0;
		$h=0;
		$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
		while($row_taxrate=mysql_fetch_array($result_taxrate))
		{$h++;
			$tax+=$_POST['taxation'.$h];
		}
		
		$grand_total=$_POST['grand_total'];
		$com=$_POST['com'];
		$invoice_date=$_POST['invoice_date'];
		@session_start();
		$counter_id=$_SESSION['counter_id'];
		$login_id=$_SESSION['id'];
		$res_ldrview=mysql_query("select `ldrview` from `login` where `id`='".$login_id."' ");
		$row_ldrview=mysql_fetch_array($res_ldrview);
		$ldrview=$row_ldrview['ldrview'];
		
		$rs_invoice=@mysql_query("insert into `invoice` set `date`='".$invoice_date."',`invoice_type_id`='".$invoice_type_id."',`customer_id`='".$customer_id."',`payment_type`='".$payment_type."',`total`='".$total."',`discount`='".$discount."',`tax`='".$tax."',`grand_total`='".$grand_total."',`payment_status`='no',`remarks`='".$remarks."',`login_id`='".$login_id."',`counter_id`='".$counter_id."',`com`='".$com."',`current_date`='".date("Y-m-d")."'");
		
		
		$result_max=mysql_query("select max(`id`) from `invoice` where `customer_id`='".$customer_id."'");
		$row=mysql_fetch_array($result_max);
		$max_invoice_id=$row[0];
		if($com!=1)
		{
			if($ldrview=='yes')
			{
		?>
            <table class="table table-condensed table-hover" width="100%">
            <tr>
            <th>Ledger Type</th>
            <th>Name</th>
            <th>Credit</th>
            <th>Debit</th>
            </tr>	
		<?php
			}
		}
		for($i=1;$i<=$count;$i++)
		{
			$ds_idd=$_POST['ds_idd'.$i];
			$extra_amnt=$_POST['extra_amnt'.$i];
			$extra_details=$_POST['extra'.$i];
			$main_amnt=$_POST['main_amnt'.$i];
			
		$rs_dss=mysql_query("select `date_from`,`date_to`,`opening_time`,`closing_time`,`service_id`,`car_id`,`car_type_id`,`total_km` from `duty_slip` where `id`='".$ds_idd."'");
			$row_ds=mysql_fetch_array($rs_dss);
			
			$date_from=$row_ds['date_from'];
			$date_to=$row_ds['date_to'];
			$service_id=$row_ds['service_id'];
			$car_id=$row_ds['car_id'];
			$car_type_id=$row_ds['car_type_id'];
			$total_km=$row_ds['total_km'];
			
			$main1= strtotime($date_from);
			$main2 = strtotime($date_to);
			$days=(($main2-$main1)/86400);
			$closing_time=$row_ds['opening_time'];
			$opening_time=$row_ds['closing_time'];
			
	/*		$temp_car_no=$row_ds['temp_car_no'];
			if(!empty($temp_car_no))
			$car_number=$temp_car_no;
			else
			$car_number=fetchcarno($car_id);  		*/
			
			$car_number=fetchcarno($car_id);
			$amount=$extra_amnt+$main_amnt;
			if(!empty($ds_idd))
			{
			$rs_ds=@mysql_query("update `duty_slip` set `extra_details`='".$extra_details."',`extra_amnt`='".$extra_amnt."',`billing_status`='yes' where `id`='".$ds_idd."'");
			$rs_invoice_detail=@mysql_query("insert into `invoice_detail` set `invoice_id`='".$max_invoice_id."',`duty_slip_id`='".$ds_idd."',`amount`='".$amount."'");
			}
			
			$result_tarrif=mysql_query("select `rate` from `customer_tariff` where customer_id='".$customer_id."' and car_type_id='".$car_type_id."' and service_id='".$service_id."'");
			if(mysql_num_rows($result_tarrif)==0)   
			$result_tarrif=mysql_query("select `rate` from `tariff_rate` where service_id='".$service_id."' and car_type_id='".$car_type_id."'");
			$row_tariff = mysql_fetch_array($result_tarrif);
			if($row_tariff['rate']>0)
			
			if($com==1)
			{
			echo "<script>
			window.open('billing_view.php?id=".$max_invoice_id."','_newtab');
			alert('Entry Updated Successfully.');
			location='billing_menu.php';		
			</script>";	
			}
			else
			{
				if(!empty($ds_idd)&&($row_tariff['rate']>0))
				{
			 $res_supplier_id=mysql_query("select `supplier_id`,`car_type_id` from `car_reg` where `id`='".$car_id."'");
			 $row_supplier_id=mysql_fetch_array($res_supplier_id);
			 $supplier_id=$row_supplier_id['supplier_id'];
			 $car_type_id=$row_supplier_id['car_type_id'];
			 
			  $result_supplier_tariff=mysql_query("select * from `supplier_tariff` where  `supplier_id`='".$supplier_id."'  &&  `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' ");
			 $num_supplier_tariff=mysql_num_rows($result_supplier_tariff);
			 if($num_supplier_tariff==0)
			  $result_supplier_tariff=mysql_query("select * from `supplier_tariff` where  `service_id`='".$service_id."' && `car_type_id`='".$car_type_id."' ");
			  
			 $row_supplier_tariff=mysql_fetch_array($result_supplier_tariff);
			 $supplier_rate = $row_supplier_tariff['rate'];
			 $minimum_chg_km = $row_supplier_tariff['minimum_chg_km'];
			 $extra_km_rate = $row_supplier_tariff['extra_km_rate'];
			 $extra_hour_rate = $row_supplier_tariff['extra_hour_rate'];
			 $minimum_chg_hourly = $row_supplier_tariff['minimum_chg_hourly'];
			 
		///////////////////////////////////////////-----------calculate supplier amount------------------///////////////////////////////////////
		
				$result_service=mysql_query("select `type` from `service` where `id`='".$service_id."'");
				$row_service=mysql_fetch_array($result_service);
				if($row_service['type']=="intercity")
				{	
					$days+=1;
					$total_freerun = $minimum_chg_km*$days;
					$extra_km=$total_km-($total_freerun);
					if($extra_km>0)
					$extra_charge=$extra_km*$extra_km_rate;
					$supp_main_amnt=$supplier_rate*$days;
				}
				else
				{
					if($days==0)
					$days++;
					$var_first_stamp=($date_to)." ".$closing_time;
					$var_second_stamp=($date_from)." ".$opening_time;
					$result_time_diff=mysql_query("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
					$row_time_diff =mysql_fetch_array($result_time_diff);
					$result_min=mysql_query("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
					$row_min_diff =mysql_fetch_array($result_min);
					$total_time_of_car= round($row_min_diff[0]);
					$total_freerun = $minimum_chg_hourly*$days;
					$extra_hours=$total_time_of_car-($total_freerun);
					if($extra_hours>0)
					$extra_charge=$extra_hours*$extra_hour_rate;
					$supp_main_amnt=$supplier_rate*$days;
				}
				$amount_supplier = $supp_main_amnt+$extra_charge;
				$amount_to_cars+=$amount_supplier;	
				
			/*	if($total_km>$minimum_chg_km)                     This concept was used in its earlier software
				{
				$amount_supplier = $supplier_rate+($total_km-$minimum_chg_km)*$extra_km_rate ;
				}
				else 
				{
				$amount_supplier = $supplier_rate;
				}
				$amount_to_cars+=$amount_supplier;		*/
				
  		///////////////////////////////////////////-----------end of supplier amount------------------///////////////////////////////////////			
					if($ldrview=='yes')
					{	
					echo "<tr>
					<td>Car</td>
					<td>".$car_number."</td>
					<td>".$amount_supplier."</td>
					<td>0</td>
					</tr>";
					}
		$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".fetchcarno($car_id)."' && `ledger_type_id`='4'");
		$row_ledger_master=mysql_fetch_array($ledger_master);

		 @mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$max_invoice_id."',`name`='".fetchcarno($car_id)."',`credit`='".$amount_supplier."',`debit`='0',`narration`='".$remarks."',`current_date`='".date("Y-m-d")."'");	
					
			 		}
					
				}  // end of else
			
		}// end of for loop
		if($com!=1)
		{
				if($_POST['discount']>0)	
				{
					$new_grand_total=$grand_total+$discount;
					$car_higher_service_amnt=($new_grand_total-($amount_to_cars+$tax));
				}
				else
				{
					$car_higher_service_amnt=($grand_total-($amount_to_cars+$tax));
				}
					if($ldrview=='yes')
					{
				echo "<tr>
				<td>Customer</td>
				<td>".fetchcustomername($customer_id)."</td>
				<td>0</td>
				<td>".$grand_total."</td>
				</tr>";
					}
				
			$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".fetchcustomername($customer_id)."' && `ledger_type_id`='1'");
			$row_ledger_master=mysql_fetch_array($ledger_master);
					
			@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$max_invoice_id."',`name`='".fetchcustomername($customer_id)."',`credit`='0',`debit`='".$grand_total."',`narration`='".$remarks."',`current_date`='".date("Y-m-d")."'");				
			
				////////////////////// Tax ///////////////////////////////////////////////////////////////
				$h=0;
				$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
				while($row_taxrate=mysql_fetch_array($result_taxrate))
				{$h++;
					if($_POST['taxation'.$h])
					{
						
							if($ldrview=='yes')
							{
								echo "<tr>
								<td>TAX</td>
								<td>".$row_taxrate['name']."</td>      
								<td>".$_POST['taxation'.$h]."</td>
								<td>0</td>
								</tr>";	
							}
							$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
							$row_ledger_master=mysql_fetch_array($ledger_master);
								
							@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$max_invoice_id."',`name`='".$row_taxrate['name']."',`credit`='".$_POST['taxation'.$h]."',`debit`='0',`narration`='".$remarks."',`current_date`='".date("Y-m-d")."'");	
						
					}
				}
				
				
				// note in Higher Education tax ledger_main_id will be 1 due to taxation and name will br Higher Education tax 
				////////////////////// End Tax ///////////////////////////////////////////////////////////////
				
				////////////////////// Discount ///////////////////////////////////////////////////////////////
				if($_POST['discount']>0)
				{
					if($ldrview=='yes')
					{	
				echo "<tr>
				<td>Discount</td>
				<td>".fetchcustomername($customer_id)."</td>
				<td>0</td>
				<td>".$discount."</td>
				</tr>";
					}
					
				$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Discount' && `ledger_type_id`='5'");
				$row_ledger_master=mysql_fetch_array($ledger_master);
			
					@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$max_invoice_id."',`name`='Discount',`credit`='0',`debit`='".$discount."',`narration`='".$remarks."',`current_date`='".date("Y-m-d")."'");	
				}
 				//////////////////////End of Discount///////////////////////////////////////////////////////////////
				if($ldrview=='yes')
				{			
				echo "<tr>
				<td>Ledger</td>
				<td>Car Hire Services</td>
				<td>".$car_higher_service_amnt."</td>
				<td>0</td>
				</tr>";
				}
				$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='Car Hire Services' && `ledger_type_id`='5'");
				$row_ledger_master=mysql_fetch_array($ledger_master);
				
				@mysql_query("insert into `ledger` set `date`='".date("Y-m-d")."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$max_invoice_id."',`name`='Car Higher Services',`credit`='".$car_higher_service_amnt."',`debit`='0',`narration`='".$remarks."',`current_date`='".date("Y-m-d")."'");				
				$total_credit=$tax+$car_higher_service_amnt+$amount_to_cars;
				$total_debit=$discount+$grand_total;
				
				if($ldrview=='yes')
				{
				echo "<tr>
				<td colspan='2'>&nbsp;</td>
				<th>".$total_credit."</th>
				<th>".$total_debit."</th>
				</tr>";
				
				echo '<tr>
				<td colspan="4" style="text-align:center;">
				<a  href="billing_view.php?id='.$max_invoice_id.'" target="_blank" onClick="abc();" class="btn green displaynone"><i class="icon-ok"></i> OK</a>
			    <button class="btn yellow diplaynone" title="Print" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i>  Print</button> 
				</td>
				</tr>';
				}
				if($ldrview=='no')
				{
					?>
					<script>
                    window.open('billing_view.php?id=<?php echo $max_invoice_id; ?>','messageWindow','scrollbars=yes,width=1000,height=600,resizable=none');
                    </script>
                    <?php
						echo "<script language=\"javascript\">alert('Entry Updated Successfully Your Invoice No. will be $max_invoice_id.');location='billing_menu.php';</script>";	
					/*	echo "<script>
						window.open('billing_view.php?id=".$max_invoice_id."','_newtab');
						alert('Entry Updated Successfully.');
						location='billing_menu.php';		
						</script>";	
						*/	
				}
				
		}
				
?>
			</table>
           
<?php
		
		
	 }
   }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 
	 else if(isset($_GET['mode']))
	 {
		 if($_GET['mode']=='view')
		 {
			 $customer_id=$_POST['customer_id'];
			 $invoice_type_id=$_POST['invoice_type_id'];
			 
			 $result_cust=mysql_query("select `servicetax_status` from customer_reg where `id`='".$customer_id."'");
			 $row_cust=mysql_fetch_array($result_cust);
			 
			 $result_invoice_type=mysql_query("select `name` from `invoice_type` where `id`='".$invoice_type_id."'");
			 $row_invoice_type=mysql_fetch_array($result_invoice_type);
			 
			 $date=$_POST['date'];
			 $payment_type=$_POST['payment_type'];
			 $com=$_POST['com'];
			 $remarks=$_POST['remarks'];
			 ?>
           		<form method="post" action="billing_menu.php?exe=final" id="booking">
                <input type="hidden" name="payment_type" value="<?php echo $payment_type; ?>" />
                <input type="hidden" name="remarks" value="<?php echo $remarks; ?>" />
                <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                <input type="hidden" name="invoice_type_id" value="<?php echo $invoice_type_id; ?>" />
                <input type="hidden" name="com" value="<?php echo $com; ?>" id="comple"/>
                <input type="hidden" value="<?php echo $row_cust['servicetax_status']; ?>" id="servicetax_status" />
                <input type="hidden" name="invoice_date" value="<?php echo datefordb($date); ?>" />
                <div class="portlet box blue">
                <div class="portlet-title">
                <h4><i class="icon-gift"></i>Result for <?php echo fetchcustomername($customer_id); ?></h4>
                </div>
                <div class="portlet-body form">
                <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
                <table width="100%" class="table table-bordered table"  style="border-collapse:collapse;">
                <thead>
                <tr>
                <th>Invoice Type</th>
                <th colspan="3">Customer Name</th>
                <th>Date</th>
                <th>Payment Type</th>
                <th colspan="3">Remarks</th>
                </tr>
                </thead>
                <tr>
                <td><?php echo $row_invoice_type['name']; ?></td>
                <td colspan="3"><?php echo fetchcustomername($customer_id); ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $payment_type; ?></td>
                <td colspan="3"><?php echo $remarks; ?></td>
                </tr>
                <?php
                $result=mysql_query("select * from `duty_slip` where `customer_id`='".$customer_id."' and billing_status='no' and `closing_km`<>'0' and waveoff_status!='1' order by `id` "); 
                while($row=mysql_fetch_array($result))
                {$k++;
                ?>
                <tr>
                <td colspan="9" style="text-align: center;">-------------------------------Duty------------------------------------</td>
                </tr>
                <tr>
                <th>DS No.</th>
                <th>Guest Name</th>
                <th>Car</th>
                <th>Service</th>
                <th>Car Number</th>
                <th>Open. KM</th>
                <th>Clos. KM</th>
                <th>Total Ch.</th>
                <th style="text-align:center;">Process ?</th>
                </tr>
                <tr id="fillme<?php echo $k; ?>">
                <td><a class="tooltips" data-placement="bottom" title="Edit Duty Slip From Here" href="update_dutyslip.php?id=<?php echo $row['id']; ?>" target="_blank"><?php echo $row['id']; ?></a></td>
                <td><?php echo $row['guest_name']; ?></td>
                <td><?php echo fetchcarname($row['car_type_id']); ?></td>
                <td><?php echo fetchservicename($row['service_id']); ?></td>
                <td><?php echo fetchcarno($row['car_id']); ?></td>
                <td><?php echo $row['opening_km']; ?></td>
                <td><?php echo $row['closing_km']; ?></td>
                <td><?php echo $row['tot_amnt']; ?></td>
                <td style="text-align:center;"><label><input type="checkbox" class="roomselect" id="check<?php echo $k; ?>"  name="ds_idd<?php echo $k; ?>" onClick="amount_validation(this.id),cal_amount();" value="<?php echo $row['id']; ?>"/></label></td>  
                </tr>
                <?php 
				if(!empty($row['extra']))
				{
					$extra_rate=ceil($row['extra_amnt']/$row['extra_details']);
				?>
                <tr id="fillme_sub<?php echo $k; ?>">
                <td colspan="4">&nbsp;</td>
                <th>Extra <?php echo $row['extra']; ?></th>
                <td><input type="text" id="extra<?php echo $k; ?>" name="extra<?php echo $k; ?>"  onKeyUp="GetExtraChargeKM(this.value,<?php echo $k; ?>);"  value="<?php echo $row['extra_details']; ?>" class="m-wrap small" /></td>
                <td><input type="text" value="<?php echo $row['extra_amnt']; ?>" id="extra_amnt<?php echo $k; ?>" class="m-wrap small" name="extra_amnt<?php echo $k; ?>"/></td>
                <td colspan="2"><input type="hidden" value="<?php echo $extra_rate; ?>"  id="extrarate<?php echo $k; ?>" /></td>
                </tr>
                <?php
				}
				else
				{
					?>
                     <input type="hidden" id="fillme_sub<?php echo $k; ?>" />
                    <input type="hidden" id="extra<?php echo $k; ?>" name="extra<?php echo $k; ?>"  onKeyUp="GetExtraChargeKM(this.value,<?php echo $k; ?>);"  value="<?php echo $row['extra_details']; ?>" class="m-wrap small" />
                <input type="hidden" value="<?php echo $row['extra_amnt']; ?>" id="extra_amnt<?php echo $k; ?>" class="m-wrap small" name="extra_amnt<?php echo $k; ?>"/>
				<input type="hidden" value="<?php echo $extra_rate; ?>"  id="extrarate<?php echo $k; ?>" />
                    <?php
                 }
				?>
	           <input type="hidden" value="<?php echo $row['tot_amnt']; ?>" name="main_amnt<?php echo $k; ?>" id="main_amnt<?php echo $k; ?>" />
                <input type="hidden" value="<?php echo $row['extra_chg']; ?>" id="extra_chg<?php echo $k; ?>" />
	            <input type="hidden" value="<?php echo $row['permit_chg']; ?>" id="permit_chg<?php echo $k; ?>" />
                <input type="hidden" value="<?php echo $row['parking_chg']; ?>" id="parking_chg<?php echo $k; ?>" />
                <input type="hidden" value="<?php echo $row['otherstate_chg']; ?>" id="otherstate_chg<?php echo $k; ?>" />
                <input type="hidden" value="<?php echo $row['guide_chg']; ?>" id="guide_chg<?php echo $k; ?>" />
                <input type="hidden" value="<?php echo $row['misc_chg']; ?>" id="misc_chg<?php echo $k; ?>" />
              
                <?php
				}
				
				$h=0;
				$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
				while($row_taxrate=mysql_fetch_array($result_taxrate))
				{$h++;
			
					$result_taxrate_Data=mysql_query("select * from `taxation_data` where `taxation_id`='".$row_taxrate['id']."' && `date`<='".date('Y-m-d')."' order by date desc limit 1");
					@$row_taxrate_Data=mysql_fetch_array($result_taxrate_Data);
					
						?>
						<input type="hidden" value="<?php echo @$row_taxrate_Data['rate']; ?>" id="tax_rate<?php echo $h; ?>"	/>	
						<?php
					
                }
                ?>
                <input type="hidden" value="<?php echo $k; ?>" id="count" name="count"/>
                <input type="hidden" id="discout_final" name="discout_final"/>
                <tr>
                <th colspan="8" class="centerme">Total</th>
                <td><input type="text" id="total" value="0" readonly class="m-wrap small" name="total" />
                </tr>
                <tr>
                <th colspan="6" class="centerme" style="padding-left: 22%;">Discount</th>
                <td colspan="2">
                <div class="controls">
                <label class="radio"><input name="discount" id="per" onClick="cal_amount();"  type="radio" />Per</label>	
                <label class="radio"><input name="discount" id="amount" onClick="cal_amount();"  checked type="radio"/>Amount</label>
                </div>
                </td>
                <td><input type="text" value="0" autocomplete="off" id="discount" onKeyUp="cal_amount();" required class="m-wrap small" name="discount"/></td>
                </tr>
                <?php
				if($row_cust['servicetax_status']=='yes' && $com!='1')
				{
				
					$h=0;
					$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
					while($row_taxrate=mysql_fetch_array($result_taxrate))
					{$h++;
						
						?>
						<tr>
						<th colspan="8" class="centerme"><?php echo $row_taxrate['name']; ?></th>
						<td><input type="text" name="taxation<?php echo $h; ?>" id="taxation<?php echo $h; ?>" value="0" readonly class="m-wrap small" /></td>
						</tr>	
						<?php
						
					}
				}
				else 
				{
					$h=0;
					$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
					while($row_taxrate=mysql_fetch_array($result_taxrate))
					{$h++;
						?>
						<input type="hidden" name="taxation<?php echo $h; ?>" id="taxation<?php echo $h; ?>" value="0" readonly />
						<?php
					}
				}
				?>
				 <tr>
                <th colspan="8" class="centerme">Other Charges</th>
                <td><input type="text"  id="other_charges" value="0" readonly="readonly" class="m-wrap small"/></td>
                </tr>
                 <tr>
                <th colspan="8" class="centerme">Grand Total</th>
                <td><input type="text"  id="grand_total" name="grand_total" value="0" readonly="readonly" class="m-wrap small"/></td>
                </tr>
                 <tr>
                 <td colspan="9" style="text-align:center">
                 <button type="submit"  style="width:200px !important" name="invoice_reg" class="btn green"><i class="icon-ok"></i> Submit</button>
                 </td>
                 </tr>
                </table>
                </div>
                </div>
                </div>
                </form>
				<?php
		 }
	 }
	 else
	 {
	 ?>
    	<form method="post" action="billing_menu.php?mode=view" class="form-horizontal" name="form_name">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-gift"></i>Billing</h4>
        </div>
        <div class="portlet-body form">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
        
        <div class="control-group">
        <label class="control-label">Invoice Type</label>
        <div class="controls">
        <select name="invoice_type_id" class="span6 m-wrap">
        <?php 
        $result=mysql_query("select distinct `id`,`name` from `invoice_type`");
        while($row=mysql_fetch_array($result))
        {
        echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select>
        </div>
        </div>
        
     	<div class="control-group">
        <label class="control-label">Customer Name</label>
        <div class="controls">
        <select name="customer_id" class="span6 m-wrap chosen">
        <option value="">---select customer---</option>
        <?php 
        $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
        while($row=mysql_fetch_array($result))
        {
        echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select>
        </div>
        </div>
        
       	<div class="control-group">
        <label class="control-label">Date</label>
        <div class="controls">
        <input type="text" name="date" value="<?php echo date("d-m-Y"); ?>"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Payment Type</label>
        <div class="controls">
        <select name="payment_type" class="span6 m-wrap">
        <option value="Cash">Cash</option>
        <option value="Credit">Credit</option>
        </select>    
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Billed Complimenatry Charges</label>
        <div class="controls">
        <label class="radio"><input type="radio" name="com" value="1"  id="r1" onchange="HideAuth();" />Yes</label>	
        <label class="radio"><input type="radio" name="com"  value="0" checked="checked" id="r2" onchange="HideAuth();" />No</label>
        </div>
        </div>
        
      <!--  <div class="control-group"  id="authperson_row" style="display:none;">
        <label class="control-label">Authorized Person:</label>
        <div class="controls">
        <input type="text" name="authperson" class="span6 m-wrap"/>
        </div>
        </div> -->

        <div class="control-group">
        <label class="control-label">Remarks</label>
        <div class="controls">
        <input type="text" name="remarks"  class="span6 m-wrap" >
        </div>
        </div>
        
        </table>
        <div class="form-actions">
        <button type="submit"   class="btn green" name="customer_tariff_reg"/><i class="icon-ok"></i> Submit</button>
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
 <script>
 jQuery(function ($) {
    //form submit handler
    $('#booking').submit(function (e) {
        //check atleat 1 checkbox is checked
        if (!$('.roomselect').is(':checked')) {
			alert('Please select atleast one check box');
            //prevent the default form submit if it is not checked
            e.preventDefault();
        }
		if(eval($('#total').val())==0)
		{
			alert('You should can not be submit 0 amount.');
			e.preventDefault();
		}
    })
})
 </script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>