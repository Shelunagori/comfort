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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
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
<!--<div>                     
<a href="customer_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="customer_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="customer_menu_delete.php" class="btn blue"><i class="icon-trash"></i> Delete</a>
<a href="customer_menu_serch.php" class="btn red"><i class="icon-search"></i> Search</a>
</div>--> 
<br />
 <div class="portlet box yellow">
                     <div class="portlet-title">
                        <h4><i class="icon-search"></i>Search</h4>
                     </div>
                     <div class="portlet-body form">
                       <table width="100%">
						 <tr><td> Customer Name:</td><td>
                         <select name="customer_name"  class="span5 chosen" tabindex="1" style="width:221px !important" >
    							 <option value="" >--- select name ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct name from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$name.'">'.$name.'</option>';
									}
        				      ?>

     </select></td></tr>
						 <tr><td> Mobile No. : </td><td>
                          <select name="customer_mobile_number"  class="span5 chosen" tabindex="1" style="width:221px !important" >
    							 <option value="" >--- select mobile ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct mobile_no from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $mobile_no = $row['mobile_no'];
								   echo '<option value="'.$mobile_no.'">'.$mobile_no.'</option>';
									}
        				      ?>

     </select>
                          </td></tr>
						<tr><td> Customer Email Id : </td><td>
                         <select name="customer_emailid"  class="span5 chosen" tabindex="1" style="width:221px !important" >
    							 <option value="" >--- select email ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct email_id from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									 $email_id = $row['email_id'];
								   echo '<option value="'.$email_id.'">'.$email_id.'</option>';
									}
        				      ?>

     </select> <button type="submit" style="margin-left:1%; margin-top:-4% !important"  class="btn green" name="customer_edit" />Go <i class="icon-circle-arrow-right"></i></button>         
                         </td></tr>
						
                        <tr><td ></td>
                        <td></td></tr>
					</table> 
                      <?php
				if(isset($_POST['customer_edit']))
				{
					?> 
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%" class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse; ">
                    <thead>
                        <tr>
                        <th width="5%">S.No</th>
                        <th width="20%">Name</th>
                        <th width="25%">Address</th>
                        <th width="5%">Mobile</th>
                        <th width="20%">Email</th>
                        <th width="5%">Opening Bal.</th>
                        <th width="5%">Closing Bal</th>
                        <th width="5%">Blocked</th>
                        <th width="10%">Search</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php           
				$q1="";	$q2="";	$q3="";	
				if(!empty($_POST['customer_name']))
				{
					$name=$_POST['customer_name'];
					$q1="name='".$name."'";
				
				}
				if(!empty($_POST['customer_mobile_number']))
				{
					$mobile_number=$_POST['customer_mobile_number'];
					if($q1=="")
						$q2=" mobile_no='".$mobile_number."'";
					else 
						$q2=" AND mobile_no='".$mobile_number."'";
				}
				if(!empty($_POST['customer_emailid']))
				{
					$email_id=$_POST['customer_emailid'];
					if($q1=="" && $q2=="")
						$q3=" email_id='".$email_id."'";
					else 
						$q3=" AND email_id='".$email_id."'";
				}
                if($q1=="" && $q2=="" && $q3=="")
                	$qry ="select * from customer_reg";
                else    
					$qry="select * from customer_reg where ";
                        $data_base_object = new DataBaseConnect();
                        $sql=$qry.$q1.$q2.$q3;
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
							$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$address=$row['address'];
							$mobile_number=$row['mobile_no'];
							$email_id=$row['email_id'];
                            $opening_balance=$row['opening_bal'];
                            $closing_bal=$row['closing_bal'];
                            $block_status=$row['block_status'];
                       ?>
						
                            <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $address;?></td>
                            <td><?php echo $mobile_number;?></td>
                            <td><?php echo $email_id;?></td>
                            <td><?php echo $opening_balance;?></td>
                            <td><?php echo $closing_bal;?></td>
                             <td><?php echo $block_status;?></td>
                    	<td><a class="btn mini red"  role="button"  href="view.php?customer=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-search"></i></a>
                            </td>
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