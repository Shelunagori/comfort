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
<a href="employee_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="employee_menu_edit.php" class="btn blue"><i class="icon-edit"></i> Edit</a>
<a href="employee_menu_delete.php" class="btn red"><i class="icon-trash"></i> Delete</a>
<a href="employee_menu_serch.php" class="btn blue"><i class="icon-search"></i> Search</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-trash"></i>Delete</h4>
                    </div>
                    <div class="portlet-body form">
                     
                      <table width="100%">
						 <tr><td> Driver Name:</td>
                         <td>
                         <select name="name"  class="span5 chosen" tabindex="1" style="width:221px !important" >
    							 <option value="" >--- select name ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct name from driver_reg");
									while($row= mysql_fetch_array($result))
									{
									 $name = $row['name'];
								   echo '<option value="'.$name.'">'.$name.'</option>';
									}
        				      ?>

     </select></td>
     </tr>
						 <tr><td> Mobile No. : </td>
                         <td>
                          <select name="mobile_no"  class="span5 chosen" tabindex="1" style="width:221px !important" >
    							 <option value="" >--- select mobile ---</option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select distinct mobile_no from driver_reg");
									while($row= mysql_fetch_array($result))
									{
									 $mobile_no = $row['mobile_no'];
								   echo '<option value="'.$mobile_no.'">'.$mobile_no.'</option>';
									}
        				      ?>

     </select> <button type="submit" style="margin-left:1%; margin-top:-4% !important"  class="btn green" name="employee_edit" />Go <i class="icon-circle-arrow-right"></i></button>
                          </td>
                          </tr>
						                       
					</table> 
                 
                     <?php
				if(isset($_POST['employee_edit']))
				{
					?> 
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
					<table width="100%" class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse; ">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Present Address</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Date Joining</th>
                        <th scope="col">Licence Valid Till</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    	<tbody>
                    <?php           
				$q1="";	$q2="";	
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
				if($q1=="" && $q2=="")
                        $qry="select * from driver_reg";
                  else 
                      $qry="select * from driver_reg where ".$q1.$q2;
                        $data_base_object = new DataBaseConnect();
                    $result= $data_base_object->execute_query_return($qry);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
							$i++;
                        	$idd=$row['driver_id'];
							$name=$row['name'];
							$address=$row['present_add'];
							$mobile_number=$row['mobile_no'];
							$dob=$row['dob'];
							$date_joining=$row['date_joining'];
                            $licence_valid=$row['licence_valid'];
                       ?>
                            <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $mobile_number;?></td>
                            <td><?php echo $address;?></td>
                            <td><?php echo $dob;?></td>
                            <td><?php echo $date_joining;?></td>
                            <td><?php echo $licence_valid;?></td>
                           <td><a class="btn mini red"  role="button" data-toggle="modal"  href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
    							<i class="icon-trash"></i></a>
                                <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 id="myModalLabel1"><i class="icon-trash"></i>&nbsp;&nbsp;Delete <?php echo $name ?> Info</h4>
									</div>
									<div class="modal-body">
									<p>Are you sure ... ?</p>
									</div>
									<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                    <a class="btn red" href='delete.php?delete_driver=true&id=<?php echo $idd;?>'><i class="icon-trash">&nbsp;</i>Delete</a>
									</div>
									</div>
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