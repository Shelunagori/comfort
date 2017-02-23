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
    
                <div class="portlet box red">
                <div class="portlet-title">
                <h4><i class="icon-envelope-alt"></i> Balance Sheet</h4>
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
                <button type="submit"   class="btn green" name="bal_gen"/><i class="icon-signal"></i> Generate</button>
                <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
                </div>
                </div>    
                </form>
                <?php
				if(isset($_POST['bal_gen']))
                {
					?>
                    <form method="post" action="docburner.php">
                    <button  type="submit" style="float:right;" class="btn red diplaynone tooltips" title="Download in Excel"  data-placement="bottom"><i class="icon-download-alt"></i> Download in Excel</button>
                    <input type="hidden" value="<?php echo $_POST['date_from']; ?>" name="date_from">
                    <input type="hidden" value="<?php echo $_POST['date_to']; ?>" name="date_to">
                    <input type="hidden" value="balancesheet" name="excel_for">
                    </form>
                    <br/>
                    <br/>
                    
                      <table width="100%" class="table table-condensed">
                      
                      <tr>
                      <th colspan="2" style="text-align:center;">BALANCE SHEET AS ON <?php  echo  dateforview($_POST['date_to']); ?></th>
                      </tr>
                    
                        <tr>
                        <td width="50%" style="border-right:#DDDDDD 2px solid;">
                        <table width="100%">
                        <tr>
                        <th>Liabities</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <tr>
                        <th colspan="3">Capital Account</th>
                        </tr>
                       <?php 

					  $res_income=mysql_query("select * from `ledger_master` where `group_belongs_to`='P&L-Income'");
						while($row_income=mysql_fetch_array($res_income))
						{
							$temp=0;
							$res_income_credit=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_income['id']."'");
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
							$result_debit=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_left['id']."'");
							while($row_debit=mysql_fetch_array($result_debit))
							{
								$flag_expense=$row_debit['debit']-$row_debit['credit']+$flag_expense;
							}
								$all_exp+=$flag_expense;
						}
   					   $profit=$all_cr-$all_exp;
					   $repeat=0;
					   $result_asset1=mysql_query("select * from `ledger_master` where `group_belongs_to`='B/S-Liabities' ORDER BY `ledger_type_id`");
						while($row_asset1=mysql_fetch_array($result_asset1))
						{$repeat++;
										
										$result_ledger=mysql_query("select `debit`,`credit` from `ledger` where `ledger_master_id`='".$row_asset1['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";										
										while ($row_ledger=mysql_fetch_array($result_ledger)) {
										$ntblnce=$row_ledger['debit']-$row_ledger['credit']+$ntblnce;
										}										
										
									$inner=mysql_query("select  `ledger_type_id` from `ledger_master` where `id`='".$row_asset1['id']."' ");
									$row_inner = mysql_fetch_array($inner);
									$ledger_type_id = $row_inner['ledger_type_id'];
									if($ledger_type_id!=$ledger_type_id_test)
									{
									$ledger_type_id_test=$ledger_type_id;
									?>
									<tr>
									<td colspan="3" style="background:#F2DEDE;"><?php echo fetchledgertype_name($ledger_type_id); ?></td>
									</tr>
									<?php
									}
									
									$result=mysql_query("select `credit`,`debit` From `ledger` where  `ledger_master_id`='".$row_asset1['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");		
												
											while($row=mysql_fetch_array($result))
											{ 
												$cr+=$row['credit'];
												$db+=$row['debit'];
												$all_credit+=$row['credit'];
												$all_debit+=$row['debit'];
												$ntblnce=$row['debit']-$row['credit']+$ntblnce;
											}				
											$all_lib+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if($all_lib>0)
											$extend_1=" DR";
											else
											$extend_1=" CR";
							if(abs($ntblnce)!=0)	
							{			
							?>
                        	<tr>
                            <td><?php echo $row_asset1['name']; ?></td>
                            <td><?php echo abs($ntblnce).$extend; ?></td>
                            <td>&nbsp;</td>
                            </tr>
                      <?php
							}
						}
						?>
                        <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo abs($all_lib).$extend_1; ?></th>
                        </tr>
                         <tr>
                        <th colspan="2">Opening Capital</th>
                        <th>0</th>
                        </tr>
                         <tr>
                        <th colspan="2">Profit</th>
                        <th><?php echo $profit; ?></th>
                        </tr>
                        </table>
                        </td>
                       
                        <td width="50%">
                        <table width="100%">
                        <tr>
                        <th>Assets</th>
                        <th colspan="2">Amount</th>
                        </tr>
                        <?php 
						$result_right=mysql_query("select * from `ledger_master` where `group_belongs_to`='B/S-Assets'  ORDER BY `ledger_type_id`");
						while($row_right=mysql_fetch_array($result_right))
						{
										
										
										$result_ledger_r=mysql_query("select `credit`,`debit` from `ledger` where `ledger_master_id`='".$row_right['id']."' and  `date` < '".datefordb($_POST['date_from'])."'");										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";										
										while ($row_ledger_r=mysql_fetch_array($result_ledger_r)) {
										$ntblnce=$row_ledger_r['debit']-$row_ledger_r['credit']+$ntblnce;
										}	
										
										$inner=mysql_query("select  `ledger_type_id` from `ledger_master` where `id`='".$row_right['id']."' ");
										$row_inner = mysql_fetch_array($inner);
										$ledger_type_id = $row_inner['ledger_type_id'];
										if($ledger_type_id!=$ledger_type_id_test)
										{
											$ledger_type_id_test=$ledger_type_id;
											?>
                                        <tr>
                                        <td colspan="3" style="background:#F2DEDE;"><?php echo fetchledgertype_name($ledger_type_id); ?></td>
                                        </tr>
                                        <?php
										}
										
																			
									$result_a=mysql_query("select `credit`,`debit` From `ledger` where  `ledger_master_id`='".$row_right['id']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");													
											while($row_a=mysql_fetch_array($result_a))
											{ 
												$cr+=$row_a['credit'];
												$db+=$row_a['debit'];
												$all_credit+=$row_a['credit'];
												$all_debit+=$row_a['debit'];
												$ntblnce=$row_a['debit']-$row_a['credit']+$ntblnce;
											}				
											$all_lib_+=$ntblnce;
											abs($ntblnce);
											if($ntblnce>0)
											$extend=" DR";
											else
											$extend=" CR";
											if($all_lib_>0)
											$extend_1=" DR";
											else
											$extend_1=" CR";
							if(abs($ntblnce)!=0)
							{				
							?>
                        	<tr>
                            <td><?php echo $row_right['name']; ?></td>
                            <td><?php echo abs($ntblnce).$extend; ?></td>
                            <td>&nbsp;</td>
                            </tr>
                       		<?php
							}
						}
						?>
                        <tr>
                        <th colspan="2">Total</th>
                        <th><?php echo $all_lib_.$extend_1; ?></th>
                        </tr>
                       	</table>
                        </td>
                        </tr>
                        <tr>
                        <th style="text-align:right;"><?php echo $all_lib+$profit+($all_lib_-($profit+$all_lib)); ?></th>
                        <th style="text-align:right;"><?php echo  $all_lib_; ?></th>
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