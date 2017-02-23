<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
setlocale(LC_MONETARY, 'en_US');
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
<script type="text/javascript" src="comma_separater.js"></script>	
<script>
function add_box(value)
{
	 if(value=='add')
	 {
	 document.getElementById("myicon").className='icon-minus';
	 document.getElementById("add").value="remove";
	 document.getElementById("group_name").disabled=true;
	 document.getElementById("place_me").innerHTML="<input type='text' placeholder='New Group Name' required class='m-wrap medium' name='group_name_other'>";	
	 }
	 else
	 {
	 	 document.getElementById("myicon").className='icon-plus';
	 	 document.getElementById("add").value="add";
	 	 document.getElementById("place_me").innerHTML="";	
		 document.getElementById("group_name").disabled=false;
	 }
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
     <?php temp(); ?>
	 
    	<?php
		if(isset($_GET['mode']))
        {
			if($_GET['mode']=='view')
			{
				?>
                <div class="portlet box blue">
                <div class="portlet-title">
                <h4><i class="icon-search"></i>View Ledger</h4>
                </div>
                <div class="portlet-body form">
                
                <form method="post" class="form-horizontal" > 
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
                <label class="control-label">Date From</label>
                <div class="controls">
                <input type="text" class="span6 m-wrap date-picker" onClick="mydatepick();" name="date_from" />
                </div>
                </div>  
                
                <div class="control-group">
                <label class="control-label">Date To</label>
                <div class="controls">
                <input type="text" class="span6 m-wrap date-picker" onClick="mydatepick();" name="date_to" /> 
                <button type="submit"   class="btn green"  name="ledger_view"/><i class="icon-ok"></i> Submit</button>
                </div>
                </div>  
                </form>
                <?php
				if(isset($_POST['ledger_view']))
				{
					$date_from=$_POST['date_from'];
					$date_to=$_POST['date_to'];
					$ledger_type_id=$_POST['ledger_type_id'];
					$ledger_name=$_POST['ledger_name'];
					
					$fetch_ledger_master=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$ledger_type_id."' && `name`='".$ledger_name."'");
					$row_ledger_master=mysql_fetch_array($fetch_ledger_master);
					$result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` < '".datefordb($date_from)."' ");
										
					?>
   					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
                    	<table class="table table-condensed table-hover responsive" width="100%" >
                    	<tr>
                    	<th colspan="2">Ledger Information </th>
						<th colspan="3"><?php echo fetchledgertype_name($_POST['ledger_type_id']); ?> Ledger from 
						<?php 
							echo dateforview($_POST['date_from']);
						?>
						to 
						<?php 
							echo dateforview($_POST['date_to']);
						?>
						</th>
						<th colspan="6" >Name : 
						<?php 
							echo $ledger_name;
						?>
						</th>
						</tr>
						<tr>
						<th colspan="5">
                        <form method="post" action="docburner.php">               
       <button  type="submit" style="background-color:#4D90FE;border:#4D90FE;color:#FFF;" class="yellow diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i> Download in Excel</button>
                        <input type="hidden" value="<?php echo $_POST['ledger_type_id']; ?>" name="ledger_type_id">
                        <input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
                        <input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
                        <input type="hidden" value="<?php echo $_POST['ledger_name']; ?>" name="ledger_name">
                        <input type="hidden" value="ledger" name="excel_for">
                        </form>
                        </th>
						<th colspan="3">Opening Balance: 
                        <?php 
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {if($row['debit']>0){
								$ntblnce=$ntblnce-($row['debit']-$row['credit']);
}else
{$ntblnce=$row['credit']+$ntblnce;}
							}
							$opening_bal=$ntblnce;
							
						?>
						<th colspan="3"><?php 
						
						if($opening_bal>0)
						{
							echo abs($opening_bal);
								echo " CR";
						}
							else
							{
								echo abs($opening_bal);
								echo " DR";
							}
						?></td>
						</tr>
                        <tr>
                        <th style="width:10%">Date</th>
						<th style="width:10%">Invoice/Trans.ID</th>
                        <th style="width:10%">Invoice/Trans.ID Date</th>
                        <th style="width:10%">Guest Name</th>
                        <th style="width:10%">Narration</th>
                        <th style="width:10%">Paid To</th>
                        <th style="width:10%">Cheque No.</th>
                        <th style="width:10%">Cheque Date</th>
                        <th style="width:6%">Debit</th>
   						<th style="width:6%">Credit</th>
                        <th style="width:8%">Balance</th>
						</tr>
                        <?php
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;	
				        $result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` between '".datefordb($date_from)."' AND '".datefordb($date_to)."' order by `date`");
						while($row=mysql_fetch_array($result))
						{ 
							?>
							<tr align="center">
							<td><?php echo dateforview($row['date']);?></td>
                            <?php if(!empty($row['invoice_id']))
							{
							$date_invoice=mysql_query("select `date` from `invoice` where `id`='".$row['invoice_id']."'");
							$row_invoice=@mysql_fetch_array($date_invoice);
							$date_to_show=$row_invoice['date'];	 
							?>
                            <td>
                            <?php
							if(!empty($row['invoice_id']))
							{
								$exp_invoice='';
								$exp_invoice=@explode(',',$row['invoice_id']);
								foreach($exp_invoice as $value)
								{
									?>
                                      <a class="tooltips" data-placement="bottom" data-original-title="View Details of Invoice No. <?php echo $value; ?>" href="billing_view.php?id=<?php echo $value; ?>" target="_blank"><?php echo $value; ?>(Invoice)</a> 
                                    <?php
								}
							?>
                           
                            <?php }
                           	if($row['transaction_type']=='receipt'){ ?>
                            <a class="tooltips" data-placement="top" data-original-title="View Details of Receipt No. <?php echo $row['transaction_id']; ?>"
                             href="view.php?receipt=true&id=<?php echo $row['transaction_id']; ?>" target="_blank"><?php echo $row['transaction_id']; ?>(Receipt)</a>
                            <?php } ?>
                            </td>
                            <?php
							}
							else if(empty($row['invoice_id'])&&!empty($row['transaction_type'])){
							?>
							<td>
                            <?php
							if($row['transaction_type']=='jv') {
							$date_to_show=$row['date'];
						     ?>
                            <label class="tooltips" data-placement="bottom" data-original-title="View Details of JV ID <?php echo $row['transaction_id']; ?>"><a href="jv_menu.php?mode=view" target="_blank"><?php echo $row['transaction_id']; ?>(JV)</a></label>
                            <?php }
							else if($row['transaction_type']=='payment'){
								$date_to_show=$row['date'];
							 ?>
                              <label class="tooltips" data-placement="bottom" data-original-title="View Details of Payment ID <?php echo $row['transaction_id']; ?>"><a href="view.php?payment=true&id=<?php echo $row['transaction_id']; ?>" target="_blank"><?php echo $row['transaction_id']; ?>(Payment)</a></label>
                             <?php
							} 
							else if($row['transaction_type']=='corporate_billing'){
							$date_cor=mysql_query("select `date` from `corporate_billing` where `id`='".$row['transaction_id']."'");
							$row_cor=@mysql_fetch_array($date_cor);
							$date_to_show=$row_cor['date'];		
							 ?>
                              <label class="tooltips" data-placement="bottom" data-original-title="View Details of Corporate Billing ID <?php echo $row['transaction_id']; ?>"><a href="corporate_view.php?corporate=true&id=<?php echo $row['transaction_id']; ?>" target="_blank"><?php echo $row['transaction_id']; ?>(Corpor. Billing)</a></label>
                             <?php
							} 
							else if($row['transaction_type']=='receipt'){ ?>
                            <a class="tooltips" data-placement="top" data-original-title="View Details of Receipt No. <?php echo $row['transaction_id']; ?>"
                             href="view.php?receipt=true&id=<?php echo $row['transaction_id']; ?>" target="_blank"><?php echo $row['transaction_id']; ?>(Receipt)</a>
                            <?php } 
							?>
                            </td>
                            <?php
							}
							else if(empty($row['invoice_id'])&&empty($row['transaction_type'])){
								echo "<td></td>";
							}
							?>
                            <td><?php echo dateforview($date_to_show); ?></td>
							<td> 
							<?php 
						    	$result_invoice= mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$row['invoice_id']."' order by `duty_slip_id`");
						  		$row_temp=mysql_fetch_array($result_invoice);
						    	$result_duty=mysql_query("select `guest_name` from `duty_slip` where `id`='".$row_temp['duty_slip_id']."'");
						  		$row_duty=mysql_fetch_array($result_duty);
						  		$row_duty['guest_name'];
						    ?>
                            <?php echo $row_duty['guest_name']; ?>
						    </td>
                            <td><?php echo $row['narration'];?></td>
                            
                            <td>
							<?php 
							if(!empty($row['credit']))
							{
								if(!empty($row['invoice_id'])&&empty($row['transaction_id'])&&(empty($row['transaction_id'])))
								{
								$ref_amnt="select `name` from `ledger` where `debit`>'0' && `invoice_id`='".$row['invoice_id']."' ";	
								}
								else if(!empty($row['transaction_type'])&&!empty($row['transaction_id'])&&empty($row['invoice_id']))
								{
								$ref_amnt="select `name` from `ledger` where `debit`>'0' && `transaction_type`='".$row['transaction_type']."' && `transaction_id`='".$row['transaction_id']."'";			}
								else
								{
							$ref_amnt="select `name` from `ledger` where `debit`='".$row['credit']."' && `date` between '".datefordb($date_from)."' AND '".datefordb($date_to)."' ";	
								}
							}
							else if(!empty($row['debit']))
							{
								if(!empty($row['invoice_id'])&&empty($row['transaction_id'])&&(empty($row['transaction_id'])))
								{
								$ref_amnt="select `name` from `ledger` where `credit`>'0' && `invoice_id`='".$row['invoice_id']."' ";	
								}
								else if(!empty($row['transaction_type'])&&!empty($row['transaction_id'])&&empty($row['invoice_id']))
								{
								$ref_amnt="select `name` from `ledger` where `credit`>'0' && `transaction_type`='".$row['transaction_type']."' && `transaction_id`='".$row['transaction_id']."'";		
								}
								else
								{
								$ref_amnt="select `name` from `ledger` where `credit`='".$row['debit']."' && `date` between '".datefordb($date_from)."' AND '".datefordb($date_to)."' ";	
								}
							}
							$query=@mysql_query($ref_amnt);
							$all_name="";
							$row_ref_amnt=@mysql_fetch_array($query);
							echo $row_ref_amnt['name'];
							?>
							</td>
                            <td><?php echo $row['cheque_no'];?></td>
                            <td><?php echo dateforview($row['cheque_date']);?></td>
							<td><?php echo abs($row['debit']);?></td>
                           	<td><?php echo abs($row['credit']);?></td>
							<?php 
							$cr+=$row['credit'];
							$db+=$row['debit'];
if($row['debit']>0){ $ntblnce=$ntblnce-($row['debit']-$row['credit']); }else { $ntblnce=$row['credit']+$ntblnce;}
							
							
							?>
							<td>
							
							<script>document.write(CommaFormatted('<?php echo abs($ntblnce); ?>')); </script><?php
							if($ntblnce>0)
							{
								
								echo " CR";
							}
							else
							{
								echo " DR";
							}
							?>
							</td>
							</tr>
							<?php 
						}
						?>
						<tr ><th colspan="8" >&nbsp;</th>
						<th><script>document.write(CommaFormatted('<?php echo $db; ?>')); </script></th>
						<th><script>document.write(CommaFormatted('<?php echo $cr; ?>')); </script></th>
						<th><?php
							if($ntblnce>0)
							{
								?><script>document.write(CommaFormatted('<?php echo abs($ntblnce); ?>')); </script><?php
								echo " CR";
							}
							else
							{
								echo " DR";
							}
								?></th>
						</tr>
                        <tr><td colspan="11">&nbsp;</td></tr>
						<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Opening Balance:</th>
						<th>
						&nbsp;<script>document.write(CommaFormatted('<?php echo abs($opening_bal); ?>')); </script><?php
						if($opening_bal>0)
						{
							
								echo " CR";
						}
							else
							{
								echo " DR";
							}
						?></th></tr>
						<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Total Debits:</th><th>
						&nbsp;<script>document.write(CommaFormatted('<?php echo abs($db); ?>')); </script><?php echo " DR";?></th></tr>
						<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Total Credits:</th><th>
						&nbsp;<script>document.write(CommaFormatted('<?php echo abs($cr); ?>')); </script><?php echo " CR";?></th></tr>
						<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Closing Balance:</th>
						<th>
						
						<?php
							if($ntblnce>0)
							{
								?><script>document.write(CommaFormatted('<?php echo abs($ntblnce); ?>')); </script><?php
								echo " CR";
							}
							else
							{
								echo " DR";
							}
								?></th></tr>
						</table>
					<?php 	
				}
				?>
                </div>
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
        <h4><i class="icon-plus"></i>Ledger</h4>
        </div>
        <div class="portlet-body form">
        
 		<table width="100%" cellpadding="5" cellspacing="5">
        <tr>
        <td width="25%">Ledger Type:</td>
        <td><input type="text" class="m-wrap medium"  value="Ledger" disabled/></td>
        </tr>
        
        
        <tr>
        <td width="25%">Name:</td>
        <td><input type="text" name="name" id="l_name" class="m-wrap medium" placeholder="Ex. Car Hire Service"/></td>
        </tr>
 		
        <tr>
        <td width="25%">Opening Balance:</td>
        <td><input type="text" name="opening_bal" id="opening_bal" onKeyUp="allLetter(this.value,this.id);" class="m-wrap medium"/></td>
        </tr>

       
        <tr>
        <td>Group Name:</td>
        <td>
        <select name="group_name"  id="group_name" class="m-wrap medium" >	
        <option value="">---select group name---</option>
        <?php 
        $result= mysql_query("select distinct `group_name` from ledger_master where `group_name`!='Difference'");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['group_name'].'">'.$row['group_name'].'</option>';
        }
        ?>
        </select>        <button type="button" onClick="add_box(this.value);" id="add" value="add" data-placement="bottom" data-original-title="Add new group name" class="btn yellow tooltips"><i class="icon-plus" id="myicon"></i></button>

        </td>
        </tr>
        
        <tr>
        <td></td>
        <td id="place_me"></td>
        </tr>
        
        <tr>
        <td>Group Belongs To:</td>
        <td>
        <select name="group_belongs_to"  class="m-wrap medium" >	
        <option value="">---select group belongs to---</option>
        <?php 
        $result= mysql_query("select distinct `group_belongs_to` from ledger_master");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['group_belongs_to'].'">'.$row['group_belongs_to'].'</option>';
        }
        ?>
        </select>
        <button type="submit" name="ledger_reg" class="btn green"><i class="icon-ok"></i> Submit</button>
        </td>
        </tr>
        </table> 
         
  		
        
  
     
        
        <table width="100%"   class="table table-condensed table-hover" style="margin-top:5%">
        <tr>
        <th colspan="6" style="text-align:center;">Ledger Account Details</th>
        </tr>
        <tr>
        <th>SL.</th>
        <th>Ledger Type</th>
        <th>Name</th>
        <th>Group Name</th>
        <th>Group Belongs To</th>
        <th>Edit</th>
        </tr>
        <?php 
			            $result=mysql_query("select * from ledger_master order by `ledger_type_id`");
                        while($row=mysql_fetch_array($result))
                        {$i++;
							$idd=$row['id'];
							$name=$row['name'];
							$ledger_type_id=$row['ledger_type_id'];
							$group_name=$row['group_name'];
							$group_belongs_to=$row['group_belongs_to'];
                     ?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo fetchledgertype_name($ledger_type_id);?></td>
                            <td><?php echo $name;?></td>
          	        	  	<td><?php echo $group_name;?></td>
                    		<td><?php echo $group_belongs_to;?></td>
                            <td>	
                            <?php
							if($name=="Difference in opening balance")
							{
								
							}
							else
							{?>
                            	<a class="btn mini yellow tooltips" data-toggle="modal"  role="button" data-placement="left" title="Edit This Ledger"  href="#myModal_first<?php echo $i; ?>"  style="text-decoration:none;">  <i class="icon-edit"></i></a>
                                
                                   <div style="display: none;" id="myModal_first<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                               <div class="modal-header">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                               <h4 id="myModalLabel1"><span style="color:#FFB848"><i class="icon-edit"></i> <b>Edit <?php echo $name; ?></b></span></h4>
                               </div>
                               <div class="modal-body">
                                   
                                <div class="control-group">
                                <label class="control-label">Ledger Type</label>
                                <div class="controls">
                                <input type="text" disabled="disabled" class="m-wrap large" value="<?php echo fetchledgertype_name($ledger_type_id); ?>" >
                                </div>
                                </div>  
                                
                                
                                <div class="control-group">
                                <label class="control-label">Group Name</label>
                                <div class="controls">
                                <select name="gr_name<?php echo $i; ?>"  class="m-wrap large" placeholder="Group Name">
                                <option value="">---select group name---</option>
								<?php 
                                $result_group_name = mysql_query("select distinct `group_name` from ledger_master where `group_name`!='Difference'");
                                while($row_group_name=mysql_fetch_array($result_group_name))
                                {
								if($group_name==$row_group_name['group_name'])	
                                echo '<option value="'.$row_group_name['group_name'].'" selected>'.$row_group_name['group_name'].'</option>';
								else
                                echo '<option value="'.$row_group_name['group_name'].'">'.$row_group_name['group_name'].'</option>';
                                }
                                ?>
                                </select>
                                </div>
                                </div> 
                                
                                <div class="control-group">
                                <label class="control-label">Group Belongs To</label>
                                <div class="controls">
                                <select name="gr_belongs_to<?php echo $i; ?>"  class="m-wrap large" placeholder="Group Name">
                                <option value="">---select group belongs to---</option>
								<?php 
                                $result_group_belongs_to = mysql_query("select distinct `group_belongs_to` from ledger_master");
                                while($row_group_belongs_to=mysql_fetch_array($result_group_belongs_to))
                                {
                                if($group_belongs_to==$row_group_belongs_to['group_belongs_to'])	
                                echo '<option value="'.$row_group_belongs_to['group_belongs_to'].'" selected>'.$row_group_belongs_to['group_belongs_to'].'</option>';
                                else
                                echo '<option value="'.$row_group_belongs_to['group_belongs_to'].'">'.$row_group_belongs_to['group_belongs_to'].'</option>';
                                }
                                ?>
                                </select>
                                </div>
                                </div>  
                                <input type="hidden" name="ledger_id<?php echo $i; ?>" value="<?php echo $idd; ?>" />
                                </div>
                                
                                
                                <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                <button type="submit" name="update_ledger<?php echo $i; ?>" class="btn yellow"><i class="icon-question-sign"></i> Save Change</button>
                                </div>
                                   
                                </div>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php
						}
						?>
        </table>
        
        <div class="form-actions">
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
 <?php autocomplete(); ?>
 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>