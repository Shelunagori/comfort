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
     <form  name="form_name" method="post">
      <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-table"></i>Pending Due List Report</h4>
                    </div>
                    <div class="portlet-body form">
                  <table width="100%">
		           <tr><td> Car Number</td>
                   <td><div class="control-group">
                                      <div class="controls">
					<label class="radio"><input name="RadioGroup" class="radio" type="radio" id="radio1" style="width:20px; height:15px;" value="invoice"  onchange="GetInvoiceNumbers(this.value)"  />Invoice</label>
						<label class="radio"><input name="RadioGroup" class="radio" type="radio" id="radio2" style="width:20px; height:15px;" value="dutyslip"  onchange="GetInvoiceNumbers(this.value)"/>Duty Slip</label>
                        </div>
                        </div></td>
                       </tr>
                       <tr>
                       <td>
                       Customer Name
                       </td>
                       <td><select name="customer_reg_name1"  class="chosen">
    							 <option value="">Customer Name</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									   echo '<option value="'.$row['id'].'" ">'.$row['name'].'</option>';
									}
        				      ?>

                               </select>
                       </td>
                       </tr>
              	<tr><td> Date From</td><td><input type="text" name="date_from" class="m-wrap medium" id="dp1"/></td></tr>
				<tr><td> Date To</td><td><input type="text" name="date_to"  class="m-wrap medium"  id="dp2"/><button type="submit" style="margin-left:1%;"  class="btn green" name="ledger_reg" />Go <i class="icon-circle-arrow-right"></i></button></td><td></tr>
                             </table>
                <br>
<br>

                <?php
                if(isset($_POST['ledger_reg']))
					{
						$tp=$_POST['RadioGroup'];
						$customer_reg_name1 = $_POST['customer_reg_name1'];
						?>
					<table width="100%" class="table table-bordered table-hover" id="sample_1"  style="border-collapse:collapse">
                    <thead>
                        <tr>
                        <th >Invoice Number</th>
                        <th >Customer Name</th>
                        <th >Date</th>
                        <th >Grand Total</th>                     
                        </tr>
                    </thead>
                    <tbody>
						<?php
					$q1="";	$q2="";	$q3=""; $q4="";	
				$q1=" status='no'";
				if((!empty($_POST['date_from'])) and (!empty($_POST['date_to'])))
				{
					$date_from=$_POST['date_from'];
					$date_to=$_POST['date_to'];
					if($tp=="invoice")
						{
						$q2=" AND date between '".DateExact($date_from)."' and '".DateExact($date_to)."'";
						}
					else
						{
						$q2=" AND current_date between '".DateExact($date_from)."' and '".DateExact($date_to)."'";
						}
					
				}
					if($tp=="invoice"  )
						{    
							if(!empty($customer_reg_name1))
				             {
					          $q4="AND duty_slip_customer_reg_name = '".$customer_reg_name1."'";
				             }  
						$q4="AND duty_slip_customer_reg_name = '".$customer_reg_name1."'";       
					$qry="select * from `invoice` where ";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q4." order by `invoice_id`";
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$invoice_id=$row['invoice_id'];
							$duty_slip_customer_reg_name=$row['duty_slip_customer_reg_name'];
							$qry_cust="select * from `customer_reg` where `id`='".$duty_slip_customer_reg_name."'";
							$data_base_object = new DataBaseConnect();
							$result_cust = $data_base_object->execute_query_return($qry_cust);
							$row_cust=mysql_fetch_array($result_cust);
							$name_cust=$row_cust['name'];
							$date=$row['date'];
							$grand_total=$row['grand_total'];
                       ?>
                            <tr>
                            <td><?php echo $invoice_id;?></td>
                            <td><?php echo $name_cust;?></td>
                            <td><?php echo $date;?></td>
                            <td><?php echo $grand_total;?></td>
                        <?php
                        }          
						?>
                          </tr>
                           
                            <?php
							  }
						}
						else
							{
								if(!empty($customer_reg_name1))
				             {
								
								$q4="AND customer_reg_name = '".$customer_reg_name1."'";
				             }  
							 
						$qry="select * from `duty_slip` where ";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q4." order by `dutyslip_id`";
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$dutyslip_id=$row['dutyslip_id'];
							$customer_reg_name=$row['customer_reg_name'];
							$qry_cust_duty="select * from `customer_reg` where `id`='$customer_reg_name'";
							$data_base_object_duty = new DataBaseConnect();
							$result_duty = $data_base_object_duty->execute_query_return($qry_cust_duty);
							$row_duty=mysql_fetch_array($result_duty);
							$customer_name=$row_duty['name'];
							$date=$row['current_date'];
							$grand_total=$row['rate'];
                       ?>
                            <tr>
                            <td><?php echo $dutyslip_id;?></td>
                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $date;?></td>
                            <td><?php echo $grand_total;?></td>
                        <?php
                        }
						?>
                           </tr>
                        <?php
                        }
							}
					?>
                    </tbody>
                    </table>   
				<?php
				 }	
				?>
   
  
   </div></div>
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