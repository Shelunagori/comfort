<?php 
require 'classes/databaseclasses/DataBaseConnect.php';
//if(isset($_GET['page']))
//{
//	if($_GET['page']=="ipas" && isset($_GET['srno']))           abc.php
//	{
 
		echo "<tr>";
		echo "<td><select name=\"ledger_type".$_GET['srno']."\"  id=\"".$_GET['srno']."\" onchange=\"SetLedgerSession(this.id)\" class=\"m-wrap small\" >";
             echo "<option>--Select--</option>";
			 $mydatabase=new DataBaseConnect();
              	$result= $mydatabase->execute_query_return("select distinct `ledger_type` from `ledger`");
						while($row=mysql_fetch_array($result))
						{
							echo "<option value=\"".$row['ledger_type']."\">".$row['ledger_type']."</option>";
						}
						$mydatabase->close_connection();
				echo "<option>Others</option>
              	</select></td>";
	//	echo "<td><input type=\"text\" style=\"width:62px; text-align:center;\" name=\"serialno[]\" readonly=\"true\" value=\"".$_GET['srno']."\"/></td>";
		echo "<td><div id=\"option_name".$_GET['srno']."\"></div></td><td>";
		echo "<select name=\"credit_debit".$_GET['srno']."\"  id=\"credit_debit".$_GET['srno']."\" onchange=\"SetLedgerSession()\" class=\"m-wrap small\" >";
             echo "<option value=\"Credit\">Credit</option>
				<option value=\"Debit\">Debit</option>
              	</select></td>";
		//echo "<td><input type=\"radio\" name=\"urgentroutine".$_GET['srno']."\" value=\"urgent\"/>Yes";
		echo "<td><input type=\"text\" name=\"date".$_GET['srno']."\"  id=\"date".$_GET['srno']."\" class=\"m-wrap small\" onmousedown=\"displayDatePicker(this.name)\"/></td>";
		echo "<td><input type=\"text\" value=\"0\" name=\"amount".$_GET['srno']."\" id=\"amount".$_GET['srno']."\" class=\"m-wrap small\"/></td>";
		echo "</tr>";
//	}
//}
	?>
<input type="hidden" name="count" value="<?php echo $_GET['srno']; ?>"  id="count" class="m-wrap small"/></td>