<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$result_max=mysql_query("select max(`transaction_id`) from `ledger` where `transaction_type`='jv'");
$row=mysql_fetch_array($result_max);
$max_jv_id=$row[0]+1;
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
<style>
select option:hover:after {
    content: attr(title);
    background: #666;
    color: #fff;
    border: none;
    right:10px;
}
</style>
<script>	
function GetRowBodyLoad()
{
	GetRow();
	GetRow();
}
function show_total()
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
				if($('#amount'+i).val().length != 0)
				{
				total_credit_value+=parseInt(document.getElementById('amount'+i).value);
				$("#all_credit").val(total_credit_value);
				}
		}	
		else
		{		
				if($('#amount'+i).val().length != 0)
				{
			    total_debit_value+=parseInt(document.getElementById('amount'+i).value);
			    $("#all_debit").val(total_debit_value);
				}
		}
	}
}

function bal_total(val,no)
{
	   var all_dr=eval(document.getElementById("all_debit").value);
	   var all_cr=eval(document.getElementById("all_credit").value);
	   
	   if(val=="Credit")
	   {
		   if($('#amount'+no).val().length != 0)
		   {
			document.getElementById("all_credit").value=all_cr+parseInt(document.getElementById('amount'+no).value);
			document.getElementById("all_debit").value=all_dr-parseInt(document.getElementById('amount'+no).value);
		   }
	   }	
	   else
	   {	
	  		if($('#amount'+no).val().length != 0)		
			{
			document.getElementById("all_debit").value=all_dr+parseInt(document.getElementById('amount'+no).value);  
			document.getElementById("all_credit").value=all_cr-parseInt(document.getElementById('amount'+no).value);  
			}
	   }
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
<body class="fixed-top" onLoad="GetRowBodyLoad();">
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
	 if(isset($_GET['mode']))
	 {
				if($_GET['mode']=='view')
				{
				?>
                        <div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Journal Search</h4>
                        </div>
                        <div class="portlet-body form">
                        <form method="post" class="form-horizontal">
                        
                         <div class="control-group">
                        <label class="control-label">Journal ID</label>
                        <div class="controls">
                        <input type="text" name="journal_id"  class="span6 m-wrap" />
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label">JV Date From</label>
                        <div class="controls">
                        <input type="text" name="date_from"  class="span6 m-wrap date-picker"  onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">JV Date To</label>
                        <div class="controls">
                        <input type="text" name="date_to"  class="span6 m-wrap date-picker" onClick="mydatepick();"/>
                        <button type="submit"   class="btn green" name="jv_view"/><i class="icon-ok"></i> NEXT</button>
                        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
                        </div>
                        </div>
                        </form>
                       <?php
					   if(isset($_POST['jv_view']))
                       {
						   ?>
                    <form method="post" action="docburner.php">
                    <button  type="submit" style="float:right;" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i> Download in Excel</button>
                    <input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
                    <input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
                    <input type="hidden" value="<?php echo $_POST['journal_id']; ?>" name="journal_id">
                    <input type="hidden" value="jv" name="excel_for">
                    </form>
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden;padding-top:5px;">
					<table width="100%" id="sample_1" class="table table-bordered table-striped table-hover">
                    <thead>
                     	<tr>
                        <th >SL.</th>
                        <th >Journal ID</th>
                        <th >Ledger Type</th>
                        <th >Ledger Name </th>
                        <th >Credit</th>
                        <th >Debit</th>
                        <th >JV Date</th>
                        <th >Current Date</th>
                        <th >Narration</th>
                        <th >Edit</th>
						 <th >Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php   
					 $q1="";	$q2="";	$q3="";	
					if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
					{
					$date_from=datefordb($_POST['date_from']);
				 	$date_to=datefordb($_POST['date_to']);
					$q1=" `date` between '".$date_from."' and '".$date_to."' ";
					}
					
					if(!empty($_POST['journal_id']))
					{
					if($q1=='')	
					$q2="  `transaction_id` = '".$_POST['journal_id']."' ";
					else
					$q2=" AND `transaction_id` = '".$_POST['journal_id']."' ";
					}  
				   
				 
				   if($q1=='' && $q2=='')
				   {
					   $qry=" select * from ledger ";
					     $q3=" where `transaction_type`='jv'";
				   }
				   else 
				   {
					   $qry=" select * from ledger where ";
					     $q3=" AND `transaction_type`='jv'";
				   }
				  	$sql=$qry.$q1.$q2.$q3;
					$result=mysql_query($sql);
						while($row=mysql_fetch_array($result))
                     	{
							$i++;
							$transaction_id=$row['transaction_id'];
							$res_trans=mysql_query("select `id` from `ledger` where `transaction_id`='".$transaction_id."' && `transaction_type`='jv'");
							$num_trans=mysql_num_rows($res_trans);
							$ledger_master_id=$row['ledger_master_id'];
							$name=$row['name'];
							$credit=$row['credit'];
							$debit=$row['debit'];
							$date=$row['date'];
							$current_date=$row['current_date'];
							$narration=$row['narration'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
							?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <th><?php echo $transaction_id;?></th>
                            <td><?php echo fetchledgertype_name($ledger_type_id);?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $credit;?></td>
                            <td><?php echo $debit;?></td>
                            <td><?php echo dateforview($date);?></td>
                            <td><?php echo dateforview($current_date);?></td>
                            <td><?php echo $narration;?></td>
                            <?php
							if($transaction_id!=$count1) { $count1=$transaction_id;?>
                            <td rowspan="<?php echo $num_trans; ?>" style="vertical-align: middle;">
                           <a class="btn mini red tooltips"   role="button"  href="update_jv.php?trans_id=<?php echo $transaction_id; ?>&type=jv" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
                           </td>
                           <?php }
						   else { ?><td style="display:none !important;">&nbsp;</td><?php } ?>
						    <?php
							if($transaction_id!=$count2) { $count2=$transaction_id;?>
                            <td rowspan="<?php echo $num_trans; ?>" style="vertical-align: middle;">
                           <a class="btn mini red tooltips"   role="button"  href="delete_jv.php?trans_id=<?php echo $transaction_id; ?>&type=jv" target="_blank" style="text-decoration:none;"><i class="icon-trash"></i></a>
                           </td>
                           <?php }
						   else { ?><td style="display:none !important;">&nbsp;</td><?php } ?>
                            </tr>
                          
                       <?php 
                     	}
                       ?>
                        </tbody>
                      </table>
                      </div>
                           <?php
					   }
					   ?>
                        </div>
                        </div>
				<?php
				}
	 }
	 else
	 {
		 ?>
          			<form action="Handler.php" name="form_name" method="post" onSubmit="return Calculation();">
                    <div class="portlet box yellow" >
                    <div class="portlet-title">
                    <h4><i class="icon-table"></i>Journal Info</h4>
                    </div>
                    <div class="portlet-body form">
                    <table width="100%" id="journal_table" class="table table-bordered table-condensed flip-content">  
                    <thead>
                	<tr>
                    <th>Journal Number</th>
                    <th colspan="4"><?php echo $max_jv_id; ?></th>
                    </tr>
                    <tr>
                    <th>Ledger type</th>
                    <th>Ledger Name</th>
                    <th>Credit/Debit</th>
                    <th>Date</th>
                    <th>Amount</th>
					<th>Invoice</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                    <td></td>
                    <td><span><strong>Narration</strong></span><br/><input type="text" name="narration" placeholder="narration" class="m-wrap large"/></td>
                    <td><span><strong>Total Debit</strong></span><br/><input type="text" value="0" disabled placeholder="Total Credit" class="m-wrap small" id="all_debit"></td>
                    <td><span><strong>Total Credit</strong></span><br/><input type="text" value="0" disabled placeholder="Total Debit" class="m-wrap small" id="all_credit"></td>
                    <td></td><td></td>
                    </tr>
                    <tr>
                    <td colspan="5"><button type="button" value="Add Row" class="btn blue" onclick="GetRow();"><i class="icon-plus"></i> Add Row</button>
                    <button type="submit"  class="btn green" name="journal_reg"><i class="icon-ok"></i> Submit</button></td>
                    </tr>
                    </tfoot>
                    </table>
                    </div>
                    </div>
                   <input type="hidden" id="srno" value="0" name="count"/>
				   <input type="hidden" name="transaction_id" value="<?php echo $max_jv_id; ?>" />
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
<script>
$( document ).ready(function() {
    $("select").die().live("change",function(){
		var callajax=$(this).attr("callajax");
		if(callajax!="no"){
			var ledger_type=$(this).closest("tr").find("td:nth-child(1) select").val();
			var ot=$(this).closest("tr").find("td:nth-child(6)");
			if(ledger_type=="1"){
				var ledger_name=$(this).closest("tr").find("td:nth-child(2) select option:selected").val();
				var am_type=$(this).closest("tr").find("td:nth-child(3) select option:selected").val();
				if(am_type=="Debit"){
					$(ot).html("");
				}
				if(am_type=="Credit" && ledger_name!="" && ledger_name!="undefined"){
					$.ajax({
					  url: "invoice_select_ajax.php?ledger_name="+ledger_name,
					  success: function(html){
						$(ot).html(html);
						var ii=0;
						$("#journal_table tbody tr").each(function(){
							ii++;
							$(this).find("td:nth-child(6) select").attr("name","invoice_list"+ii+"[]")
						})
					  }
					});
				}
			}else{
				$(ot).html("");
			}
		}
	})
});
</script>
<script>
	$("#invoice_list").die().live("click",function() {
		var tot=0;
		$('option:selected',this).each(function()
		{
			if($(this).is(':selected')){
			tot+=eval($(this).attr('due_amt'));
			
			}
		});
		$(this).closest('tr').find('.amount_box').val(tot);
	});

</script>
