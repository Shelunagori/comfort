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
		if(isset($_POST['tariff_edit']))
		{
							if(isset($_GET['customer_tariff_rate_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Customer Tariff Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['customer_tariff_rate_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Customer Tariff Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i> Customer Tariff Update</h4>
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
                        <th>Customer Name</th>
                        <th>Service Name</th>
                        <th>Car</th>
                        <th>Rate</th>
                        <th>Kilometers</th>
                        <th>Extra KM Rate</th>
                        <th>Min.Charge Hourly</th>
                       	<th>Extra Hour Rate</th>
                         <?php
							if(isset($_GET['customer_tariff_rate_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['customer_tariff_rate_delete']))
							{
								?>
                                 <th>Delete</th>
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
						$q1="";	$q2="";	
						if(!empty($_POST['customer_id']))
						{
						$customer_id=$_POST['customer_id'];
						$q1="customer_id='".$customer_id."'";
						}
						if(!empty($_POST['car_type_id']))
						{
						$car_type_id=$_POST['car_type_id'];
						if($q1=="")
						$q2=" car_type_id='".$car_type_id."'";
						else 
						$q2=" AND car_type_id='".$car_type_id."'";
						}
						$qry="select * from customer_tariff where ";
						if($q1=="" && $q2=="")
						$sql="select * from customer_tariff";
						else
						$sql=$qry.$q1.$q2;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$cust_name=fetchcustomername($row['customer_id']);
							$service_name=fetchservicename($row['service_id']);
							$car_name=fetchcarname($row['car_type_id']);
							$rate = $row['rate'];
							$minimum_chg_km = $row['minimum_chg_km'];
							$extra_km_rate = $row['extra_km_rate'];
							$minimum_chg_hourly = $row['minimum_chg_hourly'];
							$extra_hour_rate = $row['extra_hour_rate'];
					?>
                      		<tr id="<?php echo $i; ?>">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $cust_name; ?></td>
                            <td><?php echo $service_name;?></td>
                            <td><?php echo $car_name;?></td>
                            <td><?php echo $rate;?></td>
                            <td><?php echo $minimum_chg_km;?></td>
                            <td><?php echo $extra_km_rate;?></td>
                            <td><?php echo $minimum_chg_hourly;?></td>
                            <td><?php echo $extra_hour_rate;?></td>
                         <?php
							if(isset($_GET['customer_tariff_rate_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?customer_tariff=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['customer_tariff_rate_delete']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $cust_name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_customer_tariff(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_customer_tariff.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
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
                        <h4><i class="icon-edit"></i>Customer Tariff Edit</h4>
                        </div>
                        <div class="portlet-body form">
                          <form action="customer_tariff_rate_menu.php?customer_tariff_rate_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer</td>
                        <td> 
                        <select name="customer_id" class="chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
       					</td>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="chosen" >	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from car_type");
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
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="tariff_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-trash"></i>Customer Tariff Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                     <form action="customer_tariff_rate_menu.php?customer_tariff_rate_delete=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer</td>
                        <td> 
                        <select name="customer_id" class="chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
       					</td>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="chosen" >	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from car_type");
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
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="tariff_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-search"></i>Tariff View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="customer_tariff_rate_menu.php?customer_tariff_rate_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer</td>
                        <td> 
                        <select name="customer_id" class="chosen" >	
                        <option value="">---select service---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from customer_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
       					</td>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="chosen" >	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select distinct `id`,`name` from car_type");
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
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="tariff_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
        <form  name="form_name" action="Handler.php" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Customer Tariff Rate</h4>
        </div>
        <div class="portlet-body form">
         <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
         
        <div class="control-group">
        <label class="control-label">Customer Name</label>
        <div class="controls">
        <select name="customer_id" class="span6 m-wrap chosen" >	
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
        <label class="control-label">Car</label>
        <div class="controls">
        <select name="car_type_id" class="span6 m-wrap chosen" >	
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
        <label class="control-label">Service</label>
        <div class="controls">
        <select name="service_id" class="span6 m-wrap chosen" >	
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
        <label class="control-label">Rate</label>
        <div class="controls">
       <input type="text" name="rate" onKeyUp="allLetter(this.value,this.id)" id="rate" class="span6 m-wrap" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Charged KM</label>
        <div class="controls">
        <input type="text" name="minimum_chg_km"  onKeyUp="allLetter(this.value,this.id)" id="minimum_chg_km" class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Extra KM Rate</label>
        <div class="controls">
        <input type="text" name="extra_km_rate"  onKeyUp="allLetter(this.value,this.id)" id="extra_km_rate" class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Minimum Charges Hourly</label>
        <div class="controls">
        <input type="text" name="minimum_chg_hourly"  onKeyUp="allLetter(this.value,this.id)" id="minimum_chg_hourly" class="span6 m-wrap" />
        </div>
        </div>  
        
         
        <div class="control-group">
        <label class="control-label">Extra Hour Rate</label>
        <div class="controls">
        <input type="text" name="extra_hour_rate"  onKeyUp="allLetter(this.value,this.id)" id="extra_hour_rate" class="span6 m-wrap" />
        </div>
        </div>  
        
        </table>
        <div class="form-actions">
        <button type="submit"   class="btn green" name="customer_tariff_reg"/><i class="icon-ok"></i> Submit</button>
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