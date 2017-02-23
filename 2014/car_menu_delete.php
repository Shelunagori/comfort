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
     <form method="post" name="form_name">
<!--<div>                     
<a href="car_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="car_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="car_menu_delete.php" class="btn red"><i class="icon-trash"></i> Delete</a>
<a href="car_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-trash"></i>Delete</h4>
                    </div>
                    <div class="portlet-body form">
                    <table width="100%">
						 <tr><td>Select Car :</td>
						 <td>
						 <select name="carname_master_id" class="span5 chosen" style="width:221px !important">
						 <option value="">Select Car</option>	
						 <?php 
								$mydatabase = new DataBaseConnect();
								$result= $mydatabase->execute_query_return("select * from carname_master");
								while($row=mysql_fetch_array($result))
								{
									echo "<option value='".$row['id']."'>".$row['name']."</option>";
								}
						 ?>
				</select>
						 </td>
						 </tr>
                         
						 <tr><td> Vehicle Number:</td><td>
                         <select name="name" class="span5 chosen" style="width:221px !important">	
						<option value="">Select Type</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select distinct name from car_reg");
						while($row=mysql_fetch_array($result))
						{
							echo "<option>".$row['name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select>
                         
                         </td></tr>
						<tr><td>Select Supplier Name : </td><td>
						<select name="supplier_reg_name" class="span5 chosen" style="width:221px !important">	
						<option value="">Select Type</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select supplier_reg_name from car_reg");
						while($row=mysql_fetch_array($result))
						{
							echo "<option>".$row['supplier_reg_name']."</option>";
						}
						$mydatabase->close_connection();
				?>
				</select> <button type="submit" style="margin-left:1%; margin-top:-4% !important"  class="btn green" name="car_edit" />Go <i class="icon-circle-arrow-right"></i></button>
						</td></tr>
						<tr><td></td><td>&nbsp;</td></tr>
						 </table>
                         <?php
				if(isset($_POST['car_edit']))
				{
					?> 
                     <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%"  class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th scope="col">Car</th>
                        <th scope="col">Vehicle Number</th>
                        <th scope="col">Supplier Name</th>
                        <th scope="col">Insurance Date Start</th>
                        <th scope="col">Insurance Date End</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php           
				$q1="";	$q2="";$q3=$q1;	$qry ="";
				if(!empty($_POST['name']))
				{
					$name=$_POST['name'];
					$q1="name='".$name."'";
				}
				if(!empty($_POST['supplier_reg_name']))
				{
					$supplier_reg_name=$_POST['supplier_reg_name'];
					if($q1=="")
						$q2=" supplier_reg_name='".$supplier_reg_name."'";
					else 
						$q2=" AND supplier_reg_name='".$supplier_reg_name."'";
				}
				if(!empty($_POST['carname_master_id']))
				{
					$carname_master_id=$_POST['carname_master_id'];
					if($q1=="" && $q2=="")
						$q3=" carname_master_id='".$carname_master_id."'";
					else 
						$q3=" AND carname_master_id='".$carname_master_id."'";
				}
				 if($q1=="" && $q2=="" && $q3=="")
				 {
                	$qry ="select * from car_reg";
				 }
                else
                {    
					$qry="select * from car_reg where ";
                }
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q3;
                      //  echo $sql;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
							$i++;
                        	$idd=$row['car_id'];
							$carname_master_id=$row['carname_master_id'];
							$car_all=mysql_query("select * from `carname_master` where `id` = '$carname_master_id'  ");
							$ftc_car=mysql_fetch_array($car_all);
							$name = $ftc_car['name'];
							$vehicle_no=$row['name'];
							$supplier_reg_name=$row['supplier_reg_name'];
							$insurance_date_from=$row['insurance_date_from'];
							$insurance_date_to=$row['insurance_date_to'];
                       ?>
                            <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $vehicle_no;?></td>
                            <td><?php echo $supplier_reg_name;?></td>
                            <td><?php echo $insurance_date_from;?></td>
                            <td><?php echo $insurance_date_to;?></td>
                            <td><a class="btn mini red"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
    							<i class="icon-trash"></i></a>
                                 <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 id="myModalLabel1"><i class="icon-trash"></i>&nbsp;&nbsp;Delete <?php echo $name ?> Info</h4>
									</div>
									<div class="modal-body">
									<p>Are you sure ... ?</p>
									</div>
									<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                     <a class="btn red" href='delete.php?delete_car=true&id=<?php echo $idd;?>'><i class="icon-trash">&nbsp;</i>Delete</a>
									</div>
									</div>
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
 		
        </form>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>