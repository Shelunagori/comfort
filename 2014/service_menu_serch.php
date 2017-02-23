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
     <form method="post" name="form_name">
<!--<div>                     
<a href="service_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="service_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="service_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="service_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div>--> 
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-cogs"></i>Service Edit</h4>
                    </div>
                    <div class="portlet-body form">
                    <br />
                      <table width="100%">
						 <tr><td> Supplier Name:</td>
                         <td>
                         <select name="name_supplier"  class="chosen"  >
    							 <option value="" >--- select name ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct name_supplier from supplier_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name_supplier = $row['name_supplier'];
								   echo '<option value="'.$name_supplier.'">'.$name_supplier.'</option>';
									}
        				      ?>

     </select></td></tr>
						 <tr><td> Mobile No. : </td>
                         <td>
                          <select name="mobile_no"  class="chosen" >
    							 <option value="" >--- select mobile ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct mobile_no from supplier_reg");
									while($row= mysql_fetch_array($result))
									{
									 $mobile_no = $row['mobile_no'];
								   echo '<option value="'.$mobile_no.'">'.$mobile_no.'</option>';
									}
        				      ?>

     </select>
                          </td></tr>
						<tr><td> Supplier Type: </td>
                        <td>
                       <select name="supplier_master_name_id" class="chosen" >	
						<option value="">--- Select Type ---</option>
				<?php 
						$mydatabase = new DataBaseConnect();
						$result= $mydatabase->execute_query_return("select * from supplier_master");
						while($row=mysql_fetch_array($result))
						{
							echo '<option value="'.$row['id'].'">'.$row['type'].'</option>';
						}
						$mydatabase->close_connection();
				?>
				</select>
           <button type="submit" style="margin-left:1%; margin-top:-4% !important"  class="btn green" name="supplier_edit" />Go <i class="icon-circle-arrow-right"></i></button>         
                         </td></tr>
						
                        <tr><td ></td>
                        <td></td></tr>
					</table> 
                    
                     <?php
				if(isset($_POST['supplier_edit']))
				{
					?> 
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%"  class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse; ">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Supplier Type</th>
                        <th>Email</th>
                        <th>Opening Bal.</th>
                        <th>Closing Bal</th>
                        <th>Search</th>
                        </tr>
                    </thead>
                    	<tbody>
                    <?php           
				$q1="";	$q2="";	$q3="";	
				if(!empty($_POST['name_supplier']))
				{
					$name=$_POST['name_supplier'];
					$q1="name_supplier='".$name."'";
				}
				if(!empty($_POST['mobile_no']))
				{
					$mobile_number=$_POST['mobile_no'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_number."'";
					else 
						$q2=" AND mobile_no='".$mobile_number."'";
				}
				if(!empty($_POST['supplier_master_name_id']))
				{
					$supplier_master_id=$_POST['supplier_master_name_id'];
					if($q1=="" && $q2=="")
						$q3=" supplier_master_id='".$supplier_master_id."'";
					else 
						$q3=" AND supplier_master_id='".$supplier_master_id."'";
				}
				 if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from supplier_reg";
                else    
					$qry="select * from supplier_reg where ";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q3;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['supplier_id'];
							$name=$row['name_supplier'];
							$address=$row['address'];
							$mobile_number=$row['mobile_no'];
							$suuplier_type=$row['supplier_master_id'];
							$qry_supplier="select * from `supplier_master` where `id`='$suuplier_type'";
							$data_base_object = new DataBaseConnect();
							$result_supplier = $data_base_object->execute_query_return($qry_supplier);
							$row_supplier=mysql_fetch_array($result_supplier);
							$supplier_type=$row_supplier['type'];
							$email_id=$row['email_id'];
                            $opening_balance=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
                       ?>
						
                            <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $address;?></td>
                            <td><?php echo $mobile_number;?></td>
                            <td><?php echo $supplier_type;?></td>
                            <td><?php echo $email_id;?></td>
                            <td><?php echo $opening_balance;?></td>
                            <td><?php echo $closing_bal;?></td>
                            <td><a class="btn mini red"  role="button"   href="view_services.php?supplier=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    					<i class="icon-search"></i></a></td>
                        <?php }
						      }
						?>
                            </tr>
                         
                        <?php
                        
                        }
					?>
                       </tbody>
                    </table>
                    </div>    
                
                     
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