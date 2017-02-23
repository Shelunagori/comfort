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
<div>                     
<a href="customer_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="customer_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="customer_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div> 
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-table"></i>View</h4>
                     </div>
                     <div class="portlet-body form">
                 
 <?php
if(isset($_GET['customer']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select * from `customer_reg` where `id`='".$_GET['id']."'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$name=$row['name'];
	$address=$row['address'];
	$Contact_person=$row['Contact_person'];
	$office_no=$row['office_no'];
	$Residence_no=$row['Residence_no'];
	$mobile_no=$row['mobile_no'];
	$email_id=$row['email_id'];
	$fax_no=$row['fax_no'];
	$opening_bal=$row['opening_bal'];
	$closing_bal=$row['closing_bal'];
	$srvctaxregno=$row['srvctaxregno'];
	$panno=$row['panno'];
	$creditlimit=$row['creditlimit'];
?>
  <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
<table width="100%" align="center" class="table table-bordered table-hover" style="text-align:center;">
  <tr>
  <td>Date : &nbsp;&nbsp;<?php echo date('Y-m-d') ;?></td>
    <td colspan="6" align="center"><strong>Results for <?php echo $name;?></strong></td>
    <td><!--<input type="button" onclick="javascript: window.print()" class="btn green" value="print"/>--></td>
  </tr>
  <tr>
    <td width="156"><strong>Name:</strong></td>
    <td width="156"><?php echo $name;?></td>
    <td width="156"><strong>Address:</strong></td>
    <td width="156"><?php echo $address;?></td>
    <td><strong>Contact Person :</strong></td>
    <td><?php echo $Contact_person; ?></td>
    <td><strong>Office Number:</strong></td>
    <td><?php echo $office_no;?></td>
  </tr>
   <tr>
   <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Residence Number:</strong></td>
    <td><?php echo $Residence_no;?></td>
    <td><strong>Mobile Number:</strong></td>
    <td><?php echo $mobile_no;?></td>
     <td><strong>Email Id:</strong></td>
    <td><?php echo $email_id;?></td>
     <td><strong>Fax Number:</strong></td>
    <td><?php echo $fax_no;?></td>
  </tr>
   <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Opening Balance:</strong></td>
    <td><?php echo $opening_bal;?></td>
    <td><strong>Closing Balance:</strong></td>
    <td><?php echo $closing_bal;?></td>
    <td><strong>Service Tax Reg. No.:</strong></td>
    <td><?php echo $srvctaxregno;?></td>
    <td><strong>PAN No.:</strong></td>
    <td><?php echo $panno;?></td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Credit Limit:</strong></td>
    <td><?php echo $creditlimit;?></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="100px;">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td width="130px"></td>
    <td></td>
    <td width="130px;">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
</div>
<?php 
}
}
?>
                 
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