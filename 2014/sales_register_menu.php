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
         <?php
         if(isset($_GET['mode']))
				{ ?>
         <a class="btn green diplaynone"  role="button"  href="javascript:window.print();" style="text-decoration:none; margin-top:1%;"><i class="icon-print"></i>Print</a>
           <a class="btn yellow diplaynone" target="_blank"  href="excel_all.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&type=sales_registrar&customer_name=<?php echo $_POST['customer_name']; ?>" style="text-decoration:none; margin-top:1%;"><i class="icon-download-alt"></i> Export in Excel</a>
         <?php
				}?>
     <?php menu(); ?>
           <?php
	if(isset($_GET['mode']))
				{
					if($_GET['mode']=='view')
					{
						$i=0;$p1=$p2=$p3="";
					$mydatabase = new DataBaseConnect();
						
						if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
							{
								$p2=" AND  `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ";
							}
						if(!empty($_POST['customer_name']))
							{
							$p1=" AND `duty_slip_customer_reg_name`='".$_POST['customer_name']."'";
							
							if($p2=="")
								{
									$p1=" AND `duty_slip_customer_reg_name`='".$_POST['customer_name']."' ";
								}
							}
						 /*if($p1=="" AND $p2=="")
							{
								$p3=" ORDER BY `duty_slip_customer_reg_name`,`date`";
							}*/
							if($p1=="" AND $p2=="")
							{
							$p3=" `comp`!='yes' ";
							}
							else
							{
							$p3=" AND `comp`!='yes' ";
							}
							
							$p4=" ORDER BY `duty_slip_customer_reg_name`,`date` ";
						//echo "select * from invoice where (1=1)$p1$p2$p3$q4";
						$result= $mydatabase->execute_query_return("select * from `invoice` where (1=1)$p1$p2$p3$p4");
						//$row=mysql_fetch_array($result);
						?>
						<?php
						$total=0;
						$reg_nm=""; $ch=0;
						while($row=mysql_fetch_array($result))
						{ $i++;
						 
						 
						 if($row['duty_slip_customer_reg_name'] != $reg_nm)
								{ 
								if($ch != 0)
								{
								?>
									</table>
								<?php
									} 
							?>
					<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px">
                            <thead>
                                <tr>
                                <th>Sr. No.</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Invoice No.</th>                              
                                <th>Total Amount</th>
                                <th>Tax</th>
                                <th>Grand Total</th>
                                <th></th>
                                </tr>
                                </thead>
                                <tbody>
                           <tr>

							<?php $ch++;	
							$reg_nm=$row['duty_slip_customer_reg_name'];
							
						$qry_cust="select * from `customer_reg` where `id`='".$row['duty_slip_customer_reg_name']."'";
						$data_base_object_cust = new DataBaseConnect();
						$result_cust= $data_base_object_cust->execute_query_return($qry_cust);
						$row_cust=mysql_fetch_array($result_cust);
						$customer_name=$row_cust['name'];
						
							}
						?>
						<td><?php echo $i; ?></td>
                        <td><?php echo $customer_name; ?></td>
						<td><?php echo date("d-M-Y", strtotime($row['date']));?></td>
						<td><?php echo $row['invoice_id'];?></td>						
						<td><?php echo $row['total'];?></td>
						<td><?php echo $row['tax'];?></td>
						<td><?php echo $row['grand_total'];?></td>
                        <td><a href="InvoiceView.php?invoiceid=<?php echo $row['invoice_id'];?>"  target="_blank" style="text-decoration:none;"><?php echo $row['invoice_id'];?></a></td>				
						</tr>	
						<?php
						$total+=$row['grand_total'];
						}
						?>
                         </tbody>	
                        <tfoot>
						<tr>
						<th colspan="5">Total:</th>
						<td><?php echo $total; ?></td>
                        <td></td>
						</tr>
                        </tfoot>
				<?php	} ?>
           		</table>
						<?php
						$mydatabase->close_connection();
				}
	else
	{
	?>
        <form action="sales_register_menu.php?mode=view" name="form_name" method="post">
                  <table width="100%">
                  <tr><td  width="20%"> Customer Name:</td><td><select name="customer_name"  class="chosen">
    							 <option value="">Customer Name</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									   echo '<option value="'.$row['id'].'" ">'.$row['name'].'</option>';
									}
        				      ?>

                               </select></td></tr>
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
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js();?>
<?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>