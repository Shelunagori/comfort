<?php
require_once("connect.php");
//require_once("auth.php");
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
// create new PDF document
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Comfort Pdf');
$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);


// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

$html='<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="css_new/font-awesome.css" />
<title>Comfort|PDF</title>
<style>
.mystyle {
  padding: 2px; 
}
</style>
</head>
<body>';
function convert_number_to_words($number) {
  
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(


         01                   => 'One',
        02                   => 'Two',
        03                   => 'Three',
        04                   => 'Four',
        05                   => 'Five',
        06                   => 'Six',
        07                   => 'Seven',
        08                   => 'Eight',
        09                   => 'Nine',



        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
  
    if (!is_numeric($number)) {
        return false;
    }
  
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
  
    $string = $fraction = null;
  
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
  
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
  
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
  
    return $string;
}

function serial_no($number)
 {

 $str_lenth=strlen($number);
if($str_lenth==1)
{
$number='000'.$number;
}
else if($str_lenth==2)
{
$number='00'.$number;
}

else if($str_lenth==3)
{
$number='0'.$number;
}
echo $number;


}
function fetchimg()
{
$result=@mysql_query("select `auth_sign` from `taxation`");
$row=@mysql_fetch_array($result);
$auth_sign=$row['auth_sign'];	
return($auth_sign);		
}
function fetchcarname($id)
{
$result=@mysql_query("select `name` from `car_type` where `id`='".$id."'");
$row=@mysql_fetch_array($result);
$name = $row['name'];
return($name);
}

function fetchservicename($id)
{
$result=@mysql_query("select `name` from `service` where `id`='".$id."'");
$row=@mysql_fetch_array($result);
$name = $row['name'];
return($name);
}

function fetchcustomername($id)
{
$result=@mysql_query("select `name` from `customer_reg` where `id`='".$id."'");
$row=@mysql_fetch_array($result);
$name = $row['name'];
return($name);
}

function datefordb($date)
{$date_new=date("Y-m-d",strtotime($date));return($date_new);}

function dateforview($date)
{
$date_no='N/A';	
$date_new=date("d-m-Y",strtotime($date));
if($date_new=='01-01-1970')
return($date_no);
else
return($date_new);}

function fetchcarno($id)
{
$result=@mysql_query("select `name` from `car_reg` where `id`='".$id."'");
$row=@mysql_fetch_array($result);
$name=$row['name'];	
return($name);		
}

if(isset($_GET['id']) && isset($_GET['dutyslip']))
{

	$view_data="Duty_slip ".$_GET['id']. ".pdf";

	$result=@mysql_query("select * from `duty_slip` where `id`='".$_GET['id']."'");
	$row_data=@mysql_fetch_array($result);

	$result_driver=@mysql_query("select `name` from `driver_reg` where `id`='".$row_data['driver_id']."'");
	$row_driver=@mysql_fetch_array($result_driver);
	if(!empty($row_data['temp_driver_name']))
	$driver_name=$row_data['temp_driver_name'];
	else
	$driver_name=$row_driver['name'];

	$result_car=@mysql_query("select `name` from `car_reg` where `id`='".$row_data['car_id']."'");
	$row_car=@mysql_fetch_array($result_car);
	if($row_car['name']=='Other')
	$car_number=$row_data['temp_car_no'];
	else
	$car_number=$row_car['name'];
	
	$total_time      = strtotime($closing_time) - strtotime($opening_time);
	$hours      = floor($total_time / 60 / 60);
	$minutes    = round(($total_time - ($hours * 60 * 60)) / 60);
	$time_duration=$hours.'.'.$minutes;
	
	$main1= strtotime($row_data['date_from']);
	$main2 = strtotime($row_data['date_to']);
	$days=(($main2-$main1)/86400);
	
	for($i=1;$i<=2;$i++)
	{
							$html.='<table width="100%" class="mystyle" border="1">
							<tr>
							<td><strong>DutySlip ID</strong></td>
							<td>'.$row_data['id'].'</td>
							<td><strong>Date</strong></td>
							<td colspan="3">'.dateforview($row_data['date']).'</td>
							</tr>
							<tr>
							<td><strong>Customer Name</strong></td>
							<td>'.fetchcustomername($row_data['customer_id']).'</td>
							<td><strong>Guest:</strong></td>
							<td colspan="3">'.$row_data['guest_name'].'</td>
							</tr>
							<tr>
							<td><strong>Service</strong></td>
							<td colspan="5">'.fetchservicename($row_data['service_id']).'</td>
							</tr>
							<tr>
							<td><strong>Taxi Number</strong></td>
							<td>'.$car_number.'</td>
							<td><strong>Driver</strong></td>
							<td colspan="3">'.$driver_name.'</td>
							</tr>
							<tr>
							<td><strong>Opening Date</strong></td>
							<td>'.dateforview($row_data['date_from']).'</td>
							<td><strong>Closing Date</strong></td>
							<td>'.dateforview($row_data['date_to']).'</td>
							<td><strong>Total Days</strong></td>
							<td>'.$days.'</td>
							</tr>
							<tr>
							<td><strong>Opening Time</strong></td>
							<td>'.$row_data['opening_time'].'</td>
							<td><strong>Closing Time</strong></td>
							<td>'.$row_data['closing_time'].'</td>
							<td><strong>Total Hours</strong></td>
							<td>'.$time_duration.'</td>
							</tr>
							<tr>
							<td><strong>Opening KM</strong></td>
							<td>'.$row_data['opening_km'].'</td>
							<td><strong>Closing KM</strong></td>
							<td>'.$row_data['closing_km'].'</td>
							<td><strong>Total Run</strong></td>
							<td>'.$row_data['total_km'].'</td>
							</tr>
							<tr>
							<td><strong>Guest Comment</strong></td>
							<td colspan="5"></td>
							</tr>
                            <tr>
                            <td><strong>Remarks</strong></td>
                            <td colspan="5">'.$row_data['remarks'].'</td>
                            </tr>
                            <tr>
                            <td><strong>Autorized Signature</strong></td>
                            <td colspan="5"></td>
                            </tr>
                           </table>';
						    if($i==1)
							{
							$html.= '<p style="text-align:center;margin-top:1%;">--------------------*--------------------</p>';
							}
	}
}
else if(isset($_GET['id']) && isset($_GET['billing']))
{
	$view_data="Billing_View ".$_GET['id']. ".pdf";
	$othercharges=0;
	$result_invoice=@mysql_query("select * from invoice where `id`='".$_GET['id']."'");
	$row_invoice=@mysql_fetch_array($result_invoice);
	
	$result_guest="select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$_GET['id']."' ";
	$result_guest2=@mysql_query("select `guest_name` from `duty_slip` where `id`in(".$result_guest.") ");
	$row_guest2=@mysql_fetch_array($result_guest2);
	$guest_name=$row_guest2['guest_name'];
		
	$html.='<table width="100%" class="mystyle"  border="1" >
                <tr> 
                <td width="15%">Bill To M/s.</td>
                <td width="55%">'.fetchcustomername($row_invoice['customer_id']).'</td>
                <td width="15%">Invoice No.</td>
                <td width="15%">'.$row_invoice['id'].'</td>
                </tr>
                <tr> 
                <td>Guest Name</td>
                <td>'.$guest_name.'</td>
                <td>Date</td>
                <td>'.dateforview($row_invoice['date']).'</td>
                </tr>
                <tr>
                <td>REF.</td>
                <td colspan="3"></td>
                </tr>
                <tr>
                <th colspan="2">Description</th>
                <th colspan="2">Amount in INR</th>
                </tr>';
                $result_invoice_detail=@mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$row_invoice['id']."' order by `duty_slip_id`");	
                while($row_invoice_detail=@mysql_fetch_array($result_invoice_detail))
                {
				
				$result_duty=@mysql_query("select * from duty_slip where `id`='".$row_invoice_detail['duty_slip_id']."'");	
				$row_duty=@mysql_fetch_array($result_duty);
				if(!empty($row_duty['temp_car_no']))
					$car_no=$row_duty['temp_car_no'];
				else
					$car_no=fetchcarno($row_duty['car_id']);
				
				$result_tariff=@mysql_query("select * from `customer_tariff` where customer_id='".$row_duty['customer_id']."' and car_type_id='".$row_duty['car_type_id']."' and service_id='".$row_duty['service_id']."'");
				if(mysql_num_rows($result_tariff)==0)   
				$result_tariff=@mysql_query("select * from `tariff_rate` where service_id='".$row_duty['service_id']."' and car_type_id='".$row_duty['car_type_id']."'");
				$row_rariff = @mysql_fetch_array($result_tariff);	
				
               $main_amnt=($row_duty['tot_amnt']-($row_duty['extra_chg']+$row_duty['permit_chg']+$row_duty['otherstate_chg']+$row_duty['guide_chg']+$row_duty['misc_chg']+$row_duty['parking_chg']));
			   
              $html.=  '<tr>
                <td colspan="2" style="text-align:left">"Duty Slip No '.$row_invoice_detail['duty_slip_id'].' dated on '.dateforview($row_duty['date']).' towards the cost of transport used in Udaipur for the Service '.fetchservicename($row_duty['service_id']).' ('.$row_rariff['minimum_chg_hourly'].' hrs / '.$row_rariff['minimum_chg_km'].' kms) by '.fetchcarname($row_duty['car_type_id']).' '.$car_no.'" </td>
                <th colspan="2"><b>'.$main_amnt.'</b></th>
                </tr>';
                    if(!empty($row_duty['extra']))
                    {
                     $html.= '<tr>
                            <th colspan="2"><b>Extra '.$row_duty['extra'].' '.$row_duty['extra_details'].'</b></th>
                            <th colspan="2"><b>'.$row_duty['extra_amnt'].'</b></th>
                            </tr>';
                    }
                    if(!empty($row_duty['extra_chg']))
                    {
                       $html.='<tr>
                            <td colspan="2">Toll Tax</td>
                            <th colspan="2"><b>'.$row_duty['extra_chg'].'</b></th>
                            </tr>';
                    }
                    if(!empty($row_duty['permit_chg']))
                    {
                       $html.='<tr>
                            <td colspan="2">Permit Charges</td>
                            <th colspan="2"><b>'.$row_duty['permit_chg'].'</b></th>
                            </tr>';
                    }
					if(!empty($row_duty['parking_chg']))
                    {
                          $html.='<tr>
                            <td colspan="2">Parking Charges</td>
                            <th colspan="2"><b>'.$row_duty['parking_chg'].'</b></th>
                            </tr>';
                    }
					if(!empty($row_duty['otherstate_chg']))
                    {
                            $html.='<tr>
                            <td colspan="2">Driver Allowance:</td>
                            <th colspan="2"><b>'.$row_duty['otherstate_chg'].'</b></th>
                            </tr>';
                    }
					if(!empty($row_duty['guide_chg']))
                    {
                               $html.='<tr>
                            <td colspan="2">Border Tax:</td>
                            <th colspan="2"><b>'.$row_duty['guide_chg'].'</b></th>
                            </tr>';
                    }
					if(!empty($row_duty['misc_chg']))
					{
                      		  $html.='<tr>
                            <td colspan="2">Miscellaneous Charges</td>
                            <th colspan="2"><b>'.$row_duty['misc_chg'].'</b></th>
                            </tr>';
					}
                }
                      $html.='<tr>
                    <th colspan="2">Total</th>
                    <th colspan="2"><b>'.$row_invoice['total'].'</b></th>
                    </tr>';
					if(!empty($row_invoice['tax']))
					{
						$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
						while($row_taxrate=mysql_fetch_array($result_taxrate))
						{
							$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
							$row_ledger_master=mysql_fetch_array($ledger_master);
							
							$ledger=mysql_query("select `credit` from `ledger` where `name`='".$row_taxrate['name']."' && `ledger_master_id`='".$row_ledger_master['id']."' && `invoice_id`='".$row_invoice['id']."'");
							while($row_ledger=mysql_fetch_array($ledger))
							{
								$html.='<tr>
								<th colspan="2">'.$row_taxrate['name'].'</th>
								<th colspan="2"><b>'.$row_ledger['credit'].'</b></th>
								</tr>';
								
							}
						}
                      	
					}
					if(!empty($row_invoice['discount']))
					{
                      		$html.='<tr>
                            <th colspan="2">Discount</th>
                            <th colspan="2"><b>'.$row_invoice['discount'].'</b></th>
                            </tr>';
					}
                             $html.='<tr>
                            <th colspan="2">Grand Total</th>
                            <th colspan="2"><b>'.$row_invoice['grand_total'].'</b></th>
                            </tr>
                            <tr>
                            <td colspan="4"><b>'.convert_number_to_words($row_invoice['grand_total']).'</b></td>
                            </tr>
                            <tr>
                            <td colspan="2"><b>SIGNATURE IN CONFIRMATION</b><br/><span style="font-size: 20px; font-style:italic;">of terms & condition overleaf</span></td>
                            <td colspan="2">For: Comfort Travels & Tours</td>
                            </tr>
                            <tr><td colspan="4" style="border-bottom:none;">&nbsp;</td></tr>
                            <tr><td colspan="4" style="border-top:none;">&nbsp;</td></tr>
                            <tr>
                            <td colspan="2">(Name............................................)</td>
                            <td colspan="2"><!--<img src="assets/'.fetchimg().'" style="width: 30%;! important; padding: 5px;"/><br/>-->Authorised Signatory</td>
                            </tr>
                            <tr>
                            <td colspan="4" style="color:#0872BA;"><b>Other Info.</b> <span>PAN No. AAWPC1369E, Service Tax: AAWPC1369EST001<br /><b>Email:-</b> operations@comforttours.com ,  siddhant.chatur@comforttours.com</span></td>
                            </tr>
                  </table>';
}
$html.='</body>
</html>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output($view_data, 'D');
?>

