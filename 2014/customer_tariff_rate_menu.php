<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['customer_tariff_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into `customer_tariff`(`customer_reg_name`,`carname_master_id`,`service_service_id`,`rate`,`minimum_chg_km`,`extra_km_rate`,`minimum_chg_hourly`,`extra_hour_rate`)
	values('".$_POST['customer_reg_name']."','".$_POST['carname_master_id']."','".$_POST['service_service_id']."','".$_POST['rate']."',
	'".$_POST['minimum_chg_km']."','".$_POST['extra_km_rate']."','".$_POST['minimum_chg_hourly']."','".$_POST['extra_hour_rate']."'
	)";	
	$data_base_connect_object->execute_query_update($query,"customer_tariff_reg");
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('Customer Rate Added SuccessFully .');
		window.location='customer_tariff_rate_menu.php';
	</script>
	";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Supplier Deleted SuccessFully .');
		window.location='customer_tariff_rate_menu.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Customer Infomation Updated Successfully.');
		window.location='customer_tariff_rate_menu.php';
	</script>
	";
}
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
     <form method="post" name="form_name">
<div>  
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '10' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>    
<a href="customer_tariff_rate_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>     
<?php
	}
	if($edit_status==1)
	{
		?>              
<a href="customer_tariff_rate_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="customer_tariff_rate_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="customer_tariff_rate_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
<?php
	}
?>
</div> 
<br />
<?php
	if($add_status==1)
	{
		?>
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-ok"></i>Add</h4>
                    </div>
                    <div class="portlet-body form">
                    <table width="100%">
              	<tr><td> Customer Name:</td><td>
				<select name="customer_reg_name"  class="chosen">	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from customer_reg");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
				?>
				</select>
				</td></tr>
              	<tr><td>Car:</td><td>
              	<select name="carname_master_id"  class="chosen">	
				<?php 
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
				?>
				</select>
              	</td></tr>
              	<tr><td> Service:</td><td>
              <select name="service_service_id" class="chosen" >	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							  echo '<option value="'.$row['service_id'].'">'.$row['name'].'</option>';
						}
				?>
				</select>
              	</td></tr>
              	<tr><td> Rate:</td><td><input type="text" name="rate"  class="m-wrap medium"/></td></tr>
              	<tr><td> Charged KM:</td><td><input type="text" name="minimum_chg_km" class="m-wrap medium" /></td></tr>
              	<tr><td> Extra KM Rate:</td><td><input type="text" name="extra_km_rate" class="m-wrap medium" /></td></tr>
              	<tr><td> Minimum Charges Hourly:</td><td><input type="text" name="minimum_chg_hourly" class="m-wrap medium" /></td></tr>
              	<tr><td> Extra Hour Rate:</td><td><input type="text" name="extra_hour_rate"  class="m-wrap medium"/></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                            <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:30%" class="btn green" name="customer_tariff_reg"/><i class="icon-ok"></i> Submit</button>
                     </div>
                     
                     </div>
                     </div> 
 		   	  <?php
	}
	?>
        </form>
        </div>   </div>   </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>