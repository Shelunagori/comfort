<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
if(isset($_POST['dutyslip_update']))
{
	$data_base_connect_object =new DataBaseConnect();
	
	$idd=$_POST['dutyslip_id'];
	$current_date=$_POST['current_date'];
	$guest_name=$_POST['guest_name'];
	$contactnumber=$_POST['contactnumber'];                        	
	$car_reg_name=$_POST['car_reg_name']; // field customer name
	$new_car_no = $_POST['new_car_no'];
	$detail_number=$_POST['detail_number'];
	$driver_reg_driver_id=$_POST['driver_reg_driver_id'];
	$extra_chg=$_POST['extra_chg'];
	$permit_chg=$_POST['permit_chg'];
	$parking_chg=$_POST['parking_chg'];
	$otherstate_chg=$_POST['otherstate_chg'];
	$guide_chg=$_POST['guide_chg'];
	$misc_chg=$_POST['misc_chg'];
	$remarks=$_POST['remarks'];
	$rate=$_POST['rate'];
	$authorized_person=$_POST['authorized_person'];
	$date_authorization=$_POST['date_authorization'];
	$reason = $_POST['reason'];
	
	$closing_time = $_POST['closing_time_hh'].":".$_POST['closing_time_mm'].":00";
	$opening_time = $_POST['opening_time_hh'].":".$_POST['opening_time_mm'].":00";
	$service_service_id=$_POST['service_service_id']; // field service
	$customer_reg_name=$_POST['customer_reg_name']; // field customer name
	$carname_master_id = $_POST['carname_master_id'];  // field car name
	$opening_km = $_POST['opening_km'];  // field opening km 
	$closing_km= $_POST['closing_km'];
	
	$total_km = $closing_km-$opening_km;
	
	$date_from  = DateExact($_POST['date_from']);
	$date_to = DateExact($_POST['date_to']);
	$main1= strtotime($date_from);
	$main2 = strtotime($date_to);
	$days=(($main2-$main1)/86400);
	
	$night_hault_charges=0;
	
	
	$res = $data_base_connect_object->execute_query_return("select night_hault_charges from carname_master where name='".$carname_master_id."'");
	$row= mysql_fetch_array($res);
	$night_hault_charges = $days * $row['night_hault_charges'];
	$amount=$_POST['rate']+$night_hault_charges+$_POST['extra_chg']+ $_POST['permit_chg']+$_POST['parking_chg']+$_POST['otherstate_chg']+$_POST['guide_chg']+$_POST['misc_chg'];

/*	if($days>0)
		{
		$amount=($_POST['rate']*$days)+$night_hault_charges+$_POST['extra_chg']+ $_POST['permit_chg']+$_POST['parking_chg']+$_POST['otherstate_chg']+$_POST['guide_chg']+$_POST['misc_chg'];
		}
		else
		{
			$amount=($_POST['rate'])+$night_hault_charges+$_POST['extra_chg']+ $_POST['permit_chg']+$_POST['parking_chg']+$_POST['otherstate_chg']+$_POST['guide_chg']+$_POST['misc_chg'];
		}
	*/
	
	$query = "update duty_slip set `current_date`='".DateExact($_POST['current_date'])."' ,`guest_name`='".$_POST['guest_name']."',`contactnumber`='".$_POST['contactnumber']."',
	`service_service_id`='".$_POST['service_service_id']."',`carname_master_id`='".$_POST['carname_master_id']."',`car_reg_name`='".$_POST['car_reg_name']."',`new_car_no`='".$new_car_no."',
	`customer_reg_name`='".$_POST['customer_reg_name']."',`detail_number`='".$_POST['detail_number']."',`driver_reg_driver_id`='".$_POST['driver_reg_driver_id']."',
	`opening_km`='".$_POST['opening_km']."',`opening_time`='".$opening_time."', closing_km='".$_POST['closing_km']."' , closing_time='".$closing_time."' ,
	`date_from`='".$date_from."',`date_to`='".$date_to."', 
	 extra_chg='".$_POST['extra_chg']."' ,permit_chg='".$_POST['permit_chg']."',
	parking_chg='".$_POST['parking_chg']."' , otherstate_chg='".$_POST['otherstate_chg']."' , guide_chg='".$_POST['guide_chg']."' , misc_chg='".$_POST['misc_chg']."',`remarks`='".$_POST['remarks']."',
	`authorized_person`='".$_POST['authorized_person']."',`date_authorization`='".DateExact($_POST['date_authorization'])."',`reason`='".$_POST['reason']."',
 total_km='".$total_km."' ,`amount`='".$amount."',`rate`='".$rate."'
	where dutyslip_id='".$idd."'";
	
	
	$query_select_prev="select * from `duty_slip` where `dutyslip_id`='".$idd."'";
	$result=$data_base_connect_object->execute_query_return($query_select_prev);
	$row=mysql_fetch_assoc($result);
	$bool=false;
	if($row['current_date']!=DateExact($_POST['current_date']))
	{
		$bool=true;
	}
	else if($row['guest_name']!=$_POST['guest_name'])
	{
		$bool=true;
	}
	else if($row['contactnumber']!=$_POST['contactnumber'])
	{
		$bool=true;
	}
	else if($row['service_service_id']!=$_POST['service_service_id'])
	{
		$bool=true;
	}
	else if($row['carname_master_id']!=$_POST['carname_master_id'])
	{
		$bool=true;
	}
	else if($row['car_reg_name']!=$_POST['car_reg_name'])
	{
		$bool=true;
	}
	else if($row['customer_reg_name']!=$_POST['customer_reg_name'])
	{
			$bool=true;
	}
	else if($row['detail_number']!=$_POST['detail_number'])
	{
			$bool=true;
	}
	else if($row['driver_reg_driver_id']!=$_POST['driver_reg_driver_id'])
	{
			$bool=true;
	}
	else if($row['opening_km']!=$_POST['opening_km'])
	{
			$bool=true;
	}
	else if($row['opening_time']!=$opening_time)
	{
			$bool=true;
	}
	else if($row['closing_km']!=$_POST['closing_km'])
	{
			$bool=true;
	}
	else if($row['closing_time']!=$closing_time)
	{
				$bool=true;
	}
	else if($row['date_from']!=$date_from)
	{
				$bool=true;
	}
	else if($row['date_to']!=$date_to)
	{
				$bool=true;
	}
	else if($row['extra_chg']!=$_POST['extra_chg'])
	{
				$bool=true;
	}
	else if($row['permit_chg']!=$_POST['permit_chg'])
	{
				$bool=true;
	}
	else if($row['parking_chg']!=$_POST['parking_chg'])
	{
				$bool=true;
	}
	else if($row['otherstate_chg']!=$_POST['otherstate_chg'])
	{
				$bool=true;
	}
	else if($row['guide_chg']!=$_POST['guide_chg'])
	{
				$bool=true;
	}
	else if($row['misc_chg']!=$_POST['misc_chg'])
	{
				$bool=true;
	}
	else if($row['remarks']!=$_POST['remarks'])
	{
		$bool=true;
	}
	else if($row['authorized_person']!=$_POST['authorized_person'])
	{
		$bool=true;
	}
	else if($row['date_authorization']!=DateExact($_POST['date_authorization']))
	{
		$bool=true;
	}
	else if($row['reason']!=$_POST['reason'])
	{
		$bool=true;
	}
	
	$newquery="INSERT INTO `duty_slip_updation` (`dutyslip_id`, `current_date`, `guest_name`, `contactnumber`, `photo_id`, `service_service_id`, `carname_master_id`, `car_reg_name`,		`new_car_no`, `customer_reg_name`, `detail_number`, `driver_reg_driver_id`, `opening_km`, `opening_time`, `closing_km`, `closing_time`, `date_from`, `date_to`, `extra_chg`, `permit_chg`, `parking_chg`, `otherstate_chg`, `guide_chg`, `misc_chg`, `remarks`, `billed_complimentary`, `authorized_person`, `date_authorization`, `reason`, `status`, `total_km`, `rate`, `amount`) VALUES 
	('".$idd."', '".$row['current_date']."', '".$row['guest_name']."', '".$row['contactnumber']."','".$row['photo_id']."', '".$row['service_service_id']."', '".$row['carname_master_id']."', '".$row['car_reg_name']."', '".$row['new_car_no']."', '".$row['customer_reg_name']."', '".$row['detail_number']."', '".$row['driver_reg_driver_id']."', '".$row['opening_km']."', '".$row['opening_time']."', '".$row['closing_km']."','".$row['closing_time']."','".$row['date_from']."','".$row['date_to']."','".$row['extra_chg']."','".$row['permit_chg']."','".$row['parking_chg']."','".$row['otherstate_chg']."','".$row['guide_chg']."','".$row['misc_chg']."','".$row['remarks']."','".$row['billed_complimentary']."','".$row['authorized_person']."','".$row['date_authorization']."','".$row['reason']."','".$row['status']."','".$row['total_km']."','".$row['rate']."','".$row['amount']."')";
	
	$data_base_connect_object->execute_query_update($newquery,"duty_next_insert");
	$data_base_connect_object->execute_query_update($query,"dutyslip_update");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Comfort</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
  <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
function ajaxFunction(args)
{
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			if(args=="get_rate")
				document.add_form.rate.value = ajaxRequest.responseText;
			else
				document.add_form.opening_km.value = ajaxRequest.responseText;
		}
	}
	
	if(args=="get_rate")
	{
		//	var list = document.add_form.service_service_id;
		//		alert("Hello 1");
		//	var service_name = list.options[list.selectedIndex].text;
		//		alert(service_name);
		//	alert("Hello 2");
		//	var list2 = document.add_form.carname_master_id;
		//	alert("Hello 3");
		//	var car_name = list2.options[list2.selectedIndex].text;
		//  alert(car_name);
		//	alert("Hello 4");
	var service_name = document.getElementById("service_service_id").value;
		var car_name = document.getElementById("carname_master_id").value;
		var customer_reg_name = document.getElementById("autocomplete_customer_name").value;
			//	alert(customer_reg_name);alert(service_name);alert(car_name);
	//	alert("Hello 5");
		ajaxRequest.open("GET", "get_teriff_rate.php?customer_reg_name="+customer_reg_name+"&carname_master_id="+car_name+"&service_service_id="+service_name, true);
		ajaxRequest.send(null);
	} 
	else if(args=="get_closing")
	{
		//var list2 = document.add_form.carname_master_id;
		//var car_name = list2.options[list2.selectedIndex].text;
		var car_reg_name=document.add_form.car_reg_name.value;
		ajaxRequest.open("GET", "get_teriff_rate.php?carname_master_id="+car_reg_name, true);
		ajaxRequest.send(null);
	}
	//alert(service_name +" , "+car_name+" , "+customer_reg_name);
}

function cheak()
{     
      if(document.getElementById("type").checked==true)
	  {
	 document.getElementById("place").innerHTML="<input type='text' placeholder='Enter car number' class='m-wrap medium' name='car_reg_name' value=''>";	
	 document.getElementById("ajaxcarname").disabled=true; 
	 document.getElementById("ajaxcarname").value="";
	  }
	  else
	  {
		   document.getElementById("place").innerHTML="";
		    document.getElementById("ajaxcarname").disabled=false;
	  }
}
</script>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php  navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post"  name="add_form">
<div>                     
<a href="dutyslip_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="dutyslip_menu_edit.php" class="btn red"><i class="icon-edit"></i> Edit</a>
<a href="dutyslip_menu_edit_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
<a href="dutyslip_menu_waveoff.php" class="btn blue"><i class="icon-bar-chart"></i> Waveoff</a>
<a href="dutyslip_menu_print.php" class="btn blue"><i class="icon-print"></i> Print</a>
</div> 
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Update</h4>
                     </div>
                     <div class="portlet-body form">
                     <?php
				if(isset($_GET['id']))
				{
					$id= $_GET['id'];
                  	$qry="select * from duty_slip where dutyslip_id=".$id;
                	$data_base_object = new DataBaseConnect();
               		$result= $data_base_object->execute_query_return($qry);
                        if($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['dutyslip_id'];
                        	$dutyslipdate=$row['current_date'];
                        	$guest_name=$row['guest_name'];
                        	$contactnumber=$row['contactnumber'];
                        	$photo_id=$row['photo_id'];
                        	$service_service_id=$row['service_service_id'];
							$carname_master_id = $row['carname_master_id'];  // field car name
							$car_reg_name=$row['car_reg_name']; // field customer name
							$new_car_no = $row['new_car_no'];
							$customer_reg_name=$row['customer_reg_name']; // field customer name
							$detail_number=$row['detail_number'];
							$driver_reg_driver_id=$row['driver_reg_driver_id'];
							$opening_km = $row['opening_km'];  // field opening km
                        	$opening_time = $row['opening_time'];  // field opening km
							$closing_km=$row['closing_km'];  // 
							$closing_time=$row['closing_time'];
							$date_from = $row['date_from'];
							$date_to=$row['date_to'];
							$extra_chg=$row['extra_chg'];
							$permit_chg=$row['permit_chg'];
                            $parking_chg=$row['parking_chg'];
                            $otherstate_chg=$row['otherstate_chg'];
                            $guide_chg=$row['guide_chg'];
                            $misc_chg=$row['misc_chg'];
                            $remarks=$row['remarks'];
                            $rate=$row['rate'];
                            $authorized_person=$row['authorized_person'];
                            $date_authorization=$row['date_authorization'];
                            $reason = $row['reason'];
                        }
	                ?>
                <table width="100%" >
		        <tr><td width="30%;">Duty Slip Id :  </td><td><input class="m-wrap medium" type="text" name="dutyslip_id" readonly="readonly" value="<?php echo $idd;?>"/></td></tr>
		        <tr><td> Duty Slip Date: </td><td><input type="text" id="dp1" class="m-wrap medium" name="current_date" value="<?php echo DatePickerDate($dutyslipdate);?>"/> </td></tr>
		        <tr><td> Customer Name </td><td>
                <select name="customer_reg_name"  class="chosen" tabindex="1" id="autocomplete_customer_name" >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
										if($customer_reg_name==$row['id'])
										  echo '<option value="'.$row['id'].'"  selected=\"selected\">'.$row['name'].'</option>';
										else
										echo '<option value="'.$row['id'].'"  >'.$row['name'].'</option>';
									}
        				      ?>

     </select>
     
     </td></tr>
              	<tr><td> Guest Name </td><td><input type="text" name="guest_name" class="m-wrap medium" value="<?php echo $guest_name;?>"/></td></tr>
              	<tr><td> Contact Number </td><td><input type="text" name="contactnumber" class="m-wrap medium" value="<?php echo $contactnumber;?>"/></td></tr>
              	<tr><td> Detail Number: </td><td><input type="text" name="detail_number" class="m-wrap medium" value="<?php echo $detail_number;?>"/></td></tr>
              	<tr><td> Service:</td><td>
				<select name="service_service_id" id="service_service_id" class="chosen">
					<?php 
						$result= $data_base_object->execute_query_return("select * from `service`");
						while($row=mysql_fetch_array($result))
						{
							if($row['service_id']==$service_service_id)
							{
								echo '<option value="'.$row['service_id'].'" selected=\"selected\">'.$row['name'].'</option>';
							}
							else
							{
								echo '<option value="'.$row['service_id'].'">'.$row['name'].'</option>';
							}
						}
					?>
				</select>
				</td></tr>
              	<tr><td>Car:</td><td>
              	<select name="carname_master_id"  id="carname_master_id" class="chosen">
					<?php 
						$result= $data_base_object->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
						if($row['id']==$carname_master_id)
							{
							echo '<option value="'.$row['id'].'" selected=\"selected\">'.$row['name'].'</option>';
							}
							else 
							{
								echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
							}
						}
					?>
				</select>
              	</td></tr>
                <?php 
				if(!empty($car_reg_name))
				{
					?>
				<tr><td> Car Number </td><td> 
                <select name="car_reg_name" class="m-wrap medium" id="ajaxcarname" >	
                
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select `car_id`,`name` from car_reg");
						while($row=mysql_fetch_array($result))
						{
							if($row['car_id']==$car_reg_name)
							{
								echo "<option selected=\"selected\" value='".$row['car_id']."'>".$row['name']."</option>";
							}
							else 
							{
								echo "<option  value='".$row['car_id']."'>".$row['name']."</option>";
							}
						}
						$mydatabase->close_connection();
				?>
				</select>                 <input type='text' placeholder='Enter car number' class='m-wrap medium' name='new_car_no' value='<?php echo $new_car_no; ?>'>

               </td></tr>
                   <?php
				}
				else
				{
					?>
					<tr><td> Car Number </td><td> 
                <select name="car_reg_name" class="m-wrap medium"  >	
                <?php
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select `car_id`,`name`  from `car_reg`");
						while($row=mysql_fetch_array($result))
						{
							if($row['name']=='Others')
							{
								echo "<option selected=\"selected\"  value='".$row['car_id']."' >".$row['name']."</option>";
							}
							else
							{ 
								echo "<option  value='".$row['car_id']."' >".$row['name']."</option>";
							}
							
						}
						$mydatabase->close_connection();
				?>
				</select> 
                
                <input type='text' placeholder='Enter car number' class='m-wrap medium' name='new_car_no' value='<?php echo $new_car_no; ?>'>
                </td></tr>
				<?php
				}
				?>
                <tr>
                <td></td>
                <td id="place"></td>
                </tr>
				<tr><td>Rate</td><td><input type="text" name="rate" value="<?php echo $rate;?>" class="m-wrap medium" onmousedown="ajaxFunction('get_rate')" /> </td></tr>
				<tr><td> Driver Name: </td><td>
				<select name="driver_reg_driver_id" class="chosen">
					<?php 
						$result= $data_base_object->execute_query_return("select * from driver_reg");
						while($row=mysql_fetch_array($result))
						{
							if($row['driver_id']==$driver_reg_driver_id)
							{
								echo '<option value="'.$row['driver_id'].'"  selected=\"selected\">'.$row['name'].'</option>'; 
							}
							else{echo '<option value="'.$row['driver_id'].'">'.$row['name'].'</option>'; }
						}
						$data_base_object->close_connection();
					?>
				</select>
				</td></tr>
				<tr><td> Opening KM: </td><td>
				<input type="text" name="opening_km" value="<?php echo $opening_km;?>" class="m-wrap medium" onmousedown="ajaxFunction('get_closing')"/>
				</td></tr>
				<tr><td> Opening Time: </td><td>
				<select name="opening_time_hh" style="width: 75px;">
						<?php 
						$hh= substr($opening_time, 0,2);
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									if($hh=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($hh==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
									
							}
						?>
					</select>
					<select name="opening_time_mm" style="width: 75px;">
						<?php 
						$mm= substr($opening_time, 3,2);
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									if($mm=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($mm==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
				</td></tr>
				<tr><td> Travel Date From </td><td><input value="<?php echo DatePickerDate($date_from);?>" id="dp2"  class="m-wrap medium" type="text" name="date_from" /> </td></tr>
				<tr><td> Closing KM: </td><td>
				<input type="text" name="closing_km"  class="m-wrap medium" value="<?php echo $closing_km;?>"/>
				</td></tr>
				<tr><td> Closing Time: </td><td>
				<select name="closing_time_hh" style="width: 75px;">
						<?php 
						$hh= substr($closing_time, 0,2);
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									if($hh=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($hh==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
									
							}
						?>
					</select>
					<select name="closing_time_mm" style="width: 75px;">
						<?php 
						$mm= substr($closing_time, 3,2);
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									if($mm=="0".$i)
										echo "<option value=\"0".$i."\" selected=\"selected\">0".$i."</option>";
									else 
										echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
								if($mm==$i)
										echo "<option value=\"".$i."\" selected=\"selected\">".$i."</option>";
									else 
										echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
				</td></tr>
				<tr><td> Travel Date To </td><td><input value="<?php echo DatePickerDate($date_to);?>" class="m-wrap medium" id="dp3" type="text" name="date_to" /> </td></tr>
				<tr><td> Remarks: </td><td> <input type="text" value="<?php echo $remarks;?>" name="remarks"  class="m-wrap medium"/></td></tr>
				<tr><td> Authorized Person: </td><td> 
					<input type="text" value="<?php echo $authorized_person;?>" name="authorized_person" class="m-wrap medium"/>
				</td></tr>
				<tr><td> Date: </td><td> 
					<input type="text" value="<?php echo DatePickerDate($date_authorization);?>"  name="date_authorization" id="dp3" class="m-wrap medium"/>
				</td></tr>
				<tr><td> Reason: </td><td> 
					<input type="text" name="reason" class="m-wrap medium" value="<?php echo $reason;?>"/>
				</td></tr>
				<tr><td>  Toll Tax: </td><td> <input type="text" name="extra_chg" class="m-wrap medium" value="<?php echo $extra_chg;?>"/></td></tr>
				<tr><td> Permit Charges: </td><td> <input type="text" class="m-wrap medium"  name="permit_chg" value="<?php echo $permit_chg;?>"/></td></tr>
				<tr><td> Parking Charges: </td><td> <input type="text" class="m-wrap medium"  name="parking_chg" value="<?php echo $parking_chg;?>"/></td></tr>
				<tr><td> Driver Allowance: </td><td> <input type="text" class="m-wrap medium"  name="otherstate_chg" value="<?php echo $otherstate_chg;?>"/></td></tr>
				<tr><td> Border Tax: </td><td> <input type="text" name="guide_chg"  class="m-wrap medium" value="<?php echo $guide_chg;?>"/></td></tr>
				<tr><td> Miscellaneous Charges: </td><td> <input type="text" name="misc_chg" class="m-wrap medium" value="<?php echo $misc_chg;?>"/></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>
                <?php }?>
                <div class="form-actions">
                <button type="submit" name="dutyslip_update" style="margin-left:20%" class="btn green"><i class="icon-question-sign"></i> Save Change</button>
                </div>
                	</div>
                    </div>
                    </form>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>