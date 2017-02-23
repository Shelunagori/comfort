<?php
define('DB_HOST','localhost');
define('DB_USER_NAME','comfortold');
define('DB_USER_PASSWORD','8_Qyf8KF*8[f');
define ('DB_NAME','comfortold');

class DataBaseConnect
{
	
	private $connection;

	function execute_query_return($query)
	{	
		$connection=$this->get_connection();
		mysql_select_db(DB_NAME,$connection);
		return mysql_query($query,$connection);
	}
	
	function get_connection()
	{
		if(is_resource($this->connection))
		{
			return  $this->connection;
		}
		else 
		{
			$this->connection = mysql_connect(DB_HOST,DB_USER_NAME,DB_USER_PASSWORD);
			if(!$this->connection)
			{
				die(mysql_error());	
			}
			else
			{
				return  $this->connection;
			}
		}
	}
	
	
	function execute_query_update_booking($query,$car_name,$number_of_vehicle,$id="")
	{
		$connection=$this->get_connection();
		mysql_select_db(DB_NAME,$connection);

		if(mysql_query($query,$connection))
		{
			if($id=="")
			{
				$result =mysql_query("select max(id) from booking");
				$row= mysql_fetch_array($result);
				$max_booking_id = $row[0];
				$booking_car_query = "insert into booking_car(booking_id,carname_master,vehicle) values('".$max_booking_id."','".$car_name."','".$number_of_vehicle."')";
			}
			else 
			{
				$booking_car_query = "update booking_car set carname_master='".$car_name."' , vehicle='".$number_of_vehicle."' where booking_id=".$id;
			}
			if(mysql_query($booking_car_query))
			{
				$this->close_connection();
				if($id=="")
				echo "<meta http-equiv='refresh' content='0;url=booking_menu.php?reg=comp'/>";
				else
				echo "<meta http-equiv='refresh' content='0;url=booking_menu.php?updt=done'/>";
			}
		}
		else
		{
			echo mysql_error($connection);
		}
	}
	
	function execute_query_update_user_right($query,$lid,$chk,$check_sub)
	{
		$connection=$this->get_connection();
		mysql_select_db(DB_NAME,$connection);
		if(mysql_query($query,$connection))
		{
			
        foreach ($chk as $value)
		{
		 $sel_ex=mysql_query("select * from `login` where `login_name`='$lid'");
		$arr_ex=mysql_fetch_array($sel_ex);
		 $m_id=$arr_ex['id'];
	
		mysql_query("insert into `module_privilege` set `login_id`='$m_id',`module_id`='$value'");
		}	
		
		foreach ($check_sub as $value)
		{
		mysql_query("insert into `sub_module_assign` set `login_id`='$m_id',`submodule_id`='$value'");
		}		
		
		}
	}
function execute_query_operation($query)
	{	
		$connection=$this->get_connection();
		mysql_select_db(DB_NAME,$connection);
		 mysql_query($query,$connection);
	}
	
	function execute_query_update($query,$for,$add="") 
	{
		$connection=$this->get_connection();
		mysql_select_db(DB_NAME,$connection);
		if(mysql_query($query,$connection))
		{
			if($for=='tariff_reg')
			{
				$this->close_connection();
				echo "<script>location='tariff_rate_menu.php?reg=comp';</script>";
			}
			if($for=='counter')
			{
				$this->close_connection();
				echo "<script>location='add_counter.php';</script>";
			}
			else if($for=="fuel_update")
			{
				$this->close_connection();
				echo "<script>location='fuel_menu.php?updt=done';</script>";				
			}
			else if($for=="invoice_status")
			{
				return "success";
			}
			else if($for=="fuel_reg")
			{
				$this->close_connection();
				echo "<script>location='fuel_menu.php?reg=comp';</script>";
			}
			else if($for=="carnamemaster")
			{
				$this->close_connection();
				echo "<script>location='carmaster.php?reg=comp';</script>";	
			}
			else if($for=="ledger_insert")
			{
				return "success";	
			}
			else if($for=='ledger_reg')
			{
				$this->close_connection();
				echo "<script>location='ledger_menu.php?reg=comp';</script>";	
			}
			else if($for=="multi_entry")
			{
				return "success";
			}
			else if($for=="waveoff")
			{
				return "success";
			}
			else if($for=="new_user")
			{
				return "success";
			}
			else if($for=="journal_reg")
			{
				$result =mysql_query("select max(id) from journal");
				$row= mysql_fetch_array($result);
				$max_journal_id = $row[0];
				return $max_journal_id;
			}
			else if($for=="journal_receipts")
			{
				return true;
			}
			else if($for=="bank_receipts")
			{
				return true;
			}
			else if($for=="payment_receipts")
			{
				return true;
			}
			else if ($for=="supplier_payment_reg")
			{
				return "success";
			} 
			else if($for=="customer_receipt_reg")
			{
				//$this->close_connection();
				//header("receipt_menu.php?reg=done");
			}
			else if($for=='delete_booking')
			{
				return  "success";
			}
			else if($for=="booking_deleted")
			{
				$this->close_connection();
				echo "<script>location='booking_menu.php?dell=done';</script>";	
			}
			else if($for=='invoice_detail_update')
			{
				return "success";
			}
			else if($for=='invoice_process')
			{
				return  "success";
			}
			else if($for=='duty_slip_status_change')
			{
				return "success";
			}
			else if($for=="dutyslip_update")
			{
				$this->close_connection();
				echo "<script>location='dutyslip_menu.php?updt=done';</script>";
				//header("dutyslip_menu.php?updt=done");
			}
			else if($for=="duty_slip")
			{
				return "success";
			}
			else if($for=="delete_cust_tariff")
			{
				$this->close_connection();
					echo "<script>location='customer_tariff_rate_menu.php?dell=done';</script>";	
			}
			else if($for=="delete_supp_tariff")
			{
				$this->close_connection();
				echo "<script>location='supplier_tariff_rate_menu.php?dell=done';</script>";
			}
			else if($for=='customer_tariff_update')
			{
				$this->close_connection();
				echo "<script>location='customer_tariff_rate_menu.php?updt=done';</script>";
			}
			else if($for=='supplier_tariff_update')
			{
				$this->close_connection();
				echo "<script>location='supplier_tariff_rate_menu.php?updt=done';</script>";
			}
			else if($for=="tariff_deletion")
			{
				$this->close_connection();
				echo "<script>location='tariff_rate_menu.php?dell=done';</script>";
			}
			else if($for=="tariff_update")
			{
				$this->close_connection();
				echo "<script>location='tariff_rate_menu.php?updt=done';</script>";
			}
			else if($for=="driver_deletion")
			{
				$this->close_connection();
					echo "<script>location='employee_menu.php?dell=done';</script>";
			}
			else if($for=="bank_deletion")
			{
				$this->close_connection();
				echo "<script>location='bank_menu.php?dell=done';</script>";
			}
			else if($for=='booking')
			{
				$this->close_connection();
				//header("booking_menu.php?reg=comp");
			}
			else if($for=='service_delete')
			{
				$this->close_connection();
				echo "<script>location='service_menu.php?dell=done';</script>";
			}
			else if($for=='service_reg')
			{
				$this->close_connection();
					echo "<script>location='service_menu.php?reg=comp';</script>";
			}
			else if($for=='customer_tariff_reg')
			{
				$this->close_connection();
				echo "<script>location='customer_tariff_rate_menu.php?reg=comp';</script>";
			}
			else if($for=='supplier_tariff_reg')
			{
				$this->close_connection();
				echo "<script>location='supplier_tariff_rate_menu.php?reg=comp';</script>";
			}
			else if($for=="car_deletion")
			{
				$this->close_connection();
				echo "<script>location='car_menu.php?dell=done';</script>";
			}
			else if($for=="bank_reg")
			{
				mysql_query("insert into `ledger`(`ledger_type`,`name`,`description`)
				values('Bank','".$add."','Bank Description')",$this->connection);
				$this->close_connection();
				echo "<script>location='bank_menu.php?reg=comp';</script>";
			}
			else if ($for=="car_update")
			{
				$this->close_connection();
				echo "<script>location='car_menu.php?updt=done';</script>";
			}
			else if($for=="customer_reg")
			{	
				$this->close_connection();
				echo "<script>location='customer_menu.php?reg=comp';</script>";
			}
			else if($for=="driver_update")
			{
				$this->close_connection();
				echo "<script>location='employee_menu.php?updt=done';</script>";
			}
			else if($for=="customer_update")
			{
				$this->close_connection();
					echo "<script>location='customer_menu.php?updt=done';</script>";
			}
			else if($for=="customer_deletion")
			{
				$this->close_connection();
					echo "<script>location='customer_menu.php?dell=done';</script>";
			}
			else if($for=="supplier_reg")
			{
				mysql_query("insert into `ledger`(`ledger_type`,`name`,`description`)
				values('Supplier','".$add."','Supplier Description')",$this->connection);
				$this->close_connection();
				echo "<script>location='supplier_menu.php?reg=comp';</script>";
			}
			else if($for=="supplier_update")
			{
				$this->close_connection();
				echo "<script>location='supplier_menu.php?updt=done';</script>";
			}
			else if($for=="supplier_deletion")
			{
				$this->close_connection();
					echo "<script>location='supplier_menu.php?dell=done';</script>";
			}
			else if($for=="delete_login")
			{
				$this->close_connection();
					echo "<script>location='view_right.php?dell=done';</script>";
			}
			else if($for=="car_reg")
			{
				mysql_query("insert into `ledger`(`ledger_type`,`name`,`description`)
				values('Car','".$add."','Car Description')",$this->connection);
				$this->close_connection();
				echo "<script>location='car_menu.php?reg=comp';</script>";
				//header("car_menu.php?reg=comp");
			}
			
		}
		else
		{
			die(mysql_error());
		}
		
	}
	
	function close_connection() 
	{
		mysql_close($this->connection);
	}
}

function DateConvert($date)
{
	$dd= substr($date, 0,2);
	$mm= substr($date, 3,2);
	$yyyy= substr($date, 6,4);
	return $yyyy."-".$mm."-".$dd;
}
function DateExact($date)
{
	if(strpos($date,"/")!=false)
		$date=DateConvert($date);
	return $date;
}

function DatePickerDate($date) 
{
	$day = substr($date, 8);
	$month=substr($date, 5,2);
	$year=substr($date, 0,4);
	return $day."/".$month."/".$year;
}

function DisplayDate($databasedate)
{
	$year=substr($databasedate,0,4);
	$month=substr($databasedate,5,2);
	$day=substr($databasedate,8,2);
	return $day."-".$month."-".$year;	
}
?>