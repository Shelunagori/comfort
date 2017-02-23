<?php
require_once("config.php");
function temp()
{
?>
<script src="assets/js/jquery-1.8.3.min.js"></script>	
<script src="maskinput/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script>
jQuery(function($){
   $("#dob").mask("99-99-9999");
   $("#year").mask("9999");
   $("#pin_code").mask("999999"); 
   $("#mobileno").mask("9999999999");
   $("#driver_mob").mask("9999999999");
});
</script>
<?php
}
function autocomplete()
{
	?>
<script type='text/javascript' src='autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
<script type="text/javascript">
$(document).ready(function() {
	$("#customer_fetch").autocomplete("autocomplete/auto_cust_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#mobileno").autocomplete("autocomplete/auto_cust_mob_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#email_id").autocomplete("autocomplete/auto_cust_email_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#supplier_id").autocomplete("autocomplete/auto_supplier_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#fetch_driver").autocomplete("autocomplete/auto_driver_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#driver_mob").autocomplete("autocomplete/auto_driver_mob_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#car_fetch").autocomplete("autocomplete/auto_car_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#vehicle_fetch").autocomplete("autocomplete/auto_vehicle_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
	$("#l_name").autocomplete("autocomplete/auto_l_name_fetch.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
</script>
    <?php
}
