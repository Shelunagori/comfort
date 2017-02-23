<?php
require 'classes/databaseclasses/DataBaseConnect.php';
header('Content-Type: application/force-download');
header("Pragma: ");
header("Cache-Control: ");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.xls");
date_default_timezone_set('asia/kolkata');
					 if($_GET['type']=='fule_report')
					{
						?>
						<table width="100%" border="1" style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
                        <tr>
                        <td colspan="11" align="center"><b>Fuel Report From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_to'])); ?></b></td>
                        </tr>
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
                    <tbody>
                     <?php           
			   	$temp=0;
					$qry="select * from `fuel` where 
					`car_number`='".$_GET['car_number']."'
					 or `date` between '".$_GET['date_from']."' and '".$_GET['date_to']."' order by `date`
					";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$supplier_name=$row['supplier_name'];
							$date=$row['date'];
							$car_number=$row['car_number'];
							$opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $fuel_qty=$row['fuel_qty'];
                            $fuel_amount=$row['fuel_amount'];
					        $fuel_type=$row['fuel_type'];
	                        $remarks=$row['remarks'];	
							$red_diff=$closing_km-$opening_km;		
							$mileage=floatval($red_diff/$temp);
							$temp=$fuel_qty;
							
                       ?>
                             <tr class="ad">
                            <td><?php echo $i;?></td>
                            <td><?php echo $supplier_name;?></td>
                            <td><?php echo date("d-M-Y",strtotime($date));?></td>
                            <td><?php echo $car_number;?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                             <td><?php echo $fuel_type;?></td>
                            <td><?php echo $fuel_qty;?></td>
                             <td><?php echo $fuel_amount;?></td>
                               <td><?php echo round($mileage,2); ?></td>        <!-- floor  will set like 2.9 will be 2 as o/p-->
                             <td><?php echo $remarks; ?></td>                     <!-- ceil  will set like 4.3 will be 5 as o/p-->
                                                                                   <!-- round  will set like 4.4567 to 4.45 by floor(var,digit to be show)-->
                            </tr>
                        <?php
                        }
                        }
					?>
                      </tbody>
                    </table>   
                    <?php
					}
					else if($_GET['type']=='missing')
						{
					    $p1=$p2=$p3="";
						if(!empty($_GET['car_no']))
							{
							$p1=" AND car_reg_name='".$_GET['car_no']."'";
							}
						if((!empty($_GET['date_from'])) AND (!empty($_GET['date_to'])))
							{
								$p2=" AND  `current_date` between '".DateExact($_GET['date_from'])."' and  '".DateExact($_GET['date_to'])."' ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
							}
						if(!empty($_GET['car_no']))
							{
							$p1=" AND car_reg_name='".$_GET['car_no']."'";
							if($p2=="")
								{
									$p1=" AND car_reg_name='".$_GET['car_no']."' ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
								}
							}
						if($p1=="" AND $p2=="")
							{
								$p3=" ORDER BY  `car_reg_name`, `current_date`, `opening_km`";
							}
					$mydatabase = new DataBaseConnect();
						
						$result= $mydatabase->execute_query_return("select * from `duty_slip` where (1=1)$p1$p2$p3");
						?>
					<?php $row=mysql_fetch_array($result);
					
					$temp=0; $tt=0; $i=0; $tot=0; $ch=$k=0;
					?>
					
					<br/>
					
						
						<?php
						$car_no="";
						while($row=mysql_fetch_array($result))
						{
						$carname_master_id =  $row['carname_master_id'];
						$car_reg_name =  $row['car_reg_name'];
							
						$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
						$data_base_object = new DataBaseConnect();
						$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
						$row_carid = mysql_fetch_array($result_carid);
						$car_reg_name_new=$row_carid['name'];
						
					    $qry_carname="select * from `carname_master` where `id`='$carname_master_id'";
						$data_base_object = new DataBaseConnect();
						$result_car = $data_base_object->execute_query_return($qry_carname);
						$row_car=mysql_fetch_array($result_car);
						$car_name=$row_car['name'];			
							if($row['car_reg_name']!=$car_no)
								{ 
								if($ch != 0)
								{
								?>
									</table>
								<?php
									} 
								
							?>
                        <table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px;">
						<tr><td colspan="8" style="text-align:center;"><b>Report of Missing Km. From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> </b></td></tr>
						<tr><td colspan="8" style="text-align:center;"><b>Car No. </b><?php echo $car_reg_name_new?></td></tr>
						<tr><td colspan="8" style="text-align:center;"><b>Car Name </b><?php echo $car_name;?></td></tr>
						<tr>
						<th>Sr. No.</th>
						<th>Driver Name</th>
						
						<th>Date</th>
						<th>Closing KM.</th>
							<th>Driver Name</th>
						<th>Date</th>
						<th>Opening KM.</th>
							
						<th>Missing KM.</th>
						</tr>
						
							
							<?php $ch++;	
									
						$car_no=$row['car_reg_name'];
						$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
						$data_base_object_driver = new DataBaseConnect();
						$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
						$row_driver=mysql_fetch_array($result_driver);
						$driver_name_main=$row_driver['name'];		
							}
						
							if($tt==0)
								{
								$temp_t=$row['closing_km'];
								 $date_close_t=date("d-M-Y", strtotime($row['current_date']));
								$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
								$data_base_object_driver = new DataBaseConnect();
								$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
								$row_driver=mysql_fetch_array($result_driver);
								$driver_name_main_t=$row_driver['name'];	
								$driver_close_t =  $driver_name_main_t;
								$tt++;
								}
							else
								{
								 $tot=$row['opening_km']-$temp_t;
								
								$temp=$row['closing_km'];
								 $date_close=date("d-M-Y", strtotime($row['current_date']));
								 	$qry_drivername="select * from `driver_reg` where `driver_id`='".$row['driver_reg_driver_id']."'";
								$data_base_object_driver = new DataBaseConnect();
								$result_driver = $data_base_object_driver->execute_query_return($qry_drivername);
								$row_driver=mysql_fetch_array($result_driver);
								$driver_name_main_close=$row_driver['name'];	
								$driver_close =  $driver_name_main_close;
								}
							if($tot != 0)
								{
								
							$i++;
						?>
						<tr>
						
						<td><?php echo $i;?></td>			
						<td><?php echo $driver_close_t;?></td>
						<td><?php echo $date_close_t; ?></td>
						<td><?php echo $temp_t;?></td>
							<td><?php echo $driver_close; ?></td>
						<td><?php echo date("d-M-Y", strtotime($row['current_date']));?></td>
						<td><?php echo $row['opening_km'];?></td>
						
						<td><?php 
							
								echo $tot;
								
						
							?></td>
						</tr>				
						<?php
								$temp_t=$temp;
								$date_close_t=$date_close;
								$driver_close_t=$driver_close;
								}
						}
						?>
						</table>
					<?php
						}
						else if($_GET['type']=="open_ds")
						{
							 $mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip` where  `closing_km`='0'   ORDER BY `current_date` ASC");
				$i=0;
   ?>
						<table  width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px">
                        <thead>
							<tr><td colspan="8" align="center"><b>Report of Open DS. dated on <?php echo date("d-M-Y") ?></b></td></tr>
						<tr>
                        <th>Sr. No.</th>
                        <th>Duty Slip No.</th>
						<th>Car No.</th>
						<!--<th>Car Name</th>-->
						<th>Service Name</th>
						<th>Customer Name</th>
						<th>Date</th>
						<th>Opening KM.</th>
						<th>Closing KM.</th>
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
						while($row=mysql_fetch_array($result))
						{
						 $i++;
						$dutyslip_id =  $row['dutyslip_id'];
						
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
	
						
						$service_service_id = $row['service_service_id'];
						$qry="select * from `service` where `service_id`='$service_service_id'";
						$data_base_object1 = new DataBaseConnect();
						$result_service = $data_base_object1->execute_query_return($qry);
						$row_service=mysql_fetch_array($result_service);
						$service_name=$row_service['name'];
						
						$customer_reg_name =$row['customer_reg_name'];
						$qry_cust="select * from `customer_reg` where `id`='$customer_reg_name'";
						$result_cust = $data_base_object->execute_query_return($qry_cust);
						$row_customer=mysql_fetch_array($result_cust);
						$customer_name=$row_customer['name'];
						$opening_km = $row['opening_km'];
						$closing_km =$row['closing_km'];
						?>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['dutyslip_id'];?></td>
						<td><?php echo $car_reg_name_new;?></td>
						<!--<td><?php // echo $row['carname_master_id'];?></td>-->					
						<td><?php echo $service_name ?></td>
						<td><?php echo $customer_name?></td>
						<td><?php echo date("d-M-Y", strtotime($row['current_date']));?></td>
						<td><?php echo $row['opening_km'];?></td>
						<td><?php echo $row['closing_km'];?></td>
						</tr>				
						<?php
						}
						?>
                        </tbody>
						</table>
                        <?php
						}
						else if($_GET['type']=='unbilled')
						{
							$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip`   where  `status`='no'  ORDER BY `current_date` ASC");
				$i=0;
						?>
						<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px">
							 <thead><tr><td colspan="6" align="center"><b>Report of Unbilled DS. dated on <?php echo date("d-M-Y") ?></b></td></tr>  
						<tr>
						<th>Sr. No.</th>
						<th>Duty Slip</th>
						<th>Date</th>						
						<th>Car Number</th>
						<th>Customer Name</th>
						<th>Service</th>
						</tr>
                        </thead>
                        <tbody>
                        	<tr>
						<?php
						while($row=mysql_fetch_array($result))
						{ $i++;
						$service_service_id = $row['service_service_id'];
						$qry="select * from `service` where `service_id`='$service_service_id'";
						$data_base_object = new DataBaseConnect();
						$result_service= $data_base_object->execute_query_return($qry);
						$row_service=mysql_fetch_array($result_service);
						$service_name=$row_service['name'];
						$customer_reg_name =$row['customer_reg_name'];
						$qry_cust="select * from `customer_reg` where `id`='$customer_reg_name'";
						$data_base_object = new DataBaseConnect();
						$result_cust = $data_base_object->execute_query_return($qry_cust);
						$row_customer=mysql_fetch_array($result_cust);
						$customer_name=$row_customer['name'];
						$car_reg_name = $row['car_reg_name'];
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
						
						?>				
						<td><?php echo $i; ?></td>
						<td><?php echo $row['dutyslip_id'];?></td>
						<td><?php echo date("d-M-Y", strtotime($row['current_date']));?></td>
						<td><?php echo $car_reg_name_new;?></td>
						<td><?php echo $customer_name;?></td>
						<td><?php echo $service_name;?></td>
						</tr>				
						<?php
						}
						?>
                        </tbody>
						</table>
                        <?php
						}
						else if($_GET['type']=='deleted_dutyslip')
						{
						
                        	 $mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `duty_slip_waveoff` where `date_from` >= '".$_GET['date_from']."' and  `date_to`<= '".$_GET['date_to']."' ");
						?>
						<table  width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:20px">
                        <tr>
                        <td colspan="10" align="center"><b>Waveoff Dutyslip From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_to'])); ?></b></td>
                        </tr>
                        <thead>
						<tr>
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
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['dutyslip_id'];
							$current_date=$row['current_date'];
							$billing_name=$row['guest_name'];
							$customer_reg_name = $row['customer_reg_name'];
							$qry="select * from `customer_reg` where `id`='$customer_reg_name'";
							$data_base_object = new DataBaseConnect();
							$result_cust= $data_base_object->execute_query_return($qry);
							$row_cust=mysql_fetch_array($result_cust);
							$cust_name=$row_cust['name'];
							$service_service_id=$row['service_service_id'];
							$qry_service="select * from `service` where `service_id`='$service_service_id'";
							$data_base_object = new DataBaseConnect();
							$result_service= $data_base_object->execute_query_return($qry_service);
							$row_service=mysql_fetch_array($result_service);
							$service_name=$row_service['name'];
							$carname_master_id=$row['carname_master_id'];
							$qry="select * from `carname_master` where `id`='$carname_master_id'";
							$data_base_object = new DataBaseConnect();
							$result_car = $data_base_object->execute_query_return($qry);
							$row_car=mysql_fetch_array($result_car);
							$car_name=$row_car['name'];
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
							
                            $opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $status=$row['status'];
                            $reason=$row['reason'];
						?>
						
                        <td><?php echo $row['dutyslip_id'];?></td>
                         <td><?php echo $cust_name;?></td>
                        <td><?php echo $billing_name;?></td>
                        <td><?php echo $service_name;?></td>
                        <td><?php echo $car_name;?></td>
                        <td><?php echo $car_reg_name_new;?></td>
                        <td><?php echo date("d-M-Y", strtotime($current_date));?></td>
                        <td><?php echo $opening_km;?></td>
                        <td><?php echo $closing_km;?></td>
                         <td><?php echo $reason;?></td>
                        </tr>
                        <?php
						}
						?>
                        </tbody>
						</table>
                        <?php
						}
							else if($_GET['type']=='deleted_invoice')
						{
						$i=0;
					$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from `invoice_deleted` where `date` between '".$_GET['date_from']."' and '".$_GET['date_to']."'  ORDER BY `date`");
						?>
						<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:20px">
                         <tr>
                        <td colspan="7" align="center"><b>Deleted Invoice Report From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_to'])); ?></b></td>
                        </tr>
                        <thead>
						<tr>
						<th>Sr. No.</th>
						<th>Duty Slip No.</th>
						<th>Invoice No.</th>
						<th>Date</th>
						<th>Customer Name</th>
						<th>Reason</th>
						<th>Login Name</th>
						</tr>
                        </thead>
                        <tbody>
                        <tr>
						<?php
						while($row=mysql_fetch_array($result))
						{ $i++;
						$qry_cust="select * from `customer_reg` where `id`='".$row['duty_slip_customer_reg_name']."'";
						$data_base_object_cust = new DataBaseConnect();
						$result_cust= $data_base_object_cust->execute_query_return($qry_cust);
						$row_cust=mysql_fetch_array($result_cust);
						$customer_name=$row_cust['name'];
						?>
						<td><?php echo $i; ?></td>
							<td><?php echo $row['duty_slip_dutyslip_id'];?></a></td>
							<td><?php echo $row['invoice_invoice_id'];?></td>
						<td><?php echo date("d-M-Y", strtotime($row['date']));?></td>
												
						<td><?php echo $customer_name;?></td>
						<td><?php echo $row['reason'];?></td>
						<td><?php echo $row['loginname'];?></td>
						</tr>				
						<?php
						}
						?>
                        </tbody>
						</table>
						<?php
						$mydatabase->close_connection();
					}
						else if($_GET['type']=='sales_registrar')
						{
						
						$i=0;$p1=$p2=$p3="";
					$mydatabase = new DataBaseConnect();
						
						if((!empty($_GET['date_from'])) AND (!empty($_GET['date_to'])))
							{
								$p2=" AND  `date` between '".DateExact($_GET['date_from'])."' and '".DateExact($_GET['date_to'])."' ORDER BY `duty_slip_customer_reg_name`,`date`";
							}
						if(!empty($_GET['customer_name']))
							{
							$p1=" AND `duty_slip_customer_reg_name`='".$_GET['customer_name']."'";
							
							if($p2=="")
								{
									$p1=" AND `duty_slip_customer_reg_name`='".$_GET['customer_name']."' ORDER BY `duty_slip_customer_reg_name`,`date`";
								}
							}
						if($p1=="" AND $p2=="")
							{
								$p3=" ORDER BY `duty_slip_customer_reg_name`,`date`";
							}
						
						$result= $mydatabase->execute_query_return("select * from `invoice` where (1=1)$p1$p2$p3");
						//$row=mysql_fetch_array($result);
						?>
						<?php
						$total=0;
						$reg_nm=""; $ch=0;
						while($row=mysql_fetch_array($result))
						{ $i++;
						 
						 
						 if($row['duty_slip_customer_reg_name'] != $reg_nm)
								{ 
								if($ch != 0)
								{
								?>
									</table>
								<?php
									} 
							?>
					<table width="100%" align="center" border="1" cellpadding="0" cellspacing="0"  style="line-height:22px">
                    <tr>
                        <td colspan="6" align="center"><b>Sales Register Report From <?php echo date("d-M-Y",strtotime($_GET['date_from'])); ?> TO <?php echo date("d-M-Y",strtotime($_GET['date_to'])); ?></b></td>
                        </tr>
                            <thead>
                                <tr>
                                <th>Sr. No.</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Invoice No.</th>                              
                                <th>Total Amount</th>
                                <th>Tax</th>
                                <th>Grand Total</th>
                                </tr>
                                </thead>
                                <tbody>
                           <tr>

							<?php $ch++;	
							$reg_nm=$row['duty_slip_customer_reg_name'];	
							
						$qry_cust="select * from `customer_reg` where `id`='".$row['duty_slip_customer_reg_name']."'";
						$data_base_object_cust = new DataBaseConnect();
						$result_cust= $data_base_object_cust->execute_query_return($qry_cust);
						$row_cust=mysql_fetch_array($result_cust);
						$customer_name=$row_cust['name'];
						
							}
						?>
						<td><?php echo $i; ?></td>
                        <td><?php echo $customer_name; ?></td>
						<td><?php echo date("d-M-Y", strtotime($row['date']));?></td>
						<td><?php echo $row['invoice_id'];?></td>						
						<td><?php echo $row['total'];?></td>
						<td><?php echo $row['tax'];?></td>
						<td><?php echo $row['grand_total'];?></td>
                       	</tr>	
						<?php
						$total+=$row['grand_total'];
						}
						?>
                         </tbody>	
                        <tfoot>
						<tr>
						<th colspan="5">Total:</th>
						<td><?php echo $total; ?></td>
                        <td></td>
						</tr>
                        </tfoot>
				<?php	} ?>
           		</table>
						<?php
						$mydatabase->close_connection();
						
					
						