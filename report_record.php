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
  <div style="padding: 1px;">
  <a class="btn blue diplaynone tooltips" role="button" href="report_record.php"  title="Back" data-placement="bottom"><i class="icon-circle-arrow-left"></i></a>    
 <button class="btn yellow diplaynone tooltips" role="button" title="Print" data-placement="bottom" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);javascript:window.print();"><i class="icon-print"></i></button> 
 </div>
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
						$q1="";	$q2="";	$q3="";
						if(!empty($_POST['login_id']))
						{
							$login_id=$_POST['login_id'];
							$q1=" login_id='".$login_id."' ";
						}
						if(!empty($_POST['counter_id']))
						{
							$counter_id=$_POST['counter_id'];
							if($q1=="")
								$q2=" counter_id='".$counter_id."' ";
							else 
								$q2=" AND counter_id='".$counter_id."'";
						}
						if($q1=="" && $q2=="")
							$qry ="select * from `".$_POST['type']."` ";
						else    
							 $qry="select * from `".$_POST['type']."` where ";
						
						$q3=" ORDER BY `date` ASC ";
						$sql=$qry.$q1.$q2.$q3;
						$result=mysql_query($sql);
	 		?>
            <div class="portlet box blue">
            <div class="portlet-title">
            <h4><i class="icon-cloud"></i>Records</h4>
            </div>
            <div class="portlet-body form">
          	<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
            <table width="100%"  class="table table-striped table-bordered table-advance table-hover">
			<?php 
            if($_POST['type']=="duty_slip")
            {
				?>
                <thead>
                <tr>
                <th>DS. No.</th>
                <th><i class="icon-trash"></i> Waveoff Status</th>
                <th><i class="icon-bar-chart"></i> Billing Status</th>
                <th><i class="icon-table"></i> View </th>
                <th><i class="icon-download-alt"></i> PDF</th>
                </tr>
                </thead>
                <?php
						while($row=mysql_fetch_array($result))
						{
						?>
						<tr>
                        <th><?php echo $row['id']; ?></th>
                        <td>
                        <?php
						if($row['waveoff_status']=='1')
						{?>
                        <span class="label label-warning">Yes</span>
                        <?php
						}
						else
						{?>
                         <span class="label label-info">No</span>   
                         <?php
						}
						?>
                        </td>
                        <td>
                        <?php
						if($row['billing_status']=='yes')
						{?>
                        <span class="label label-success">Success</span>
                        <?php
						}
						else
						{?>
                        <span class="label label-important">Pending</span>
						<?php
						}?>
                        </td>
						<td>
						<a class="btn mini blue"  role="button"  href="dutyslip_view.php?dutyslip=true&id=<?php echo $row['id'];?>" target="_blank" style="text-decoration:none;"><i class="icon-search"></i> </a>
						</td>	
                        <td>
                        <a class="btn mini red"  role="button" onClick="window.open('pdf.php?dutyslip=true&id=<?php echo $idd;?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');"   target="_blank" style="text-decoration:none;">
						<i class="icon-download-alt"></i></a>
                        </td>
						</tr>        
						<?php
				}
				
            }
			else if($_POST['type']=="invoice")
            {
				?>
                <thead>
                <tr>
                <th>Invoice No.</th>
                <th><i class="icon-trash"></i> Waveoff Status</th>
                <th><i class="icon-bar-chart"></i> Payment Status</th>
                <th><i class="icon-table"></i> View </th>
                <th><i class="icon-download-alt"></i> PDF</th>
                </tr>
                </thead>
                <?php
						while($row=mysql_fetch_array($result))
						{
						?>
                        <tr>
                        <th><?php echo $row['id']; ?></th>
                        <td>
                        <?php
						if($row['waveoff_status']=='1')
						{?>
                        <span class="label label-warning">Yes</span>
                        <?php
						}
						else
						{?>
                         <span class="label label-info">No</span>   
                         <?php
						}
						?>
                        </td>
                        <td>
                        <?php
						if($row['payment_status']=='yes')
						{?>
                        <span class="label label-success">Success</span>
                        <?php
						}
						else
						{?>
                        <span class="label label-important">Pending</span>
						<?php
						}?>
                        </td>
						<td>
										<a class="btn mini blue"  role="button"  href="billing_view.php?invoice=true&id=<?php echo $row['id'];?>" target="_blank" style="text-decoration:none;">
										<i class="icon-search"></i></a>
                         </td>
                         <td>               
			<a class="btn mini red"  role="button" onClick="window.open('pdf.php?billing=true&id=<?php echo $row['id'];?>','messageWindow','scrollbars=yes,width=150,height=100,resizable=none');"   target="_blank" style="text-decoration:none;">
										<i class="icon-download-alt"></i></a>
										</td>	
										</tr>
						<?php
						}
            }
			else
			{
						while($row=mysql_fetch_array($result))
						{
						?>
						<tr>
                        <th width="10%">Booking ID :<?php echo $row['id']; ?></th>
						<td>
					<a class="btn mini blue"  role="button"  href="view.php?booking=true&id=<?php echo $row['id'];?>" target="_blank" style="text-decoration:none;">
					<i class="icon-search"></i> View Booking </a>
										</td>	
										</tr>
						<?php
						}
				
			}
            ?>
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
        <form  name="form_name" action="report_record.php?mode=view" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-cloud"></i>Records</h4>
        </div>
        <div class="portlet-body form">
   
        <div class="control-group">
        <label class="control-label">Counter Name</label>
        <div class="controls">
        <select name="counter_id" class="span6 m-wrap ">
      	<option value="">---select counter---</option>
        <?php 
        $result=mysql_query("select distinct `id`,`name` from `counter`");
        while($row=mysql_fetch_array($result))
        {
        echo "<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
        </select>
        </div>
        </div>
        
         <div class="control-group">
        <label class="control-label">Login Name</label>
        <div class="controls">
        <select name="login_id" class="span6 m-wrap ">
      	<option value="">---select login---</option>
        <?php 
        $result=mysql_query("select distinct `id`,`login_id` from `login`");
        while($row=mysql_fetch_array($result))
        {
        echo "<option value='".$row['id']."'>".$row['login_id']."</option>";
        }
        ?>
        </select>
        </div>
        </div>
                
        <div class="control-group">
        <label class="control-label">Type</label>
        <div class="controls">
        <select name="type" class="span6 m-wrap ">
        <option value="duty_slip">Duty Slip</option>
        <option value="invoice">Invoice</option>
        <option value="booking">Booking</option>
        </select>
        </div>
        </div>    
     
        <div class="form-actions">
        <button type="submit"   class="btn green" name="done"/><i class="icon-signal"></i> Generate</button>
        <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
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