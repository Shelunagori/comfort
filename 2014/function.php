<?php
require_once ("classes/databaseclasses/DataBaseConnect.php");
date_default_timezone_set('Asia/Calcutta');	
session_start();
function css()
{?>
      <link href="favico.ico" rel="shortcut icon" />
  	  <style type="text/css">
          body {
            padding-top: 60px;
            padding-bottom: 40px;
          }
		  .radio
		  {
			  margin-left:0px !important;
		  }
		  .btn.red,.btn.blue
		  {
			  margin-top:0.2% !important;
		  }
      </style>
     
<style media="print">
.go-top
	{
		display:none !important;
	}
	
      .diplaynone{
              display:none !important;
          }
          #noprint{
              display:none !important;
          }
          .fsize{
              font-size:24px !important;
          }
          .fsize1{
              font-size:28px !important;
          }
          .prnt
          {
              page-break-after:always;
          }
      </style>
 
<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
<link href="assets/css/metro.css" rel="stylesheet" />
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
<link href="assets/css/style.css" rel="stylesheet"/>
<link href="assets/css/plugins.css" rel="stylesheet"/>
<link href="assets/css/style_responsive.css" rel="stylesheet"/>
<link href="assets/css/style_default.css" rel="stylesheet" id="style_color"/>
<link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css"/>
<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css"/>
<link rel="stylesheet" type="text/css" href="datepicker/css/datepicker.css" />
<!--<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css"/>
<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet"/>
<link href="assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>-->
<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css"/>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<!--<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />-->
<link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
<!--<link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />-->
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-fileupload.css" />
   
<?php }
/*
function logo()
{ ?>
<link rel="shortcut icon" href="images/logo.jpg" />
<?php 
}
*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function js()
{
?> 
		<script src="assets/js/jquery-1.8.3.min.js"></script>		
        <script src="assets/breakpoints/breakpoints.js"></script>		
     <!--   <script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
        <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>-->
        <script src="datepicker/js/bootstrap-datepicker.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.blockui.js"></script>	
         <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
        <script src="assets/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
   <!--    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
        <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
        <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
        <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
      
     <!--   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
        <script src="datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>  -->
        <!-- Managed Table Start -->
        <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
 <!--       <script type="text/javascript" src="assets/bootstrap/js/bootstrap-fileupload.js"></script> -->
        <!-- Managed Table End -->
        <script src="assets/js/app.js"></script>
        <script>
      jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
      });
   </script>
 <?php  }
 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function navi_bar()
{ 
session_start();
$f_nm=$_SESSION['username'];
?>
<div class="header navbar navbar-inverse navbar-fixed-top diplaynone">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
                <a class="brand">
				<img src="assets/img/logo.jpg" width="125" style="margin-top:-3%">
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="assets/img/menu-toggler.png"  />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<li class="dropdown" id="header_notification_bar"></li>
					<li class="dropdown" id="header_task_bar"> </li>
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<!--	<img alt="" src="assets/img/avatar1_small.jpg" /> -->
						<span class="username hid"><strong>Welcome</strong>&nbsp;<b><?php echo $f_nm;?></b></span>
						<i class="icon-angle-down hid"></i>
						</a>
						<ul class="dropdown-menu hid">
							<li><a href="change_password.php"><i class="icon-user"></i> Change Password</a></li>
                            <li class="divider"></li>
							<li><a href="login.php"><i class="icon-key"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
			  </ul>
				<!-- END TOP NAVIGATION MENU -->	
		  </div>
		</div>
	</div>
	
<?php }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 

function navi_menu()
{ 

?>
      <!-- BEGIN SIDEBAR -->
   <div class="page-sidebar nav-collapse collapse diplaynone">
         <div class="slide hide">
            <i class="icon-angle-left"></i>
         </div>
       
         <div class="clearfix"></div>
         <ul style="margin-top:0px;">
         <li class="has-sub">
					<a href="index.php" style="background-color:#5CB85C !important; border-color:#4CAE4C !important;">
					<i class="icon-dashboard"></i> Dashboard
                    			<span class="selected"></span>
					</a>					
				</li>
           <?php
  $data_base_object = new DataBaseConnect();
  session_start();
  $id = $_SESSION['login_user'];
  $sql="select * from module_privilege where login_id='$id' ORDER BY id ASC ";
   $result= $data_base_object->execute_query_return($sql);
	while($arr_user=mysql_fetch_array($result))
	{
     $module_id=$arr_user['module_id'];
 
			  if($module_id == 2)
			   {
              ?>
    	       <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-cogs" ></i>Master
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                    <?php
                     $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '1'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="customer_menu.php">Customer</a></li>
                    <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '2'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="supplier_menu.php">Supplier</a></li>
                    <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '38'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="employee_menu.php">Employee</a></li>
                    <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '3'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="car_menu.php">Car</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '4'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="bank_menu.php">Bank</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '5'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="ledger_menu.php">Ledger</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '6'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                     <li><a class="" href="carmaster.php">Car Master</a></li>
                       <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '7'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="vehicle_allocation_menu.php">Vehicle Allocation</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '8'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                     <li><a class="" href="tariff_rate_menu.php">Tariff Rate</a></li>
                       <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '9'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="service_menu.php">Services</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '10'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                     <li><a class="" href="customer_tariff_rate_menu.php">Customer Tariff Rates</a></li>
                       <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '11'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="supplier_tariff_rate_menu.php">Supplier Tariff</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '12'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                     <li><a class="" href="fuel_menu.php">Fuel</a></li> 
                      <?php
					}
					?>
					</ul>
				</li> 
                <?php
			   }
			   
                if($module_id == 3)
			   {
               ?>
                 <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-flag" ></i>Duty Slip
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                    <?php
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '13'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{						?>
                    <li><a class="" href="dutyslip_menu.php">Add</a></li> 
                    <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '14'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="dutyslip_menu_edit.php">Edit</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '15'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="dutyslip_menu_edit_serch.php">Search|Waveoff</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '16'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="dutyslip_menu_print.php">Print</a></li> 
                     <?php
					}
                    ?>
					</ul>
				</li>
                <?php
			   }
			    if($module_id == 4)
			   {
               ?>
                
                  <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-bar-chart" ></i>Billing
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                     <?php
					   $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '17'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="billing_menu.php">Add</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '18'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="billing_menu_edit.php">Edit</a></li> 
                     <?php
					}
					$sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '19'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="billing_menu_search.php">Search</a></li> 
                     <?php
					}
					$sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '42'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="billing_menu_view.php">View</a></li> 
                     <?php
					}
						?>
					</ul>
				</li>
                  <?php
			   }
			    if($module_id == 5)
			   {
               ?>
                
                 <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-credit-card" ></i>Transcation
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                      <?php
					    $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '20'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                   $arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="receipt_menu.php">Receipt</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '21'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="payment_menu.php">Payment</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '22'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="journal_menu.php">Journal</a></li> 
                      <?php
					}
					?>
					</ul>
				</li>
                  <?php
			   }
			    if($module_id == 6)
			   {
               ?>
                 <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-book" ></i>Reports
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                    <?php
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '45'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                  <li><a class="" href="report_excel.php">Month Wise</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '23'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                  <li><a class="" href="missingkm_menu.php">Missing KM</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '24'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="ntclskm_menu.php">Open DS</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '25'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="nostatus_menu.php">Unbilled DS</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '39'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="duty_slip_update.php">Duty Slip Update</a></li>
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '40'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                   <li><a href="view_deleted_dutyslip.php">Waveoff Dutyslip</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '41'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                   <li><a href="invoice_delete_menu.php">Deleted Invoice</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '26'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="sales_register_menu.php">Sales Register</a></li> 
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '27'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                  <li><a href="billing_and_dutyslip.php">Dutyslip And Invoice</a></li>
                     <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '28'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="pendingduelist.php">Pending Due List</a></li>
                     <?php
					}
					$sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '44'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="report_fule.php">Fuel</a></li>
                     <?php
					}
                   	?>
					</ul>
				</li>
                  <?php
			   }
			    if($module_id == 7)
			   {
               ?>
                 <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-bell" ></i>Booking
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                      <?php
					    $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '29'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="booking_menu.php">Add</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '30'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="booking_menu_edit.php">Edit</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '31'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="booking_menu_delete.php">Delete</a></li> 
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '32'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a class="" href="booking_menu_search.php">Search</a></li>
                      <?php
					}
						?>
					</ul>
				</li>
			 <?php
			   }
			    if($module_id == 8)
			   {
               ?>	
                 <li class="has-sub" >
					<a href="javascript:;" class="">
					<i class="icon-key" ></i>Security
					<span class="arrow"></span>
					</a>
					<ul class="sub">
                      <?php
					    $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '33'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="add_counter.php">Add Counter</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '34'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
					<li><a href="add_right.php">Add Right</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '35'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                    <li><a href="update_right.php">Update Right</a></li>
                      <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '36'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
                     <li><a href="view_right.php">View Right</a></li>
                       <?php
					}
					  $sql_next="select * from sub_module_assign where login_id='$id' && `submodule_id` = '37'";
                    $result_sub_menu = $data_base_object->execute_query_return($sql_next);
                	$arr_sub_menu=mysql_fetch_array($result_sub_menu);   
				 $total_rows=mysql_num_rows($result_sub_menu);             
					if($total_rows>0)
					{
						?>
            	     <li><a href="backup.php">Backup</a></li>
                       <?php
					}
						?>
					</ul>
				</li>
		 
                <?php
			   }
	       }
	
		   ?>
			
               </ul>
      </div>
<?php 
 }
 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function footer()
{?>
      <footer class="diplaynone">
        <p style="margin-left:200px"><a href="http://www.nmcorp.co.in" target="_blank">&copy; NMCorp 2013</a>| All Rights Reserved</p>
      </footer>
<?php
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function menu()
{
?>

            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER-->
                  <!-- END STYLE CUSTOMIZER-->      
              </div>
            </div>    
<?php
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function datepicker()
{?>
   <script>
  
        $(function(){
            window.prettyPrint && prettyPrint();
            $('#dp1').datepicker({
                format: 'dd/mm/yyyy'
            });
			$('#dp1').on('changeDate', function(ev){
			$(this).datepicker('hide');
			});
			$('#dp2').datepicker({
                format: 'dd/mm/yyyy'
            });
			$('#dp2').on('changeDate', function(ev){
			$(this).datepicker('hide');
			});
			$('#dp3').datepicker({
                format: 'dd/mm/yyyy'
            });
			 $('#dp3').on('changeDate', function(ev){
			$(this).datepicker('hide');
			}); 
			$('#dp4').datepicker({
                format: 'dd/mm/yyyy'
            });
			$('#dp4').on('changeDate', function(ev){
			$(this).datepicker('hide');
			});
			$('#dp5').datepicker({
                format: 'dd/mm/yyyy'
            });
			 $('#dp5').on('changeDate', function(ev){
			$(this).datepicker('hide');
			}); 
			$('#dp6').datepicker({
                format: 'dd/mm/yyyy'
            });
			 $('#dp6').on('changeDate', function(ev){
			$(this).datepicker('hide');
			}); 
			$('#dp7').datepicker({
                format: 'dd/mm/yyyy'
            });
			 $('#dp7').on('changeDate', function(ev){
			$(this).datepicker('hide');
			}); 
        });
    </script>

<?php
} 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ajax()
{ ?>
<script type="text/javascript">
 
	function fillMe()
{

		var ajaxRequest;  // The variable that makes Ajax possible!
		try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){
					// Something went wrong
					alert("Your browser broke!");
					return false;
				}
			}
		}
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function()
		{
			if(ajaxRequest.readyState == 4)
			{
				document.getElementById('will_be' ).innerHTML=ajaxRequest.responseText;
			}
		}
	//	var list = document.form_name.supplier_master_id;
	//	var car_name = list.options[list.selectedIndex].text;
        var car_name_new = document.getElementById('car_name_id').value;
		ajaxRequest.open("GET", "common.php?supplier_master_type="+car_name_new, true);
		ajaxRequest.send(null); 	
	}
		 
function fetch_price(value)
{

		var ajaxRequest;  // The variable that makes Ajax possible!
		try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
		} catch (e){
			// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try{
					ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e){
					// Something went wrong
					alert("Your browser broke!");
					return false;
				}
			}
		}
		
		// Create a function that will receive data sent from the server
		ajaxRequest.onreadystatechange = function()
		{
			if(ajaxRequest.readyState == 4)
			{
				document.getElementById('price_here' ).innerHTML=ajaxRequest.responseText;
			}
		}
	//	var list = document.form_name.supplier_master_id;
	//	var car_name = list.options[list.selectedIndex].text;
		ajaxRequest.open("GET", "fetch_fuel_price.php?price="+value, true);
		ajaxRequest.send(null); 	
	}		 
</script>
		  
<?php 
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>

