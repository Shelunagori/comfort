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
<script	type="text/javascript">
function SetLedgerSession(itemid)
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
	ajaxRequest.open("GET", "receipt_ledger_session_set.php?ledger_type="+ledger_type, true);	
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
     <form method="post" name="form_name" action="ledger_menu_data.php">
<!--<div>                     
<a href="ledger_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="ledger_menu_view.php" class="btn red"><i class="icon-table"></i> View Ledger</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-book"></i>Ledger</h4>
                    </div>
                    <div class="portlet-body form">
              <table width="100%">
					<tr><td > Ledger Type:</td><td>
					<select name="ledger_type" onchange="SetLedgerSession(this.id)" id="hello" class="m-wrap medium">	
						<option value="">Select Type</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select Distinct `ledger_type` from `ledger`");
						while($row=mysql_fetch_array($result))
						{
							echo "<option>".$row['ledger_type']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
					</td></tr>
					<tr><td>Name</td>
					<td><div id="div_name">
				
					</div>
					</td></tr>
					<tr><td> Date From:</td>
					<td>
					<input type="text" class="m-wrap medium" id="dp1" name="date_from"/>
					</td>
					</tr>
					<tr><td> Date To:</td>
					<td>
					<input type="text"  class="m-wrap medium"  id="dp2" name="date_to"/><button type="submit"  style="margin-left:1%" value="Next" class="btn green" name="ledger_view"  onclick="ajax_right();" />Go <i class="icon-circle-arrow-right"></i></button>
					</td>
					</tr>
                </table></div></div>
                
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