<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
date_default_timezone_set('Asia/Calcutta');	
if(isset($_POST['customer_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into customer_reg(name,address,Contact_person,office_no,Residence_no,mobile_no,email_id,fax_no,opening_bal,closing_bal,srvctaxregno,panno,creditlimit)
	values('".$_POST['customer_name']."','".$_POST['customer_address']."','".$_POST['customer_contact_person_name']."'
	,'".$_POST['customer_office_number']."','".$_POST['customer_residence_number']."','".$_POST['customer_mobile_number']."'
	,'".$_POST['customer_emailid']."','".$_POST['customer_fax_number']."','".$_POST['customer_opening_balance']."'
	,'".$_POST['customer_closing_balance']."','".$_POST['srvctaxregno']."','".$_POST['panno']."'
	,'".$_POST['creditlimit']."')";	
    $data_base_connect_object->execute_query_operation($query);

	$sql_cust_id="select `id` from `customer_reg` where `name` = '".$_POST['customer_name']."' ORDER BY `id` DESC LIMIT 1";
	$result_for_id = $data_base_connect_object->execute_query_return($sql_cust_id);
	$row_sel=mysql_fetch_array($result_for_id);
	$id_customer=$row_sel['id'];

	if(!empty($_POST['customer_fetch']))
	{
		$sql_query="select * from customer_tariff where customer_reg_name = '".$_POST['customer_fetch']."' ";
		$result= $data_base_connect_object->execute_query_return($sql_query);
		while($row=mysql_fetch_array($result))
		{
		$carname_master_id = $row['carname_master_id'];
		$service_service_id = $row['service_service_id'];
		$rate = $row['rate'];
		$minimum_chg_km = $row['minimum_chg_km'];
		$extra_km_rate = $row['extra_km_rate'];
		$minimum_chg_hourly = $row['minimum_chg_hourly'];
		$extra_hour_rate = $row['extra_hour_rate'];
		
		$cust_query="insert into `customer_tariff`(`customer_reg_name`,`carname_master_id`,`service_service_id`,`rate`,`minimum_chg_km`,`extra_km_rate`,`minimum_chg_hourly`,`extra_hour_rate`)
		values('".$id_customer."','".$carname_master_id."','".$service_service_id."','".$rate."',
		'".$minimum_chg_km."','".$extra_km_rate."','".$minimum_chg_hourly."','".$extra_hour_rate."'
		)";
		$data_base_connect_object->execute_query_operation($cust_query);
		}
		}
	
	$data_base_connect_object->execute_query_update("insert into `ledger`(`ledger_type`,`name`,`credit`,`debit`,`date`)
		VALUES('Customer','".$_POST['customer_name']."','0','".$_POST['customer_opening_balance']."','".date('Y-m-d')."')
		", "ledger_insert");
	
	
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Customer Added SuccessFully .');
		window.location='customer_menu.php';
	</script>";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Customer Deleted SuccessFully .');
		window.location='customer_menu_delete.php';
	</script>
	";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Customer Infomation Updated Successfully.');
		window.location='customer_menu.php';
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
     <form method="post">
<div>                   
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '1' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{
		?>
<a href="customer_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($edit_status==1)
	{
		?>
<a href="customer_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="customer_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="customer_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                        <h4><i class="icon-comments"></i>Customer Add</h4>
                     </div>
                     <div class="portlet-body form">
                     <table width="100%" >
                            <tr><td> Customer Name:</td><td>
                            <input type="text" name="customer_name" class="m-wrap medium">
                            </td></tr>
              	<tr><td valign="middle"> Customer Address:</td><td><textarea rows="2" style="resize:none;" class="m-wrap medium" name="customer_address"></textarea></td></tr>
              	<tr><td> Contact Person Name:</td><td><input type="text" class="m-wrap medium" name="customer_contact_person_name" /></td></tr>
              	<tr><td> Office No.:</td><td><input type="text" class="m-wrap medium" name="customer_office_number" /> </td></tr>
				<tr><td> Residence No. : </td><td><input type="text" class="m-wrap medium" name="customer_residence_number" /> </td></tr>
				<tr><td> Mobile No. : </td><td><input type="text" class="m-wrap medium" name="customer_mobile_number" /> </td></tr>
				<tr><td> Customer Email Id : </td><td><input type="text" class="m-wrap medium" name="customer_emailid" /> </td></tr>
				<tr><td> Customer Fax No. : </td><td><input type="text" class="m-wrap medium" name="customer_fax_number" /> </td></tr>
				<tr><td> Customer Opening Balance: </td><td><input type="text" class="m-wrap medium" name="customer_opening_balance" /> </td></tr>
				<tr><td> Customer Closing Balance: </td><td><input type="text" class="m-wrap medium" name="customer_closing_balance" /> </td></tr>
				<tr><td> Service Tax Reg Number: </td><td><input type="text" class="m-wrap medium" name="srvctaxregno" /> </td></tr>
				<tr><td> Pan Number: </td><td><input type="text" name="panno" class="m-wrap medium" /> </td></tr>
				<tr><td> Credit Limit: </td><td><input type="text" name="creditlimit"  class="m-wrap medium"/> </td></tr>
                <tr><td> Copy Tariff Rate From: </td><td><select name="customer_fetch"  class="chosen" tabindex="1"  >
    							 <option value="" >--select customer name--</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$row['id'].'">'.$name.'</option>';
									}
        				      ?>

     </select></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                </table>
                     <div class="form-actions">
                     <button type="submit" style="margin-left:33%"   class="btn green" name="customer_reg"/><i class="icon-ok"></i> Add</button>
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>