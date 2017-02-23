<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title><?php title(); ?></title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
	<?php logo(); ?>
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
                <form method="post" action="Handler.php" class="form-horizontal"> 

                <div class="portlet box yellow">
                <div class="portlet-title">
                <h4><i class="icon-inbox"></i>Add Counter</h4>
                </div>
                <div class="portlet-body form">
                
                <div class="control-group">
                <label class="control-label">Counter Name</label>
                <div class="controls">
                <input type="text" name="name"  class="span6 m-wrap"  required="required">
                </div>
                </div>  

                  <div class="form-actions">
                  <button type="submit" value="Add" class="btn green" name="counter"/><i class="icon-user"></i> Submit</button>
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