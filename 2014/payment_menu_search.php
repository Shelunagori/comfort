<?php 
require_once("function.php");
//require_once("classes/databaseclasses/DataBaseConnect.php");
require_once("config.php");
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
<!--<script type="text/javascript">

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

function SetLedgerSession()
{
	var ledger_list=document.add_form.ledger_type;
	var ledger_type=ledger_list.options[ledger_list.selectedIndex].text;
	var ajaxRequest;  // The variable that makes Ajax possible!
	ajaxRequest=GetAjax();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('option_name').innerHTML=ajaxRequest.responseText;
		}
	}
	
	ajaxRequest.open("GET", "receipt_ledger_session_set.php?ledger_type="+ledger_type, true);
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
</script>-->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" style="">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post" name="view_form">
<!--<div>                     
<a href="payment_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="payment_menu_search.php" class="btn red"><i class="icon-edit"></i> Search</a>
</div> 
<br />-->
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-credit-card"></i>Enter Payment Information</h4>
                    </div>
                    <div class="portlet-body form">
                   
                <table width="100%">
                <tr>
                 <td>Payment ID</td>
				<td>
				<input type="text"  class="m-wrap medium"  name="payment_id"/>
				</td>
                </tr>
                <tr>
                <td> Date From:</td>
				<td>
				<input type="text" id="dp1" class="m-wrap medium"  name="date_from"/>
				</td>
				</tr>
				<tr>
                <td> Date To:</td>
				<td>
				<input type="text"  id="dp2"  class="m-wrap medium" name="date_to"/> <button type="submit" style="margin-left:1%;"  value="Add"  class="btn green" name="ledger_view"/>Go <i class="icon-circle-arrow-right"></i></button>
				</td>
				</tr>
                </table>
                     	<?php
				if(isset($_POST['ledger_view']))
				{
					?>
                      <a class="btn green" style="float:right;"  href="excel_payment.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&id=<?php echo $_POST['payment_id']; ?>" target="_blank"><i class="icon-download-alt"></i> Export in Excel</a>
                      
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;margin-top:5%">
					<table width="100%" id="sample_1" class="table table-bordered table-hover" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>Date</th>
                        <th>Payment ID</th>
                        <th>Name </th>
                        <th>Narration</th>
                        <th>Amount</th>
                        <th>View | Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php      
						$result = mysql_query("select * from `payment` where `current_date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' OR `id`='".$_POST['payment_id']."'");
						while($row=mysql_fetch_array($result))
                     	{
                     	?>
                            <tr>
                            <td><?php echo DisplayDate($row['date']);?></td>
                            <td><?php echo $row['id'];?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['narration'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td>
                            <a href="view_payment.php?payment=true&id=<?php echo $row['id'];?>" class="btn mini blue" target="_blank"><i class="icon-search"></i></a>
                            <a href="edit_payment.php?payment=true&id=<?php echo $row['id'];?>" class="btn mini yellow" target="_blank"><i class="icon-edit"></i></a>
                            </td>
                            </tr>
                       <?php 
                     	}
                       ?>
                        </tbody>
                      </table>
                      </div>
                    
				<?php 
				}?>
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