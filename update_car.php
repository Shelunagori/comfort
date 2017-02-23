<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `car_reg` where `id`='".$idd."'";
$result=mysql_query($sql);
$row_data = mysql_fetch_array($result);
$num=mysql_num_rows($result);
if($num==0)
{
	echo "<script>alert('Entry not found in database.');window.close();</script>";
}
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
     <?php temp(); ?>
    	<form name="form_name" action="Handler.php" method="post">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Car Edit</h4>
        </div>
        <div class="portlet-body form">
         <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
       <tr>
        <td> Car:</td>
        <td><select name="car_type_id" class="m-wrap medium">	
        <option value="">---select car---</option>
        <?php 
        $result= mysql_query("select DISTINCT `name`,`id` from `car_type`");
        while($row=mysql_fetch_array($result))
        {
			if($row['id']==$row_data['car_type_id'])
            echo "<option value='".$row['id']."' selected>".$row['name']."</option>";
			else
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select></td>
        <td> Vehicle Number:</td>
        <td><input type="text" REQUIRED class="m-wrap medium" value="<?php echo $row_data['name']; ?>" name="name" /></td>
        </tr>
        <tr>
        <td>Supplier Name:</td>
        <td><select name="supplier_id" class="m-wrap medium">
        <option value="">---select supplier---</option>	
        <?php 
        $result= mysql_query("select  `name`,`id` from `supplier_reg` group by `name`");
        while($row=mysql_fetch_array($result))
        {
			if($row['id']==$row_data['supplier_id'])
            echo "<option value='".$row['id']."' selected>".$row['name']."</option>";
			else
	        echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select></td>
        <td> Engine Number:</td><td><input type="text" value="<?php echo $row_data['engine_no']; ?>" class="m-wrap medium" name="engine_no" /> </td>
        </tr>
        <tr>
        <td> Chasis Number : </td><td><input type="text"  value="<?php echo $row_data['chasis_no']; ?>" class="m-wrap medium" name="chasis_no" /> </td>
        <td> RTO Tax Date: </td><td><input type="text" value="<?php echo dateforview($row_data['rto_tax_date']); ?>" class="m-wrap medium date-picker" onClick="mydatepick();" name="rto_tax_date" /> </td></tr>
        <tr>
        <td> Insurance Statting Date: </td><td><input type="text" value="<?php echo dateforview($row_data['insurance_date_from']); ?>" name="insurance_date_from" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
        <td> Insurance Ending Date: </td><td><input type="text" value="<?php echo dateforview($row_data['insurance_date_to']); ?>" name="insurance_date_to" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
        </tr>
        <tr>
        <td> Authorization Detail Date: </td><td><input type="text" value="<?php echo dateforview($row_data['authorization_date']); ?>" name="authorization_date" onClick="mydatepick();"  class="m-wrap medium date-picker"/> </td>
        <td> Permit Date: </td><td><input type="text" name="permit_date" onClick="mydatepick();" value="<?php echo dateforview($row_data['permit_date']); ?>" class="m-wrap medium date-picker"/> </td>
        </tr>
        <tr>
        <td> Fitness Date: </td><td><input type="text" name="fitness_date" onClick="mydatepick();" value="<?php echo dateforview($row_data['fitness_date']); ?>" class="m-wrap medium date-picker"/> </td>
        <td> PUC Date: </td><td><input type="text" name="puc_date"  onClick="mydatepick();" value="<?php echo dateforview($row_data['puc_date']); ?>" class="m-wrap medium date-picker"/> </td>
        </tr>
                       
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_car"/><i class="icon-question-sign"></i> Save Change</button>
       	<button type="button"  class="btn yellow" name="reset" onClick="javascript:;window.close();"/><i class="icon-remove"></i> Close</button>
        </div>
        </div>
        </div> 
        <input type="hidden" name="myid" value="<?php echo $idd; ?>" />
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