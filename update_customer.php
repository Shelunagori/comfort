<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `customer_reg` where `id`='".$idd."'";
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
        <td> Customer Name:</td>
        <td><input type="text" name="name" id="customer_fetch" value="<?php echo $row_data['name']; ?>" class="m-wrap medium"></td>
        <td>Contact Person Name:</td>
        <td><input type="text" class="m-wrap medium" name="Contact_person" value="<?php echo $row_data['Contact_person'] ?>"/></td>
        </tr>
        
        <tr>
        <td> Office No.:</td>
        <td><input type="text" class="m-wrap medium" name="office_no" value="<?php echo $row_data['office_no'] ?>"/> </td>
        <td> Residence No. : </td>
        <td><input type="text" class="m-wrap medium" name="Residence_no" value="<?php echo $row_data['Residence_no'] ?>"/> </td>
        </tr>
        
        <tr>
        <td> Mobile No. : </td>
        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" value="<?php echo $row_data['mobile_no'] ?>"/> </td>
        <td> Customer Email Id : </td>
        <td><input type="text" class="m-wrap medium" name="email_id" value="<?php echo $row_data['email_id'] ?>"/> </td>
        </tr>
      
		<tr>
        <td> Customer Fax No. : </td>
        <td><input type="text" class="m-wrap medium" name="fax_no" value="<?php echo $row_data['fax_no'] ?>"/> </td>
        <td> Customer Opening Balance: </td>
        <td><input type="text" class="m-wrap medium" name="opening_bal"  value="<?php echo $row_data['opening_bal'] ?>"/> </td>
        </tr>
        
        <tr>
        <td> Customer Closing Balance: </td>
        <td><input type="text" class="m-wrap medium" name="closing_bal"  value="<?php echo $row_data['closing_bal'] ?>" /> </td>
		<td> Service Tax Reg Number: </td><td><input type="text" class="m-wrap medium" name="srvctaxregno"  value="<?php echo $row_data['srvctaxregno'] ?>"/> </td>
        </tr>
        
        <tr>
        <td> Credit Limit: </td>
        <td><input type="text" name="creditlimit"  class="m-wrap medium" value="<?php echo $row_data['creditlimit'] ?>"/> </td>
        <td> Service Tax Applicability : </td>
        <td><select type="text" name="servicetax_status" required class="m-wrap medium">
        <option value="">---select service tax status---</option>
        <option value="yes" <?php if($row_data['servicetax_status']=='yes') { ?> selected <?php } ?> >Yes</option>
        <option value="no" <?php if($row_data['servicetax_status']=='no') { ?> selected <?php } ?>>No</option>
        </select></td>
        </tr>
        
        <tr>
	    <td> Pan Number: </td>
        <td><input type="text" name="panno" class="m-wrap medium"  value="<?php echo $row_data['panno'] ?>"/> </td>
        <td valign="middle">Customer Address:</td>
        <td><textarea rows="2" style="resize:none;" class="m-wrap medium" name="address"><?php echo $row_data['address']; ?></textarea></td>
     	</tr>
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_customer"/><i class="icon-question-sign"></i> Save Change</button>
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