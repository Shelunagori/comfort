<?php
include("function.php");
include("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
  <meta charset="utf-8" />
  <title>Login Page</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="description" />
  <meta content="" name="author" />
  <?php css(); ?>
<body class="login">
  <!-- BEGIN LOGO --> 
  <div class="logo"><img src="assets/logo.jpg" alt="logo"   style="padding-top:10px;"/> 
</div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form"   method="post" />
      <?php
$message=false;
if(!empty($_POST['login']) && !empty($_POST['pass']) )
{ 

$result=mysql_query("select * from `login` where `login_id`='".$_POST['login']."' and `password`='".md5($_POST['pass'])."' and `counter_id`='".$_POST['counter']."' ");
	if(mysql_num_rows($result)>0)
	{
		@session_start();
		$row= mysql_fetch_array($result);


		$_SESSION['id']=$row['id'];
		$_SESSION['login_id']=$row['login_id'];
		$_SESSION['username']=$row['username'];
		$_SESSION['counter_id']=$row['counter_id'];
		ob_start();
		echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
		ob_flush();
	}
	else 
	{
		$message =true;	
	}
}    if($message)
       { 
      ?>
    <h5 style="color:red;"><b>Username OR Password are Incorrect</b></h5>
     <?php 
	} 
	?>
    <h3 class="form-title">Login to your account</h3>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap" type="text" name="login" autocomplete="off" required="required" autofocus="true"  placeholder="Login id" />
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap" type="password" name="pass" autocomplete="off" required="required" placeholder="Password" />
          </div>
        </div>
      </div>
       <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
           <i class="icon-inbox"></i>
        <select name="counter" style="width:100%; text-align:center" REQUIRED class="m-wrap" >
        <option value="">---Select Counter Name---</option>
        <?php
		$result=@mysql_query("select * from `counter`");
        while($row= mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
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