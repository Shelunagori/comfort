<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
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
     <form method="post">
<!--<div>                     
<a href="dutyslip_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="dutyslip_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="dutyslip_menu_edit_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
<a href="dutyslip_menu_waveoff.php" class="btn blue"><i class="icon-bar-chart"></i> Waveoff</a>
<a href="dutyslip_menu_print.php" class="btn blue"><i class="icon-print"></i> Print</a>
</div> -->
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-search"></i>Search</h4>
                     </div>
                     <div class="portlet-body form">
                    <table width="100%">
						 <tr><td> Duty Slip Id:</td><td><input type="text" class="m-wrap medium" name="dutyslip_id" /></td></tr>
				          <tr><td> Service</td><td>
							<select name="service_service_id" class="chosen">
							<option value="">Service</option>
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

						 <tr><td> Customer Name : </td><td><select name="customer_reg_name1"  class="chosen">
    							 <option value="">Customer Name</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									   echo '<option value="'.$row['id'].'" ">'.$row['name'].'</option>';
									}
									$mydatabase->close_connection();
        				      ?>

                               </select></td></tr>
                           <tr><td> Authorized Person : </td><td><input type="text" class="m-wrap medium" name="authorized_person" />
                              <button type="submit"  class="btn green" name="dutyslip_edit" style="margin-left:1%;" />Go <i class="icon-circle-arrow-right"></i></button> </td></tr>
						 <tr><td></td><td>
                      
</td></tr>
						 </table>
                         <?php
				if(isset($_POST['dutyslip_edit']))
				{
					?> 
					 <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%"  class="table table-bordered" id="sample_1" style="border-collapse:collapse;border:1px solid silver;">
                    <thead>
                        <tr>
                        <th >DSNo</th>
                        <th >Guest Name</th>
                        <th >Service</th>
                        <th >Car</th>
						<th >Car No.</th>
                        <th >Driver Name</th>
                        <th >Date</th>                        
                        <th >Ope.KM</th>
                        <th >Clo.KM</th>
                        <th >View|Pdf|Wo</th>
                        </tr>
                        </thead>
                    	<tbody>
                     <?php       
                    if(!isset($_GET['dutyslip_waveoff']))
                    {    
				$q1=""; $q2=""; $q3="";$q4="";	
				if(!empty($_POST['dutyslip_id']))
				{
					$dutyslip_id=$_POST['dutyslip_id'];
					$q1=" dutyslip_id='".$dutyslip_id."'";
				}
				if(!empty($_POST['service_service_id']))
				{
					$service_service_id=$_POST['service_service_id'];
					if($q1=="")
						$q2=" service_service_id='".$service_service_id."'";
					else
						$q2=" AND service_service_id='".$service_service_id."'";
				}
				if(!empty($_POST['customer_reg_name1']))
				{
					$customer_reg_name1=$_POST['customer_reg_name1'];
					if($q1=="" && $q2=="")
						$q3=" customer_reg_name='".$customer_reg_name1."'";
					else 
						$q3=" AND customer_reg_name='".$customer_reg_name1."'";
				}
				if(!empty($_POST['authorized_person']))
				{
					$authorized_person=$_POST['authorized_person'];
					if($q1=="" && $q2=="" && $q3=="")
						$q4=" authorized_person='".$authorized_person."'";
					else 
						$q4=" AND authorized_person='".$authorized_person."'";
				}
                    
                   
					//	if($q1=="" && $q2=="" && $q3="")
					//		$qry="select * from duty_slip ";
					//	else 
						$qry="select * from duty_slip ";
						if($q1!="" || $q2!="" || $q3!="" || $q4!="")
						   $qry.=" where ";
                   
                        	$sql=$qry.$q1.$q2.$q3.$q4." order by `dutyslip_id`";
                    }
                    else {
                    	
                    $q1=""; $q2="";
				if(!empty($_POST['countername']))
				{
					$countername=$_POST['countername'];
					$q1=" countername='".$countername."'";
				}
				if(!empty($_POST['authorized_person']))
				{
					$authorized_person=$_POST['authorized_person'];
					if($q1=="")
						$q2=" authorized_person='".$authorized_person."'";
					else
						$q2=" AND authorized_person='".$authorized_person."'";
				}
				$qry="select * from `duty_slip_waveoff` ";
						if($q1!="" || $q2!="")
						   $qry.=" where ";
                  
                        	$sql=$qry.$q1.$q2." order by `dutyslip_id`";
                    }   
                      //  	echo $sql;
                            $data_base_object = new DataBaseConnect();
                        	$result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
							
                        	$idd=$row['dutyslip_id'];
							$current_date=$row['current_date'];
							$billing_name=$row['guest_name'];
							$service_service_id=$row['service_service_id'];
							$service_all=mysql_query("select * from `service` where `service_id` = '$service_service_id'  ");
							$ftc_service=mysql_fetch_array($service_all);
							$name_service = $ftc_service['name'];
							$carname_master_id=$row['carname_master_id'];
							$car_all=mysql_query("select * from `carname_master` where `id` = '$carname_master_id'  ");
							$ftc_car=mysql_fetch_array($car_all);
							$car_name = $ftc_car['name'];
							
							$car_reg_name=$row['car_reg_name'];
							
							$new_car_no = $row['new_car_no'];
							
							$qry_fetch_carid="select * from `car_reg` where `car_id`='".$car_reg_name."'";
							$data_base_object = new DataBaseConnect();
							$result_carid = $data_base_object->execute_query_return($qry_fetch_carid);
							$row_carid = mysql_fetch_array($result_carid);
							$car_reg_name_new=$row_carid['name'];
							if($car_reg_name_new=="Others")
							{
							$car_reg_name_new=$new_car_no;
							}
							
							$driver_reg_driver_id=$row['driver_reg_driver_id'];
							$driver_all=mysql_query("select * from `driver_reg` where `driver_id` = '$driver_reg_driver_id'  ");
							$ftc_driver=mysql_fetch_array($driver_all);
							$driver_name = $ftc_driver['name'];
                            $opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $status=$row['status'];
                            $reason=$row['reason'];
							if($status=="no")
							{
                       ?>
                            <tr>
                            <td><a href="update_dutyslip.php?id=<?php echo $row['dutyslip_id'];?>" target="_new" ><b><?php echo $row['dutyslip_id'];?></b></a></td>
                            <td><?php echo $billing_name;?></td>
                            <td><?php echo $name_service;?></td>
                            <td><?php echo $car_name;?></td>
							<td><?php echo $car_reg_name_new;?></td>
                            <td><?php echo $driver_name;?></td>
                            <td><?php echo date("d-M-Y", strtotime($current_date));?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                              <td><a class="btn mini blue"  role="button" href="view_dutyslip.php?dutyslip=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                 <a class="btn mini red"  role="button" href="dutislip_pdf.php?dutyslip=true&id=<?php echo $idd;?>"  target="_blank" style="text-decoration:none;">
    							<i class="icon-download-alt"></i></a>
                                 <a class="btn mini green"  role="button" href="javascript:WaveOff(<?php echo $idd;?>)"   style="text-decoration:none;">
    							<i class="icon-bar-chart"></i></a>
                            </td>
                            	<?php 
							}
							else if($status=="yes")
							{
								?>
                               <tr  style="background-color:#DFF0D8;">
                            <td><a href="update_dutyslip.php?id=<?php echo $row['dutyslip_id'];?>" target="_new" ><b><?php echo $row['dutyslip_id'];?></b></a></td>
                            <td><?php echo $billing_name;?></td>
                            <td><?php echo $name_service;?></td>
                            <td><?php echo $car_name;?></td>
							<td><?php echo $car_reg_name_new;?></td>
                             <td><?php echo $driver_name;?></td>
                            <td><?php echo date("d-M-Y", strtotime($current_date));?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                              <td><a class="btn mini blue"  role="button" href="view_dutyslip.php?dutyslip=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                 <a class="btn mini red"  role="button" href="dutislip_pdf.php?dutyslip=true&id=<?php echo $idd;?>"  target="_blank" style="text-decoration:none;">
    							<i class="icon-download-alt"></i></a>
                                
                            </td>  
                                <?php
							}
								}
					    	?>
                            </tr>
                        <?php
						}
                        }
					?>
                     </tbody>
                    </table> 
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