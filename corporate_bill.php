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
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="corpor_row();">
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
						if(isset($_POST['cor_submit']))
						{
									if(isset($_GET['corporate_view']))
									{
										?>  
											<div class="portlet box blue" >
											<div class="portlet-title">
											<h4><i class="icon-search"></i> Corporate View</h4>
											</div>
											<div class="portlet-body form">
											<?php
									}
									else if(isset($_GET['corporate_del']))
									{
											?>
											<div class="portlet box red" >
											<div class="portlet-title">
											<h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Corporate Delete</h4>
											</div>
											<div class="portlet-body form">
											<?php
									}
									else
									{
										?>
											<div class="portlet box yellow" >
											<div class="portlet-title">
											<h4><i class="icon-edit"></i> Corporate Edit</h4>
											</div>
											<div class="portlet-body form">
										<?php
									}
									?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>SL.</th>
                        <th>Date</th>
                       	<th>Invoice No.</th>
                        <th>Customer Name</th>
                        <th>Guest Name</th>
                        <th>Grand Total</th>
                         <?php
							if(isset($_GET['corporate_view']))
							{
								?>
                                 <th>View</th>
                                 <?php
							}
							else if(isset($_GET['corporate_del']))
							{
								?>
                                 <th>Waveoff</th>
                                 <?php
							}
							else 
							{
								?>
                                 <th>Edit</th>
                                 <?php
							}
							
							?>
                        </tr>
                    </thead>
                   	<tbody>
                    <?php
				$q1="";	$q2="";	$q3="";	$q4="";
				if(!empty($_POST['id']))
				{
					$id=$_POST['id'];
					$q1="id='".$id."'";
				}
				if(!empty($_POST['customer_id']))
				{
					$customer_id=$_POST['customer_id'];
					if($q1=="")
						$q2=" customer_name='".$customer_id."'";
					else 
						$q2=" AND customer_name='".$customer_id."'";
				}
				if(!empty($_POST['date']))
				{
					$date=datefordb($_POST['date']);
					if($q1=="" && $q2=="")
						$q3=" date='".$date."'";
					else 
						$q3=" AND date='".$date."'";
				}
	
                if($q1=="" && $q2=="" && $q3=="")
				{
                	$qry ="select * from `corporate_billing`";
				//	$q4= " where `waveoff_status`!='1' ";
				}
                else    {
						$qry="select * from `corporate_billing` where ";
					//	$q4=" and `waveoff_status`!='1' ";
						}
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        $idd=$row['id'];
					?>
                      		<tr id="<?php echo $i; ?>" <?php if($row['waveoff_status']=='1'){ ?> title="Waveoff invoice" style="background-color:#F2DEDE;" <?php } ?>>
                            <td><?php echo $i;?></td>
                            <td><?php echo dateforview($row['date']);?></td>
                            <th><?php echo $row['id'];?></th>
                          	<td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['guest_name']; ?></td>
                            <td><?php echo $row['net_amnt']; ?></td>
                         <?php
							if(isset($_GET['corporate_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="corporate_view.php?corporate=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['corporate_del']))
							{
								?>
                                    
                                      <td>
                                 <?php 
								 if($row['waveoff_status']!=1) { ?>
                                      <a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-bar-chart"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-bar-chart"></i> <b><?php echo ($row['customer_name']); ?></b></span></h4>
                            </div>
                            <div class="modal-body">
                           
                            <div class="controls">
                            <input type="text"  name="waveoff_reason" id="cor_waveoff_reason<?php echo $i; ?>" placeholder="Enter Waveoff Reason" class="span12 m-wrap">
                            </div>   
                            
                            </div>
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_corporate(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-bar-chart"></i> Waveoff Now</button>
                            </div>
                            </div>        
                             <?php } ?>
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								
								
								?>
                                 <td>
                                  <?php
								  if($row['waveoff_status']!=1)
								  { ?>
                                 <a class="btn mini red"  role="button" href="update_corporate_billing.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>			<?php } else { ?>
                                  <a class="btn mini red"  role="button"  data-toggle="modal" href="#myModal_wave<?php echo $i ?>" style="text-decoration:none;"><i class="icon-edit"></i></a>	
                                    <div style="display: none;" id="myModal_wave<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B; font-size:13px;"><strong>Note: This is Waveoff Bill.</strong></span></h4>
                            </div>
                       
                            <div class="modal-footer">
                            <button class="btn red" data-dismiss="modal" aria-hidden="true">Ok</button>	
                            </div>
                            </div>        
                                </td>
                                 <?php
								 }
							}
							
							?>
                            </tr>
                            <?php
						}
						}
						?>
                    </tbody>
                    </table>   
                    </div>
                    </div>
                    </div>
                    <?php
						}
	else  if(isset($_GET['mode']))
	 {
		 	if($_GET['mode']=='edit')
			{
				?>
                <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Corporate Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="corporate_bill.php?corporate_edit=true" class="form-horizontal" name="form_name"  method="post">
                       
                        <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls">
                        <input name="id" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                       
                        
                        <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                        <select name="customer_name" class="span6 m-wrap chosen">
                        <option value="">---select customer---</option>
                        <?php 
                        $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='1'");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="cor_submit"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
                        <button type="reset"   class="btn yellow"/><b>Reset <i class="icon-retweet"></i></b></button>
                        </div>
                        
                        </form>
                        </div>
                        </div>
                <?php
			}
			else if($_GET['mode']=='delete')
			{
				?>
                  		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Corporate Delete</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="corporate_bill.php?corporate_del=true" class="form-horizontal" name="form_name"  method="post">
                       
                        <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls">
                        <input name="id" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                       
                        
                        <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                        <select name="customer_name" class="span6 m-wrap chosen">
                        <option value="">---select customer---</option>
                        <?php 
                        $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='1'");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="cor_submit"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
                        <button type="reset"   class="btn yellow"/><b>Reset <i class="icon-retweet"></i></b></button>
                        </div>
                        
                        </form>
                        </div>
                        </div>
                        
                <?php
			}
				else if($_GET['mode']=='view')
			{
				?>
                        <div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Corporate View</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="corporate_bill.php?corporate_view=true" class="form-horizontal" name="form_name"  method="post">
                       
                        <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls">
                        <input name="id" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                       
                        
                        <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                        <select name="customer_name" class="span6 m-wrap chosen">
                        <option value="">---select customer---</option>
                        <?php 
                        $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='1'");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date</label>
                        <div class="controls">
                        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="cor_submit"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
                        <button type="reset"   class="btn yellow"/><b>Reset <i class="icon-retweet"></i></b></button>
                        </div>
                        
                        </form>
                        </div>
                        </div>
                        
                <?php
			}
	 }
     else
     {
     ?>
        <form  method="post" name="corporate_bill_generate" target="_blank" action="corporate_bill_generate.php">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Corporate Billing</h4>
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
        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </td>
        <td>Name of Guest</td>
        <td><input type="text" name="guest_name"  class="m-wrap medium"/></td>
        </tr>
        
       	<tr>
        <td>REF.</td>
        <td><input type="text" name="ref"  class="m-wrap medium"/></td>
        <td>Date</td>
        <td><input type="text" name="ins_date" onClick="mydatepick();" class="m-wrap medium date-picker"/></td>
        </tr>

	
        <tr><td colspan="4"><b>SERVICES DETAIL:</b></td></tr>
        
        <tr>
        <td colspan="6">
		<table width="100%" id="cor_table" class="table table-bordered table-condensed flip-content">
        <thead>
        <tr>
        <th>DATE</th>
        <th>SERVICE NAME/HOURS</th>
        <th>RATE (RS)</th>
        <th>NO OF DAYS</th>
        <th>TAXI No. / GUIDE Tkt. No.</th>
        <th>Amount</th>
        <th><i class="icon-remove"></i></th>
        </tr>
        </thead>
        
        <tfoot>
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>TOTAL AMOUNT</th>
        <th><input type="text" name="grand_total" id="grand_total" value="0" readonly class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        <?php
		$result_taxrate=mysql_query("select `rate` from `taxation` where `name`='Service Tax'");
		$row_taxrate=mysql_fetch_array($result_taxrate);
		?>
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>SERVICE TAX<input type="text" name="tax_rate" autocomplete="off"  onKeyUp="cal_service_tax();" value="<?php echo $row_taxrate['rate']; ?>" id="tax_rate"  style="width:10% !important;margin-left:5%;" class="m-wrap small"/>%</th>
        <th><input type="text" name="service_tax" readonly id="service_tax" value="0"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        
          <tr>
        <td colspan="4">&nbsp;</td>
        <th>DISCOUNT</th>
        <th><input type="text" name="discount"  id="discount"  autocomplete="off" onKeyUp="cal_discount();" value="0"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        
        <tr>
        <td colspan="4">&nbsp;</td>
        <th>NET AMOUNT</th>
        <th><input type="text" name="net_amnt" id="net_amnt" readonly value="0"  class="m-wrap small"/></th>
        <th>&nbsp;</th>
        </tr> 
        
        <tr>
        <td colspan="8">
        <button type="button" value="Add Row" class="btn yellow" onClick="corpor_row();"><i class="icon-plus"></i> Add Row</button>
        <button type="submit" name="sub_cor" value="Add Row" class="btn blue" ><i class="icon-print"></i> Save & Print</button>
        <button  title="Reset All"  class="btn gray" style="text-decoration:none;" type="reset" ><i class=" icon-retweet"></i> Reset All</button>
        <input type="hidden" value="0" name="total_cor" id="cor_row"/>
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
        <?php 
	 }
	 ?>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
<div class="footer">
<?php footer();?>
</div>
<?php js(); ?> 
<script>
$('form[name=corporate_bill_generate]').submit(function(e)
{
	
	var net_amnt=$('#net_amnt').val();
	if(net_amnt<=0)
	{
		e.preventDefault();
	}
});
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