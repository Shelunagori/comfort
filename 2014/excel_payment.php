<?php
require 'classes/databaseclasses/DataBaseConnect.php';
require_once("config.php");
header('Content-Type: application/force-download');
header("Pragma: ");
header("Cache-Control: ");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=document_name.xls");
?>
<style>
td
{
	text-align:left;
}
</style>
<table width="100%"  border="1" style="border-collapse:collapse;">
<tr><td ><strong>Payment Information</strong> </td>
						<td colspan="7" ><strong>Payment from</strong> 
						<?php 
							echo date("d-M-Y",strtotime($_GET['date_from']));
						?>
						<strong>to</strong> 
						<?php 
							echo date("d-M-Y",strtotime($_GET['date_to']));
						?>
						</td>
						</tr>
                    <thead>
                        <tr>
                        <th>Payment No.</th>
                        <th>Payment Type</th>
                        <th>Date</th>
                        <th>Name </th>
                        <th>Bank Name</th>
                        <th>Invoice No.</th>
                        <th>Narration</th>
                        <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php      
                     	$result = mysql_query("select * from `payment` where `current_date` between '".($_GET['date_from'])."' and '".($_GET['date_to'])."' OR `id`='".$_GET['receipt_id']."'");
                     	 $id=0;
						  $num_rows=mysql_num_rows($result);
                     	while($row=mysql_fetch_array($result))
                     	{
                     	 ?>
                            <tr>
                            <td><?php echo $row['id'];?></td>
                            <td><?php echo $row['receipt_type_type_id']; ?>
                            <td><?php echo $row['date'];?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['bank_reg_bank_id']; ?></td> 
                            <td><?php echo $row['invoice_ids']; ?></td>
                            <td><?php echo $row['narration'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            </tr>
                            
                       <?php 
                     	}
                       ?>  
                       </tr>
                       </tbody>
                       </table>
<?php
