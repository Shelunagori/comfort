<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_GET['id']) && isset($_GET['delete_driver']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from driver_reg where driver_id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"driver_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_customer']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from customer_reg  where id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"customer_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_spplier']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from supplier_reg  where supplier_id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"supplier_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_car']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from car_reg where car_id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"car_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_bank']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from bank_reg where id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"bank_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_tariff']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from tariff_rate where tariff_id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"tariff_deletion");
}
else if(isset($_GET['id']) && isset($_GET['delete_cust_tariff']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from customer_tariff where customer_tariff_id	='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"delete_cust_tariff");
}
else if(isset($_GET['id']) && isset($_GET['delete_supp_tariff']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from `supplier_tariff` where `supplier_tariff_id`	='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"delete_supp_tariff");
}
else if(isset($_GET['id']) && isset($_GET['delete_booking']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "delete from booking where id='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"booking_deletion");
	$data_base_connect_object->execute_query_update("delete from booking_car where booking_id=".$_GET['id'],"booking_deleted");
}
else if(isset($_GET['id']) && isset($_GET['delete_login']))
{
	$data_base_connect_object =new DataBaseConnect(); 
	$query = "update `login` set `status`='1' where `id`='".$_GET['id']."'";
	$data_base_connect_object->execute_query_update($query,"delete_login");
} 
?>
