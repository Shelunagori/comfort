<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `supplier_reg` where `id`='".$idd."'";
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
        <h4><i class="icon-edit"></i>Customer Edit</h4>
        </div>
        <div class="portlet-body form">
         <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
       	<tr>
       	<td>Supplier Type:</td>
        <td>
        <select name="supplier_type_id"  class="m-wrap medium">
        <option value="">---Select---</option>	
        <?php 
        $result=@mysql_query("select * from supplier_type");
        while($row=mysql_fetch_array($result))
        {
		if($row_data['supplier_type_id']==$row['id'])	
        echo '<option value="'.$row['id'].'" selected>'.$row['name'].'</option>';
		else
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
		</td>
        <td> Supplier Category:</td>
        <td>  
        <select name="supplier_type_sub_id" class='m-wrap medium' >
    	<?php
		$result_=@mysql_query("select * from supplier_type_sub");
		while($row_=mysql_fetch_array($result_))
		{
			if($row_data['supplier_type_sub_id']==$row_['id'])	
			echo "<option value='".$row_['id']."' selected>".$row_['name']."</option>";
			else
			echo "<option value='".$row_['id']."'>".$row_['name']."</option>";
		}
		?>
		</select></td>
        </tr>
               
        <tr>
        <td> Supplier Name:</td>
        <td><input type="text" name="name" REQUIRED id="supplier_id" value="<?php echo $row_data['name'] ?>" class="m-wrap medium"/></td>
        <td> Address. : </td>
        <td><textarea rows="2"  name="address" class="m-wrap medium"  style="resize:none;"><?php echo $row_data['address'] ?></textarea></td>
        </tr>
        
        <tr>
        <td> Contact Name. : </td>
        <td><input type="text" name="contact_name" class="m-wrap medium"  value="<?php echo $row_data['contact_name'] ?>" /></td>
		<td> Office Number: </td>
        <td><input type="text" name="office_no" class="m-wrap medium" value="<?php echo $row_data['office_no'] ?>" /></td>
        </tr>
        
        <tr>
        <td> Residence Number : </td>
        <td><input type="text" name="residence_no" class="m-wrap medium" value="<?php echo $row_data['residence_no'] ?>" /> </td>
		<td> Mobile Number: </td>
        <td><input type="text" name="mobile_no" id="mobileno" class="m-wrap medium" value="<?php echo $row_data['mobile_no'] ?>" /> </td>
        </tr>
        
        <tr>
        <td> Email Id: </td>
        <td><input type="text" name="email_id"  class="m-wrap medium" value="<?php echo $row_data['email_id'] ?>"/> </td>
		<td> Fax Number: </td>
        <td><input type="text" name="fax_no" class="m-wrap medium" value="<?php echo $row_data['fax_no'] ?>"/> </td>
        </tr>
        
        <tr>
        <td> Opening Balance: </td>
        <td><input type="text" name="opening_bal"  class="m-wrap medium" value="<?php echo $row_data['opening_bal'] ?>"/> </td>
		<td> Closing Balance: </td>
        <td><input type="text" name="closing_bal"  class="m-wrap medium" value="<?php echo $row_data['closing_bal'] ?>"/> </td>
        </tr>
         
        <tr>
        <td> Due Days: </td>
        <td><input type="text" name="due_days"  class="m-wrap medium" value="<?php echo $row_data['due_days'] ?>"/> </td>
		<td> Service Tax Number: </td><td> <input type="text" name="servicetax_no" class="m-wrap medium" value="<?php echo $row_data['servicetax_no'] ?>"/></td>
        </tr>        
        
       <tr>
       <td> Pan Number: </td>
       <td> <input type="text" name="pan_no" class="m-wrap medium" value="<?php echo $row_data['pan_no'] ?>"/></td>
		<td>Bank Account Number: </td><td> <input type="text" name="account_no" class="m-wrap medium" value="<?php echo $row_data['account_no'] ?>"/></td>
        </tr> 
        <tr>
           <td> Service Tax Applicability : </td>
        <td><select type="text" name="servicetax_status"  class="m-wrap medium">
        <option value="">---select service tax status---</option>
        <option value="yes" <?php if($row_data['servicetax_status']=='yes') { ?> selected <?php } ?> >Yes</option>
        <option value="no" <?php if($row_data['servicetax_status']=='no') { ?> selected <?php } ?>>No</option>
        </select></td>
        </tr>  
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_supplier"/><i class="icon-question-sign"></i> Save Change</button>
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