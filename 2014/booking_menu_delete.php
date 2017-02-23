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
<a href="booking_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="booking_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="booking_menu_delete.php" class="btn red"><i class="icon-trash"></i> Delete</a>
<a href="booking_menu_search.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-trash"></i>Delete</h4>
                    </div>
                    <div class="portlet-body form">
      				   <table width="100%">
						 <tr><td> Booking Person Name:</td><td>
                            <select name="booked_by"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct booked_by from booking");
									while($row= mysql_fetch_array($result))
									{
									 $booked_by = $row['booked_by'];
								   echo '<option value="'.$booked_by.'">'.$booked_by.'</option>';
									}
        				      ?>

     </select></td></tr>
						 <tr><td> Customer Name : </td><td>
                          <select name="customer_reg_name"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from customer_reg");
									while($row= mysql_fetch_array($result))
									{
									    $name = $row['name'];
								   echo '<option value="'.$row['id'].'">'.$name.'</option>';
									}
        				      ?>

     </select>  <button type="submit" style="margin-left:1%; margin-top:-4%"  class="btn green" name="booking_edit" />Go <i class="icon-circle-arrow-right"></i></button></td></tr>
						 <tr><td></td><td>&nbsp;</td></tr>
						 </table>  <br>

                         <?php
						 if(isset($_POST['booking_edit']))
				{
					?> 
					  <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%"  class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse;">
                    <thead>                        <tr>
                        <th scope="col">Booking Person Name</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Booked From</th>
                        <th scope="col">Booked To</th>
                        <th scope="col">Travel Place</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php           
				$q1="";	$q2="";	$q3="";$q4="";$q5="";$q6="";$q7="";
				$three_blank=false;	
					
				if(!empty($_POST['booked_by']))
				{
					$booked_by=$_POST['booked_by'];
					$q1=" booked_by='".$booked_by."'";
				}
				if(!empty($_POST['customer_reg_name']))
				{
					$customer_reg_name=$_POST['customer_reg_name'];
					if($q1=="" && $q2=="")
						$q3=" customer_reg_name='".$customer_reg_name."'";
					else 
					$q3=" AND customer_reg_name='".$customer_reg_name."'";
				}
				if(!empty($_POST['flight_no']))
				{
					$flight_no=$_POST['flight_no'];
					if($q1=="" && $q2=="" && $q3=="")
						$q4=" flight_no='".$flight_no."'";
					else 
					$q4=" AND flight_no='".$flight_no."'";
				}
				
				if($q1=="" && $q2=="" && $q3=="" && $q4=="")
                {
                	$qry="select * from booking";
                	$three_blank=true;
                }
                else
                {       
					$qry = "select * from booking where ";
                }

				        $sql=$qry.$q1.$q2.$q3.$q4;
				
				if(!empty($_POST['travel_from']))
				{
					$q4=DateExact($_POST['travel_from']);
				}
				if(!empty($_POST['travel_to']))
				{
					$q5=DateExact($_POST['travel_to']);
				}

				if($q4=="" && $q5=="")
				{
					
				}
				else if($q4!="" && $q5=="")
				{
					if(strpos($sql, "where")==false)
					{
						$sql="select * from booking where travel_from>= '".$q4."'";
					}
					
				}
				else if($q4=="" && $q5!="")
				{
					if(strpos($sql, "where")==false)
					{
						$sql="select * from booking where travel_to>='".$q5."'";
					}
				}
				else 
				{
					if(strpos($sql, "where")==false)
					{
						$sql="select * from booking where (travel_from>= '".$q4."' and travel_from>='".$q5."')";
						$sql.=" or (travel_from<= '".$q4."' and travel_to>='".$q5."')";
						$sql.= " or (travel_to>= '".$q4."' and travel_to<='".$q5."')";
					}
				}
                        $data_base_object = new DataBaseConnect();
                        $result= $data_base_object->execute_query_return($sql);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$booked_by=$row['booked_by'];
							$customer_reg_name=$row['customer_reg_name'];
							$customer_all=mysql_query("select * from `customer_reg` where `id` = '$customer_reg_name'  ");
							$ftc_customer=mysql_fetch_array($customer_all);
							$customer_name = $ftc_customer['name'];
							$travel_from=$row['travel_from'];
							$travel_to=$row['travel_to'];
                            $service_id=$row['service_id'];
							$rez_book="select * from `service` where `service_id` = '$service_id'";
							$data_base_object_service = new DataBaseConnect();
							$result_book= $data_base_object_service->execute_query_return($rez_book);
							$row_book=mysql_fetch_array($result_book);
							$service_name = $row_book['name'];
                       ?>
                            <tr>
                            <td><?php echo $booked_by;?></td>
                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $travel_from;?></td>
                            <td><?php echo $travel_to;?></td>
                            <td><?php echo $service_name;?></td>
                             <td><a class="btn mini red"  role="button"  href="delete.php?delete_booking=true&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-trash"></i></a>
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