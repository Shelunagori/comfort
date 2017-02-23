<?php
			include("config.php");
			
			$new = mysql_query("select * from `duty_slip` ");
			while($ftc_name=mysql_fetch_array($new))
			{
			$car_reg_name = $ftc_name['car_reg_name'];		
			$dutyslip_id = $ftc_name['dutyslip_id'];
			if(!empty($car_reg_name))
			{
			$car_detail = mysql_query("select * from `car_reg` where `name` LIKE '%$car_reg_name%' ");
			$num_rows = mysql_num_rows($car_detail);
			if($num_rows>0)
			{
				
			}
			else
			{
				$temp = $car_reg_name;
			echo	$mysql_query = "update `duty_slip` set `new_car_no`='$temp' ,`car_reg_name`='Others' where `dutyslip_id`='$dutyslip_id'";
			// remove echo and exit when run
			 //	mysql_query("update `duty_slip` set `new_car_no`='$temp' ,`car_reg_name`='Others' where `dutyslip_id`='$dutyslip_id'");
			}
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