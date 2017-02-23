<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_POST['driver_update_info']))
{
	$id=$_POST['id'];
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "update driver_reg set name='".$_POST['driver_name']."' , mobile_no='".$_POST['driver_mobile_number']."' , present_add='".trim($_POST['driver_present_address'])."' , father_name='".$_POST['fether_name']."' , 
	qualification='".$_POST['driver_qualification']."',permanent_add='".trim($_POST['driver_per_address'])."',dob='".$_POST['driver_dob']."',date_joining='".$_POST['driver_doj']."',blood_group='".$_POST['driver_blood_group']."',
	reference_person='".$_POST['driver_reference_person_name']."',licence_no='".$_POST['driver_licence_number']."',date_issue_licence='".$_POST['driver_licence_issue_date']."',issued_place='".$_POST['driver_licence_issue_place']."',licence_valid='".$_POST['driver_licence_valid_date']."',
	tax_badge_no='".$_POST['driver_tax_badge_number']."',date_of_leaving='".$_POST['driver_date_leaving']."',
	reason='".trim($_POST['driver_leaving_reason'])."',
	esi_number='".$_POST['esi_number']."' ,
	pf_number='".$_POST['pf_number']."' ,
	pan_number='".$_POST['pan_number']."' ,
	bank_account_number='".$_POST['bank_account_number']."' ,
	bank_name='".$_POST['bank_name']."', designation='".$_POST['designation']."',basicsalary='".$_POST['basicsalary']."',dearness='".$_POST['dearness']."',houserent='".$_POST['houserent']."',conveyance='".$_POST['conveyance']."',phone='".$_POST['phone']."',medical='".$_POST['medical']."',professiontax='".$_POST['professiontax']."',providentfund='".$_POST['providentfund']."',fpf='".$_POST['fpf']."',esic='".$_POST['esic']."',incometaxtds='".$_POST['incometaxtds']."'  
	where driver_id=".$id;	
	$data_base_connect_object->execute_query_update($query,"driver_update");
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
<a href="employee_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="employee_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="employee_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="employee_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
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
                  	$qry="select * from driver_reg where driver_id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['driver_id'];
							$name=$row['name'];
							$mobile_no=$row['mobile_no'];
							$present_add=$row['present_add'];
							$licence_address=$row['father_name'];
                            $qualification=$row['qualification'];
                            $permanent_add=$row['permanent_add'];
                            $dob=$row['dob'];
                            $date_joining=$row['date_joining'];
                            $blood_group=$row['blood_group'];
                            $reference_person=$row['reference_person'];
                            $licence_no=$row['licence_no'];
                            $date_issue_licence=$row['date_issue_licence'];
                            $issued_place=$row['issued_place'];
                            $licence_valid=$row['licence_valid'];
                            $tax_badge_no=$row['tax_badge_no'];
                            $date_of_leaving=$row['date_of_leaving'];
                            $reason=$row['reason'];
                            $esi_number=$row['esi_number'];
                            $pf_number=$row['pf_number'];
                            $pan_number=$row['pan_number'];
                            $bank_account_number=$row['bank_account_number'];
                            $bank_name=$row['bank_name'];
                            $designation=$row['designation'];
                            $basicsalary=$row['basicsalary'];
                            $dearness=$row['dearness'];
                            $houserent=$row['houserent'];
                            $conveyance=$row['conveyance'];
                            $phone=$row['phone'];
                            $medical=$row['medical'];
                            $professiontax=$row['professiontax'];
							$providentfund=$row['providentfund'];
							$fpf=$row['fpf'];
							$esic=$row['esic'];
							$incometaxtds=$row['incometaxtds'];
                        }
                       $data_base_object->close_connection();
                 ?>
                <table width="100%">
              	<tr><td> Driver Name : </td><td><input type="text" name="driver_name" class="m-wrap medium" value="<?php echo $name;?>"/> </td></tr>
				<tr><td> Driver Mobile No. : </td><td><input type="text" name="driver_mobile_number" class="m-wrap medium" value="<?php echo $mobile_no;?>"/> </td></tr>
				<tr><td> Present Address. : </td>
				<td><textarea rows="3" cols="20" style="resize:none" name="driver_present_address" class="m-wrap medium">
				<?php echo $permanent_add;?>
				</textarea></td>
				</tr>
				<tr><td> Licence Address : </td>
				<td><input type="text" class="m-wrap medium" name="driver_licence_address" value="<?php echo $licence_address;?>"/> </td>
				</tr>
				
				<tr><td> Qualification : </td>
				<td><input type="text" class="m-wrap medium" name="driver_qualification" value="<?php echo $qualification;?>"/> </td>
				</tr>
				
				<tr><td> Permanent Address : </td>
				<td><textarea rows="3" name="driver_per_address" class="m-wrap medium">
				<?php echo $permanent_add;?>
				</textarea> </td>
				</tr>
				
				<tr><td> Date of Birth: </td>
				<td><input type="text" name="driver_dob" class="m-wrap medium" value="<?php echo DatePickerDate($dob);?>" id="dp1"/> </td>
				</tr>
				
				<tr><td> ESIC Number: </td>
				<td><input type="text" name="esi_number" class="m-wrap medium"  value="<?php echo $esi_number;?>"/> </td>
				</tr>
				<tr><td> PF Number: </td>
				<td><input type="text" name="pf_number" class="m-wrap medium" value="<?php echo $pf_number;?>"/> </td>
				</tr>
				<tr><td> PAN Number: </td>

				<td><input type="text" name="pan_number" class="m-wrap medium" value="<?php echo $pan_number;?>"/> </td>
				</tr>
				<tr><td> Designation: </td>
				<td><input type="text" name="designation" class="m-wrap medium" value="<?php echo $designation;?>"/> </td>
				</tr>
				<tr><td> Basic Salary: </td>
				<td><input type="text" name="basicsalary"  class="m-wrap medium" value="<?php echo $basicsalary;?>"/> </td>
				</tr>
				<tr><td> Dearness: </td>
				<td><input type="text" name="dearness" class="m-wrap medium" value="<?php echo $dearness;?>"/> </td>
				</tr>
				<tr><td> House Rent: </td>
				<td><input type="text" name="houserent" class="m-wrap medium" value="<?php echo $houserent;?>"/> </td>
				</tr>
				<tr><td> Conveyance: </td>
				<td><input type="text" name="conveyance" class="m-wrap medium" value="<?php echo $conveyance;?>"/> </td>
				</tr>
				<tr><td> Phone Amount: </td>
				<td><input type="text" name="phone" class="m-wrap medium" value="<?php echo $phone;?>"/> </td>
				</tr>
				<tr><td> Medical Amount: </td>
				<td><input type="text" name="medical" class="m-wrap medium" value="<?php echo $medical;?>"/> </td>
				</tr>
				<tr><td>Profession Tax: </td>
				<td><input type="text" name="professiontax" class="m-wrap medium" value="<?php echo $professiontax;?>"/> </td>
				</tr>
				<tr><td>Provident Fund: </td>
				<td><input type="text" name="providentfund" class="m-wrap medium" value="<?php echo $providentfund;?>"/> </td>
				</tr>
				<tr><td> F.P.F: </td>
				<td><input type="text" name="fpf" class="m-wrap medium" value="<?php echo $fpf;?>"/> </td>
				</tr>
				<tr><td> E.S.I.C: </td>
				<td><input type="text" name="esic" class="m-wrap medium" value="<?php echo $esic;?>"/> </td>
				</tr>
				<tr><td> Income Tax-TDS: </td>
				<td><input type="text" name="incometaxtds" class="m-wrap medium" value="<?php echo $incometaxtds;?>"/> </td>
				</tr>
				<tr><td> Bank Account Number: </td>
				<td><input type="text" name="bank_account_number" class="m-wrap medium" value="<?php echo $bank_account_number;?>"/> </td>
				</tr>
				<tr><td> Bank Name: </td>
				<td><input type="text" name="bank_name" class="m-wrap medium" value="<?php echo $bank_name;?>"/> </td>
				</tr>
				
				<tr><td> Date of Joining: </td>
				<td><input type="text" name="driver_doj" id="dp2" class="m-wrap medium" value="<?php echo $date_joining;?>"/> </td>
				</tr>
				
				<tr><td> Blood Group: </td>
				<td>
				<select name="driver_blood_group" class="m-wrap medium">
				
				<?php $blood_group_array=array('O+','A+','B+','AB+','O-','A-','B-','AB-');
				foreach ($blood_group_array as $value) 
				{
					if ($value==$blood_group) 
					{
						echo "<option value=\"".$value."\" selected=\"selected\">".$value."</option>";
					}
					else {
						echo "<option value=\"".$value."\">".$value."</option>";
					}
				}
				?>
				</select>
				</td>
				</tr>
				<tr><td> Reference Person Name: </td>
				<td><input type="text" name="driver_reference_person_name" class="m-wrap medium" value="<?php echo $reference_person;?>"/> </td>
				</tr>
				
				<tr><td> Licence Number: </td>
				<td><input type="text" name="driver_licence_number" class="m-wrap medium" value="<?php echo $licence_no;?>"/> </td>
				</tr>
				
				
				<tr><td> Licence Issue Date </td>
				<td><input type="text" name="driver_licence_issue_date" class="m-wrap medium" id="dp3" value="<?php echo $date_issue_licence;?>"/> </td>
				</tr>
				
				
				<tr><td> Licence Issue Place </td>
				<td><input type="text" name="driver_licence_issue_place" class="m-wrap medium" value="<?php echo $issued_place;?>"/> </td>
				</tr>
				
				
				<tr><td> Licence Valid Date </td>
				<td><input type="text" name="driver_licence_valid_date" id="dp4" class="m-wrap medium" value="<?php echo $licence_valid;?>"/> </td>
				</tr>
				
				<tr><td> Tax Badge No. </td>
				<td><input type="text" name="driver_tax_badge_number" class="m-wrap medium" value="<?php echo $tax_badge_no;?>"/> </td>
				</tr>
				
				<tr><td> Date Of Leaving </td>
				<td><input type="text" name="driver_date_leaving"  class="m-wrap medium" id="dp5" value="<?php echo $date_of_leaving;?>"/> </td>
				</tr>
				
				
				<tr><td> Reason Of Leaving </td>
				<td><textarea rows="3" style="resize:none" class="m-wrap medium" cols="20" name="driver_leaving_reason">
				<?php echo $reason;?>
				</textarea> </td>
				</tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <input type="hidden" value="<?php echo $id;?>" name="id" />
                <?php }?>
                   <div class="form-actions">
                   <button type="submit" value="Update Info" style="margin-left:30%" class="btn green" name="driver_update_info"><i class="icon-question-sign"></i> Save Changes</button>
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