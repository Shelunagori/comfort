<?php
require_once("function.php");
require_once ("config.php");
require_once("auth.php");
date_default_timezone_set('Asia/Calcutta');	
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
return($date_new);}

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
		
        				
                        
                <div class="portlet box yellow">
                <div class="portlet-title">
                <h4><i class="icon-money"></i>Trial Balance</h4>
                </div>
                <div class="portlet-body form">
                <form  name="form_name" class="form-horizontal"  method="post">
                      
                <div class="control-group">
                <label class="control-label">Date From</label>
                <div class="controls">
                <input type="text" name="date_from" id="dp1"   class="span4 m-wrap date-picker" />
                </div>
                </div>    
                
                <div class="control-group">
                <label class="control-label">Date To</label>
                <div class="controls">
                <input type="text" name="date_to" id="dp2" class="span4 m-wrap date-picker" />
                <button type="submit"   class="btn green" name="trial_gen"/><i class="icon-signal"></i> Generate</button>
                <button type="reset"   class="btn yellow" name="done"/><i class="icon-retweet"></i> Reset</button>
                </div>
                </div>    
                
                </form>

                <?php
				if(isset($_POST['trial_gen']))
                {
					?>
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
							$result_ledger_type=mysql_query("select distinct `ledger_type` from `ledger` where `ledger_type`!='--Select--' && `ledger_type`!='0' order by `ledger_type`");
							while($row_ledger_type=@mysql_fetch_array($result_ledger_type))
							{
								?>
                                <tr>
                                <td colspan="5" style="background-color:#FFFFCC;">
                                <?php echo $row_ledger_type['ledger_type']; ?>
                                </td>
                                </tr>
                                <?php
                                    $result_ledger_master=mysql_query("select distinct `name` from `ledger` where `ledger_type`='".$row_ledger_type['ledger_type']."' order by `name`");	
                                    while($row_ledger_master=@mysql_fetch_array($result_ledger_master))
                                    {
										
										$result_ledger=mysql_query("select * from `ledger` where `name`='".$row_ledger_master['name']."' and  `date` < '".datefordb($_POST['date_from'])."'");
										
										$ntblnce=0;
										$opening_bal=0;
										$extend="";
										
										while ($row_ledger=@mysql_fetch_array($result_ledger)) {
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
										
									$result=mysql_query("select `credit`,`debit` from `ledger` where  `name`='".$row_ledger_master['name']."' and  `date` between '".datefordb($_POST['date_from'])."' AND '".datefordb($_POST['date_to'])."' ");		
										while($row=@mysql_fetch_array($result))
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
    <?php datepicker1(); ?>
    <?php
	function datepicker1()
{?>
   <script>
  
        $(function(){
            window.prettyPrint && prettyPrint();
            $('#dp1').datepicker({
                format: 'dd-mm-yyyy'
            });
			$('#dp1').on('changeDate', function(ev){
			$(this).datepicker('hide');
			});
			$('#dp2').datepicker({
                format: 'dd-mm-yyyy'
            });
			$('#dp2').on('changeDate', function(ev){
			$(this).datepicker('hide');
			});
        });
    </script>

<?php
} 
?>
<!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>