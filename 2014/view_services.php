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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
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
     <form method="post">
<div>                     
<a href="service_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="service_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="service_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="service_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div> 
<br />
 <div class="portlet box yellow">
							<div class="portlet-title">
								<h4><i class="icon-table"></i>View</h4>
							</div>
							<div class="portlet-body">
                 
 <?php
if(isset($_GET['supplier']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `supplier_reg` where `supplier_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$supplier_master_id=$row['supplier_master_id'];
	$qry_supplier="select * from `supplier_master` where `id`='$supplier_master_id'";
	$data_base_object = new DataBaseConnect();
	$result_supplier = $data_base_object->execute_query_return($qry_supplier);
	$row_supplier=mysql_fetch_array($result_supplier);
	$supplier_type=$row_supplier['type'];
	$supplier_master_name_id=$row['supplier_master_name_id'];
	$qry_car="select * from `carname_master` where `id`='$supplier_master_name_id'";
	$result_car = $data_base_object->execute_query_return($qry_car);
	$row_car=mysql_fetch_array($result_car);
	$car_name=$row_car['name'];
	$name_supplier=$row['name_supplier'];
	$address=$row['address'];
	$contact_name=$row['contact_name'];
	$office_no=$row['office_no'];
	$residence_no=$row['residence_no'];
	$mobile_no=$row['mobile_no'];
	$email_id=$row['email_id'];
	$fax_no=$row['fax_no'];
	$opening_bal=$row['opening_bal'];
	$closing_bal=$row['closing_bal'];
	$due_days=$row['due_days'];
	$servicetax_no=$row['servicetax_no'];
	$pan_no=$row['pan_no'];
	$account_no=$row['account_no'];
?>
  <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
<table width="100%" align="center" class="table table-bordered table-hover" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Results for <?php echo $name_supplier;?></strong></td>
    <td><!--<input type="button" onclick="javascript: window.print()" value="print"/>--></td>
  </tr>
  <tr>
    <td><strong>Supplier Type:</strong></td>
    <td width="13%"><?php echo $supplier_type;?></td>
    <td width="13%"><strong>Supplier Category:</strong></td>
    <td width="13%"><?php echo $car_name;?></td>
    <td><strong>Supplier Name :</strong></td>
    <td><?php echo $name_supplier; ?></td>
    <td><strong>Address:</strong></td>
    <td><?php echo $address;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Contact Name:</strong></td>
    <td><?php echo $contact_name;?></td>
     <td><strong>Office Number:</strong></td>
    <td><?php echo $office_no;?></td>
     <td><strong>Residence Number:</strong></td>
    <td><?php echo $residence_no;?></td>
   <td><strong>Mobile Number</strong></td>
    <td><?php echo $mobile_no;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Fax Number:</strong></td>
    <td><?php echo $fax_no;?></td>
    <td><strong>Opening Balance:</strong></td>
    <td><?php echo $opening_bal;?></td>
    <td><strong>Closing Balance:</strong></td>
    <td><?php echo $closing_bal;?></td>
     <td><strong>Due Days:</strong></td>
    <td><?php echo $due_days;?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Service Tax Number:</strong></td>
    <td><?php echo $servicetax_no;?></td>
    <td><strong>Pan Number</strong></td>
    <td><?php echo $pan_no;?></td>
    <td><strong> Bank Account Number:</strong></td>
    <td><?php echo $account_no;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="140px"></td>
    <td width="130px"></td>
    <td width="160px;">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php 
}
$data_base->close_connection();
}
?>
                 </div>
                   </div>  
                    </div>	
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