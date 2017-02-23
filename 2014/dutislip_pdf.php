<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require_once("auth.php");
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Comfort');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setLanguageArray($l);
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();


$html='<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css_new/font-awesome.css" />
<title>Comfort</title>
</head>
<body>';

if(isset($_GET['customer']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `customer_reg` where `id`='".$_GET['id']."'");
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

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr>
  <td>Date : &nbsp;&nbsp;'.date('Y-m-d').'</td>
    <td colspan="6" align="center"><strong>Results for '.$name.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td width="156"><strong>Name:</strong></td>
    <td width="156">'.$name.'</td>
    <td width="156"><strong>Address:</strong></td>
    <td width="156">'.$address.'</td>
    <td><strong>Contact Person :</strong></td>
    <td>'.$Contact_person.'</td>
    <td><strong>Office Number:</strong></td>
    <td>'.$office_no.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Residence Number:</strong></td>
    <td>'.$Residence_no.'</td>
    <td><strong>Mobile Number:</strong></td>
    <td>'.$mobile_no.'</td>
     <td><strong>Email Id:</strong></td>
    <td>'.$email_id.'</td>
     <td><strong>Fax Number:</strong></td>
    <td>'.$fax_no.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Opening Balance:</strong></td>
    <td>'.$opening_bal.'</td>
    <td><strong>Closing Balance:</strong></td>
    <td>'.$closing_bal.'</td>
    <td><strong>Service Tax Reg. No.:</strong></td>
    <td>'.$srvctaxregno.'</td>
    <td><strong>PAN No.:</strong></td>
    <td>'.$panno.'</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Credit Limit:</strong></td>
    <td>'.$creditlimit.'</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="100px;">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="130px"></td>
    <td></td>
    <td width="130px;">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['receipt']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select `date`,`name`,`credit`,`narration`, `type_id`  from `ledger` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$date=$row['date'];
	$name=$row['name'];
	$credit=$row['credit'];
	$narration=$row['narration'];
	$type_id=$row['type_id'];

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr>
    <td colspan="3" align="left"><span><strong style="font-size:20px; font-family:calibri;">COMFORT  TRAVELS AND TOURS </strong></span><br/>
      104-106 &quot;Akruti&quot;<br/>
      <span> 4- New Fatehpura, Opp. Saheliyo ki Badi, UDAIPUR-313004 </span>
<br/>      <span>email:comfortadl@sancharnet.in</span></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><strong style="font-size:20px; font-family:calibri;">RECEIPT</strong></td>
  </tr>
  <tr>
    <td align="left" width="100"><strong>Receipt No.</strong><br/>
<strong>Date</strong>
    </td>
    <td colspan="2" align="left">&nbsp;&nbsp;'.$type_id.'<br/>
    '.DisplayDate($date).'</td>
  </tr>
   <tr align="left">
     <td><strong>Paid To:</strong>
     <br/>
    <strong> The Sum of Rs.</strong>
     </td>
     <td colspan="2" align="left">&nbsp;&nbsp;'.$name.'
     <br/>
     <span style="text-transform:capitalize;">
     &nbsp;&nbsp; '.$credit.' &nbsp;&nbsp;( Rupees';
         
    /*
$one=array(" "," one"," two"," three"," four"," five"," six"," seven","
eight"," nine"," ten"," eleven"," twelve"," thirteen"," fourteen","
fifteen"," sixteen"," seventeen"," eighteen"," nineteen");
$ten=array(" "," "," twenty"," thirty"," forty"," fifty"," sixty","
seventy"," eighty"," ninety");
$n=$row['credit'];
                  pw(round($n/10000000)," crore");
                  pw(round(($n/100000)%100)," lakh");
                  pw(round(($n/1000)%100)," thousand");
                  pw(round(($n/100)%10)," hundred");
                  pw(round($n%100)," ");*/
                 // echo " only /-";


$html.='</span>
     )</td>
  </tr>
  <tr align="left">
    <td colspan="3">
    '.$narration.'
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2"><strong>Prepared By &nbsp;&nbsp;&nbsp;&nbsp;Approved By</strong></td>
  </tr>
</table>.';

}
$data_base->close_connection();
}
else if(isset($_GET['payment']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select `date`,`name`,`debit`,`narration`, `type_id`  from `ledger` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$date=$row['date'];
	$name=$row['name'];
	$debit=$row['debit'];
	$narration=$row['narration'];
	$type_id=$row['type_id'];

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr>
    <td colspan="3" align="left"><span><strong style="font-size:20px; font-family:calibri;">COMFORT  TRAVELS AND TOURS </strong></span><br/>
      104-106 &quot;Akruti&quot;<br/>
      <span> 4- New Fatehpura, Opp. Saheliyo ki Badi, UDAIPUR-313004 </span>
<br/>      <span>email:comfortadl@sancharnet.in</span></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><strong style="font-size:20px; font-family:calibri;">PAYMENT</strong></td>
  </tr>
  <tr>
    <td align="left" width="100"><strong>Payment No.</strong><br/>
<strong>Date</strong>
    </td>
    <td colspan="2" align="left">&nbsp;&nbsp; '.$type_id.'<br/>
     '.DisplayDate($date).'</td>
  </tr>
   <tr align="left">
     <td><strong>Paid To:</strong>
     <br/>
    <strong> The Sum of Rs.</strong>
     </td>
     <td colspan="2" align="left">&nbsp;&nbsp;'.$name.'
     <br/>
     <span style="text-transform:capitalize;">
     &nbsp;&nbsp; '.$debit.' &nbsp;&nbsp;( Rupees';
        /*
    
$one=array(" "," one"," two"," three"," four"," five"," six"," seven","
eight"," nine"," ten"," eleven"," twelve"," thirteen"," fourteen","
fifteen"," sixteen"," seventeen"," eighteen"," nineteen");
$ten=array(" "," "," twenty"," thirty"," forty"," fifty"," sixty","
seventy"," eighty"," ninety");
$n=$row['debit'];
                  pw(round($n/10000000)," crore");
                  pw(round(($n/100000)%100)," lakh");
                  pw(round(($n/1000)%100)," thousand");
                  pw(round(($n/100)%10)," hundred");
                  pw(round($n%100)," ");
                  echo " only /-";*/


$html.='</span>
     )</td>
  </tr>
  <tr align="left">
    <td colspan="3">
    '.$narration.'
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2"><strong>Prepared By &nbsp;&nbsp;&nbsp;&nbsp;Approved By</strong></td>
  </tr>
</table>';
}
$data_base->close_connection();
}
else if(isset($_GET['supplier']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `supplier_reg` where `supplier_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$supplier_master_id=$row['supplier_master_id'];
	$supplier_master_name_id=$row['supplier_master_name_id'];
	$name_supplier=$row['name_supplier'];
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
	
$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;'.date('Y-m-d').'</td>
    <td colspan="6" align="center"><strong>Results for '.$name_supplier.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td width="156"><strong>Supplier Type:</strong></td>
    <td width="156">'.$supplier_master_id.'</td>
    <td width="156"><strong>Supplier Category:</strong></td>
    <td width="156">'.$supplier_master_name_id.'</td>
    <td><strong>Supplier Name :</strong></td>
    <td>'.$name_supplier.'</td>
    <td><strong>Address:</strong></td>
    <td>'.$address.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Contact Name:</strong></td>
    <td>'.$contact_name.'</td>
     <td><strong>Office Number:</strong></td>
    <td>'.$office_no.'</td>
     <td><strong>Residence Number:</strong></td>
    <td>'.$residence_no.'</td>
   <td><strong>Mobile Number</strong></td>
    <td>'.$mobile_no.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Fax Number:</strong></td>
    <td>'.$fax_no.'</td>
    <td><strong>Opening Balance:</strong></td>
    <td>'.$opening_bal.'</td>
    <td><strong>Closing Balance:</strong></td>
    <td>'.$closing_bal.'</td>
     <td><strong>Due Days:</strong></td>
    <td>'.$due_days.'</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Service Tax Number:</strong></td>
    <td>'.$servicetax_no.'</td>
    <td><strong>Pan Number</strong></td>
    <td>'.$pan_no.'</td>
    <td><strong> Bank Account Number:</strong></td>
    <td>'.$account_no.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['dutyslip']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `duty_slip` where `dutyslip_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
		$row=mysql_fetch_array($result);
		$dutyslip_id=$row['dutyslip_id'];
		$guest_name=$row['guest_name'];
		$service_service_id=$row['service_service_id'];
		$service_all=mysql_query("select * from `service` where `service_id` = '$service_service_id'  ");
		$ftc_service=mysql_fetch_array($service_all);
		$name_service = $ftc_service['name'];
		$carname_master_id=$row['carname_master_id'];
			
		$car_reg_name=$row['car_reg_name'];
		$new_car_no = $row['new_car_no'];
		
		$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
		$data_base_object = new DataBaseConnect();
		$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
		$row_carid = mysql_fetch_array($result_carid);
		$car_reg_name_new=$row_carid['name'];
		if($car_reg_name_new=="Others")
		{
			$car_reg_name_new=$new_car_no;
		}
		
		
		$customer_reg_name=$row['customer_reg_name'];
		$booked_by=$row['detail_number'];
		$driver_reg_driver_id=$row['driver_reg_driver_id'];
		$driver_reg_driver_id=$row['driver_reg_driver_id'];
		$driver_all=mysql_query("select * from `driver_reg` where `driver_id` = '$driver_reg_driver_id'  ");
		$ftc_driver=mysql_fetch_array($driver_all);
		$name_driver = $ftc_driver['name'];
		$opening_km=$row['opening_km'];
		$opening_time=$row['opening_time'];
		$closing_km=$row['closing_km'];
		$closing_time=$row['closing_time'];
		$date_from=$row['date_from'];
		$date_to=$row['date_to'];
		$remarks=$row['remarks'];
		$dat1=$row['current_date'];
		$dat=date("d-M-Y",strtotime($dat1));

$html.='<table align="center" width="100%" border="0"  style="font-family:calibri;border-collapse:collapse; text-align: center;">
  <tr>
    <td>
    	<img src="images/logo.jpg" />  
    </td>
    <td>Comfort Travels &amp; Tours
      <br/>
      "Akruti" , 4- New Fatehpura, Opp. Saheliyo ki Badi,  UDAIPUR-313004    
      <br/>
      :+91-294-2411661/62 Fax : +91-294-2422131
      </td>
    </tr> 
    <tr><td colspan="2">&nbsp;</td></tr>
    </table>
<table width="100%" border="1" align="center" style="text-align:left; font-family: calibri; font-size:25px; border-collapse:collapse; ">
  <tr >
    <td width="25%"><strong>Duty Slip Id:</strong></td>
    <td width="25%">'.$dutyslip_id.'</td>
    <td  width="25%"><strong>Date: </strong></td>
    <td  width="25%">'.$dat.'</td>
  </tr>
   <tr >
    <td width="25%"><strong>Customer:</strong></td>
    <td width="25%">'.$dutyslip_id.'</td>
    <td  width="25%"><strong>Guest: </strong></td>
    <td  width="25%">'.$dat.'</td>
  </tr>
   <tr>
   <td colspan="4">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Guest:</strong></td>
  	<td >'.$guest_name.'</td>
    <td><strong>Hotel: </strong></td>
    <td>___________</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Service: </strong></td>
    <td colspan="7">'.$name_service.'</td>
  
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Taxi Number:</strong></td>
    <td>'.$car_reg_name_new.'</td>
    <td><strong>Driver:</strong></td>
    <td>'.$name_driver.'</td>
    <td colspan="4"></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Time From:</strong></td>
    <td>'.$opening_time.'</td>
    <td><strong>to</strong></td>
    <td colspan="5">__________</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td width="30%"><strong>Opening KM:</strong></td>
    <td width="10%">'.$opening_km.'</td>
    <td width="10%"><strong>Closing KM:</strong></td>
    <td width="10%">'.$closing_km.'</td>
     <td width="10%"><strong>Closing Time:</strong></td>
    <td width="10%">'.$closing_time.'</td>
    <td width="10%"><strong>Used Hours:</strong></td>
    <td width="10%">________________</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Charges: </strong></td>
    <td colspan="5">________________________________</td>
    <td><strong>Running KM:</strong></td>
    <td>_____________</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr >
    <td><strong>Guest Comments: </strong></td>
    <td colspan="7">_____________________________________________________________________________________________</td>
  </tr>
  <tr >
    <td><strong>Remarks: </strong></td>
    <td colspan="7">'.$remarks.'</td>
  </tr>
<tr align="center"><td colspan="8"></td></tr>
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['dutyslipwaveoff']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `duty_slip_waveoff` where `dutyslip_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$dutyslip_id=$row['dutyslip_id'];
	$current_date=$row['current_date'];
	$guest_name=$row['guest_name'];
	$contactnumber=$row['contactnumber'];
	$photo_id=$row['photo_id'];
	$service_service_id=$row['service_service_id'];
	$carname_master_id=$row['carname_master_id'];
	$car_reg_name=$row['car_reg_name'];
	$customer_reg_name=$row['customer_reg_name'];
	$detail_number=$row['detail_number'];
	
	$driver_reg_driver_id=$row['driver_reg_driver_id'];
	$opening_km=$row['opening_km'];
	$opening_time=$row['opening_time'];
	$closing_km=$row['closing_km'];
	$closing_time=$row['closing_time'];
	$date_from=$row['date_from'];
	$date_to=$row['date_to'];
	$extra_chg=$row['extra_chg'];
	$permit_chg=$row['permit_chg'];
	$parking_chg=$row['parking_chg'];
	$otherstate_chg=$row['otherstate_chg'];
	$guide_chg=$row['guide_chg'];
	$misc_chg=$row['misc_chg'];
	$remarks=$row['remarks'];
	$billed_complimentary=$row['billed_complimentary'];
	$total_km=$row['total_km'];
	$rate=$row['rate'];
	$amount=$row['amount'];
	$loginname=$row['loginname'];
	$countername=$row['countername'];
	

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;'.date('Y-m-d').'</td>
    <td colspan="6" align="center"><strong>Duty Slip'.$dutyslip_id.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td width="156"><strong>Duty Slip Id:</strong></td>
    <td width="156">'.$dutyslip_id.'</td>
    <td width="156"><strong>Duty Slip Date:</strong></td>
    <td width="156">'.$current_date.'</td>
     <td><strong>Guest Name :</strong></td>
    <td>'.$guest_name.'</td>
     <td><strong>Contact Number:</strong></td>
    <td>'.$contactnumber.'</td>
    </tr>
    <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
     <td><strong>Photo Id :</strong></td>
    <td>'.$photo_id.'</td>
    <td><strong>Service Name :</strong></td>
    <td>'.$service_service_id.'</td>
    <td><strong>Car Name:</strong></td>
    <td>'.$carname_master_id.'</td>
    <td><strong>Car Number:</strong></td>
    <td>'.$car_reg_name.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
     <td><strong>Driver Name:</strong></td>
    <td>'.$driver_reg_driver_id.'</td>
     <td><strong>Opening KM:</strong></td>
    <td>'.$opening_km.'</td>
    <td><strong>Opening Time</strong></td>
    <td>'.$opening_time.'</td>
    <td><strong>Closing KM:</strong></td>
    <td>'.$closing_km.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Closing Time:</strong></td>
    <td>'.$closing_time.'</td>
    <td><strong>Date From:</strong></td>
    <td>'.$date_from.'</td>
    <td><strong>Date To:</strong></td>
    <td>'.$date_to.'</td>
    <td><strong>Extra Charges</strong></td>
    <td>'.$extra_chg.'</td>  
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Permit Charges:</strong></td>
    <td>'.$permit_chg.'</td>
    <td><strong>Parking Charges:</strong></td>
    <td>'.$parking_chg.'</td>
    <td><strong>Other State Charges:</strong></td>
    <td>'.$otherstate_chg.'</td>
    <td><strong>Guide Charges:</strong></td>
    <td>'.$guide_chg.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Remarks:</strong></td>
    <td>'.$remarks.'</td>
    <td><strong>Billed Complimentary:</strong></td>
    <td>'.$billed_complimentary.'</td>
    <td><strong>Misc. Charges:</strong></td>
    <td>'.$misc_chg.'</td>
     <td><strong>Rate:</strong></td>
    <td>'.$rate.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Amount:</strong></td>
    <td>'.$amount.'</td>
    <td><strong>Total KM.:</strong></td>
    <td>'.$total_km.'</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8"></td>
  </tr>
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['employee']) && isset($_GET['id']))
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
	
$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;'.date('Y-m-d') .'</td>
    <td colspan="6" align="center"><strong>Results for '.$name.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td><strong>Name:</strong></td>
    <td>'.$name.'</td>
    <td><strong>Mobile Number:</strong></td>
    <td>'.$mobile_no.'</td>
    <td><strong>Present Address:</strong></td>
    <td>'.$present_add.'</td>
    <td><strong>Father Name:</strong></td>
    <td>'.$father_name.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Qualification:</strong></td>
    <td>'.$qualification.'</td>
    <td><strong>Permanent Address:</strong></td>
    <td>'.$permanent_add.'</td>
     <td><strong>Date of Birth:</strong></td>
    <td>'.$dob.'</td>
     <td><strong>Date of Joining:</strong></td>
    <td>'.$date_joining.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Blood Group: </strong></td>
    <td>'.$blood_group.'</td>
    <td><strong>Reference Person:</strong></td>
    <td>'.$reference_person.'</td>
    <td><strong>Licence Number:</strong></td>
    <td>'.$licence_no.'</td>
    <td><strong>Licence Issue Date:</strong></td>
    <td>'.$date_issue_licence.'</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Licence Issued Place:</strong></td>
    <td>'.$issued_place.'</td>
    <td><strong>Licence Validity:</strong></td>
    <td>'.$licence_valid.'</td>
    <td><strong>Tax Badge No</strong></td>
    <td>'. $tax_badge_no.'</td>
   <td><strong>Date of Leaving:</strong></td>
    <td>'.$date_of_leaving.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Reason:</strong></td>
    <td>'.$reason.'</td>
    <td><strong>ESI Number:</strong></td>
    <td>'.$esi_number.'</td>
     <td><strong>PF Number:</strong></td>
    <td>'.$pf_number.'</td>
     <td><strong>Pan Number:</strong></td>
    <td>'.$pan_number.'</td>  
  </tr>
    <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Bank Acount Number:</strong></td>
    <td>'.$bank_account_number.'</td>
    <td><strong>Bank Name:</strong></td>
    <td>'.$bank_name.'</td>
    <td><strong>Designation:</strong></td>
    <td>'.$designation.'</td>
    <td><strong>Basic Salary:</strong></td>
    <td>'.$basicsalary.'</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Dearness:</strong></td>
    <td>'.$dearness.'</td>
    <td><strong>House Rent:</strong></td>
    <td>'.$houserent.'</td>
    <td><strong>Coneyance:</strong></td>
    <td>'.$conveyance.'</td>
    <td><strong>Phone Amount:</strong></td>
    <td>'.$phone.'</td>
  </tr>
    <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>Medical:</strong></td>
    <td>'.$medical.'</td>
    <td><strong>Profession Tax:</strong></td>
    <td>'.$professiontax.'</td>
    <td><strong>Provident Fund:</strong></td>
    <td>'.$providentfund.'</td>
    <td><strong>F.P.F:</strong></td>
    <td>'.$fpf.'</td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td><strong>E.S.I.C:</strong></td>
    <td>'.$esic.'</td>
    <td><strong>Income Tax Tds:</strong></td>
    <td>'.$incometaxtds.'</td>
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
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['car']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `car_reg` where `car_id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$carname_master_id=$row['carname_master_id'];
	$name=$row['name'];
	$supplier_reg_name=$row['supplier_reg_name'];
	$engine_no=$row['engine_no'];
	$chasis_no=$row['chasis_no'];
	$rto_tax_date=$row['rto_tax_date'];
	$insurance_date_from=$row['insurance_date_from'];
	$insurance_date_to=$row['insurance_date_to'];
	$authorization_date=$row['authorization_date'];
	$permit_date=$row['permit_date'];
	$fitness_date=$row['fitness_date'];
	$puc_date=$row['puc_date'];

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;'.date('Y-m-d').'</td>
    <td colspan="6" align="center"><strong>Results for '.$carname_master_id.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td><strong>Name:</strong></td>
    <td>'.$carname_master_id.'</td>
    <td><strong>Number:</strong></td>
    <td>'.$name.'</td>
    <td><strong>Supplier Name:</strong></td>
    <td>'.$supplier_reg_name.'</td>
     <td><strong>Engine Number:</strong></td>
    <td>'.$engine_no.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
   
    <td><strong>Chasis Number:</strong></td>
    <td>'.$chasis_no.'</td>
     <td><strong>RTO Tax Date:</strong></td>
    <td>'.$rto_tax_date.'</td>
     <td><strong>Insurance Starting Date:</strong></td>
    <td>'.$insurance_date_from.'</td>
    <td><strong>Insurance Ending Date: </strong></td>
    <td>'.$insurance_date_to.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Authorization Date: </strong></td>
    <td>'.$authorization_date.'</td>
    <td><strong>Permit Date: </strong></td>
    <td>'.$permit_date.'</td>
     <td><strong>Fitness Date: </strong></td>
    <td>'.$fitness_date.'</td>
     <td><strong>PUC Date: </strong></td>
    <td>'.$puc_date.'</td>
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
</table>';

}
$data_base->close_connection();
}
else if(isset($_GET['booking']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `booking` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$booking_id=$row['id'];
	$booked_by=$row['booked_by'];
	$customer_reg_name=$row['customer_reg_name'];
	$customer_mob_number=$row['customer_mob_number'];
	$guest_name=$row['guest_name'];
	$guest_mob_number=$row['guest_mob_number'];
	$travel_from=$row['travel_from'];
	$travel_to=$row['travel_to'];
	$service_id=$row['service_id'];
	$flight_no=$row['flight_no'];
	$pickup_time=$row['pickup_time'];
	$pickup_from=$row['pickup_from'];
	$drop_to=$row['drop_to'];
	$result=$data_base->execute_query_return("select * from `booking_car` where `booking_id`='".$booking_id."'");
	$row=mysql_fetch_array($result);
	$carname_master=$row['carname_master'];
	$vehicle=$row['vehicle'];

$html.='<table width="940px" align="center" id="newspaper-a" style="text-align:center;">
  <tr><td>Date : &nbsp;&nbsp;'.date('Y-m-d').'</td>
    <td colspan="6" align="center"><strong>Results for '.'Booking'.'</strong></td>
    <td></td>
  </tr>
  <tr>
    <td><strong>Booked By:</strong></td>
    <td>'.$booked_by.'</td>
    <td><strong>Customer Name:</strong></td>
    <td>'.$customer_reg_name.'</td>
    <td><strong>Customer Mobile:</strong></td>
    <td>'.$customer_mob_number.'</td>
    <td><strong>Guest Name:</strong></td>
    <td>'.$guest_name.'</td>
     </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    
    <td><strong>Guest Mobile:</strong></td>
    <td>'.$guest_mob_number.'</td>
      <td><strong>Travel From:</strong></td>
    <td>'.$travel_from.'</td>
      <td><strong>Travel Date To:</strong></td>
    <td>'.$travel_to.'</td>
    <td><strong>Service Name</strong></td>
    <td>'.$service_id.'</td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Flight Number: </strong></td>
    <td>'.$flight_no.'</td>
    <td><strong>PickUp Time: </strong></td>
    <td>'.$pickup_time.'</td>
    <td><strong>PickUp From: </strong></td>
    <td>'.$pickup_from.'</td>
    <td><strong>Drop To: </strong></td>
    <td>'.$drop_to.'</td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
   
    <td><strong>Car Name: </strong></td>
    <td>'.$carname_master.'</td>
    <td><strong>Number: </strong></td>
    <td>'.$vehicle.'</td>
    <td></td>
    <td></td><td></td>
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
</table>';

}
$data_base->close_connection();
}
/*
function pw($n,$ch)
{
	global $one;
	global $ten;
 if($n>19)echo $ten[$n/10],$one[$n%10];
 else echo $one[$n];
 if($n)echo $ch;
}
*/
$html.='</body>
</html>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page

//Close and output PDF document
$pdf->Output('dutyslip.pdf', 'I');
//============================================================+
// END OF FILE                                                
//============================================================+
?>