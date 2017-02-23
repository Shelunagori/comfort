<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
if(isset($_POST['counter']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into counter(counter_name) values('".$_POST['countername']."')";	
	$data_base_connect_object->execute_query_operation($query);
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
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class=" icon-shopping-cart"></i>Counter</h4>
                    </div>
                    <div class="portlet-body form">
                    <br />

                 <table width="100%" cellpadding="0" cellspacing="0">
              	<tr><td align="center">Counter Name:</td>
                <td>
                <input type="text" name="countername" class="m-wrap medium" required="required">
				</td></tr>
				
                </table>
                <br>

                  <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:16%" class="btn green" name="counter"/><i class="icon-user"></i> Add Counter</button>
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