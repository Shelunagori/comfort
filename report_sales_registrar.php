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
<div style="padding: 1px;">
<form method="post" action="docburner.php">
<a class="btn blue diplaynone tooltips" role="button" href="report_sales_registrar.php"  title="Back" data-placement="bottom"><i class="icon-circle-arrow-left"></i></a>    
<button class="btn yellow diplaynone tooltips" role="button" title="Print" data-placement="bottom" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i></button> 

<button  type="submit" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i></button>

<input type="hidden" value="<?php echo $_POST['customer_id']; ?>" name="customer_id">
<input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
<input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
<input type="hidden" value="sales_register" name="excel_for">
</form>
</div>
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
		 // You can also see same time of report in spsu library @ report_condition.php 
					$i=0;$p1=$p2=$p3="";
					$p4=" ORDER BY `customer_id`,`date` ";
					if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
						{
							$p2=" AND  `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
						}
					if(!empty($_POST['customer_id']))
						{
						$p1=" AND `customer_id`='".$_POST['customer_id']."'";
						$cus_name=fetchcustomername($_POST['customer_id']);
						$p5=" AND `customer_name`='".$cus_name."'";
						if($p2=="")
							{
								$p1=" AND `customer_id`='".$_POST['customer_id']."'";
							}
						}
						$p3=" AND `com`='0' ";
						
						$p4=" ORDER BY `customer_id`,`date`";
						$result=mysql_query("select * from `invoice` where (1=1)$p1$p2$p3$p4");	

						$result1=mysql_query("select * from `corporate_billing` where (1=1)$p2$p5");
						$row_list1=mysql_fetch_array($result1);
						
						
	 		?>
            <div class="portlet box blue">
            <div class="portlet-title">
            <h4><i class="icon-inbox"></i>Result for <?php echo fetchcustomername($_POST['customer_id']); ?> Sales Registrar </h4>
            </div>
            <div class="portlet-body form">
          	<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
            <table width="100%" class="table table-bordered table-hover table-condensed flip-content">
            <thead>
            <tr>
            <th>SL.</th>
            <th>Customer Name</th>
            <th>Date</th>
            <th>Invoice No.</th>
            <th>Total Amount</th>
			<th>Discount</th>
			
            <th>TAX</th>
            <th>Grand Total</th>
            </tr>
            </thead>
            <tbody>
			<tr>
						<td colspan="9" style="text-align:center"><b>Result for Invoice</b></td>
						</tr>
             <?php
							while($row_list=mysql_fetch_array($result))
							{$i++;
							$waveoff_status=$row_list['waveoff_status'];
							if($waveoff_status==0)
							{
							
									if(empty($_POST['customer_id']))
									{
									if (@in_array(@$row_list['customer_id'], @$data_store)) 
									{
										
									}
									else
									{
									$data_store[]=@$row_list['customer_id'];
									?>
									<tr>
									<td colspan="9" style="background-color:#D9EDF7; text-align:center"><b>Customer: <?php echo fetchcustomername($row_list['customer_id']); ?></b></td>
									</tr>
									<?php
									} 
									}
									$inv_id=$row_list['id'];
									$othercharges=0;
									
									$result_invoice_detail=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$inv_id."' order by `duty_slip_id`");	
										while($row_invoice_detail=mysql_fetch_array($result_invoice_detail))
										{
												
												$result_duty=mysql_query("select * from duty_slip where `id`='".$row_invoice_detail['duty_slip_id']."'");	
												$row_duty=mysql_fetch_array($result_duty);
												
												
													if(!empty($row_duty['permit_chg']))
													{
													$othercharges+=$row_duty['permit_chg'];
													}
													if(!empty($row_duty['parking_chg']))
													{
													$othercharges+=$row_duty['parking_chg'];
													}
													if(!empty($row_duty['otherstate_chg']))
													{
													$othercharges+=$row_duty['otherstate_chg'];
													}
													if(!empty($row_duty['guide_chg']))
													{
													$othercharges+=$row_duty['guide_chg'];
													}
													if(!empty($row_duty['misc_chg']))
													{
													$othercharges+=$row_duty['misc_chg'];
													}
										}
												
									$total+=$row_list['total'];
									$discount+=$row_list['discount'];
									$tax+=$row_list['tax'];
									$grand_total+=$row_list['grand_total'];
									$customer_id=$row_list['customer_id']
								?>
                            <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo fetchcustomername($customer_id); ?></td>
                            <td><?php echo dateforview($row_list['date']); ?></td>
                            <td><label class="tooltips" data-placement="bottom" title="Click To See Invoice" onClick="window.open('pdf.php?billing=true&id=<?php echo $row_list['id'];?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');" ><strong><?php echo $row_list['id'];?></strong></label></td>
                            <td><?php echo $row_list['total']; ?></td>
							<td><?php echo $row_list['discount']; ?></td>
							<td><?php echo $row_list['tax']; ?></td>
                            <td><?php echo $row_list['grand_total']; ?></td>
                            </tr>
                            <?php
                            	}
							}
							?>
						<tr>
							<td colspan="9" style="text-align:center"><b>Result for Corporate Billing</b></td>
						</tr>
					 <?php
					 $j=0;
						while($row_list1=mysql_fetch_array($result1))
						{$j++;
							$waveoff_status=$row_list1['waveoff_status'];
							if($waveoff_status==0)
							{
								
								if(empty($_POST['customer_id']))
								{
									if (@in_array(@$row_list1['customer_name'], @$data_store1)) 
									{
										
									}
									else
									{
									$data_store1[]=@$row_list1['customer_name'];
									?>
									<tr>
									<td colspan="9" style="background-color:#D9EDF7; text-align:center"><b>Customer: <?php echo $row_list1['customer_name']; ?></b></td>
									</tr>
									<?php
									} 
								}	
								?>
							<tr>
                            <td><?php echo $j; ?></td>
                            <td><?php echo $row_list1['customer_name']; ?></td>
                            <td><?php echo dateforview($row_list1['date']); ?></td>
                            <td><label class="tooltips" data-placement="bottom" title="Click To See corporate billing" onClick="window.open('corporate_view.php?corporate=true&id=<?php echo $row_list1['id'];?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');" ><strong><?php echo $row_list1['id'];?></strong></label></td>
                            <td><?php echo $row_list1['tot_amnt']; ?></td>
							<td><?php echo $row_list1['discount']; ?></td>
							
                            <td><?php echo $row_list1['service_tax']; ?></td>
                            <td><?php echo $row_list1['net_amnt']; ?></td>
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
        <form  name="form_name" action="report_sales_registrar.php?mode=view" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-inbox"></i>Sales Registrar</h4>
        </div>
        <div class="portlet-body form">
               
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