<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
$idd=$_GET['id'];
$sql="SELECT * from `driver_reg` where `id`='".$idd."'";
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
       	<td> Employee/Driver: </td>
       	<td>
        <select name="emp_type" onchange="makeAlert()"  class="m-wrap medium">
        <option>Driver</option>
        <option>Employee</option>
        </select>
        </td>
        <td id="dname"> Driver Name : </td>
        <td><input type="text" name="name" REQUIRED onblur="makeAlert()" value="<?php echo $row_data['name']; ?>" id="fetch_driver" class="m-wrap medium"/> </td>
        </tr>
        <tr>
        <td id="dmob"> Driver Mobile No. : </td>
        <td><input type="text" name="mobile_no" id="mobileno"  value="<?php echo $row_data['mobile_no']; ?>"  class="m-wrap medium"/> </td>
        <td> Present Address. : </td>
		<td><textarea rows="2" cols="28" name="present_add"   style="resize:none;" class="m-wrap medium"><?php echo $row_data['present_add']; ?></textarea></td>
        </tr>
         
        <tr>
        <td> Father Name : </td>
		<td><input type="text" name="father_name" value="<?php echo $row_data['father_name']; ?>"  class="m-wrap medium" /> </td>
        <td>Driver Qualification : </td>
        <td><input type="text" name="qualification"  value="<?php echo $row_data['qualification']; ?>" class="m-wrap medium" /> </td>
		</tr>
        
        <tr>
        <td> Permanent Address : </td>
         <td><textarea rows="2"  style="resize:none;"  name="address"  class="m-wrap medium"><?php echo $row_data['address']; ?></textarea> </td>
         <td> Date of Birth: </td>
        <td><input type="text" name="dob"  class="m-wrap medium date-picker" value="<?php echo dateforview($row_data['dob']); ?>"  onClick="mydatepick();"/> </td>
        </tr>
        
        <tr>
        <td> ESIC Number: </td>
        <td><input type="text" name="esi_no"  class="m-wrap medium"  value="<?php echo $row_data['esi_no']; ?>"/> </td>
        <td> PF Number: </td>
        <td><input type="text" name="pf_no"  class="m-wrap medium"   value="<?php echo $row_data['pf_no']; ?>" /> </td>
        </tr>
        
        
        <tr>
        <td> Designation: </td>
        <td><input type="text" name="designation"   class="m-wrap medium"  value="<?php echo $row_data['designation']; ?>"/> </td>
        <td> Basic Salary: </td>
        <td><input type="text" name="basicsalary"   class="m-wrap medium"  value="<?php echo $row_data['basicsalary']; ?>"/> </td>
        </tr>
                
        <tr>
        <td> Dearness: </td>
        <td><input type="text" name="dearness"   class="m-wrap medium"  value="<?php echo $row_data['dearness']; ?>"/> </td>
        <td> House Rent: </td>
        <td><input type="text" name="houserent"  class="m-wrap medium"  value="<?php echo $row_data['houserent']; ?>"/> </td>
        </tr>
        
        <tr>
        <td> Conveyance: </td>
        <td><input type="text" name="conveyance"   class="m-wrap medium"  value="<?php echo $row_data['conveyance']; ?>"/> </td>
        <td> Phone Amount: </td>
        <td><input type="text" name="phone_amnt"   class="m-wrap medium"  value="<?php echo $row_data['phone_amnt']; ?>"/> </td>
        </tr>
        
        <tr>
        <td> Medical Amount: </td>
        <td><input type="text" name="medical_amnt"   class="m-wrap medium"  value="<?php echo $row_data['medical_amnt']; ?>"/> </td>
        <td>Profession Tax: </td>
        <td><input type="text" name="professiontax"   class="m-wrap medium"  value="<?php echo $row_data['professiontax']; ?>"/> </td>
        </tr>
        
        <tr>
        <td>Provident Fund: </td>
        <td><input type="text" name="providentfund"   class="m-wrap medium"  value="<?php echo $row_data['providentfund']; ?>"/> </td>
        <td> F.P.F: </td>
        <td><input type="text" name="fpf"  class="m-wrap medium"  value="<?php echo $row_data['fpf']; ?>"/> </td>
        </tr>
        
        <tr>
        <td> E.S.I.C: </td>
        <td><input type="text" name="esic"   class="m-wrap medium" value="<?php echo $row_data['esic']; ?>"/> </td>
        <td> Income Tax-TDS: </td>
        <td><input type="text" name="incometaxtds"  class="m-wrap medium" value="<?php echo $row_data['incometaxtds']; ?>"/> </td>
        </tr>
        
        <tr>
        <td> Bank Account Number: </td>
        <td><input type="text" name="bank_account_number"   class="m-wrap medium"  value="<?php echo $row_data['bank_account_number']; ?>"/> </td>
        <td> Bank Name: </td>
        <td><input type="text" name="bank_name"   class="m-wrap medium"  value="<?php echo $row_data['bank_name']; ?>"/> </td>
        </tr>
        
        <tr>
        <td> Date of Joining: </td>
        <td><input type="text" name="driver_doj"  class="m-wrap medium date-picker" onClick="mydatepick();"  value="<?php echo dateforview($row_data['driver_doj']); ?>"/> </td>
        
        <td> Blood Group: </td>
        <td>
        <select name="blood_group"  class="m-wrap medium">
        <option value="O+" <?php if($row_data['blood_group']=="O+") { ?> selected <?php } ?>>O+</option>
        <option value="A+" <?php if($row_data['blood_group']=="A+") { ?> selected <?php } ?>>A+</option>
        <option value="B+" <?php if($row_data['blood_group']=="B+") { ?> selected <?php } ?>>B+</option>
        <option value="AB+" <?php if($row_data['blood_group']=="AB+") { ?> selected <?php } ?>>AB+</option>
        <option value="O-" <?php if($row_data['blood_group']=="O-") { ?> selected <?php } ?>>O-</option>
        <option value="A-" <?php if($row_data['blood_group']=="A-") { ?> selected <?php } ?>>A-</option>
        <option value="B-" <?php if($row_data['blood_group']=="B-") { ?> selected <?php } ?>>B-</option>
        <option value="AB-" <?php if($row_data['blood_group']=="AB-") { ?> selected <?php } ?>>AB-</option>
        </select>
        </td>
        </tr>
        
        <tr>
        <td> Reference Person Name: </td>
        <td><input type="text" name="ref_name"  class="m-wrap medium"  value="<?php echo $row_data['ref_name']; ?>"/> </td>
        <td> Licence Number: </td>
        <td><input type="text" name="lic_no" class="m-wrap medium"  value="<?php echo $row_data['lic_no']; ?>" /> </td>
        </tr>
        
        <tr>
        <td> Licence Issue Date </td>
        <td><input type="text" name="lic_issue_date"  id="dp3"  class="m-wrap medium date-picker" onClick="mydatepick();" value="<?php echo dateforview($row_data['lic_issue_date']); ?>"/> </td>
        <td> Licence Issue Place </td>
        <td><input type="text" name="lic_issue_place"  value="<?php echo $row_data['lic_issue_place']; ?>"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Licence Expiry Date </td>
        <td><input type="text" name="lic_exp_date"  value="<?php echo dateforview($row_data['lic_exp_date']); ?>"  class="m-wrap medium date-picker" onClick="mydatepick();" /> </td>
        <td>Badge Number: </td>
        <td><input type="text" name="badge_no"  value="<?php echo $row_data['badge_no']; ?>"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Date Of Leaving </td>
        <td><input type="text" name="dob_leave" id="dp5" class="m-wrap medium date-picker"  value="<?php echo dateforview($row_data['dob_leave']); ?>"  onClick="mydatepick();"/> </td>
        <td> Reason Of Leaving </td>
        <td><textarea rows="2"  style="resize:none;"  name="leave_reason"  class="m-wrap medium"><?php echo $row_data['leave_reason']; ?></textarea>
        </td>
        </tr>
         
                       
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="update_employee"/><i class="icon-question-sign"></i> Save Change</button>
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