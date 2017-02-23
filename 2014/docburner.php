<?php
require 'classes/databaseclasses/DataBaseConnect.php';
header('Content-Type: application/force-download');
header("Pragma: ");
header("Cache-Control: ");
           header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=document_name.xls");
			if($_POST['ledger_type']=='Bank')
						{
							?>	
						<table width="100%" border="1" style="border-collapse:collapse;">
						<tr style="height: 40px;"><td style="font-size:12px; color: blue;">Ledger Information </td>
						<td colspan="8" style="font-size:12px; width: 250px;" >Bank Ledger from 
						<?php 
							echo $_POST['date_from'];
						?>
						to 
						<?php 
							echo $_POST['date_to'];
						?>
						</td>
						</tr>
						<tr>
						<td colspan="4">&nbsp;</td>
						<td>Opening Balance: </td>
						<?php 
						$opening_bal=0;
						$ntblnce=0;
						$mydatabase = new DataBaseConnect();
							$result= $mydatabase->execute_query_return("select `credit`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `date` < '".DateExact($_POST['date_from'])."'");
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							}
							$opening_bal=$ntblnce;
						?>
						<td  colspan="3"><?php 
						echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></td>
						</tr>
						<tr><th>Date</th><th>Customer Name</th><th>Cheque Number</th><th>Debit</th><th>Credit</th><th>Balance</th></tr>
						<?php
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select `chequenumber`, `ledger_type`, `name`,`credit`,`bill_number`,`date`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ");
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;
						while($row=mysql_fetch_array($result))
						{
							?>
							<tr align="center" >
							<td><?php echo $row['date']?></td>
							<td><?php echo $row['name']?></td>
							<td><?php echo $row['chequenumber']?></td>
							<td><?php echo $row['debit']?></td>
							<td><?php echo abs($row['credit']);?></td>
							<?php 
							$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							?>
							<td><?php echo abs($ntblnce); 
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
							?>
							</td>
							</tr>
							<?php 
								$cr+= $row['credit'];
								$db+= $row['debit'];
						}
						?>
						<tr ><th colspan="3" >Total.</th><th><?php echo $db;?></th><th><?php echo $cr;?></th><th><?php echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Opening Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo $opening_bal;
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Total Debits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $db." DR";?></th></tr>
						<tr ><th >Total Credits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $cr." CR";?></th></tr>
						<tr ><th >Closing Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal+$db-$cr);
						if($opening_bal+$db-$cr>0)
							echo " DR";
						else
							echo " CR"; 
						?></th></tr>
                        </table>
					<?php 	}
					else if($_POST['ledger_type']=='Tax')
						{
							?>	
						<table width="100%" border="1" style="border-collapse:collapse;">
						<tr style="height: 40px;"><td style="font-size:12px; color: blue;">Ledger Information </td>
						<td colspan="8" style="font-size:12px; width: 250px;" >Tax Ledger from 
						<?php 
							echo $_POST['date_from'];
						?>
						to 
						<?php 
							echo $_POST['date_to'];
						?>
						</td>
						</tr>
						<tr>
						<td colspan="6">&nbsp;</td>
						<td colspan="2">Opening Balance: </td>
						<?php 
						$mydatabase = new DataBaseConnect();
							$result= $mydatabase->execute_query_return("select `credit`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `date` < '".DateExact($_POST['date_from'])."'");
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							}
							$opening_bal=$ntblnce;
						?>
						<td  colspan="3"><?php 
						echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></td>
						</tr>
						<tr ><th>Date</th><th>Bill Number</th><th>Taxable Amount</th><th>Service Tax</th><th>Education <br/>Cess</th><th>Higher <br/>Education Cess</th>
						<th>Credit</th>
						<th>Debit</th>
						<th>Balance</th>
						</tr>
						<?php
						$result= $mydatabase->execute_query_return("select `bill_number` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ");
						$service_tax=0;
						$ec=0;
						$hec=0;
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;
						while($row=mysql_fetch_array($result))
						{
							$local_result=$mydatabase->execute_query_return("select * from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `bill_number`='".$row['bill_number']."' order by `id`");
							$row_st=mysql_fetch_assoc($local_result);
							$row_ec=mysql_fetch_assoc($local_result);
							$row_hec=mysql_fetch_assoc($local_result);
							?>
							<tr align="center"><td><?php echo $row_st['date']?></td><td><?php echo $row['bill_number']?></td>
							<td><?php echo ($row_st['credit']+$row_ec['credit']+$row_hec['credit']);?></td>
							<td><?php echo $row_st['credit'];?></td><td><?php echo $row_ec['credit'];?></td>
							<td><?php echo $row_hec['credit'];?></td>
							<td><?php echo ($row_st['credit']+$row_ec['credit']+$row_hec['credit']);?></td>
							<td><?php echo $row_st['debit'];?></td>
							<?php 
								$ntblnce=($row_st['debit']+$row_ec['debit']+$row_hec['debit'])-($row_st['credit']+$row_ec['credit']+$row_hec['credit'])+$ntblnce;
							?>
							<td><?php echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
								?>
							</td>
							</tr>
							<?php 
								$service_tax+=$row_st['credit'];
								$ec+=$row_ec['credit'];
								$hec+=$row_hec['credit'];
								$cr+= ($row_st['credit']+$row_ec['credit']+$row_hec['credit']);
								$db+= $row_st['debit']+$row_ec['debit']+$row_hec['debit'];
						}
						?>
						<tr ><th colspan="2" >Total.</th>
						<th><?php echo $cr;?></th><th><?php echo $service_tax;?></th><th><?php echo $ec;?></th>
						<th><?php echo $hec;?></th>
						<th><?php echo $cr;?></th>
						<th><?php echo $db;?></th>
						<th><?php echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
								?></th>
						</tr>
						<tr ><th >Opening Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal);
						if($opening_bal>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Total Debits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $db." DR";?></th></tr>
						<tr ><th >Total Credits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $cr." CR";?></th></tr>
						<tr ><th >Closing Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal+$db-$cr);
						if($opening_bal+$db-$cr>0)
							echo " DR";
						else
							echo " CR"; 
						?></th></tr>

						</table>
					<?php 	}
						else if($_POST['ledger_type']=='Fuel')
						{
							?>	
						<table width="100%" border="1" style="border-collapse:collapse;">
						<tr style="height: 40px;"><td style="font-size:12px; color: blue;">Ledger Information </td>
						<td style="font-size:12px; width: 250px;"><?php echo $_POST['ledger_type'];?> Ledger from 
						<?php 
							echo $_POST['date_from'];
						?>
						to 
						<?php 
							echo $_POST['date_to'];
						?>
						</td>
						<td style="font-size:12px;" colspan="4">Name : 
						<?php 
							echo $_POST['name'];
						?>
						</td>
						</tr>
						<tr>
						<td colspan="3" align="right">&nbsp;</td>
						<td colspan="2">Opening Balance: </td>
						<?php 
						$mydatabase = new DataBaseConnect();
							$result= $mydatabase->execute_query_return("select `credit`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` < '".DateExact($_POST['date_from'])."'");
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							}
							$opening_bal=$ntblnce;
						?>
						<td><?php 
						echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></td>
						</tr>
						<tr ><th>Date</th>
						<th>Fuel Type</th>
						<th>Car Name</th>
						<th>Debit</th><th>Credit</th><th>Balance</th>
						</tr>
						<?php
						$result= $mydatabase->execute_query_return("select * from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ");
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;
						while($row=mysql_fetch_array($result))
						{
							?>
							<tr align="center">
							<td><?php echo $row['date'];?></td>
							<td><?php echo $row['cust_supp_name'];?></td>
							<td><?php echo $row['description'];?></td>
							<td><?php echo $row['debit'];?></td>
							<td><?php echo $row['credit'];?></td>
							<?php 
							$cr+=$row['credit'];
							$db+=$row['debit'];
							$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							?>
							<td><?php echo abs($ntblnce); 
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
							?>
							</td>
							</tr>
							<?php 
						}
						?>
						<tr ><th colspan="3" >Total.</th>
						<th><?php echo $db;?></th>
						<th><?php echo $cr;?></th>
						<th><?php echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
								?></th>
						</tr>
						<tr ><th >Opening Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal);
						if($opening_bal>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Total Debits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $db." DR";?></th></tr>
						<tr ><th >Total Credits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $cr." CR";?></th></tr>
						<tr ><th >Closing Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal+$db-$cr);
						if($opening_bal+$db-$cr>0)
							echo " DR";
						else
							echo " CR"; 
						?></th></tr>
                         
						</table>
					<?php 	}
						else if($_POST['ledger_type']=='Customer' || $_POST['ledger_type']=='Discount'
						|| $_POST['ledger_type']=='Car'
						)
						{
							?>	
						<table width="100%" border="1" style="border-collapse:collapse;">
						<tr style="height: 40px;"><td style="font-size:12px; color: blue;">Ledger Information </td>
						<td style="font-size:12px; width: 250px;"><?php echo $_POST['ledger_type'];?> Ledger from 
						<?php 
							echo $_POST['date_from'];
						?>
						to 
						<?php 
							echo $_POST['date_to'];
						?>
						</td>
						<td style="font-size:12px;" colspan="4">Name : 
						<?php 
							echo $_POST['name'];
						?>
						</td>
						</tr>
						<tr>
						<td colspan="3" align="right">&nbsp;</td>
						<td colspan="2">Opening Balance: </td>
						<?php 
						$mydatabase = new DataBaseConnect();
							$result= $mydatabase->execute_query_return("select `credit`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` < '".DateExact($_POST['date_from'])."'");
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							}
							$opening_bal=$ntblnce;
						?>
						<td><?php 
						echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></td>
						</tr>
						<tr ><th>Date</th>
						<th>Invoice No./Transcation ID</th>
						<th>Guest Name</th>
						<th>Debit</th><th>Credit</th><th>Balance</th>
						</tr>
						<?php
						$result= $mydatabase->execute_query_return("select `bill_number`,`payment_id`, `credit`,`date`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ");
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;
						while($row=mysql_fetch_array($result))
						{
							?>
							<tr align="center" >
							<td><?php echo $row['date'];?></td>
							  <?php if(!empty($row['bill_number']))
							{?>
                            <td><?php echo $row['bill_number'];?></td>
                            <?php
							}else{
							?>
							<td><?php echo $row['payment_id'];?></td>
                            <?php
							}
							?>
							<td> 
							<?php 
						    	$result_invoice= $mydatabase->execute_query_return("select `duty_slip_dutyslip_id` from `invoice_detail` where `invoice_invoice_id`='".$row['bill_number']."' order by `duty_slip_dutyslip_id`");
						  		$row_temp=mysql_fetch_assoc($result_invoice);
						    	$result_duty=$mydatabase->execute_query_return("select `guest_name` from `duty_slip` where `dutyslip_id`='".$row_temp['duty_slip_dutyslip_id']."'");
						  		$row_duty=mysql_fetch_assoc($result_duty);
						  		echo $row_duty['guest_name'];
						    ?>
						    </td>
							<td><?php echo $row['debit'];?></td>
							<td><?php echo $row['credit'];?></td>
							<?php 
							$cr+=$row['credit'];
							$db+=$row['debit'];
							$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							?>
							<td><?php echo abs($ntblnce); 
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
							?>
							</td>
							</tr>
							<?php 
						}
						?>
						<tr ><th colspan="3" >Total.</th>
						<th><?php echo $db;?></th>
						<th><?php echo $cr;?></th>
						<th><?php echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
								?></th>
						</tr>
						<tr ><th >Opening Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo $opening_bal;
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Total Debits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $db." DR";?></th></tr>
						<tr ><th >Total Credits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $cr." CR";?></th></tr>
						<tr ><th >Closing Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal+$db-$cr);
						if($opening_bal+$db-$cr>0)
							echo " DR";
						else
							echo " CR"; 
						?></th></tr>
						</table>
					<?php 	
						
					}
						else {
					?>	
						<table width="100%" border="1" style="border-collapse:collapse;">
						<tr style="height: 40px;"><td style="font-size:12px; color: blue;">Ledger Information </td>
						<td style="font-size:12px; width: 250px;"><?php echo $_POST['ledger_type'];?> Ledger from 
						<?php 
							echo $_POST['date_from'];
						?>
						to 
						<?php 
							echo $_POST['date_to'];
						?>
						</td>
						<td style="font-size:12px;" colspan="6">Name : 
						<?php 
							echo $_POST['name'];
						?>
						</td>
						</tr>
						<tr>
						<td colspan="3" align="right">&nbsp;</td>
						<td colspan="4">Opening Balance: </td>
						<?php 
						$mydatabase = new DataBaseConnect();
							$result= $mydatabase->execute_query_return("select `credit`,`debit` from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` < '".DateExact($_POST['date_from'])."'");
							$ntblnce=0;
							$opening_bal=0;
							while ($row=mysql_fetch_array($result)) {
								$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							}
							$opening_bal=$ntblnce;
						?>
						<td><?php 
						echo abs($ntblnce);
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></td>
						</tr>
						<tr ><th>Date</th>
                        <th>Type</th>
						<th>Id</th>
						<th>Invoice No.</th>
						<th>Customer Name/<br/>
						Supplier Name
						</th>
						<th>Debit</th><th>Credit</th><th>Balance</th>
						</tr>
						<?php
						$result= $mydatabase->execute_query_return("select * from `ledger` where `ledger_type`='".$_POST['ledger_type']."' and `name`='".$_POST['name']."' and `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' ");
						$cr=0;
						$db=0;
						$ntblnce=$opening_bal;
						while($row=mysql_fetch_array($result))
						{
							?>
							<tr align="center" >
							<td><?php echo $row['date'];?></td>
                             <td><?php echo $row['type'];?></td>
							<td><?php echo $row['type_id'];?></td>
							<td><?php echo $row['bill_number'];?></td>
							<td> 
							<?php echo $row['cust_supp_name'];?></td>
							<td><?php echo $row['debit'];?></td>
							<td><?php echo $row['credit'];?></td>
							<?php 
							$cr+=$row['credit'];
							$db+=$row['debit'];
							$ntblnce=$row['debit']-$row['credit']+$ntblnce;
							?>
							<td><?php echo abs($ntblnce); 
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
							?>
							</td>
							</tr>
							<?php 
						}
						?>
						<tr ><th colspan="5" >Total.</th>
						<th><?php echo $db;?></th>
						<th><?php echo $cr;?></th>
						<th><?php echo abs($ntblnce) ;
							if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
								?></th>
						</tr>
						<tr ><th >Opening Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo $opening_bal;
						if($ntblnce>0)
								echo " DR";
							else
								echo " CR";
						?></th></tr>
						<tr ><th >Total Debits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $db." DR";?></th></tr>
						<tr ><th >Total Credits:</th><th colspan="5" align="left">
						&nbsp;<?php echo $cr." CR";?></th></tr>
						<tr ><th >Closing Balance:</th><th colspan="5" align="left">
						&nbsp;<?php echo abs($opening_bal+$db-$cr);
						if($opening_bal+$db-$cr>0)
							echo " DR";
						else
							echo " CR"; 
						?></th></tr>
						</table>
					<?php	
					}
					?>