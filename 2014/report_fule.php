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
<style>
.ad:hover
{
	background-color:#CCC;
}
</style>
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
      <?php
	  if(isset($_GET['mode']))
	  {
		  ?>
           <a class="btn yellow diplaynone" role="button" href="report_fule.php" ><i class=" icon-circle-arrow-left"></i> Back</a>
          <a class="btn green diplaynone" role="button" href="javascript:window.print();" ><i class="icon-print"></i> Print</a>
           <a class="btn yellow diplaynone" target="_blank"  href="excel_all.php?date_from=<?php echo DateExact($_POST['date_from']); ?>&date_to=<?php echo DateExact($_POST['date_to']);?>&type=fule_report&car_number=<?php echo $_POST['car_number']; ?>" style="text-decoration:none;"><i class="icon-download-alt"></i> Export in Excel</a>
          <?php
	  }
	  ?>
         <div class="container-fluid">
     <?php menu(); ?>
<?php
if(isset($_GET['mode']))
{
	if($_GET['mode']=='view')
	{
		?>
					<table width="100%" border="1" style="border-collapse:collapse;" bordercolor="#10A062" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="background-color:#DFF0D8;">
                        <th >S.No.</th>
                        <th >Supplier Name</th>
                        <th >Date</th>
                        <th >Car No.</th>
                        <th >Pre. Reading</th>
                        <th >Cur. Reading</th>
                        <th >Fuel Type</th>
                        <th >Fuel Qty</th>
                        <th >Fuel Amount</th>
                        <th >Approx. Mileage</th>
                        <th >Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php           
			   	$temp=0;
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
					        $fuel_type=$row['fuel_type'];
	                        $remarks=$row['remarks'];	
							$red_diff=$closing_km-$opening_km;		
							$mileage=@floatval($red_diff/$temp);
							$temp=$fuel_qty;
							
                       ?>
                             <tr class="ad">
                            <td><?php echo $i;?></td>
                            <td><?php echo $supplier_name;?></td>
                            <td><?php echo date("d-M-Y",strtotime($date));?></td>
                            <td><?php echo $car_number;?></td>
                            <td><?php echo $opening_km;?></td>
                            <td><?php echo $closing_km;?></td>
                             <td><?php echo $fuel_type;?></td>
                            <td><?php echo $fuel_qty;?></td>
                             <td><?php echo $fuel_amount;?></td>
                               <td><?php echo round($mileage,2); ?></td>        <!-- floor  will set like 2.9 will be 2 as o/p-->
                             <td><?php echo $remarks; ?></td>                     <!-- ceil  will set like 4.3 will be 5 as o/p-->
                                                                                   <!-- round  will set like 4.4567 to 4.45 by floor(var,digit to be show)-->
                            </tr>
                        <?php
                        }
                        }
					?>
                      </tbody>
                    </table>   
                     <?php	
	}
}
else
{
?>
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-book"></i>Fule Report</h4>
        </div>
        <div class="portlet-body form">
        <form method="post" action="report_fule.php?mode=view" >
         <table width="100%">
						 <tr>
                         <td> Car Number:</td>
                         <td>
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
                        </select>
                         </td>
                        </tr>
						 <tr>
                         <td> Date From: </td>
                         <td>
                          <input type="text" name="date_from" id="dp1" class="m-wrap medium"/>
                          </td>
                          </tr>
						<tr>
                        <td> Date To: </td>
                        <td>
                        <input type="text" name="date_to"  id="dp2" class="m-wrap medium"/>
                       <button type="submit"   class="btn green" name="fuel_edit" />Go <i class="icon-circle-arrow-right"></i></button>         
                         </td>
                         </tr>
					</table> 
                    </form>
        </div>
        </div>
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
 <?php datepicker(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>