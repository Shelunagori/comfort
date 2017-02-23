<?php
		   include("config.php");
		 
		   $invoice_data = mysql_query("select * from `invoice`  where `invoice_type_type_id` = 'Car'   ");
			while($ftc_invoice=mysql_fetch_array($invoice_data))
          {
			$sum=0;	
			$invoice_id = $ftc_invoice['invoice_id'];
			
		  $ledger_first = mysql_query("select * from `ledger` where `ledger_type` = 'Car' && `bill_number`='".$invoice_id."'");
	      $num_rows = mysql_num_rows($ledger_first);
		  while($ftc_ledger_first = mysql_fetch_array($ledger_first))
		  {
          $credit = $ftc_ledger_first['credit'];
		  $sum+=$credit;
		  }
		  $ledger_first = mysql_query("select * from `ledger` where `ledger_type` = 'Customer' && `bill_number`='".$invoice_id."'");
		   $ftc_ledger_first = mysql_fetch_array($ledger_first);
           $debit = $ftc_ledger_first['debit'];
		   
		   $final_credit = $debit-$sum;
		   
		   if($debit==$sum)
		   {
			   
		   }
		   else
		   {
			
		   echo $mysql_query="update `ledger` set `credit`='".$final_credit."' where `ledger_type`='Ledger' && `name`='Car Hire Services' && `bill_number`='".$invoice_id."'"; 
	   //mysql_query("update `ledger` set `credit`='".$final_credit."' where `ledger_type`='Ledger' && `name`='Car Hire Services' && `bill_number`='".$invoice_id."'"); 
		  echo '<br />';
		     echo '<br />';
		   }
		  }
		  exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>