<?php 
require_once("function.php");
require_once("auth.php");
include("config.php");
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
     <form  name="form_name" method="post">
      <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-table"></i>DutySlip and Invoice <?php echo date("d-M-Y") ?></h4>
                    </div>
                    <div class="portlet-body form">
                        <table width="100%" border="1" style="border-collapse:collapse;" bordercolor="#10A062">
                        <tr style="background-color:#DFF0D8;" >
                        <th width="5%">S.No</th>
                        <th width="10%">DutySilp No</th>
                        <th  width="10%">Invoice No</th>
                        <th width="10%">DS Date</th>
                        <th  width="10%">Mobile No</th>
                        <th width="20%">Guest Name</th>
                        <th width="20%">Service</th>
                        <th width="10%">Total Amount</th>
                        </tr>
                   <?php
				        $s=1;
						$total=mysql_query("select * from `duty_slip` ");
						while ($row = mysql_fetch_array($total)) 											
						{ 
						$i++;
						$reg_all=mysql_query("select * from `duty_slip` where `customer_reg_name`='$i' && `max_invoice_id`!='' ");
						$num_rows = mysql_num_rows($reg_all);
						if($num_rows==0)
						{
						$s++;
						}
							while($ftc_data=mysql_fetch_array($reg_all))
							{	
							$k++;
							$customer_reg_name= $ftc_data['customer_reg_name'];
							$cust_all=mysql_query("select * from `customer_reg` where `id` = '$customer_reg_name'  ");
							$ftc_cust=mysql_fetch_array($cust_all);
							$cust_name = $ftc_cust['name'];
							$dutyslip_id = $ftc_data['dutyslip_id'];
							$max_invoice_id = $ftc_data['max_invoice_id'];
							$current_date = $ftc_data['current_date'];
							$detail_number = $ftc_data['detail_number'];
							$guest_name = $ftc_data['guest_name'];
							$service_service_id = $ftc_data['service_service_id'];
							$service_all=mysql_query("select * from `service` where `service_id` = '$service_service_id'  ");
							$ftc_service=mysql_fetch_array($service_all);
							$service_name = $ftc_service['name'];
							$amount = $ftc_data['amount'];
							if($i==$s)
							{
							$s++;
                            ?>
                                <tr>
                                <td colspan="8" style="background-color:#DFF0D8"><b>Customer Name-<?php  echo $cust_name;?></b></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>  
                                <td width="5%"><?php echo  $k ?></td>
                                <td width="10%"><b><?php echo $dutyslip_id ?></b></td>
                                <td width="10%"><b><?php echo $max_invoice_id ?></b></td>
                                <td width="10%"><?php echo date("d-M-Y",strtotime($current_date ))?></td>
                                <td width="10%"><?php echo $detail_number ?></td>
                                <td width="20%"><?php echo $guest_name ?></td>
                                <td width="20%"><?php echo $service_name ?></td>
                                <td width="10%"><?php echo $amount ?></td>
                                </tr>
                                <?php
                                }
                                }
                                ?>
                                </table>

						
   
  
   </div></div>
   </form>
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