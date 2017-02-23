<?php 
require_once("function.php");
include("config.php");
$p=0;
if(isset($_POST['update']))
{
		$lid = $_POST['lid'];
		$result=mysql_query("select * from `login` where `login_name`='$lid'");
		$row=mysql_fetch_array($result);
		$member_id=$row['id'];
		
		mysql_query("delete from `module_privilege` where login_id='".$member_id."'");
		mysql_query("delete from `sub_module_assign` where login_id='".$member_id."'");  //first delete all rows  from table users_right where member id ='3'.
		
		$chk=$_POST['check'];
		foreach ($chk as $value)
		{
		mysql_query("insert into `module_privilege` set `login_id`='$member_id',`module_id`='$value'");//now insert all those  values / menu which we required.
		}
		$total=mysql_query("select * from `duty_slip` ");
		while ($row = mysql_fetch_array($total)) 											
		{ 
		$p++;
		$sel_ex=mysql_query("select * from `login` where `login_name`='".$_POST['lid']."'");
		$arr_ex=mysql_fetch_array($sel_ex);
		$m_id=$arr_ex['id'];
		$check_sub = $_POST['check_sub'.$p];
		if($_POST['check_sub'.$p]!="")
		{
		$check_sub_check_add = $_POST['check_sub_check_add'.$p];
		$check_sub_check_edit = $_POST['check_sub_check_edit'.$p];
		$check_sub_check_delete = $_POST['check_sub_check_delete'.$p];
		$check_sub_check_search = $_POST['check_sub_check_search'.$p];
		mysql_query("insert into `sub_module_assign` set `login_id`='$m_id',`submodule_id`='$check_sub',`add`='$check_sub_check_add',`edit`='$check_sub_check_edit',`delete`='$check_sub_check_delete',`view`='$check_sub_check_search'");
		}
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
<script type="text/javascript">
var xobj;
   //modern browers
   if(window.XMLHttpRequest)
    {
	  xobj=new XMLHttpRequest();
	  }
	  //for ie
	  else if(window.ActiveXObject)
	   {
	    xobj=new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
		  alert("Your broweser doesnot support ajax");
		  }
function ajax_right()
		  {	  
			 if(xobj)
			 {
			 var c1=document.getElementById("update").value;
			 var query="?con=" + c1;
			 xobj.open("GET","ajax_update_right.php" +query,true);
			 xobj.onreadystatechange=function()
			  {
			  if(xobj.readyState==4 && xobj.status==200)
			   {	   
			   document.getElementById("txt_my_name").innerHTML=xobj.responseText;
			   }
			  }
			  
			 }
			 xobj.send(null);
		  }
		  
</script>
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
     <form method="post">
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class="icon-check"></i>Update Right</h4>
                    </div>
                    <div class="portlet-body form">
					<table width="100%" style="margin-top:1%">
  <tr>
    <td width="25%">Login Id</td>
    <td width="22%" > <select name="lid"  id="update" class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from `login`");
									while($row= mysql_fetch_array($result))
									{
									 $login_name = $row['login_name'];
								   echo '<option value="'.$login_name.'">'.$login_name.'</option>';
									}
        				      ?>

     </select></td><td><button type="button"  class="btn green" name="fetch" onclick="ajax_right();">Go <i class="icon-circle-arrow-right"></i></button></td>
  </tr>
                         <tr>
                        <td colspan="3"><span id="txt_my_name"></span></td>
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