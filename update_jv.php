<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$idd=$_GET['trans_id'];
$type=$_GET['type'];
$sql="SELECT * from `ledger` where `transaction_id`='".$idd."' && `transaction_type`='".$type."'";
$result=mysql_query($sql);
if(mysql_num_rows($result)==0)
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
<script type="text/javascript">
function Calculation()
{
	var total_rows=document.getElementById('count').value;
	var total_credit_value=0;
	var total_debit_value=0;
	for(var i=1;i<=total_rows;i++)
	{		
			if($('#credit'+ i).val().length!=0)
			{
			total_credit_value+=parseInt(document.getElementById('credit'+i).value);	
			}
			if($('#debit'+ i).val().length!=0)
			{
			total_debit_value+=parseInt(document.getElementById('debit'+i).value);
			}
	}
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
function bal_total()
{
	var total_rows=document.getElementById('count').value;
	var total_credit_value=0;
	var total_debit_value=0;
	for(var i=1;i<=total_rows;i++)
	{
		if($('#credit'+ i).val().length!=0)
		{
		total_credit_value+=parseInt(document.getElementById('credit'+i).value);	
		}
		if($('#debit'+ i).val().length!=0)
		{
		total_debit_value+=parseInt(document.getElementById('debit'+i).value);
		}
	}
		$("#all_cr").val(total_credit_value);
		$("#all_dr").val(total_debit_value);
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
     					<form method="post" action="Handler.php"  onSubmit="return Calculation();">
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Journal Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
                        <table width="100%" class="table table-bordered table-hover table-condensed flip-content">
                        <thead>
                        <tr>
                        <th >SL.</th>
                        <th >JV ID</th>
                        <th >Ledger Type</th>
                        <th >Ledger Name </th>
                        <th >Credit</th>
                        <th >Debit</th>
                        <th >Date</th>
                        <th >Narration</th>
                        </tr>
                        </thead>
                        <tbody>
 						<?php
						$result=mysql_query($sql);
						while($row=mysql_fetch_array($result))
                     	{
							$i++;
							$myid=$row['id'];
							$ledger_master_id=$row['ledger_master_id'];
							$transaction_id=$row['transaction_id'];
							$name=$row['name'];
							$credit=$row['credit'];
							if(empty($credit))
							$credit=0;
							$debit=$row['debit'];
							if(empty($debit))
							$debit=0;
							$date=$row['date'];
							$narration=$row['narration'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
							$all_cr+=$credit;
							$all_dr+=$debit;
							?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <th><?php echo $transaction_id;?></th>
                            <td>
        <select name="ledger_type_id<?php echo $i; ?>" id="ledger_type<?php echo $i; ?>" class="m-wrap small" onchange="fetch_ledger_jv(this.value,<?php echo $i; ?>);">	
        <option value="">---select ledger type---</option>
        <?php 
        $result_ledger_type= mysql_query("select distinct `id`,`name` from ledger_type");
        while($row_ledger_type=mysql_fetch_array($result_ledger_type))
        {
		if($row_ledger_type['id']==$ledger_type_id)	
        echo '<option value="'.$row_ledger_type['id'].'" selected>'.$row_ledger_type['name'].'</option>';
		else
        echo '<option value="'.$row_ledger_type['id'].'">'.$row_ledger_type['name'].'</option>';
        }
        ?></select>
        </td>
                            <td id="option_name<?php echo $i; ?>">
                            <select name="ledger_master_id<?php echo $i; ?>" class="span6 m-wrap">	
                            <option value="0">---select name---</option>
                            <?php 
                            $result_lname=mysql_query("select distinct `name` from `ledger_master` where `name`!='Difference in opening balance'");
                            while($row_lname=mysql_fetch_array($result_lname))
                            {
							if($row_lname['name']==$name)			
                            echo '<option value="'.$row_lname['name'].'" selected>'.$row_lname['name'].'</option>';
							else
                            echo '<option value="'.$row_lname['name'].'">'.$row_lname['name'].'</option>';
                            }
                            ?>
                            </select>
                            </td>
                            <td><input type="text" class="m-wrap small" id="credit<?php echo $i; ?>" onKeyUp="bal_total();"  name="credit<?php echo $i; ?>" value="<?php echo $credit;?>"></td>
                            <td><input type="text" name="debit<?php echo $i; ?>"  onKeyUp="bal_total();" id="debit<?php echo $i; ?>" class="m-wrap small" value="<?php echo $debit; ?>"></td>
                            <td><input type="text" name="date<?php echo $i; ?>" class="m-wrap small date-picker" value="<?php echo dateforview($date);?>" /></td>
                            <td><input type="text" name="narration<?php echo $i; ?>" value="<?php echo $narration;?>" class="m-wrap small"></td>
                            <input type="hidden" value="<?php echo $myid; ?>" name="myid<?php echo $i; ?>" />
                            <input type="hidden" value="<?php echo $idd; ?>" name="trancation_id" />
                            </tr>
                       <?php 
                     	}
                       ?>
                        <tr>
                        <td colspan="4"></td>
                        <td><input type="text" class="m-wrap small" id="all_cr"  value="<?php echo $all_cr;?>"></td>
                        <td><input type="text" class="m-wrap small" id="all_dr"  value="<?php echo $all_dr;?>"></td>
                        <td colspan="2"></td>
                        <tr>
                        <td colspan="8" style="text-align:center;">      
                        <input type="hidden" name="count" id="count" value="<?php echo $i; ?>" />        
                        <button type="submit"  class="btn green" name="update_jv"/><i class="icon-question-sign"></i> Save Change</button>
                      	<a type="button"  class="btn blue" onClick="javascript:;location.reload();" name="reset"/><i class="icon-refresh"></i> Reload</a>
                        </td>
                        </tr>
                        </tbody>
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
 <?php js(); ?> 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>