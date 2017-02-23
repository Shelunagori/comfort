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
    
                <div class="portlet box yellow">
                <div class="portlet-title">
                <h4><i class="icon-money"></i>Trial Balance</h4>
                </div>
                <div class="portlet-body form">
                <form  name="form_name" class="form-horizontal"  method="post">
                      
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
                <button type="submit"   class="btn green" name="trial_gen"/><i class="icon-signal"></i> Generate</button>
                <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
                </div>
                </div>    
                
                </form>

                <?php
				if(isset($_POST['trial_gen']))
                {
					?>
                        <form method="post" action="docburner.php">
                        <button  type="submit" style="float:right;" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i> Download in Excel</button>
                        <input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
                        <input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
                        <input type="hidden" value="trialbalance" name="excel_for">
                        </form>
                        <br/>
                        <br/>
                      		<table width="100%" class="table table-condensed table-hover" >
                     		<tr>
                            <th colspan="5" style="text-align:center;">TRIAL BALANCE FROM <?php echo dateforview($_POST['date_from']); ?> To <?php echo dateforview($_POST['date_to']); ?></th>
                            </tr>
                            <tr>
                            <th>Perticulars</th>
                            <th>Opening Bal.</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Closing Bal.</th>
                            </tr>
                            <?php
							$all_credit=0;
							$all_debit=0;
							$result_ledger_type=mysql_query("select * from `ledger_type` order by `id`");
							while($row_ledger_type=mysql_fetch_array($result_ledger_type))
							{
								?>
                                <tr>
                                <td colspan="5" style="background-color:#FFFFCC;">
                                <?php echo $row_ledger_type['name']; ?>
                                </td>
                                </tr>
                                <?php
								
                                    $result_ledger_master=mysql_query("select * from `ledger_master` where `ledger_type_id`='".$row_ledger_type['id']."' order by id");	
                                    while($row_ledger_master=mysql_fetch_array($result_ledger_master))
                                    {
										
										
										$result_ledger=mysql_query("select * from `ledger` where `ledger_master_id`='".$row_ledger_master['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");
										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";
										
										while ($row_ledger=mysql_fetch_array($result_ledger)) {
										$ntblnce=$row_ledger['debit']-$row_ledger['credit']+$ntblnce;
										}
										$opening_bal=$ntblnce;
										abs($opening_bal);
										if($opening_bal>0)
										$extend_opening=" DR";
										else
										$extend_opening=" CR";
										
										$cr=0;
										$db=0;
										$ntblnce=$opening_bal;	
									$result=mysql_query("select * From `ledger` where  `ledger_master_id`='".$row_ledger_master['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");		
										while($row=mysql_fetch_array($result))
											{ 
												$cr+=$row['credit'];
												$db+=$row['debit'];
												$all_credit+=$row['credit'];
												$all_debit+=$row['debit'];
												$ntblnce=$row['debit']-$row['credit']+$ntblnce;
											}
											$all_ntblnce+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if(($cr>0)||($db>0)||($opening_bal>0)||($opening_bal<0))
											{
											?>
											<tr>
											<td><?php echo $row_ledger_master['name']; ?></td>
											<td><?php echo abs($opening_bal).$extend_opening; ?></td>
											<td><?php echo $db; ?></td>
											<td><?php echo $cr; ?></td>
											 <td><?php echo abs($ntblnce).$extend; ?></td>
											</tr>
											<?php	
											}
                                    }
							}
							?>
                            <tr>
                            <th colspan="2">Total:</th>
                            <th><?php echo round($all_debit); ?></th>
                            <th><?php echo round($all_credit); ?></th>
                            <th><?php echo round($all_ntblnce); ?></th>
                            </tr>
                        	</table>
                    <?php
							
					
				}
				?>
                </div>
                </div>
                
          
        
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