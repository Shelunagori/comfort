<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
$carnumber=$_GET['con'];
if(!empty($carnumber))
{
?>
<select name="car_reg_name" class="m-wrap medium" id="ajaxcarname">	
						<option value="">Select Type</option>
				<?php 
				$mydatabase = new DataBaseConnect();
				$result= $mydatabase->execute_query_return("select * from car_reg where `carname_master_id`='$carnumber' ");
				while($row=mysql_fetch_array($result))
				{
					echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
				}
				$mydatabase->close_connection();
				?>
				</select>  
                    <label class="checkbox">
                    <input type="checkbox" value="same" id="type"  style="margin-left:1%" onClick="cheak();">&nbsp;New Car Number
                    </label>
                                      
                <?php
}