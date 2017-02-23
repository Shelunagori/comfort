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
<style>
th
{
text-align:center !important;
}
</style>
<script>
function cal_amount()
{  
	var total=0;
	var total_other=0;
	var net_total=0;
	var val=0;
	var all_tax=0;
	var tax_status=0;
	
    var discount_rate=eval(document.getElementById('discount').value);
	var count=eval(document.getElementById("count").value);
	for(var i=1; i<=count; i++)
	{
		var main_amnt=eval(document.getElementById('main_amnt'+i).value);
		var extra_amnt=eval(document.getElementById('extra_amnt'+i).value);
		total+=extra_amnt+main_amnt;
		var extra_chg=eval(document.getElementById('extra_chg'+i).value);
		var permit_chg=eval(document.getElementById('permit_chg'+i).value);
		var parking_chg=eval(document.getElementById('parking_chg'+i).value);
		var otherstate_chg=eval(document.getElementById('otherstate_chg'+i).value);
		var guide_chg=eval(document.getElementById('guide_chg'+i).value);
		var misc_chg=eval(document.getElementById('misc_chg'+i).value);
		total_other+=extra_chg+permit_chg+parking_chg+otherstate_chg+guide_chg+misc_chg;
		
	}
	net_total=total+total_other;
	var discount_amnt = 0;
	if(discount_rate>0){
		if(document.getElementById('per').checked==true)
		{
			  discount_amnt=Math.round((total)*discount_rate/100);
		}
		else
		{
			  discount_amnt=discount_rate;
		}
	}
	
	var val=(net_total-(total_other+discount_amnt));
	 
	var total_tax_amnt=0;	
	var tax=0;
	var tax_amnt=0;
	if(total_other!=0)
	{
	 document.getElementById("other_charges").value=total_other;
	}

	var applicable=document.getElementById('tax_status').value;
	 	 
	if(document.getElementById('tax_status').value=='yes')
	{ 
		<?php
		$h=0;
		$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
		while($row_taxrate=mysql_fetch_array($result_taxrate))
		{$h++; ?>
			tax=eval(document.getElementById('tax_rate<?php echo $h; ?>').value);
			if(tax != 0)
			{
				tax_amnt= val*tax/100;
	 
				total_tax_amnt+=tax_amnt;
				var taxx = tax_amnt.toFixed(2); 
				document.getElementById('taxation<?php echo $h; ?>').value=taxx;
				
			}
			
		<?php
		} ?>
		var all_over_total = Math.round(val+total_other+total_tax_amnt);
		
	}
	else
	{ 
		var all_over_total = val+total_other;
	}
	

	document.getElementById("total").value=total;
	
	tax_status=$('#tax_status').val();
	
 	document.getElementById("grand_total").value=(all_over_total);
}
</script>
</head>
<body class="fixed-top" onLoad="cal_amount();">
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
        $result_invoice=mysql_query("select * from invoice where `id`='".$_GET['id']."'");
        $row_invoice=mysql_fetch_array($result_invoice);
        
	    $result_guest2=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$_GET['id']."'");
		while($row_duty=mysql_fetch_array($result_guest2))
		{
			$duty_slip_id[]=$row_duty['duty_slip_id'];
		}
		$ds=@implode(",",$duty_slip_id);
		$result_guest2=mysql_query("select `guest_name` from `duty_slip` where `id`='".$duty_slip_id[0]."'");
		$row_guest2=mysql_fetch_array($result_guest2);
		$guest_name=$row_guest2['guest_name'];
		
        ?>
		<form method="post" name="add_form" action="Handler.php">
		<input type="hidden" name="current_date" value="<?php echo $row_invoice['current_date']; ?>" class="m-wrap medium"/>
		<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
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
        
         <table width="100%" style="margin-top:1%;" class="table table-bordered table-condensed flip-content">
                <tr> 
                <td width="15%">Bill To M/s.</td>
                <td width="45%"> 
                <select name="customer_id" class="m-wrap medium chosen">
                <option value="">---select customer---</option>
                <?php 
                $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
                while($row=mysql_fetch_array($result))
                {
				if($row_invoice['customer_id']==$row['id'])	
                echo "<option value='".$row['id']."' selected >".$row['name']."</option>";
				else
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
                }
                ?>
                </select>
        		</td>
                <td width="15%">Invoice No.</td>
                <td width="15%"><?php echo $row_invoice['id']; ?></td>
                </tr>
                
               
                
                <tr> 
                <td>Guest Name</td>
                <td><input type="text" name="guest_name" value="<?php echo $guest_name; ?>" class="m-wrap medium"/></td>
                <td>Date</td>
                <td><input type="text" name="date" value="<?php echo dateforview($row_invoice['date']); ?>" class="m-wrap medium date-picker" /></td>
                </tr>
                 <tr>
                <td>Remarks.</td>
                <td colspan="3"><input type="text" class=" span12 m-wrap" name="remarks" value="<?php echo $row_invoice['remarks']; ?>"/></td>
                </tr>
                <tr>
                <td>REF.</td>
                <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                <th colspan="2">Description</th>
                <td></td>
                <th colspan="">Amount in INR</th>
                </tr>
				<?php
                $result_invoice_detail=mysql_query("select * from `invoice_detail` where `invoice_id`='".$row_invoice['id']."' order by `duty_slip_id`");	
                while($row_invoice_detail=mysql_fetch_array($result_invoice_detail))
                {
				$i++;
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
                <tr>
                <td colspan="2" style="text-align:left"><?php echo "Duty Slip No. ".$row_invoice_detail['duty_slip_id']." dated on ".dateforview($row_duty['date'])." "."towards the cost of transport used in Udaipur for the Service ".fetchservicename($row_duty['service_id'])." (".$row_rariff['minimum_chg_hourly']." hrs / ".$row_rariff['minimum_chg_km']." kms) by ".fetchcarname($row_duty['car_type_id'])." ".$car_no ?></td>
                <td></td>
                <th colspan=""><input type="text" name="main_amnt<?php echo $i; ?>" onKeyUp="cal_amount();" value="<?php echo $main_amnt; ?>" id="main_amnt<?php echo $i; ?>" class="m-wrap small"/></th>
                </tr>
					<?php
                    if(!empty($row_duty['extra']))
                    {
                        ?>
                            <tr>
                            <th colspan="2">Extra <?php echo $row_duty['extra']; ?>: <?php echo $row_duty['extra_details']; ?></th>
                            <td></td>
                            <th colspan=" "><input type="text" name="extra_amnt<?php echo $i; ?>" onKeyUp="cal_amount();" id="extra_amnt<?php echo $i; ?>" value="<?php echo $row_duty['extra_amnt']; ?>" class="m-wrap small"/></th>
                            </tr>
                        <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="extra_amnt<?php echo $i; ?>" value="0" />
                        <?php
					}
                    if(!empty($row_duty['extra_chg']))
                    {
                    ?>
                            <tr>
                            <td colspan="2">Toll Tax</td>
                            <td></td>
                            <th colspan=" "><input type="text" name="extra_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="extra_chg<?php echo $i; ?>" value="<?php echo $row_duty['extra_chg']; ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="extra_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
                    if(!empty($row_duty['permit_chg']))
                    {
                    ?>
                            <tr>
                            <td colspan="2">Permit Charges</td>
                            <td></td>
                            <th colspan=" "><input type="text" name="permit_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="permit_chg<?php echo $i; ?>" value="<?php echo $row_duty['permit_chg']; ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="permit_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
					if(!empty($row_duty['parking_chg']))
                    {
                    ?>
                            <tr>
                            <td colspan="2">Parking Charges</td>
                            <td></td>
                            <th colspan=" "><input type="text" name="parking_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="parking_chg<?php echo $i; ?>" value="<?php echo $row_duty['parking_chg']; ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="parking_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
					if(!empty($row_duty['otherstate_chg']))
                    {
                    ?>
                            <tr>
                            <td colspan="2">Driver Allowance:</td>
                            <td></td>
                            <th colspan=" "><input type="text" name="otherstate_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="otherstate_chg<?php echo $i; ?>" value="<?php echo $row_duty['otherstate_chg']; ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="otherstate_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
					if(!empty($row_duty['guide_chg']))
                    {
                    ?>
                            <tr>
                            <td colspan="2">Border Tax:</td>
                            <td></td>
                            <th colspan=" "><input type="text" name="guide_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="guide_chg<?php echo $i; ?>" value="<?php echo $row_duty['guide_chg']; ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
                    }
					else
					{
						?>
                       <input type="hidden" id="guide_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
					if(!empty($row_duty['misc_chg']))
					{
					?>
                        <tr>
                        <td colspan="2">Miscellaneous Charges</td>
                        <td></td>
                        <th colspan=" "><input type="text" name="misc_chg<?php echo $i;?>" onKeyUp="cal_amount();" id="misc_chg<?php echo $i; ?>" value="<?php echo $row_duty['misc_chg']; ?>" class="m-wrap small"/></th>
                        </tr>
                      
                    <?php
					}
					else
					{
						?>
                       <input type="hidden" id="misc_chg<?php echo $i; ?>" value="0" />
                        <?php
					}
					?>
                    <input type="hidden" value="<?php echo $row_invoice_detail['duty_slip_id']; ?>" name="duty_slip_id<?php echo $i; ?>" />  
                    <input type="hidden" value="<?php echo $row_invoice_detail['id']; ?>" name="invoice_detail_id<?php echo $i; ?>" />      
                    <?php
                }
                ?>	
                    <tr>
                    <th colspan="2">Total</th>
                    <td></td>
                    <th colspan=""><input type="text"  name="total"   autocomplete="off" onKeyUp="cal_amount();" id="total" value="<?php echo $row_invoice['total']; ?>" class="m-wrap small" readonly="readonly" /></th>
                    </tr>
                   
					 
                      		<tr>
                            <th colspan="2">Discount</th>
                            <td>
                            <div class="controls">
                            <label class="radio"><input name="discount" id="per" onClick="cal_amount();"  type="radio" />Per</label>	
                            <label class="radio"><input name="discount" id="amount" onClick="cal_amount();"  checked type="radio"/>Amount</label>
                            </div>
                            </td>
                            <th><input type="text"  name="discount" id="discount" onKeyUp="cal_amount();" value=" <?php if(!empty($row_invoice['discount'])){ echo $row_invoice['discount']; } ?>" class="m-wrap small"/></th>
                            </tr>
                    <?php
				 
					 
					if(!empty($row_invoice['tax']))
					{
						$h=0;
						$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
						while($row_taxrate=mysql_fetch_array($result_taxrate))
						{$h++;
							$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
							$row_ledger_master=mysql_fetch_array($ledger_master);
							
							$ledger=mysql_query("select `credit` from `ledger` where `name`='".$row_taxrate['name']."' && `ledger_master_id`='".$row_ledger_master['id']."' && `invoice_id`='".$row_invoice['id']."'");
							while($row_ledger=mysql_fetch_array($ledger))
							{
							?>
							<tr>
							<th colspan="2"><?php echo $row_taxrate['name']; ?></th>
                            <td></td>
							<th colspan=" "><input type="text" autocomplete="off" name="taxation<?php echo $h; ?>" id="taxation<?php echo $h; ?>" value="<?php echo $row_ledger['credit']; ?>"  class="m-wrap small" readonly="readonly" /></th>
							</tr>	
							<?php
							}
							
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
                            <th colspan="2">Other Charges</th>
                            <td></td>
                            <th colspan=" "><input type="text"  id="other_charges" value="0" readonly="readonly" class="m-wrap small"/></th>
                            </tr>	
                            <tr>
                            <th colspan="2">Grand Total</th>
                            <td></td>
                            <th colspan=" "><input type="text"  name="grand_total" id="grand_total" value="<?php echo $row_invoice['grand_total']; ?>" class="m-wrap small"/></th>
                            </tr>
                            
                            <tr>
                            <td colspan="4"><b><?php echo convert_number_to_words($row_invoice['grand_total']); ?></b></td>
                            </tr>
                            
                            <tr>
                            <td colspan="2"><b>SIGNATURE IN CONFIRMATION</b><br/><span style="font-size: 11px; font-style:italic;">of terms & condition overleaf</span></td>
                            <td colspan="2">For: Comfort Travels & Tours</td>
                            </tr>
                            
                            <tr><td colspan="4" style="border-bottom:none;">&nbsp;</td></tr>
                            <tr><td colspan="4" style="border-top:none;">&nbsp;</td></tr>
                            
                            <tr>
                            <td colspan="2">(Name............................................)</td>
                            <td colspan="2"><!--<img src="assets/<?php echo fetchimg(); ?>" style="width: 30%;! important; padding: 5px;"/><br/>-->Authorised Signatory</td>
                            </tr>
                            
                            <tr>
                            <td colspan="4"  style="color:#0872BA;"><b>Other Info.</b> <span>PAN No. AAWPC1369E, Service Tax: AAWPC1369EST001<br /><b>Email:-</b> operations@comforttours.com ,  siddhant.chatur@comforttours.com</span></td>
                            </tr>
                        
                        <tr>
                        <td colspan="4" style="text-align:center;background-color:#F5F5F5;">   
						<?php
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
                        <?php
						$result_cust=mysql_query("select `servicetax_status` from customer_reg where `id`='".$row_invoice['customer_id']."'");
						$row_cust=mysql_fetch_array($result_cust);
						?>
                        <input type="hidden" name="tax_status" id="tax_status" value="<?php echo $row_cust['servicetax_status']; ?>"  />
                        <input type="hidden" name="count" value="<?php echo $i; ?>" id="count" />
                        <input type="hidden" name="invoice_id" value="<?php echo $row_invoice['id']; ?>" /> 	
                        <button type="submit"  class="btn green" name="update_billing" value="update_billing"><i class="icon-question-sign"></i> Save Change</button>
                        <button type="button"  class="btn yellow" name="reset" onClick="javascript:;window.close();"><i class="icon-remove"></i> Close</button>
                        </td>
                        </tr>
                        
                  </table>
                </div>
                </form>
                
        
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
 <script>
$( document ).ready(function() {
	$('form[name=add_form]').live('submit',function(e)
	{
		var grand_total=$('#grand_total').val();
		if(grand_total<=0)
		{
			e.preventDefault();
		}
	});
});
</script>
 <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>