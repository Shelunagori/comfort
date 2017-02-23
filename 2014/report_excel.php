<?php 
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("function.php");
require_once ("config.php");
require_once("auth.php");
if(isset($_POST['submit']))
{
    $date_from=DateExact($_POST['date_from']);	
	$date_to=DateExact($_POST['date_to']);
	$cust_name=$_POST['cust_name'];
	echo "<script>
	location='report_excel.php';
	window.open('excel.php?date_from=$date_from&date_to=$date_to&cust_name=$cust_name','_newtab');
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
		<form method="post">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-table-th"></i>Excel Report</h4>
        </div>
        <div class="portlet-body form">
        <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
        <td>Enter Date</td>
        <td><input type="text" name="date_from" placeholder="Start Date" class="m-wrap medium" id="dp1"> <input type="text"  placeholder="End Date" name="date_to" class="m-wrap medium" id="dp2"></td>
        <td>Customer Name</td>
        <td>
        <select name="cust_name"  class="chosen" tabindex="1"  >
        <option value="" >--select customer name--</option>
        <?php
        $result=mysql_query("select distinct `name`,`id` from customer_reg");
        while($row= mysql_fetch_array($result))
        {
        $name = $row['name'];
        echo '<option value="'.$row['id'].'">'.$name.'</option>';
        }
        ?>
        </select>
        </td>
        </tr>
         <tr>
        <td colspan="4" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" style="text-align:center"><button type="submit" class="btn green" name="submit"><i class="icon-download-alt"></i> Download</button></td>
        </tr>
        </table>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>