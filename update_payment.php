<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$idd=$_GET['id'];
$sql="SELECT * from `ledger` where `transaction_id`='".$idd."' && `transaction_type`='payment'";
$result=mysql_query($sql);
$num=mysql_num_rows($result);
if($num==0)
{
	echo "<script>alert('Entry not found in database.');window.close();</script>";
}
while($row_data=mysql_fetch_array($result))
{		
		if(!empty($row_data['debit']))
		{
			$amount=$row_data['debit'];
			$name=$row_data['name'];
			$result_ledger=mysql_query("select `ledger_type_id` from `ledger_master` where `name`='".$name."'");
			$row_ledger=mysql_fetch_array($result_ledger);
			$ledger_type_id=$row_ledger['ledger_type_id'];
			$name_id=$row_data['id'];
		}
		if(!empty($row_data['credit']))
		{
			if(!empty($row_data['bank_id']))
			{
			$bank_id=$row_data['bank_id'];
			$branch_id=$row_data['branch_id'];
			$cheque_no=$row_data['cheque_no'];
			$cheque_date=$row_data['cheque_date'];
			$drawn_branch=$row_data['drawn_branch'];
			$payment_method="bank";
			}
			else
			{
			$payment_method="cash";	
			}
		}
		$narration=$row_data['narration'];
		$date=$row_data['date'];
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
<script>
function ledger_payment_edit(ledger_type_id)
{
	if(xobj)
	 {	
	 var query="?payment_ledger_id=" + ledger_type_id + "&l_id=" + $("#l_id").val();
	 xobj.open("GET","ajax_page.php" +query,true);
	 xobj.onreadystatechange=function()
	  {
	  if(xobj.readyState==4 && xobj.status==200)
	   {
	   document.getElementById("l_data_place").innerHTML=xobj.responseText;
	   }
	  }
	  
	 }
	 xobj.send(null);
}
window.onload=init;
function init()
{
ledger_payment_edit(document.getElementById("ledger_type_id").value);
	<?php
	if($payment_method=="bank")
	{
		?>
		HideShowRows();
		<?php
	}
	?>
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
    	<form name="form_name" action="Handler.php" class="form-horizontal" method="post">
        
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Payment Edit</h4>
        </div>
        <div class="portlet-body form">
        
         <div class="control-group">
        <label class="control-label">Payment No.</label>
        <div class="controls">
        <span class="text"><input type="text" value="<?php echo $idd; ?>" class="span6 m-wrap" disabled /></strong></span>
        </div>
        </div>
                
        <div class="control-group">
        <label class="control-label">Ledger Type</label>
        <div class="controls">
        <select name="ledger_type_id" id="ledger_type" class="span6 m-wrap" onchange="ledger_payment_edit(this.value);">	
	    <option value="">---select ledger type---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from ledger_type");
        while($row=mysql_fetch_array($result))
        {
		if($ledger_type_id==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>  
        
        <div class="control-group">
        <label class="control-label">Name</label>
        <div class="controls" id="l_data_place">
        
        </div>
        </div>  
        
         
        <div class="control-group">
        <label class="control-label">Payment Type</label>
        <div class="controls">
        <select name="payment_type" class="span6 m-wrap"  onchange="HideShowRows()">	
        <option value="cash" <?php if($payment_method=="cash") { ?> selected <?php } ?>>Cash</option>
        <option value="bank" <?php if($payment_method=="bank") { ?> selected <?php } ?>>Bank</option>
        </select>
        </div>
        </div>   
           
        <div class="control-group"  id="1" style="display:none;" >
        <label class="control-label">Bank Name:</label>
        <div class="controls">
        <select name="bank_id" class="span6 m-wrap" id="bank_id">	
	    <option value="">---select bank name---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from `bank_reg`");
        while($row=mysql_fetch_array($result))
        {
		if($bank_id==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div> 
        
            
        <div class="control-group"  id="2" style="display:none;" >
        <label class="control-label">Branch Name:</label>
        <div class="controls">
        <select name="branch_id" class="span6 m-wrap">	
        <?php 
        $result= mysql_query("select  `id`,`branch` from `bank_reg`");
        while($row=mysql_fetch_array($result))
        {
		if($row['branch']==$branch_id)	
        echo '<option value="'.$row['id'].'" selected>'.$row['branch'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['branch'].'</option>';
        }
        ?>
        </select>
        </div>
        </div> 
         
         
        <div class="control-group"  id="3" style="display:none;" >
        <label class="control-label">Cheque number</label>
        <div class="controls">
        <input type="text" name="cheque_no" value="<?php echo $cheque_no; ?>"  class="span6 m-wrap" />
        </div>
        </div> 
        
            
        <div class="control-group"  id="4" style="display:none;" >
        <label class="control-label">Cheque Date</label>
        <div class="controls">
        <input type="text" name="cheque_date"  class="span6 m-wrap date-picker"  value="<?php echo dateforview($cheque_date); ?>" onClick="mydatepick();"/>
        </div>
        </div> 
        
         <div class="control-group" id="5" style="display:none;">
        <label class="control-label">Drawn Branch</label>
        <div class="controls">
        <input type="text" name="drawn_branch" value="<?php echo $drawn_branch; ?>" class="span6 m-wrap" />
        </div>
        </div>
         
  	
        <div class="control-group">
        <label class="control-label">Date</label>
        <div class="controls">
       <input type="text" name="date"  value="<?php echo dateforview($date); ?>" class="span6 m-wrap date-picker" onClick="mydatepick();" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Amount</label>
        <div class="controls">
        <input type="text" name="amount" id="amount"  value="<?php echo $amount; ?>"  onKeyUp="allLetter(this.value,this.id)"  class="span6 m-wrap" />
        </div>
        </div>    
        
       
        <div class="control-group">
        <label class="control-label">Narration</label>
        <div class="controls">
        <input type="text" name="narration" value="<?php echo $narration; ?>" class="span6 m-wrap" />
        </div>
        </div>  
        
        
        
        <div class="form-actions">
        <button type="submit"  class="btn green" name="update_payment"/><i class="icon-question-sign"></i> Save Change</button>
       	<button type="button"  class="btn yellow" name="reset" onClick="javascript:;window.close();"/><i class="icon-remove"></i> Close</button>
        </div>
        
        </div>
        </div> 
        <input type="hidden" name="myid" value="<?php echo $idd; ?>" />
        <input type="hidden" id="ledger_type_id" value="<?php echo $ledger_type_id; ?>" />
        <input type="hidden" id="l_id" value="<?php echo $name_id; ?>" />
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