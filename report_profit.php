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
         <div class="container-fluid">
     <?php menu(); ?>
    
                <form  name="form_name" class="form-horizontal"  method="post">
                <div class="portlet box green">
                <div class="portlet-title">
                <h4><i class="icon-gift"></i> Profit & Loss</h4>
                </div>
                <div class="portlet-body form">
               	
                      
                <div class="control-group">
                <label class="control-label">Date From</label>
                <div class="controls">
                <input type="text" name="date_from" onClick="mydatepick();"  class="span4 m-wrap date-picker" />
                </div>
                </div>    
                
                <div class="control-group">
                <label class="control-label">Date To</label>
                <div class="controls">
                <input type="text" name="date_to" onClick="mydatepick();" class="span4 m-wrap date-picker" />
                <button type="submit"   class="btn green" name="profit_gen"/><i class="icon-signal"></i> Generate</button>
                <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
                </div>
                </div>    
                
                <?php
				if(isset($_POST['profit_gen']))
                {
					?>
                      <table width="100%" class="table table-condensed">
                      
                      <tr>
                      <th colspan="2" style="text-align:center;">PROFIT & LOSS ACCOUNT <br/><?php echo dateforview($_POST['date_from']); ?> To <?php echo  dateforview($_POST['date_to']); ?></th>
                      </tr>
                    
                        <tr>
                        <td width="50%" style="border-right:#DDDDDD 2px solid;">
                        <table width="100%">
                        <tr>
                        <th>Particulars</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">To Indirect Exp</th>
                        </tr>
                        <?php
						$res_income=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_income=mysql_fetch_array($res_income))
						{
							$temp=0;
							$res_income_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_income['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_income_credit=mysql_fetch_array($res_income_credit))
							{
								$temp=$row_income_credit['credit']-$row_income_credit['debit']+$temp;
							}
								$all_cr+=$temp;
						}

						$result_left=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Expense'");
						while($row_left=mysql_fetch_array($result_left))
						{
							$flag_expense=0;
							$result_debit=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_left['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_debit=mysql_fetch_array($result_debit))
							{
								$flag_expense=$row_debit['debit']-$row_debit['credit']+$flag_expense;
							}
								$all_exp+=$flag_expense;
							if($flag_expense>0||$flag_expense<0)
							{
							?>
                            <tr>
                            <td><?php echo $row_left['name']; ?></td>
                            <td><?php echo $flag_expense; ?></td>
                            <td>&nbsp;</td>
                            </tr>
                            <?php
							}
						}
						$profit=$all_cr-$all_exp;
						?>
                        <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo $all_exp; ?></th>
                        </tr>
                        <tr  style="background-color:#DFF0D8;">
                        <th colspan="2">NET PROFIT</th>
                        <th><?php echo $profit; ?></th>
                        </tr>
                        </table>
                        </td>
                       
                        <td width="50%">
                        <table width="100%">
                        <tr>
                        <th>Particulars</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">By Direct Income</th>
                        </tr>
                        <?php 
						$result_right=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_right=mysql_fetch_array($result_right))
						{
							$ntblnce=0;
							$result_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_right['id']."' and `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."'");
							while($row_credit=mysql_fetch_array($result_credit))
							{
								$ntblnce=$row_credit['credit']-$row_credit['debit']+$ntblnce;
							}
								$all_bal+=$ntblnce;
							?>
                        	<tr>
                            <td><?php echo $row_right['name']; ?></td>
                            <td><?php echo $ntblnce; ?></td>
                            <td>&nbsp;</td>
                            </tr>
                       		<?php
						}
						?>
                        <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo $all_bal; ?></th>
                        </tr>
                        </table>
                        </td>
                        </tr>
                        <tr>
                        <th style="text-align:right;"><?php echo $all_exp+$profit; ?></th>
                        <th style="text-align:right;"><?php echo $all_bal; ?></th>
                        </tr>  
                       	</table>
                    <?php
					
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