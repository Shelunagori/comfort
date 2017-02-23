<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
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
     <form method="post" action="dutyslip_printpreview.php">
<!--<div>                     
<a href="dutyslip_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="dutyslip_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="dutyslip_menu_edit_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
<a href="dutyslip_menu_waveoff.php" class="btn blue"><i class="icon-bar-chart"></i> Waveoff</a>
<a href="dutyslip_menu_print.php" class="btn red"><i class="icon-print"></i> Print</a>
</div> -->
 <br />
     <table width="100%" align="center" >
     <tr>
     <td width="20%">
      <input type="text" name="dsid" value="<?php echo $_GET['ds_id']; ?>" class="m-wrap medium" placeholder="Enter Duty Slip ID">
     </td>
     <td >&nbsp;</td>
     </tr>
     <tr>
     <td>
     <input type="text" name="find_dutyslip" class="m-wrap medium" value="2" placeholder="Howmany Copies ?">
     </td>
     <td>
     <button type="submit" style="margin-top:-1.5% !important"  class="btn green" name="generate">Go <i class="icon-circle-arrow-right"></i></button>
     </td>
    </tr>
     </table>
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