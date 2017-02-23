<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_POST['customer_update_info']))
{
	$id=$_POST['id']; 
	$data_base_connect_object =new DataBaseConnect(); 
	$qry="select * from customer_reg where id=".$id;
	$result= $data_base_connect_object->execute_query_return($qry);
	$row=mysql_fetch_array($result);
	$name=$row['name'];			
	$query = "update customer_reg set name='".$_POST['customer_name']."' , address='".trim($_POST['customer_address'])."' , Contact_person='".$_POST['customer_contact_person_name']."'
	, office_no='".$_POST['customer_office_number']."' , Residence_no='".$_POST['customer_residence_number']."' , mobile_no='".$_POST['customer_mobile_number']."' , email_id='".$_POST['customer_emailid']."' , fax_no='".$_POST['customer_fax_number']."' , opening_bal='".$_POST['customer_opening_balance']."' , closing_bal='".$_POST['customer_closing_balance']."' 
	, srvctaxregno='".$_POST['srvctaxregno']."' , panno='".$_POST['panno']."' , creditlimit='".$_POST['creditlimit']."'
	,`block_status`='".$_POST['block_status']."'
	where id='".$id."'";

	if(!empty($_POST['customer_fetch']))
	{
		
	    $sql_query="select * from customer_tariff where customer_reg_name = '".$_POST['customer_fetch']."' ";
		$result_cust_tariff= $data_base_connect_object->execute_query_return($sql_query);
		while($row_tariff=mysql_fetch_array($result_cust_tariff))
		{
		//$customer_reg_name_id = $row['customer_reg_name'];
		$carname_master_id = $row_tariff['carname_master_id'];
		$service_service_id = $row_tariff['service_service_id'];
		$rate = $row_tariff['rate'];
		$minimum_chg_km = $row_tariff['minimum_chg_km'];
		$extra_km_rate = $row_tariff['extra_km_rate'];
		$minimum_chg_hourly = $row_tariff['minimum_chg_hourly'];
		$extra_hour_rate = $row_tariff['extra_hour_rate'];
		
	  $cust_query="insert into  `customer_tariff` set `customer_reg_name`='".$id."',`carname_master_id`='".$carname_master_id."',`service_service_id`='".$service_service_id."',`rate`='".$rate."',`minimum_chg_km`='".$minimum_chg_km."',`extra_km_rate`='".$extra_km_rate."',`minimum_chg_hourly`='".$minimum_chg_hourly."',`extra_hour_rate`='".$extra_hour_rate."'";
		$data_base_connect_object->execute_query_operation($cust_query);
		}
	
	}
	$query_ledger = "update ledger set name='".$_POST['customer_name']."' where name='".$name."' && `ledger_type`='Customer'";
	$query_receipt = "update receipts set name='".$_POST['customer_name']."' where name='".$name."'";
	$query_journal = "update journal set name='".$_POST['customer_name']."' where name='".$name."' && `ledger_type`='Customer'";
	$query_payment = "update payment set name='".$_POST['customer_name']."' where name='".$name."'";
	
	$data_base_connect_object->execute_query_operation($query_ledger);
	$data_base_connect_object->execute_query_operation($query_receipt);
	$data_base_connect_object->execute_query_operation($query_journal);
	$data_base_connect_object->execute_query_operation($query_payment);
	$data_base_connect_object->execute_query_operation($query);
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
                  	$qry="select * from customer_reg where id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$name=$row['name'];
							$address=$row['address'];
							$contact_person=$row['Contact_person'];
							$office_number=$row['office_no'];
                            $residence_no=$row['Residence_no'];
                            $mobile_no=$row['mobile_no'];
                            $email_id=$row['email_id'];
                            $fax_no=$row['fax_no'];
                            $opening_bal=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
                            $srvctaxregno=$row['srvctaxregno'];
                            $panno=$row['panno'];
                            $creditlimit=$row['creditlimit'];
                            $block_status=$row['block_status'];
                        }
                 ?>
                <table width="100%">
              	<tr><td> Customer Name:</td><td><input value="<?php echo $name ;?>" type="text" name="customer_name" class="m-wrap medium"/></td></tr>
              	<tr><td> Customer Address:</td><td><textarea rows="2" cols="28" name="customer_address" style="resize:none;" class="m-wrap medium">
              	<?php echo trim($address) ;?>
              	 </textarea></td></tr>
              	<tr><td> Contact Person Name:</td><td><input type="text" value="<?php echo $contact_person ;?>" name="customer_contact_person_name" class="m-wrap medium" /></td></tr>
              	<tr><td> Office No.:</td><td><input type="text" name="customer_office_number" value="<?php echo $office_number ;?>"  class="m-wrap medium" /> </td></tr>
				<tr><td> Residence No. : </td><td><input type="text" name="customer_residence_number"  class="m-wrap medium" value="<?php echo $residence_no ;?>"/> </td></tr>
				<tr><td> Mobile No. : </td><td><input type="text" name="customer_mobile_number"  class="m-wrap medium" value="<?php echo $mobile_no ;?>"/> </td></tr>
				<tr><td> Customer Email Id : </td><td><input type="text" name="customer_emailid"  class="m-wrap medium" value="<?php echo $email_id ;?>"/> </td></tr>
				<tr><td> Customer Fax No. : </td><td><input type="text" name="customer_fax_number"  class="m-wrap medium" value="<?php echo $fax_no ;?>"/> </td></tr>
				<tr><td> Customer Opening Balance: </td><td><input type="text" name="customer_opening_balance"  class="m-wrap medium" value="<?php echo $opening_bal ;?>"/> </td></tr>
				<tr><td> Customer Closing Balance: </td><td><input type="text" name="customer_closing_balance"  class="m-wrap medium" value="<?php echo $closing_bal ;?>"/> </td></tr>
				<tr><td> Service Tax Reg Number: </td><td><input type="text" name="srvctaxregno"  class="m-wrap medium" value="<?php echo $srvctaxregno ;?>"/> </td></tr>
				<tr><td> Pan Number: </td><td><input type="text" name="panno"  class="m-wrap medium" value="<?php echo $panno ;?>"/> </td></tr>
				<tr><td> Credit Limit: </td><td><input type="text" name="creditlimit"  class="m-wrap medium" value="<?php echo $creditlimit ;?>"/> </td></tr>
				<tr><td> Blocked: </td><td><input type="text" name="block_status"  class="m-wrap medium" value="<?php echo $block_status ;?>"/> </td></tr>
                  <tr><td> Update Tariff Rate From: </td><td><select name="customer_fetch"  class="chosen"  >
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
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                <?php 
				}
				?>
                   <div class="form-actions">
                   <button type="submit" style="margin-left:30%"  class="btn green" name="customer_update_info"/><i class="icon-question-sign"></i> Save Change</button>
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>