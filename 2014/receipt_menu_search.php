<?php 
require_once("function.php");
//require_once ("classes/databaseclasses/DataBaseConnect.php");
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
<script type="text/javascript">
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
		ajaxRequest.open("GET", "get_teriff_rate.php?receiptdelete="+id+"&reason="+reason, true);
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
<a href="receipt_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="receipt_menu_search.php" class="btn red"><i class="icon-edit"></i> Search</a>
</div> 
<br />-->
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-edit"></i>Search Receipt</h4>
                    </div>
                    <div class="portlet-body form">
                   
                <table width="100%">
                <tr>
                 <td>Receipt ID</td>
				<td>
				<input type="text"  class="m-wrap medium"  name="receipt_id"/>
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
               <a class="btn green" style="float:right;"  href="excel_receipt.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&id=<?php echo $_POST['receipt_id']; ?>" target="_blank"><i class="icon-download-alt"></i> Export in Excel</a>
				<div style="width:100%; overflow-x:scroll; overflow-y:hidden;margin-top:5% ">
					<table width="100%"  class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>Date</th>
                        <th>Receipt No.</th>
                        <th>Name </th>
                        <th>Narration</th>
                        <th>Amount</th>
                        <th>View|Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php      
                     	$result = mysql_query("select * from `receipts` where `current_date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' OR `id`='".$_POST['receipt_id']."'");
                     	 $id=0;
						  $num_rows=mysql_num_rows($result);
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
                            <a class="btn mini blue" href="view_receipt.php?receipt=true&id=<?php echo $row['id'];?>" target="_blank"><i class="icon-search"></i></a> 
                            <a class="btn mini yellow" href="edit_receipt.php?receipt=true&id=<?php echo $row['id'];?>" target="_blank"><i class="icon-edit"></i></a>
                            </td>
                            </tr>
                            
                       <?php 
                     	}
                       ?>  
                       </tr>
                       </tbody>
                       </table>
                       </div>
				<?php 
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>