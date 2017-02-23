<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
$login_id=$_SESSION['login_user'];
if(isset($_POST['driver_reg']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "insert into driver_reg (name,mobile_no,present_add,father_name,
	qualification,permanent_add,dob,date_joining,blood_group,reference_person,
	licence_no,date_issue_licence,issued_place,licence_valid,tax_badge_no,date_of_leaving,
	reason,esi_number,pf_number,pan_number,bank_account_number,bank_name,designation,basicsalary,dearness,houserent,conveyance,phone,medical,professiontax,
	providentfund,fpf,esic,incometaxtds)
	values('".$_POST['driver_name']."','".$_POST['driver_mobile_number']."','".trim($_POST['driver_present_address'])."'
	,'".$_POST['father_name']."','".$_POST['driver_qualification']."','".trim($_POST['driver_per_address'])."'
	,'".DateExact($_POST['driver_dob'])."','".DateExact($_POST['driver_doj'])."','".$_POST['driver_blood_group']."'
	,'".$_POST['driver_reference_person_name']."','".$_POST['driver_licence_number']."'
	,'".DateExact($_POST['driver_licence_issue_date'])."','".$_POST['driver_licence_issue_place']."','".DateExact($_POST['driver_licence_valid_date'])."','".$_POST['driver_tax_badge_number']."'
	,'".DateExact($_POST['driver_date_leaving'])."'
	,'".trim($_POST['driver_leaving_reason'])."','".$_POST['esi_number']."','".$_POST['pf_number']."',
	'".$_POST['pan_number']."','".$_POST['bank_account_number']."','".$_POST['bank_name']."','".$_POST['designation']."','".$_POST['basicsalary']."','".$_POST['dearness']."','".$_POST['houserent']."','".$_POST['conveyance']."','".$_POST['phone']."','".$_POST['medical']."','".$_POST['professiontax']."'
	,'".$_POST['providentfund']."','".$_POST['fpf']."','".$_POST['esic']."','".$_POST['incometaxtds']."'
	)";	
	$data_base_connect_object->execute_query_operation($query);
	$sql_driver_id="select `driver_id` from `driver_reg` where `name` = '".$_POST['driver_name']."'  ORDER BY `driver_id` DESC LIMIT 1";
	$result_for_id = $data_base_connect_object->execute_query_return($sql_driver_id);
	$row_sel=mysql_fetch_array($result_for_id);
	$id_driver=$row_sel['driver_id'];
    $driver_query ="insert into `ledger`(`ledger_type`,`name`,`description`)
	values('Employee','".$id_driver."','Employee Description')";
	$data_base_connect_object->execute_query_operation($driver_query);
}
if(isset($_GET['reg']))
{
	echo "<script language=\"javascript\">
		alert('New Employee Added SuccessFully .');
		window.location='employee_menu.php';
	</script>";
}
if(isset($_GET['updt']))
{
	echo "<script language=\"javascript\">
		alert('Employee Infomation Updated Successfully.');
		window.location='employee_menu.php';
	</script>";
}
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Employee Deleted SuccessFully .');
		window.location='employee_menu.php';
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
<script type="text/javascript">
function makeAlert()
{
	var list = document.form_name.emp_type;
	var emp_type = list.options[list.selectedIndex].text;
	if(emp_type=="Driver")
	{
		 // driver validations
		document.getElementById("dname").innerHTML="Driver Name: ";
		document.getElementById("dmob").innerHTML="Driver Mobile No.: ";
	}
	else
	{
		// employee validations
		document.getElementById("dname").innerHTML="Employee Name: ";
		document.getElementById("dmob").innerHTML="Employee Mobile No.: ";
	}
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
     <form method="post" name="form_name">
<div>      
<?php
	$data_base_connect_object =new DataBaseConnect(); 
	$my_query="select * from sub_module_assign where `login_id` = '".$login_id."' && `submodule_id` = '38' ";
	$result_mydata = $data_base_connect_object->execute_query_return($my_query);
	$row_right=mysql_fetch_array($result_mydata);
	$add_status = $row_right['add'];
	$edit_status = $row_right['edit'];
	$delete_status = $row_right['delete'];
	$view_status = $row_right['view'];
	if($add_status==1)
	{    
	?>           
<a href="employee_menu.php" class="btn red"><i class="icon-ok"></i> Add</a>
<?php
	}
	if($edit_status==1)
	{
		?>
<a href="employee_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<?php
	}
	if($delete_status==1)
	{
	?>
<a href="employee_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<?php
	}
	if($view_status==1)
	{
		?>
<a href="employee_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                    <h4><i class="icon-comments"></i>Employee</h4>
                    </div>
                    <div class="portlet-body form">
                      <table width="100%">
                <tr><td> Employee/Driver: </td><td>
                	<select name="emp_type" onchange="makeAlert()"  class="m-wrap medium">
                	<option>Driver</option>
                	<option>Employee</option>
                	</select>
                </td></tr>
		        <tr><td id="dname"> Driver Name : </td><td><input type="text" name="driver_name" onblur="makeAlert()" class="m-wrap medium"/> </td></tr>
				<tr><td id="dmob"> Driver Mobile No. : </td><td><input type="text" name="driver_mobile_number"   class="m-wrap medium"/> </td></tr>
				<tr><td> Present Address. : </td>
				<td><textarea rows="3" cols="28" name="driver_present_address"  style="resize:none;" class="m-wrap medium"></textarea></td>
				</tr>
				<tr><td> Father Name : </td>
				<td><input type="text" name="father_name"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Qualification : </td>
				<td><input type="text" name="driver_qualification"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Permanent Address : </td>
				<td><textarea rows="3" cols="28" style="resize:none;"  name="driver_per_address"  class="m-wrap medium">
				</textarea> </td>
				</tr>
				<tr><td> Date of Birth: </td>
				<td><input type="text" name="driver_dob"  id="dp1"  class="m-wrap medium"/> </td>
				</tr>
				<tr><td> ESIC Number: </td>
				<td><input type="text" name="esi_number"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> PF Number: </td>
				<td><input type="text" name="pf_number"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Designation: </td>
				<td><input type="text" name="designation"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Basic Salary: </td>
				<td><input type="text" name="basicsalary"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Dearness: </td>
				<td><input type="text" name="dearness"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> House Rent: </td>
				<td><input type="text" name="houserent"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Conveyance: </td>
				<td><input type="text" name="conveyance"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Phone Amount: </td>
				<td><input type="text" name="phone"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Medical Amount: </td>
				<td><input type="text" name="medical"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td>Profession Tax: </td>
				<td><input type="text" name="professiontax"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td>Provident Fund: </td>
				<td><input type="text" name="providentfund"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> F.P.F: </td>
				<td><input type="text" name="fpf"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> E.S.I.C: </td>
				<td><input type="text" name="esic"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Income Tax-TDS: </td>
				<td><input type="text" name="incometaxtds"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Bank Account Number: </td>
				<td><input type="text" name="bank_account_number"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Bank Name: </td>
				<td><input type="text" name="bank_name"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Date of Joining: </td>
				<td><input type="text" name="driver_doj"  id="dp2" class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Blood Group: </td>
				<td>
				<select name="driver_blood_group"  class="m-wrap medium">
				<option value="O+">O+</option>
				<option value="A+">A+</option>
				<option value="B+">B+</option>
				<option value="AB+">AB+</option>
				<option value="O-">O-</option>
				<option value="A-">A-</option>
				<option value="B-">B-</option>
				<option value="AB-">AB-</option>
				</select>
				</td>
				</tr>
				<tr><td> Reference Person Name: </td>
				<td><input type="text" name="driver_reference_person_name"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Licence Number: </td>
				<td><input type="text" name="driver_licence_number" class="m-wrap medium"  /> </td>
				</tr>
				<tr><td> Licence Issue Date </td>
				<td><input type="text" name="driver_licence_issue_date"  id="dp3"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Licence Issue Place </td>
				<td><input type="text" name="driver_licence_issue_place"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Licence Expiry Date </td>
				<td><input type="text" name="driver_licence_valid_date" id="dp4"  class="m-wrap medium" /> </td>
				</tr>
				<tr><td>Badge Number: </td>
				<td><input type="text" name="driver_tax_badge_number"   class="m-wrap medium"/> </td>
				</tr>
				<tr><td> Date Of Leaving </td>
				<td><input type="text" name="driver_date_leaving" id="dp5" class="m-wrap medium" /> </td>
				</tr>
				<tr><td> Reason Of Leaving </td>
				<td><textarea rows="3" cols="28" style="resize:none;"  name="driver_leaving_reason"  class="m-wrap medium">
				</textarea> </td>
				</tr>
				<tr><td>&nbsp;</td>
				<td>&nbsp;</td>  
				</tr>
                </table>
                    
                  <div class="form-actions">
                  <button type="submit" value="Add" style="margin-left:30%" class="btn green" name="driver_reg"/><i class="icon-ok"></i> Add</button>
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