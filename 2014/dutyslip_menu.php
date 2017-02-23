<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
date_default_timezone_set('Asia/Calcutta');	
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
</head>
<style>
td
{
	height:40px;
}
</style>
<script type="text/javascript">

function validateOKMS() 
{
	if(document.getElementById('opening_km').value>=0 && document.getElementById('opening_km').value<=999999)
	{
		
	}
	else
	{
		alert("Km cannot be more than 6 digits");
		document.getElementById('opening_km').value=parseInt(document.getElementById('opening_km').value/10);
	}
	
	
}
function validateOKMS1() 
{
	if(document.getElementById('opening_km').value =="0")
	{
	
	
		alert("Close previous DS.");
		window.location.href='dutyslip_menu.php';
	}
	
}
	


function validateCKMS() 
{
	if(document.getElementById('closing_km').value>=0 && document.getElementById('closing_km').value<=999999)
	{
		
	}
	else
	{
		alert("Km cannot be more than 6 digits");
		document.getElementById('closing_km').value=parseInt(document.getElementById('closing_km').value/10);
	}
}
function checkForBlank()
{
	var list = document.add_form.photo_id;
	var photoidval=	list.options[list.selectedIndex].text;
	list = document.add_form.service_service_id;
	var servicename=list.options[list.selectedIndex].text;
	list = document.add_form.carname_master_id;
	var carname=list.options[list.selectedIndex].text;
	list = document.add_form.driver_reg_driver_id;
	var drivername=list.options[list.selectedIndex].text;
	
	var date_from = document.add_form.date_from.value;
	var openingkm = document.add_form.opening_km.value;
	
	var date_to = document.add_form.date_to.value;
	var closingkm = document.add_form.closing_km.value;
	
	
	if(document.add_form.customer_reg_name.value=="")
	{
		alert("plz Enter Customer Name");
		return false;
	}
	else if(photoidval=='-select-')
	{
		alert("plz select photo id");
		return false;
	}
	else if(servicename=='-select-')
	{
		alert("plz select service ");
		return false;
	}
	else if(carname=='-select-')
	{
		alert("plz select car name");
		return false;
	}
	else if(drivername=='-select-')
	{
		alert("plz select driver name");
		return false;
	}
//	else if(closingkm!='' && openingkm>=closingkm)
//	{
//		alert("closing KM must be greater than opening KM");
//		return false;
//	}
	else if(openingkm=="" || date_from=="")
	{
		if(openingkm!="" && date_from=="")
		{
			alert("You must select date from ");
			return false;
		}
		else if(openingkm=="" && date_from!="")
		{
			alert("you must enter opening km");
			return false;
		}
	}
	else if(closingkm=="" || date_to=="")
	{
		if(closingkm!="" && date_to=="")
		{
			alert("You must select date to ");
			return false;
		}
		else if(closingkm=="" && date_to!="")
		{
			alert("you must enter closing km");
			return false;
		}
		
	}
	return true;
}

function WaveOff(id)
{
	var reason=prompt("Reason for waveoff ?","");	
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
			if(ajaxRequest.responseText=="completed")
			{
				location.reload();
			}
			else
			{
				alert("Problem");
			}
		}
	}

		
		ajaxRequest.open("GET", "get_teriff_rate.php?waveoff="+id+"&reason="+reason, true);
		ajaxRequest.send(null);
}


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
		var customer_reg_name = document.getElementById("autocomplete_dutyslip_customer_reg_name").value;
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
  
		  
</script>
<script type="text/javascript">
 var xobj;
   //modern browers
   if(window.XMLHttpRequest)
    {
	  xobj=new XMLHttpRequest();
	  }
	  //for ie
	  else if(window.ActiveXObject)
	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
		  alert("Your broweser doesnot support ajax");
		  }
		  
	  function getNumber()
		  {
	       if(xobj)
			 {
			var c1=document.getElementById("carname_master_id").value;
			 var query="?con=" + c1;
			 xobj.open("GET","ajax_for_car_number.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("txt_my_carnumber").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }	  
		  
		  function cheak()
{     
      if(document.getElementById("type").checked==true)
	  {
			document.getElementById("place").innerHTML="<input type='text' placeholder='Enter car number' class='m-wrap medium' name='new_car_no' value=''>";
			document.getElementById("ajaxcarname").value="";	
			document.getElementById("ajaxcarname").disabled=true; 
	  }
	  else
	  {
			document.getElementById("place").innerHTML="";
			document.getElementById("ajaxcarname").disabled=false;
	  }
}
</script>
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
     <form method="post" target="_blank" action="dutyslip_submitcode.php" name="add_form"  onsubmit="return checkForBlank()">

                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-map-marker"></i> Duty Silp</h4>
                    </div>
                    <div class="portlet-body form">
                 <table width="100%">
		        <tr><td width="30%;"> Duty Slip Date: </td><td><label style="width: 250px;"><?php echo date('d-m-Y');?></label> </td></tr>
		        <tr><td> Customer Name </td><td> 
                <select name="customer_reg_name" id="autocomplete_dutyslip_customer_reg_name" class="chosen"  tabindex="1"  >
    							 <option value="" ></option>
    								    <?php 
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$row['id'].'">'.$name.'</option>';
									}
        				      ?>
     </select></td></tr>
              	<tr><td> Guest Name </td><td><input type="text" name="billing_name"  class="m-wrap medium"/></td></tr>
              	<tr><td> Contact Number </td><td><input type="text" name="contactnumber"   class="m-wrap medium"/></td></tr>
              	<tr><td> Photo Id: </td><td>
              		<select name="photo_id" class="m-wrap medium">
              		<option>select</option>
              			<option>Passport Number</option>
              			<option>Driving Licence</option>
              			<option>EC Card</option>
              			<option>Pan Card</option>
              			<option>Others</option>
              		</select>
              	</td></tr>
              	<tr><td> Detail Number: </td><td><input type="text" class="m-wrap medium" name="detail_number" /></td></tr>
              	<tr><td> Service</td><td>
				<select name="service_service_id" id="service_service_id" class="chosen" >
				<option>select</option>
					<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from service");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['service_id'].'">'.$row['name'].'</option>';
						}
						$mydatabase->close_connection();
					?>
				</select>
				</td></tr>
              	<tr><td>Car:</td><td>
              	<select name="carname_master_id"  class="chosen"  id="carname_master_id">
              	<option>select</option>
					<?php 
					    $mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from carname_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
						}
						$mydatabase->close_connection();
					?>
				</select>
              	</td></tr>
				<tr><td> Car Number </td>
                <td>
                <select name="car_reg_name" class="m-wrap medium" id="ajaxcarname">	
						<option value="">Select Type</option>
				<?php 
				$mydatabase = new DataBaseConnect();
				$result= $mydatabase->execute_query_return("select * from car_reg");
				while($row=mysql_fetch_array($result))
				{
					echo '<option value="'.$row['car_id'].'">'.$row['name'].'</option>';
				}
				$mydatabase->close_connection();
				?>
				</select>  <label class="checkbox">
                    <input type="checkbox" value="same" id="type"  style="margin-left:1%" onClick="cheak();">&nbsp;New Car Number
                    </label></td></tr>
                 <tr>
                <td></td>
                <td id="place"></td>
                </tr>
				<tr><td>Rate</td><td><input type="text" name="rate" class="m-wrap medium"  onmousedown="ajaxFunction('get_rate')" /> </td></tr>
				<tr><td> Driver Name: </td><td>
				<select name="driver_reg_driver_id" class="chosen">
				<option>select</option>
					<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from driver_reg");
						while($row=mysql_fetch_array($result))
						{
							echo  '<option value="'.$row['driver_id'].'">'.$row['name'].'</option>';  
						}
						$mydatabase->close_connection();
					?>
				</select>
				</td></tr>
				<tr><td> Opening KM: </td><td>
				<input id="opening_km" onkeyup="validateOKMS()" class="m-wrap medium" onClick="validateOKMS1()" type="text" name="opening_km" onmousedown="ajaxFunction('get_closing')"/>
				</td></tr>
				<tr><td>Opening Time: </td><td>
				<select name="opening_time_hh" style="width: 75px;">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="opening_time_mm" style="width: 75px;">
						<?php 
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
				</td></tr>
				<tr><td> Travel Date From </td><td><input id="dp1" class="m-wrap medium" type="text" name="date_from" /> </td></tr>
				<tr><td> Closing KM: </td><td>
				<input type="text" id="closing_km" class="m-wrap medium" name="closing_km" onkeyup="validateCKMS()"/>
				</td></tr>
			 	<tr><td> Closing Time: </td><td>
				<select name="closing_time_hh" style="width: 75px;">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="closing_time_mm" style="width: 75px;">
						<?php 
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
				</td></tr>
				<tr><td> Travel Date To </td><td><input id="dp2" class="m-wrap medium" type="text" name="date_to" /> </td></tr>
				<tr><td> Remarks: </td><td> <input type="text" name="remarks"  class="m-wrap medium"/></td></tr>
				<tr><td> Authorized Person: </td><td> 
					<input type="text" readonly="readonly" value="<?php echo $_SESSION['username'];?>" name="authorized_person"  class="m-wrap medium"/>
				</td></tr>
				<tr><td> Date: </td><td> 
					<input type="text" readonly="readonly" value="<?php echo date('Y-m-d');?>"  name="date_authorization"   class="m-wrap medium" />
				</td></tr>
				<tr><td> Reason: </td><td> 
					<input type="text" name="reason" class="m-wrap medium"/>
				</td></tr>
                <tr><td>  Toll Tax: </td><td> <input type="text" name="extra_chg" class="m-wrap medium" /></td></tr>
				<tr><td> Permit Charges: </td><td> <input type="text" class="m-wrap medium"  name="permit_chg" /></td></tr>
				<tr><td> Parking Charges: </td><td> <input type="text" class="m-wrap medium"  name="parking_chg" /></td></tr>
				<tr><td> Driver Allowance: </td><td> <input type="text" class="m-wrap medium"  name="otherstate_chg" /></td></tr>
				<tr><td> Border Tax: </td><td> <input type="text" name="guide_chg"  class="m-wrap medium" /></td></tr>
				<tr><td> Miscellaneous Charges: </td><td> <input type="text" name="misc_chg" class="m-wrap medium" /></td></tr>
				<tr><td></td><td>&nbsp;</td></tr>
                </table>  
                <br>
  
                     <div class="form-actions">
                   <button type="submit" style="margin-left:20%"   class="btn green" name="duty_slip"/><i class="icon-ok"></i> Submit</button>
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