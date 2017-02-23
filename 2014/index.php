<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
date_default_timezone_set('Asia/Calcutta');	
//$time = date('h:i:s a', time());
$date = date('d-m-Y');
$date_convrt=date('d-m-Y');
$date=date("Y-m-d",strtotime($date_convrt));
$database = new DataBaseConnect();
$booking_notification = array();
$car_insurence=array();
$driver_licence=array();

$result=$database->execute_query_return("select id,travel_from from booking where travel_from>='".date('Y-m-d')."'");
while($row=mysql_fetch_array($result))
{
	 $main1= strtotime($row['travel_from']);
	 $main2 = strtotime(date('Y-m-d')); 
	$days=0;
	
		$result_d = array();
		while ($main2 <= $main1) 
		{
  			if (date('N', $main2) < 8) 
			{
   			 	$result_d[] = date('Y-m-d', $main2);
 			 }
 			 $main2 = strtotime('+1 day', $main2);
		}
		foreach($result_d as $value)
		{
		$days++;
	
		}

	// $days=($main1-$main2)/86400;
	if($days>=0 && $days<=10)
	{
		 $booking_notification[]=$row['id'];	
	}
}
$result=$database->execute_query_return("select car_id,insurance_date_to from car_reg where insurance_date_to>='".date('Y-m-d')."'");
while($row=mysql_fetch_array($result))
{
	$main1= strtotime($row['insurance_date_to']);
	$main2 = strtotime(date('Y-m-d'));
	$days=0;
	
		$result_d = array();
		while ($main2 <= $main1) 
		{
  			if (date('N', $main2) < 8) 
			{
   			 	$result_d[] = date('Y-m-d', $main2);
 			 }
 			 $main2 = strtotime('+1 day', $main2);
		}
		foreach($result_d as $value)
		{
		$days++;
	
		}
	//$days=($main1-$main2)/86400;
	if($days>=0 && $days<=3)
	{
		$car_insurence[]=$row['car_id'];	
	}
}
$result=$database->execute_query_return("select driver_id,licence_valid from driver_reg where licence_valid>='".date('Y-m-d')."'");
while($row=mysql_fetch_array($result))
{
	$main1= strtotime($row['licence_valid']);
	$main2 = strtotime(date('Y-m-d'));
	$days=0;
	
		$result_d = array();
		while ($main2 <= $main1) 
		{
  			if (date('N', $main2) < 8) 
			{
   			 	$result_d[] = date('Y-m-d', $main2);
 			 }
 			 $main2 = strtotime('+1 day', $main2);
		}
		foreach($result_d as $value)
		{
		$days++;
	
		}
	//$days=($main1-$main2)/86400;
	if($days>=0 && $days<=3)
	{
		$driver_licence[]=$row['driver_id'];	
	}
}
$database->close_connection();
if(count($booking_notification)>0)
	$booking_notification1="";
	 $booking_notification1=implode(",", $booking_notification);
	$_SESSION['booking_notification']=$booking_notification1;
if(count($car_insurence)>0)	
	$car_insurence1="";
	 $car_insurence1=implode(",", $car_insurence);
	$_SESSION['car_insurence']=$car_insurence1;
if(count($driver_licence)>0)	
	$driver_licence1="";
	 $driver_licence1=implode(",", $driver_licence);
	$_SESSION['driver_licence']=$driver_licence1;
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
      <?php navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     	<div class="row-fluid">
					<div class="span12">
     		<div class="styler-panel hidden-phone">
							<i class="icon-cog"></i>
							<i class="icon-remove"></i>
							<span class="settings">
							<span class="text">Style:</span>
							<span class="colors">
							<span class="color-default" data-style="default"></span>
							<span class="color-blue" data-style="blue"></span>
							<span class="color-light" data-style="light"></span>		
							</span>
							<span class="layout">
							<label class="hidden-phone">
							<div id="uniform-undefined" class="checker"><span class="checked"><input style="opacity: 0;" class="header" checked="" value="" type="checkbox"></span></div>Fixed Header
							</label>							
							</span>
							</span>
						</div>
                    </div></div>

                        
     <div class="row-fluid">
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat blue" id="pulsate-regular">
								<div class="visual">
									<i class="icon-bullhorn"></i>
								</div>
								<div class="details">
									<div class="number">
								    <?php
									$count = 0;
									$rez="select * from `booking` where `current_date` = '$date'";
									$data_base_object_book = new DataBaseConnect();
									$result= $data_base_object_book->execute_query_return($rez);
								    while($row=mysql_fetch_array($result))
									{
										$count++;
									}
									?>
                                    <?php echo $count;?>
									</div>
									<div class="desc">									
										New Booking
									</div>
								</div>
								<a class="more" href="view_booking_dashboard.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
     <div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat green">
								<div class="visual">
									<i class="icon-shopping-cart"></i>
								</div>
								<div class="details">
									<div class="number"> 
                                    <?php
									$count = 0;
									$rez="select * from `duty_slip` where `closing_km`='0'  ORDER BY `current_date` ASC";
									$data_base_object_book = new DataBaseConnect();
									$result= $data_base_object_book->execute_query_return($rez);
								    while($row=mysql_fetch_array($result))
									{
										$count++;
									}
									?>
                                    <?php echo $count;?></div>
									<div class="desc">Open DS</div>
								</div>
								<a class="more" href="ntclskm_menu.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6  fix-offset" data-desktop="span3">
							<div class="dashboard-stat purple">
								<div class="visual">
									<i class="icon-globe"></i>
								</div>
								<div class="details">
									<div class="number"><?php
									$count = 0;
									$fetch_data="select * from `duty_slip` where `status`='no'  ORDER BY `current_date` ASC";
									$data_base_object_invoice = new DataBaseConnect();
									$result_pending_due= $data_base_object_invoice->execute_query_return($fetch_data);
								    while($row_pending=mysql_fetch_array($result_pending_due))
									{
										$count++;
									}
									?>
                                     <?php echo $count;?>
                                    </div>
									<div class="desc">UnBilled DS</div>
								</div>
								<a class="more" href="nostatus_menu.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
						<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
							<div class="dashboard-stat yellow">
								<div class="visual">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="details">
                                <div class="number">
                                	<?php
									$count = 0;
									$fetch_data="select * from `invoice` where status='no' ";
									$data_base_object_invoice = new DataBaseConnect();
									$result_pending_due= $data_base_object_invoice->execute_query_return($fetch_data);
								    while($row_pending=mysql_fetch_array($result_pending_due))
									{
									  $duty_slip_customer_reg_name =	$row_pending['duty_slip_customer_reg_name'];
									 if($duty_slip_customer_reg_name=='3'||$duty_slip_customer_reg_name=='5')
									 {
										$count++;
									 }
									}
									?>
                                    <?php echo $count;?>
                                    </div>
                                    <div class="desc">Invoice Due List</div>
								</div>
								<a class="more" href="total_invoice_due.php">
								View more <i class="m-icon-swapright m-icon-white"></i>
								</a>						
							</div>
						</div>
					</div>
                    	
     		<div class="clearfix"></div>
     
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