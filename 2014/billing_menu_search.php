<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
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
	
		if(document.getElementById('per').checked==true)
		{
			discount=(final_total)*discount/100;
		}

		 val = final_total-parseInt(document.getElementById('extra_total').value)-discount;
	     var stax = val*4.8/100;
		 document.getElementById('stax').value=Math.round(stax);
		 document.getElementById('etax').value=Math.round(stax*2/100);
		 document.getElementById('hetax').value=Math.round(stax*1/100);
			
		document.getElementById("grand_total").value=Math.round((parseFloat(final_total)-discount)+stax+etax+hetax);
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
		document.getElementById("grand_total").value=Math.round((parseFloat(final_total)-discount));
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
<a href="billing_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="billing_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="billing_menu_search.php" class="btn red"><i class="icon-search"></i> Search</a>
</div> -->
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-search"></i>Search</h4>
                    </div>
                    <div class="portlet-body form">
    		 			 <table width="100%">
						 <tr><td> Invoice Number : </td><td><input type="text" name="invoiceid"  class="m-wrap medium"/> </td></tr>
                          <tr><td>Customer Name  </td><td> 
                <select name="duty_slip_customer_reg_name"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$row['id'].'">'.$name.'</option>';
									}
        				      ?>

     </select></td></tr>
						 <tr><td> Date of Billing : </td><td><input id="dp1" type="text" name="date"  class="m-wrap medium"/> </td></tr>
                         <tr><td> Duty Slip No : </td><td><input  type="text" name="duty_slipno"  class="m-wrap medium"/> </td></tr>
						 <tr><td> Billed Complimenatry Charges: </td><td> 
                           <div class="control-group">
                           <div class="controls">
							<label class="radio"><input type="radio" name="billed_complimentary"  value="yes" checked="checked"  style="width: 20px;"/>Yes</label>
							<label class="radio"><input type="radio" name="billed_complimentary"  value="no" style="width: 20px;"/>No</label>
                            </div>
                            </div>
						</td></tr>
						 <tr><td> Authorized Person: </td><td><input type="text" name="authorizedperson"  class="m-wrap medium"/>
                           <button type="submit" style="margin-left:1%;"  class="btn green" name="view_bill" />Go <i class="icon-circle-arrow-right"></i></button> </td></tr>
						 <tr><td></td><td>&nbsp;</td></tr>
						 </table>
                            <?php
                         if(isset($_POST['view_bill']))
					{
					?> 
				 <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%"  class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th >Invoice Number</th>
                        <th >Customer Name</th>
                        <th >Date</th>
                        <th >Grand Total</th>
                        <th >View|PDF|Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php           
				$q1="";	$q2="";	$q3=""; $q4="";	
				if(!empty($_POST['invoiceid']))
				{
					$invoiceid=$_POST['invoiceid'];
					$q1="invoice_id='".$invoiceid."'";
				}
				if(!empty($_POST['duty_slip_customer_reg_name']))
				{
					$duty_slip_customer_reg_name=$_POST['duty_slip_customer_reg_name'];
					if($q1=="")
						$q2=" duty_slip_customer_reg_name='".$duty_slip_customer_reg_name."'";
					else 
						$q2=" AND duty_slip_customer_reg_name='".$duty_slip_customer_reg_name."'";
				}
				if(!empty($_POST['date']))
				{
					$date=$_POST['date'];
					if($q1=="" && $q2=="")
						$q3=" date='".DateExact($date)."'";
					else 
						$q3=" AND date='".DateExact($date)."'";
				}
				
				if(!empty($_POST['duty_slipno']))
				{
					    $duty_slipno=$_POST['duty_slipno'];
						 $data_base_object=new DataBaseConnect();
						$fetch_invoice1 = "select * from `invoice_detail` where `duty_slip_dutyslip_id` = '".$_POST['duty_slipno']."'";
						$result_invoice = $data_base_object->execute_query_return($fetch_invoice1);
						$fetch_invoice=mysql_fetch_array($result_invoice);
				     	$invoice_invoice_id = $fetch_invoice['invoice_invoice_id'];
					 
					if($q1=="" && $q2=="" && $q3=="")
					$q4=" invoice_id='".$invoice_invoice_id."'";
					else 
						$q4=" AND invoice_id='".$invoice_invoice_id."'";
				}
				
                if($q1=="" && $q2=="" && $q3=="" && $q4=="")
                	$qry ="select * from `invoice`";
                else    
					$qry="select * from `invoice` where ";
			
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q3.$q4." order by `invoice_id`";
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$invoice_id=$row['invoice_id'];
							$duty_slip_customer_reg_name=$row['duty_slip_customer_reg_name'];
							$qry_cust="select * from `customer_reg` where `id`='".$duty_slip_customer_reg_name."'";
							$data_base_object = new DataBaseConnect();
							$result_cust= $data_base_object->execute_query_return($qry_cust);
							$row_cust_name=mysql_fetch_array($result_cust);
							$customer_name=$row_cust_name['name'];
							$date=$row['date'];
							$grand_total=$row['grand_total'];
                       ?>
                            <tr>
                            <td><?php echo $invoice_id;?></td>
                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $date;?></td>
                            <td><?php echo $grand_total;?></td>
                            <td>
								<a class="btn mini blue"  role="button" href="InvoiceView.php?invoiceid=<?php echo $invoice_id;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                 <a class="btn mini red"  role="button" href="invoicepdf.php?invoiceid=<?php echo $invoice_id;?>"  target="_blank" style="text-decoration:none;">
    							<i class="icon-download-alt"></i></a>
                                 <a class="btn mini green"  role="button" href="javascript:deleteInvoice(<?php echo $invoice_id;?>)" style="text-decoration:none;">
    							<i class="icon-bar-chart"></i></a>
                                
                            	</td>
                            </tr>
                      
                        <?php
                        }
                        }
						
					?>
                          </tbody>
                    </table>  
                        </div> 
				<?php }	
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>