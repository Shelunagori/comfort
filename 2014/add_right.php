<?php 
require_once("function.php");
include("config.php");
require_once("auth.php");
$p=0;
if(isset($_POST['user_right']))
{
	 mysql_query("insert into `login` set  `username` = '".$_POST['uname']."' , `counter` = '".$_POST['counter_id']."' , `login_name` = '".$_POST['lid']."' , `password` = '".md5($_POST['pass'])."' ");
	$chk=$_POST['check'];
		$check_sub = $_POST['check_sub'];
        foreach ($chk as $value)
		{
		$sel_ex=mysql_query("select * from `login` where `login_name`='".$_POST['lid']."'");
		$arr_ex=mysql_fetch_array($sel_ex);
		$m_id=$arr_ex['id'];
		mysql_query("insert into `module_privilege` set `login_id`='$m_id',`module_id`='$value'");
		}	
	/*	foreach ($check_sub as $value_supplier)
		{
		$result_supplier_sub=mysql_query("select * from `login` where `login_name`='".$_POST['lid']."'");
		$arr_supplier=mysql_fetch_array($result_supplier_sub);
		$m_id=$arr_supplier['id'];
     	mysql_query("insert into `sub_module_assign` set `login_id`='$m_id',`submodule_id`='$value_supplier'");
		}
*/
	
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

/* function cheking(id) 
	{ 
		 if(document.getElementById(id).checked==true)
			 {
				var group=document.frm1.elements[id + "_sub_check[]"];	
        		for (var i=0; i<group.length; i++) 
				{
				group[i].checked = true;
           		 }
			 }
			 else
			 {
				 var group=document.frm1.elements[id + "_sub_check[]"];
        		for (var i=0; i<group.length; i++) 
				{
				//document.frm1.elements[id + "[]"][i].checked = true;
				group[i].checked = false;
           		 }
			 }
	}
	*/  
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
     <form method="post" name="frm1">
                    <div class="portlet box yellow">
                    <div class="portlet-title">
                    <h4><i class=" icon-user"></i>Add Right</h4>
                    </div>
                    <div class="portlet-body form">
 <table width="100%" style="margin-top:1%">
  <tr>
    <td width="30%">User Name</td>
    <td width="70%"><input type="text" name="uname" class="m-wrap medium"  id="user"/></td>
  </tr>
  <tr>
    <td>Login id</td>
    <td><input type="text" name="lid"  class="m-wrap medium"  id="login"/></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><input type="password" name="pass"  class="m-wrap medium"  id="mypassword"/></td>
  </tr>
  <tr>
    <td>Counter</td>
    <td colspan="2"> <select name="counter_id"  class="chosen" tabindex="1"  >
    							 <option value="" ></option>
    								    <?php
									  $database=new DataBaseConnect();
									$result=$database->execute_query_return("select * from `counter`");
									while($row= mysql_fetch_array($result))
									{
									 $counter = $row['counter_name'];
									 $id = $row['id'];
								   echo '<option value="'.$id.'">'.$counter.'</option>';
									}
        				      ?>

     </select></td>
  </tr>
 <tr><td colspan="2">&nbsp;</td></tr> <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
  <td colspan="2">
  
  <div class="portlet box green">
                     <div class="portlet-title">
								<h4><i class="icon-reorder"></i>Module</h4>
								</div>
							<div class="portlet-body">
								<div style="height: auto;" class="accordion in collapse" id="accordion1">
                                <table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="50%">Module</th>
											<th style="text-align:center; width:25% !important">Status</th>
											<th style="text-align:center; width:25% !important">Advance Settings</th>
										</tr>
									</thead>
                                    <tbody>
										
                                    <?php
									$i=0;
									$sel_module=mysql_query("select * from module");
									while($arr_module=mysql_fetch_array($sel_module))
									{
										$i++;
									?>
										<tr>
											<tr>
											<td><?php echo $arr_module['menu_name']; ?></td>
											<td style="text-align:center;"><label style="width:100%; height:auto"><input type="checkbox" style="opacity: 1 !important;margin-top: -5%;width: 85%;"   name="check[]" value="<?php echo $arr_module['id']; ?>"></label></td>
                                            <td><a class="accordion-toggle btn yellow mini collapsed" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $i; ?>"><strong>Sub Module</strong></a></td>
										</tr>
                                        <tr>
											<td colspan="3" style="padding:0px;">
											<div id="<?php echo $i; ?>" class="accordion-body collapse">
												<table class="table table-bordered table-hover" style="background-color:#DFF0D8;">
                                                <?php 
								    $sub_module_data=mysql_query("select * from `sub_module` where `Main_module_id` = '$i'");
									while($arr_sub_module=mysql_fetch_array($sub_module_data))
									{		
									$k++;
									$status=1;	
										?>
                                   <tr><td width="50%" style="background-color:#DFF0D8;"><?php echo $arr_sub_module['sub_module_name']; ?></td>
                                   <td style="text-align:center; width:25% !important;background-color:#DFF0D8;"><label style="width:100%;"><input type="checkbox" name="check_sub<?php echo $k ?>"  value="<?php echo $arr_sub_module['id']; ?>" onChange="cheking(this.id)" id="check" style="opacity: 1 !important;margin-top: -5%;width: 85%;"></label></td>
                                     <td style="text-align:center; width:25% !important;background-color:#DFF0D8;">
                                       <table width="100%" align="center">
                                     <tr>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox" style="opacity: 1 !important;margin-top: -5%;width: 85%;"  name="check_sub_check_add<?php echo $k ?>" value="<?php echo $status ?>" /><i class="icon-plus" style="color:#5CB85C !important;"></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox" style="opacity: 1 !important;margin-top: -5%;width: 85%;" name="check_sub_check_edit<?php echo $k ?>" value="<?php echo $status ?>"/><i class="icon-edit" style="color:#FFB848 !important;" ></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox" style="opacity: 1 !important;margin-top: -5%;width: 85%;" name="check_sub_check_delete<?php echo $k ?>" value="<?php echo $status ?>"/><i class="icon-trash" style="color:#EE5F5B !important;"></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox" style="opacity: 1 !important;margin-top: -5%;width: 85%;" name="check_sub_check_search<?php echo $k ?>" value="<?php echo $status ?>"/><i class="icon-search" style="color:#4D90FE !important;"></i></label></td>
                                     </tr>
                                     </table> 
                                     </td>
                                   </tr>
                                     <?php
									}
									?>
                                             </table>							
											</div>
											</td>
										</tr>
                                            
                                     <?php
									}
									 ?>  
                                     </tbody>
								</table>
                                     
									</div>
								</div>
							</div>
						</td></tr>
</table>

                         <div class="form-actions">
                          <button type="submit" style="margin-left:30%" name="user_right" value="Save"  class="btn green" /><i class="icon-ok"></i> Submit</button>
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