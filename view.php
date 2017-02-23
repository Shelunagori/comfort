<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
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
<style>
th
{
	text-align:left !important;
}
</style>
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
  		<button class="btn yellow  diplaynone" role="button" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();" ><i class="icon-print"></i> Print</button>
  <a class="btn red diplaynone" role="button" onClick="javascript:window.close();"><i class="icon-remove"></i> Close</a>  
   <div class="container-fluid">
     <?php menu(); ?>
 <form method="post" name="form_name">
     <?php
if(isset($_GET['customer']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `customer_reg` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$name=$row['name'];
	$address=$row['address'];
	$Contact_person=$row['Contact_person'];
	$office_no=$row['office_no'];
	$Residence_no=$row['Residence_no'];
	$mobile_no=$row['mobile_no'];
	$email_id=$row['email_id'];
	$fax_no=$row['fax_no'];
	$opening_bal=$row['opening_bal'];
	$closing_bal=$row['closing_bal'];
	$srvctaxregno=$row['srvctaxregno'];
	$panno=$row['panno'];
	$creditlimit=$row['creditlimit'];
?>
    <h4><i class="icon-user"></i> <b>Customer Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
  	<tr>
    <td><strong>Name:</strong></td>
    <td><?php echo $name;?></td>
    <td><strong>Address:</strong></td>
    <td><?php echo $address;?></td>
    <td><strong>Contact Person :</strong></td>
    <td><?php echo $Contact_person; ?></td>
    </tr>
    
    <tr>
    <td><strong>Office Number:</strong></td>
    <td><?php echo $office_no;?></td>
    <td><strong>Residence Number:</strong></td>
    <td><?php echo $Residence_no;?></td>
    <td><strong>Mobile Number:</strong></td>
    <td><?php echo $mobile_no;?></td>
    </tr>
    
    <tr>
    <td><strong>Email Id:</strong></td>
    <td><?php echo $email_id;?></td>
    <td><strong>Fax Number:</strong></td>
    <td><?php echo $fax_no;?></td>
    <td><strong>Opening Balance:</strong></td>
    <td><?php echo $opening_bal;?></td>
    </tr>
    
    <tr>
    <td><strong>Closing Balance:</strong></td>
    <td><?php echo $closing_bal;?></td>
    <td><strong>Service Tax Reg. No.:</strong></td>
    <td><?php echo $srvctaxregno;?></td>
    <td><strong>PAN No.:</strong></td>
    <td><?php echo $panno;?></td>
    </tr>
    <tr>
    <td colspan="2"><strong>Service Tax Applicable</strong></td>
    <td colspan="4"><?php echo $row['servicetax_status']; ?></td>
    </tr>
    </table>
    <?php
}
}
else if(isset($_GET['supplier']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `supplier_reg` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$supplier_type_id=$row['supplier_type_id'];
	$type_name=supplier_type_name($supplier_type_id);
 	$supplier_type_sub_id=$row['supplier_type_sub_id'];
	$type_sub_name=supplier_type_sub_name($supplier_type_sub_id);
	$name=$row['name'];
	$address=$row['address'];
	$contact_name=$row['contact_name'];
	$office_no=$row['office_no'];
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
?>
    <h4><i class="icon-user"></i> <b>Supplier Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Supplier Type:</strong></td>
    <td><?php echo $type_name;?></td>
    <td><strong>Supplier Category:</strong></td>
    <td><?php echo $type_sub_name;?></td>
    </tr>
    <tr>
    <td><strong>Supplier Name :</strong></td>
    <td><?php echo $name; ?></td>
    <td><strong>Address:</strong></td>
    <td><?php echo $address;?></td>
    </tr>
    <tr>
    <td><strong>Contact Name:</strong></td>
    <td><?php echo $contact_name;?></td>
    <td><strong>Office Number:</strong></td>
    <td><?php echo $office_no;?></td>
    </tr>
    <tr>
    <td><strong>Residence Number:</strong></td>
    <td><?php echo $residence_no;?></td>
    <td><strong>Mobile Number</strong></td>
    <td><?php echo $mobile_no;?></td>
    </tr>
    <tr>
    <td><strong>Fax Number:</strong></td>
    <td><?php echo $fax_no;?></td>
    <td><strong>Opening Balance:</strong></td>
    <td><?php echo $opening_bal;?></td>
    </tr>
    <tr>
    <td><strong>Closing Balance:</strong></td>
    <td><?php echo $closing_bal;?></td>
    <td><strong>Due Days:</strong></td>
    <td><?php echo $due_days;?></td>
    </tr>
    <tr>
    <td><strong>Service Tax Number:</strong></td>
    <td><?php echo $servicetax_no;?></td>
    <td><strong>Pan Number</strong></td>
    <td><?php echo $pan_no;?></td>
    </tr>
    <tr>
    <td><strong> Bank Account Number:</strong></td>
    <td><?php echo $account_no;?></td>
    <td><strong>Service Tax Applicable</strong></td>
    <td><?php echo $row['servicetax_status']; ?></td>
    </tr>
    </table>
    <?php
}
}
else if(isset($_GET['employee']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `driver_reg` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-user"></i> <b>Employee Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Name</strong></td>
    <td><?php echo $row['name']; ?></td>
   	<td><strong>Mobile No</strong></td>
    <td><?php echo $row['mobile_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Persent Address</strong></td>
    <td><?php echo $row['present_add']; ?></td>
   	<td><strong>Father Name</strong></td>
    <td><?php echo $row['father_name']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Qualification</strong></td>
    <td><?php echo $row['qualification']; ?></td>
   	<td><strong>Address</strong></td>
    <td><?php echo $row['address']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Date of Birth</strong></td>
    <td><?php echo dateforview($row['dob']); ?></td>
   	<td><strong>Mobile No</strong></td>
    <td><?php echo $row['mobile_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>ESI No</strong></td>
    <td><?php echo $row['esi_no']; ?></td>
   	<td><strong>PF No</strong></td>
    <td><?php echo $row['pf_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Designation</strong></td>
    <td><?php echo $row['designation']; ?></td>
   	<td><strong>Basic Salary</strong></td>
    <td><?php echo $row['basicsalary']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Dearness</strong></td>
    <td><?php echo $row['dearness']; ?></td>
   	<td><strong>Houserent</strong></td>
    <td><?php echo $row['houserent']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Conveyance</strong></td>
    <td><?php echo $row['conveyance']; ?></td>
   	<td><strong>Phone amount</strong></td>
    <td><?php echo $row['phone_amnt']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Medical Amount</strong></td>
    <td><?php echo $row['medical_amnt']; ?></td>
   	<td><strong>Professiontax</strong></td>
    <td><?php echo $row['professiontax']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Provident fund</strong></td>
    <td><?php echo $row['providentfund']; ?></td>
   	<td><strong>FPF</strong></td>
    <td><?php echo $row['fpf']; ?></td>
    </tr>

    <tr>
    <td><strong>ESIC</strong></td>
    <td><?php echo $row['esic']; ?></td>
   	<td><strong>Income Tax-tds</strong></td>
    <td><?php echo $row['incometaxtds']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Bank Account Number</strong></td>
    <td><?php echo $row['bank_account_number']; ?></td>
   	<td><strong>Bank Name</strong></td>
    <td><?php echo $row['bank_name']; ?></td>
    </tr>
    
    <tr>
    <td><strong>driver Date of joining</strong></td>
    <td><?php echo dateforview($row['driver_doj']); ?></td>
   	<td><strong>Blood group</strong></td>
    <td><?php echo $row['blood_group']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Reference Name</strong></td>
    <td><?php echo $row['ref_name']; ?></td>
   	<td><strong>Licence No</strong></td>
    <td><?php echo $row['lic_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Reference Name</strong></td>
    <td><?php echo $row['ref_name']; ?></td>
   	<td><strong>Licence No</strong></td>
    <td><?php echo $row['lic_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Licence Issue Date</strong></td>
    <td><?php echo dateforview($row['lic_issue_date']); ?></td>
   	<td><strong>Licence Issue Place</strong></td>
    <td><?php echo $row['lic_issue_place']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Licence Exp. Date</strong></td>
    <td><?php echo dateforview($row['lic_exp_date']); ?></td>
   	<td><strong>Badge No</strong></td>
    <td><?php echo $row['badge_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Date of Leaveing</strong></td>
    <td><?php echo dateforview($row['dob_leave']); ?></td>
   	<td><strong>Leave Reason</strong></td>
    <td><?php echo $row['leave_reason']; ?></td>
    </tr>
    </table>
    <?php
}
}
else if(isset($_GET['car']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `car_reg` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-truck"></i> <b>Car Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Car Name</strong></td>
    <td><?php echo fetchcarname($row['car_type_id']); ?></td>
    <td><strong>Car Number</strong></td>
    <td><?php echo $row['name']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Supplier Name</strong></td>
    <td><?php echo fetchsuppliername($row['supplier_id']); ?></td>
    <td><strong>Engine Number</strong></td>
    <td><?php echo $row['engine_no']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Chasis No</strong></td>
    <td><?php echo $row['chasis_no']; ?></td>
    <td><strong>RTO Tax Date</strong></td>
    <td><?php echo dateforview($row['rto_tax_date']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Insurance Starting Date</strong></td>
    <td><?php echo dateforview($row['insurance_date_from']); ?></td>
    <td><strong>Insurance Ending Date</strong></td>
    <td><?php echo dateforview($row['insurance_date_to']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Authorization Date</strong></td>
    <td><?php echo dateforview($row['authorization_date']); ?></td>
    <td><strong>Permit Date</strong></td>
    <td><?php echo dateforview($row['permit_date']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Fitness Date</strong></td>
    <td><?php echo dateforview($row['fitness_date']); ?></td>
    <td><strong>PUC Date</strong></td>
    <td><?php echo dateforview($row['puc_date']); ?></td>
    </tr>
    
 	</table>
    <?php
}
}
else if(isset($_GET['tariff']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `tariff_rate` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-cloud"></i> <b>Tariff Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Service Name</strong></td>
    <td><?php echo fetchservicename($row['service_id']); ?></td>
    <td><strong>Car Name</strong></td>
    <td><?php echo fetchcarname($row['car_type_id']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Rate</strong></td>
    <td><?php echo $row['rate']; ?></td>
    <td><strong>Minimum Charge km.</strong></td>
    <td><?php echo $row['minimum_chg_km']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Extra km rate</strong></td>
    <td><?php echo $row['extra_km_rate']; ?></td>
    <td><strong>Minimum Charge Hourly</strong></td>
    <td><?php echo $row['minimum_chg_hourly']; ?></td>
    </tr>
    
   
    <tr>
    <td><strong>Extra Hour Rate</strong></td>
    <td colspan="3"><?php echo $row['extra_hour_rate']; ?></td>
    </tr>
    
 	</table>
    <?php
}
}  
else if(isset($_GET['customer_tariff']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `customer_tariff` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-cloud"></i> <b>Customer Tariff Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Service Name</strong></td>
    <td><?php echo fetchservicename($row['service_id']); ?></td>
    <td><strong>Car Name</strong></td>
    <td><?php echo fetchcarname($row['car_type_id']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Customer Name</strong></td>
    <td><?php echo fetchcustomername($row['customer_id']); ?></td>
    <td><strong>Minimum Charge km.</strong></td>
    <td><?php echo $row['minimum_chg_km']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Extra km rate</strong></td>
    <td><?php echo $row['extra_km_rate']; ?></td>
    <td><strong>Minimum Charge Hourly</strong></td>
    <td><?php echo $row['minimum_chg_hourly']; ?></td>
    </tr>
    
   
    <tr>
    <td><strong>Rate</strong></td>
    <td><?php echo $row['rate']; ?></td>
    <td><strong>Extra Hour Rate</strong></td>
    <td><?php echo $row['extra_hour_rate']; ?></td>
    </tr>
    
 	</table>
    <?php
}
}
else if(isset($_GET['supplier_tariff_rate_view']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `supplier_tariff` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-cloud"></i> <b>Supplier Tariff Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Service Name</strong></td>
    <td><?php echo fetchservicename($row['service_id']); ?></td>
    <td><strong>Car Name</strong></td>
    <td><?php echo fetchcarname($row['car_type_id']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Supplier Name</strong></td>
    <td><?php echo fetchsuppliername($row['supplier_id']); ?></td>
    <td><strong>Minimum Charge km.</strong></td>
    <td><?php echo $row['minimum_chg_km']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Extra km rate</strong></td>
    <td><?php echo $row['extra_km_rate']; ?></td>
    <td><strong>Minimum Charge Hourly</strong></td>
    <td><?php echo $row['minimum_chg_hourly']; ?></td>
    </tr>
    
   
    <tr>
    <td><strong>Rate</strong></td>
    <td><?php echo $row['rate']; ?></td>
    <td><strong>Extra Hour Rate</strong></td>
    <td><?php echo $row['extra_hour_rate']; ?></td>
    </tr>
    
 	</table>
    <?php
}
}
else if(isset($_GET['supplier_tariff_rate_view']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `supplier_tariff` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-cloud"></i> <b>Supplier Tariff Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
    <tr>
    <td><strong>Service Name</strong></td>
    <td><?php echo fetchservicename($row['service_id']); ?></td>
    <td><strong>Car Name</strong></td>
    <td><?php echo fetchcarname($row['car_type_id']); ?></td>
    </tr>
    
    <tr>
    <td><strong>Supplier Name</strong></td>
    <td><?php echo fetchsuppliername($row['supplier_id']); ?></td>
    <td><strong>Minimum Charge km.</strong></td>
    <td><?php echo $row['minimum_chg_km']; ?></td>
    </tr>
    
    <tr>
    <td><strong>Extra km rate</strong></td>
    <td><?php echo $row['extra_km_rate']; ?></td>
    <td><strong>Minimum Charge Hourly</strong></td>
    <td><?php echo $row['minimum_chg_hourly']; ?></td>
    </tr>
    
   
    <tr>
    <td><strong>Rate</strong></td>
    <td><?php echo $row['rate']; ?></td>
    <td><strong>Extra Hour Rate</strong></td>
    <td><?php echo $row['extra_hour_rate']; ?></td>
    </tr>
    
 	</table>
    <?php
}
}
else if(isset($_GET['booking']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `booking` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
?>
    <h4><i class="icon-bell"></i> <b>Booking Detail:</b></h4>
    <table width="100%" class="table table-bordered table-striped table-condensed flip-content" >
   <tr>
   <td><strong>Customer Name</strong></td>
   <td><?php echo fetchcustomername($row['customer_id']); ?></td>
   <td><strong>Mobile No.</strong></td>
   <td><?php echo $row['mobile_no']; ?></td>
   </tr>
    
   <tr>
   <td><strong>Guest Name</strong></td>
   <td><?php echo $row['guest_name']; ?></td>
   <td><strong>Guest Mobile No</strong></td>
   <td><?php echo $row['guest_mobile_no']; ?></td>
   </tr>
   
   <tr>
   <td><strong>Travel from</strong></td>
   <td><?php echo dateforview($row['travel_from']); ?></td>
   <td><strong>Travel To</strong></td>
   <td><?php echo dateforview($row['travel_to']); ?></td>
   </tr>
   
   <tr>
   <td><strong>Service Name</strong></td>
   <td><?php echo fetchservicename($row['service_id']); ?></td>
   <td><strong>Car Name</strong></td>
   <td><?php echo fetchcarname($row['car_type_id']); ?></td>
   </tr>
   
   <tr>
   <td><strong>Flight No.</strong></td>
   <td><?php echo $row['flight_no']; ?></td>
   <td><strong>Pickup Time</strong></td>
   <td><?php echo $row['pickup_time']; ?></td>
   </tr>
   
   <tr>
   <td><strong>Pickup place</strong></td>
   <td><?php echo $row['pickup_place']; ?></td>
   <td><strong>Drop place</strong></td>
   <td><?php echo $row['drop_place']; ?></td>
   </tr>
   
   <tr>
   <td><strong>UserName</strong></td>
   <td><?php echo fetchusername($row['login_id']); ?> </td>
   <td><strong>Counter Name</strong></td>
   <td><?php echo fetchcountername($row['counter_id']); ?></td>
   </tr>
    
 	</table>
    <?php
}
}
else if(isset($_GET['payment']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `ledger` where `transaction_id`='".$_GET['id']."' && `transaction_type`='payment'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$result1=@mysql_query("select * from `ledger` where `transaction_id`='".$_GET['id']."' && `transaction_type`='payment' && `bank_id`!=0");
	$row1=mysql_fetch_array($result1);
	if(!empty($row1['bank_id']))
	{
		$bank_id=$row1['bank_id'];
		$branch_id=$row1['branch_id'];
		$cheque_no=$row1['cheque_no'];
		$cheque_date=$row1['cheque_date'];
		$drawn_branch=$row1['drawn_branch'];
		$payment_method="Bank";
		$result2= mysql_query("select `name`,`branch` from `bank_reg` where `id`='".$bank_id."'");
        $row2=mysql_fetch_array($result2);
		$bank_name=$row2['name'];
		$branch_name=$row2['branch'];
		 $data='<tr align="left">
     <td><strong>Payment Type:</strong>
     <br/>
     <strong>Bank Name:</strong>
	 <br/>
     <strong>Branch Name:</strong>
	 <br/>
     <strong>Cheque Date:</strong>
	 <br/>
     <strong>Cheque number:</strong>
     </td>
     <td colspan="2" align="left">
	 '.$payment_method.'
     <br/>
	 '.$bank_name.'
     <br/>
	 '.$branch_name.'
     <br/>
	 '.$cheque_date.'
     <br/>
	 '.$cheque_no.'
	</td>
  </tr>';
        
	}
	else
	{
		$payment_method="Cash";	
		$data='<tr align="left">
		 <td><strong>Payment Type:</strong></td>
		 <td colspan="2" align="left">
		'.$payment_method.'</td>
		</tr>';
	}
?>
   <table width="100%" class="table table-bordered table-striped table-condensed flip-content">
    <tr>
    <td colspan="3" align="left"><span><strong style="font-size:20px; font-family:calibri;">COMFORT  TRAVELS AND TOURS </strong></span><br/>
    104-106 &quot;Akruti&quot;<br/>
    <span> 4- New Fatehpura, Opp. Saheliyo ki Badi, UDAIPUR-313004 </span>
    <br/>      <span>email:comfortadl@sancharnet.in</span></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center"><strong style="font-size:20px; font-family:calibri;">PAYMENT</strong></td>
  </tr>
  <tr>
    <td align="left" width="140"><strong>PAYMENT No.</strong><br/>
<strong>Date</strong>
    </td>
    <td colspan="2" align="left">&nbsp;&nbsp;<strong><?php echo $_GET['id'];?></strong><br/>
    <?php echo dateforview($row['date']);?></td>
  </tr>
   <tr align="left">
     <td><strong>Paid To:</strong>
     <br/>
    <strong> The Sum of Rs.</strong>
     </td>
     <td colspan="2" align="left"><?php echo $row['name'];?>
     <br/>
     <span style="text-transform:capitalize;">
 	 <?php echo $row['debit']; ?>
    (<?php echo (convert_number_to_words($row['debit'])); ?>)
</span>
	</td>
  </tr>
  <?php echo $data; ?>
  <tr align="left">
    <td colspan="3">
    <?php echo $row['narration']; ?>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2" style="text-align:center"><strong>Prepared By &nbsp;&nbsp;&nbsp;&nbsp;Approved By</strong></td>
  </tr>
   </table>
    <?php
}
}
else if(isset($_GET['receipt']) && isset($_GET['id']))
{
$result=@mysql_query("select * from `ledger` where `transaction_id`='".$_GET['id']."' && `transaction_type`='receipt'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$result1=@mysql_query("select * from `ledger` where `transaction_id`='".$_GET['id']."' && `transaction_type`='receipt' && `bank_id`!=0");
	$row1=mysql_fetch_array($result1);
	if(!empty($row1['bank_id']))
	{
		$bank_id=$row1['bank_id'];
		$branch_id=$row1['branch_id'];
		$cheque_no=$row1['cheque_no'];
		$cheque_date=$row1['cheque_date'];
		$drawn_branch=$row1['drawn_branch'];
		$payment_method="Bank";
		$result2= mysql_query("select `name`,`branch` from `bank_reg` where `id`='".$bank_id."'");
        $row2=mysql_fetch_array($result2);
		$bank_name=$row2['name'];
		$branch_name=$row2['branch'];
		 $data='<tr align="left">
     <td><strong>Receipt Type:</strong>
     <br/>
     <strong>Bank Name:</strong>
	 <br/>
     <strong>Branch Name:</strong>
	 <br/>
     <strong>Cheque Date:</strong>
	 <br/>
     <strong>Cheque number:</strong>
     </td>
     <td colspan="2" align="left">
	 '.$payment_method.'
     <br/>
	 '.$bank_name.'
     <br/>
	 '.$branch_name.'
     <br/>
	 '.$cheque_date.'
     <br/>
	 '.$cheque_no.'
	</td>
  </tr>';
        
	}
	else
	{
		$payment_method="Cash";	
		$data='<tr align="left">
		 <td><strong>Receipt Type:</strong></td>
		 <td colspan="2" align="left">
		'.$payment_method.'</td>
		</tr>';
	}
?>
   <table width="100%" class="table table-bordered table-striped table-condensed flip-content">
    <tr>
    <td colspan="3" align="left"><span><strong style="font-size:20px; font-family:calibri;">COMFORT  TRAVELS AND TOURS </strong></span><br/>
    104-106 &quot;Akruti&quot;<br/>
    <span> 4- New Fatehpura, Opp. Saheliyo ki Badi, UDAIPUR-313004 </span>
    <br/>      <span>email:comfortadl@sancharnet.in</span></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center"><strong style="font-size:20px; font-family:calibri;">RECEIPT</strong></td>
  </tr>
  <tr>
    <td align="left" width="140"><strong>RECEIPT No.</strong><br/>
<strong>Date</strong>
    </td>
    <td colspan="2" align="left">&nbsp;&nbsp;<strong><?php echo $_GET['id'];?></strong><br/>
    <?php echo dateforview($row['date']);?></td>
  </tr>
   <tr align="left">
     <td><strong>Paid To:</strong>
     <br/>
    <strong> The Sum of Rs.</strong>
     </td>
     <td colspan="2" align="left"><?php echo $row['name'];?>
     <br/>
     <span style="text-transform:capitalize;">
 	 <?php echo $row['credit']; ?>
    (<?php echo (convert_number_to_words($row['credit'])); ?>)
</span>
	</td>
  </tr>
  <?php echo $data; ?>
  
  <tr align="left">
    <td colspan="3">
    <?php echo $row['narration']; ?>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2" style="text-align:center"><strong>Prepared By &nbsp;&nbsp;&nbsp;&nbsp;Approved By</strong></td>
  </tr>
   </table>
    <?php
}
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