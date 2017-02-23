<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
 if(isset($_POST['supplier_tariff_update']))
{
	$id=$_POST['id']; 
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "update supplier_tariff set `supplier_reg_name`='".$_POST['supplier_reg_name']."' , carname_master_id='".$_POST['carname_master_id']."' ,service_service_id='".$_POST['service_service_id']."', rate='".$_POST['rate']."' ,
	minimum_chg_km='".$_POST['minimum_chg_km']."' , extra_km_rate='".$_POST['extra_km_rate']."' , minimum_chg_hourly='".$_POST['minimum_chg_hourly']."' , extra_hour_rate='".$_POST['extra_hour_rate']."'  where supplier_tariff_id='".$id."'";
	$data_base_connect_object->execute_query_update($query,"supplier_tariff_update");
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
      <?php  navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post">
<div>                     
<a href="supplier_tariff_rate_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="supplier_tariff_rate_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="supplier_tariff_rate_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> 
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Update</h4>
                     </div>
                     <div class="portlet-body form">
                     
                     <?php
				if(isset($_GET['id']))
				{
					$id= $_GET['id'];
                  	$qry="select * from `supplier_tariff` where `supplier_tariff_id`=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
							$supplier_tariff_id=$row['supplier_tariff_id'];
							$supplier_reg_name=$row['supplier_reg_name'];                      	
                        	$carname_master_id=$row['carname_master_id'];
                        	$service_service_id=$row['service_service_id'];
                        	$rate = $row['rate'];
                        	$minimum_chg_km = $row['minimum_chg_km'];
							$extra_km_rate = $row['extra_km_rate'];
							$minimum_chg_hourly = $row['minimum_chg_hourly'];
							$extra_hour_rate = $row['extra_hour_rate'];
                        }
                 ?>
                <table width="100%">
		        <tr><td> Supplier Name:</td><td>
				<select name="supplier_reg_name" class="span5 chosen" style="width:221px">	
				<?php 
					$mydatabase=new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `supplier_reg`");
						while($row=mysql_fetch_array($result))
						{
							if($row['supplier_id']==$supplier_reg_name)
								echo "<option value=\"".$row['supplier_id']."\" selected=\"selected\">".$row['name_supplier']."</option>";
							else 
								echo "<option value=\"".$row['supplier_id']."\">".$row['name_supplier']."</option>";
						}
				?>
				</select>
				</td></tr>
              	<tr><td> Car:</td><td>
              	<select name="carname_master_id" class="span5 chosen" style="width:221px">	
				<?php 
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							if($row['id']==$carname_master_id)
								echo "<option value=\"".$row['id']."\" selected=\"selected\">".$row['name']."</option>";
								else 
								echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
              	</td></tr>
              	<tr><td> Service:</td><td>
              	<select name="service_service_id" class="span5 chosen" style="width:221px">	
				<?php 
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							if($row['service_id']==$service_service_id)
								echo "<option value=\"".$row['service_id']."\" selected=\"selected\">".$row['name']."</option>";
							else 
								echo "<option value=\"".$row['service_id']."\">".$row['name']."</option>";	
						}
						$mydatabase->close_connection();
				?>
				</select>
              	</td></tr>
              	<tr><td> Rate:</td><td><input type="text" class="m-wrap medium" name="rate" value="<?php echo $rate;?>"/></td></tr>
              	<tr><td> Charged KM:</td><td><input type="text" class="m-wrap medium" name="minimum_chg_km" value="<?php echo $minimum_chg_km;?>"/></td></tr>
              	<tr><td> Extra KM Rate:</td><td><input type="text" class="m-wrap medium" name="extra_km_rate" value="<?php echo $extra_km_rate;?>"/></td></tr>
              	<tr><td> Minimum Charges Hourly:</td><td><input type="text" class="m-wrap medium" name="minimum_chg_hourly" value="<?php echo $minimum_chg_hourly;?>"/></td></tr>
              	<tr><td> Extra Hour Rate:</td><td><input type="text" name="extra_hour_rate" class="m-wrap medium" value="<?php echo $extra_hour_rate;?>"/></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                  <div class="form-actions">
                   <button type="submit" style="margin-left:30%"  class="btn green" name="supplier_tariff_update"/><i class="icon-question-sign"></i> Save Change</button>
                   </div>
                   </div></div>
                      <?php }?>
                     
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