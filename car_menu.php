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
		if(isset($_POST['car_edit']))
		{
							if(isset($_GET['car_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Car Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['car_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Car Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i> Car Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>Sl.</th>
                        <th>Car</th>
                        <th>Vehicle Number</th>
                        <th>Supplier Name</th>
                        <th>Insurance Date Start</th>
                        <th>Insurance Date End</th>
                         <?php
							if(isset($_GET['car_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['car_delete']))
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
				$q1="";	$q2="";	$q3="";	
				if(!empty($_POST['name']))
				{
					$name=$_POST['name'];
					$q1="name='".$name."'";
				}
				if(!empty($_POST['car_type_id']))
				{
					$car_type_id=$_POST['car_type_id'];
					if($q1=="")
						$q2=" car_type_id='".$car_type_id."'";
					else 
						$q2=" AND car_type_id='".$car_type_id."'";
				}
				if(!empty($_POST['supplier_id']))
				{
					$supplier_id=$_POST['supplier_id'];
					if($q1=="" && $q2=="")
						$q3=" supplier_id='".$supplier_id."'";
					else 
						$q3=" AND supplier_id='".$supplier_id."'";
				}
				 if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from car_reg";
                else    
					$qry="select * from car_reg where ";
                        $sql=$qry.$q1.$q2.$q3;
                        $result=@mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$car_type_id=$row['car_type_id'];
							$car_name=fetchcarname($car_type_id);
							$supplier_id=$row['supplier_id'];
							$supplier_name=fetchsuppliername($supplier_id);
							$insurance_date_from=dateforview($row['insurance_date_from']);
							$insurance_date_to=dateforview($row['insurance_date_to']);
                       ?>
                            <tr id="<?php echo $i; ?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $car_name;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $supplier_name;?></td>
                            <td><?php echo $insurance_date_from;?></td>
                            <td><?php echo $insurance_date_to;?></td>
                         <?php
							if(isset($_GET['car_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?car=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['car_delete']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_car(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_car.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
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
                        <h4><i class="icon-edit"></i>Car Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="car_menu.php?car_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="m-wrap medium">	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `car_type`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
              			 </td>
                        <td>Vehicle No.:</td>
                        <td><input type="text" class="m-wrap medium" id="vehicle_fetch" name="name" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Name:</td>
                        <td>
                        <select name="supplier_id" class="m-wrap medium">
                        <option value="">---select supplier---</option>	
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `supplier_reg`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="car_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-trash"></i>Car Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="car_menu.php?car_delete=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="m-wrap medium">	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `car_type`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
              			 </td>
                        <td>Vehicle No.:</td>
                        <td><input type="text" class="m-wrap medium" id="vehicle_fetch" name="name" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Name:</td>
                        <td>
                        <select name="supplier_id" class="m-wrap medium">
                        <option value="">---select supplier---</option>	
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `supplier_reg`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="car_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-search"></i>Car View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="car_menu.php?car_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Car:</td>
                        <td>
                        <select name="car_type_id" class="m-wrap medium">	
                        <option value="">---select car---</option>
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `car_type`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
              			 </td>
                        <td>Vehicle No.:</td>
                        <td><input type="text" class="m-wrap medium" id="vehicle_fetch" name="name" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Name:</td>
                        <td>
                        <select name="supplier_id" class="m-wrap medium">
                        <option value="">---select supplier---</option>	
                        <?php 
                        $result= mysql_query("select DISTINCT `name`,`id` from `supplier_reg`");
                        while($row=mysql_fetch_array($result))
                        {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="car_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
        <form  name="form_name" action="Handler.php" method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Car Add</h4>
        </div>
        <div class="portlet-body form">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                <tr>
                <td> Car:</td>
                <td><select name="car_type_id" class="m-wrap medium chosen">	
                <option value="">---select car---</option>
				<?php 
				$result= mysql_query("select DISTINCT `name`,`id` from `car_type`");
				while($row=mysql_fetch_array($result))
				{
					echo "<option value='".$row['id']."'>".$row['name']."</option>";
				}
				?>
				</select></td>
                <td> Vehicle Number:</td>
                <td><input type="text" REQUIRED class="m-wrap medium" name="name" /></td>
                </tr>
                <tr>
                <td>Supplier Name:</td>
                <td><select name="supplier_id" class="m-wrap medium chosen">
                <option value="">---select supplier---</option>	
				<?php 
				$result= mysql_query("select  `name`,`id` from `supplier_reg` group by `name`");
				while($row=mysql_fetch_array($result))
				{
					echo "<option value='".$row['id']."'>".$row['name']."</option>";
				}
				?>
				</select></td>
                <td> Engine Number:</td><td><input type="text" class="m-wrap medium" name="engine_no" /> </td>
                </tr>
				<tr>
                <td> Chasis Number : </td><td><input type="text" class="m-wrap medium" name="chasis_no" /> </td>
                <td> RTO Tax Date: </td><td><input type="text"  class="m-wrap medium date-picker" onClick="mydatepick();" name="rto_tax_date" /> </td></tr>
				<tr>
                <td> Insurance Starting Date: </td><td><input type="text" name="insurance_date_from" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
                <td> Insurance Ending Date: </td><td><input type="text" name="insurance_date_to" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
                </tr>
                <tr>
                <td> Authorization Detail Date: </td><td><input type="text" name="authorization_date" onClick="mydatepick();"  class="m-wrap medium date-picker"/> </td>
                <td> Permit Date: </td><td><input type="text" name="permit_date" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
                </tr>
                <tr>
                <td> Fitness Date: </td><td><input type="text" name="fitness_date" onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
                <td> PUC Date: </td><td><input type="text" name="puc_date"  onClick="mydatepick();" class="m-wrap medium date-picker"/> </td>
                </tr>
              
                </table>   
                        
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="car_reg"/><i class="icon-ok"></i> Submit</button>
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