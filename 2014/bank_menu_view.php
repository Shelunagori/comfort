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
<a href="bank_menu.php" class="btn blue"><i class="icon-ok"></i> Add</a>
<a href="bank_menu_view.php" class="btn red"><i class="icon-bar-chart"></i> View</a>
</div> -->
<br />
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-shopping-cart"></i>Bank</h4>
                    </div>
                    <div class="portlet-body form">
                    <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px 0 !important">
                     	<table width="100%"  class="table table-bordered table-hover" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Code</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    	<tbody>
<?php 
                        $qry="select * from bank_reg";
                        $data_base_object = new DataBaseConnect();
                        $result= $data_base_object->execute_query_return($qry);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$name=$row['name'];
							$branch=$row['branch'];
							$accno=$row['accno'];
							$code=$row['code'];
                     ?>
                            <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $branch;?></td>
                            <td><?php echo $accno;?></td>
                            <td><?php echo $code;?></td>
                           	<td><a class="btn mini red"  role="button"  href="delete.php?delete_bank=t&id=<?php echo $idd;?>" target="_blank" style="text-decoration:none;">
    							<i class="icon-trash"></i></a></td></tr> 	
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