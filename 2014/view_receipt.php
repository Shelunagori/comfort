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
         <div class="container-fluid">
     <?php menu(); ?>
     <form method="post">
     <?php
      if(isset($_GET['receipt']) && isset($_GET['id']))
{
$data_base = new DataBaseConnect();	
$result=$data_base->execute_query_return("select `date`,`name`,`credit`,`narration`, `type_id`  from `ledger` where `type_id`='".$_GET['id']."' && `type`='Receipt'");
if(mysql_num_rows($result)>0)
{
	$row=mysql_fetch_array($result);
	$date=$row['date'];
	$name=$row['name'];
	$credit=$row['credit'];
	$narration=$row['narration'];
	$type_id=$row['type_id'];
?>
<table width="100%" class="table table-bordered table-hover table-condensed flip-content" align="center"  style="text-align:center;">
  <tr>
    <td colspan="3" align="left"><span><strong style="font-size:20px; font-family:calibri;">COMFORT  TRAVELS AND TOURS </strong></span><br/>
      104-106 &quot;Akruti&quot;<br/>
      <span> 4- New Fatehpura, Opp. Saheliyo ki Badi, UDAIPUR-313004 </span>
<br/>      <span>email:comfortadl@sancharnet.in</span></td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center"><strong style="font-size:20px; font-family:calibri;">RECEIPT</strong></td>
  </tr>
  <tr>
    <td align="left" width="100"><strong>Receipt No.</strong><br/>
<strong>Date</strong>
    </td>
    <td colspan="2" align="left">&nbsp;&nbsp;<?php echo $type_id;?><br/>
    <?php echo DisplayDate($date);?></td>
  </tr>
   <tr align="left">
     <td><strong>Paid To:</strong>
     <br/>
    <strong> The Sum of Rs.</strong>
     </td>
     <td colspan="2" align="left">&nbsp;&nbsp;<?php echo $name;?>
     <br/>
     <span style="text-transform:capitalize;">
     &nbsp;&nbsp; <?php echo $credit ; ?> &nbsp;&nbsp;
        <?php 
$one=array(" "," one"," two"," three"," four"," five"," six"," seven","
eight"," nine"," ten"," eleven"," twelve"," thirteen"," fourteen","
fifteen"," sixteen"," seventeen"," eighteen"," nineteen");
$ten=array(" "," "," twenty"," thirty"," forty"," fifty"," sixty","
seventy"," eighty"," ninety");
$n=$row['credit'];
                  pw(round($n/10000000)," crore");
                  pw(round(($n/100000)%100)," lakh");
                  pw(round(($n/1000)%100)," thousand");
                  pw(round(($n/100)%10)," hundred");
                  pw(round($n%100)," ");
                  echo " only /-";

?>
</span>
     )</td>
  </tr>
  <tr align="left">
    <td colspan="3">
    <?php echo $narration; ?>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="center">
    <td colspan="2" style="text-align:center"><strong>Prepared By &nbsp;&nbsp;&nbsp;&nbsp;Approved By</strong></td>
  </tr>
</table>
<?php 
}
$data_base->close_connection();
}
?>
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
   <?php 

function pw($n,$ch)
{
	global $one;
	global $ten;
 if($n>19)echo $ten[$n/10],$one[$n%10];
 else echo $one[$n];
 if($n)echo $ch;
}
?>
</body>
<!-- END BODY -->
</html>