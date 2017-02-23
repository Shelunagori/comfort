<?php 
require_once("function.php");
//require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("config.php");
require_once("auth.php");

if(isset($_POST['customer_receipt_reg']))
{
		$bill_no=$_POST['bill_no'];
		$ins_id=implode(',',$bill_no);
		$tot=$_POST['amount']-$_POST['discount'];
		
		$sql="update `receipts` set `receipt_type_type_id`='".$_POST['receipt_type_type_id']."',`current_date`='".date("Y-m-d")."',`name`='".$_POST['name']."',`amount`='".$tot."',`narration`='".$_POST['narration']."',`invoice_ids`='".$ins_id."',`date`='".date("Y-m-d",strtotime($_POST['date']))."' where `id`='".$_POST['change_id']."'";
		
		$sql_legger="update `ledger` set `ledger_type`='".$_POST['ledger_type']."',`name`='".$_POST['name']."',`credit`='".$_POST['amount']."',`date`='".date("Y-m-d",strtotime($_POST['date']))."',`bankname`='".$_POST['bank_reg_bank_id']."',`branch`='".$_POST['branch']."',`chequenumber`='".$_POST['chequenumber']."',`narration`='".$_POST['narration']."',`chequedate`='".date("Y-m-d",strtotime($_POST['chequedate']))."',`bill_number`='".$ins_id."' where `type_id`='".$_POST['change_id']."' && `type`='Receipt' && `debit`='0' ";

	
	$sql_legger2="update `ledger` set `debit`='".$_POST['amount']."',`cust_supp_name`='".$_POST['name']."',`date`='".date("Y-m-d",strtotime($_POST['date']))."',`bankname`='".$_POST['bank_reg_bank_id']."',`branch`='".$_POST['branch']."',`chequenumber`='".$_POST['chequenumber']."',`chequedate`='".date("Y-m-d",strtotime($_POST['chequedate']))."',`narration`='".$_POST['narration']."',`bill_number`='".$ins_id."' where `type_id`='".$_POST['change_id']."' && `type`='Receipt' && `credit`='0' && `name`!='Discount'";
	
	$sql_legger3="update `ledger` set `debit`='".$_POST['discount']."',`cust_supp_name`='".$_POST['name']."',`date`='".date("Y-m-d",strtotime($_POST['date']))."',`bankname`='".$_POST['bank_reg_bank_id']."',`branch`='".$_POST['branch']."',`chequenumber`='".$_POST['chequenumber']."',`chequedate`='".date("Y-m-d",strtotime($_POST['chequedate']))."',`narration`='".$_POST['narration']."',`bill_number`='".$ins_id."' where `type_id`='".$_POST['change_id']."' && `type`='Receipt' && `credit`='0' && `name`='Discount'";
	
$result=mysql_query($sql);
$result1=mysql_query($sql_legger);
$result2=mysql_query($sql_legger2);
$result3=mysql_query($sql_legger3);
	
if($result&&$result1&&$result2&&$result3)	
{
	echo '<script>
	alert("Entry update Successfully");
	window.location="receipt_menu_search.php";
	</script>';
}
else
{
	echo '<script>
	alert("Error! Try again");
	window.location="receipt_menu_search.php";
	</script>';
}	
}

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
		ajaxRequest.open("GET", "get_teriff_rate.php?receiptdelete="+id, true);
		ajaxRequest.send(null);
}

function SetLedgerSession2(itemid)
{ 
	var ledger_list=document.getElementById(itemid);
	
	var ledger_type=ledger_list.options[ledger_list.selectedIndex].text;
	var ajaxRequest;  // The variable that makes Ajax possible!

	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('div_name').innerHTML=ajaxRequest.responseText;
		}
	}	
	ajaxRequest.open("GET", "receipt_ledger_session_set.php?ledger_type="+ledger_type, true);	
	ajaxRequest.send(null);
}

function GetInvoiceNumbers(idd)
{
	var invoice_ids=$("#invoice_ids").val();
	var nm=document.getElementById("name").value;
	ajaxRequest=GetAjax();
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				document.getElementById('bill_numbers_div').innerHTML=ajaxRequest.responseText;
			}
			}
		 var query="?customer_name=" + nm + "&type=" + idd + "&invoice_ids=" + invoice_ids;
		ajaxRequest.open("GET", "receipt_ledger_session_set.php" +query, true);
		ajaxRequest.send(null);
			
	
}
	function getamount()
{
	var nm=document.getElementById("name").value;
	if(document.getElementById("radio1").checked==true)
		{
			var rd=document.getElementById("radio1").value;
			var sel=$("#invoice").val();
			}
	if(document.getElementById("radio2").checked==true)
		{
			var rd=document.getElementById("radio2").value;
			var sel=$("#duty").val();			
			}
	ajaxRequest=GetAjax();
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function(){
			if(ajaxRequest.readyState == 4){
				document.getElementById('txtamt').innerHTML=ajaxRequest.responseText;
			}
			}
		 var query="?customer_name=" + nm + "&bill_id=" + sel + "&type=" + rd;
		 ajaxRequest.open("GET", "getamount_type.php" +query, true);
		 ajaxRequest.send(null);
}

function HideShowRows()
{
	for(var i=1;i<=5;i++)
	{
	 	if (document.getElementById(i).style.display == 'none') {
         document.getElementById(i).style.display = '';
     	} else {
         document.getElementById(i).style.display = 'none';
     	}
	}
}

function cal_all()
{
	var one =document.calform.amount1.value;
	var two =document.calform.amount2.value;
	var three =document.calform.amount3.value;
	var four =document.calform.amount4.value;
	var five =document.calform.amount5.value;
	var amount_val = document.calform.amount_val.value;
	if((parseInt(one)+parseInt(two)+parseInt(three)+parseInt(four)+parseInt(five))==amount_val)
	{
		return true;
	}
	return false;
}


function getPre()
{
	var curr_id=document.view_form.current_id.value;
//	alert(curr_id);
	msg="<";
	get_Result(curr_id);
}

function getNext()
{
	var curr_id=document.view_form.current_id.value;
	msg=">";
	get_Result(curr_id);
}

function GetAjax()
{
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
	return ajaxRequest;
}

function SetLedgerSession(l_type)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('option_name').innerHTML=ajaxRequest.responseText;
		}
	}
	
	ajaxRequest.open("GET", "receipt_ledger_session_set.php?ledger_type="+l_type+"&l_name="+document.getElementById("l_name").value, true);
	ajaxRequest.send(null); 
}

function GetBranches()
{
	var bank_list=document.add_form.bank_reg_bank_id;
	var bank_name=bank_list.options[bank_list.selectedIndex].text;
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('branch_name_div').innerHTML=ajaxRequest.responseText;
		}
	}
	
	ajaxRequest.open("GET", "receipt_ledger_session_set.php?bank_name="+bank_name, true);
	ajaxRequest.send(null); 
}

function get_Result(curr_id)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var string = ajaxRequest.responseText;
			var myarray = new Array();
	        myarray = string.split(",");
	       document.getElementById('first_data').innerHTML=myarray[0];
	        document.getElementById('second_data').innerHTML=myarray[1];
	        document.getElementById('third_data').innerHTML=myarray[2];
	        document.getElementById('four_data').innerHTML=myarray[3];
	        document.getElementById('five_data').innerHTML=myarray[4];
	        document.getElementById('six_data').innerHTML=myarray[5];
	    //    document.getElementById('seven_data').innerHTML=myarray[6];
			document.getElementById('current_id').value=myarray[6];
			document.getElementById('seven_data').innerHTML=myarray[7];
		}
	}
	
	ajaxRequest.open("GET", "get_duty_data.php?id=" + curr_id+"&rec_fetch=true&what="+msg
					 +"&ledger_type="+document.getElementById('ledger_type').value+"&ledger_name="+document.getElementById('ledger_name').value+"&date_from="+document.getElementById('date_from').value+"&date_to="+document.getElementById('date_to').value
					 , true);
	ajaxRequest.send(null); 	
}

function cal_grand_total()
{
	var final_total = document.getElementById('total').value;
	var discount = document.getElementById('discount').value;
	var tax = document.getElementById('tax').value;
	document.getElementById("grand_total").value=(final_total-discount)+(final_total-discount)*tax/100;
}

function deleteReceipt()
{

	var curr_id=document.view_form.current_id.value;
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			alert(ajaxRequest.responseText);
			getNext();
		}
	}
	ajaxRequest.open("GET", "get_duty_data.php?del_id=" + curr_id, true);
	ajaxRequest.send(null); 

}

function payment_type(value)
{
	//alert(value);
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('payment_place').innerHTML=ajaxRequest.responseText;
			GetBranches(document.getElementById("bank_reg_bank_id").value);
		}
	}
	
	ajaxRequest.open("GET", "ajax_p_type.php?receipt_value="+value+"&receipt_id="+document.getElementById("change_id").value, true);
	ajaxRequest.send(null); 
}
</script>
<script>
 window.onload=init;
		function init()
		{
			payment_type(document.getElementById("p_type").value);
			SetLedgerSession(document.getElementById("l_type").value);
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
     <form method="post" name="add_form">
 <?php
if(isset($_GET['receipt']) && isset($_GET['id']))
{
$result=mysql_query("select * from `receipts` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
$row_data=mysql_fetch_array($result);

$res_l_type=mysql_query("select ledger_type from ledger where type_id='".$_GET['id']."' && type='Receipt' && ledger_type!='Ledger' ");
$row_l=mysql_fetch_array($res_l_type);
$ledger_type=$row_l['ledger_type'];

$res_dis=mysql_query("select debit from ledger where type_id='".$_GET['id']."' && type='Receipt' && name='Discount' ");
$row_dis=mysql_fetch_array($res_dis);
$receipt_dis=$row_dis['debit'];
?>
<input type="hidden" id="p_type" value="<?php echo $row_data['receipt_type_type_id']; ?>" />
<input type="hidden" id="l_type" value="<?php echo $ledger_type; ?>" />
<input type="hidden" id="l_name" value="<?php echo $row_data['name']; ?>" />
<input type="hidden" id="invoice_ids" value="<?php echo $row_data['invoice_ids']; ?>" />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Edit Receipt</h4>
                     </div>
                     <div class="portlet-body form">
<table width="100%">
	<tr><td width="30%">  Receipts Type</td><td>
              	<select name="receipt_type_type_id" class="m-wrap medium" onchange="payment_type(this.value)">
              	<?php 
						$result=mysql_query("select name from receipt_type");
						while($row=mysql_fetch_array($result))
						{
							if($row_data['receipt_type_type_id']==$row['name'])	
							echo "<option value=\"".$row['name']."\" selected>".$row['name']."</option>";
							else
							echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
						}
              	?>
              	</select>
              	</td></tr>
                
				<tr><td>Date:  </td><td>
					<input type="text" name="date" id="dp1" value="<?php echo DisplayDate($row_data['date']); ?>" class="m-wrap medium"/>
				</td></tr>
					
				 <tr>
        <td colspan="2"><div id="payment_place"></div></td>
        </tr>		
                
				<tr><td> Ledger Type : </td><td>
              	<select name="ledger_type"  onchange="SetLedgerSession(this.value)" class="m-wrap medium" >
					<option value="0">----Select----</option>
              	<?php 
              	$result= mysql_query("select distinct `ledger_type` from `ledger`");
						while($row=mysql_fetch_array($result))
						{
							if($ledger_type==$row['ledger_type'])
							echo "<option value=\"".$row['ledger_type']."\" selected>".$row['ledger_type']."</option>";
							else
							echo "<option value=\"".$row['ledger_type']."\">".$row['ledger_type']."</option>";
						}
              	?>
              	</select>
              	</td></tr>
              	<tr><td> Name : </td><td>
              		<div id="option_name"></div>
<!--              		<input type="text" name="name" id="autocomplete_ledger_name" style="width: 250px;"/>-->
              	</td></tr>
					<tr><td>Type  </td><td>
                    <div class="control-group">
                                      <div class="controls">
					<label class="radio"><input name="RadioGroup" class="radio" type="radio" id="radio1" style="width:20px; height:15px;" value="invoice" onchange="GetInvoiceNumbers(this.value)"/>Invoice</label>
						<label class="radio"><input name="RadioGroup" class="radio" type="radio" id="radio2" style="width:20px; height:15px;" value="dutyslip" onchange="GetInvoiceNumbers(this.value)"/>Duty Slip</label>
						<label class="radio"><input name="RadioGroup"  class="radio" type="radio" id="radio3" style="width:20px; height:15px;" value="radio"/>Not Applicable</label>
                        </div>
                        </div>
				</td></tr>
				
				<tr><td> Bill No: </td><td>
				<div id="bill_numbers_div">
				
              	</div>
				</td></tr>
					<tr id="txtamt"><td> Amount: </td><td><input type="text" name="amount" id="amount" value="<?php echo $row_data['amount']; ?>" class="m-wrap medium"  ondblclick="getamount()"/> </td></tr>
					<tr><td> Discount: </td><td><input type="text" name="discount" value="<?php echo $receipt_dis; ?>" id="discount" class="m-wrap medium" /> </td></tr>
				<tr><td> Narration: </td><td><input type="text" name="narration" value="<?php echo $row_data['narration']; ?>" class="m-wrap medium"/> </td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
					
                </table>
                  <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:30%" class="btn green" name="customer_receipt_reg"/><i class="icon-ok"></i> Submit</button>
                     </div>    <input type="hidden" name="change_id" id="change_id" value="<?php echo $row_data['id']; ?>" />

</div>
</div>
<?php 
}
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>