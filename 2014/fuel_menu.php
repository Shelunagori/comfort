<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['fuel_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	
/*	$sql_supplier="select `name_supplier` from `supplier_reg` where `supplier_id` = '".$_POST['supplier_name']."'";
	$result_for_id = $data_base_connect_object->execute_query_return($sql_supplier);
	$row_sel=mysql_fetch_array($result_for_id);
	$supplier_name=$row_sel['name_supplier'];
	
	$sql_car="select `name` from `car_reg` where `car_id` = '".$_POST['car_number']."'";
	$result_car_id = $data_base_connect_object->execute_query_return($sql_car);
	$row_sel_car=mysql_fetch_array($result_car_id);
	$car_name=$row_sel_car['name'];
	*/
	$data_base_connect_object->execute_query_operation("update `taxation` set `rate`='".$_POST['price']."' where `name`='".$_POST['fuel_type']."'");
	
	$fuel_qty=@floatval($_POST['fuel_amount']/$_POST['price']);

	$query = "insert into `fuel`(`supplier_name`,`date`,`car_number`,`opening_km`,`closing_km`,`fuel_qty`,`fuel_rate`,`fuel_amount`,`fuel_type`,`remarks`) 
	values('".$_POST['supplier_name']."','".DateExact($_POST['date'])."','".$_POST['car_number']."','".$_POST['opening_km']."' ,
	'".$_POST['closing_km']."' ,'".$fuel_qty."','".$_POST['price']."','".$_POST['fuel_amount']."','".$_POST['fuel_type']."','".$_POST['remarks']."')";
	
	$data_base_connect_object->execute_query_operation($query);
	
	$query1="insert into `ledger` set `ledger_type`='Fuel',`name`='".$_POST['supplier_name']."',`cust_supp_name`='".$_POST['fuel_type']."',`description`='".$_POST['car_number']."',`credit`='".$_POST['fuel_amount']."',`debit`='0',`date`='".DateExact($_POST['date'])."',`narration`='".$_POST['remarks']."'";
	
 $data_base_connect_object->execute_query_operation($query1);
 
   $qyery2="insert into `ledger` set `ledger_type`='Car',`name`='".$_POST['car_number']."',`credit`='0',`debit`='".$_POST['fuel_amount']."',`date`='".DateExact($_POST['date'])."',`narration`='".$_POST['remarks']."'";

	
 $data_base_connect_object->execute_query_operation($qyery2);
 
 
	echo "<script language=\"javascript\">
		alert('Fuel Entry Added SuccessFully .');
		window.location='fuel_menu.php';
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
<script type="text/javascript">
function my_reading()
{
 var op_km=eval(document.getElementById("opening_km").value);
 var cl_km=eval(document.getElementById("closing_km").value);
if(op_km>cl_km)
{
alert("Closing KM. must be greater than Opening KM.");	
document.getElementById("closing_km").value='';}
}
function ajaxFunction()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
				document.add_form.opening_km.value = ajaxRequest.responseText;
		}
	}
		//var list2 = document.add_form.carname_master_id;
		//var car_name = list2.options[list2.selectedIndex].text;
		var car_reg_name=document.add_form.car_number.value;
		ajaxRequest.open("GET", "get_teriff_rate.php?carname_master_id_fuel="+car_reg_name, true);
		ajaxRequest.send(null);
	
	//alert(service_name +" , "+car_name+" , "+customer_reg_name);
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
      <?php navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <?php ajax(); ?>
     	<div class="row-fluid">
        <form  name="add_form" method="post">
        <div>      
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '12' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>                     
<a href="fuel_menu.php" class="btn red"><i class="icon-beaker"></i> Fuel</a>
<?php
	}
	if($edit_status==1)
	{
	?>
<a href="fuel_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit Fuel</a>
<?php
	}
	?>
</div> 
<br />
<?php
	if($add_status==1)
	{
		?>
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Add Fuel Entry</h4>
        </div>
        <div class="portlet-body form">
        <table width="100%">
        <tr><td>Supplier Name:</td><td>
        <select name="supplier_name" class="chosen">	
        <option value="">--- Select ---</option>
        <?php 
        $mydatabase = new DataBaseConnect();
        $result= $mydatabase->execute_query_return("select DISTINCT `name` from `ledger` where `ledger_type`='Fuel'");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
        }
        ?>
        </select></td></tr>
        <tr><td> Date:</td><td><input type="text"  id="dp1" class="m-wrap medium" name="date"/> </td></tr>
        <tr><td> Car Number:</td><td>
        <select name="car_number" onChange="ajaxFunction();" class="chosen" id="ajaxcarname">	
        <option value="">Select Car No.</option>
        <?php 
        $mydatabase = new DataBaseConnect();
        $result= $mydatabase->execute_query_return("select `car_id`,`name` from car_reg");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
        }
        $mydatabase->close_connection();
        ?>
        </select> 
        </td></tr>
        <tr><td> Previous Reading.:</td><td><input type="text" readonly class="m-wrap medium" id="opening_km" name="opening_km" /> </td></tr>
        <tr><td> Current Reading. : </td><td><input type="text" onBlur="my_reading();" id="closing_km" class="m-wrap medium" name="closing_km" /> </td></tr>
        <tr><td> Fuel Type. : </td><td>
        <select name="fuel_type" class="m-wrap medium" onChange="fetch_price(this.value);">
         <option value="">---select---</option>
        <option value="Petrol">Petrol</option>
        <option value="Diesel">Diesel</option>
        </select><div id="price_here"></div>
        </td></tr>
     <!--   <tr><td> Fuel Quantity. : </td><td><input type="text" class="m-wrap medium" name="fuel_qty" /> </td></tr>  -->
        <tr><td> Fuel Amount. : </td><td><input type="text"  class="m-wrap medium" name="fuel_amount" /> </td></tr>
         <tr><td> Remarks : </td><td><textarea type="text" rows="2"  class="m-wrap medium" name="remarks" ></textarea> </td></tr>
        </table>
        <div class="form-actions">
        <button type="submit" style="margin-left:25%" class="btn green" name="fuel_reg"><i class="icon-ok"></i> Submit</button>
        </div> 
        </div>
        </div>
         <?php
	}
	?>
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