<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
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
    <?php
	 if(isset($_GET['mode']))
	 {?>  
<form method="post" action="docburner.php">                   
<a class="btn blue diplaynone tooltips" role="button" href="report_fule.php"  title="Back" data-placement="bottom"><i class="icon-circle-arrow-left"></i></a>    
<button class="btn yellow diplaynone tooltips" role="button" title="Print" data-placement="bottom" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i></button> 
<button  type="submit" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i></button>
<input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
<input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
<input type="hidden" value="<?php echo $_POST['car_id']; ?>" name="car_id">
<input type="hidden" value="fule" name="excel_for">
</form>
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
			 				$q1=""; $q2="";  $temp=0;
			 				if(!empty($_POST['car_id']))
							{
							$car_id=$_POST['car_id'];
							$q1=" `car_id` = '".$car_id."' ";
							}
							if(!empty($_POST['date_from']) && !empty($_POST['date_to']))
							{
								if($q1=="")
								{
									$q2=" `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
								}
								else
								{
									$q2=" AND `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
								}
							}
							if($q1=="" && $q2=="")
							$qry ="select * from `fuel` ";
							else 
							$qry="select * from `fuel` where ";
							$sql=$qry.$q1.$q2;
 							$result=mysql_query($sql);
			
	 		?>
            <div class="portlet box blue">
            <div class="portlet-title">
            <h4><i class="icon-beaker"></i>Result for Fule </h4>
            </div>
            <div class="portlet-body form">
          	<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
            <table width="100%" id="sample_1" class="table table-bordered table-hover table-condensed flip-content">
            <thead>
            <tr>
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
            while($row=mysql_fetch_array($result))
            {$i++;
				 			$fuel_qty=$row['fuel_qty'];
							$red_diff=$row['closing_km']-$row['opening_km'];		
							@$mileage=($red_diff/$temp);
							$temp=$fuel_qty;
				?>
                    <tr>
                    <td><?php echo $i;?></td>
                    <th><?php echo fetchsuppliername($row['supplier_id']); ?></th>
                    <td><?php echo dateforview($row['date']); ?></td>
                    <td><?php echo fetchcarno($row['car_id']); ?></td>
                    <td><?php echo $row['opening_km']; ?></td>
                    <td><?php echo $row['closing_km']; ?></td>
                    <td><?php echo $row['fuel_type'];?></td>
                    <td><?php echo $row['fuel_qty'];?></td>
                    <td><?php echo $row['fuel_amount'];?></td>
                    <td><?php echo round($mileage,2); ?></td>       
                    <td><?php echo $row['remarks']; ?></td>                
                    </tr>
                <?php
			 	}
			?>
          
            </tbody>
            </table>
            </div>
            </div>
            </div>
            <?php
		 }
	 }
	 else
	 {
		 ?>
       <form  name="form_name" action="report_fule.php?mode=view" class="form-horizontal"  method="post">
          
            <div class="portlet box yellow">
            <div class="portlet-title">
            <h4><i class="icon-beaker"></i>Fuel Report</h4>
            </div>
            <div class="portlet-body form">
          
            <div class="control-group">
            <label class="control-label">Car No.</label>
            <div class="controls">
            <select name="car_id" class="span6 m-wrap chosen" onChange="fetch_reading(this.value);" >	
            <option value="">---select car---</option>
            <?php 
            $result= mysql_query("select distinct `id`,`name` from car_reg");
            while($row=mysql_fetch_array($result))
            {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>
            </div>
            </div>   
            
            <div class="control-group">
            <label class="control-label">Date From</label>
            <div class="controls">
            <input type="text" name="date_from" class="span6 m-wrap date-picker" onClick="mydatepick();"/>
            </div>
            </div>    
            
            <div class="control-group">
            <label class="control-label">Date To</label>
            <div class="controls">
            <input type="text" name="date_to" class="span6 m-wrap date-picker" onClick="mydatepick();"/>
            </div>
            </div>    
              
            <div class="form-actions">
            <button type="submit"   class="btn green" name="fuel_edit"/><i class="icon-ok"></i> Submit</button>
            <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>