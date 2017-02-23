<?php
require_once("config.php");
$start_date='2015-11-16' ;
$ledgr_ft=mysql_query("select * from `ledger` where `ledger_master_id`='27' && `date` between '$start_date' and '2016-01-06'  ");
while($ftc_ledger=mysql_fetch_array($ledgr_ft))
{
	echo $invoice_id=$ftc_ledger['invoice_id'];
	$ledger_id=$ftc_ledger['id'];
	
	$invoice_data=mysql_query("select * from `invoice`  where `id`= '$invoice_id'");
	$ftc_invoice=mysql_fetch_array($invoice_data);
		 $id=$ftc_invoice['id']; 
		 $total=$ftc_invoice['total']; 
		 $discount=$ftc_invoice['discount'];
		 $tax=$ftc_invoice['tax'];
		 $after_discount=$total-$discount;
		 $tax=round(5.6*($after_discount/100));
		 $sb_cess=round(0.20*($after_discount/100));
		 
		 //echo  "update `invoice` set `tax`='$tax',`sb_cess`='$sb_cess' where `id`='$id'";
		 mysql_query("update `invoice` set `tax`='$tax',`sb_cess`='$sb_cess' where `id`='$id'");
		 
		 $ledger_master_id=$ftc_ledger['ledger_master_id'];
		 $credit=$ftc_ledger['credit'];
		 $date=$ftc_ledger['date'];
		 $bank_id=$ftc_ledger['bank_id'];
		 $branch_id=$ftc_ledger['branch_id'];
		 $cheque_no=$ftc_ledger['cheque_no'];
		 $cheque_date=$ftc_ledger['cheque_date'];
		 $drawn_branch=$ftc_ledger['drawn_branch'];
		 $transaction_type=$ftc_ledger['transaction_type'];
		 $transaction_id=$ftc_ledger['transaction_id'];
		 $current_date=$ftc_ledger['current_date'];
		 $narration=$ftc_ledger['narration'];
		 
		 mysql_query("update `ledger` set `credit`='$tax' where `id`='$ledger_id'"); 
	 	
		$data=mysql_query("select `id` from `ledger` where `invoice_id`='$invoice_id' && `ledger_master_id` = '223' ");
		$count=mysql_num_rows($data);
		if($count>0)
		{}else
		{
		mysql_query("insert into `ledger` set `ledger_master_id`='223', `name`='SB Cess',`narration`='$narration', `credit`='$sb_cess', `date`='$date', `invoice_id`='$invoice_id', `bank_id`='$bank_id',`branch_id`='$branch_id',`cheque_no`='$cheque_no',`cheque_date`='$cheque_date',`drawn_branch`='$drawn_branch',`payment_id`='$payment_id',`transaction_type`='$transaction_type',`transaction_id`='$transaction_id',`current_date`='$current_date' "); 
		}
		 
		 
		
echo "<br>";			
}



?>