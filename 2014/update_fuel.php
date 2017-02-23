<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
if(isset($_POST['fuel_update_info']))
{
	$data_base_connect_object =new DataBaseConnect();
	$id=$_POST['id'];
	
	$fuel_qty=floatval($_POST['fuel_amount']/$_POST['price']);
	
	$query = "update `fuel` set `opening_km`='".$_POST['opening_km']."' , `closing_km`='".$_POST['closing_km']."' ,  `fuel_qty`='".$fuel_qty."',
	  `fuel_amount`='".$_POST['fuel_amount']."' ,`fuel_type`='".$_POST['fuel_type']."', `remarks`='".$_POST['remarks']."' , `fuel_rate`='".$_POST['price']."' where id=".$id; 	
		$data_base_connect_object->execute_query_update($query,"fuel_update");		
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Fuel Entry Updated SuccessFully .');
		window.close();
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
<script>
function my_reading()
{
 var op_km=eval(document.getElementById("opening_km").value);
 var cl_km=eval(document.getElementById("closing_km").value);
if(op_km>cl_km)
{
alert("Closing KM. must be greater than Opening KM.");	
document.getElementById("closing_km").value='';}
}
</script>
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
    <?php ajax(); ?>
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-edit"></i>Fuel Update</h4>
        </div>
        <div class="portlet-body form">
        <?php
				if(isset($_GET['id']))
				{
					$id= $_GET['id'];
                  	$qry="select * from `fuel` where id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$supplier_name=$row['supplier_name'];
							$date=$row['date'];
							$car_number=$row['car_number'];
							$opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $fuel_qty=$row['fuel_qty'];
                            $fuel_amount=$row['fuel_amount'];
    						$remarks=$row['remarks'];
	
                        }
                 ?>
                <form  name="form_name" method="post">
                <table width="100%">
              	<tr><td> Supplier Name:</td><td><input value="<?php echo $supplier_name ;?>"  type="text" readonly="readonly" class="m-wrap medium"/></td></tr>
              	<tr><td> Date:</td><td><input type="text" value="<?php echo DisplayDate($date) ;?>" readonly="readonly" class="m-wrap medium"/></td></tr>
              	<tr><td> Car Number.:</td><td><input type="text" readonly="readonly" value="<?php echo $car_number ;?>"class="m-wrap medium" /> </td></tr>
				<tr><td> Opening KM. : </td><td><input type="text" name="opening_km" id="opening_km" class="m-wrap medium" value="<?php echo $opening_km ;?>"/> </td></tr>
				<tr><td> Closing KM. : </td><td><input type="text" name="closing_km" id="closing_km" onBlur="my_reading();" class="m-wrap medium" value="<?php echo $closing_km ;?>"/> </td></tr>
                <tr><td> Fuel Type. : </td><td>
                <select name="fuel_type" class="m-wrap medium" onChange="fetch_price(this.value);">
                <option value="">---select---</option>
                <option value="Petrol" <?php if($row['fuel_type']=="Petrol") { ?> selected <?php } ?> >Petrol</option>
                <option value="Diesel" <?php if($row['fuel_type']=="Diesel") { ?> selected <?php } ?> >Diesel</option>
                </select><div id="price_here"></div>
                </td></tr>
				<tr><td> Fuel Amount : </td><td><input type="text" name="fuel_amount" class="m-wrap medium" value="<?php echo $fuel_amount ;?>"/> </td></tr>
                <tr><td> Remarks : </td><td><textarea type="text" rows="2"  class="m-wrap medium" name="remarks" ><?php echo $remarks; ?></textarea></td></tr>
                </table>
                <div class="form-actions">
                <button type="submit" style="margin-left:25%" class="btn green" name="fuel_update_info"><i class="icon-ok"></i> Submit</button>
                </div> 
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                </form>
                <?php }?>
        </div>
        </div>
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