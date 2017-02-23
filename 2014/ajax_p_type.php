<?php 
require_once ("config.php");
$value=$_GET['value'];
$id=$_GET['id'];
if(!empty($value))
{
if($value=='Bank')
{
$result=mysql_query("select * from `payment` where `id`='".$_GET['id']."'");
$row_data=mysql_fetch_array($result);

$res_l_type=mysql_query("select chequedate,chequenumber,bankname,branch from ledger where payment_id='".$_GET['id']."' && type='Payment' && ledger_type='Bank'");
$row_l=mysql_fetch_array($res_l_type);

?>
<table width="100%">
	<tr ><td  width="30%"> Bank Name: </td><td>
					<select name="bank_reg_bank_id" id="bank_reg_bank_id" onchange="GetBranches(this.value)"  class="m-wrap medium">
					<option>-Select-</option>
              	<?php 
						$result=mysql_query("select name from bank_reg");
						while($row=mysql_fetch_array($result))
						{
							if($row_l['bankname']==$row['name'])
							echo "<option value=\"".$row['name']."\" selected >".$row['name']."</option>";
							else
							echo "<option value=\"".$row['name']."\"  >".$row['name']."</option>";
						}
              	?>
              	</select>
				</td></tr>
<tr ><td> Branch : </td><td>
<div id="branch_name_div"></div>
</td></tr>
<tr ><td> Cheque Number : </td><td><input type="text"  value="<?php echo $row_l['chequenumber']; ?>" class="m-wrap medium" name="chequenumber" /> </td></tr>
<tr ><td> Cheque Date : </td><td><input type="text" placeholder="dd-mm-yyyy"  value="<?php echo date("d-m-Y",strtotime($row_l['chequedate'])); ?>" class="m-wrap medium" name="chequedate" /> </td></tr>
</table>
<?php
}
else
{
	?>
    <?php
}
}
else if(!empty($_GET['receipt_value'])&&!empty($_GET['receipt_id']))
{
$result=mysql_query("select * from `receipts` where `id`='".$_GET['receipt_id']."'");
$row_data=mysql_fetch_array($result);

$res_l_type=mysql_query("select chequedate,chequenumber,bankname,branch from ledger where type_id='".$_GET['receipt_id']."' && type='Receipt' && ledger_type='Bank'");
$row_l=mysql_fetch_array($res_l_type);
if($_GET['receipt_value']=='Bank')
{
	?>
    <table width="100%">
    <tr ><td  width="30%"> Bank Name: </td><td>
    <select name="bank_reg_bank_id" id="bank_reg_bank_id" onchange="GetBranches(this.value)"  class="m-wrap medium">
    <option>-Select-</option>
    <?php 
    $result=mysql_query("select name from bank_reg");
    while($row=mysql_fetch_array($result))
    {
    if($row_l['bankname']==$row['name'])
    echo "<option value=\"".$row['name']."\" selected >".$row['name']."</option>";
    else
    echo "<option value=\"".$row['name']."\"  >".$row['name']."</option>";
    }
    ?>
    </select>
    </td></tr>
    <tr ><td> Branch : </td><td>
    <div id="branch_name_div"></div>
    </td></tr>
    <tr ><td> Cheque Number : </td><td><input type="text"  value="<?php echo $row_l['chequenumber']; ?>" class="m-wrap medium" name="chequenumber" /> </td></tr>
    <tr ><td> Cheque Date : </td><td><input type="text" placeholder="dd-mm-yyyy"  value="<?php echo date("d-m-Y",strtotime($row_l['chequedate'])); ?>" class="m-wrap medium" name="chequedate" /> </td></tr>
    </table>
    <?php
}
else
{
}
}