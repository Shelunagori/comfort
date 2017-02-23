<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
 if(isset($_POST['service_delete']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from service where service_id='".$_POST['name']."'";
	$data_base_connect_object->execute_query_update($query,"service_delete");
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
<!--<div>                     
<a href="service_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="service_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="service_menu_delete.php" class="btn red"><i class="icon-trash"></i> Delete</a>
<a href="service_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-cogs"></i>Service Delete</h4>
                    </div>
                    <div class="portlet-body form">
                    <br />
                      <table width="100%">
						<tr><td> Service To Delete : </td><td>
						<select name="name" class="span5 chosen" >
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=\"".$row['service_id']."\">".$row['name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
						</td></tr>
						<tr><td></td><td>&nbsp;</td></tr>
						 </table>
                         
                         <div class="form-actions">
                           <button  type="submit"   class="btn green" style="margin-left:15%" name="service_delete" ><i class="icon-trash"></i> Delete Service</button>
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