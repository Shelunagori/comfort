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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
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

 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Fuel Update</h4>
                     </div>
                     <div class="portlet-body form">
                     <table width="100%">
						 <tr><td> Car Number:</td><td>
                        <select name="car_number" class="chosen" id="ajaxcarname">	
                        <option value="">Select Type</option>
                        <?php 
                        $mydatabase = new DataBaseConnect();
                        $result= $mydatabase->execute_query_return("select `car_id`,`name` from car_reg");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select> </td></tr>
						 <tr><td> Date From: </td><td>
                          <input type="text" name="date_from" id="dp1" class="m-wrap medium"/>
                          </td></tr>
						<tr><td> Date To: </td><td>
                        <input type="text" name="date_to"  id="dp2" class="m-wrap medium"/>
                       <button type="submit"   class="btn green" name="fuel_edit" />Go <i class="icon-circle-arrow-right"></i></button>         
                         </td></tr>
					</table> 
                     
                      <?php
				if(isset($_POST['fuel_edit']))
				{
					?> 
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px!important">
					<table width="100%" class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse; ">
                    <thead>
                        <tr>
                        <th >S. No.</th>
                        <th >Supplier Name</th>
                        <th >Date</th>
                        <th >Car Number</th>
                        <th >Previous Reading</th>
                        <th >Current Reading</th>
                        <th >Fuel Qty</th>
                        <th >Fuel Amount</th>
                        <th >Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php           
			   
					$qry="select * from `fuel` where 
					`car_number`='".$_POST['car_number']."'
					 or `date` between '".DateExact($_POST['date_from'])."' and '".DateExact($_POST['date_to'])."' order by `date`
					";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$supplier_name=$row['supplier_name'];
							$date=$row['date'];
							$car_number=$row['car_number'];
							$opening_km=$row['opening_km'];
                            $closing_km=$row['closing_km'];
                            $fuel_qty=$row['fuel_qty'];
                            $fuel_amount=$row['fuel_amount'];
						
                       ?>
                             <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $supplier_name;?></td>
                            <td><?php echo date("d-M-Y",strtotime($date));?></td>
                            <td><?php echo $car_number;?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                            <td><?php echo $fuel_qty;?></td>
                             <td><?php echo $fuel_amount;?></td>
                            <td><a href="update_fuel.php?id=<?php echo $idd;?>" class="btn mini red" style="text-decoration:none;" target="_blank"><i class="icon-edit"></i></a></td>
                            </tr>
                        <?php
                        }
                        }
					?>
                      </tbody>
                    </table>   
                    <?php
				}
				?>
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