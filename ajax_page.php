<?php
require_once("config.php");
require_once("auth.php");
$delete_cust_id=$_GET['delete_cust_id'];
$delete_supplier_id=$_GET['delete_supplier_id'];
$supplier_type_id=$_GET['supplier_type_id']; 
$delete_emp_id=$_GET['delete_emp_id']; 
$delete_car_id=$_GET['delete_car_id'];
$delete_tariff_id=$_GET['delete_tariff_id'];
$delete_customer_tariff_id=$_GET['delete_customer_tariff_id'];
$delete_supplier_tariff_id=$_GET['delete_supplier_tariff_id'];
$delete_booking_id=$_GET['delete_booking_id'];
$delete_dutyslip_id=$_GET['delete_dutyslip_id'];
$delete_invoice_id=$_GET['delete_invoice_id'];
$counter=$_GET['counter'];
$car_reading=$_GET['car_reading'];
$bank_id=$_GET['bank_id'];
$ledger_type=$_GET['ledger_type'];
$srno=$_GET['srno'];
$ledger_type_jv=$_GET['ledger_type_jv'];
$ins_no=$_GET['ins_no'];
$f_invoice_id=$_GET['f_invoice_id'];

$fuel_type=$_GET['fuel_type'];
$corporate=(int)$_GET['corporate'];


function fetchsuppliername($id)
{
$result=mysql_query("select `name` from `supplier_reg` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}


if(!empty($delete_cust_id))  
{
	@mysql_query("delete from customer_reg where id='".$delete_cust_id."'");
}
else if(!empty($delete_supplier_id))
{
	@mysql_query("delete from supplier_reg where id='".$delete_supplier_id."'");
}
else if(!empty($supplier_type_id))
{
	?>
    <select name="supplier_type_sub_id" class='m-wrap medium' >
    <?php
		$result=@mysql_query("select * from supplier_type_sub where `supplier_type_id`='".$_GET['supplier_type_id']."'");
		while($row=mysql_fetch_array($result))
		{
			echo "<option value='".$row['id']."'>".$row['name']."</option>";
		}
		?>
	</select>
    <?php
}
else if(!empty($delete_emp_id))
{
	@mysql_query("delete from `driver_reg` where `id`='".$delete_emp_id."'");
}
else if(!empty($delete_car_id))
{
	@mysql_query("delete from `car_reg` where `id`='".$delete_car_id."'");	
}
else if(!empty($delete_tariff_id))
{
	@mysql_query("delete from `tariff_rate` where `id`='".$delete_tariff_id."'");	
}
else if(!empty($delete_customer_tariff_id))
{
		@mysql_query("delete from `customer_tariff` where `id`='".$delete_customer_tariff_id."'");	
}
else if(!empty($delete_supplier_tariff_id))
{
		@mysql_query("delete from `supplier_tariff` where `id`='".$delete_supplier_tariff_id."'");	
}
else if(!empty($delete_booking_id))
{
		@mysql_query("delete from `booking` where `id`='".$delete_booking_id."'");	
}
else if($_GET['identity']=='ratefix')
{
	   $result=mysql_query("select `rate` from `customer_tariff` where customer_id='".$_GET['customer_id']."' and car_type_id='".$_GET['car_type_id']."' and service_id='".$_GET['service_id']."'");
	   if(mysql_num_rows($result)==0)   
	   $result=mysql_query("select `rate` from `tariff_rate` where service_id='".$_GET['service_id']."' and car_type_id='".$_GET['car_type_id']."'");
	   $row = mysql_fetch_array($result);
	   if($row['rate']>0)
	   echo $rate=$row['rate'];
	   else
	   echo '0';
}
else if($_GET['identity']=='Opening_km')
{
	$result=mysql_query("select `closing_km` from `duty_slip` where `car_id`='".$_GET['car_id']."' && `waveoff_status`!='1' ORDER BY `id` DESC");
	$row = mysql_fetch_array($result);
	if($row['closing_km']>0)
	echo $closing_km=$row['closing_km'];
	else
	echo '0';
}
else if(!empty($delete_dutyslip_id))
{
	@session_start();
 	$counter_id=$_SESSION['counter_id'];	
	$login_id=$_SESSION['id'];
	@mysql_query("update `duty_slip` set `waveoff_reason`='".$_GET['waveoff_reason']."',`waveoff_login_id`='".$login_id."',`waveoff_counter_id`='".$counter_id."',`waveoff_status`='1' where `id`='".$delete_dutyslip_id."'");
}
else if(!empty($delete_invoice_id))
{
	@session_start();
 	$counter_id=$_SESSION['counter_id'];	
	$login_id=$_SESSION['id'];
	@mysql_query("update `invoice` set `waveoff_reason`='".$_GET['waveoff_reason']."',`waveoff_login_id`='".$login_id."',`waveoff_counter_id`='".$counter_id."',`waveoff_status`='1' where `id`='".$delete_invoice_id."'");
	$fetch_ds_id=@mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$delete_invoice_id."'");
	while($row_ds_id=mysql_fetch_array($fetch_ds_id))
	{
		@mysql_query("update `duty_slip` set `billing_status`='no' where `id`='".$row_ds_id['duty_slip_id']."'");
	}
}
else if(!empty($counter))
{
	$check=mysql_query("select `name` from `counter` where `name`='".$counter."'");
	$num_rows=mysql_num_rows($check);
	if($num_rows>0)
	{
		?>
            <select name="role" class="m-wrap medium">
            <option value="0"> Select Counter</option>
            <?php $sel1=mysql_query("select * from counter");
            while($arr1=mysql_fetch_array($sel1))
            {
            echo '<option value="'.$arr1['id'].'">'.$arr1['name'].'</option>';
            } ?>
            </select>
        <?php
	}
	else
	{
		@mysql_query("insert into `counter` set `name`='".$counter."'")
		?>
                           <select name="role" class="m-wrap medium" >
                            <option value="0"> Select Counter</option>
                            <?php $sel1=mysql_query("select * from counter");
                            while($arr1=mysql_fetch_array($sel1))
                            {
                            echo '<option value="'.$arr1['id'].'">'.$arr1['name'].'</option>';
                            } ?>
                            </select>
        <?php
	}
}
else if(!empty($fuel_type))
{
	  	  $res_fuel=mysql_query("select *  from `taxation` where `name`='".$fuel_type."' ");
		  $row_fuel=mysql_fetch_array($res_fuel); 
		  echo "<input type=\"text\" readonly=\"readonly\"  class=\"span6 m-wrap\" value=".$row_fuel['rate']." name=\"price\" />";
}
else if(!empty($car_reading))
{
	 $result_reading=mysql_query("select `closing_km` from `fuel` where `car_id`='".$car_reading."' ORDER BY `id` DESC");
	   if(mysql_num_rows($result_reading)!=0)   
	   {
	   		$row = mysql_fetch_array($result_reading);
	   		if($row['closing_km']==0)
	   		{
	   			echo "0";
	   		}
	   		else 
			{
	   		echo $row['closing_km'];
	   		}
	   }
}
else if(!empty($bank_id))
{
			?>
            <select name="branch_id" class="span6 m-wrap">	
            <?php 
            $result= mysql_query("select  `id`,`branch` from `bank_reg` where `id`='".$bank_id."'");
            while($row=mysql_fetch_array($result))
            {
            echo '<option value="'.$row['id'].'">'.$row['branch'].'</option>';
            }
            ?>
            </select>
            <?php
}
else if(!empty($ledger_type))
{
	
	?>
       		<select name="ledger_name" id="ledger_name" class="m-wrap span12 ledger_name" >	
            <option value="0">---select name---</option>
            <?php 
            $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='".$ledger_type."' && `name`!='Difference in opening balance'");
            while($row=mysql_fetch_array($result))
            {		
            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>
	<?php
}
else if(!empty($srno))
{
	?>
    <tr>
    <td><select name="ledger_type_id<?php echo $srno; ?>" id="ledger_type<?php echo $srno; ?>" class="m-wrap small" onchange="fetch_ledger_jv(this.value,<?php echo $srno; ?>);">	
	    <option value="">---select ledger type---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from ledger_type");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select></td>
    <td id="option_name<?php echo $srno; ?>"></td>
    <td><select name="credit_debit<?php echo $srno; ?>" id="credit_debit<?php echo $srno; ?>" class="m-wrap small" onchange="bal_total(this.value,<?php echo $srno; ?>);">
        <option value="Credit">Credit</option>
		<option value="Debit">Debit</option>
       	</select></td>
    <td><input type="text" class="m-wrap small date-picker"   onmouseover="mydatepick();" id="date<?php echo $srno; ?>" name="date<?php echo $srno; ?>" /></td> 
	<td><input type="text" class="m-wrap small amount_box" name="amount<?php echo $srno; ?>" id="amount<?php echo $srno; ?>" onkeyup="show_total();" autocomplete="off"/></td> 
	<td>
		<div class="controls" id="ins_list_place">
        </div>
	</td> 
    </tr>
    <?php
}
else if(!empty($ledger_type_jv))
{
		?>
		<select name="ledger_master_id<?php echo $_GET['name_extension']; ?>" class="m-wrap large chosen">	
		<option value="0">---select name---</option>
		<?php 
		$result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='".$ledger_type_jv."'  && `name`!='Difference in opening balance'");
		while($row=mysql_fetch_array($result))
		{		
		echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
		}
		?>
		</select>
		<?php
			
}

else if(!empty($ins_no))
{	 
	?>
     	<select class="span6 m-wrap tooltips" name="invoice_list[]" style="margin-left: 12px;"  data-placement="bottom"  id="invoice_list" multiple="multiple" tabindex="1">
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
    <?php
}
else if(!empty($_GET['update_receipt_invoice'])&&!empty($_GET['update_receipt_cust']))
{
	$update_receipt_invoice=explode(',',$_GET['update_receipt_invoice']);
	 $result_customer_id=mysql_query("select `id` from `customer_reg` where `name`='".$_GET['update_receipt_cust']."'");
		$row_customer_id=@mysql_fetch_array($result_customer_id);
		
		$result_invoice=mysql_query("select `id`,`grand_total`,`payment_status` from invoice where  `customer_id`='".$row_customer_id['id']."' && `waveoff_status`!='1' order by `id`");
		while($row_invoice=@mysql_fetch_array($result_invoice))
		{
			
			if(in_array($row_invoice['id'], $update_receipt_invoice))
			{
			$all_ids[]=$row_invoice['id'];
			}
			else if($row_invoice['payment_status']=='no')
			{
			$all_ids[]=$row_invoice['id'];
			}
		}
	?>
	<select class="span6 m-wrap tooltips" name="invoice_list[]"  data-placement="bottom"  id="invoice_list" multiple="multiple" tabindex="1">
        <?php
			$z=@array_unique($all_ids);
	   		foreach($z as $val)
			{
			$check_receipt_detail=mysql_query("select `due_amnt` from `receipt_detail` where `invoice_id`='".$val."'");
			if(mysql_num_rows($check_receipt_detail)>0)
			{
			$row_receipt_detail=mysql_fetch_array($check_receipt_detail);
			$grand_total=$row_receipt_detail['due_amnt'];
			}
			else
			{
			$fetch_amnt=mysql_query("select `grand_total` from `invoice` where `id`='".$val."'");
			$row_amnt=@mysql_fetch_array($fetch_amnt);
			$grand_total=$row_amnt['grand_total'];	
			}
			$res_ds_no=mysql_query("select `duty_slip_id` from `invoice_detail` where `invoice_id`='".$val."'");
			$row_dsno=@mysql_fetch_array($res_ds_no);
			$duty_slip_id=$row_dsno['duty_slip_id'];
			
			$res_guest_name=mysql_query("select `guest_name` from `duty_slip` where `id`='".$duty_slip_id."'");
			$row_guest=@mysql_fetch_array($res_guest_name);
			$guest_name=$row_guest['guest_name'];
	
			if(in_array($val, $update_receipt_invoice))
			{
			$sel="selected=selected";
			}
			else
			{
			$sel="";
			}
			if(!empty($grand_total))
			{
    echo   '<option class="tooltips" value="'.$val.'" '.$sel.'  data-placement="bottom" title="Guest:'.$guest_name.',DS No:'.$duty_slip_id.' Due Amt:'.$grand_total.'" due_amt="'.$grand_total.'">'.$val.'</option>';
			}
		}
		?>
        </select>
        <?php
}
else if(!empty($corporate))
{
?>
                         
                            <tr id="h_rmv<?php echo $corporate; ?>">
                            <th><input type="text" name="date<?php echo $corporate; ?>" placeholder="dd-mm-yyyy"  onmouseover="mydatepick();" class="m-wrap small date-picker"/></th>
                            <th><input type="text" name="service<?php echo $corporate; ?>"  class="m-wrap medium"/></th>
                            <th><input type="text" autocomplete="off" onkeyup="calculate_amnt(<?php echo $corporate; ?>);" id="rate<?php echo $corporate; ?>" name="rate<?php echo $corporate; ?>"  class="m-wrap small"/></th>
                            <th><input type="text" autocomplete="off" onkeyup="calculate_amnt(<?php echo $corporate; ?>);" id="day<?php echo $corporate; ?>" name="day<?php echo $corporate; ?>"  class="m-wrap small"/></th>
                            <th><input type="text" name="texi_no<?php echo $corporate; ?>"  class="m-wrap medium"/></th>
                            <th><input readonly="readonly" type="text" id="amount<?php echo $corporate; ?>" name="amount<?php echo $corporate; ?>"  class="m-wrap small"/></th>
                            <td><button class="btn mini red"  title="Delete this row"   role="button" value="<?php echo $corporate; ?>" onClick="delete_cor_row(this.value);"  style="width:2.5em !important; height:2em !important;text-decoration:none;"><i class="icon-remove"></i></button></td>
                            </tr>
                           
<?php
}
else if(!empty($_GET['payment_ledger_id']))
{
		$res_name=@mysql_query("select `name` from `ledger` where `id`='".$_GET['l_id']."'");
		$row_name=mysql_fetch_array($res_name);
	?>
            <select name="ledger_name"  class="span6 m-wrap" >	
            <option value="0">---select name---</option>
            <?php 
            $result=mysql_query("select distinct `name` from `ledger_master` where `ledger_type_id`='".$_GET['payment_ledger_id']."'");
            while($row=mysql_fetch_array($result))
            {	
			if($row['name']==$row_name['name'])	
            echo '<option value="'.$row['name'].'" selected="selected">'.$row['name'].'</option>';
			else
            echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>	
    <?php
}
else if(!empty($_GET['delete_coporate_id']))
{
	@session_start();
 	$counter_id=$_SESSION['counter_id'];	
	$login_id=$_SESSION['id'];
	@mysql_query("update `corporate_billing` set `waveoff_reason`='".$_GET['cor_waveoff_reason']."',`waveoff_login_id`='".$login_id."',`waveoff_counter_id`='".$counter_id."',`waveoff_status`='1' where `id`='".$_GET['delete_coporate_id']."'");
	@mysql_query("delete from `ledger` where `transaction_id`='".$_GET['delete_coporate_id']."' && `transaction_type`='corporate_billing'");
}
else if(!empty($_GET['l_idd']))
{
	if($_GET['status']=='1'){
	@mysql_query("update `login` set `ldrview`='yes' where `id`='".$_GET['l_idd']."'");}
	else if($_GET['status']=='0'){
	@mysql_query("update `login` set `ldrview`='no' where `id`='".$_GET['l_idd']."'");
	}
}
?>
   
