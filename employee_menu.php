<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
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
    	<?php
		if(isset($_POST['employee_edit']))
		{
							if(isset($_GET['employee_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Employee Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['employee_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Employee Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i>Employee Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Present Address</th>
                        <th>Date of Birth</th>
                        <th>Date Joining</th>
                        <th>Licence Valid Till</th>
                         <?php
							if(isset($_GET['employee_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['employee_delete']))
							{
								?>
                                 <th>Delete</th>
                                 <?php
							}
							else 
							{
								?>
                                 <th>Edit</th>
                                 <?php
							}
							
							?>
                        </tr>
                    </thead>
                   	<tbody>
                    <?php
				$q1="";	$q2="";	
				if(!empty($_POST['name']))
				{
					$name=$_POST['name'];
					$q1="name='".$name."'";
				}
				if(!empty($_POST['mobile_no']))
				{
					$mobile_no=$_POST['mobile_no'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_no."'";
					else 
						$q2=" AND mobile_no='".$mobile_no."'";
				}
				 if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from driver_reg";
                else    
					$qry="select * from driver_reg where ";
                        $sql=$qry.$q1.$q2;
                        $result=@mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$present_add=$row['present_add'];
							$mobile_no=$row['mobile_no'];
							$dob=$row['dob'];
							$driver_doj=$row['driver_doj'];
                            $lic_exp_date=$row['lic_exp_date'];
                       ?>
                            <tr id="<?php echo $i; ?>">
                            <td><?php echo $name;?></td>
                            <td><?php echo $present_add;?></td>
                            <td><?php echo $mobile_no;?></td>
                            <td><?php echo dateforview($dob);?></td>
                            <td><?php echo dateforview($driver_doj);?></td>
                            <td><?php echo dateforview($lic_exp_date);?></td>
                         <?php
							if(isset($_GET['employee_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?employee=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['employee_delete']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_employee(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_employee.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
                                </td>
                                 <?php
							}
							
							?>
                            </tr>
                            <?php
						}
						}
						?>
                    </tbody>
                    </table>   
                    </div>
                    </div>
                    </div>
               <?php
		}
		else if(isset($_GET['mode']))
		{
			if($_GET['mode']=='edit')
			{
				?>
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Employee Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="employee_menu.php?edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Employee Name:</td>
                        <td><input type="text" name="name" id="fetch_driver" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="driver_mob" name="mobile_no" /></td>
                        </tr>                     
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="employee_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                 <?php
			}
			else if($_GET['mode']=='del')
			{
				?>
                		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-trash"></i>Employee Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="employee_menu.php?employee_delete=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Employee Name:</td>
                        <td><input type="text" name="name" id="fetch_driver" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="driver_mob" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="employee_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>

                        </div>
                <?php
			}
			else if($_GET['mode']=='view')
			{
				?>
                		<div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Employee View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="employee_menu.php?employee_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Employee Name:</td>
                        <td><input type="text" name="name" id="supplier_id" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="driver_mob" name="mobile_no" /></td>
                        </tr>                     
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="employee_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
		}
		else
		{
		?>
        <form  name="form_name" action="Handler.php" method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Employee Add</h4>
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
        <td><input type="text" name="name" REQUIRED onblur="makeAlert()" id="fetch_driver" class="m-wrap medium"/> </td>
        </tr>
        <tr>
        <td id="dmob"> Driver Mobile No. : </td>
        <td><input type="text" name="mobile_no" id="driver_mob"   class="m-wrap medium"/> </td>
        <td> Present Address. : </td>
		<td><textarea rows="2" cols="28" name="present_add"  style="resize:none;" class="m-wrap medium"></textarea></td>
        </tr>
         
        <tr>
        <td> Father Name : </td>
		<td><input type="text" name="father_name"  class="m-wrap medium" /> </td>
        <td>Driver Qualification : </td>
        <td><input type="text" name="qualification"  class="m-wrap medium" /> </td>
		</tr>
        
        <tr>
        <td> Permanent Address : </td>
         <td><textarea rows="2"  style="resize:none;"  name="address"  class="m-wrap medium"></textarea> </td>
         <td> Date of Birth: </td>
        <td><input type="text" name="dob"  class="m-wrap medium date-picker" onClick="mydatepick();"/> </td>
        </tr>
        
        <tr>
        <td> ESIC Number: </td>
        <td><input type="text" name="esi_no"  class="m-wrap medium" /> </td>
        <td> PF Number: </td>
        <td><input type="text" name="pf_no"  class="m-wrap medium" /> </td>
        </tr>
        
        
        <tr>
        <td> Designation: </td>
        <td><input type="text" name="designation"   class="m-wrap medium"/> </td>
        <td> Basic Salary: </td>
        <td><input type="text" name="basicsalary"   class="m-wrap medium"/> </td>
        </tr>
                
        <tr>
        <td> Dearness: </td>
        <td><input type="text" name="dearness"   class="m-wrap medium"/> </td>
        <td> House Rent: </td>
        <td><input type="text" name="houserent"  class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> Conveyance: </td>
        <td><input type="text" name="conveyance"   class="m-wrap medium"/> </td>
        <td> Phone Amount: </td>
        <td><input type="text" name="phone_amnt"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Medical Amount: </td>
        <td><input type="text" name="medical_amnt"   class="m-wrap medium"/> </td>
        <td>Profession Tax: </td>
        <td><input type="text" name="professiontax"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td>Provident Fund: </td>
        <td><input type="text" name="providentfund"   class="m-wrap medium"/> </td>
        <td> F.P.F: </td>
        <td><input type="text" name="fpf"  class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> E.S.I.C: </td>
        <td><input type="text" name="esic"   class="m-wrap medium"/> </td>
        <td> Income Tax-TDS: </td>
        <td><input type="text" name="incometaxtds"  class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> Bank Account Number: </td>
        <td><input type="text" name="bank_account_number"   class="m-wrap medium"/> </td>
        <td> Bank Name: </td>
        <td><input type="text" name="bank_name"   class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> Date of Joining: </td>
        <td><input type="text" name="driver_doj"  id="dp2" class="m-wrap medium date-picker" onClick="mydatepick();" /> </td>
        <td> Blood Group: </td>
        <td>
        <select name="blood_group"  class="m-wrap medium">
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
        
        <tr>
        <td> Reference Person Name: </td>
        <td><input type="text" name="ref_name"  class="m-wrap medium" /> </td>
        <td> Licence Number: </td>
        <td><input type="text" name="lic_no" class="m-wrap medium"  /> </td>
        </tr>
        
        <tr>
        <td> Licence Issue Date </td>
        <td><input type="text" name="lic_issue_date"  id="dp3"  class="m-wrap medium date-picker" onClick="mydatepick();" /> </td>
        <td> Licence Issue Place </td>
        <td><input type="text" name="lic_issue_place"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Licence Expiry Date </td>
        <td><input type="text" name="lic_exp_date"   class="m-wrap medium date-picker" onClick="mydatepick();" /> </td>
        <td>Badge Number: </td>
        <td><input type="text" name="badge_no"   class="m-wrap medium"/> </td>
        </tr>
        
        <tr>
        <td> Date Of Leaving </td>
        <td><input type="text" name="dob_leave" id="dp5" class="m-wrap medium date-picker"  onClick="mydatepick();"/> </td>
        <td> Reason Of Leaving </td>
        <td><textarea rows="2"  style="resize:none;"  name="leave_reason"  class="m-wrap medium"></textarea>
        </td>
        </tr>
         
                       
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="driver_reg"/><i class="icon-ok"></i> Submit</button>
        </div>
        </div>
        </div> 
        </form>
        <?php	
		}
		?>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
<div class="footer">
<?php footer();?>
</div>
<?php js(); ?> 
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>