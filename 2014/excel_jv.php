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
	text-align:center;
}
</style>
<table width="100%"  border="1" style="border-collapse:collapse;">
<tr><td ><strong>Journal Information</strong> </td>
						<td colspan="3" ><strong>Ledger Type</strong> 
						<?php 
							echo $_GET['l_type'];
						?>
						</td>
                        <td colspan="3"><strong>Name</strong> 
						<?php 
							echo $_GET['name'];
						?>
                        </td>
						</tr>
                    <thead>
                        <tr>
                        <th >S. No</th>
                        <th >Ledger Type</th>
                        <th >Ledger Name </th>
                        <th >Credit</th>
                        <th >Debit</th>
                        <th >Date</th>
                        <th >Narration</th>
                        </tr>
                    </thead>
                      <tbody>
                     <?php      
                     	$data_base = new DataBaseConnect();
                     	$result = $data_base->execute_query_return("select * from `ledger` where
                     	`ledger_type`='".$_GET['l_type']."' and `name`='".$_GET['name']."'
                     	 and `narration` <> ''");
                     	while($row=mysql_fetch_array($result))
                     	{
						$i++;
						$id=$row['id'];
						$ledger_type=$row['ledger_type'];
						$name=$row['name'];
						$credit=$row['credit'];
						$debit=$row['debit'];
						$date=$row['date'];
						$narration=$row['narration'];
                     	
?>
                            <tr>
                             <td><?php echo $i;?></td>
                            <td><?php echo $ledger_type;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $credit;?></td>
                            <td><?php echo $debit;?></td>
                            <td><?php echo $date;?></td>
                            <td><?php echo $narration;?></td>
                             </tr>
				<?php 
				}
				?>
                   
				</tbody>
                    </table>
<?php
