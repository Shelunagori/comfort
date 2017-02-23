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
                <form method="post" action="Handler.php" class="form-horizontal" enctype="multipart/form-data"> 

                <div class="portlet box yellow">
                <div class="portlet-title">
                <h4><i class="icon-inbox"></i>TAX & FUEL Rate</h4>
                </div>
                <div class="portlet-body form">
                <?php
				$i=0;
				$result=mysql_query("select * from taxation");
				while($row_data=mysql_fetch_array($result))
				{$i++;
				?>
                <div class="control-group">
                <label class="control-label"><?php echo $row_data['name']; ?></label>
                <div class="controls">
                <input type="text" name="rate<?php echo $i; ?>" id="rate<?php echo $i; ?>" onKeyUp="allLetter(this.value,this.id)" class="span6 m-wrap" value="<?php echo $row_data['rate']; ?>" required="required">
                </div>
                </div>
                <input type="hidden" name="idd<?php echo $i; ?>" value="<?php echo $row_data['id']; ?>" />
            <?php 
				}
				?>
              	<input type="hidden" name="count" value="<?php echo $i; ?>" />
              <div class="form-actions">
              <button type="submit" value="Add" class="btn green" name="tax_rate"/><i class="icon-question-sign"></i> Save Change</button>
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
</html>s