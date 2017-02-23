<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
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
     <?php temp(); ?>
    	<?php
		if(isset($_POST['billing_operate']))
		{
			
							if(isset($_GET['billing_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Invoice Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['billing_waveoff']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Invoice Waveoff</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i> Invoice Edit</h4>
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
                       	<th>Invoice No.</th>
                       	<th>Duty Slip ID</th>
                       	<th>Guest Name</th>
                        <th>Customer Name</th>
                        <th>Date</th>
                        <th>Grand Total</th>
                         <?php
							if(isset($_GET['billing_view']))
							{
								?>
                                 <th>View|PDF</th>
                                 <?php
							}
							else if(isset($_GET['billing_waveoff']))
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
				$q1="";	$q2="";	$q3="";	$q4=""; $q5=""; $qry="";
				if(!empty($_POST['id']))
				{
					$id=$_POST['id'];
					$q1="id='".$id."'";
				}
				if(!empty($_POST['customer_id']))
				{
					$customer_id=$_POST['customer_id'];
					if($q1=="")
						$q2=" customer_id='".$customer_id."'";
					else 
						$q2=" AND customer_id='".$customer_id."'";
				}
				if(!empty($_POST['date']))
				{
					$date=datefordb($_POST['date']);
					if($q1=="" && $q2=="")
						$q3=" date='".$date."'";
					else 
						$q3=" AND date='".$date."'";
				}
				if(!empty($_POST['ds_no']))
				{	
					 $ds_no=$_POST['ds_no'];
					 $fetch_ds_id="(select `invoice_id` from `invoice_detail` where `duty_slip_id`=".$ds_no.")";
					 if($q1=="" && $q2=="" && $q3=="")	
					 $q4=" `id`in".$fetch_ds_id."";	
					 else
					 $q4=" AND  `id`in".$fetch_ds_id."";
				}
				if(!empty($_POST['guest_name']))
				{
					$guest_name=$_POST['guest_name'];
					$res_ins_id=mysql_query("select `id` from `duty_slip` where `guest_name`='".$guest_name."'");
					$row_ins_id=mysql_fetch_array($res_ins_id);
 					$fetch_ins_id="(select `invoice_id` from `invoice_detail` where `duty_slip_id` = ".$row_ins_id['id'].")";
					if($q1=="" && $q2=="" && $q3=="" && $q4=="")	
					$q5=" `id`in".$fetch_ins_id."";
					else 
					$q5=" AND `id`in".$fetch_ins_id."";
				}
                if($q1=="" && $q2=="" && $q3=="" && $q4=="" && $q5=="")
				{
                	$qry ="select * from invoice";
					//$q6= " where `waveoff_status`!='1' ";
				}
                else    {
						$qry="select * from invoice where ";
						//$q6=" and `waveoff_status`!='1' ";
						}
                        $sql=$qry.$q1.$q2.$q3.$q4.$q5.$q6;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        $idd=$row['id'];
						$duty_slip_id="";	
						$res_duty=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$idd."'");
							while($row_duty=mysql_fetch_array($res_duty))
							{
								$duty_slip_id[]=$row_duty['duty_slip_id'];
							}
								$ds=@implode(",",$duty_slip_id);
						$tot_guest=mysql_query("select `guest_name` from `duty_slip` where `id`='".$duty_slip_id[0]."'");
						$row_guest=mysql_fetch_array($tot_guest);
								
					?>
                      		<tr id="<?php echo $i; ?>" style="<?php if($row['waveoff_status']=='1'){ ?> background-color:#F2DEDE; <?php } else if($row['payment_status']=='yes'){ ?>  background-color:#DFF0D8; <?php } ?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $idd;?></td>
                            <td><span class="label label-info popovers" data-placement="right" data-title="<?php if($row['waveoff_status']=='1'){ ?> Waveoff invoice <?php } else if($row['payment_status']=='yes'){ ?> Payment have been Done <?php } ?>"  data-trigger="hover"  data-content="<?php echo $ds; ?>">dutyslip id</span></td>
                            <td><?php echo $row_guest['guest_name']; ?>
                          	<td><?php echo fetchcustomername($row['customer_id']); ?></td>
                            <td><?php echo dateforview($row['date']); ?></td>
                            <td><?php echo $row['grand_total']; ?></td>
                         <?php
							if(isset($_GET['billing_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="billing_view.php?invoice=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                <a class="btn mini red"  role="button" href="pdf.php?billing=true&id=<?php echo $idd;?>"  style="text-decoration:none;">
    							<i class="icon-download-alt"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['billing_waveoff']))
							{
								if($row['waveoff_status']=='0')
								{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-bar-chart"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-bar-chart"></i> <b><?php echo fetchcustomername($row['customer_id']); ?></b></span></h4>
                            </div>
                            <div class="modal-body">
                           
                            <div class="controls">
                            <input type="text"  name="waveoff_reason" id="waveoff_reason<?php echo $i; ?>" placeholder="Enter Waveoff Reason" class="span12 m-wrap">
                            </div>   
                            
                            </div>
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_invoice(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-bar-chart"></i> Waveoff Now</button>
                            </div>
                            </div>        
                                    
                            </td>
                                
                                 <?php
								}
								else
								{
									?>
                                    <td></td>
                                    <?php
								}
							}
							else 
							{
								
								?>
                                 <td>
                                  <?php 
								  if($row['waveoff_status']=='1')
								  {
									  ?>
                                          <a class="btn mini red"  role="button"  data-toggle="modal" href="#myModal_wave<?php echo $i ?>" style="text-decoration:none;"><i class="icon-edit"></i></a>	
                                            <div style="display: none;" id="myModal_wave<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B;  font-size:13px;"><strong>Note: This is Waveoff Bill. </strong></span></h4>
                                    </div>
                               
                                    <div class="modal-footer">
                                    <button class="btn red" data-dismiss="modal" aria-hidden="true">Ok</button>	
                                    </div>
                                    </div>         
                                         <?php
								  }
								  else if($row['payment_status']=='no' || $row['payment_status']=='yes')
								  {?>
                                 <a class="btn mini red"  role="button" href="update_billing.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>		<?php }
								 else { ?>
                                  <a class="btn mini red"  role="button"  data-toggle="modal" href="#myModal_wave<?php echo $i ?>" style="text-decoration:none;"><i class="icon-edit"></i></a>	
                                    <div style="display: none;" id="myModal_wave<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B; font-style:italic; font-size:13px;"><b>Note: You Can't Edit This DS Due To Payment Reason. </b></span></h4>
                            </div>
                       
                            <div class="modal-footer">
                            <button class="btn red" data-dismiss="modal" aria-hidden="true">Ok</button>	
                            </div>
                            </div>         
                                 <?php
								 }
								 ?>
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
			 if($_GET['mode']=='del')
			{
				?>
						<div class="portlet box red" >
						<div class="portlet-title">
						<h4><i class="icon-trash"></i>Invoice Waveoff</h4>
						</div>
						<div class="portlet-body form">
						<form action="billing_menu_operation.php?billing_waveoff=true" class="form-horizontal" name="form_name" autocomplete="off" method="post">
					    
                        <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls">
                        <input name="id" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                        
                         <div class="control-group">
                        <label class="control-label">DutySlip No.</label>
                        <div class="controls">
                        <input name="ds_no" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                        <select name="customer_id" class="span6 m-wrap chosen">
                        <option value="">---select customer---</option>
                        <?php 
                        $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date of Billing</label>
                        <div class="controls">
                        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Guest Name</label>
                        <div class="controls">
                        <input type="text" id="guest_name"  class="span6 m-wrap" name="guest_name">
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="billing_operate"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
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
                        <h4><i class="icon-search"></i>Invoice View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="billing_menu_operation.php?billing_view=true" class="form-horizontal" name="form_name" autocomplete="off" method="post">
                        
                        <div class="control-group">
                        <label class="control-label">Invoice No.</label>
                        <div class="controls">
                        <input name="id" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">DutySlip No.</label>
                        <div class="controls">
                        <input name="ds_no" type="text" class="span6 m-wrap">
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Customer Name</label>
                        <div class="controls">
                        <select name="customer_id" class="span6 m-wrap chosen">
                        <option value="">---select customer---</option>
                        <?php 
                        $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Date of Billing</label>
                        <div class="controls">
                        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
                        </div>
                        </div>
                        
                        <div class="control-group">
                        <label class="control-label">Guest Name</label>
                        <div class="controls">
                        <input type="text" id="guest_name"  class="span6 m-wrap" name="guest_name">
                        </div>
                        </div>
                        
                        <div class="form-actions">
                        <button type="submit"   class="btn green" name="billing_operate"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
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
        <form  name="add_form"  class="form-horizontal" method="post" action="billing_menu_operation.php?billing_edit=true">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Edit</h4>
        </div>
        <div class="portlet-body form">
      	
        <div class="control-group">
        <label class="control-label">Invoice No.</label>
        <div class="controls">
        <input name="id" type="text" class="span6 m-wrap">
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">DutySlip No.</label>
        <div class="controls">
        <input name="ds_no" type="text" class="span6 m-wrap">
        </div>
        </div>
        
     	<div class="control-group">
        <label class="control-label">Customer Name</label>
        <div class="controls">
        <select name="customer_id" class="span6 m-wrap chosen">
        <option value="">---select customer---</option>
        <?php 
        $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
        while($row=mysql_fetch_array($result))
        {
        echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select>
        </div>
        </div>
        
       	<div class="control-group">
        <label class="control-label">Date of Billing</label>
        <div class="controls">
        <input type="text" name="date"  class="span6 m-wrap date-picker"  onClick="mydatepick();">
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Guest Name</label>
        <div class="controls">
        <input type="text" id="guest_name"  class="span6 m-wrap" name="guest_name">
        </div>
        </div>
        
        <div class="form-actions">
        <button type="submit"   class="btn green" name="billing_operate"/><b>Proceed <i class="icon-circle-arrow-right"></i></b></button>
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
<script>
if (App.isTouchDevice()) { // if touch device, some tooltips can be skipped in order to not conflict with click events
	jQuery('.popovers:not(.no-popover-on-touch-device)').tooltip();
} else {
	jQuery('.popovers').popover();
}
</script>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>