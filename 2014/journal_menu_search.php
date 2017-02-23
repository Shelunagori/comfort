<?php 
require_once("function.php");
require_once("config.php");
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
     <form method="post" name="view_form">
       <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-credit-card"></i>Enter Journal Information</h4>
                    </div>
                    <div class="portlet-body form">
    <table width="100%">
                <tr>
                 <td>Journal ID</td>
				<td>
				<input type="text"  class="m-wrap medium"  name="payment_id"/>
				</td>
                </tr>
                <tr>
                <td> Date From:</td>
				<td>
				<input type="text" id="dp1" class="m-wrap medium"  name="date_from"/>
				</td>
				</tr>
				<tr>
                <td> Date To:</td>
				<td>
				<input type="text"  id="dp2"  class="m-wrap medium" name="date_to"/> <button type="submit" style="margin-left:1%;"  value="Add"  class="btn green" name="ledger_view"/>Go <i class="icon-circle-arrow-right"></i></button>
				</td>
				</tr>
                </table>
                     	<?php
				if(isset($_POST['ledger_view']))
				{
					?>
                    
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;margin-top:5%">
					<table width="100%" id="sample_1" class="table table-bordered table-hover" style="border-collapse:collapse;">
                    <thead>
                     	<tr>
                        <th >SL.</th>
                        <th >Journal ID</th>
                        <th >Ledger Type</th>
                        <th >Ledger Name </th>
                        <th >Credit</th>
                        <th >Debit</th>
                        <th >Date</th>
                        <th >Narration</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php   
					 $q1="";	$q2="";	$q3="";	
				
					
					if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
					{
					$date_from=DateExact($_POST['date_from']);
				 	$date_to=DateExact($_POST['date_to']);
					$q1=" `date` between '".$date_from."' and '".$date_to."' ";
					}
					
					if(!empty($_POST['payment_id']))
					{
					if($q1=='')	
					$q2="  `payment_id` = '".$_POST['payment_id']."' ";
					else
					$q2=" AND `payment_id` = '".$_POST['payment_id']."' ";
					}  
				   
				 
				   if($q1=='' && $q2=='')
				   {
					   $qry=" select * from ledger ";
					     $q3=" where 	`type`='journal'";
				   }
				   else 
				   {
					   $qry=" select * from ledger where ";
					     $q3=" AND `type`='journal'";
				   }
				  	$sql=$qry.$q1.$q2.$q3;
					$result=mysql_query($sql);
							
						while($row=mysql_fetch_array($result))
                     	{
							$i++;
							$payment_id=$row['payment_id'];
							$ledger_type=$row['ledger_type'];
							$name=$row['name'];
							$credit=$row['credit'];
							$debit=$row['debit'];
							$date=$row['date'];
							$narration=$row['narration'];
							?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $payment_id;?></td>
                            <td><?php echo $ledger_type;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $credit;?></td>
                            <td><?php echo $debit;?></td>
                            <td><?php echo DisplayDate($date);?></td>
                            <td><?php echo $narration;?></td>
                            </tr>
                       <?php 
                     	}
                       ?>
                        </tbody>
                      </table>
                      </div>
                    
				<?php 
				}?>
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
 <?php datepicker(); ?>

   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>