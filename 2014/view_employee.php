<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
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
<div>                     
<a href="employee_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="employee_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="employee_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="employee_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div> 
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-table"></i>View</h4>
                     </div>
                     <div class="portlet-body form">
 
 <?php
                 if(isset($_GET['employee']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `driver_reg` where `driver_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$name=$row['name'];
	$mobile_no=$row['mobile_no'];
	$present_add=$row['present_add'];
	$father_name=$row['father_name'];
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
	
?>
  <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
<table width="100%" align="center"  class="table table-bordered table-hover" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Results for <?php echo $name;?></strong></td>
    <td><!--<input type="button" onclick="javascript: window.print()" value="print"/> --></td>
  </tr>
  <tr>
    <td><strong>Name:</strong></td>
    <td><?php echo $name;?></td>
    <td><strong>Mobile Number:</strong></td>
    <td><?php echo $mobile_no;?></td>
    <td><strong>Present Address:</strong></td>
    <td><?php echo $present_add; ?></td>
    <td><strong>Father Name:</strong></td>
    <td><?php echo $father_name;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Qualification:</strong></td>
    <td><?php echo $qualification;?></td>
    <td><strong>Permanent Address:</strong></td>
    <td><?php echo $permanent_add;?></td>
     <td><strong>Date of Birth:</strong></td>
    <td><?php echo $dob;?></td>
     <td><strong>Date of Joining:</strong></td>
    <td><?php echo $date_joining;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Blood Group: </strong></td>
    <td><?php echo $blood_group;?></td>
    <td><strong>Reference Person:</strong></td>
    <td><?php echo $reference_person;?></td>
    <td><strong>Licence Number:</strong></td>
    <td><?php echo $licence_no;?></td>
    <td><strong>Licence Issue Date:</strong></td>
    <td><?php echo $date_issue_licence;?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Licence Issued Place:</strong></td>
    <td><?php echo $issued_place;?></td>
    <td><strong>Licence Validity:</strong></td>
    <td><?php echo $licence_valid;?></td>
    <td><strong>Tax Badge No</strong></td>
    <td><?php echo $tax_badge_no;?></td>
   <td><strong>Date of Leaving:</strong></td>
    <td><?php echo $date_of_leaving;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Reason:</strong></td>
    <td><?php echo $reason;?></td>
    <td><strong>ESI Number:</strong></td>
    <td><?php echo $esi_number;?></td>
     <td><strong>PF Number:</strong></td>
    <td><?php echo $pf_number;?></td>
     <td><strong>Pan Number:</strong></td>
    <td><?php echo $pan_number;?></td>  
  </tr>
    <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Bank Acount Number:</strong></td>
    <td><?php echo $bank_account_number;?></td>
    <td><strong>Bank Name:</strong></td>
    <td><?php echo $bank_name;?></td>
    <td><strong>Designation:</strong></td>
    <td><?php echo $designation;?></td>
    <td><strong>Basic Salary:</strong></td>
    <td><?php echo $basicsalary;?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Dearness:</strong></td>
    <td><?php echo $dearness;?></td>
    <td><strong>House Rent:</strong></td>
    <td><?php echo $houserent;?></td>
    <td><strong>Coneyance:</strong></td>
    <td><?php echo $conveyance;?></td>
    <td><strong>Phone Amount:</strong></td>
    <td><?php echo $phone;?></td>
  </tr>
    <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Medical:</strong></td>
    <td><?php echo $medical;?></td>
    <td><strong>Profession Tax:</strong></td>
    <td><?php echo $professiontax;?></td>
    <td><strong>Provident Fund:</strong></td>
    <td><?php echo $providentfund;?></td>
    <td><strong>F.P.F:</strong></td>
    <td><?php echo $fpf;?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>E.S.I.C:</strong></td>
    <td><?php echo $esic;?></td>
    <td><strong>Income Tax Tds:</strong></td>
    <td><?php echo $incometaxtds;?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="140px"></td>
    <td width="130px"></td>
    <td width="160px;">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php 
}
$data_base->close_connection();
}
?>
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