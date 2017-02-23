<?php
ini_set('max_execution_time', 600);
require_once("config.php");
$i=0;

$result_invoice=mysql_query("select * from invoice where `date`>='2016-05-01'");
while($row_invoice=mysql_fetch_array($result_invoice))
{
	$i++;
	$tax=$row_invoice['tax'];
	$total=$row_invoice['total'];
	$current_date=$row_invoice['date'];
	$invoice_id=$row_invoice['id'];
	$discount=$row_invoice['discount'];
	$total-=$discount;
	if($tax>0)
	{
		$h=0;
		$result_taxrate=mysql_query("select * from `taxation` where `tax`='1'");
		while($row_taxrate=mysql_fetch_array($result_taxrate))
		{$h++;
	
			$result_taxrate_Data=mysql_query("select * from `taxation_data` where `taxation_id`='".$row_taxrate['id']."' && `date`<='".$current_date."' order by date desc limit 1");
			@$row_taxrate_Data=mysql_fetch_array($result_taxrate_Data);
			if($row_taxrate_Data['rate']>0)
			{
					 $credit=($total*$row_taxrate_Data['rate'])/100;
					$ledger_master=mysql_query("select `id` from `ledger_master` where `name`='".$row_taxrate['name']."' && `ledger_type_id`='8'");
					$row_ledger_master=mysql_fetch_array($ledger_master);
					
					$ledger=mysql_query("select `id`,`narration` from `ledger` where `name`='".$row_taxrate['name']."' && `ledger_master_id`='".$row_ledger_master['id']."' && `invoice_id`='".$row_invoice['id']."'");
					$row_ledger=mysql_fetch_array($ledger);
					
						@$narration=$row_ledger['narration'];
						mysql_query("delete from `ledger` where `id`='".$row_ledger['id']."'");
						@mysql_query("insert into `ledger` set `date`='".$current_date."',`ledger_master_id`='".$row_ledger_master['id']."',`invoice_id`='".$invoice_id."',`name`='".$row_taxrate['name']."',`credit`='".round($credit)."',`debit`='0',`narration`='".$narration."',`current_date`='".$current_date."'");
						
					
				
			}
		}
	}
}

?>