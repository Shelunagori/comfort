<?php 
require_once("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
require_once("auth.php");
session_start();
$id = $_SESSION['login_user'];
$s=0;
if(isset($_POST['sub']))
{
extract($_POST);
if($new_pass==$conform_pass)
	{
		$qry="update `login` set `password`='".md5($new_pass)."' where `id`='".$id."'";
		$data_base_object = new DataBaseConnect();
        $data_base_object->execute_query_operation($qry);
		$s=2;
	} 
	else
	{
			$s=1;	
}
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
                    <h4><i class="icon-user"></i>Change Password</h4>
                    </div>
                    <div class="portlet-body form">
                      <?php
									if($s==1)
									{
		  							 echo	'<div class="alert alert-error">
									<button class="close" data-dismiss="alert"></button>
									<strong>Error!</strong> Password Are Not Matched. 
								</div>';								
									}
									else if($s==2)
									{
										echo	'<div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<strong>Success!</strong> Password Change Successfully
								</div>';
									}
                                    ?>
	                             <table width="100%" style="margin-top:1%">
                             
                                 <tr>
                                 <td width="33%">New Passwords</td>
                                <td colspan="2"><input name="new_pass" required="required" placeholder="password" class="m-wrap medium" type="password"></td>
                                 </tr>
                                 
                                  <tr>
                                 <td>Conform New Password</td>
                                 <td>    
                                 <input name="conform_pass" class="m-wrap medium" required="required" placeholder="confirm password" type="password">
                                 </td>
                                 </tr>
                                 </table>
              
                               <div class="form-actions">
                                  <button type="submit" style="margin-left:20%" name="sub"  class="btn green" /><i class="icon-ok"></i> Save</button>
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