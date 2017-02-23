<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_POST['supplier_update_info']))
{
	$id=$_POST['id']; 
	$data_base_connect_object =new DataBaseConnect(); 
	$qry="select * from supplier_reg where supplier_id=".$id;
	$result= $data_base_connect_object->execute_query_return($qry);
	$row=mysql_fetch_array($result);
	$name_supplier=$row['name_supplier'];		
	$query = "update supplier_reg set supplier_master_id='".$_POST['supplier_master_id']."', supplier_master_name_id='".$_POST['supplier_master_name_id']."' , name_supplier='".$_POST['name_supplier']."' , 
	 address='".trim($_POST['address'])."' , contact_name='".$_POST['contact_name']."' , office_no='".$_POST['office_no']."' , residence_no='".$_POST['residence_no']."'
	,mobile_no='".$_POST['mobile_no']."' , email_id='".$_POST['email_id']."' , fax_no='".$_POST['fax_no']."' , opening_bal='".$_POST['opening_bal']."' ,
	closing_bal='".$_POST['closing_bal']."' , due_days='".$_POST['due_days']."' , servicetax_no='".$_POST['servicetax_no']."'
	,pan_no='".$_POST['pan_no']."', account_no='".$_POST['account_no']."'
	 where supplier_id=".$id."";
	 
    $query_ledger = "update ledger set name='".$_POST['name_supplier']."' where name='".$name_supplier."' && `ledger_type`='Supplier'";
	$data_base_connect_object->execute_query_operation($query_ledger); 	
	$data_base_connect_object->execute_query_update($query,"supplier_update");
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
<a href="supplier_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="supplier_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="supplier_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                  	$qry="select * from supplier_reg where supplier_id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
							$supplier_master_id=$row['supplier_master_id'];
							$supplier_master_name_id=$row['supplier_master_name_id'];                      	
                        	$idd=$row['supplier_id'];
							$name_supplier=$row['name_supplier'];
							$address=$row['address'];
							$contact_name=$row['contact_name'];
							$office_number=$row['office_no'];
                            $residence_no=$row['residence_no'];
                            $mobile_no=$row['mobile_no'];
                            $email_id=$row['email_id'];
                            $fax_no=$row['fax_no'];
                            $opening_bal=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
                            $due_days=$row['due_days'];
                            $servicetax_no=$row['servicetax_no'];
                            $pan_no=$row['pan_no'];
                            $account_no=$row['account_no'];
                        }
                        $data_base_object->close_connection();
                 ?>
                <table width="100%">
		        <tr><td> Supplier Type:</td><td>
				<select name="supplier_master_id" class="m-wrap medium">	
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select type from supplier_master");
						while($row=mysql_fetch_array($result))
						{
							if($supplier_master_id==$row['type'])
								echo "<option selected=\"selected\">".$row['type']."</option>";
							else 
								echo "<option>".$row['type']."</option>";
						}
				?>
				</select>
				</td></tr>
              	<tr><td> Supplier Category:</td><td>
              	<select name="supplier_master_name_id" class="m-wrap medium">	
				<?php 
						$result= $mydatabase->execute_query_return("select name from supplier_master_type");
						while($row=mysql_fetch_array($result))
						{
							if($supplier_master_name_id==$row['name'])
								echo "<option selected=\"selected\">".$row['name']."</option>";
							else 
								echo "<option>".$row['name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
              	</td></tr>
              	<tr><td> Supplier Name:</td><td><input type="text" class="m-wrap medium" name="name_supplier" value="<?php echo $name_supplier; ?>" /></td></tr>
				<tr><td> Address. : </td><td>
					<textarea rows="3" cols="28" name="address" class="m-wrap medium" > 
					<?php echo $address; ?>
					</textarea>
				</td></tr>
				<tr><td> Contact Name. : </td><td><input type="text" class="m-wrap medium" name="contact_name" value="<?php echo $contact_name; ?>"/> </td></tr>
				<tr><td> Office Number: </td><td><input type="text" class="m-wrap medium" name="office_no" value="<?php echo $office_number; ?>"/> </td></tr>
				<tr><td> Residence Number : </td><td><input type="text" class="m-wrap medium" name="residence_no" value="<?php echo $residence_no; ?>"/> </td></tr>
				<tr><td> Mobile Number: </td><td><input type="text" class="m-wrap medium" name="mobile_no" value="<?php echo $mobile_no; ?>"/> </td></tr>
				<tr><td> Email Id: </td><td><input type="text" class="m-wrap medium" name="email_id" value="<?php echo $email_id; ?>"/> </td></tr>
				<tr><td> Fax Number: </td><td><input type="text" class="m-wrap medium" name="fax_no" value="<?php echo $fax_no; ?>"/> </td></tr>
				<tr><td> Opening Balance: </td><td><input type="text" class="m-wrap medium" name="opening_bal" value="<?php echo $opening_bal; ?>"/> </td></tr>
				<tr><td> Closing Balance: </td><td><input type="text" class="m-wrap medium" name="closing_bal" value="<?php echo $closing_bal; ?>"/> </td></tr>
				<tr><td> Due Days: </td><td><input type="text" class="m-wrap medium" name="due_days" value="<?php echo $due_days; ?>"/> </td></tr>
				<tr><td> Service Tax Number: </td><td> <input type="text" class="m-wrap medium" name="servicetax_no" value="<?php echo $servicetax_no; ?>"/></td></tr>
				<tr><td> Pan Number: </td><td> <input type="text" name="pan_no" class="m-wrap medium" value="<?php echo $pan_no; ?>"/></td></tr>
				<tr><td>Bank Account Number: </td><td> <input type="text" class="m-wrap medium" name="account_no" value="<?php echo $account_no; ?>"/></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                <?php }?>
                <div class="form-actions">
                <button type="submit" value="Update Supplier Info" style="margin-left:30%" class="btn green" name="supplier_update_info"/><i class="icon-question-sign"></i> Save Changes</button>
                </div>
                </div></div>
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