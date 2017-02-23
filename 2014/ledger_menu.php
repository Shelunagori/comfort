<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
 if(isset($_POST['ledger_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "INSERT INTO `ledger` (`ledger_type`, `name`,`description`) VALUES
		('".$_POST['ledger_type']."','".$_POST['name']."' , '".$_POST['description']."')";
		$data_base_connect_object->execute_query_update($query, "ledger_reg");
}

if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Ledger Added SuccessFully .');
		window.location='ledger_menu.php';
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
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '5' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>        
<a href="ledger_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="ledger_menu_view.php" class="btn blue"><i class="icon-table"></i> View Ledger</a>
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
                    <h4><i class="icon-book"></i>View Ledger</h4>
                    </div>
                    <div class="portlet-body form">
                <table width="100%">
              	<tr><td>Ledger Type:</td><td>
				<select name="ledger_type" class="m-wrap medium">	
				<option>Customer</option>
				<option>Supplier</option>
				<option>Employee</option>
				<option>Car</option>
				<option>Ledger</option>
				</select>
				</td></tr>
				<tr><td> Name:</td><td><input type="text" name="name" class="m-wrap medium" /></td></tr>
              	<tr><td> Description:</td><td><input type="text" name="description" class="m-wrap medium"  /> </td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table> 
                  <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:20%" class="btn green" name="ledger_reg"/><i class="icon-ok"></i> Add</button>
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