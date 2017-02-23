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
<style>
.my-table {
  border: 3px solid #CCC;
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?>
    	<form method="post" name="form_name">
          <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue my-table" id="pulsate-regular">
								<div class="visual">
									<i class="icon-bullhorn"></i>
								</div>
								<div class="details">
									<div class="number">
								    <?php
									$current_date=date("Y-m-d");
									$result=mysql_query("select `travel_from`,`travel_to` from `booking` ");
									while($row=mysql_fetch_array($result))
									{
											if($current_date >= $row['travel_from'] && $current_date <= $row['travel_to'])
											{
											$num_booking++;
											}
											else
											{
											$num_booking=0;	
											}
									}
									?>
                                    <?php echo $num_booking;?>
									</div>
									<div class="desc">									
										New Booking
									</div>
								</div>
								<a class="more" href="booking_menu.php?mode=view">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
     <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green my-table">
								<div class="visual">
									<i class="icon-rss"></i>
								</div>
								<div class="details">
									<div class="number"> 
                                    <?php
									$result=mysql_query("select `id` from `duty_slip`  where `closing_km`='0'  && `waveoff_status`='0'");
								    $num_ds_opn=@mysql_num_rows($result);
									?>
                                    <?php echo $num_ds_opn; ?></div>
									<div class="desc">Open DS</div>
								</div>
								<a class="more" href="report_opends.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple my-table">
								<div class="visual">
									<i class="icon-eye-close"></i>
								</div>
								<div class="details">
									<div class="number">
									<?php
									$result=mysql_query("select * from `duty_slip`  where `billing_status`='no'  && `waveoff_status`='0'");
   								 	$num_unbilled=@mysql_num_rows($result);
									?>
                                     <?php echo $num_unbilled;?>
                                    </div>
									<div class="desc">UnBilled DS</div>
								</div>
								<a class="more" href="report_unbilled.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow my-table">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
                                <div class="number">
                                	<?php
									$result=mysql_query("select `id` from invoice where  payment_status='no'  && `waveoff_status`='0'");
									$num_invoice=mysql_num_rows($result);
									?>
                                     <?php echo $num_invoice;?>
                                    </div>
                                    <div class="desc">Invoice Due List</div>
								</div>
								<a class="more" href="report_pending_dues.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
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
    <script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>
