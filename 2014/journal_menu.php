<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
 if(isset($_POST['journal_reg']))
{
	$data_base_connect_object=new DataBaseConnect();
	
	
    $result_max=$data_base_connect_object->execute_query_return("select max(`receipt_type_type_id`) from `journal`");
	$row=mysql_fetch_array($result_max);
	$max_journal_id=$row['max(`receipt_type_type_id`)']+1;
	
	$count=$_POST['count'];
	
	for($k=1;$k<=$count;$k++)
	{
		if(!empty($_POST['amount'.$k]))
		{
			if($_POST['credit_debit'.$k]=="Credit")
			{
	$query1 = "insert into ledger set `ledger_type`='".$_POST['ledger_type'.$k]."' ,`name`='".$_POST['name'.$k]."',`credit`='".$_POST['amount'.$k]."',`date`='".DateExact($_POST['date'.$k])."',`narration`='".$_POST['narration']."',`payment_id`='".($max_journal_id+1)."' ,`type`='journal',`type_id`='".($max_journal_id+1)."' ";
	
	$query_j1 = "insert into `journal` set `ledger_type`='".$_POST['ledger_type'.$k]."' ,`receipt_type_type_id`='".$max_journal_id."',`current_date`='".date("Y-m-d")."',`name`='".$_POST['name'.$k]."',`credit`='".$_POST['amount'.$k]."',`date`='".DateExact($_POST['date'.$k])."',`amount`='".$_POST['amount'.$k]."',`narration`='".$_POST['narration']."'  ";
	
	 $data_base_connect_object->execute_query_operation($query1);
	 $data_base_connect_object->execute_query_operation($query_j1);
	
			}
			else
			{
	$query2	= "insert into ledger set `ledger_type`='".$_POST['ledger_type'.$k]."' ,`name`='".$_POST['name'.$k]."',`debit`='".$_POST['amount'.$k]."',`date`='".DateExact($_POST['date'.$k])."',`narration`='".$_POST['narration']."',`payment_id`='".($max_journal_id+1)."' ,`type`='journal',`type_id`='".($max_journal_id+1)."'";	
	
	$query_j2 = "insert into `journal` set `ledger_type`='".$_POST['ledger_type'.$k]."' ,`receipt_type_type_id`='".$max_journal_id."',`current_date`='".date("Y-m-d")."',`name`='".$_POST['name'.$k]."',`debit`='".$_POST['amount'.$k]."',`date`='".DateExact($_POST['date'.$k])."',`amount`='".$_POST['amount'.$k]."',`narration`='".$_POST['narration']."'";	
	
	 $data_base_connect_object->execute_query_operation($query2);
	  $data_base_connect_object->execute_query_operation($query_j2);
			}
		}
	
	}
	
    $data_base_connect_object->close_connection();
   // echo $query.$vals;
    //header("location:journal_menu.php?reg=done");
	
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
<link rel="stylesheet" type="text/css" href="olddatepicker/datepickercss.css"/>
<script src="olddatepicker/DateTimePicker.js"></script>
<script src="olddatepicker/datepicker.js"></script>
<script type="text/javascript">

var what_pressed="next";

function SetLedgerSession2(itemid)
{
	
	var ledger_list=document.getElementById(itemid);
	
	var ledger_type=ledger_list.options[ledger_list.selectedIndex].text;
	var ajaxRequest;  // The variable that makes Ajax possible!

	ajaxRequest=GET_AJAX();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('div_name').innerHTML=ajaxRequest.responseText;
		}
	}	
	ajaxRequest.open("GET", "receipt_ledger_session_set1.php?ledger_type="+ledger_type, true);	
	ajaxRequest.send(null);
}

function SetLedgerSession(itemid)
{
	
	var ledger_list=document.getElementById(itemid);
	var ledger_type=ledger_list.options[ledger_list.selectedIndex].text;
	//alert(ledger_type);
	var ajaxRequest;  // The variable that makes Ajax possible!

	ajaxRequest=GET_AJAX();
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById('option_name'+itemid).innerHTML=ajaxRequest.responseText;
		}
	}	
	
	ajaxRequest.open("GET", "receipt_ledger_session_set1.php?ledger_type="+ledger_type+"&jv="+itemid, true);	
	ajaxRequest.send(null);
}

function GetRowBodyLoad()
{
	GetRow();
	GetRow();
}

function GetRow() {
	
    var ajaxRequest=GET_AJAX();
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState == 4) {
            var table=document.getElementById('journal_table');
            var tBody = document.createElement("tbody");
            tBody.innerHTML = ajaxRequest.responseText;
            table.appendChild(tBody);
        }
    }
    		document.getElementById('srno').value++;
    		var last_srno= document.getElementById('srno').value; 
    		ajaxRequest.open("GET", "abc.php?srno="+last_srno, true);
    		ajaxRequest.send(null);
}
function GET_AJAX()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    return ajaxRequest;
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
	what_pressed="pre";
	get_Result(document.view_form.current_id.value);
}

function getNext()
{
	what_pressed="next";
	get_Result(document.view_form.current_id.value);
}

function get_Result(curr_id)
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
			var string = ajaxRequest.responseText;
			var myarray = new Array();
	        myarray = string.split(",");
	        document.getElementById('first_data').innerHTML=myarray[0];
	        document.getElementById('second_data').innerHTML=myarray[1];
	        document.getElementById('third_data').innerHTML=myarray[2];
	        document.getElementById('four_data').innerHTML=myarray[3];
	        document.getElementById('five_data').innerHTML=myarray[4];
	        document.getElementById('six_data').innerHTML=myarray[5];
	        document.view_form.current_id.value=myarray[6];
		}
	}
	
	ajaxRequest.open("GET", "get_duty_data.php?iddd="+curr_id+"&what="+what_pressed+"&ledger_type="+document.view_form.ledger_type.value+"&ledger_name="+document.view_form.ledger_name.value, true);
	ajaxRequest.send(null); 	
//	alert(what_pressed);
//	alert(curr_id);
//	alert(document.view_form.ledger_type.value); journal_menu.php
//	alert(document.view_form.ledger_name.value);
}

function Calculation()
{
	var total_rows=document.getElementById('srno').value;
	var total_credit_value=0;
	var total_debit_value=0;
	for(var i=1;i<=total_rows;i++)
	{
		
		var list =document.getElementById('credit_debit'+i);
		var val = list.options[list.selectedIndex].text;
		if(val=="Credit")
		{
			total_credit_value+=parseInt(document.getElementById('amount'+i).value);
		}	
		else
		{
			total_debit_value+=parseInt(document.getElementById('amount'+i).value);
		}
	}
	//alert(total_credit_value);
	//alert(total_debit_value);
	if(total_credit_value!=total_debit_value)
	{
		alert("Please Balance Credit and Debit");
		return false;
	}
	else 
	{
		return true;
	}
}

</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onload="GetRowBodyLoad()">
<input type="hidden" id="srno" value="0"/>
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post" name="add_form"  onsubmit="return Calculation()">
<div>                     
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '22' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{
		?>  
<a href="journal_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="journal_menu_search.php" class="btn blue"><i class="icon-edit"></i> Search</a>
<?php
	}
	?>
</div> 
<br />
<?php
	if($add_status==1)
	{
		?>
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-credit-card"></i>Enter Journal Information</h4>
                    </div>
                    <div class="portlet-body form">
                <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
                <table width="100%"  class="table table-bordered table-hover" id="journal_table" style="border-collapse:collapse;">
		        <thead>
                <tr><td>  Journal Number</td><td>
		        <?php 
				$data_base=new DataBaseConnect();
              		 $result_max=$data_base->execute_query_return("select max(`receipt_type_type_id`) from `journal`");
				$row=mysql_fetch_array($result_max);
      echo  	$max_journal_id=$row['max(`receipt_type_type_id`)']+1;
				$data_base->close_connection();
              	?>
		        </td></tr> 
		        <tr><th width="20%">Ledger Type</th><th width="20%">Ledger Name</th><th width="20%">Credit/Debit</th><th width="20%">Date</th><th width="20%">Amount</th></tr>
		        </thead>
              	<tfoot>
				<tr>
				<td align="center">Narration</td>
				<td><input type="text" name="narration" class="m-wrap medium" /></td>
				<td colspan="3"><button type="submit"  class="btn green" name="journal_reg"><i class="icon-ok"></i> Submit</button></td></tr>
				<tr align="left"><td colspan="5"><button type="button" value="Add Row" class="btn green" onclick="GetRow()"><i class="icon-plus"></i> Add Row</button></td></tr>
				</tfoot>
                </table>
                 </div>
                   </div>
                     </div> 
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>