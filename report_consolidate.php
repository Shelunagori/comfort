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
     <script>
 window.onload=init;
		function init()
		{
			var abc="zoom_out";
			fun_zoom(abc);
		}
 </script>   
<form method="post" action="docburner.php">               
<a class="btn blue diplaynone tooltips" role="button" href="report_consolidate.php"  title="Back" data-placement="bottom"><i class="icon-circle-arrow-left"></i></a>    
<button class="btn yellow diplaynone tooltips" role="button" title="Print" data-placement="bottom" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i></button> 
<button  type="submit" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i></button>
<input type="hidden" value="<?php echo $_POST['customer_id']; ?>" name="customer_id">
<input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
<input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
<input type="hidden" value="consolidated" name="excel_for">
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
		 // You can also see same time of report in spsu library @ report_condition.php 
					$i=0;$p1=$p2="";
					$p3=" AND `waveoff_status`='0' ";
					$p4=" AND `com`='0' ";
					$p5=" ORDER BY `customer_id`,`date` ";
					if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
						{
							$p2=" AND  `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
						}
					if(!empty($_POST['customer_id']))
						{
						$p1=" AND `customer_id`='".$_POST['customer_id']."'";
						
						if($p2=="")
							{
								$p1=" AND `customer_id`='".$_POST['customer_id']."'";
							}
						}
					$result=mysql_query("select * from `invoice` where (1=1)$p1$p2$p3$p4$p5");			
	 		?>
            <div class="portlet box blue">
            <div class="portlet-title">
            <h4><i class="icon-inbox"></i>Result for <?php echo fetchcustomername($_POST['customer_id']); ?> Total Billing <?php 	if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to']))) { ?> From <?php echo dateforview($_POST['date_from']); ?> To <?php echo dateforview($_POST['date_to']); ?> <?php } ?></h4>
            </div>
            <div class="portlet-body form">
          	<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
            <table width="100%" class="table table-bordered table-hover table-condensed flip-content" >
            <thead>
            <tr>
            <th>SL.</th>
            <th>Date</th>
            <th>In.No.</th>
            <th>Ds.No.</th>
            <th>Guest</th>
            <th>Service</th>
            <th>Ds.Amt</th>
            <th>Gross</th>
            <th>TAX</th>
            <th>Discount</th>
            <th>TotalAmt</th>
            </tr>
            </thead>
            <tbody>
             <?php
			 				$grand_amnt=0;
							while($row_list=mysql_fetch_array($result))
							{$i++;
							$count=0;
							$count_sl=0;
							$count_ins=0;
							$count_gross=0;
							$count_tax=0;
							$count_discount=0;
							$count_grand=0;
							$grand_amnt+=$row_list['grand_total'];
									if(empty($_POST['customer_id']))
									{
									if (in_array(@$row_list['customer_id'], @$data_store)) 
									{
										
									}
									else
									{
									$data_store[]=@$row_list['customer_id'];
									?>
									<tr>
									<td colspan="11" style="background-color:#D9EDF7; text-align:center"><b>Customer: <?php echo fetchcustomername($row_list['customer_id']); ?></b></td>
									</tr>
									<?php
									} 
									}
							$result_ins_detail=@mysql_query("select * from `invoice_detail` where `invoice_id`='".$row_list['id']."'");	
							$num_ds=@mysql_num_rows($result_ins_detail);
							while($row_ins_detail=@mysql_fetch_array($result_ins_detail))
							{
								
								$rs_ds=@mysql_query("select `guest_name`,`service_id` from `duty_slip` where `id`='".$row_ins_detail['duty_slip_id']."'");
								while($row_ds=@mysql_fetch_array($rs_ds))
								{
								?>
                            <tr>
                            <?php
							if(($num_ds!=$count_sl)){ $count_sl=$num_ds; ?>
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo $i; ?></td>
                            <?php
							}
                            else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                            <?php
							if(($num_ds!=$count)){ $count=$num_ds; ?>
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo dateforview($row_list['date']); ?></td>
                            <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                             <?php
							if(($num_ds!=$count_ins)){ $count_ins=$num_ds; ?>
                            
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><label class="tooltips" data-placement="bottom" title="Click To See Invoice" onClick="window.open('pdf.php?billing=true&id=<?php echo $row_list['id'];?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');" ><strong><?php echo $row_list['id'];?></strong></label></td>
                             <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                            <td style="text-align:center;"><label class="tooltips" data-placement="bottom" title="Click To See Ds" onClick="window.open('pdf.php?dutyslip=true&id=<?php echo $row_ins_detail['duty_slip_id'];?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');" ><strong><?php echo $row_ins_detail['duty_slip_id'];?></strong></label></td>
                            <td><?php echo $row_ds['guest_name']; ?></td>
                            <td><?php echo fetchservicename($row_ds['service_id']); ?></td>
                            <td><?php echo $row_ins_detail['amount']; ?></td>
                            <?php
							if(($num_ds!=$count_gross)){ $count_gross=$num_ds; ?>
                            
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo $row_list['total']; ?></td>
                             <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                            <?php
							if(($num_ds!=$count_tax)){ $count_tax=$num_ds; ?>
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo $row_list['tax']; ?></td>
                               <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                             <?php
							if(($num_ds!=$count_discount)){ $count_discount=$num_ds; ?>
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo $row_list['discount']; ?></td>
                             <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                            <?php
							if(($num_ds!=$count_grand)){ $count_grand=$num_ds; ?>
                            <td rowspan="<?php echo $num_ds; ?>" style="vertical-align: middle;"><?php echo $row_list['grand_total']; ?></td>
                              <?php
							}
							else
							{
								?>
                                <td style="display:none !important;">&nbsp;</td>
                                <?php
							}
							?>
                            </tr>
                            <?php
								}
							}
                            }
							?>
                            <tr>
                            <th colspan="10"><?php echo convert_number_to_words($grand_amnt); ?></th>
                            <th><?php echo $grand_amnt; ?></th>
                            </tr>
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
        <form  name="form_name" action="report_consolidate.php?mode=view" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-inbox"></i>Total Billing Report</h4>
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