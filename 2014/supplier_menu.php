<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['supplier_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into supplier_reg(supplier_master_id,supplier_master_name_id,name_supplier,address,contact_name,office_no,residence_no,mobile_no,email_id,fax_no,opening_bal,closing_bal,due_days,servicetax_no,pan_no,account_no)
	values('".$_POST['supplier_master_id']."','".$_POST['supplier_master_name_id']."','".$_POST['name_supplier']."'
	,'".$_POST['address']."','".$_POST['contact_name']."'
	,'".$_POST['office_no']."','".$_POST['residence_no']."','".$_POST['mobile_no']."'
	,'".$_POST['email_id']."','".$_POST['fax_no']."','".$_POST['opening_bal']."'
	,'".$_POST['closing_bal']."','".$_POST['due_days']."','".$_POST['servicetax_no']."'
	,'".$_POST['pan_no']."','".$_POST['account_no']."')";	
	$data_base_connect_object->execute_query_update($query,"supplier_reg",$_POST['name_supplier']);
	
	$sql_suply_id="select `supplier_id` from `supplier_reg` where `name_supplier` = '".$_POST['name_supplier']."'  ORDER BY `supplier_id` DESC LIMIT 1";
	$result_for_id = $data_base_connect_object->execute_query_return($sql_suply_id);
	$row_sel=mysql_fetch_array($result_for_id);
	$id_supplier=$row_sel['supplier_id'];
	
	   if(!empty($_POST['supplier_reg_name']))
	   {
		$sql_query="select * from supplier_tariff where supplier_reg_name = '".$_POST['supplier_reg_name']."' ";
		$result= $data_base_connect_object->execute_query_return($sql_query);
		while($row=mysql_fetch_array($result))
		{
		$carname_master_id = $row['carname_master_id'];
		$service_service_id = $row['service_service_id'];
		$rate = $row['rate'];
		$minimum_chg_km = $row['minimum_chg_km'];
		$extra_km_rate = $row['extra_km_rate'];
		$minimum_chg_hourly = $row['minimum_chg_hourly'];
		$extra_hour_rate = $row['extra_hour_rate'];
		
		$cust_query="insert into `supplier_tariff`(`supplier_reg_name`,`carname_master_id`,`service_service_id`,`rate`,`minimum_chg_km`,`extra_km_rate`,`minimum_chg_hourly`,`extra_hour_rate`)
		values('".$id_supplier."','".$carname_master_id."','".$service_service_id."','".$rate."',
		'".$minimum_chg_km."','".$extra_km_rate."','".$minimum_chg_hourly."','".$extra_hour_rate."'
		)";
		$data_base_connect_object->execute_query_operation($cust_query);
		}
	    }
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Supplier Added SuccessFully .');
		window.location='supplier_menu.php';
	</script>";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Supplier Deleted SuccessFully .');
		window.location='supplier_menu_delete.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Supplier Infomation Updated Successfully.');
		window.location='supplier_menu.php';
	</script>";
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
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post"  name="form_name">
<div>  
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '2' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{
		?>               
<a href="supplier_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($edit_status==1)
	{
		?>
<a href="supplier_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="supplier_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="supplier_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                        <h4><i class="icon-comments"></i>Add Supplier</h4>
                     </div>
                     <div class="portlet-body form">
                    <table width="100%">
              	<tr><td> Supplier Type:</td><td>
				<select name="supplier_master_id" id="car_name_id" onchange="fillMe()" class="m-wrap medium">
				<option value="">Select</option>	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from supplier_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['type'].'</option>';
						}
				?>
				</select>
				</td></tr>
              	<tr><td> Supplier Category:</td>
              	<td id="will_be">
              	
              	</td></tr>
              	<tr><td> Supplier Name:</td><td><input type="text" name="name_supplier" class="m-wrap medium"/></td></tr>
				<tr><td> Address. : </td><td>
					<textarea rows="2" cols="28" name="address" class="m-wrap medium" style="resize:none;"> </textarea>
				</td></tr>
				<tr><td> Contact Name. : </td><td><input type="text" name="contact_name" class="m-wrap medium" /> </td></tr>
				<tr><td> Office Number: </td><td><input type="text" name="office_no" class="m-wrap medium"/> </td></tr>
				<tr><td> Residence Number : </td><td><input type="text" name="residence_no" class="m-wrap medium" /> </td></tr>
				<tr><td> Mobile Number: </td><td><input type="text" name="mobile_no" class="m-wrap medium" /> </td></tr>
				<tr><td> Email Id: </td><td><input type="text" name="email_id"  class="m-wrap medium"/> </td></tr>
				<tr><td> Fax Number: </td><td><input type="text" name="fax_no" class="m-wrap medium" /> </td></tr>
				<tr><td> Opening Balance: </td><td><input type="text" name="opening_bal"  class="m-wrap medium"/> </td></tr>
				<tr><td> Closing Balance: </td><td><input type="text" name="closing_bal"  class="m-wrap medium"/> </td></tr>
				<tr><td> Due Days: </td><td><input type="text" name="due_days"  class="m-wrap medium"/> </td></tr>
				<tr><td> Service Tax Number: </td><td> <input type="text" name="servicetax_no" class="m-wrap medium" /></td></tr>
				<tr><td> Pan Number: </td><td> <input type="text" name="pan_no" class="m-wrap medium" /></td></tr>
				<tr><td>Bank Account Number: </td><td> <input type="text" name="account_no" class="m-wrap medium"/></td></tr>
                <tr><td>Copy Tariff Rate From: </td><td><select name="supplier_reg_name" class="chosen">	
				<option value="">--- Supplier Name ---</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `supplier_reg`");
						while($row=mysql_fetch_array($result))
						{
							  echo '<option value="'.$row['supplier_id'].'">'.$row['name_supplier'].'</option>';
						}
				?>
				</select></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                     <div class="form-actions">
                     <button type="submit" style="margin-left:33%"   class="btn green" name="supplier_reg"/><i class="icon-ok"></i> Add</button>
                     </div>
                     </div>
                     </div> 
                         <?php
	}
	?>
 		
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