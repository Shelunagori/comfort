<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
if(isset($_GET['dell']))
{
	echo "<script language=\"javascript\">
		alert('Login Deleted SuccessFully .');
		window.location='view_right.php';
	</script>";
}
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
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-table"></i>View</h4>
                    </div>
                    <div class="portlet-body form">

	<table class="table table-bordered table-hover" >
									<thead>
										<tr>
											<th>S.No</th>
											<th><i class="icon-user"></i>&nbsp;User Name</th>
											<th><i class="icon-key"></i>&nbsp;Login-Id</th>
                                            <th><i class="icon-inbox"></i>&nbsp;Counter Name </th>
                                            <th><i class="icon-trash"></i>&nbsp;Delete </th>
										</tr>
									</thead>
                                 <!--   <div class="scroller" data-height="400px"> -->
                                        <?php
										$i=0;
										$qry = "select * from `login` where `status`='0'";
										$data_base_object = new DataBaseConnect();
										$result= $data_base_object->execute_query_return($qry);
										while ($row=mysql_fetch_array($result))
										{ 
										$i++;	
										$idd = $row['id'];
										$username= $row['username']; 
										$counter=$row['counter'];
										$login=$row['login_name'];													
										$fetch_counter = "select * from `counter` where `id` = '$counter'";
										$result_counter = $data_base_object->execute_query_return($fetch_counter);
										$fetch_array=mysql_fetch_array($result_counter);
										$counter_name = $fetch_array['counter_name'];
											?>	
                                        <tbody>
                                         <tr>								
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $username ?></td>
                                        <td><?php echo $login ?></td>
                                        <td><?php echo $counter_name ?></td>
                                       <th>
                                       <a class="btn mini red"  role="button"  data-toggle="modal" href="#myModal1<?php echo $i ?>" style="text-decoration:none;">
    							<i class="icon-trash"></i></a>
                                   <div style="display: none;" id="myModal1<?php echo $i ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 id="myModalLabel1"><i class="icon-trash"></i>&nbsp;&nbsp;Delete <b><?php echo $login ?></b> Info</h4>
									</div>
									<div class="modal-body">
									<p>Are you sure ... ?</p>
									</div>
									<div class="modal-footer">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                     <a class="btn red" href='delete.php?delete_login=true&id=<?php echo $idd;?>'><i class="icon-trash">&nbsp;</i>Delete</a></th>
                                        </tr>
                                        <?php
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
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>