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
		if(isset($_POST['supplier_edit']))
		{
							if(isset($_GET['supplier_view']))
							{
								?>  
                                    <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-search"></i> Supplier Search</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else if(isset($_GET['supplier_delete']))
							{
                                    ?>
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-trash"></i> <i class="icon-ban-circle"></i> Supplier Delete</h4>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php
							}
							else
							{
								?>
                                    <div class="portlet box yellow" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-edit"></i>Supplier Update</h4>
                                    </div>
                                    <div class="portlet-body form">
                                <?php
							}
							?>
					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
					<table width="100%" class="table table-bordered table-hover table-condensed flip-content" id="sample_1" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Supplier Type</th>
                        <th>Email</th>
                        <th>Opening Bal.</th>
                        <th>Closing Bal</th>
                         <?php
							if(isset($_GET['supplier_view']))
							{
								?>
                                 <th>View Details</th>
                                 <?php
							}
							else if(isset($_GET['supplier_delete']))
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
					$mobile_number=$_POST['mobile_no'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_number."'";
					else 
						$q2=" AND mobile_no='".$mobile_number."'";
				}
				if(!empty($_POST['supplier_type_id']))
				{
					$supplier_type_id=$_POST['supplier_type_id'];
					if($q1=="" && $q2=="")
						$q3=" supplier_type_id='".$supplier_type_id."'";
					else 
						$q3=" AND supplier_type_id='".$supplier_type_id."'";
				}
				 if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from supplier_reg";
                else    
					$qry="select * from supplier_reg where ";
                        $sql=$qry.$q1.$q2.$q3;
                        $result=@mysql_query($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$address=$row['address'];
							$mobile_number=$row['mobile_no'];
							$supplier_type_id=$row['supplier_type_id'];
							$type_name=supplier_type_name($supplier_type_id);
							$email_id=$row['email_id'];
                            $opening_balance=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
                       ?>
                            <tr id="<?php echo $i; ?>">
                            <td><?php echo $name;?></td>
                            <td><?php echo $address;?></td>
                            <td><?php echo $mobile_number;?></td>
                            <td><?php echo $type_name;?></td>
                            <td><?php echo $email_id;?></td>
                            <td><?php echo $opening_balance;?></td>
                            <td><?php echo $closing_bal;?></td>
                         <?php
							if(isset($_GET['supplier_view']))
							{
								?>
                                <td>
                                <a class="btn mini blue"  role="button"  href="view.php?supplier=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                                </td>
                                 <?php
							}
							else if(isset($_GET['supplier_delete']))
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
                            <button type="button"  onClick="delete_supplier(<?php echo $idd; ?>,<?php echo $i; ?>);" id="refresh"    data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                            </div>
                            </div>        
                                    
                            </td>
                                 </td>  
                                 <?php
							}
							else 
							{
								?>
                                 <td><a class="btn mini red"  role="button"  href="update_supplier.php?id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;"><i class="icon-edit"></i></a>
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
                        <h4><i class="icon-edit"></i>Supplier Edit</h4>
                        </div>
                        <div class="portlet-body form">
                        <form action="supplier_menu.php?supplier_edit=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Supplier Name:</td>
                        <td><input type="text" name="name" id="supplier_id" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Type:</td>
                        <td>
                        <select name="supplier_type_id"  class="m-wrap medium">
                        <option value="">---Select---</option>	
                        <?php 
                        $result=@mysql_query("select * from supplier_type");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="supplier_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-trash"></i>Supplier Delete</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="supplier_menu.php?supplier_delete=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Supplier Name:</td>
                        <td><input type="text" name="name" id="supplier_id" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Type:</td>
                        <td>
                        <select name="supplier_type_id"  class="m-wrap medium">
                        <option value="">---Select---</option>	
                        <?php 
                        $result=@mysql_query("select * from supplier_type");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="supplier_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
                        <h4><i class="icon-search"></i>Supplier View</h4>
                        </div>
                        <div class="portlet-body form">
	                    <form action="supplier_menu.php?supplier_view=true" name="form_name" autocomplete="off" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                        <td>Supplier Name:</td>
                        <td><input type="text" name="name" id="supplier_id" class="m-wrap medium"></td>
                        <td>Mobile No.:</td>
                        <td><input type="text" class="m-wrap medium" id="mobileno" name="mobile_no" /></td>
                        </tr>
                        <tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td>Supplier Type:</td>
                        <td>
                        <select name="supplier_type_id"  class="m-wrap medium">
                        <option value="">---Select---</option>	
                        <?php 
                        $result=@mysql_query("select * from supplier_type");
                        while($row=mysql_fetch_array($result))
                        {
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                        }
                        ?>
                        </select>
        				</td>
                        </tr>
                       	<tr><td colspan="4">&nbsp;</td></tr>
                        <tr>
                        <td colspan="4" style="text-align:center;"><button type="submit" title="Please fill atleast one info. to see result" class="btn green" name="supplier_edit"><b>Proceed <i class="icon-circle-arrow-right"></i></b></button></td>
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
        <h4><i class="icon-plus"></i>Supplier Add</h4>
        </div>
        <div class="portlet-body form">
        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
       	<tr>
       	<td>Supplier Type:</td>
        <td>
        <select name="supplier_type_id"  onchange="fillMe(this.value)" class="m-wrap medium">
        <option value="">---select---</option>	
        <?php 
        $result=@mysql_query("select * from supplier_type");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
		</td>
        <td> Supplier Category:</td>
        <td id="will_be">
        </td>
        
        <tr>
        <td> Supplier Name:</td>
        <td><input type="text" name="name" REQUIRED id="supplier_id" class="m-wrap medium"/></td>
        <td> Address. : </td>
        <td><textarea rows="2"  name="address" class="m-wrap medium" style="resize:none;"> </textarea></td>
        </tr>
        
        <tr>
        <td> Contact Name. : </td>
        <td><input type="text" name="contact_name" class="m-wrap medium" /></td>
		<td> Office Number: </td>
        <td><input type="text" name="office_no" class="m-wrap medium"/></td>
        </tr>
        
        <tr>
        <td> Residence Number : </td>
        <td><input type="text" name="residence_no" class="m-wrap medium" /> </td>
		<td> Mobile Number: </td>
        <td><input type="text" name="mobile_no" id="mobileno" class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> Email Id: </td>
        <td><input type="text" name="email_id"  class="m-wrap medium"/> </td>
		<td> Fax Number: </td>
        <td><input type="text" name="fax_no" class="m-wrap medium" /> </td>
        </tr>
        
        <tr>
        <td> Opening Balance: </td>
        <td><input type="text" name="opening_bal"  class="m-wrap medium"/> </td>
		<td> Closing Balance: </td>
        <td><input type="text" name="closing_bal"  class="m-wrap medium"/> </td>
        </tr>
         
        <tr>
        <td> Due Days: </td>
        <td><input type="text" name="due_days"  class="m-wrap medium"/> </td>
		<td> Service Tax Number: </td><td> <input type="text" name="servicetax_no" class="m-wrap medium" /></td>
        </tr>        
        
       <tr>
       <td> Pan Number: </td>
       <td> <input type="text" name="pan_no" class="m-wrap medium" /></td>
		<td>Bank Account Number: </td><td> <input type="text" name="account_no" class="m-wrap medium"/></td>
        </tr>        
        
        <tr>
        <td> Service Tax Applicability : </td>
        <td><select type="text" name="servicetax_status"  class="m-wrap medium">
        <option value="">---select service tax status---</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
        </select></td>
        <td>Copy Tariff Rate From</td>
        <td>
        <select type="text" name="cop_supptariff"  id="cop_custtariff" class="m-wrap medium">
        <option value="">---select supp. tariff---</option>
        <?php
        $result=mysql_query("select distinct `id`,`name` from `supplier_reg`");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select></td>
        </tr>
        
        </table>
        <div class="form-actions">
        <button type="submit"  style="margin-left:25%" class="btn green" name="supplier_reg"/><i class="icon-ok"></i> Submit</button>
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