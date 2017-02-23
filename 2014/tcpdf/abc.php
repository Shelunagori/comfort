<?php 
require '../classes/databaseclasses/DataBaseConnect.php';
if(isset($_GET['page']))
{
	if($_GET['page']=="ipas" && isset($_GET['srno']))
	{
		echo "<tr>";
		echo "<td><input type=\"text\" style=\"width:62px; text-align:center;\" name=\"serialno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"particulars[]\" style=\"width:120px;\" id=\"".$_GET['srno']."\" onchange=\"QcSpecification(this.id)\">
		<option>--Select--</option>";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"specification[]\" id=\"specification".$_GET['srno']."\" /></td>";
		echo "<td><input type=\"radio\" name=\"urgentroutine".$_GET['srno']."\" value=\"urgent\"/>Yes";
		echo "<input type=\"radio\" name=\"urgentroutine".$_GET['srno']."\" value=\"routine\"/>No</td>";
		$result=$data_base_object->execute_query_return("select `name` from `department`");
		echo "<td>
		<select name=\"department_name[]\" style=\"width:120px;\">
		<option>--Select--</option>";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['name']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();		
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"msl[]\" id=\"msl".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"quantityavailable[]\" id=\"quantityavailable".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"quantityrequired[]\" id=\"quantityrequired".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"lastpurchasedate".$_GET['srno']."\" onmousedown=\"displayDatePicker(this.name)\" id=\"lastpurchasedate".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"lastpurchasequantity[]\" id=\"lastpurchasequantity".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"lastpurchaserate[]\" id=\"lastpurchaserate".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"quantityapproved[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"purchasequantity[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"purchasedate".$_GET['srno']."\" onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"purchaserate[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="is" && isset($_GET['srno']))
	{
		echo "<tr>";
		echo "<td><input type=\"text\" style=\"width:62px; text-align:center;\" name=\"serialno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"item[]\" style=\"width: 150px; height: 25px; font-family: calibri;\" id=\"".$_GET['srno']."\" onchange=\"QcSpecification(this.id)\" style=\"height:25px; width:125px; font-family:calibri;\">";
		echo "<option>--Select--</option>";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();
		
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"specification[]\" id=\"specification".$_GET['srno']."\"/></td>";
		
		echo "<td><input type=\"text\" style=\"width:85px;\" name=\"quantityrequired[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:90px;\" name=\"quantityavailable[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"remarks[]\" /></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="rrp" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"date".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:90px;\" name=\"item[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"specification[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:85px;\" name=\"quantityrequired[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:90px;\" name=\"quantityavailable[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"remarks[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"remarks[]\" /></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="oql" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:80px; text-align:center;\" name=\"serialno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"mfgdate[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"expdate[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" onblur=\"calBatchSize()\" name=\"batchsize[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"quantityoffer[]\" /></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="dr" && isset($_GET['srno']))
	{
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select action_taken from action_taken_list");
		
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:80px; text-align:center;\" name=\"serialno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"item[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"quantity[]\"/></td>";
		echo "<td>
		<select name=\"actiontaken[]\">";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['action_taken']."</option>";
		}
		echo "</select></td>";
		echo "</tr>";
		$data_base_object->close_connection();
	}
	else if($_GET['page']=="pl" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:80px; text-align:center;\" name=\"cartonno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"mfgdate".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"expdate".$_GET['srno']."\" onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\"  name=\"unit[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"quantitysupplied[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"sampledrawn[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"quantitybilled[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"grossweight[]\" /></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"dimension[]\" /></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="grn")
	{
		echo "<tr>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"gatepass_id[]\"/></td>";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `vendor_name` from `supplier_reg`");
		echo "<td>
		<select name=\"supplier_name[]\" id=\"supplier_name\" onblur=\"GetGRNData()\">";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['vendor_name']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"supplier_address[]\" id=\"supplier_address\" /></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"invoiceno[]\" id=\"invoiceno\" onblur=\"calInvoiceData()\" /></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"invoicedate[]\"  id=\"invoicedate\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"purchase_id[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"purchase_quantity[]\" id=\"purchase_quantity\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantityactual[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"mfgdate".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"expdate".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\" /></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"vim_id[]\" id=\"vim_id\" onblur=\"GetPackingStatusVIM()\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"qcreport_id[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"qcreport_date".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"acceptedquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"rejectedquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"qc_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"qc_date".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"store_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"store_date".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"remarks[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"po_no[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pakingstatus[]\" id=\"pakingstatus\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="rdrrp")
	{
		echo "<tr>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"date[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"pro_quantity1[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_noboxes[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_weight[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pur_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pur_no[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"letterref[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"date_radiationdispatch[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"date_radiationreceived[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"noofboxes[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"weight[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"qc_samples[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"issueslip_id[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_quantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_issueslip_id[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"remarks[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="rmc")
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"date[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"proissueslip_id[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"particulars[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"department_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"openingbalance[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"receivedirect[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"receivedother[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"issuedpro[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"issuedqc[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"issuerejected[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"issueothers[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"closingbalance[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"accepted[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"undertest[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"hold[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"remarks[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="isp" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"component_name[]\" style=\"width:130px;\" >";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";
		$result=$data_base_object->execute_query_return("select `id` from `grn`");
		echo "<td>
		<select name=\"grn_id[]\" style=\"width:130px;\" id=\"".$_GET['srno']."\" onchange=\"GetBatchNumber(this.id)\">";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['id']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"grn_batchno[]\" id=\"grn_batchno".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"quantityrequired[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"quantityissued[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"remarks[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="cgrn" && isset($_GET['srno']))
	{
		echo "<tr>";
		echo "<td><input type=\"text\" readonly=\"true\" style=\"width:50px; text-align:center;\" name=\"serialno[]\" value=\"".$_GET['srno']."\" /></td>";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"item_name[]\" style=\"width:130px;\">";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"details[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"received[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"accepted[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"rejected[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"remarks[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="rsm")
	{
		echo "<tr  align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"date[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"component_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"pro_quantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"qc_quantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"othersquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"totalquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"disposaldate[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"disposalquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"balancequantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"remarks[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="mp" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" readonly=\"true\" style=\"width:50px; text-align:center;\" name=\"serialno[]\" value=\"".$_GET['srno']."\" /></td>";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"component_name[]\" style=\"width:130px;\" onchange=\"MPUnitFetchQCTable(this.id)\" id=\"".$_GET['srno']."\">";
		echo "<option>--Select--</option>";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";		
		$data_base_object->close_connection();
		echo "<td><input type=\"text\" style=\"width:80px;\" name=\"unit[]\" id=\"unit".$_GET['srno']."\" /></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"requireperbatch[]\" id=\"requireperbatch".$_GET['srno']."\" /></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantityrequired[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantityavailable[]\" id=\"quantityavailable".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantityproduced[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"leadtime[]\" id=\"leadtime".$_GET['srno']."\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"requiredquantity[]\"/></td>";
		echo "<td align=\"left\"><input type=\"text\" style=\"width:80px;\" name=\"requireddate".$_GET['srno']."\"  onmousedown=\"displayDatePicker(this.name)\" /></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="viim")
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"component_name[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"batchno[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"totalboxes[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"boxesok[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"boxesdamage[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"totalquantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantityok[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantitydamage[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="dc")
	{
		echo "<tr align=\"center\">";
		echo "<td><select style=\"width:150px;\" name=\"reasoncode[]\">
				<option>001</option><option>002</option><option>003</option><option>004</option>
				<option>005</option><option>006</option><option>007</option><option>008</option>
			</select>
		</td>";
		echo "<td><input type=\"text\" style=\"width:150px;\" name=\"description[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:150px;\" name=\"quantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:150px;\" name=\"appoxvalue[]\"/></td>";
		echo "</tr>";
	}
	else if($_GET['page']=="rs" && isset($_GET['srno']))
	{
		echo "<tr align=\"center\">";
		echo "<td><input type=\"text\" readonly=\"true\" style=\"width:50px; text-align:center; \" name=\"serialno[]\" value=\"".$_GET['srno']."\"/></td>";
		$data_base_object=new DataBaseConnect();
		$result=$data_base_object->execute_query_return("select `particulars` from `qc`");
		echo "<td>
		<select name=\"consumable_name[]\" style=\"width:130px;\">";
		while ($row=mysql_fetch_assoc($result)) {
			echo "<option>".$row['particulars']."</option>";
		}
		echo "</select></td>";
		$data_base_object->close_connection();
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"quantity[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:60px;\" name=\"purpose[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:100px;\" name=\"daterequired[]\"/></td>";
		echo "<td><input type=\"text\" style=\"width:50px;\" name=\"approvedquantity[]\"/></td>";
		echo "</tr>";
	}
}
?>