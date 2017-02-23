<?php
require_once("connect.php");
@header ( "Content-type: application/vnd.ms-excel" );
@header ( "Content-Disposition: attachment; filename=".$_POST['excel_for'].".xls" );
date_default_timezone_set('asia/kolkata');

function datefordb($date)
{$date_new=date("Y-m-d",strtotime($date));return($date_new);}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function dateforview($date)
{
	$date_no='-';	
	$date_new=date("d-m-Y",strtotime($date));
	if($date_new=='01-01-1970'||$date_new=='30-11-0001')
	return($date_no);
	else
	return($date_new);}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchledgertype_name($id)
{
	$result_table=mysql_query("select `name` from `ledger_type` where `id`='".$id."'");
	$row_table=mysql_fetch_array($result_table);
	$name=$row_table['name'];
	return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<table width="100%"  cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
<tr><td colspan="3"></td>
<td colspan="3" align="center" style="color:#0872BA;"><span style="font-size:18px !important;"><b>Comfort Travels &amp; Tours</b></span></td></tr>
<tr><td colspan="3"></td><td colspan="3"  align="center" style="font-size:16px !important;color:#0872BA;">"Akruti", 4-New Fatehpura, Opp. Saheliyo ki Badi,</span></td></tr>
<tr><td colspan="3"></td><td colspan="3"  align="center" style="font-size:16px !important;color:#0872BA;">UDAIPUR-313004 Fax: +91-294-2422131</td></tr>
<tr><td colspan="3"></td><td colspan="3" align="center" style="font-size:16px !important; color:#0872BA;">Telephone : +91-294-2411661/62
</td>
</tr>
</table>';

if($_POST['excel_for']=='waveoffds')
	{
			$q1=""; $q2="";
			if(!empty($_POST['date_from'])&&!empty($_POST['date_to']))
			{
			$date_from=date("Y-m-d",strtotime($_POST['date_from']));
			$date_to=date("Y-m-d",strtotime($_POST['date_to']));
			$q1=" `date` between '".$date_from."' and  '".$date_to."' ";
			}
			if($q1=="")
			$qry ="select * from `duty_slip`  where `waveoff_status`='1'  ";
			else {
			$qry="select * from `duty_slip` where ";
			$q2=" and `waveoff_status`='1' "; }
			$sql=$qry.$q1.$q2;
			$result=mysql_query($sql);
			echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
			<thead>
            <th>DS No.</th>
            <th>Customer Name</th>
            <th>Guest Name</th>
            <th>Service</th>
            <th>Car</th>
            <th>Car No.</th>
            <th>Date</th>
            <th>Opening KM</th>
            <th>Closing KM</th>
            <th>Reason</th>
            </thead>
            <tbody>';
			  while($row=mysql_fetch_array($result))
            {
				$i++;
				if(!empty($row['temp_car_no']))
				{
				$car_no=$row['temp_car_no'];
				}
				else
				{
					$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row['car_id']."'");
					$row_car=mysql_fetch_array($result_car);
					$car_no=$row_car['name'];	
				}
					$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
					$row_cust=mysql_fetch_array($result_cust);
					$cust_name=$row_cust['name'];
					
					$result_service=mysql_query("select `name` from `service` where `id`='".$row['service_id']."'");
					$row_service=mysql_fetch_array($result_service);
					$service_name=$row_service['name'];
					
					$result_carname=mysql_query("select `name` from `car_type` where `id`='".$row['car_type_id']."'");
					$row_carname=mysql_fetch_array($result_carname);
					$car_name=$row_carname['name'];
					
			echo 	'<tr>
                    <td>'.$i.'</td>
                    <td>'.$cust_name.'</td>
                    <td>'.$row['guest_name'].'</td>
                    <td>'.$service_name.'</td>
                    <td>'.$car_name.'</td>
                    <td>'.$car_no.'</td>
                    <td>'.date("d-m-Y",strtotime($row['date'])).'</td>
                    <td>'.$row['opening_km'].'</td>
                    <td>'.$row['closing_km'].'</td>
                    <td>'.$row['waveoff_reason'].'</td>
                    </tr>';
			}
			echo  '</tbody>
            </table>';
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if($_POST['excel_for']=='waveoffbill')
	{
		
			 				$q1="";  $q2="";
			 				if(!empty($_POST['date_from'])&&!empty($_POST['date_to']))
							{
							$date_from=date("Y-m-d",strtotime($_POST['date_from']));
							$date_to=date("Y-m-d",strtotime($_POST['date_to']));
							$q1=" `date` between '".$date_from."' and  '".$date_to."' ";
							}
							if($q1=="")
							$qry ="select * from `invoice`  where `waveoff_status`='1'  ";
							else {
							$qry="select * from `invoice` where ";
							$q2=" and `waveoff_status`='1' "; }
							$sql=$qry.$q1.$q2;
 							$result=mysql_query($sql);
							echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
							<thead>
							<tr>
							<th>SL.</th>
							<th>Duty Slip No.</th>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th>Reason</th>
							<th>Login Name</th>
							</tr>
							</thead>
							<tbody>';
					     while($row=mysql_fetch_array($result))
						{$i++;
							$ds_ids="";
							$result_ds=mysql_query("select `duty_slip_id` from  `invoice_detail` where `invoice_id`='".$row['id']."'");
							while($row_ds=mysql_fetch_array($result_ds))
							{
								$ds_ids[]=$row_ds['duty_slip_id'];
							}
							$ds_ids_show=@implode(",",$ds_ids);
							
							$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							
							$result_user=mysql_query("select `username` from `login` where `id`='".$row['waveoff_login_id']."'");
							$row_user=mysql_fetch_array($result_user);
							$username=$row_user['username'];	

							echo '<tr>
							<td>'.$i.'</td>
							<th>'.$ds_ids_show.'</th>
							<th>'.$row['id'].'</th>
							<td>'.date("d-m-Y",strtotime($row['date'])).'</td>
							<td>'.$cust_name.'</td>
							<td>'.$row['waveoff_reason'].'</td>
							<td>'.$username.'</td>
							</tr>';
							}
							echo '</tbody>
								  </table>';
							
						
	}		
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='opends')
{	
						    $q1=""; $q2=""; $q3='order by date';
			 				if(!empty($_POST['customer_id']))
							{
							$customer_id=$_POST['customer_id'];
							$q1=" `customer_id` = '".$customer_id."' ";
							}
							if($q1=="")
							$qry ="select * from `duty_slip`  where `closing_km`='0'  && `waveoff_status`='0' ";
							else {
							$qry="select * from `duty_slip` where ";
							$q2=" and `closing_km`='0' "; }
							$sql=$qry.$q1.$q2.$q3;
 							$result=mysql_query($sql);
							echo  '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
							<thead>
							<tr>
							<th>SL.</th>
							<th>Duty Slip No.</th>
							<th>Car No.</th>
							<th>Service Name</th>
							<th>Customer Name</th>
							<th>Date</th>
							<th>Opening KM.</th>
							<th>Closing KM.</th>
							</tr>
							</thead>
							<tbody>';
							while($row=mysql_fetch_array($result))
							{$i++;
							if(!empty($row['temp_car_no']))
							{
							$car_no=$row['temp_car_no'];
							}
							else
							{
							$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row['car_id']."'");
							$row_car=mysql_fetch_array($result_car);
							$car_no=$row_car['name'];	
							}
							
							$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							
							$result_service=mysql_query("select `name` from `service` where `id`='".$row['service_id']."'");
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
							
							echo   '<tr>
							<td>'.$i.'</td>
							<th>'.$row['id'].'</th>
							<td>'.$car_no.'</td>
							<td>'.$service_name.'</td>
							<td>'.$cust_name.'</td>
							<td>'.date("d-m-Y",strtotime($row['date'])).'</td>
							<td>'.$row['opening_km'].'</td>
							<td>'.$row['closing_km'].'</td>
							</tr>';
							}
							echo  '</tbody>
							</table>';
	
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='unbilled')
	{
			$q1=""; $q2="";
			if(!empty($_POST['customer_id']))
			{
			$customer_id=$_POST['customer_id'];
			$q1=" `customer_id` = '".$customer_id."' ";
			}
			if($q1=="")
			$qry ="select * from `duty_slip`  where `billing_status`='no'  && `waveoff_status`='0'";
			else {
			$qry="select * from `duty_slip` where ";
			$q2=" and `billing_status`='no' "; }
			$sql=$qry.$q1.$q2;
			$result=mysql_query($sql);
			echo '<table width="100%"  width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <th>SL.</th>
            <th>Duty Slip No.</th>
            <th>Car No.</th>
            <th>Service Name</th>
            <th>Customer Name</th>
            <th>Date</th>
            </tr>
            </thead>
            <tbody>';
			 while($row=mysql_fetch_array($result))
            {$i++;
				if(!empty($row['temp_car_no']))
				{
				$car_no=$row['temp_car_no'];
				}
				else
				{
				$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row['car_id']."'");
				$row_car=mysql_fetch_array($result_car);
				$car_no=$row_car['name'];	
				}
				
					
				$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
				$row_cust=mysql_fetch_array($result_cust);
				$cust_name=$row_cust['name'];
				
				$result_service=mysql_query("select `name` from `service` where `id`='".$row['service_id']."'");
				$row_service=mysql_fetch_array($result_service);
				$service_name=$row_service['name'];
				
				echo  '<tr>
                    <td>'.$i.'</td>
                    <th>'.$row['id'].'</th>
                    <td>'.$car_no.'</td>
                    <td>'.$service_name.'</td>
                    <td>'.$cust_name.'</td>
                    <td>'.date("d-m-Y",strtotime($row['date'])).'</td>
                    </tr>';
			}
			  echo     '</tbody>
            	</table>';
							
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else if($_POST['excel_for']=='pendingdues')
	{
					$q1="";	$q2="";	$q3="";	$q4=" && `waveoff_status`='0' ";
				
					if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
					{	
					$date_from=date("Y-m-d",strtotime($_POST['date_from']));
					$date_to=date("Y-m-d",strtotime($_POST['date_to']));
					$q2=" AND `date` between '".$date_from."' and '".$date_to."' ";
					}
					
					
					if(!empty($_POST['customer_id']))
					{
					$q3=" AND `customer_id` = '".$_POST['customer_id']."' ";
					}  
				
					$type_radio=$_POST['type_radio'];
					if($type_radio=='invoice')
						{
						$q1=" payment_status='no' ";
						$qry=" select `customer_id`,`date`,`grand_total`,`id` from invoice where ";
						}
					else
						{
						$q1=" billing_status='no' ";
						$qry=" select `extra_amnt`,`customer_id`,`date`,`tot_amnt`,`id` from duty_slip where ";
						}
						
						$sql=$qry.$q1.$q2.$q3.$q4;
						$result=mysql_query($sql);
						echo '<table width="100%"  border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
							<thead>
							<tr>
							<th>SL.</th>';
							if($type_radio=="invoice"){
						echo '<th>Invoice No.</th>';  } else { 
						echo  '<th>Duty Slip No.</th>';  } 
						echo   '<th>Customer Name</th>
							<th>Date</th>
							<th>Grand Total</th>';
if($type_radio=='invoice'){?>
            <th>Received Amt.</th>
            <th>Due Amt.</th>
            <?php }
							echo '</tr>
							</thead>
							<tbody>';
						if($type_radio=='invoice')
						{
							while($row=mysql_fetch_array($result))
							{$i++;
								$receive_amnt=0;
						$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$row['id']."' && `due_amnt`>'0'");
						if(mysql_num_rows($check_receipt_detail)>0)
						{
						$row_receipt_detail=mysql_fetch_array($check_receipt_detail);
						$due_amnt=$row_receipt_detail['due_amnt'];
						}
						else
						{
						$due_amnt=$row['grand_total'];
						}
						$receive_amnt=$row['grand_total']-$due_amnt;  
							$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							
						
							
								echo	'<tr>
									<td>'.$i.'</td>
									<th>'.$row['id'].'</th>
									<td>'.$cust_name.'</td>
									<td>'.date("d-m-Y",strtotime($row['date'])).'</td>
									<td>'.$row['grand_total'].'</td>
                                                                        <td>'.$receive_amnt.'</td>
                                                                        <td>'.$due_amnt.'</td>
									</tr>';
								
							 }
						}
						else
					{
					while($row=mysql_fetch_array($result))
					{$i++;
						
							$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row['customer_id']."'");
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							
						
							
							$amount=$row['extra_amnt']+$row['tot_amnt'];
                        	echo '<tr>
							<td>'.$i.'</td>
							<th>'.$row['id'].'</th>
							<td>'.$cust_name.'</td>
							<td>'.date("d-m-Y",strtotime($row['date'])).'</td>
							<td>'.$amount.'</td>
							</tr>';
					 }
					
					}
				echo	'</tbody>
					</table>';
						
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='sales_register')
	{
					
					$date_from=date("Y-m-d",strtotime($_POST['date_from']));
					$date_to=date("Y-m-d",strtotime($_POST['date_to']));
					
					$i=0;$p1=$p2=$p3="";
					$p4=" ORDER BY `customer_id`,`date` ";
					if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
						{
							$p2=" AND  `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
						}
					if(!empty($_POST['customer_id']))
						{
						$p1=" AND `customer_id`='".$_POST['customer_id']."'";
						
						if($p2=="")
							{
								$p1=" AND `customer_id`='".$_POST['customer_id']."'";
							}
						}
						//$p5=" AND `waveoff_status`='0'";
						$p3=" AND `com`='0' ";
						
						$p4=" ORDER BY `customer_id`,`date`";
			$result=mysql_query("select * from `invoice` where (1=1)$p1$p2$p3$p4");	
			echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <th>SL.</th>
			<th>Customer Name</th>
            <th>Date</th>
            <th>Invoice No.</th>
            <th>Total Amount</th>
            <th>TAX</th>
            <th>Discount</th>
            <th>Grand Total</th>
            </tr>
            </thead>
            <tbody>';
							while($row_list=mysql_fetch_array($result))
							{$i++;
							$waveoff_status=$row_list['waveoff_status'];
							if($waveoff_status==0)
							{
									$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row_list['customer_id']."'");
									$row_cust=mysql_fetch_array($result_cust);
									$cust_name=$row_cust['name'];
									
									if(empty($_POST['customer_id']))
									{
									if (in_array(@$row_list['customer_id'], @$data_store)) 
									{
										
									}
									else
									{
									$data_store[]=@$row_list['customer_id'];
									
								echo	'<tr>
									<td colspan="7" style="background-color:#D9EDF7; text-align:center"><b>Customer: '.$cust_name.'</b></td>
									</tr>';
									
									} 
									}
									
									
							  echo '<tr>
									<td>'.$i.'</td>
									<td>'.$cust_name.'</td>
									<td>'.$row_list['date'].'</td>
									<td>'.$row_list['id'].'</td>
									<td>'.$row_list['total'].'</td>
									<td>'.$row_list['tax'].'</td>
									<td>'.$row_list['discount'].'</td>
									<td>'.$row_list['grand_total'].'</td>
									</tr>';
									
									$total+=$row_list['total'];
									$discount+=$row_list['discount'];
									$tax+=$row_list['tax'];
									$grand_total+=$row_list['grand_total'];
								}
							}
							echo '<tr>
                            <th colspan="3" style="text-align:center;">TOTAL AMOUNT</th>
                            <th>'.$total.'</th>
                            <th>'.$tax.'</th>
                            <th>'.$discount.'</th>
                            <th>'.$grand_total.'</th>
                            </tr>';
       echo     '</tbody>
            	</table>';

	}	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='consolidated')
	{
					$i=0;$p1=$p2="";
					$p3=" AND `waveoff_status`='0' ";
					$p4=" AND `com`='0' ";
					$p5=" ORDER BY `customer_id`,`date` ";
					$date_from=date("Y-m-d",strtotime($_POST['date_from']));
					$date_to=date("Y-m-d",strtotime($_POST['date_to']));
					
					if((!empty($_POST['date_from'])) AND (!empty($_POST['date_to'])))
						{
							$p2=" AND  `date` between '".$date_from."' and '".$date_to."' ";
						}
					if(!empty($_POST['customer_id']))
						{
						$p1=" AND `customer_id`='".$_POST['customer_id']."'";
						
						if($p2=="")
							{
								$p1=" AND `customer_id`='".$_POST['customer_id']."' ";
							}
						}
					
					$result=mysql_query("select * from `invoice` where (1=1)$p1$p2$p3$p4$p5");	
					echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
					<thead>
					<tr>
					<th>SL.</th>
					<th>Date</th>
					<th>In.No.</th>
					<th>Ds.No.</th>
					<th>Guest</th>
					<th>Service</th>
					<th>Ds.Amt</th>
					<th>Gross</th>
					<th>TAX</th>
					<th>Discount</th>
					<th>TotalAmt</th>
					</tr>
					</thead>
					<tbody>';
					$grand_amnt=0;
							while($row_list=mysql_fetch_array($result))
							{$i++;
							$count=0;
							$count_sl=0;
							$count_ins=0;
							$count_gross=0;
							$count_tax=0;
							$count_discount=0;
							$count_grand=0;
							$grand_amnt+=$row_list['grand_total'];
							
								$result_cust=mysql_query("select `name` from `customer_reg` where `id`='".$row_list['customer_id']."'");
								$row_cust=mysql_fetch_array($result_cust);
								$cust_name=$row_cust['name'];
								
									if(empty($_POST['customer_id']))
									{
									if (in_array(@$row_list['customer_id'], @$data_store)) 
									{
										
									}
									else
									{
									$data_store[]=@$row_list['customer_id'];
							echo	'<tr>
									<td colspan="11" style="background-color:#D9EDF7; text-align:center"><b>Customer: '.$cust_name.'</b></td>
									</tr>';
									} 
									}
									$result_ins_detail=@mysql_query("select * from `invoice_detail` where `invoice_id`='".$row_list['id']."'");	
							$num_ds=@mysql_num_rows($result_ins_detail);
							while($row_ins_detail=@mysql_fetch_array($result_ins_detail))
							{
								
								$rs_ds=@mysql_query("select `guest_name`,`service_id` from `duty_slip` where `id`='".$row_ins_detail['duty_slip_id']."'");
								while($row_ds=@mysql_fetch_array($rs_ds))
								{
									
							$result_service=mysql_query("select `name` from `service` where `id`='".$row_ds['service_id']."'");
							$row_service=mysql_fetch_array($result_service);
							$service_name = $row_service['name'];
							
							echo '<tr>';
							if(($num_ds!=$count_sl)){ $count_sl=$num_ds;
                            echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.$i.'</td>';
							}
                            
							if(($num_ds!=$count)){ $count=$num_ds; 
                            echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.date("d-m-Y",strtotime($row_list['date'])).'</td>';
							}
							
							if(($num_ds!=$count_ins)){ $count_ins=$num_ds; 
                        
							  echo  '<td rowspan="'.$num_ds.'" style="vertical-align: middle;"><strong>'.$row_list['id'].'</strong></td>';
							}
							
                            echo  '<td style="text-align:center;"><strong>'.$row_ins_detail['duty_slip_id'].'</strong></td>
                            <td>'.$row_ds['guest_name'].'</td>
                            <td>'.$row_ds['service_id'].'</td>
                            <td>'.$row_ins_detail['amount'].'</td>';
							
							if(($num_ds!=$count_gross)){ $count_gross=$num_ds; 
                           echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.$row_list['total'].'</td>';
							}
							
							if(($num_ds!=$count_tax)){ $count_tax=$num_ds;
                           echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.$row_list['tax'].'</td>';
							}
							
							if(($num_ds!=$count_discount)){ $count_discount=$num_ds; 
                           echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.$row_list['discount'].'</td>';
							}
							
							if(($num_ds!=$count_grand)){ $count_grand=$num_ds;
                           echo '<td rowspan="'.$num_ds.'" style="vertical-align: middle;">'.$row_list['grand_total'].'</td>';
							}
							
                           echo  '</tr>';
								}
							}
                            }
                            echo '<tr>
                            <th colspan="10"></th>
                            <th>'.$grand_amnt.'</th>
                            </tr>';
                         echo   '</tbody>
                            </table>';
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='ledger')
	{
		
					$date_from=date("Y-m-d",strtotime($_POST['date_from']));
					$date_to=date("Y-m-d",strtotime($_POST['date_to']));
					$ledger_type_id=$_POST['ledger_type_id'];
					$ledger_name=$_POST['ledger_name'];
					
					$fetch_ledger_master=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='".$ledger_type_id."' && `name`='".$ledger_name."'");
					$row_ledger_master=mysql_fetch_array($fetch_ledger_master);
					$result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` < '".$date_from."' ");
					
					$result_table=mysql_query("select `name` from `ledger_type` where `id`='".$ledger_type_id."'");
					$row_table=mysql_fetch_array($result_table);
					$ledger_name_auto=$row_table['name'];

					echo '<table  width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                    <tr><th colspan="2">Ledger Information </th>
						<th colspan="3">'.$ledger_name_auto.' Ledger from 
							'.date("Y-m-d",strtotime($date_from)).'
						To 
							'.date("Y-m-d",strtotime($date_to)).'
						</th>
						<th colspan="6" >Name : 
							 '.$ledger_name.'
						</th>
						</tr>
						<tr>
						<th colspan="5">&nbsp;</th>
						<th colspan="3">Opening Balance'; 
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								if($row['debit']>0){
								$ntblnce=$ntblnce-($row['debit']-$row['credit']);
								}
								else
								{$ntblnce=$row['credit']+$ntblnce;}
							}
							$opening_bal=$ntblnce;
							abs($opening_bal);
						echo '<th colspan="3">'.abs($opening_bal).'';
						if($opening_bal>0)
								echo " CR";
							else
								echo " DR";
						echo '</td>';
						echo '</tr>';
						echo '<tr>
                        <th>Date</th>
						<th>Invoice/Trans.ID</th>
                        <th>Invoice/Trans.ID Date</th>
                        <th>Guest Name</th>
                        <th>Narration</th>
						<th>Paid To</th>
                        <th>Cheque No.</th>
                        <th>Cheque Date</th>
                        <th>Debit</th>
   						<th>Credit</th>
                        <th>Balance</th>
						</tr>';
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;	
				        $result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` between '".$date_from."' AND '".$date_to."' order by `date`");
						while($row=mysql_fetch_array($result))
						{ 
						
						  echo  '<tr align="center">';
						 echo '<td>'.$row['date'].'</td>';
                            if(!empty($row['invoice_id']))
							{
							$date_invoice=mysql_query("select `date` from `invoice` where `id`='".$row['invoice_id']."'");
							$row_invoice=@mysql_fetch_array($date_invoice);
							if($row_invoice['date']=='1970-01-01')
							{
								$date_to_show='';
							}
							else{
							$date_to_show=$row_invoice['date'];	 }
                       echo     '<td>'; if(!empty($row['invoice_id'])) { echo $row['invoice_id']."(Invoice)"; } 
                            if($row['transaction_type']=='receipt'){ 
                            echo "&nbsp;". $row['transaction_id']."(Receipt)"; 
                           	} 
                            echo '</td>';
							}
							else{
						echo	'<td>';
							if($row['transaction_type']=='jv') {
							$date_to_show=$row['date'];
						  echo  $row['transaction_id']."(JV)"; 
                          }
							else if($row['transaction_type']=='payment'){
								$date_to_show=$row['date'];
							 echo $row['transaction_id']."(Payment)"; } 
							else if($row['transaction_type']=='corporate_billing'){
							$date_cor=mysql_query("select `date` from `corporate_billing` where `id`='".$row['transaction_id']."'");
							$row_cor=@mysql_fetch_array($date_cor);
							$date_to_show=$row_cor['date'];		
							echo $row['transaction_id']; 	} 
                          echo  '</td>';
							}
                          
                         echo   '<td>'.date("d-m-Y",strtotime($date_to_show)).'</td>';
						echo '<td align="left"> ';
						    	$result_invoice= mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$row['invoice_id']."' order by `duty_slip_id`");
						  		$row_temp=mysql_fetch_array($result_invoice);
						    	$result_duty=mysql_query("select `guest_name` from `duty_slip` where `id`='".$row_temp['duty_slip_id']."'");
						  		$row_duty=mysql_fetch_array($result_duty);
                           echo $row_duty['guest_name']; 
						 echo  '</td>';
                         echo   '<td align="left">'.$row['narration'].'</td>';
						 echo '<td align="left">';
						if(!empty($row['credit']))
							{
								if(!empty($row['invoice_id'])&&empty($row['transaction_id'])&&(empty($row['transaction_id'])))
								{
								$ref_amnt="select `name` from `ledger` where `debit`>'0' && `invoice_id`='".$row['invoice_id']."' ";	
								}
								else if(!empty($row['transaction_type'])&&!empty($row['transaction_id'])&&empty($row['invoice_id']))
								{
								$ref_amnt="select `name` from `ledger` where `debit`>'0' && `transaction_type`='".$row['transaction_type']."' && `transaction_id`='".$row['transaction_id']."'";			}
								else
								{
							$ref_amnt="select `name` from `ledger` where `debit`='".$row['credit']."' && `date` between '".($date_from)."' AND '".($date_to)."' ";	
								}
							}
							else if(!empty($row['debit']))
							{
								if(!empty($row['invoice_id'])&&empty($row['transaction_id'])&&(empty($row['transaction_id'])))
								{
								$ref_amnt="select `name` from `ledger` where `credit`>'0' && `invoice_id`='".$row['invoice_id']."' ";	
								}
								else if(!empty($row['transaction_type'])&&!empty($row['transaction_id'])&&empty($row['invoice_id']))
								{
								$ref_amnt="select `name` from `ledger` where `credit`>'0' && `transaction_type`='".$row['transaction_type']."' && `transaction_id`='".$row['transaction_id']."'";		
								}
								else
								{
								$ref_amnt="select `name` from `ledger` where `credit`='".$row['debit']."' && `date` between '".($date_from)."' AND '".($date_to)."' ";	
								}
							}
							$query=@mysql_query($ref_amnt);
							$all_name="";
							$row_ref_amnt=@mysql_fetch_array($query);
							echo $row_ref_amnt['name'];
							echo '</td>';
                         	echo  '<td>'.$row['cheque_no'].'</td>';
							if($row['cheque_date']=='0000-00-00')
							{
								$ch_date="-";
							}
							else
							{
								$ch_date=date("d-m-Y",strtotime($row['cheque_date']));
							}
                         echo   '<td>'.$ch_date.'</td>';
						echo	'<td>'.abs($row['debit']).'</td>
                           	<td>'.abs($row['credit']).'</td>';
							$cr+=$row['credit'];
							$db+=$row['debit'];
							
							if($row['debit']>0){ $ntblnce=$ntblnce-($row['debit']-$row['credit']); }else { $ntblnce=$row['credit']+$ntblnce;}
						echo	'<td>';
						 echo abs($ntblnce); 
							if($ntblnce>0)
								echo " CR";
							else
								echo " DR";
						echo	'</td>
							</tr>';
						}
					echo	'<tr ><th colspan="8" >&nbsp;</th>
						<th>'.$db.'</th>
						<th>'.$cr.'</th>
						<th>';
						 echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " CR";
							else
								echo " DR";
						echo '</th>';
						echo '</tr>';
                        echo '<tr><td colspan="11">&nbsp;</td></tr>
						<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Opening Balance:</th><th>';
						 echo $opening_bal;
						if($opening_bal>0)
								echo " CR";
							else
								echo " DR";
						echo '</th></tr>';
						echo '<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Total Debits:</th><th>';
						 echo $db." DR";
						 echo '</th></tr>';
						echo '<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Total Credits:</th><th>';
						 echo $cr." CR";
						 echo '</th></tr>';
						echo '<tr ><td colspan="8">&nbsp;</td>
                        <th colspan="2">Closing Balance:</th><th>';
						 echo abs($ntblnce);
						if($ntblnce>0)
							echo " CR";
						else
							echo " DR"; 
						echo '</th></tr>
						</table>';
	
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='fule')
{
							$q1=""; $q2="";  $temp=0;
							
							$date_from=date("Y-m-d",strtotime($_POST['date_from']));
							$date_to=date("Y-m-d",strtotime($_POST['date_to']));
							
			 				if(!empty($_POST['car_id']))
							{
							$car_id=$_POST['car_id'];
							$q1=" `car_id` = '".$car_id."' ";
							}
							if(!empty($_POST['date_from']) && !empty($_POST['date_to']))
							{
								if($q1=="")
								{
									$q2=" `date` between '".$date_from."' and '".$date_to."' ";
								}
								else
								{
									$q2=" AND `date` between '".$date_from."' and '".$date_to."' ";
								}
							}
							if($q1=="" && $q2=="")
							$qry ="select * from `fuel` ";
							else 
							$qry="select * from `fuel` where ";
							$sql=$qry.$q1.$q2;
 							$result=mysql_query($sql);
							echo '<table border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
							<thead>
							<tr>
							<th >S.No.</th>
							<th >Supplier Name</th>
							<th >Date</th>
							<th >Car No.</th>
							<th >Pre. Reading</th>
							<th >Cur. Reading</th>
							<th >Fuel Type</th>
							<th >Fuel Qty</th>
							<th >Fuel Amount</th>
							<th >Approx. Mileage</th>
							<th >Remarks</th>
							</tr>
							</thead>
							<tbody>';
							while($row=mysql_fetch_array($result))
							{$i++;
							$fuel_qty=$row['fuel_qty'];
							$red_diff=$row['closing_km']-$row['opening_km'];		
							$mileage=($red_diff);
							$temp=$fuel_qty;
								
							$result_supplier=mysql_query("select `name` from `supplier_reg` where `id`='".$row['supplier_id']."'");
							$row_supplier=mysql_fetch_array($result_supplier);
							$supplier_name=$row_supplier['name'];
							
							$result_car=mysql_query("select `name` from `car_reg` where `id`='".$row['car_id']."'");
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];	

							echo '<tr>
							<td>'.$i.'</td>
							<th>'.$supplier_name.'</th>
							<td>'.date("d-m-Y",strtotime($row['date'])).'</td>
							<td>'.$car_name.'</td>
							<td>'.$row['opening_km'].'</td>
							<td>'.$row['closing_km'].'</td>
							<td>'.$row['fuel_type'].'</td>
							<td>'.$row['fuel_qty'].'</td>
							<td>'.$row['fuel_amount'].'</td>
							<td>'.round($mileage,2).'</td>       
							<td>'.$row['remarks'].'</td>                
							</tr>';
							}
							echo ' </tbody>
							</table>';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='corporate')
{
				$q1="";	$q2="";	$q3="";	$q4="";
				if(!empty($_POST['id']))
				{
					$id=$_POST['id'];
					$q1="id='".$id."'";
				}
				if(!empty($_POST['customer_id']))
				{
					$customer_id=$_POST['customer_id'];
					if($q1=="")
						$q2=" customer_name='".$customer_id."'";
					else 
						$q2=" AND customer_name='".$customer_id."'";
				}
				if(!empty($_POST['date']))
				{
					$date=date("Y-m-d",strtotime($_POST['date']));
					if($q1=="" && $q2=="")
						$q3=" date='".$date."'";
					else 
						$q3=" AND date='".$date."'";
				}
	
                if($q1=="" && $q2=="" && $q3=="")
				{
                	$qry ="select * from `corporate_billing`";
				//	$q4= " where `waveoff_status`!='1' ";
				}
                else    {
						$qry="select * from `corporate_billing` where ";
					//	$q4=" and `waveoff_status`!='1' ";
						}
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
				  echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                   		<thead>
                        <tr>
                        <th>SL.</th>
                        <th>Date</th>
                       	<th>Invoice No.</th>
                        <th>Customer Name</th>
                        <th>Guest Name</th>
                        <th>Grand Total</th>
						</tr>';
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                       		 $idd=$row['id'];
						echo'<tr>
                            <td>'.$i.'</td>
                            <td>'.$row['date'].'</td>
                            <th>'.$row['id'].'</th>
                          	<td>'.$row['customer_name'].'</td>
                            <td>'.$row['guest_name'].'</td>
                            <td>'.$row['net_amnt'].'</td>';
						}
					}
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='jv')
{
					$q1="";	$q2="";	$q3="";	
					if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
					{
					$date_from=date("Y-m-d",strtotime($_POST['date_from']));
				 	$date_to=date("Y-m-d",strtotime($_POST['date_to']));
					$q1=" `date` between '".$date_from."' and '".$date_to."' ";
					}
					
					if(!empty($_POST['journal_id']))
					{
					if($q1=='')	
					$q2="  `transaction_id` = '".$_POST['journal_id']."' ";
					else
					$q2=" AND `transaction_id` = '".$_POST['journal_id']."' ";
					}  
				   
				 
				   if($q1=='' && $q2=='')
				   {
					   $qry=" select * from ledger ";
					     $q3=" where `transaction_type`='jv'";
				   }
				   else 
				   {
					   $qry=" select * from ledger where ";
					     $q3=" AND `transaction_type`='jv'";
				   }
				  	$sql=$qry.$q1.$q2.$q3;
					$result=mysql_query($sql);
					echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
					<thead>
					<tr>
					<th >SL.</th>
					<th >Journal ID</th>
					<th >Ledger Type</th>
					<th >Ledger Name </th>
					<th >Credit</th>
					<th >Debit</th>
					<th >JV Date</th>
					<th >Current Date</th>
					<th >Narration</th>
					</tr>
					</thead>
					<tbody>';
					while($row=mysql_fetch_array($result))
                     	{
							$i++;
							$transaction_id=$row['transaction_id'];
							$res_trans=mysql_query("select `id` from `ledger` where `transaction_id`='".$transaction_id."' && `transaction_type`='jv'");
							$num_trans=mysql_num_rows($res_trans);
							$ledger_master_id=$row['ledger_master_id'];
							$name=$row['name'];
							$credit=$row['credit'];
							$debit=$row['debit'];
							$date=$row['date'];
							$current_date=$row['current_date'];
							$narration=$row['narration'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
							
							$result_table=mysql_query("select `name` from `ledger_type` where `id`='".$ledger_type_id."'");
							$row_table=mysql_fetch_array($result_table);
							$l_name=$row_table['name'];
                          echo  '<tr>
                            <td>'.$i.'</td>
                            <th>'.$transaction_id.'</th>
                            <td>'.$l_name.'</td>
                            <td>'.$name.'</td>
                            <td>'.$credit.'</td>
                            <td>'.$debit.'</td>
                            <td>'.dateforview($date).'</td>
                            <td>'.dateforview($current_date).'</td>
                            <td>'.$narration.'</td>
                            </tr>';
                   	}
                   echo    '</tbody>
                      </table>';
					
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='payment')
{
				$q1="";	$q2="";	$q3=" ";	
				if(!empty($_POST['payment_id']))
				{
					$payment_id=$_POST['payment_id'];
					$q1="transaction_id='".$payment_id."'";
				}
				if(!empty($_POST['date_from'])&&!empty($_POST['date_to']))
				{
					$date_from=datefordb($_POST['date_from']);
					$date_to=datefordb($_POST['date_to']);
					if($q1=="")
					$q2=" `date` between '".$date_from."' and  '".$date_to."' ";
					else
					$q2=" AND `date` between '".$date_from."' and  '".$date_to."' ";
				 }
                if($q1=="" && $q2=="" ){
                	$qry ="select * from ledger";
					$q3=" where `transaction_type`='payment'  AND `debit`!='0' ";}
                else    {
					$qry="select * from ledger where ";
					$q3=" AND `transaction_type`='payment'  AND `debit`!='0' "; }
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
						echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
						<thead>
						<tr>
                       	<th>Sl.</th>
                       	<th>Date</th>
                       	<th>Payment ID</th>
                        <th>Name</th>
                        <th>Narration</th>
                        <th>Amount</th>
						</tr>
						</thead>
						<tbody>';
						 while($row=mysql_fetch_array($result))
                        {	$i++;
                        	$idd=$row['transaction_id'];
							$ledger_master_id=$row['ledger_master_id'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
							echo '<tr>
                            <td>'.$i.'</td>
                            <td>'.dateforview($row['date']).'</td>
                            <th>'.$row['transaction_id'].'</th>
                            <td>'.$name.'</td>
                            <td>'.$row['narration'].'</td>
                            <td>'.$row['debit'].'</td>
							</tr>';
						}
						}
                echo    '</tbody>
                    	</table>';   
						
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='receipt')
{
				$q1="";	$q2="";	$q3=" ";	
				if(!empty($_POST['receipt_id']))
				{
					$receipt_id=$_POST['receipt_id'];
					$q1="transaction_id='".$receipt_id."'";
				}
				if(!empty($_POST['date_from'])&&!empty($_POST['date_to']))
				{
					$date_from=datefordb($_POST['date_from']);
					$date_to=datefordb($_POST['date_to']);
					if($q1=="")
					$q2=" `date` between '".$date_from."' and  '".$date_to."' ";
					else
					$q2=" AND `date` between '".$date_from."' and  '".$date_to."' ";
				 }
                if($q1=="" && $q2=="" ){
                	$qry ="select * from ledger";
					$q3=" where `transaction_type`='receipt'  AND `credit`!='0' ";}
                else    {
					$qry="select * from ledger where ";
					$q3=" AND `transaction_type`='receipt'  AND `credit`!='0' "; }
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
						echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">  
						<thead>
                        <tr>
                       	<th>Sl.</th>
                       	<th>Date</th>
                       	<th>Receipt ID</th>
                        <th>Name</th>
                        <th>Narration</th>
                        <th>Amount</th>
						</tr>
						</thead>';	
                        while($row=mysql_fetch_array($result))
                        {	$i++;
                        	$idd=$row['transaction_id'];
							$ledger_master_id=$row['ledger_master_id'];
							$result_ledger=mysql_query("select `ledger_type_id`,`name` from `ledger_master` where `id`='".$ledger_master_id."'");
							$row_ledger=mysql_fetch_array($result_ledger);
							$name=$row_ledger['name'];
							$ledger_type_id=$row_ledger['ledger_type_id'];
							echo '<tr>
                            <td>'.$i.'</td>
                            <td>'.dateforview($row['date']).'</td>
                            <th>'.$row['transaction_id'].'</th>
                            <td>'.$name.'</td>
                            <td>'.$row['narration'].'</td>
                            <td>'.$row['credit'].'</td>
							</tr>';
						}
						}
						 echo    '</tbody>
                    	</table>';  
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='profit')
{
	
						echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">  
                      
                      <tr>
                      <th colspan="2" style="text-align:center;">PROFIT & LOSS ACCOUNT <br/>'.dateforview($_POST['date_from']).' To '.dateforview($_POST['date_to']).' </th>
                      </tr>
                    
                        <tr>
                        <td width="50%" style="border-right:#DDDDDD 2px solid;">
                        <table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                        <tr>
                        <th>Particulars</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">To Indirect Exp</th>
                        </tr>';
						$res_income=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_income=mysql_fetch_array($res_income))
						{
							$temp=0;
							$res_income_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_income['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_income_credit=mysql_fetch_array($res_income_credit))
							{
								$temp=$row_income_credit['credit']-$row_income_credit['debit']+$temp;
							}
								$all_cr+=$temp;
						}

						$result_left=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Expense'");
						while($row_left=mysql_fetch_array($result_left))
						{
							$flag_expense=0;
							$result_debit=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_left['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_debit=mysql_fetch_array($result_debit))
							{
								$flag_expense=$row_debit['debit']-$row_debit['credit']+$flag_expense;
							}
								$all_exp+=$flag_expense;
							if($flag_expense>0||$flag_expense<0)
							{
                         echo   '<tr>
                            <td>'.$row_left['name'].'</td>
                            <td>'.$flag_expense.'</td>
                            <td>&nbsp;</td>
                            </tr>';
							}
						}
						$profit=$all_cr-$all_exp;
                  echo      '<tr>
                        <th colspan="2">Total</th>
                        <th>'.$all_exp.'</th>
                        </tr>
                        <tr  style="background-color:#DFF0D8;">
                        <th colspan="2">NET PROFIT</th>
                        <th>'.$profit.'</th>
                        </tr>
                        </table>
                        </td>
                       
                        <td width="50%">
                        <table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                        <tr>
                        <th>Particulars</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">By Direct Income</th>
                        </tr>';
						$result_right=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_right=mysql_fetch_array($result_right))
						{
							$ntblnce=0;
							$result_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_right['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_credit=mysql_fetch_array($result_credit))
							{
								$ntblnce=$row_credit['credit']-$row_credit['debit']+$ntblnce;
							}
								$all_bal+=$ntblnce;
                      echo  	'<tr>
                            <td>'.$row_right['name'].'</td>
                            <td>'.$ntblnce.'</td>
                            <td>&nbsp;</td>
                            </tr>';
						}
                     echo   '<tr>
                        <th colspan="2">Total</th>
                        <th>'.$all_bal.'</th>
                        </tr>
                        </table>
                        </td>
                        </tr>
                        <tr>
                        <th style="text-align:right;">'.$all_exp+$profit.'</th>
                        <th style="text-align:right;">'.$all_bal.'</th>
                        </tr>  
                       	</table>';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='balancesheet')
{
		echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0"> 
                      <tr>
                      <th colspan="2" style="text-align:center;">BALANCE SHEET AS ON '.dateforview($_POST['date_to']).' </th>
                      </tr>
                    
                        <tr>
                        <td width="50%" style="border-right:#DDDDDD 2px solid;">
                        <table width="100%"  border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                        <tr>
                        <th>Liabities</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">Capital Account</th>
                        </tr>';

					  $res_income=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_income=mysql_fetch_array($res_income))
						{
							$temp=0;
							$res_income_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_income['id']."'");
							while($row_income_credit=mysql_fetch_array($res_income_credit))
							{
								$temp=$row_income_credit['credit']-$row_income_credit['debit']+$temp;
							}
								$all_cr+=$temp;
						}

						$result_left=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Expense'");
						while($row_left=mysql_fetch_array($result_left))
						{
							$flag_expense=0;
							$result_debit=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_left['id']."'");
							while($row_debit=mysql_fetch_array($result_debit))
							{
								$flag_expense=$row_debit['debit']-$row_debit['credit']+$flag_expense;
							}
								$all_exp+=$flag_expense;
						}
   					   $profit=$all_cr-$all_exp;
					   $repeat=0;
					   $result_asset1=mysql_query("select * from `ledger_master` where `group_belongs_to`='B/S-Liabities' ORDER BY `ledger_type_id`");
						while($row_asset1=mysql_fetch_array($result_asset1))
						{$repeat++;
										
										$result_ledger=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_asset1['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";										
										while ($row_ledger=mysql_fetch_array($result_ledger)) {
										$ntblnce=$row_ledger['debit']-$row_ledger['credit']+$ntblnce;
										}										
										
									$inner=mysql_query("select  `ledger_type_id` from `ledger_master` where `id`='".$row_asset1['id']."' ");
									$row_inner = mysql_fetch_array($inner);
									$ledger_type_id = $row_inner['ledger_type_id'];
									if($ledger_type_id!=$ledger_type_id_test)
									{
									$ledger_type_id_test=$ledger_type_id;
									
									$result_ltype=mysql_query("select `name` from `ledger_type` where `id`='".$ledger_type_id."'");
									$row_ltype=mysql_fetch_array($result_ltype);
									$ltypename=$row_ltype['name'];

								echo	'<tr>
									<td colspan="3" style="background:#F2DEDE;">'.$ltypename.'</td>
									</tr>';
									}
									
									$result=mysql_query("select `credit`,`debit` From `ledger` where  `ledger_master_id`='".$row_asset1['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");		
												
											while($row=mysql_fetch_array($result))
											{ 
												$cr+=$row['credit'];
												$db+=$row['debit'];
												$all_credit+=$row['credit'];
												$all_debit+=$row['debit'];
												$ntblnce=$row['debit']-$row['credit']+$ntblnce;
											}				
											$all_lib+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if($all_lib>0)
											$extend_1=" DR";
											else
											$extend_1=" CR";
							if(abs($ntblnce)!=0)	
							{			
						echo	'<tr>
								<td>'.$row_asset1['name'].'</td>
								<td>'.abs($ntblnce).$extend.'</td>
								<td>&nbsp;</td>
								</tr>';
							}
						}
                   echo     '<tr>
                        <th colspan="2">Total</th>
                        <th>'.abs($all_lib).$extend_1.'</th>
                        </tr>
                         <tr>
                        <th colspan="2">Opening Capital</th>
                        <th>0</th>
                        </tr>
                         <tr>
                        <th colspan="2">Profit</th>
                        <th>'.$profit.'</th>
                        </tr>
                        </table>
                        </td>
                       
                        <td width="50%">
                        <table width="100%"  border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0">
                        <tr>
                        <th>Assets</th>
                        <th colspan="2">Amount</th>
                        </tr>';
						$result_right=mysql_query("select * from `ledger_master` where `group_belongs_to`='B/S-Assets'  ORDER BY `ledger_type_id`");
						while($row_right=mysql_fetch_array($result_right))
						{
										
										
										$result_ledger_r=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_right['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";										
										while ($row_ledger_r=mysql_fetch_array($result_ledger_r)) {
										$ntblnce=$row_ledger_r['debit']-$row_ledger_r['credit']+$ntblnce;
										}	
										
										$inner=mysql_query("select  `ledger_type_id` from `ledger_master` where `id`='".$row_right['id']."' ");
										$row_inner = mysql_fetch_array($inner);
										$ledger_type_id = $row_inner['ledger_type_id'];
										if($ledger_type_id!=$ledger_type_id_test)
										{
											$ledger_type_id_test=$ledger_type_id;
                                     echo   '<tr>
                                        <td colspan="3" style="background:#F2DEDE;">'.fetchledgertype_name($ledger_type_id).'</td>
                                        </tr>';
										}
										
																			
									$result_a=mysql_query("select `credit`,`debit` From `ledger` where  `ledger_master_id`='".$row_right['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");													
											while($row_a=mysql_fetch_array($result_a))
											{ 
												$cr+=$row_a['credit'];
												$db+=$row_a['debit'];
												$all_credit+=$row_a['credit'];
												$all_debit+=$row_a['debit'];
												$ntblnce=$row_a['debit']-$row_a['credit']+$ntblnce;
											}				
											$all_lib_+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if($all_lib_>0)
											$extend_1=" DR";
											else
											$extend_1=" CR";
							if(abs($ntblnce)!=0)
							{				
                       echo 	'<tr>
                            <td>'.$row_right['name'].'</td>
                            <td>'.abs($ntblnce).$extend.'</td>
                            <td>&nbsp;</td>
                            </tr>';
							}
						}
                  echo      '<tr>
                        <th colspan="2">Total</th>
                        <th>'.$all_lib_.$extend_1.'</th>
                        </tr>
                       	</table>
                        </td>
                        </tr>
                        <tr>
                        <th style="text-align:right;">'.$all_lib+$profit+($all_lib_-($profit+$all_lib)).'</th>
                        <th style="text-align:right;">'.$all_lib_.'</th>
                        </tr>  
                        </table>';
					                      
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
else if($_POST['excel_for']=='trialbalance')
{
							echo '<table width="100%" border="1" style="border-collapse:collapse;"  bordercolor="#10A062" cellpadding="0" cellspacing="0"> 
                     		<tr>
                            <th colspan="5" style="text-align:center;">TRIAL BALANCE FROM '.dateforview($_POST['date_from']).' To '.dateforview($_POST['date_to']).' </th>
                            </tr>
                            <tr>
                            <th>Perticulars</th>
                            <th>Opening Bal.</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Closing Bal.</th>
                            </tr>';
							$all_credit=0;
							$all_debit=0;
							$result_ledger_type=mysql_query("select * from `ledger_type` order by `id`");
							while($row_ledger_type=mysql_fetch_array($result_ledger_type))
							{
							
                            echo    '<tr>
                                <td colspan="5" style="background-color:#FFFFCC;">
                               '.$row_ledger_type['name'].'
                                </td>
                                </tr>';
								
                                    $result_ledger_master=mysql_query("select * from `ledger_master` where `ledger_type_id`='".$row_ledger_type['id']."' order by id");	
                                    while($row_ledger_master=mysql_fetch_array($result_ledger_master))
                                    {
										$result_ledger=mysql_query("select * from `ledger` where `ledger_master_id`='".$row_ledger_master['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");
										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";
										
										while ($row_ledger=mysql_fetch_array($result_ledger)) {
										$ntblnce=$row_ledger['debit']-$row_ledger['credit']+$ntblnce;
										}
										$opening_bal=$ntblnce;
										abs($opening_bal);
										if($opening_bal>0)
										$extend_opening=" DR";
										else
										$extend_opening=" CR";
										
										$cr=0;
										$db=0;
										$ntblnce=$opening_bal;	
									$result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");		
										while($row=mysql_fetch_array($result))
											{ 
												$cr+=$row['credit'];
												$db+=$row['debit'];
												$all_credit+=$row['credit'];
												$all_debit+=$row['debit'];
												$ntblnce=$row['debit']-$row['credit']+$ntblnce;
											}
											$all_ntblnce+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if(($cr>0)||($db>0)||($opening_bal>0)||($opening_bal<0))
											{
											
										echo	'<tr>
											<td>'.$row_ledger_master['name'].'</td>
											<td>'.abs($opening_bal).$extend_opening.'</td>
											<td>'.$db.'</td>
											<td>'.$cr.'</td>
											 <td>'.abs($ntblnce).$extend.'</td>
											</tr>';
											}
                                    }
							}
						
                         echo   '<tr>
                            <th colspan="2">Total:</th>
                            <th>'.round($all_debit).'</th>
                            <th>'.round($all_credit).'</th>
                            <th>'.round($all_ntblnce).'</th>
                            </tr>
                        	</table>';
}
