<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `supplier_tariff` where `id`='".$idd."'";
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
    	<form name="form_name" class="form-horizontal" action="Handler.php" method="post">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Supplier Tariff Edit</h4>
        </div>
        <div class="portlet-body form">
        
        <div class="control-group">
        <label class="control-label">Supplier Name</label>
        <div class="controls">
        <select name="supplier_id" class="span6 m-wrap chosen" >	
        <option value="">---select service---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from supplier_reg");
        while($row=mysql_fetch_array($result))
        {
		if($row_data['supplier_id']==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Services</label>
        <div class="controls">
        <select name="service_id" class="span6 m-wrap chosen" >	
        <option value="">---select service---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from service");
        while($row=mysql_fetch_array($result))
        {
		if($row_data['service_id']==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Car</label>
        <div class="controls">
        <select name="car_type_id" class="span6 m-wrap chosen" >	
	    <option value="">---select car---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_type");
        while($row=mysql_fetch_array($result))
        {
		if($row_data['car_type_id']==$row['id'])		
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>   
            
        <div class="control-group">
        <label class="control-label">Rate</label>
        <div class="controls">
       <input type="text" name="rate" value="<?php echo $row_data['rate']; ?>" onKeyUp="allLetter(this.value,this.id)" id="rate" class="span6 m-wrap" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Charged KM</label>
        <div class="controls">
        <input type="text" name="minimum_chg_km" value="<?php echo $row_data['minimum_chg_km']; ?>" onKeyUp="allLetter(this.value,this.id)" id="minimum_chg_km" class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Extra KM Rate</label>
        <div class="controls">
        <input type="text" name="extra_km_rate" value="<?php echo $row_data['extra_km_rate']; ?>"  onKeyUp="allLetter(this.value,this.id)" id="extra_km_rate" class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Minimum Charges Hourly</label>
        <div class="controls">
        <input type="text" name="minimum_chg_hourly" value="<?php echo $row_data['minimum_chg_hourly']; ?>"   onKeyUp="allLetter(this.value,this.id)" id="minimum_chg_hourly" class="span6 m-wrap" />
        </div>
        </div>  
        
         
        <div class="control-group">
        <label class="control-label">Extra Hour Rate</label>
        <div class="controls">
        <input type="text" name="extra_hour_rate" value="<?php echo $row_data['extra_hour_rate']; ?>"   onKeyUp="allLetter(this.value,this.id)" id="extra_hour_rate" class="span6 m-wrap" />
        </div>
        </div>  
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_supplier_tariff"/><i class="icon-question-sign"></i> Save Change</button>
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