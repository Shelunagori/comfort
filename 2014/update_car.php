<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
if(isset($_POST['car_update_info']))
{
	$id=$_POST['id']; 
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "update `car_reg` set `carname_master_id`='".$_POST['carname_master_id']."' , `name`='".$_POST['name']."' , `supplier_reg_name`='".$_POST['supplier_reg_name']."', 
	`engine_no`='".$_POST['engine_no']."' , `chasis_no`='".$_POST['chasis_no']."' , `rto_tax_date`='".DateExact($_POST['rto_tax_date'])."' , `insurance_date_from`='".DateExact($_POST['insurance_date_from'])."' , `insurance_date_to`='".DateExact($_POST['insurance_date_to'])."'
	, `authorization_date`='".DateExact($_POST['authorization_date'])."' 
	, `permit_date`='".DateExact($_POST['permit_date'])."' 
	, `fitness_date`='".DateExact($_POST['fitness_date'])."' 
	, `puc_date`='".DateExact($_POST['puc_date'])."' 
	where `car_id`=".$id;
	$data_base_connect_object->execute_query_update($query,"car_update");
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
<!--<div>                     
<a href="customer_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="customer_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="customer_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
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
                  	$qry="select * from car_reg where car_id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
							$carname_master_id=$row['carname_master_id'];
							$name=$row['name'];                      	
                        	$supplier_reg_name=$row['supplier_reg_name'];
							$engine_no=$row['engine_no'];
							$chasis_no=$row['chasis_no'];
							$rto_tax_date=$row['rto_tax_date'];
							$insurance_date_from=$row['insurance_date_from'];
                            $insurance_date_to=$row['insurance_date_to'];
                            $authorization_date=$row['authorization_date'];
                            $permit_date=$row['permit_date'];
                            $fitness_date=$row['fitness_date'];
                            $puc_date=$row['puc_date'];
                            
                        }
                        $data_base_object->close_connection();
                 ?>
                <table width="100%" >
              	<tr><td> Car:</td><td>
				<select name="carname_master_id" class="span5 chosen" style="width:221px !important">	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							if($carname_master_id==$row['id'])	
								echo "<option selected=\"selected\" value=\"".$row['id']."\" >".$row['name']."</option>";
							else 
								echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
						}
				?>
				</select>
				</td></tr>
				<tr><td> Vehicle Number:</td><td><input type="text" class="m-wrap medium" name="name" value="<?php echo $name;?>"/></td></tr>
              	<tr><td> Supplier Name:</td><td>
              	<select name="supplier_reg_name" class="span5 chosen" style="width:221px !important">	
				<?php 
						$result= $mydatabase->execute_query_return("select name_supplier from supplier_reg");
						while($row=mysql_fetch_array($result))
						{
							if($supplier_reg_name==$row['name_supplier'])	
								echo "<option selected=\"selected\">".$row['name_supplier']."</option>";
							else 
								echo "<option>".$row['name_supplier']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
              	</td></tr>
              	<tr><td> Engine Number:</td><td><input type="text" class="m-wrap medium" name="engine_no" value="<?php echo $engine_no;?>"/> </td></tr>
				<tr><td> Chasis Number : </td><td><input type="text" class="m-wrap medium" name="chasis_no" value="<?php echo $chasis_no;?>"/> </td></tr>
				<tr><td> RTO Tax Date: </td><td><input id="dp6" class="m-wrap medium" type="text" name="rto_tax_date" value="<?php echo $rto_tax_date;?>"/> </td></tr>
				<tr><td> Insurance Statting Date: </td><td><input id="dp1" class="m-wrap medium" type="text" name="insurance_date_from" value="<?php echo $insurance_date_from;?>"/> </td></tr>
				<tr><td> Insurance Ending Date: </td><td><input id="dp2" class="m-wrap medium" type="text" name="insurance_date_to" value="<?php echo $insurance_date_to;?>"/> </td></tr>
				<tr><td> Authorization Detail Date: </td><td><input id="dp3" class="m-wrap medium" type="text" name="authorization_date" value="<?php echo $authorization_date;?>"/> </td></tr>
				<tr><td> Permit Date: </td><td><input id="dp4" class="m-wrap medium" type="text" name="permit_date" value="<?php echo $permit_date;?>"/> </td></tr>
				<tr><td> Fitness Date: </td><td><input id="dp7" class="m-wrap medium" type="text" name="fitness_date" value="<?php echo $fitness_date;?>"/> </td></tr>
				<tr><td> PUC Date: </td><td><input id="dp5" class="m-wrap medium" type="text" name="puc_date" value="<?php echo $puc_date;?>"/> </td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
               <input type="hidden" value="<?php echo $id;?>" name="id" />
                  <?php }?>
                   <div class="form-actions">
                   <button type="submit" style="margin-left:30%"  class="btn green" name="car_update_info"/><i class="icon-question-sign"></i> Save Change</button>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>