<?php 
require_once("function.php");
require_once ("config.php");
require_once("auth.php");
if(isset($_POST['payment_update']))
{
	 $sql="update `payment` set `receipt_type_type_id`='".$_POST['receipt_type_type_id']."',`current_date`='".date("Y-m-d")."',`name`='".$_POST['name']."',`bank_reg_bank_id`='".$_POST['bank_reg_bank_id']."',`bank_reg_branch`='".$_POST['branch']."',`cheque_no`='".$_POST['chequenumber']."',`amount`='".$_POST['amount']."',`narration`='".$_POST['narration']."' where `id`='".$_POST['change_id']."'";

	$sql_legger="update `ledger` set `ledger_type`='".$_POST['ledger_type']."',`name`='".$_POST['name']."',`debit`='".$_POST['amount']."',`date`='".$_POST['date']."',`bankname`='".$_POST['bank_reg_bank_id']."',`branch`='".$_POST['branch']."',`chequenumber`='".$_POST['chequenumber']."',`narration`='".$_POST['narration']."',`chequedate`='".date("Y-m-d",strtotime($_POST['chequedate']))."' where `payment_id`='".$_POST['change_id']."' && `type`='Payment' && `credit`='0'";

	
	$sql_legger2="update `ledger` set `cust_supp_name`='".$_POST['name']."',`credit`='".$_POST['amount']."',`date`='".$_POST['date']."',`bankname`='".$_POST['bank_reg_bank_id']."',`branch`='".$_POST['branch']."',`chequenumber`='".$_POST['chequenumber']."',`chequedate`='".date("Y-m-d",strtotime($_POST['chequedate']))."',`narration`='".$_POST['narration']."' where `payment_id`='".$_POST['change_id']."' && `type`='Payment' && `debit`='0'";
	
$result=mysql_query($sql);
$result1=mysql_query($sql_legger);
$result2=mysql_query($sql_legger2);
	
if($result&&$result1&&$result2)	
{
	echo '<script>
	alert("Entry update Successfully");
	window.location="payment_menu.php";
	</script>';
}
else
{
	echo '<script>
	alert("Error! Try again");
	window.location="payment_menu.php";
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
		ajaxRequest.open("GET", "get_teriff_rate.php?paymentdelete="+id, true);
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

function deletePayment()
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
	ajaxRequest.open("GET", "get_duty_data.php?del_pay_id=" + curr_id, true);
	ajaxRequest.send(null); 

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

var msg;

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

function GetBranches(bank_name)
{
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
		//	alert("Hello");
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
	ajaxRequest.open("GET", "get_duty_data.php?id=" + curr_id+"&pay_fetch=true&what="+msg
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
	
	ajaxRequest.open("GET", "ajax_p_type.php?value="+value+"&id="+document.getElementById("change_id").value, true);
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
if(isset($_GET['payment']) && isset($_GET['id']))
{
$result=mysql_query("select * from `payment` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
$row_data=mysql_fetch_array($result);

$res_l_type=mysql_query("select ledger_type from ledger where payment_id='".$_GET['id']."' && type='Payment' && ledger_type!='Ledger' ");
$row_l=mysql_fetch_array($res_l_type);
$ledger_type=$row_l['ledger_type'];
?>
<input type="hidden" id="p_type" value="<?php echo $row_data['receipt_type_type_id']; ?>" />
<input type="hidden" id="l_type" value="<?php echo $ledger_type; ?>" />
<input type="hidden" id="l_name" value="<?php echo $row_data['name']; ?>" />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Edit Payment</h4>
                     </div>
                     <div class="portlet-body form">
<table width="100%">
<tr><td width="30%">Payment Type</td><td>
<select name="receipt_type_type_id" onchange="payment_type(this.value)"  class="m-wrap medium">
<?php 
$result=mysql_query("select distinct receipt_type_type_id from payment");
while($row=mysql_fetch_array($result))
{
if($row_data['receipt_type_type_id']==$row['receipt_type_type_id'])	
echo "<option value='".$row['receipt_type_type_id']."' selected>".$row['receipt_type_type_id']."</option>";
else
echo "<option value='".$row['receipt_type_type_id']."' >".$row['receipt_type_type_id']."</option>";
}
?>
</select>
</td></tr>
<tr><td> Ledger Type : </td><td>
<select name="ledger_type"  onchange="SetLedgerSession(this.value)"  class="m-wrap medium" >
<option>--Select--</option>
<?php 
$result=mysql_query("select distinct `ledger_type` from `ledger`");
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
              	</td></tr>


		
        <tr>
        <td colspan="2"><div id="payment_place"></div></td>
        </tr>		
                
                
<tr>
<td>Amount</td>
<td><input type="text" class="m-wrap medium" name="amount" value="<?php echo $row_data['amount']; ?>" /></td>
</tr>

<tr>
<td>Narration</td>
<td><textarea type="text" class="m-wrap medium" name="narration" rows="2" style="resize:none;" ><?php echo $row_data['narration']; ?></textarea></td>
</tr>
</table>
<input type="hidden" name="change_id" id="change_id" value="<?php echo $row_data['id']; ?>" />
<input type="hidden" name="date" value="<?php echo $row_data['date']; ?>" />
<div class="form-actions">
<button type="submit" name="payment_update" style="margin-left:20%" class="btn green"><i class="icon-question-sign"></i> Save Change</button>
</div>
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