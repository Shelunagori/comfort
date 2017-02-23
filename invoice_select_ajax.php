<?php
require_once("config.php");
require_once("auth.php");

$ins_no=$_GET['ledger_name'];
?>
<select class="span6 m-wrap tooltips" name="invoice_list[]"  data-placement="bottom"  id="invoice_list" multiple="multiple" tabindex="1" style="width:150px;" callajax="no">
        <?php
	    $result_customer_id=mysql_query("select `id` from `customer_reg` where `name`='".$ins_no."'");
		$row_customer_id=mysql_fetch_array($result_customer_id);

		$result_invoice=mysql_query("select `id`,`grand_total` from invoice where `payment_status`='no' and `customer_id`='".$row_customer_id['id']."' && `waveoff_status`!='1' order by `id`");
		while($row_invoice=mysql_fetch_array($result_invoice))
		{
			 
			$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$row_invoice['id']."'");
			if(mysql_num_rows($check_receipt_detail)>0)
			{
				$row_receipt_detail=mysql_fetch_array($check_receipt_detail);
				$grand_total=$row_receipt_detail['due_amnt'];
			}
			else
			{
				$grand_total=$row_invoice['grand_total'];	
			}
			$res_ds_no=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$row_invoice['id']."'");
			$row_dsno=mysql_fetch_array($res_ds_no);
			$duty_slip_id=$row_dsno['duty_slip_id'];
			
			$res_guest_name=mysql_query("select `guest_name` from `duty_slip` where `id`='".$duty_slip_id."'");
			$row_guest=mysql_fetch_array($res_guest_name);
			$guest_name=$row_guest['guest_name'];
			if(!empty($grand_total))
			{
		?>
     <option class="tooltips" value="<?php echo $row_invoice['id']; ?>" due_amt="<?php echo $grand_total; ?>" data-placement="bottom" title="Guest:<?php echo $guest_name; ?>,DS No:<?php echo $duty_slip_id; ?>Due Amt:<?php echo $grand_total; ?>"><?php echo $row_invoice['id']; ?></option>
        <?php
			}
		}
		?>
      </select>