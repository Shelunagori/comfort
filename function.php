<?php
// <tt></tt> used ar pual iris resume which expand * 
date_default_timezone_set('Asia/Calcutta');
ini_set('max_execution_time', 300);
error_reporting(0);
ini_set('display_errors', 0);
@session_start();
function css()
{?>
<style type="text/css">
	body {
	padding-top: 60px;
	padding-bottom: 40px;
	}
	.radio
	{
	margin-left:0px !important;
	}
	.upr{text-transform:uppercase}
	.ad:hover
    {
	background-color:#E5E5E5;
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
          .prnt{
              page-break-after:always;
          }
		  #search{
			  display:none !important;
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
<link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css"/>
<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet"/>
<!--<link href="assets/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css"/>-->
<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css"/>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
<link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
<link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-fileupload.css" />
   
<?php }
function title()//function to show title
{	
	echo "Comfort";
}

/////////////////////////////////////////////////////////////////////////////////////////////
function logo()//function to show title
{
echo "<link rel='shortcut icon' href='assets/img/favicon.ico'/>";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function js()
{
?> 
<script src="assets/js/jquery-1.8.3.min.js"></script>		
<script src="assets/breakpoints/breakpoints.js"></script>		
<!--<script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>-->
<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.blockui.js"></script>	
<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script src="assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
 <script type="text/javascript" src="assets/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
<script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--Managed Table Start -->
<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/bootstrap-fileupload.js"></script> 
<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
<!--Managed Table End -->
<script src="assets/js/app.js"></script>
<script>
jQuery(document).ready(function() {       
// initiate layout and plugins
App.init();
});
</script>
<?php
} 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
function rightclick_disabled()
{
	?>
<script type="text/javascript">
var message="This Function is not allowed here";
///////////////////////////////////
function clickIE() {if (document.all) {(message);return false;}}
function clickNS(e) {if
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);return false;}}}
if (document.layers)
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
</script>
<?php
}

 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function navi_bar()
{ 
@session_start();
$username=$_SESSION['username'];
$comfort_id=$_SESSION['comfort_id'];
$idd=$_SESSION['id'];
$page_name_from_url=basename($_SERVER['PHP_SELF']); /* Returns The Current PHP File Name */
?>
<div class="header navbar navbar-inverse navbar-fixed-top diplaynone">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
                <a class="brand" href="index.php">
				<img src="assets/logo.jpg" width="100" alt="logo"  class="img-responsive" >
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
					<li class="dropdown" id="header_notification_bar">
                    <button type="button" class="btn mini yellow" style="height: 25px;" id="zoom"  value="zoom_out" onClick="fun_zoom(this.value);" ><i class=" icon-resize-full"></i></button>			
                    </li>
					<li class="dropdown" id="header_task_bar"> </li>
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<!--	<img alt="" src="assets/img/avatar1_small.jpg" /> -->
						<span class="username hid"><b>WELCOME: <?php echo  strtoupper($username);?></b></span>
						<i class="icon-angle-down hid" ></i>
						</a>
						<ul class="dropdown-menu hid" style="background-color:#3D3D3D;border-color:#3D3D3D;">
                        	<li>
                            <a href="change_password.php"><i class="icon-key"></i> Change password</a>
                            </li>
                           <!-- <li class="divider"></li> -->
							<li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
			  </ul>
				<!-- END TOP NAVIGATION MENU -->	
		  </div>
		</div>
	</div>
	
<?php 
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function cash_account_id()
{
$result=mysql_query("select `id` from `ledger_master` where `ledger_type_id`='5' && `name`='Cash Account'");
$row=mysql_fetch_array($result);
return($row['id']);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function supplier_type_name($supplier_type_id)
{
$result=mysql_query("select `name` from `supplier_type` where `id`='".$supplier_type_id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function supplier_type_sub_name($supplier_type_id)
{
$result=mysql_query("select `name` from `supplier_type_sub` where `id`='".$supplier_type_id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function datefordb($date)
{$date_new=date("Y-m-d",strtotime($date));return($date_new);}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function dateforview($date)
{
$date_no='N/A';	
$date_new=date("d-m-Y",strtotime($date));
if($date_new=='01-01-1970'||$date_new=='30-11-0001')
return($date_no);
else
return($date_new);}///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchsuppliername($id)
{
$result=mysql_query("select `name` from `supplier_reg` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchcustomername($id)
{
$result=mysql_query("select `name` from `customer_reg` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchcarname($id)
{
$result=mysql_query("select `name` from `car_type` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchservicename($id)
{
$result=mysql_query("select `name` from `service` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name = $row['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchusername($login_id)
{
$result=mysql_query("select `username` from `login` where `id`='".$login_id."'");
$row=mysql_fetch_array($result);
$username=$row['username'];	
return($username);						
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchcountername($login_id)
{
$result=mysql_query("select `name` from `counter` where `id`='".$login_id."'");
$row=mysql_fetch_array($result);
$name=$row['name'];	
return($name);						
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchcarno($id)
{
$result=mysql_query("select `name` from `car_reg` where `id`='".$id."'");
$row=mysql_fetch_array($result);
$name=$row['name'];	
return($name);		
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchimg()
{
$result=mysql_query("select `auth_sign` from `taxation`");
$row=mysql_fetch_array($result);
$auth_sign=$row['auth_sign'];	
return($auth_sign);		
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function counterfun($id)
{
$result=mysql_query("select `name` from `counter`");
$row=mysql_fetch_array($result);
$name=$row['name'];	
return($name);		
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchledgertype_name($id)
{
$result_table=mysql_query("select `name` from `ledger_type` where `id`='".$id."'");
$row_table=mysql_fetch_array($result_table);
$name=$row_table['name'];
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchledger_name($ledger_master_id)
{
$result_ledger_main_id=mysql_query("select `name` from `ledger` where `id`='".$ledger_master_id."'");
$row_ledger_main_id=mysql_fetch_array($result_ledger_main_id);
$name=$row_ledger_main_id['name'];	
return($name);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function fetchdrivername($driver_id)
{
$result_driver=mysql_query("select `name` from `driver_reg` where `id`='".$driver_id."'");	
$row_driver=mysql_fetch_array($result_driver);
$name=$row_driver['name'];
return($name);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function qrcode($invoice_id) 
{
	$qrcode="comforttours.in +919461907903 ".$invoice_id;
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;    
    $PNG_WEB_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR))
     mkdir($PNG_TEMP_DIR); 
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 2.5;
     if (isset($qrcode)) 
	{ 
	      $filename = $PNG_TEMP_DIR.$qrcode.'.png';
          QRcode::png($qrcode, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
		 echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />'; 	
	}
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function convert_number_to_words($number) {
  
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(


        01	                 => 'One',
        02                   => 'Two',
        03                   => 'Three',
        04                   => 'Four',
        05                   => 'Five',
        06                   => 'Six',
        07                   => 'Seven',
        08                   => 'Eight',
        09                   => 'Nine',



        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
  
    if (!is_numeric($number)) {
        return false;
    }
  
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
  
    $string = $fraction = null;
  
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
  
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
  
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
  
    return $string;
}

function serial_no($number)
 {

 $str_lenth=strlen($number);
if($str_lenth==1)
{
$number='000'.$number;
}
else if($str_lenth==2)
{
$number='00'.$number;
}

else if($str_lenth==3)
{
$number='0'.$number;
}
echo $number;


}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 function security($id,$counter_id)
{ 
	$l_id=$id;
 	$c_id=$counter_id;
	
	$page_name_from_url = strlen($_SERVER['QUERY_STRING']) ? basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);	
	
	$sel_module=mysql_query("select `id` from `module` where `page_link`='".$page_name_from_url."' ");
	$count_module = mysql_num_rows($sel_module);
	if($count_module>0)
	{
	$arr_module=mysql_fetch_array($sel_module);
	$sel_user_rights=mysql_query("select `id` from `user_right` where (`login_id`='".$l_id."' || `role_id`='".$c_id."') && `module_id`='".$arr_module['id']."'");
	$num_user=mysql_num_rows($sel_user_rights);
		if(empty($num_user)&&($page_name_from_url!="index.php"))
		{
			echo '<script>
			alert("Oops! You are lost");
			location="index.php";
			</script>';
		}
	}
	else
	{
	$sub_module=mysql_query("select `id` from `sub_module` where `page_link`='".$page_name_from_url."'");
	$count_sub = mysql_num_rows($sub_module);
	if($count_sub>0)
	{
	$arr_submodule=mysql_fetch_array($sub_module);
	$sub_user_rights=mysql_query("select `id` from `user_right` where (`login_id`='".$l_id."' || `role_id`='".$c_id."') && `submodule_id`='".$arr_submodule['id']."'");
	$sub_user=mysql_num_rows($sub_user_rights);
		if(empty($sub_user)&&($page_name_from_url!="index.php"))
		{
			echo '<script>
			alert("Oops! You are lost");
			location="index.php";
			</script>';
		}
	}
	else
	{
		$sub_sub_module=mysql_query("select `id` from `sub_submodule` where `page_link`='".$page_name_from_url."'");
		$count_subsub=mysql_num_rows($sub_sub_module);
		if($count_subsub>0)
		{
			$arr_subsubmodule=mysql_fetch_array($sub_sub_module);
			$subsub_user_rights=mysql_query("select `id` from `user_right` where (`login_id`='".$l_id."' || `role_id`='".$c_id."')  && `sub_submodule_id`='".$arr_subsubmodule['id']."'");
			$subsub_user=mysql_num_rows($subsub_user_rights);
			if(empty($subsub_user)&&($page_name_from_url!="index.php"))
			{
			echo '<script>
			alert("Oops! You are lost");
			location="index.php";
			</script>';
			}
		}
	}
	}


}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function navi_menu()
{ 
?>
      <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar nav-collapse collapse diplaynone" id="asd" >
        <div class="slide hide">
        <i class="icon-angle-left"></i>
        </div>
        
        <div class="clearfix"></div>
        <ul style="margin-top:0px;">
         
              	<?php
                include("config.php");
                @session_start();
                $counter_id = $_SESSION['counter_id'];
                $id = $_SESSION['id'];
                $i=0;
                $module_result=mysql_query("select * from `module` ");
                while( $ftc_module=mysql_fetch_array($module_result))
                {
                $i++;
                $menu_name_id= $ftc_module['id'];
                $menu_name_name= $ftc_module['mainmenu_name'];
                $target_blank_main_menu= $ftc_module['target_blank'];
                $page_link_main_menu= $ftc_module['page_link'];
                $page_icon_main_menu= $ftc_module['page_icon'];
								
                $user_right_result=mysql_query("select `id` from `user_right` where (`login_id`='".$id."' || `role_id`='".$counter_id."')  && `module_id`='".$menu_name_id."'");
                $num_rows_user_right=mysql_num_rows($user_right_result);
                if($num_rows_user_right>0)
                {
                $user_right_result_next=mysql_query("select `id` from `user_right` where ( `role_id`='".$counter_id."' || `login_id`='".$id."' )  && `module_id`='".$menu_name_id."' && `submodule_id`='0'"); // condition if we get result means only module is found , submodule is not found in this case.
                $num_rows_user_right_next=mysql_num_rows($user_right_result_next);	
				security($id,$counter_id);
                ?>	
                <!-- if $num_rows_user_right_next is greater then 0 means only main module is awailable sub module is not awailable -->
                <li class="has-sub"><a  <?php echo $target_blank_main_menu;  if($i==1) { ?>   style="background-color:#5CB85C  !important; border-color:#4CAE4C  !important;"  <?php  } ?> href="<?php echo $page_link_main_menu ; ?>" class=""><i class="<?php echo $page_icon_main_menu ; ?>"></i>
                <?php echo $menu_name_name ; if($num_rows_user_right_next==0){?> <span class="arrow"></span> <?php } ?>	</a> 
                <?php 		
                if($num_rows_user_right_next==0)
                {
                ?>
                <ul class="sub">
                <?php
           $user_right_result=mysql_query("select `submodule_id` from `user_right` where (`role_id`='".$counter_id."' || `login_id`='".$id."') && `module_id`='".$menu_name_id."' GROUP BY `submodule_id`");	
                while($ftc_sub_menu_name=mysql_fetch_array($user_right_result))
                {
                $sub_menu_name_idd= $ftc_sub_menu_name['submodule_id'];
                $fetching_data=mysql_query("select * from `sub_module` where `id`='".$sub_menu_name_idd."'");
                $row_data = mysql_fetch_array($fetching_data);
                $sub_module_name1 = $row_data['submenu_name'];
                $page_link_sub_menu1= $row_data['page_link'];
                $page_icon_sub_menu1= $row_data['page_icon'];
                $target_blank_seb_menu1= $row_data['target_blank'];
                if(!empty($sub_module_name1))
                {
				$result_subsub=mysql_query("select `sub_submodule_id` from `user_right` where (`role_id`='".$counter_id."' || `login_id`='".$id."') && `module_id`='".$menu_name_id."' && `submodule_id`='".$sub_menu_name_idd."'");	
				$num_sub=mysql_num_rows($result_subsub);
				$arr_avail=mysql_fetch_array($result_subsub);
				if($arr_avail['sub_submodule_id']==0)	
				{
				security($id,$counter_id);
                ?>
                <li><a <?php echo $target_blank_seb_menu1 ; ?> href="<?php echo $page_link_sub_menu1; ?>"><?php echo $sub_module_name1; ?></a></li>
                <?php 
				}
				else
				{
					$result_subsub=mysql_query("select `sub_submodule_id` from `user_right` where (`role_id`='".$counter_id."' || `login_id`='".$id."') && `module_id`='".$menu_name_id."' && `submodule_id`='".$sub_menu_name_idd."'");	
					$num_last=mysql_num_rows($result_subsub);
					security($id,$counter_id);
					?>
                        <li class="dropdown-submenu">
                        <a href="<?php echo $page_link_sub_menu1; ?>"><?php echo $sub_module_name1; ?></a>
                        <ul class="dropdown-menu"  style="background-color:#3D3D3D;border-color:#3D3D3D;margin-top:.2px;">
                        <?php
                    while($ftc_subsub=mysql_fetch_array($result_subsub))
					{$inter++;
					$sub_submodule_id=$ftc_subsub['sub_submodule_id'];
					$fetching_last_menu=mysql_query("select * from `sub_submodule` where `id`='".$sub_submodule_id."'");
					$row_data_sub = mysql_fetch_array($fetching_last_menu);
					$sub_submenu_name = $row_data_sub['sub_submenu_name'];
					$page_link_subsub= $row_data_sub['page_link'];
					$menu_icon_subsub= $row_data_sub['menu_icon'];
					$target_blank = $row_data_sub['target_blank'];
					?>
                        <li><a <?php if($inter==1) { ?> style="background-color:#4B4B4B;" <?php } ?><?php echo $target_blank; ?> href="<?php echo $page_link_subsub; ?>"><i class="<?php echo $menu_icon_subsub; ?>"></i><?php echo $sub_submenu_name; ?></a></li>
                        <?php
					}$inter=0;
					?>
                        </ul>
                    <?php
					
				}
                }
                }
                ?>
                </ul>
                <?php
                }
                ?>
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
        <p style="margin-left:200px"><a href="http://www.phppoets.com" target="_blank">&copy; PHPPOETS 2015</a>| All Rights Reserved</p>
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function enterdisabled()
{
	?>
     <script type="text/javascript">
	 function keyPressed(e)
{
     var key;      
     if(window.event)
          key = window.event.keyCode; //IE
     else
          key = e.which; //firefox      

     return (key != 13);
}
	 </script>
    <?php
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function ajax()
{ ?>
<script type="text/javascript">
  var xobj;
   //modern browers
   if(window.XMLHttpRequest)
    {
	  xobj=new XMLHttpRequest();
	  }
	  //for ie
	  else if(window.ActiveXObject)
	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
		  alert("Your broweser doesnot support ajax");
		}
		  
		  
	 function right_fetch()
		 {
		  document.getElementById("personal_data").innerHTML="<img  style='margin-top:10%' src='maskinput/ajax-loader.gif'></img>";		 
		  if(xobj)
			 {		
			 var c1=document.getElementById("login_id").value;
			 var query="?login_id=" + c1;
			 xobj.open("GET","ajax_user_right.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("personal_data").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }	

function fetch_ledger_jv(value,place)
	{
		if(xobj)
			 {	
			 var query="?ledger_type_jv=" + value + "&name_extension=" + place;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("option_name"+place).innerHTML=xobj.responseText;
 		       load_data();
			   }
			  }
			  
			 }
			 xobj.send(null);
	}
	
	function fetch_ledger()
	{
		if(xobj)
			 {	
    		 document.getElementById("ledger_name_place").innerHTML="<img  style='margin-left:10%' src='maskinput/ajax-loader.gif'></img>";		
			 var ledger_type=document.getElementById("ledger_type").value;  	
			 var query="?ledger_type=" + ledger_type;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("ledger_name_place").innerHTML=xobj.responseText; 
			    load_data();
			   }
			  }
			
			 }
			 xobj.send(null);
	}
	
	function load_data()
	{
		 $(".chosen").chosen(); 
	}
 	
	
	function fetch_ldrview(value)
	{	
		if(xobj)
		{
		var status=+$("#ldr_view"+value).is(':checked');
		var l_idd=$('input[name=l_idd'+value+']').val();
		 var query="?l_idd=" + l_idd + "&status=" + status;
		 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   }
			  }
			 }
			 xobj.send(null);
	}
	
/*
	function fetch_invoice_no(value)
	{
		var ins_no = value;
	   $.ajax({
            type:"get",
            url:"ajax_page.php",
            data:"ins_no="+ins_no,
            success:function(result)
            { 

          var place=$('#ledger_name').closest('.input_fields_wrap').find('#ins_list_place');
            	            	$(place).html(result);
            }
        });
	}
*/	
	
	function update_invoice_no(name,old_ins)
	{
		     if(xobj)
			 {
			 var query="?update_receipt_invoice=" + old_ins + "&update_receipt_cust=" + name;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("ins_list_place").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
	}
	
	function fetch_branch()
	{
		 if(xobj)
			 {	
    		 document.getElementById("branch_place").innerHTML="<img  style='margin-left:20%' src='maskinput/ajax-loader.gif'></img>";		
			 var c1=document.getElementById("bank_id").value;  	
			 var query="?bank_id=" + c1;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("branch_place").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
	}

		  
	function fetch_price(value)
	{
		 if(xobj)
			 {	
    		 document.getElementById("price_place").innerHTML="<img  style='margin-left:20%' src='maskinput/ajax-loader.gif'></img>";		  	
			 var query="?fuel_type=" + value;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
			   document.getElementById("price_place").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
	}

	function fetch_reading(value)
	{
		 if(xobj)
			 {		
			 var query="?car_reading=" + value;
			 xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
					var str=xobj.responseText;
					str = str.replace(/\s/g, '');
			   document.getElementById("opening_km").value=str;
			   }
			  }
			  
			 }
			 xobj.send(null);
	}
	
 function desgi_wise()
		  {
		  document.getElementById("role_data").innerHTML="<img style='margin-top:10%' src='maskinput/ajax-loader.gif'></img>";		 
		  if(xobj)
			 {	
		 	 var myrole=document.getElementById("myrole").value;	
			 var query="?role_id=" + myrole;
			 xobj.open("GET","ajax_user_right.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("role_data").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }	
	
function add_desg()
{
var counter=document.getElementById('counter').value;
if(counter!='')
{
	 if(xobj)
       {
           var query="?counter=" + counter;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {
				document.getElementById('counter').value='';         
 				document.getElementById("counter_here").innerHTML=xobj.responseText;
			   }
			  }
             }
             xobj.send(null);
}
}
		  	  
		  
function delete_cust(id,i)
{
	
 if(xobj)
       {
           var query="?delete_cust_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Customer Deleted!</h4>';
				 var my_details='<p >Customer Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}



function delete_supplier(id,i)
{
	
 if(xobj)
       {
           var query="?delete_supplier_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Supplier Deleted!</h4>';
				 var my_details='<p >Supplier Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_employee(id,i)
{
 if(xobj)
       {
           var query="?delete_emp_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Employee Deleted!</h4>';
				 var my_details='<p >Employee Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}


function delete_car(id,i)
{
 if(xobj)
       {
           var query="?delete_car_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Car Deleted!</h4>';
				 var my_details='<p >Car Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}


function delete_tariff(id,i)
{
 if(xobj)
       {
           var query="?delete_tariff_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Tariff Deleted!</h4>';
				 var my_details='<p >Tariff Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_customer_tariff(id,i)
{
 if(xobj)
       {
           var query="?delete_customer_tariff_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Customer Tariff Deleted!</h4>';
				 var my_details='<p >Customer Tariff Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_supplier_tariff(id,i)
{
 if(xobj)
       {
           var query="?delete_supplier_tariff_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Supplier Tariff Deleted!</h4>';
				 var my_details='<p >Supplier Tariff Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}


function delete_booking(id,i)
{
 if(xobj)
       {
           var query="?delete_booking_id=" + id;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Booking Deleted!</h4>';
				 var my_details='<p >Booking Deleted Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_dutyslip(id,i)
{
	if(xobj)
       {
		   var waveoff_reason=document.getElementById("waveoff_reason" + i).value;
           var query="?delete_dutyslip_id=" + id + "&waveoff_reason=" + waveoff_reason;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Dutyslip Waveoff!</h4>';
				 var my_details='<p >Dutyslip Waveoff Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_invoice(id,i)
{
	if(xobj)
       {
		   var waveoff_reason=document.getElementById("waveoff_reason" + i).value;
           var query="?delete_invoice_id=" + id + "&waveoff_reason=" + waveoff_reason;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Invoice Waveoff!</h4>';
				 var my_details='<p >Invoice Waveoff Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function delete_corporate(id,i)
{
	if(xobj)
       {
		   var waveoff_reason=document.getElementById("cor_waveoff_reason" + i).value;
           var query="?delete_coporate_id=" + id + "&cor_waveoff_reason=" + waveoff_reason;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				 document.getElementById(i).innerHTML="";
			   	 var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Corporate Waveoff!</h4>';
				 var my_details='<p >Corporate Bill Waveoff Successfully</p>';
			     my_notification(my_activity,my_details);
			   }
			  }
             }
             xobj.send(null);
}

function fetch_rate(value)
{
	
		 if(xobj)
			 {
				if(value=='get_km')
				{	 
					 var car_id=document.forms["add_form"]["car_id"].value;
					 var query="?car_id=" + car_id + "&identity=" + "Opening_km";
				}
				else 
				{
					var customer_id=document.forms["add_form"]["customer_id"].value;
					var service_id=document.forms["add_form"]["service_id"].value;
					var car_type_id=document.forms["add_form"]["car_type_id"].value;
					var query="?customer_id=" + customer_id + "&service_id=" + service_id + "&car_type_id=" +car_type_id + "&identity=" + "ratefix";	
				}
			 xobj.open("GET","ajax_page.php" +query,true);
			 
			 xobj.onreadystatechange=function()
			 {
				  if(xobj.readyState==4 && xobj.status==200)
				  {
				    var str=xobj.responseText;
				    str = str.replace(/\s/g, '');
					if(value=='get_km')
				  	document.forms["add_form"]["opening_km"].value=str;
					else 
	    		    document.forms["add_form"]["rate"].value=str;
				  }
			 }
			 }
			 xobj.send(null);
}
function fillMe(value)
{
 if(xobj)
       {
	    document.getElementById("will_be").innerHTML="<img src='maskinput/loding_ajx.gif'></img>";		    
           var query="?supplier_type_id=" + value;
		   xobj.open("GET","ajax_page.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {      
				document.getElementById("will_be").innerHTML=xobj.responseText;;
			   }
			  }
             }
             xobj.send(null);
}

function cheak()
{
		var list = document.add_form.car_id;
		var car_no=list.options[list.selectedIndex].text;
		var res = car_no.split(" ");
		var oter = res[0];
		if(oter=='Other')	
		document.getElementById("will_be").innerHTML="<input type='text' placeholder='Enter car number' required class='m-wrap medium' name='temp_car_no'>";
		else
		document.getElementById("will_be").innerHTML="";	             
}

function cheak_driver()
{	
		var list = document.add_form.driver_id;
		var driver_id=list.options[list.selectedIndex].text;
		if(driver_id=='Others')	
		document.getElementById("will_be_driver").innerHTML="<input type='text' placeholder='Enter driver name' required class='m-wrap medium' name='temp_driver_name'>";
		else
		document.getElementById("will_be_driver").innerHTML="";	             
}



function dutyslip_openclose() 
{
	if(document.getElementById("opening_km").value=="0")
	{	
		alert("Close previous DS.");
		window.location.href='dutyslip_menu.php';
	}
}

function HideShowRows()
{
	for(var i=1;i<=5;i++)
	{
	 	if (document.getElementById(i).style.display == 'none') {
         document.getElementById(i).style.display = '';
     	} else {
         document.getElementById(i).style.display = 'none';
     	}
	}
}

		  
			function allLetter(inputtxt,id)  
			{  
			//var numbers = /^[-+]?[0-9]+$/;
			var numbers =  /^[0-9]*\.?[0-9]*$/;  
			if(inputtxt.match(numbers))  
			{  
			
			}  
			else  
			{  
				//var data=inputtxt.slice(0, -1);
			document.getElementById(id).value=""; 
			return false;  
			}  
			} 
			

			function fun_zoom(value)
			{
					if(value=='zoom_out')
					{
					document.getElementById("zoom_div").style.marginLeft = "0px";
					document.getElementById("asd").style.display='none';
					document.getElementById("zoom").value='zoom_in';
					document.getElementById("zoom").innerHTML='<i class="icon-resize-small"></i>';
					}
					else if(value=='zoom_in')
					{
					document.getElementById("zoom_div").style.marginLeft = "225px";
					document.getElementById("asd").style.display='block';
					document.getElementById("zoom").value='zoom_out';
					document.getElementById("zoom").innerHTML='<i class="icon-resize-full"></i>';	
					}
			}
			
			function mydatepick()
			{    
			$(document).ready(function() {	
			$('.date-picker').datepicker();
			$('.date-picker').datepicker().on('changeDate', function(){
			$(this).blur();
			$(this).datepicker('hide');
			})});
			}
			
			function my_notification(my_activity,my_details)
			{		
			$('#gritter-without-image').ready(function () {
			$.gritter.add({
			// (string | mandatory) the heading of the notification
			title:  my_activity,
			// (string | mandatory) the text inside the notification
			text: my_details,
			class_name: 'gritter-without-image'
			});
			
			return false;
			});
			}
			
			function makeAlert()
			{
			var list = document.form_name.emp_type;
			var emp_type = list.options[list.selectedIndex].text;
			if(emp_type=="Driver")
			{
			// driver validations
			document.getElementById("dname").innerHTML="Driver Name: ";
			document.getElementById("dmob").innerHTML="Driver Mobile No.: ";
			}
			else
			{
			// employee validations
			document.getElementById("dname").innerHTML="Employee Name: ";
			document.getElementById("dmob").innerHTML="Employee Mobile No.: ";
			}
			}
			
function fetch_menulink(value)
{
	if(value=='2'){
	document.getElementById("menu_type").value='javascript:;';
	document.getElementById("menu_type").readOnly=true;}
	else{
	document.getElementById("menu_type").value='';
	document.getElementById("menu_type").readOnly=false;}
}
function change_icon(i)
{
	var what=document.getElementById("myicon"+i).className;
	if(what=="icon-plus")
	{
	document.getElementById("myicon" +i).className='icon-minus';
	}
	else
	{
	document.getElementById("myicon" +i).className='icon-plus';	
	}
}			
</script>
<script>
function GetRow() {
	
    var ajaxRequest=GET_AJAX();
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function () {
        if (ajaxRequest.readyState == 4) {
            var table=document.getElementById('journal_table');
            var tBody = document.createElement("tbody");
            tBody.innerHTML = ajaxRequest.responseText;
            table.appendChild(tBody);
        }
    }
    		document.getElementById('srno').value++;
    		var srno= document.getElementById('srno').value; 
    		ajaxRequest.open("GET", "ajax_page.php?srno="+srno, true);
    		ajaxRequest.send(null);
}




function GET_AJAX()
{
	var ajaxRequest;  // The variable that makes Ajax possible!
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    return ajaxRequest;
}

</script>
<?php 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

