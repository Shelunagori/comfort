<?php
session_start();
session_destroy();
include("function.php");
require_once ("classes/databaseclasses/DataBaseConnect.php");
?>
<!DOCTYPE html>
 <html lang="en"> 
<head>
  <meta charset="utf-8"/>
  <title>Login | Comfort</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
 <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="images/logo.jpg" width="300px" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" method="post"/>
    <?php
	$message=false;

if(!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['counter']))
{
	$database=new DataBaseConnect();
	$result=$database->execute_query_return("select * from `login` where `login_name`='".$_POST['login']."' and `password`='".md5($_POST['pass'])."' and `counter`='".$_POST['counter']."' and `status`='0'");
	if(mysql_num_rows($result)>0)
	{
		session_start();
		$row= mysql_fetch_array($result);
		$_SESSION['login_user']=$row['id'];
		$_SESSION['username']=$row['login_name'];
		$_SESSION['counter']=$row['counter'];
		$_SESSION['ldrview']=$row['ldrview'];
		$database->close_connection();
		echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
	}
	else 
	{
		$message =true;	
		$database->close_connection();
	}
}    if($message)
       {
      ?>
    <h5 class="form-title" style="color:red;"><b>Username and Password are Incorrect</b></h5>
    <?php 
	} ?>
      <h3 class="form-title">Login to your account</h3>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap" type="text" name="login" required="required" placeholder="Username" />
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap" type="password" name="pass"  required="required" placeholder="Password" />
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
         
          <select name="counter"  class="span5 chosen" tabindex="1"  required="required" style="width:100%" id="dist_name_fetch">
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select *  from `counter`");
									while($row= mysql_fetch_array($result))
									{
									 $counter_name = $row['counter_name'];
								   echo '<option value="'.$row['id'].'">'.$counter_name.'</option>';
									}
        				      ?>

     </select>
           </div>
        </div>
      </div>
      
      <div class="form-actions">     
        <button type="submit" name="bttn_login"  class="btn green pull-right">Login <i class="m-icon-swapright m-icon-white"></i></button>
      </div>
  
    </form>
  
     
  </div>
  
  <div class="copyright" style="float:left; width:980px" >
    <?php footer(); ?>
  </div>
  <?php js(); ?>
  <script>
    jQuery(document).ready(function() {
      App.initLogin();
    });
  </script>
 
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>