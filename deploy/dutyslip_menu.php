<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title><?php title(); ?></title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
	<?php logo(); ?>
    <?php css(); ?>
    <?php ajax(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript">
function checkForBlank()
{	

	var date_from = document.add_form.date_from.value;
	var openingkm = eval(document.add_form.opening_km.value);
	var date_to = document.add_form.date_to.value;
	var closingkm = eval(document.add_form.closing_km.value);
	
	if(document.add_form.customer_id.value=="")
	{
		alert("plz Enter Customer Name");
		return false;
	}
	else if(document.add_form.photo_id.value=="")
	{
		alert("plz select photo id");
		return false;
	}
	else if(document.add_form.service_id.value=="")
	{
		alert("plz select service ");
		return false;
	}
	else if(document.add_form.car_type_id.value=="")
	{
		alert("plz select car name");
		return false;
	}
	else if(document.add_form.driver_id.value=="")
	{
		alert("plz select driver name");
		return false;
	}
/*	else  if(openingkm==undefined || closingkm==undefined)
	{	
		 if(openingkm==undefined)
		{	
			alert("you must enter opening km");
			return false;
		}
		else if(closingkm==undefined)
		{	
			alert("you must enter closing km");
			return false;
		}
		
	}    */
	else if(date_from=="" || date_to=="")
	{
		if(date_from=="")
		{
			alert("You must select date from ");
			return false;
		}
	/*	else if(date_to=="")
		{
			alert("You must select date to ");
			return false;
		}
			*/
	}
	else if(closingkm!='' && openingkm>=closingkm)
	{
		alert("closing KM must be greater than opening KM");
		return false;
	}
	return true;
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
     <?php temp(); ?>
    	<?php
		if(isset($_POST['customer_edit']))
		{
							if(isset($_GET['dutyslip_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> DutySlip Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['dutyslip_waveoff']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> DutySlip Waveoff</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i> DutySlip Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>SL.</th>
                       	<th>DS ID</th>
                        <th>Guest</th>
                        <th>Service</th>
                        <th>Driver</th>
                        <th>Car</th>
						<th>Car No.</th>
                        <th>Date</th>                        
                        <th>Open. KM</th>
                        <th>Clos. KM</th>
                         <?php
							if(isset($_GET['dutyslip_view']))
							{
								?>
                                 <th>View|PDF|WO</th>
                                 <?php
							}
							else if(isset($_GET['dutyslip_waveoff']))
							{
								?>
                                 <th>Waveoff</th>
                                 <?php
							}
							else 
							{
								?>
                                 <th>Edit</th>
                                 <?php
							}
							
							?>
                        </tr>
                    </thead>
                   	<tbody>
                    <?php
				$q1="";	$q2="";	$q3=""; $q4="";
				if(!empty($_POST['id']))
				{
					$id=$_POST['id'];
					$q1="id='".$id."'";
				}
				if(!empty($_POST['service_id']))
				{
					$service_id=$_POST['service_id'];
					if($q1=="")
						$q2=" service_id='".$service_id."'";
					else 
						$q2=" AND service_id='".$service_id."'";
				}
				if(!empty($_POST['customer_id']))
				{
					$customer_id=$_POST['customer_id'];
					if($q1=="" && $q2=="")
						$q3=" customer_id='".$customer_id."'";
					else 
						$q3=" AND customer_id='".$customer_id."'";
				}
				if(!empty($_POST['driver_id']))
				{
					$driver_id=$_POST['driver_id'];
					if($q1=="" && $q2=="" && $q3=="")
						$q4=" driver_id='".$driver_id."'";
					else
						$q4=" AND driver_id='".$driver_id."'";
				}
                if($q1=="" && $q2=="" && $q3=="" && $q4=="")
                	$qry ="select * from duty_slip";
                else    
					$qry="select * from duty_slip where ";
                        $sql=$qry.$q1.$q2.$q3.$q4;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							if(!empty($row['temp_car_no']))
							$car_number=$row['temp_car_no'];
							else
							$car_number=fetchcarno($row['car_id']);
							
							if(!empty($row['temp_driver_name']))
							$driver_name=$row['temp_driver_name'];
							else
							$driver_name=fetchdrivername($row['driver_id']);
					?>
                      		<tr id="<?php echo $i; ?>" <?php if($row['billing_status']=='yes'){ ?>  title="Billing have been Done" style="background-color:#DFF0D8;" <?php }
							else if($row['waveoff_status']==1) {?> title="This is waveoff ds" style="background-color:#F2DEDE;" <?php } ?>>
                            <td><?php echo $i;?></td>
                            <td><?php echo $idd;?></td>
                            <td><?php echo $row['guest_name'];?></td>
                            <td><?php echo fetchservicename($row['service_id']);?></td>
                            <td><?php echo $driver_name;?></td>
                            <td><?php echo fetchcarname($row['car_type_id']);?></td>
                            <td><?php echo $car_number;?></td>
                            <td><?php echo dateforview($row['date']);?></td>
                            <td><?php echo $row['opening_km'];?></td>
                            <td><?php echo $row['closing_km'];?></td>
                         <?php
							if(isset($_GET['dutyslip_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="dutyslip_view.php?dutyslip=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
   <a class="btn mini red"  role="button" href="pdf.php?dutyslip=true&id=<?php echo $idd;?>"   style="text-decoration:none;">
    							<i class="icon-download-alt"></i></a>
                            <?php
							if($row['waveoff_status']!=1)
							{?>    
    <a class="btn mini green" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-bar-chart"></i></a>   
    
 <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#5CB85C"><i class="icon-bar-chart"></i> <b><?php echo $row['guest_name']; ?></b></span></h4>
                        </div>
                        <div class="modal-body">
                       
                        <div class="controls">
                        <input type="text"  name="waveoff_reason" id="waveoff_reason<?php echo $i; ?>" placeholder="Enter Waveoff Reason" class="span12 m-wrap">
                        </div>   
                        
                        </div>
                        <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                        <button type="button"  onClick="delete_dutyslip(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn green"><i class="icon-bar-chart"></i> Waveoff Now</button>
                        </div>
                        </div>   
                        <?php } ?>
                                                                                  
                                </td>
                                 <?php
							}
							else if(isset($_GET['dutyslip_waveoff']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-bar-chart"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-bar-chart"></i> <b><?php echo $row['guest_name']; ?></b></span></h4>
                            </div>
                            <div class="modal-body">
                           
                            <div class="controls">
                            <input type="text"  name="waveoff_reason" id="waveoff_reason<?php echo $i; ?>" placeholder="Enter Waveoff Reason" class="span12 m-wrap">
                            </div>   
                            
                            </div>
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_dutyslip(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-bar-chart"></i> Waveoff Now</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								
								?>
                                 <td>
                                  <?php 
								  if($row['billing_status']=='no')
								  {?>
                                 <a class="btn mini red"  role="button" href="update_dutyslip.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>		<?php }
								 else { ?>
                                  <a class="btn mini red"  title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal_wave<?php echo $i ?>" style="text-decoration:none;"><i class="icon-edit"></i></a>	
                                    <div style="display: none;" id="myModal_wave<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B;font-size:13px;"><strong>Note: You Can't Edit This DS Because Billing have been Completed.</strong></span></h4>
                            </div>
                       
                            <div class="modal-footer">
                            <button class="btn red" data-dismiss="modal" aria-hidden="true">Ok</button>	
                            </div>
                            </div>         
                                 <?php
								 }
								 ?>
                                </td>
                                 <?php
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
               <?php
		}
		else if(isset($_GET['mode']))
		{
			if($_GET['mode']=='edit')
			{
				?>
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>DutySlip Edit</h4>
                        </div>
                        <div class="portlet-body form">
                       <form action="dutyslip_menu.php?dutyslip_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>DutySlip ID</td>
                        <td><input type="text" name="id" class="m-wrap medium"></td>
                        <td>Service Name</td>
                        <td>
                        <select name="service_id" id="service_id" class="m-wrap medium chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from service");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Name</td>
                        <td> 
                        <select name="customer_id" id="customer_id" class="m-wrap medium chosen" >	
                        <option value="">---select customer---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        <td>Driver Name</td>
                        <td>
                        <select name="driver_id" class="m-wrap medium chosen" >	
                        <option value="">---select driver---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from driver_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                 <?php
			}
			else if($_GET['mode']=='del')
			{
				?>
                		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-trash"></i>DutySlip Waveoff</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="dutyslip_menu.php?dutyslip_waveoff=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>DutySlip ID</td>
                        <td><input type="text" name="id" class="m-wrap medium"></td>
                        <td>Service Name</td>
                        <td>
                        <select name="service_id" id="service_id" class="m-wrap medium chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from service");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Name</td>
                        <td> 
                        <select name="customer_id" id="customer_id" class="m-wrap medium chosen" >	
                        <option value="">---select customer---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        <td>Driver Name</td>
                        <td>
                        <select name="driver_id" class="m-wrap medium chosen" >	
                        <option value="">---select driver---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from driver_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
			else if($_GET['mode']=='view')
			{
				?>
                		<div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>DutySlip View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="dutyslip_menu.php?dutyslip_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>DutySlip ID</td>
                        <td><input type="text" name="id" class="m-wrap medium"></td>
                        <td>Service Name</td>
                        <td>
                        <select name="service_id" id="service_id" class="m-wrap medium chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from service");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Name</td>
                        <td> 
                        <select name="customer_id" id="customer_id" class="m-wrap medium chosen" >	
                        <option value="">---select customer---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        <td>Driver Name</td>
                        <td>
                        <select name="driver_id" class="m-wrap medium chosen" >	
                        <option value="">---select driver---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from driver_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
                        </td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
		}
		else
		{
		?>
        <form  name="add_form"  class="form-horizontal" method="post" onsubmit="return checkForBlank()">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Dutyslip Add</h4>
        <h4 style="float:right;"><?php echo date("d/M/Y"); ?></h4>
        </div>
        <div class="portlet-body form">
        
        <div class="control-group">
        <label class="control-label">Customer Name</label>
        <div class="controls">
        <select name="customer_id" id="customer_id" class="span6 m-wrap chosen" >	
        <option value="">---select customer---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from customer_reg");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Guest Name</label>
        <div class="controls">
	    <input type="text" name="guest_name" class="span6 m-wrap" />
      	</div>
        </div>
        
        
        <div class="control-group">
        <label class="control-label">Mobile Number</label>
        <div class="controls">
        <input type="text" name="mobile_no" id="mobileno" class="span6 m-wrap" />
        </div>
        </div>

         <div class="control-group">
        <label class="control-label">Email Address</label>
        <div class="controls">
        <input type="email" name="email_id" id="email_id" class="span6 m-wrap" />
        </div>
        </div>
        
     
      	<div class="control-group">
        <label class="control-label">Photo Id</label>
        <div class="controls">
        <select name="photo_id" class="span6 m-wrap">
        <option value="">---select photo ID---</option>
        <option value="Passport Number">Passport Number</option>
        <option value="Driving Licence">Driving Licence</option>
        <option value="EC Card">EC Card</option>
        <option value="Pan Card">Pan Card</option>
        <option value="Others">Others</option>
        </select>
        </div>
        </div>
       
        <div class="control-group">
        <label class="control-label">Detail Number</label>
        <div class="controls">
        <input type="text" name="detail_no" class="span6 m-wrap">
        </div>
        </div>
        
		
         
        <div class="control-group">
        <label class="control-label">Car</label>
        <div class="controls">
        <select name="car_type_id" id="car_type_id" class="span6 m-wrap chosen" >	
	    <option value="">---select car---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_type");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Car Number</label>
        <div class="controls">
        <select name="car_id" class="span6 m-wrap chosen" onChange="cheak();">	
	    <option value="">---select car no---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_reg");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        <span  id="will_be"></span>
        </div>
        </div>
        
		
        <div class="control-group">
        <label class="control-label">Service</label>
        <div class="controls">
        <select name="service_id" id="service_id" class="span6 m-wrap chosen" >	
	    <option value="">---select service---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from service");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        
        <div class="control-group">
        <label class="control-label">Driver Name</label>
        <div class="controls">
        <select name="driver_id" class="span6 m-wrap chosen" onChange="cheak_driver();">	
	    <option value="">---select driver---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from driver_reg");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        <span  id="will_be_driver"></span>
        </div>
        </div>
       
        <div class="control-group">
        <label class="control-label">Rate</label>
        <div class="controls">
        <input type="text" name="rate" autocomplete="off" onKeyUp="allLetter(this.value,this.id)" id="rate" onMouseDown="fetch_rate('get_rate');" class="span6 m-wrap" />
        </div>
        </div>  
        
    
   		<div class="control-group">
        <label class="control-label">Opening KM</label>
        <div class="controls">
        <input type="text" name="opening_km" id="opening_km"  onMouseDown="fetch_rate('get_km')" autocomplete="off"  onClick="dutyslip_openclose();" class="span6 m-wrap" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Closing KM</label>
        <div class="controls">
        <input type="text" name="closing_km" id="closing_km" class="span6 m-wrap" autocomplete="off"   onkeyup="validateCKMS()"/>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Opening Time</label>
        <div class="controls">
         <select name="opening_time_hh" class="span3 m-wrap">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="opening_time_mm" class="span3 m-wrap">
						<?php 
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
                    </div>
                    </div>
                    
        <div class="control-group">
        <label class="control-label">Closing Time</label>
        <div class="controls">
        <select name="closing_time_hh" class="span3 m-wrap">
						<?php 
							for ($i = 0; $i <24; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
					<select name="closing_time_mm" class="span3 m-wrap">
						<?php 
							for ($i = 0; $i <=60; $i++) {
								if($i<10)
									echo "<option value=\"0".$i."\">0".$i."</option>";
								else 
									echo "<option value=\"".$i."\">".$i."</option>";
							}
						?>
					</select>
            </div>
            </div>
                    
        
        <div class="control-group">
        <label class="control-label">Travel Date From</label>
        <div class="controls">
        <input class="span6 m-wrap date-picker" onClick="mydatepick();" type="text" name="date_from" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Travel Date To</label>
        <div class="controls">
        <input class="span6 m-wrap date-picker" onClick="mydatepick();" type="text" name="date_to" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Toll Tax</label>
        <div class="controls">
        <input class="span6 m-wrap" type="text" name="extra_chg" id="extra_chg" onKeyUp="allLetter(this.value,this.id)"/>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Permit Charges</label>
        <div class="controls">
        <input class="span6 m-wrap"  type="text" name="permit_chg" id="permit_chg" onKeyUp="allLetter(this.value,this.id)"/>
        </div>
        </div>
      
       
         <div class="control-group">
        <label class="control-label">Parking Charges</label>
        <div class="controls">
        <input type="text" class="span6 m-wrap"  name="parking_chg" id="parking_chg" onKeyUp="allLetter(this.value,this.id)"/>
        </div>
        </div>
        
     
        <div class="control-group">
        <label class="control-label">Driver Allowance</label>
        <div class="controls">
        <input type="text" class="span6 m-wrap"  name="otherstate_chg" id="otherstate_chg" onKeyUp="allLetter(this.value,this.id)"/>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Border Tax</label>
        <div class="controls">
        <input type="text" name="guide_chg"  class="span6 m-wrap" id="guide_chg" onKeyUp="allLetter(this.value,this.id)"/>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Miscellaneous Charges</label>
        <div class="controls">
        <input type="text" name="misc_chg" class="span6 m-wrap"  id="misc_chg" onKeyUp="allLetter(this.value,this.id)" />
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Remarks</label>
        <div class="controls">
        <input type="text" name="remarks"  class="span6 m-wrap"/>
        </div>
        </div>
        
      	<div class="control-group">
        <label class="control-label">Reason</label>
        <div class="controls">
        <input type="text" name="reason"  class="span6 m-wrap"/>
        </div>
        </div>
        
        
        <div class="form-actions">
        <button type="submit"   formaction="dutyslip_menu_submit.php" formtarget="_blank"  title="You are done ?" class="btn green" name="dutyslip_reg"/><i class="icon-ok"></i> Submit</button>
        </div>
        </div>
        </div> 
        </form>
        <?php	
		}
		?>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
<div class="footer">
<?php footer();?>
</div>
<?php js(); ?> 
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>