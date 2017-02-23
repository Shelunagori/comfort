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
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>      
      <!-- BEGIN PAGE -->  
      <div class="page-content" id="zoom_div">
    <?php
	 if(isset($_GET['mode']))
	 {?>  
<form method="post" action="docburner.php">               
<a class="btn blue diplaynone tooltips" role="button" href="report_pending_dues.php"  title="Back" data-placement="bottom"><i class="icon-circle-arrow-left"></i></a>    
<button class="btn yellow diplaynone tooltips" role="button" title="Print" data-placement="bottom" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i></button> 
<button  type="submit" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i></button>
<input type="hidden" value="<?php echo $_POST['customer_id']; ?>" name="customer_id">
<input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
<input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
<input type="hidden" value="<?php echo $_POST['type_radio']; ?>" name="type_radio">
<input type="hidden" value="pendingdues" name="excel_for">   
</form>
 <?php
	 }
	 ?>
         <div class="container-fluid">
     <?php menu(); ?>
     <?php
	 if(isset($_GET['mode']))
	 {
		 if($_GET['mode']=='view')
		 {
					$q1="";	$q2="";	$q3="";	$q4=" && `waveoff_status`='0' ";
				
					if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
					{
					$date_from=datefordb($_POST['date_from']);
					$date_to=datefordb($_POST['date_to']);
					$q2=" AND `date` between '".$date_from."' and '".$date_to."' ";
					}
					
					
					if(!empty($_POST['customer_id']))
					{
					$q3=" AND `customer_id` = '".$_POST['customer_id']."' ";
					}  
				
					$type_radio=$_POST['type_radio'];
					if($type_radio=='invoice')
						{
						$q1=" payment_status='no' ";
						$qry=" select `customer_id`,`date`,`grand_total`,`id` from invoice where ";
						}
					else
						{
						$q1=" billing_status='no' ";
						$qry=" select `extra_amnt`,`customer_id`,`date`,`tot_amnt`,`id` from duty_slip where ";
						}
						
						$sql=$qry.$q1.$q2.$q3.$q4;
						$result=mysql_query($sql);
			
	 		?>
            <div class="portlet box blue">
            <div class="portlet-title">
            <h4><i class="icon-eye-close"></i>Result for Pending Dues</h4>
            </div>
            <div class="portlet-body form">
          	<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
            <table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1">
            <thead>
            <tr>
            <th>SL.</th>
            <?php
			if($type_radio=='invoice'){?>
            <th>Invoice No.</th> <?php } else { ?>
            <th>Duty Slip No.</th>  <?php } ?>
            <th>Customer Name</th>
            <th>Date</th>
            <th>Grand Total</th>
	      <?php if($type_radio=='invoice'){?>
            <th>Received Amt.</th>
            <th>Due Amt.</th>
            <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php
			if($type_radio=='invoice')
			{
					while($row=mysql_fetch_array($result))
					{$i++;
						$receive_amnt=0;
						$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$row['id']."' && `due_amnt`>'0'");
						if(mysql_num_rows($check_receipt_detail)>0)
						{
						$row_receipt_detail=mysql_fetch_array($check_receipt_detail);
						$due_amnt=$row_receipt_detail['due_amnt'];
						}
						else
						{
						$due_amnt=$row['grand_total'];
						}
						$receive_amnt=$row['grand_total']-$due_amnt;  
						?>
                            <tr>
							<td><?php echo $i;?></td>
							<td><a class="tooltips" data-placement="bottom" data-original-title="View Details of Invoice No. <?php echo $row['id']; ?>" href="billing_view.php?id=<?php echo $row['id']; ?>" target="_blank"><strong><?php echo $row['id']; ?></strong></a> </td>
							<td><?php echo fetchcustomername($row['customer_id']); ?></td>
							<td><?php echo dateforview($row['date']); ?></td>
							<td><?php echo $row['grand_total']; ?></td>
                            <td><?php echo $receive_amnt; ?></td>
                        	<td><?php echo $due_amnt; ?></td>
                            </th>
							</tr>
						<?php
					 }
			}
			else
			{
					while($row=mysql_fetch_array($result))
					{$i++;
						
						$amount=$row['extra_amnt']+$row['tot_amnt'];
						?>
	                        <tr>
							<td><?php echo $i;?></td>
							<td><a class="tooltips" data-placement="bottom" data-original-title="View Details of DutySlip No. <?php echo $row['id']; ?>" href="dutyslip_view.php?dutyslip=true&id=<?php echo $row['id']; ?>" target="_blank"><strong><?php echo $row['id']; ?></strong></a></td>
							<td><?php echo fetchcustomername($row['customer_id']); ?></td>
							<td><?php echo dateforview($row['date']); ?></td>
							<td><?php echo $amount; ?></td>
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
	 }
	 else
	 {
		 ?>
        <form  name="form_name" action="report_pending_dues.php?mode=view" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-bolt"></i>Pending Dues</h4>
        </div>
        <div class="portlet-body form">
            
        <div class="control-group">
        <label class="control-label">Type</label>
        <div class="controls">
        <label class="radio"><input name="type_radio" class="radio" checked type="radio" value="invoice"  />Invoice</label>
        <label class="radio"><input name="type_radio" class="radio" type="radio" value="dutyslip"/>Duty Slip</label>
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
        <label class="control-label">Date From</label>
        <div class="controls">
        <input type="text" name="date_from" onClick="mydatepick();"  class="span6 m-wrap date-picker" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Date To</label>
        <div class="controls">
        <input type="text" name="date_to" onClick="mydatepick();" class="span6 m-wrap date-picker" />
        </div>
        </div>    
     
        <div class="form-actions">
        <button type="submit"   class="btn green" name="done"/><i class="icon-signal"></i> Generate</button>
        <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>