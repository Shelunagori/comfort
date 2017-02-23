<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['car_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into car_reg(carname_master_id,name,supplier_reg_name,engine_no,chasis_no,rto_tax_date,insurance_date_from,insurance_date_to,authorization_date,permit_date,fitness_date,puc_date)
	values('".$_POST['carname_master_id']."','".$_POST['name']."','".$_POST['supplier_reg_name']."'
	,'".$_POST['engine_no']."','".$_POST['chasis_no']."'
	,'".DateExact($_POST['rto_tax_date'])."','".DateExact($_POST['insurance_date_from'])."','".DateExact($_POST['insurance_date_to'])."'
	,'".DateExact($_POST['authorization_date'])."','".DateExact($_POST['permit_date'])."','".DateExact($_POST['fitness_date'])."'
	,'".DateExact($_POST['puc_date'])."'
	)";	
	$data_base_connect_object->execute_query_update($query,"car_reg",$_POST['name']);
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Car Added SuccessFully .');
		window.location='car_menu.php';
	</script>
	";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Car Information Deleted SuccessFully .');
		window.location='car_menu_delete.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Car Infomation Updated Successfully.');
		window.location='car_menu.php';
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
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '3' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>                      
<a href="car_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($edit_status==1)
	{
		?>
<a href="car_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="car_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="car_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                    <h4><i class="icon-plane"></i>Car</h4>
                    </div>
                    <div class="portlet-body form">
                      <table width="100%">
              	<tr><td> Car:</td><td>
				<select name="carname_master_id" class="span5 chosen" style="width:221px;">	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
				?>
				</select>
				</td></tr>
				<tr><td> Vehicle Number:</td><td><input type="text" class="m-wrap medium" name="name" /></td></tr>
              	<tr><td> Supplier Name:</td><td>
              	<select name="supplier_reg_name" class="span5 chosen" style="width:221px;">	
				<?php 
						$result= $mydatabase->execute_query_return("select DISTINCT name_supplier from supplier_reg");
						while($row=mysql_fetch_array($result))
						{
							echo "<option>".$row['name_supplier']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
              	</td></tr>
              	<tr><td> Engine Number:</td><td><input type="text" class="m-wrap medium" name="engine_no" /> </td></tr>
				<tr><td> Chasis Number : </td><td><input type="text" class="m-wrap medium" name="chasis_no" /> </td></tr>
				<tr><td> RTO Tax Date: </td><td><input type="text" id="dp1" class="m-wrap medium" name="rto_tax_date" /> </td></tr>
				<tr><td> Insurance Statting Date: </td><td><input type="text" name="insurance_date_from" id="dp2" class="m-wrap medium"/> </td></tr>
				<tr><td> Insurance Ending Date: </td><td><input type="text" name="insurance_date_to" id="dp3" class="m-wrap medium"/> </td></tr>
				<tr><td> Authorization Detail Date: </td><td><input type="text" name="authorization_date" id="dp4" class="m-wrap medium"/> </td></tr>
				<tr><td> Permit Date: </td><td><input type="text" name="permit_date" id="dp5" class="m-wrap medium"/> </td></tr>
				<tr><td> Fitness Date: </td><td><input type="text" name="fitness_date" id="dp6" class="m-wrap medium"/> </td></tr>
				<tr><td> PUC Date: </td><td><input type="text" name="puc_date" id="dp7"  class="m-wrap medium"/> </td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                  <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:30%" class="btn green" name="car_reg"/><i class="icon-ok"></i> Add</button>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>