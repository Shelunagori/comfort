<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
date_default_timezone_set('Asia/Calcutta');	
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Comfort</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
  <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">

function deleteInvoice(id)
{
	var reason=prompt("Reason for Deletion ?","");
	var ajaxRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			if(ajaxRequest.responseText=="completed")
			{
				location.reload();
			}
		}
	}
		ajaxRequest.open("GET", "get_teriff_rate.php?invoicedelete="+id+"&reason="+reason, true);
		ajaxRequest.send(null);
}

function HideAuth()
{
	
	if (document.getElementById('authperson_row').style.display == 'none') {
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

function GetExtraChargeKM(itemid,dutyid)
{
	document.getElementById('txtextrakmchg'+dutyid).value=document.getElementById('txtextrakm'+dutyid).value*document.getElementById('hidden'+dutyid).value;
}

function GetExtraChargeHours(itemid,dutyid)
{
	document.getElementById('txtextrahrschg'+dutyid).value=document.getElementById('txtextrahrs'+dutyid).value*document.getElementById('hidden'+dutyid).value;
}

function cal_grand_total()
{
	
	if(document.getElementById('notax')==null)
	{
	var final_total = parseInt(document.getElementById('total').value);
	var discount = parseInt(document.getElementById('discount').value);
	var stax = parseFloat(document.getElementById('stax').value);
	var etax = parseFloat(document.getElementById('etax').value);
	var hetax = parseFloat(document.getElementById('hetax').value);
	var temp = parseFloat(document.getElementById('extra_total').value);
	if(document.getElementById('per').checked==true)
	{
		discount=(final_total-temp)*discount/100;
	}
	var val = (final_total-(discount+temp));
	var stax = val*4.8/100;
	document.getElementById('stax').value=Math.round(stax);
	document.getElementById('etax').value=Math.round(stax*2/100);
	document.getElementById('hetax').value=Math.round(stax*1/100);
     document.getElementById("grand_total").value=((parseFloat(final_total)-discount)+stax+etax+hetax);
	//alert(document.getElementById("grand_total").value);
	//document.getElementById("grand_total").value=Math.round((parseFloat(final_total)-discount)+stax+etax+hetax+temp);
	
	document.getElementById('mydiscount').value=discount;
	}
	else
	{
		var final_total = parseInt(document.getElementById('total').value);
		
		var discount = parseInt(document.getElementById('discount').value);
		if(document.getElementById('per').checked==true)
		{
			discount=(final_total)*discount/100;
		}
		document.getElementById("grand_total").value=(parseFloat(final_total)-discount); 
		// alert(document.getElementById("grand_total").value);
		//document.getElementById("grand_total").value=Math.round((parseFloat(final_total)-discount));
		document.getElementById('mydiscount').value=discount;
	}	
}



function cal_total(id,vall,dutyid,rate)
{	

	if(document.getElementById('notax')==null)
	{
	 var val = parseInt(document.getElementById('total').value);
	 var discount = parseFloat(document.getElementById('discount').value);
		
		if(document.getElementById('per').checked==true)
		{
			discount=(val)*discount/100;
		}
		
     if (id.checked == true) {
         val+= parseInt(vall);
         document.getElementById('extra_total').value=parseInt(document.getElementById('extra_total').value)+rate;
         //alert(document.getElementById('extra_total').value);
		if(document.getElementById('txtextrakmchg'+dutyid)!=null)
		{
			val+= parseInt(document.getElementById('txtextrakmchg'+dutyid).value);
			document.getElementById('txtextrakm'+dutyid).readOnly=true;
		}
		else if(document.getElementById('txtextrahrschg'+dutyid)!=null)
		{
			val+= parseInt(document.getElementById('txtextrahrschg'+dutyid).value);
			document.getElementById('txtextrahrs'+dutyid).readOnly=true;
		}
         document.getElementById('total').value = val;
     }
     else {
         val-= parseInt(vall);
         document.getElementById('extra_total').value=parseInt(document.getElementById('extra_total').value)-rate;
		 document.getElementById('discount').value=0;
  //       alert(document.getElementById('extra_total').value);
          if(document.getElementById('txtextrakmchg'+dutyid)!=null)
 		{
 			val-= parseInt(document.getElementById('txtextrakmchg'+dutyid).value);
 			document.getElementById('txtextrakm'+dutyid).readOnly=false;
 		}
 		else if(document.getElementById('txtextrahrschg'+dutyid)!=null)
 		{
 			val-= parseInt(document.getElementById('txtextrahrschg'+dutyid).value);
 			document.getElementById('txtextrahrs'+dutyid).readOnly=false;
 		}
         document.getElementById('total').value = val;
     }

	// 	alert(dutyid);
	 val = parseInt(document.getElementById('total').value-document.getElementById('extra_total').value)-discount;
     var stax = val*4.8/100;
	 document.getElementById('stax').value=Math.round(stax);
	 document.getElementById('etax').value=Math.round(stax*2/100);
	 document.getElementById('hetax').value=Math.round(stax*1/100);
	}
	else
	{
		var val = parseInt(document.getElementById('total').value);
		if (id.checked == true) {
	         val+= parseInt(vall);
			if(document.getElementById('txtextrakmchg'+dutyid)!=null)
			{
				val+= parseInt(document.getElementById('txtextrakmchg'+dutyid).value);
				document.getElementById('txtextrakm'+dutyid).readOnly=true;
			}
			else if(document.getElementById('txtextrahrschg'+dutyid)!=null)
			{
				val+= parseInt(document.getElementById('txtextrahrschg'+dutyid).value);
				document.getElementById('txtextrahrs'+dutyid).readOnly=true;
			}
	         document.getElementById('total').value = val;
	     }
	     else {
	         val-= parseInt(vall);
	         if(document.getElementById('txtextrakmchg'+dutyid)!=null)
	 		{
	 			val-= parseInt(document.getElementById('txtextrakmchg'+dutyid).value);
	 			document.getElementById('txtextrakm'+dutyid).readOnly=false;
	 		}
	 		else if(document.getElementById('txtextrahrschg'+dutyid)!=null)
	 		{
	 			val-= parseInt(document.getElementById('txtextrahrschg'+dutyid).value);
	 			document.getElementById('txtextrahrs'+dutyid).readOnly=false;
	 		}
	         document.getElementById('total').value = val;
	     }
	}
	cal_grand_total();
}

</script>
<script type="text/javascript">
function MyFun()
{
	window.open("InvoiceView.php?invoiceid="+document.getElementById('maxinvoiceid').value,"Invoice View");
	// window.open("InvoiceView_new.php?invoiceid="+document.getElementById('maxinvoiceid').value,"Invoice View");
	window.location="billing_menu.php";
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
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post" name="form_name">
<!--<div>                     
<a href="billing_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<a href="billing_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="billing_menu_search.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div>   -->
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-signal"></i>Billing</h4>
                    </div>
                    <div class="portlet-body form">
        <table width="100%">
              	<tr><td style="width: 30%;">  Invoice Type</td><td>
              	<select name="invoice_type_type_id" class="m-wrap medium">
              	<?php 
              		$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select name from invoice_type");
						while($row=mysql_fetch_array($result))
						{
							echo "<option>".$row['name']."</option>";
						}
					$mydatabase->close_connection();
              	?>
              	</select>
              	</td></tr>
				<tr><td>Customer Name  </td><td> 
                <select name="duty_slip_customer_reg_name"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select *  from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
									 $id = $row['id'];
								   echo '<option value="'.$id.'">'.$name.'</option>';
									}
        				      ?>

     </select></td></tr>
				<tr><td> Date </td><td><input type="text" id="dp1" value="<?php echo DatePickerDate(date('Y-m-d'));?>" name="date" class="m-wrap medium"/> </td></tr>
				<tr><td>Payment Type </td><td>
				<select name="payment_type" class="m-wrap medium">
				<option value="Cash">Cash</option>
				<option value="Credit">Credit</option>
				</select> 
				</td></tr>
				<tr><td> Billed Complimenatry Charges: </td><td> 
                 <div class="control-group">
                                      <div class="controls">
					<label class="radio"><input type="radio" name="billed_complimentary" id="r1" onchange="HideAuth()" value="yes" />Yes</label>	
                    <label class="radio"><input type="radio" name="billed_complimentary" id="r2" onchange="HideAuth()" value="no" checked="checked" />No</label>
                    </div></div>
				</td></tr>
				<tr id="authperson_row" style="display: none;"><td>Authorized Person:</td><td><input type="text" name="authperson" class="m-wrap medium"/> </td></tr>
				<tr><td> Service Tax Applicable: </td><td> 
                 <div class="control-group">
                                      <div class="controls">
					<label class="radio"><input type="radio" name="tax_app" id="r3" value="yes" checked="checked"  />Yes</label>
                    <label class="radio"><input type="radio" name="tax_app" id="r4" value="no"  />No</label>
                    </div></div>
				</td></tr>
				<tr><td> Authorized Person: </td><td><input readonly="readonly" type="text"  name="auth"  class="m-wrap medium" value="<?php echo $_SESSION['username'];?>"/> </td></tr>
				<tr><td> Remarks: </td><td><input type="text" name="remarks" class="m-wrap medium" /> 
                <button type="submit" style="margin-left:1%;"  class="btn green" name="booking" >Go <i class="icon-circle-arrow-right"></i></button></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <?php
				if(isset($_POST['booking']))
				{
					$all_duty_slip_ids=array();
					?> 
					<?php 
					if($_POST['tax_app']=="no")
					{
						echo "<input type=\"hidden\" id=\"notax\" />";
					}
					?>
                     <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%" class="table table-bordered table-hover"  style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th >Invoice Type</th>
                        <th >Customer Name</th>
                        <th  colspan="2">Date</th>
                        <th  colspan="2">Payment Type</th>
                        <th >Remarks</th>
                         <th  colspan="2"></th>
                        </tr>
                    </thead>
                     <tbody>
                     <?php          
						$_SESSION['invoice_type_type_id']=$invoice_type_type_id=$_POST['invoice_type_type_id'];
						$_SESSION['authperson']=$authperson=$_POST['authperson'];
						$_SESSION['duty_slip_customer_reg_name']=$duty_slip_customer_reg_name=$_POST['duty_slip_customer_reg_name'];
						$date=$_POST['date'];
						$_SESSION['date']=DateExact($date);
						$_SESSION['payment_type']=$payment_type=$_POST['payment_type'];
						$_SESSION['billed_complimentary']=$_POST['billed_complimentary'];
						$_SESSION['remarks']= $remarks = $_POST['remarks'];
						$qry="select * from `customer_reg` where `id`='$duty_slip_customer_reg_name'";
						$data_base_object = new DataBaseConnect();
						$result= $data_base_object->execute_query_return($qry);
						$row=mysql_fetch_array($result);
						$customer_name=$row['name'];
                     	 ?>
                            <tr>
                            <td><?php echo $invoice_type_type_id;?></td>
                            <td><?php echo $customer_name;?></td>
                            <td colspan="2"><?php echo $date;?></td>
                            <td colspan="2"><?php echo $payment_type;?></td>
                            <td><?php echo $remarks;?></td>
                            <td  colspan="2"></td>
                            </tr>
                   <?php  	 
                        $qry="select * from duty_slip where customer_reg_name='".$duty_slip_customer_reg_name."' and status='no' and `closing_km`<>'0' order by `dutyslip_id`" ;
                        $data_base_object = new DataBaseConnect();
                        $result= $data_base_object->execute_query_return($qry);
                        if($result)
                        {
                        	$final_total=0;
                        while($row=mysql_fetch_array($result))
                        {
                        	?>
                            <tr >
                            <td colspan="9" style="text-align: center;">-------------------------------Duty------------------------------------ </td>
                            </tr>
	                        <tr>
	                        <th ><b>Duty Slip No.</b></th>
                            <th ><b>Guest Name</b></th>
	                        <th ><b>Car</b></th>
	                        <th ><b>Service</b></th>
	                        <th ><b>Car Number</b></th>
	                        <th ><b>Opening KM</b></th>
	                        <th ><b>Closing KM</b></th>
	                        <th  ><b>Total Ch.</b></th>
	                        <th >Process ?</th>
	                        </tr>
	                    	<?php
	                    	$dutyslip_id=$row['dutyslip_id'] ;
							$guest_name = $row['guest_name'];
	                    	$all_duty_slip_ids[]=$dutyslip_id; //  getting all duty slip id with billing name and registered customer
                        	$carname_master_id=$row['carname_master_id'];
							$qry_car="select * from `carname_master` where `id`='$carname_master_id'";
							$data_base_object_car = new DataBaseConnect();
							$result_car= $data_base_object_car->execute_query_return($qry_car);
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];
                        	$car_reg_name=$row['car_reg_name'];
							$new_car_no = $row['new_car_no'];
							
							$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
							$data_base_object = new DataBaseConnect();
							$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
							$row_carid = mysql_fetch_array($result_carid);
							$car_reg_name_new=$row_carid['name'];
							if($car_reg_name_new=="Others")
							{
							$car_reg_name_new=$new_car_no;
							}
                        	$service_service_id=$row['service_service_id'];
							$qry_service="select * from `service` where `service_id`='$service_service_id'";
							$data_base_object_service = new DataBaseConnect();
							$result_service= $data_base_object_service->execute_query_return($qry_service);
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
	                    	$opening_km=$row['opening_km'];
							$closing_km=$row['closing_km'];
							$extra_chg=$row['extra_chg'];
							$permit_chg=$row['permit_chg'];
							$parking_chg=$row['parking_chg'];
                            $otherstate_chg=$row['otherstate_chg'];
                            $guide_chg=$row['guide_chg'];
                            $misc_chg=$row['misc_chg'];
                            $total_chg=$row['amount'];
                            $rate=$row['rate'];
							$date_from_st=$row['date_from'];
							$date_to_ed=$row['date_to'];
							
							$main1= strtotime($date_from_st);
							$main2 = strtotime($date_to_ed);
							$days=(($main2-$main1)/86400);
							
							$tot_chg = $total_chg+($rate*$days);
							
							$new_days = $days+1;
							
							if($days==0)
							{
							$incity_days=1;
							}
							else
							{
							$incity_days=$days;	
							}
                            $extra_charge=$total_chg-$rate;
							
                            //$total_chg=$minimum_chg+$extra_chg+$permit_chg+$parking_chg+$otherstate_chg+$guide_chg+$misc_chg;
                       ?>
                            <tr>
                            <td><a href="update_dutyslip.php?id=<?php echo $dutyslip_id;?>" target="_new"><b><?php echo $dutyslip_id;?></b></a></td>
                              <td><?php echo $guest_name;?></td>
                            <td><?php echo $car_name;?></td>
                            <td><?php echo $service_name;?></td>
                            <td><?php echo $car_reg_name_new;?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                            <td><?php echo $tot_chg;?></td>
                           <td><input onchange="cal_total(this,<?php echo $tot_chg;?>,<?php echo $dutyslip_id;?>,<?php echo $extra_charge;?>)" type="checkbox" name="<?php echo "dutyslip".$dutyslip_id ; ?>" style="width: 50px;"/> 
                            <input type="hidden" value="0" id="extra_total" />
                            </td>
                            </tr>
                          
                          
                          
                          
                          
                          
						<?php 
						$result_what=$data_base_object->execute_query_return("select `type` from `service` where `service_id`='".$service_service_id."'");
						$row_what=mysql_fetch_assoc($result_what);
						$service_type=$row_what['type'];
						if($service_type=='intercity')
						{
						
						$result_cust=$data_base_object->execute_query_return("select * from `customer_tariff` where `customer_reg_name`='".$_SESSION['duty_slip_customer_reg_name']."' and `carname_master_id`='".$carname_master_id."' and `service_service_id`='".$service_service_id."'");
						$extra_km_charge=0;
						$extra_km=0;
						$extra_per_km=0;
						if(mysql_num_rows($result_cust)>0)
						{
							$row_cust=mysql_fetch_assoc($result_cust);
							$minimum_chg_km=$row_cust['minimum_chg_km'];
							$total_freerun = $minimum_chg_km*$new_days;
							$extra_km=$row['total_km']-($total_freerun);
							$extra_km_charge=($extra_km)*$row_cust['extra_km_rate'];
							$extra_per_km=$row_cust['extra_km_rate'];
						}
						else
						{
							
							$result_tariff=$data_base_object->execute_query_return("select * from `tariff_rate` where `carname_master_id`='".$carname_master_id."' and `service_service_id`='".$service_service_id."'");
						
								$row_tariff=mysql_fetch_assoc($result_tariff);
								$minimum_chg_km=$row_tariff['minimum_chg_km'];
								$total_freerun = $minimum_chg_km*$new_days;
								$extra_km=$row['total_km']-($total_freerun);
								$extra_km_charge=($extra_km)*$row_tariff['extra_km_rate'];
								$extra_per_km=$row_tariff['extra_km_rate'];
							
						  }
							
												
							if($extra_km>0)
							{
							?>
                            
	                            <tr>
	                              <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td><b>Extra Km:</b></td>
	                            <td><input id="<?php echo "txtextrakm".$dutyslip_id ?>" onKeyUp="GetExtraChargeKM(this.id,<?php echo $dutyslip_id;?>)" class="m-wrap small" type="text" value="<?php echo $extra_km;?>" /></td>
	                            <td><input  type="text" class="m-wrap small" name="<?php echo "txtextrakmchg".$dutyslip_id ?>" id="<?php echo "txtextrakmchg".$dutyslip_id ?>" value="<?php echo $extra_km_charge;?>" /></td>
	                            <td><input id="<?php echo "hidden".$dutyslip_id ?>" type="hidden" value="<?php echo $extra_per_km; ?>" /></td>
                                <td>&nbsp;</td>
	                            </tr>
	                            <?php 
							}
						}
						else if($service_type=='incity'){
							
						
							$result_cust=$data_base_object->execute_query_return("select * from `customer_tariff` where `customer_reg_name`='".$_SESSION['duty_slip_customer_reg_name']."' and `carname_master_id`='".$carname_master_id."' and `service_service_id`='".$service_service_id."'");
					
						$extra_hours=0;
						$extra_hours_charges=0;
						$extra_per_hour=0;
						if(mysql_num_rows($result_cust)>0)
						{
					                 $row_cust=mysql_fetch_assoc($result_cust);
							        $var_first_stamp =$row['date_to']." ".$row['closing_time'];
									$var_second_stamp =$row['date_from']." ".$row['opening_time'];
									$result_time_diff=$data_base_object->execute_query_return("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=$data_base_object->execute_query_return("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
								
										$extra_hours=$total_time_of_car-(($row_cust['minimum_chg_hourly'])*$incity_days);
										$extra_hours_charges=$extra_hours*$row_cust['extra_hour_rate'];
										$extra_per_hour=$row_cust['extra_hour_rate'];
						}
						else
						{
							
							$result_tariff=$data_base_object->execute_query_return("select * from `tariff_rate` where `carname_master_id`='".$carname_master_id."' and `service_service_id`='".$service_service_id."'");
						            
									$row_tariff=mysql_fetch_assoc($result_tariff);
							     	$var_first_stamp =$row['date_to']." ".$row['closing_time'];
									$var_second_stamp =$row['date_from']." ".$row['opening_time'];
									$result_time_diff=$data_base_object->execute_query_return("select timediff('".$var_first_stamp."','".$var_second_stamp."')");
									$row_time_diff =mysql_fetch_array($result_time_diff);
									$result_min=$data_base_object->execute_query_return("select time_to_sec('".$row_time_diff[0]."')/(60*60)");
									$row_min_diff =mysql_fetch_array($result_min);
									$total_time_of_car= round($row_min_diff[0]);
								
										$extra_hours=$total_time_of_car-(($row_tariff['minimum_chg_hourly'])*$incity_days);
										$extra_hours_charges=$extra_hours*$row_tariff['extra_hour_rate'];
										$extra_per_hour=$row_tariff['extra_hour_rate'];
						  }					
							
						if($extra_hours>0)
						{
                            ?>
                             <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>Extra Hours:</b></td>
                             <td><input id="<?php echo "txtextrahrs".$dutyslip_id ?>" onblur="GetExtraChargeHours(this.id,<?php echo $dutyslip_id;?>)" type="text" value="<?php echo $extra_hours;?>" class="m-wrap small"/></td>
                            <td><input name="<?php echo "txtextrahrschg".$dutyslip_id ?>" type="text"  id="<?php echo "txtextrahrschg".$dutyslip_id ?>" value="<?php echo $extra_hours_charges;?>" class="m-wrap small"/></td>
                            <td>&nbsp;</td>
                            <td><input id="<?php echo "hidden".$dutyslip_id ?>" type="hidden" value="<?php echo $extra_per_hour; ?>" /></td>
                            </tr>
                         <?php 
						}
						}
                        }
						}
						 
						?> 
	                        <tr>
	                        <th  colspan="8">Total</th><td><input id="total" name="total" readonly="readonly" value="0" type="text" class="m-wrap small"/></td>
	                        </tr>
							<tr>
	                        <th colspan="7"  style="padding-left: 180px;">Discount</th>
	                        <th >
                            <label>
								<input name="RadioGroup1" onchange="cal_grand_total()" type="radio" id="per" style="width:20px; height:15px;" value="radio"/>
								Per</label>
	                          <label>
	                            <input name="RadioGroup1" onchange="cal_grand_total()" type="radio" id="amt"  style="width:20px; height:15px;" value="radio" checked="checked"/>
                              Amount</label>
                            </th>
	                        <td><input type="text" onKeyUp="cal_grand_total()" class="m-wrap small" name="discount" id="discount" value="0"/></td>
	                        </tr>
							<tr>
	                        <th  colspan="8">Service Tax</th>
	                        <td><input type="text" name="stax" id="stax" value="0" class="m-wrap small" /></td>
	                        </tr>
	                        <tr>
	                        <th  colspan="8">Education Cess</th>
	                        <td><input type="text" name="etax" id="etax" value="0" class="m-wrap small"/></td>
	                        </tr>
	                        <tr>
	                        <th  colspan="8">Higher Education Cess</th>
	                        <td><input type="text" name="hetax" id="hetax"  value="0" class="m-wrap small" /></td>
	                        </tr>
	                        <tr>
	                        <th  colspan="8">Grand Total</th> <td><input onmousedown="cal_grand_total()" type="text"  id="grand_total" name="grand_total" readonly="readonly" class="m-wrap small"/></td>
	                        </tr>
	                        <tr><td colspan="12"><button type="submit"  style="margin-left:40%; width:200px !important" name="invoice_process" class="btn green btn-block"><i class="icon-ok"></i> Submit</button></td></tr>
                            </tbody>
						  </table><br>

                         
                          </div>
							<input type="hidden" value="<?php echo implode("-", $all_duty_slip_ids) ;?>" name="all_dutyslip_ids"/>
							<input type="hidden" id="mydiscount" name="mydiscount"  />
						<?php 
                       	$data_base_object->close_connection();
				}
			else	if(isset($_POST['invoice_process']))
{
	$data_base_connect_object = new DataBaseConnect();
	session_start();
	$array_duty_ids= array();
	$array_duty_ids=explode("-",$_POST['all_dutyslip_ids']);
	
	$query_insert_invoice= "insert into `invoice` (`invoice_type_type_id`,`authorized_person` ,`duty_slip_customer_reg_name` , `date` ,`payment_type`,`remarks` ,`total` ,`discount` ,`tax` ,`grand_total`,`status`,`loginname`,`countername`,`comp`)
	values ('".$_SESSION['invoice_type_type_id']."','".$_SESSION['authperson']."','".$_SESSION['duty_slip_customer_reg_name']."',
	'".$_SESSION['date']."','".$_SESSION['payment_type']."','".$_SESSION['remarks']."','".$_POST['total']."','".round($_POST['mydiscount'])."','".round($_POST['stax']+$_POST['etax']+$_POST['hetax'])."','".round($_POST['grand_total'])."','no','".$_SESSION['username']."','".$_SESSION['counter']."','".@$_SESSION['billed_entary']."')";
	$return = $data_base_connect_object->execute_query_update($query_insert_invoice, "invoice_process");
	$payment_from_customer = $_POST['grand_total'];
	$processed_duty_slips=array();
	$result_max=$data_base_connect_object->execute_query_return("select max(`invoice_id`) from `invoice`");
	$row=mysql_fetch_array($result_max);
	$max_invoice_id=$row[0];
	if($return=="success")
	{
		$add_query = "";
		for ($i = 0; $i < count($array_duty_ids); $i++) 
		{
				if(isset($_POST['dutyslip'.$array_duty_ids[$i]]))
				{
					if(strlen($add_query)==0)
					{	
						$add_query="`dutyslip_id`=".$array_duty_ids[$i];
						$processed_duty_slips[]=$array_duty_ids[$i];
					}
					else 
					{
						$add_query.=" or "."`dutyslip_id`=".$array_duty_ids[$i];
						$processed_duty_slips[]=$array_duty_ids[$i];
					}		
				}
		}
		$query_for_duty_update = "update `duty_slip` set `status`='yes' , `max_invoice_id`='".$max_invoice_id."' where ".$add_query;
		$data_base_connect_object->execute_query_operation($query_for_duty_update);
		$result1="success";
		echo "<table class=\"table table-bordered table-hover\" width=\"100%\" >";
		echo "<tr><th>Ledger Type</th><th>Name</th><th>Credit</th><th>Debit</th></tr>";
		$amount_to_cars=0;
		if($result1=="success")
		{
			for ($i = 0; $i < count($processed_duty_slips); $i++) 
			{
				$rss1 = $data_base_connect_object->execute_query_return("select `service_service_id` ,`total_km`,`carname_master_id`, `car_reg_name` ,`amount` from `duty_slip` where `dutyslip_id`=".$processed_duty_slips[$i]);
				$rss=mysql_fetch_array($rss1);
				
				$qry_fetch_carid="select * from `car_reg` where `car_id`='".$rss['car_reg_name']."'";
				$data_base_object = new DataBaseConnect();
				$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
				$row_carid = mysql_fetch_array($result_carid);
				$car_name_find=$row_carid['name'];
				
				$amt=0;
				if(isset($_POST['txtextrakmchg'.$processed_duty_slips[$i]]))
				{
					$amt=$_POST['txtextrakmchg'.$processed_duty_slips[$i]];
				}
				else if(isset($_POST['txtextrahrschg'.$processed_duty_slips[$i]]))
				{
					$amt=$_POST['txtextrahrschg'.$processed_duty_slips[$i]];
				}
			
				$data_base_connect_object->execute_query_update("insert into invoice_detail (invoice_invoice_id,duty_slip_dutyslip_id,duty_slip_service_service_id,duty_slip_car_reg_name,amount) values(".$max_invoice_id.",".$processed_duty_slips[$i].",'".$rss['service_service_id']."','".$car_name_find."','".($rss['amount']+$amt)."')","invoice_detail_update");
				
				$result_supplier_name=$data_base_connect_object->execute_query_return("select `supplier_reg_name` from `car_reg` where `name`='".$rss['car_reg_name']."'");
				$supplier_row=mysql_fetch_assoc($result_supplier_name);
				$num_rows_supplier = mysql_num_rows($supplier_row);
				if($num_rows_supplier>0)
				{
				$supplier_name=$supplier_row['supplier_reg_name']; // supplier name from car_reg
				$qry_supp="select * from `supplier_reg` where `name_supplier`='".$supplier_name."'";
				$data_base_object = new DataBaseConnect();
				$result_supp = $data_base_object->execute_query_return($qry_supp);
				$row_supp=mysql_fetch_array($result_supp);
				$supplier_id=$row_supp['supplier_id'];
				}
				else
				{
				$result_supplier_other=$data_base_connect_object->execute_query_return("select `supplier_reg_name` from `car_reg` where `name`='Others'");
				$supplier_row_other=mysql_fetch_assoc($result_supplier_other);
				$supplier_name_other=$supplier_row_other['supplier_reg_name']; // supplier name from car_reg
				$qry_supp_other="select * from `supplier_reg` where `name_supplier`='".$supplier_name_other."'";
				$data_base_object = new DataBaseConnect();
				$result_supp_other = $data_base_object->execute_query_return($qry_supp_other);
				$row_supp_other=mysql_fetch_array($result_supp_other);
				$supplier_id=$row_supp_other['supplier_id'];
				}
				$total_km=$rss['total_km'];   // getting total km of duty slip
				
			$query1="select * from `supplier_tariff` where `supplier_reg_name`='".$supplier_id."' and carname_master_id='".$rss['carname_master_id']."' and service_service_id='".$rss['service_service_id']."'";
				$result = $data_base_connect_object->execute_query_return($query1);
	
			if(mysql_num_rows($result)>0)  // if supplier tariff rate is defined
			{
					$row= mysql_fetch_array($result);
					$amount=$supplier_rate = $row['rate'];
					$minimum_chg_km = $row['minimum_chg_km'];
					$extra_km_rate = $row['extra_km_rate'];
					if($total_km>$minimum_chg_km)
					{
						$amount = $supplier_rate+($total_km-$minimum_chg_km)*$extra_km_rate ;
					}
					else 
					{
						$amount = $supplier_rate;
					}
					$amount_to_cars+=$amount;
					if($_SESSION['billed_complimentary']!="yes")
					{
						echo "<tr><td>Car</td><td>".$car_name_find."</td><td>".$amount."</td><td>0</td></tr>";	
						$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
						values('Car','".$car_name_find."','".$amount."','0','".date('Y-m-d')."','".$max_invoice_id."')", "ledger_insert");
					}
			}
		}
	}
		
		
		if($_SESSION['billed_complimentary']=="yes")
		{
//			if($_SESSION['payment_type']=="Cash")
//			{
//				echo "<tr><td>Comfort</td><td>Car Hire Services</td><td>0</td><td>".round($_POST['grand_total'])."</td></tr>";
//				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`cust_supp_name`,`credit`,`debit`,`date`,`bill_number`)
//				values('Comfort','Car Hire Services','".$_SESSION['duty_slip_customer_reg_name']."','0','".round($_POST['grand_total'])."','".date('Y-m-d')."','".$max_invoice_id."')
//				", "ledger_insert");
//			}
//			else {
//				echo "<tr><td>Comfort</td><td>Car Hire Services</td><td>0</td><td>".round($_POST['grand_total'])."</td></tr>";
//				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`cust_supp_name`,`credit`,`debit`,`date`,`bill_number`)
//				values('Comfort','Car Hire Services','".$_SESSION['duty_slip_customer_reg_name']."','0','".round($_POST['grand_total'])."','".date('Y-m-d')."','".$max_invoice_id."')
//				", "ledger_insert");
//			}
		}
		else 
		{
            			$qry="select * from `customer_reg` where `id`='".$_SESSION['duty_slip_customer_reg_name']."'";
		                $data_base_object = new DataBaseConnect();
						$result= $data_base_object->execute_query_return($qry);
						$row=mysql_fetch_array($result);
						$customer_name=$row['name'];
			echo "<tr><td>Customer</td><td>".$customer_name."</td><td>0</td><td>".round($_POST['grand_total'])."</td></tr>";
			$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
			values('Customer','".$customer_name."','0','".round($_POST['grand_total'])."','".date('Y-m-d')."','".$max_invoice_id."')
			", "ledger_insert");
		}
		
		if(round($_POST['discount'])!=0)
		{
			if($_SESSION['billed_complimentary']!="yes")
			{
				echo "<tr><td>Discount</td><td>".$customer_name."</td><td>0</td><td>".round($_POST['discount'])."</td></tr>";
				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
					values('Discount','".$customer_name."','0','".round($_POST['discount'])."','".date('Y-m-d')."','".$max_invoice_id."')
					", "ledger_insert");
			}
		}
		if(round($_POST['stax'])!=0)
		{
			if($_SESSION['billed_complimentary']!="yes")
			{
				echo "<tr><td>Tax</td><td>Service Tax</td><td>".round($_POST['stax'])."</td><td>0</td></tr>";
				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
				values('Service Tax','Service Tax','".round($_POST['stax'])."','0','".date('Y-m-d')."','".$max_invoice_id."')
				", "ledger_insert");
			}
		}
		
		echo "<input type=\"hidden\" value=\"".$max_invoice_id."\" id=\"maxinvoiceid\" />";
		
		if(round($_POST['etax'])!=0)
		{
			if($_SESSION['billed_complimentary']!="yes")
			{
				echo "<tr><td>Tax</td><td>Education Cess</td><td>".round($_POST['etax'])."</td><td>0</td></tr>";
				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
				values('Service Tax','Education Cess','".round($_POST['etax'])."','0','".date('Y-m-d')."','".$max_invoice_id."')
				", "ledger_insert");
			}
		}
		
		if(round($_POST['hetax'])!=0)
		{
			if($_SESSION['billed_complimentary']!="yes")
			{
			echo "<tr><td>Tax</td><td>Higher Education Cess</td><td>".round($_POST['hetax'])."</td><td>0</td></tr>";
			$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`credit`,`debit`,`date`,`bill_number`)
			values('Service Tax','Higher Education Cess','".round($_POST['hetax'])."','0','".date('Y-m-d')."','".$max_invoice_id."')
			", "ledger_insert");
			}
		}
		if($_SESSION['payment_type']=="Cash")
		{
			if($_SESSION['billed_complimentary']!="yes")
			{
				echo "<tr><td>Ledger</td><td>Car Hire Services</td><td>".round(($payment_from_customer-$amount_to_cars))."</td><td>0</td></tr>";
				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`cust_supp_name`,`credit`,`debit`,`date`,`bill_number`)
				values('Ledger','Car Hire Services','".$customer_name."','".round(($payment_from_customer-$amount_to_cars))."','0','".date('Y-m-d')."','".$max_invoice_id."')
				", "ledger_insert");
			}
		}
		else {
			if($_SESSION['billed_complimentary']!="yes")
			{
				echo "<tr><td>Ledger</td><td>Car Hire Services</td><td>".round(($payment_from_customer-$amount_to_cars))."</td><td>0</td></tr>";
				$data_base_connect_object->execute_query_update("insert into ledger(`ledger_type`,`name`,`cust_supp_name`,`credit`,`debit`,`date`,`bill_number`)
				values('Ledger','Car Hire Services','".$customer_name."','".round(($payment_from_customer-$amount_to_cars))."','0','".date('Y-m-d')."','".$max_invoice_id."')
				", "ledger_insert");
			}
		}
		
		echo "<tr align=\"center\"><td colspan=\"4\"><button type=\"button\" class=\"btn green\" value=\"OK\"  onclick=\"MyFun()\"/><i class=\"icon-ok\"></i> OK</button></td></tr>";
		echo "<tr align=\"center\"><td colspan=\"4\"><button type=\"button\" value=\"Print\" class=\"btn green\"  onclick=\"javascript:window.print() \"/><i class=\"icon-print\"></i> Print</button></td></tr>";
		echo "</table>";
		$data_base_connect_object->close_connection();
	 	unset($_SESSION['invoice_type_type_id']);
		unset($_SESSION['authperson']);
		unset($_SESSION['duty_slip_customer_reg_name']);
		unset($_SESSION['date']);
		unset($_SESSION['payment_type']);
		unset($_SESSION['remarks']);
	}
		if($_SESSION['ldrview']!=1)
		{
			echo "<meta http-equiv='refresh' content='0;url=billing_menu.php?billing=comp'/>";
			echo '<script type="text/javascript">
					MyFun();	
			      </script>';
		}  
		if($_SESSION['billed_complimentary']=="yes")
		{
			echo '<script type="text/javascript">
					MyFun();	
			      </script>';
			unset($_SESSION['billed_complimentary']);
			echo "<meta http-equiv='refresh' content='0;url=billing_menu.php?billing=comp'/>";
			
				
		} 
	
}
					?>
                     </div>
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>