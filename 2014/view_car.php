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
<a href="car_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="car_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="car_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="car_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div>
<br />
 <div class="portlet box yellow">
							<div class="portlet-title">
								<h4><i class="icon-search"></i>Search</h4>
							</div>
							<div class="portlet-body">
<?php
if(isset($_GET['car']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `car_reg` where `car_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$carname_master_id=$row['carname_master_id'];
	$car_all=mysql_query("select * from `carname_master` where `id` = '$carname_master_id'  ");
	$ftc_car=mysql_fetch_array($car_all);
	$name = $ftc_car['name'];
	$vehicle_no=$row['name'];
	$supplier_reg_name=$row['supplier_reg_name'];
	$engine_no=$row['engine_no'];
	$chasis_no=$row['chasis_no'];
	$rto_tax_date=$row['rto_tax_date'];
	$insurance_date_from=$row['insurance_date_from'];
	$insurance_date_to=$row['insurance_date_to'];
	$authorization_date=$row['authorization_date'];
	$permit_date=$row['permit_date'];
	$fitness_date=$row['fitness_date'];
	$puc_date=$row['puc_date'];
?>
 <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
<table width="100%" align="center" class="table table-bordered table-hover" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Results for <?php echo $carname_master_id;?></strong></td>
    <td></td>
  </tr>
  <tr>
    <td><strong>Name:</strong></td>
    <td><?php echo $name;?></td>
    <td><strong>Number:</strong></td>
    <td><?php echo $vehicle_no;?></td>
    <td><strong>Supplier Name:</strong></td>
    <td><?php echo $supplier_reg_name; ?></td>
     <td><strong>Engine Number:</strong></td>
    <td><?php echo $engine_no;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
   
    <td><strong>Chasis Number:</strong></td>
    <td><?php echo $chasis_no;?></td>
     <td><strong>RTO Tax Date:</strong></td>
    <td><?php echo $rto_tax_date;?></td>
     <td><strong>Insurance Starting Date:</strong></td>
    <td><?php echo $insurance_date_from;?></td>
    <td><strong>Insurance Ending Date: </strong></td>
    <td><?php echo $insurance_date_to;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Authorization Date: </strong></td>
    <td><?php echo $authorization_date;?></td>
    <td><strong>Permit Date: </strong></td>
    <td><?php echo $permit_date;?></td>
     <td><strong>Fitness Date: </strong></td>
    <td><?php echo $fitness_date;?></td>
     <td><strong>PUC Date: </strong></td>
    <td><?php echo $puc_date;?></td>
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
</div>
<?php 
}
$data_base->close_connection();
}
?>
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