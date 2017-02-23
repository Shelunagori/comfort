<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Comfort</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
  <?php css(); ?>
  <style>
  @media print {
    a {
        display:none;
    }
} 
</style> 
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
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
      <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-credit-card"></i>Invoice Deleted</h4>
                    </div>
                    <div class="portlet-body form">
                      <?php
	if(isset($_GET['mode']))
				{
					if($_GET['mode']=='view')
					{
						$i=0;
					$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `invoice_deleted` where `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."'  ORDER BY `date`");
						?>
                          <a class="btn yellow diplaynone" target="_blank"  href="excel_all.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&type=deleted_invoice" style="text-decoration:none; margin-top:1%;"><i class="icon-download-alt"></i> Export in Excel</a>
                          
						<table width="100%" style="border:1px solid silver; margin-top:2%" class="table table-bordered table-hover">
                        <thead>
						<tr>
						<th>Sr. No.</th>
						<th>Duty Slip No.</th>
						<th>Invoice No.</th>
						<th>Date</th>
						<th>Customer Name</th>
						<th>Reason</th>
						<th>Login Name</th>
                        <th></th>
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
						while($row=mysql_fetch_array($result))
						{ $i++;
						$qry_cust="select * from `customer_reg` where `id`='".$row['duty_slip_customer_reg_name']."'";
						$data_base_object_cust = new DataBaseConnect();
						$result_cust= $data_base_object_cust->execute_query_return($qry_cust);
						$row_cust=mysql_fetch_array($result_cust);
						$customer_name=$row_cust['name'];
						?>
						<td><?php echo $i; ?></td>
							<td><?php echo $row['duty_slip_dutyslip_id'];?></a></td>
							<td><?php echo $row['invoice_invoice_id'];?></td>
						<td><?php echo date("d-M-Y", strtotime($row['date']));?></td>
												
						<td><?php echo $customer_name;?></td>
						<td><?php echo $row['reason'];?></td>
						<td><?php echo $row['loginname'];?></td>
                        <td><a href="update_dutyslip.php?id=<?php echo $row['duty_slip_dutyslip_id'];?>" target="_new"><b><?php echo $row['duty_slip_dutyslip_id'];?></b></a></td>
						</tr>				
						<?php
						}
						?>
                        </tbody>
						</table>
						<?php
						$mydatabase->close_connection();
					}
				}
                    
				else
				{
					?>
     <form action="invoice_delete_menu.php?mode=view" name="form_name" method="post">
               <table width="100%">
              	<tr><td  width="20%"> Date From</td><td width="20%"><input type="text" name="date_from"  id="dp1" class="m-wrap medium"/></td><td></td></tr>
				<tr><td> Date To</td><td><input type="text" name="date_to" id="dp2"  class="m-wrap medium"/></td>
			<td><button type="submit" class="btn green" value="Submit" style="margin-left:1%; margin-top:-2% !important"  name="ledger_reg">Go <i class="icon-circle-arrow-right"></i></button></td></tr>
                </table>
              </form>  
              
              
                <?php
	}
	?>
    </div>
    </div>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>