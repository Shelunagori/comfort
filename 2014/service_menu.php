<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['service_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into service(name) values('".$_POST['name']."')";	
	$data_base_connect_object->execute_query_update($query,"service_reg");
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Service Added SuccessFully .');
		window.location='service_menu.php';
	</script>
	";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Service Deleted SuccessFully .');
		window.location='service_menu.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Customer Infomation Updated Successfully.');
		window.location='service_menu.php';
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
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '9' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>     
<a href="service_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($edit_status==1)
	{
		?>
<a href="service_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="service_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="service_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                    <h4><i class="icon-cogs"></i>Services</h4>
                    </div>
                    <div class="portlet-body form">
                    <br />
                    <table width="100%">
                    <tr><td> Service Name:</td><td><input type="text" name="name" class="m-wrap medium" /></td></tr>
                    <tr><td></td><td>&nbsp;</td></tr>
                    </table>
                   
                   <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:15%" class="btn green" name="service_reg"/><i class="icon-ok"></i> Add</button>
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