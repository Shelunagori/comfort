<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$idd=$_GET['id'];
$sql="SELECT * from `corporate_billing` where `id`='".$idd."'";
$result=mysql_query($sql);
$row_data = mysql_fetch_array($result);
$service_date=@explode(",",$row_data['service_date']);
$service=@explode(",",$row_data['service']);
$rate=@explode(",",$row_data['rate']);
$no_of_days=@explode(",",$row_data['no_of_days']);
$taxi_no=@explode(",",$row_data['taxi_no']);
$amount=@explode(",",$row_data['amount']);
$num=mysql_num_rows($result);
if($num==0)
{
	echo "<script>alert('Entry not found in database.');window.close();</script>";
}
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
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="cal_service_tax();cal_discount();"> 
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>      
      <!-- BEGIN PAGE -->  
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
    	
        <form  method="post" name="corporate_billing_edit" action="Handler.php">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Corporate Billing Edit</h4>
        </div>
        <div class="portlet-body form">
        <div style="width:100%; overflow-x:scroll; overflow-y:hidden; ">
        <table width="100%" cellpadding="5" cellspacing="5">
        <tr><td colspan="4"><b>CUSTOMER DETAIL:</b></td></tr>

        <tr>
        <td>Customer Name</td>
        <td>
        <select name="customer_name" class="m-wrap medium" required>
        <option value="">---select customer---</option>
		<?php 
        $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='1' ");
        while($row=mysql_fetch_array($result))
        {		
		if($row['name']==$row_data['customer_name'])
        echo '<option value="'.$row['name'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </td>
        <td>Name of Guest</td>
        <td><input type="text" name="guest_name" value="<?php echo $row_data['guest_name']; ?>" class="m-wrap medium"/></td>
        </tr>
        
       	<tr>
        <td>REF.</td>
        <td><input type="text" name="ref"  value="<?php echo $row_data['ref']; ?>" class="m-wrap medium"/></td>
        <td>Date</td>
        <td><input type="text" name="ins_date" onClick="mydatepick();"  value="<?php echo dateforview($row_data['date']); ?>" class="m-wrap medium date-picker"/></td>
        </tr>

	
        <tr><td colspan="4"><b>SERVICES DETAIL:</b></td></tr>
        
        <tr>
        <td colspan="6">
		<table width="100%" id="cor_table" class="table table-bordered table-condensed flip-content">
        <tr>
        <th>DATE</th>
        <th>SERVICE NAME/HOURS</th>
        <th>RATE (RS)</th>
        <th>NO OF DAYS</th>
        <th>TAXI No. / GUIDE Tkt. No.</th>
        <th>Amount</th>
        <th><i class="icon-remove"></i></th>
        </tr>
         <?php
				for($i=0;$i<sizeof($amount);$i++)
				{
					if(!empty($amount))
					{$k++;
					?>
<tr id="h_rmv<?php echo $k; ?>">
<th><input type="text" value="<?php echo dateforview($service_date[$i]); ?>"  name="service_date<?php echo $k; ?>" placeholder="dd-mm-yyyy"  onmouseover="mydatepick();" class="m-wrap small date-picker"/></th>
<th><input type="text" name="service<?php echo $k; ?>" value="<?php echo $service[$i]; ?>"  class="m-wrap medium"/></th>
<th><input type="text" value="<?php echo $rate[$i]; ?>" autocomplete="off" onkeyup="calculate_amnt(<?php echo $k; ?>);" id="rate<?php echo $k; ?>" name="rate<?php echo $k; ?>"  class="m-wrap small"/></th>
<th><input type="text" value="<?php echo $no_of_days[$i]; ?>" autocomplete="off" onkeyup="calculate_amnt(<?php echo $k; ?>);" id="day<?php echo $k; ?>" name="day<?php echo $k; ?>"  class="m-wrap small"/></th>
<th><input type="text" name="taxi_no<?php echo $k; ?>"  value="<?php echo $taxi_no[$i]; ?>" class="m-wrap medium"/></th>
<th><input readonly="readonly" type="text" id="amount<?php echo $k; ?>" name="amount<?php echo $k; ?>" value="<?php echo $amount[$i]; ?>"  class="m-wrap small"/></th>
<td><button class="btn mini red"  title="Delete this row"   role="button" value="<?php echo $k; ?>" onClick="delete_cor_row(this.value);"  style="width:2.5em !important; height:2em !important;text-decoration:none;"><i class="icon-remove"></i></button></td>
</tr>
        		<?php
					}

				}
				?>
        <tfoot>
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>TOTAL AMOUNT</th>
        <th><input type="text" name="grand_total" id="grand_total" value="<?php echo $row_data['tot_amnt']; ?>" readonly class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
         <?php
		$result_taxrate=mysql_query("select `rate` from `taxation` where `name`='Service Tax'");
		$row_taxrate=mysql_fetch_array($result_taxrate);
		?>
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>SERVICE TAX<input type="text" name="tax_rate_cor"  autocomplete="off"  onKeyUp="cal_service_tax();" value="<?php echo $row_taxrate['rate']; ?>" id="tax_rate"  style="width:10% !important;margin-left:5%;" class="m-wrap small"/>%</th>
        <th><input type="text" name="service_tax"  id="service_tax" readonly value="<?php echo $row_data['service_tax']; ?>"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        
          <tr>
        <td colspan="4">&nbsp;</td>
        <th>DISCOUNT</th>
        <th><input type="text" name="discount"  id="discount"  autocomplete="off" onKeyUp="cal_discount();" value="<?php echo $row_data['discount']; ?>"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>NET AMOUNT</th>
        <th><input type="text" name="net_amnt" id="net_amnt"  value="<?php echo $row_data['net_amnt']; ?>"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        <tr>
        <td colspan="8">
        <button type="submit" name="update_corporate"  class="btn green" ><i class=" icon-question-sign"></i> Save Change</button>
        <input type="hidden" value="<?php echo sizeof($amount); ?>" name="total_cor" id="cor_row"/>
        <input type="hidden" value="<?php echo $idd; ?>" name="myid" />
        </td>
        </tr>
        </tfoot>
        </table>
        </td>
        </tr>
        
        </table>
        </div>
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
   <script src="assets/js/jquery-1.8.3.min.js"></script>
 <script>
$('form[name=corporate_billing_edit]').live('submit',function(e)
{
	var net_amnt=$('#net_amnt').val();
	if(net_amnt<=0)
	{
		e.preventDefault();
	}
});
</script>
 <?php js(); ?> 
 <script>
function calculate_amnt(i)
{
var total=0;	
var grand_total=0;
var count=0;
var tax_rate=0;
var tax_amnt=0
count=eval(document.getElementById("cor_row").value);
total=eval(document.getElementById('rate'+i).value)*eval(document.getElementById('day'+i).value);	
document.getElementById('amount'+i).value=Math.round(total);
     	for(var k=1;k<=count;k++)
		{
		grand_total+=eval(document.getElementById('amount'+k).value);
		}
document.getElementById('grand_total').value=Math.round(grand_total);
tax_rate=document.getElementById("tax_rate").value;	
tax_amnt=Math.round(grand_total*tax_rate/100);
document.getElementById('service_tax').value=tax_amnt;
document.getElementById("net_amnt").value=Math.round(tax_amnt+grand_total);
}

function cal_discount()
{
	var grand_total=0;
	var discount=0;
	var service_tax=0;
	grand_total=eval(document.getElementById("grand_total").value);
	service_tax=eval(document.getElementById('service_tax').value);
	discount=eval(document.getElementById("discount").value);
	document.getElementById("net_amnt").value=Math.round((grand_total+service_tax)-discount);
}

function cal_service_tax()
{
	var tax_rate=0;
	var grand_total=0;
	var discount=0;
	grand_total=eval(document.getElementById("grand_total").value);
	discount=eval(document.getElementById("discount").value);
	tax_rate=document.getElementById("tax_rate").value;	
	tax_amnt=Math.round(grand_total*tax_rate/100);
	document.getElementById('service_tax').value=tax_amnt;
 	document.getElementById("net_amnt").value=Math.round((grand_total+tax_amnt)-discount);
}

function corpor_row()
{
var c=document.getElementById('cor_row').value;
c++;
document.getElementById('cor_row').value=c;
	 if(xobj)
       {
           var query="?corporate=" + c;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				var table=document.getElementById('cor_table');
				var tBody = document.createElement("tbody");
				tBody.innerHTML = xobj.responseText;
				table.appendChild(tBody);
			   }
			  }
             }
             xobj.send(null);

}
function delete_cor_row(val)
{
var grand_total=0;	
var remove_amnt=0;
var remain_amnt=0;
var tax_rate=0;
var tax_amnt=0;

document.getElementById("discount").value=0;
grand_total=eval(document.getElementById("grand_total").value);	
remove_amnt=eval(document.getElementById('rate'+val).value)*eval(document.getElementById('day'+val).value);	
remain_amnt=eval(grand_total-remove_amnt);

tax_rate=document.getElementById("tax_rate").value;	
tax_amnt=Math.round(remain_amnt*tax_rate/100);
document.getElementById('service_tax').value=tax_amnt;
document.getElementById("grand_total").value=remain_amnt;
document.getElementById("net_amnt").value=Math.round(tax_amnt+remain_amnt);

document.getElementById("h_rmv" +val).innerHTML="";
//$('#h_rmv' + val).remove();

$('#cor_table').append('<input type="hidden" id="amount'+val+'" value="0" />');

var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Row Deleted!</h4>';
var my_details='<p >Row Deleted Successfully</p>';
my_notification(my_activity,my_details);
}


</script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>