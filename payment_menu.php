<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
if(isset($_GET['idd']) && isset($_GET['delete_payment']))
{
	$query = mysql_query("delete from ledger where transaction_id='".$_GET['idd']."' && transaction_type='payment'");
	if($query)
	echo '<script>
	alert("Payment Deleted Successfully.");
	location="payment_menu.php?mode=del";
	</script>';
}
$result_max=mysql_query("select max(`transaction_id`) from `ledger` where `transaction_type`='payment'");
$row=mysql_fetch_array($result_max);
$max_payment_id=$row[0]+1;
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
    	<?php
		if(isset($_POST['payment_edit']))
			{
				
                           
                            
				if(isset($_GET['payment_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Payment Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['payment_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> Payment Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i> Payment Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
                              <form method="post" action="docburner.php">
                            <button  type="submit" style="float:right;" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i> Download in Excel</button>
                            <input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
                            <input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
                            <input type="hidden" value="<?php echo $_POST['payment_id']; ?>" name="payment_id">
                            <input type="hidden" value="payment" name="excel_for">
                            </form>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;padding-top:5px;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                       	<th>Sl.</th>
                       	<th>Date</th>
                       	<th>Payment ID</th>
                        <th>Name</th>
                        <th>Narration</th>
                        <th>Amount</th>
                         <?php
							if(isset($_GET['payment_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['payment_delete']))
							{
								?>
                                 <th>Delete</th>
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
				$q1="";	$q2="";	$q3=" ";	
				if(!empty($_POST['payment_id']))
				{
					$payment_id=$_POST['payment_id'];
					$q1="transaction_id='".$payment_id."'";
				}
				if(!empty($_POST['date_from'])&&!empty($_POST['date_to']))
				{
					$date_from=datefordb($_POST['date_from']);
					$date_to=datefordb($_POST['date_to']);
					if($q1=="")
					$q2=" `date` between '".$date_from."' and  '".$date_to."' ";
					else
					$q2=" AND `date` between '".$date_from."' and  '".$date_to."' ";
				 }
                if($q1=="" && $q2=="" ){
                	$qry ="select * from ledger";
					$q3=" where `transaction_type`='payment'  AND `debit`!='0' ";}
                else    {
					$qry="select * from ledger where ";
					$q3=" AND `transaction_type`='payment'  AND `debit`!='0' "; }
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {	$i++;
                        	$idd=$row['transaction_id'];
							$ledger_master_id=$row['ledger_master_id'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
					?>
                      		<tr id="<?php echo $i; ?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo dateforview($row['date']); ?></td>
                            <th><?php echo $row['transaction_id']; ?></th>
                            <td><?php echo $name;?></td>
                            <td><?php echo $row['narration'];?></td>
                            <td><?php echo $row['debit'];?></td>
                         <?php
							if(isset($_GET['payment_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?payment=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['payment_delete']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <a type="button"   href='payment_menu.php?delete_payment=true&idd=<?php echo $idd;?>' id="refresh" class="btn red"><i class="icon-trash"></i> Delete</a>
                            </div>
                            </div>        
                                    
                            </td>
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_payment.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
                                </td>
                                 <?php
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
	   else if(isset($_GET['mode']))
		{
			if($_GET['mode']=='edit')
			{
				?>
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Payment Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="payment_menu.php?payment_edit=true" name="form_name" autocomplete="off" method="post" class="form-horizontal">
                        
                         <div class="control-group">
                        <label class="control-label">Payment ID</label>
                        <div class="controls">
                        <input type="text" name="payment_id"  class="span6 m-wrap" />
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label">Date From</label>
                        <div class="controls">
                        <input type="text" name="date_from"  class="span6 m-wrap date-picker"  onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date To</label>
                        <div class="controls">
                        <input type="text" name="date_to"  class="span6 m-wrap date-picker" onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="payment_edit"/><i class="icon-ok"></i> Submit</button>
                        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
                        </div> 
                        
                       
                        </form>
                        </div>
                        </div>
                 <?php
			}
			else if($_GET['mode']=='del')
			{
				?>
                		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-trash"></i>Payment Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="payment_menu.php?payment_delete=true" name="form_name" autocomplete="off" method="post" class="form-horizontal">
                        
                        <div class="control-group">
                        <label class="control-label">Payment ID</label>
                        <div class="controls">
                        <input type="text" name="payment_id"  class="span6 m-wrap" />
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label">Date From</label>
                        <div class="controls">
                        <input type="text" name="date_from"  class="span6 m-wrap date-picker" onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date To</label>
                        <div class="controls">
                        <input type="text" name="date_to"  class="span6 m-wrap date-picker" onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="payment_edit"/><i class="icon-ok"></i> Submit</button>
                        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
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
                        <h4><i class="icon-search"></i>Payment View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="payment_menu.php?payment_view=true" name="form_name" autocomplete="off" method="post" class="form-horizontal">
                      
                        <div class="control-group">
                        <label class="control-label">Payment ID</label>
                        <div class="controls">
                        <input type="text" name="payment_id"  class="span6 m-wrap" />
                        </div>
                        </div>
                       
                        <div class="control-group">
                        <label class="control-label">Date From</label>
                        <div class="controls">
                        <input type="text" name="date_from"  class="span6 m-wrap date-picker"  onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date To</label>
                        <div class="controls">
                        <input type="text" name="date_to"  class="span6 m-wrap date-picker" onClick="mydatepick();"/>
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="payment_edit"/><i class="icon-ok"></i> Submit</button>
                        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
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
        <form  name="form_name" action="Handler.php" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-inbox"></i>Payment</h4>
        </div>
        <div class="portlet-body form">
         
        <div class="control-group">
        <label class="control-label">Payment No.</label>
        <div class="controls">
        <span class="text"><strong><?php echo $max_payment_id; ?></strong></span>
        </div>
        </div>
                
        <div class="control-group">
        <label class="control-label">Ledger Type</label>
        <div class="controls">
        <select name="ledger_type_id" id="ledger_type" class="span6 m-wrap" onChange="fetch_ledger();">	
	    <option value="">---select ledger type---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from ledger_type");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>  
        
        <div class="control-group">
        <label class="control-label">Name</label>
        <div class="controls" id="ledger_name_place">
        
        </div>
        </div>  
        
         
        <div class="control-group">
        <label class="control-label">Payment Type</label>
        <div class="controls">
        <select name="payment_type" class="span6 m-wrap"  onchange="HideShowRows()">	
        <option value="cash">Cash</option>
        <option value="bank">Bank</option>
        </select>
        </div>
        </div>   
           
        <div class="control-group"  id="1" style="display:none;" >
        <label class="control-label">Bank Name:</label>
        <div class="controls">
        <select name="bank_id" class="span6 m-wrap" id="bank_id" onChange="fetch_branch();">	
	    <option value="">---select bank name---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from `bank_reg`");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div> 
        
            
        <div class="control-group"  id="2" style="display:none;" >
        <label class="control-label">Branch Name:</label>
        <div class="controls" id="branch_place">
       
        </div>
        </div> 
         
         
        <div class="control-group"  id="3" style="display:none;" >
        <label class="control-label">Cheque number</label>
        <div class="controls">
        <input type="text" name="cheque_no"  class="span6 m-wrap" />
        </div>
        </div> 
        
            
        <div class="control-group"  id="4" style="display:none;" >
        <label class="control-label">Cheque Date</label>
        <div class="controls">
        <input type="text" name="cheque_date"  class="span6 m-wrap date-picker"  onClick="mydatepick();"/>
        </div>
        </div> 
        
         <div class="control-group" id="5" style="display:none;">
        <label class="control-label">Drawn Branch</label>
        <div class="controls">
        <input type="text" name="drawn_branch"  class="span6 m-wrap" />
        </div>
        </div>
         
  	
        <div class="control-group">
        <label class="control-label">Date</label>
        <div class="controls">
       <input type="text" name="date"  class="span6 m-wrap date-picker" onClick="mydatepick();" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Amount</label>
        <div class="controls">
        <input type="text" name="amount" id="amount"  onKeyUp="allLetter(this.value,this.id)"  class="span6 m-wrap" />
        </div>
        </div>    
        
       
        <div class="control-group">
        <label class="control-label">Narration</label>
        <div class="controls">
        <input type="text" name="narration" class="span6 m-wrap" />
        </div>
        </div>  
        
        <div class="form-actions">
        <button type="submit"   class="btn green" name="payment_submit"/><i class="icon-ok"></i> Submit</button>
        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
        </div>
        </div>
        </div> 
        <input type="hidden" value="<?php echo $max_payment_id; ?>" name="payment_id" />
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
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>