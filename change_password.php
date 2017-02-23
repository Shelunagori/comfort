<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
session_start();
$id=$_SESSION['id'];
$res_username=mysql_query("select `username` from `login` where `id`='".$id."'");
$arr_user=mysql_fetch_array($res_username);
if(isset($_POST['chg_pass']))
{
	$new_pass=$_POST['new_pass'];
	$confirm_pass=$_POST['confirm_pass'];
	if(!empty($new_pass)&&!empty($confirm_pass))
	{
		if($new_pass==$confirm_pass)
		{
		$rs=@mysql_query("update `login` set `password`='".md5($_POST['new_pass'])."' where `id`='".$id."'");
		unset($id);
		if($rs)
		{
		echo "<script>
		alert('Password Changed Successfully.');
		window.location='change_password.php';
		</script>";
		}
		}
		else
		{
		echo "<script>
		alert('Error! Password did not matched.');
		window.location='change_password.php';
		</script>";
		}
	}
	else
	{
		 echo "<script>
    alert('Error! Enter nothing.');
	window.location='change_password.php';
	</script>";
	}
	
}
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
     <form method="post" name="form_name">
        <div class="portlet box yellow">
        <div class="portlet-title">
        <h4><i class="icon-key"></i>Change Password</h4>
        </div>
        <div class="portlet-body form">
        
                <table width="100%" cellpadding="0" cellspacing="0">
                
                <tr>
                <td>User Name</td>
                <td><input type="text" name="u_name" disabled   class="m-wrap medium"  value="<?php echo $arr_user['username']; ?>" ></td>
                </tr>
                
                <tr>
                <td>New Passwords</td>
                <td><input name="new_pass" autofocus autocomplete='off'   placeholder="password" class="m-wrap medium" type="password"></td>
                </tr>
                
                <tr>
                <td>Confirm New Password</td>
                <td><input name="confirm_pass" autocomplete='off' class="m-wrap medium"  placeholder="confirm password" type="password"></td>
                </tr>
                
                <tr>
                <td>&nbsp;</td>
                <td>
                <button type="submit" name="chg_pass" class="btn green" ><i class="icon-question-sign"></i> Save Change</button>
                </td>
                </tr>
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