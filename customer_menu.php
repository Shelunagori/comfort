<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");                   
require_once("myscript.php");
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
     <?php temp(); ?>
    	<?php
		if(isset($_POST['customer_edit']))
		{
							if(isset($_GET['cust_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Customer Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['cust_del']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Customer Block</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i>Customer Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                       	<th>Sl.</th>
                       	<th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Opening Bal.</th>
                        <th>Closing Bal</th>
                         <?php
							if(isset($_GET['cust_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['cust_del']))
							{
								?>
                                 <th>Delete</th>
                                 <?php
							}
							else 
							{
								?>
                                 <th>Edit</th>
                                 <?php
							}
							
							?>
                        </tr>
                    </thead>
                   	<tbody>
                    <?php
				$q1="";	$q2="";	$q3="";	
				if(!empty($_POST['name']))
				{
					$name=$_POST['name'];
					$q1="name='".$name."'";
				}
				if(!empty($_POST['mobile_no']))
				{
					$mobile_no=$_POST['mobile_no'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_no."'";
					else 
						$q2=" AND mobile_no='".$mobile_no."'";
				}
				if(!empty($_POST['email_id']))
				{
					$email_id=$_POST['email_id'];
					if($q1=="" && $q2=="")
						$q3=" email_id='".$email_id."'";
					else 
						$q3=" AND email_id='".$email_id."'";
				}
                if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from customer_reg";
                else    
					$qry="select * from customer_reg where ";
                        $sql=$qry.$q1.$q2.$q3;
                        $result= @mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$address=$row['address'];
							$mobile_number=$row['mobile_no'];
							$email_id=$row['email_id'];
                            $opening_balance=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
					?>
                      		<tr id="<?php echo $i; ?>">
                            <td><?php echo $i;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $address;?></td>
                            <td><?php echo $mobile_number;?></td>
                            <td><?php echo $email_id;?></td>
                            <td><?php echo $opening_balance;?></td>
                            <td><?php echo $closing_bal;?></td>
                         <?php
							if(isset($_GET['cust_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?customer=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['cust_del']))
							{
								?>
                                    
                                      <td><a class="btn mini red" title="Permanently Delete"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
                                    <i class="icon-trash"></i></a> 
                                    
                            <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 id="myModalLabel1" style="text-align: left ! important;"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $name; ?></b></span></h4>
                            </div>
                            <!--  <div class="modal-body">
                            </div>-->
                            <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                            <button type="button"  onClick="delete_cust(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_customer.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
                                </td>
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
                    </div>
                    </div>
                    </div>
               <?php
		}
		else if(isset($_GET['mode']))
		{
			if($_GET['mode']=='edit')
			{
				?>
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Customer Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="customer_menu.php?cust_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td><input type="text" name="name" id="customer_fetch" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Email Id:</td>
                        <td><input type="text" class="m-wrap medium" id="email_id" name="email_id" /></td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                 <?php
			}
			else if($_GET['mode']=='del')
			{
				?>
                		<div class="portlet box red" >
                        <div class="portlet-title">
                        <h4><i class="icon-trash"></i>Customer Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="customer_menu.php?cust_del=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td><input type="text" name="name" id="customer_fetch" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Email Id:</td>
                        <td><input type="text" class="m-wrap medium" name="email_id" /></td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
			else if($_GET['mode']=='view')
			{
				?>
                		<div class="portlet box blue" >
                        <div class="portlet-title">
                        <h4><i class="icon-search"></i>Customer View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="customer_menu.php?cust_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Customer Name:</td>
                        <td><input type="text" name="name" id="customer_fetch" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Customer Email Id:</td>
                        <td><input type="text" class="m-wrap medium" name="email_id" /></td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="customer_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                <?php
			}
		}
		else
		{
		?>
        <form  name="form_name" action="Handler.php" method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Customer Add</h4>
        </div>
        <div class="portlet-body form">
         <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
        <td> Customer Name:</td>
        <td><input type="text" name="name" REQUIRED id="customer_fetch" class="m-wrap medium"></td>
        <td>Contact Person Name:</td>
        <td><input type="text" class="m-wrap medium" name="Contact_person" /></td>
        </tr>
        
        <tr>
        <td> Office No.:</td>
        <td><input type="text" class="m-wrap medium" name="office_no" /> </td>
        <td> Residence No. : </td>
        <td><input type="text" class="m-wrap medium" name="Residence_no" /> </td>
        </tr>
        
        <tr>
        <td> Mobile No. : </td>
        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /> </td>
        <td> Customer Email Id : </td>
        <td><input type="text" class="m-wrap medium" name="email_id" /> </td>
        </tr>
      
		<tr>
        <td> Customer Fax No. : </td>
        <td><input type="text" class="m-wrap medium" name="fax_no" /> </td>
        <td> Customer Opening Balance: </td>
        <td><input type="text" class="m-wrap medium" name="opening_bal" /> </td>
        </tr>
        
        <tr>
        <td> Customer Closing Balance: </td>
        <td><input type="text" class="m-wrap medium" name="closing_bal" /> </td>
		<td> Service Tax Reg Number: </td><td><input type="text" class="m-wrap medium" name="srvctaxregno" /> </td>
        </tr>
        
        <tr>
        <td> Credit Limit: </td>
        <td><input type="text" name="creditlimit"   class="m-wrap medium"/> </td>
        <td> Service Tax Applicability : </td>
        <td><select type="text" name="servicetax_status" required  class="m-wrap medium">
        	<option value="">---select service tax status---</option>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        	</select></td>
        </tr>
        
        <tr>
	    <td> Pan Number: </td>
        <td><input type="text" name="panno" class="m-wrap medium" /> </td>
        <td valign="middle">Customer Address:</td>
        <td><textarea rows="2" style="resize:none;" class="m-wrap medium" name="address"></textarea></td>
     	</tr>
        
        <tr>
        <td>Copy Tariff Rate From</td>
        <td colspan="3">
        <select type="text" name="cop_custtariff"  id="cop_custtariff" class="m-wrap medium">
        <option value="">---select cust. tariff---</option>
        <?php
        $result=mysql_query("select distinct `id`,`name` from `customer_reg`");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select></td>
        </tr>
        
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="customer_reg"/><i class="icon-ok"></i> Submit</button>
        </div>
        </div>
        </div> 
        </form>
        <?php	
		}
		?>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
<div class="footer">
<?php footer();?>
</div>
<?php js(); ?> 
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>