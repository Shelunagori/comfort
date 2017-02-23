<?php
require_once("config.php");
require_once("function.php");
$result=mysql_query("select `id` from `car_reg` where `name`='Other'");
$row=mysql_fetch_array($result);
$car_id=$row['id'];                                // This is auto id of other car

$result_duty_slip=mysql_query("select `id` from `duty_slip` where `car_id`='Others'");      // this code replace other name in car by its auto id 30 
while($row_duty_slip=mysql_fetch_array($result_duty_slip))
{$i++;
@mysql_query("update `duty_slip` set `car_id`='".$car_id."' where `id`='".$row_duty_slip['id']."'");
}

$result_new_car=mysql_query("select `id`,`new_car_no` from `duty_slip` where `new_car_no`!=''"); 
while($row_new_car=mysql_fetch_array($result_new_car))
{
	$k++;
	@mysql_query("update `duty_slip` set `temp_car_no`='".$row_new_car['new_car_no']."' where `id`='".$row_new_car['id']."'");
}

?>