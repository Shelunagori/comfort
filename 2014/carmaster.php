<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['carmasterreg']))
{
	$data_base_connect_object =new DataBaseConnect();
	$query = "insert into `carname_master`(`name`,`night_hault_charges`) values('".$_POST['name']."','".$_POST['night_hault_charges']."')"; 	
	$data_base_connect_object->execute_query_update($query,"carnamemaster");		
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Car Added SuccessFully .');
		window.location='carmaster.php';
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
<br />
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '6' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>     
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-tint"></i>Car</h4>
                    </div>
                    <div class="portlet-body form">
                      <table width="100%">
              	<tr><td> Car Name:</td><td>
				<input type="text" name="name"  class="m-wrap medium"/>
				</td></tr>
				<tr><td> Night Hault Charges:</td><td><input type="text" class="m-wrap medium" name="night_hault_charges" /></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                     <div class="form-actions">
                     <button type="submit" style="margin-left:25%" class="btn green" name="carmasterreg"><i class="icon-ok"></i> Submit</button>
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