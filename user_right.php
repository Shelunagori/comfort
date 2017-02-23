<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
$reg_ll=@mysql_query("select `id` from `login` ");
while ($row = mysql_fetch_array($reg_ll)) 											
	{
		$j++;
	if(isset($_POST['edit_password'.$j]))
	{
			$n_pass=$_POST['n_pass'.$j];
			$r_pass=$_POST['r_pass'.$j];
			$l_idd=$_POST['l_idd'.$j];
			if(!empty($n_pass)&&!empty($r_pass))
			{
					if($n_pass!=$r_pass)
					{
										$status=1;
					}
					else
					{
						
										$rs=@mysql_query("update `login` set `password`='".md5($n_pass)."' where `id`='".$l_idd."'");
										if($rs)
										$status=2;
					}
			}
			else
			{
										$status=3;
			}
	}
}


if(isset($_POST['add_mainmenu']))
{
	$result=@mysql_query("insert into `module` set `mainmenu_name`='".$_POST['module_name']."',`page_link`='".$_POST['module_link']."',`page_icon`='".$_POST['module_icon']."'");
	if($result)
	echo "<script>;alert('Entry Updated Successfully');location='user_right.php?mode=setup';</script>";
	else
    echo "<script>;alert('Error in menu creation Try again');location='user_right.php?mode=setup';</script>";

}
if(isset($_POST['add_submenu']))
{
	$result=@mysql_query("insert into `sub_module` set `submenu_name`='".$_POST['submodule_name']."',`page_link`='".$_POST['submodule_link']."',`module_id`='".$_POST['module_idd']."'");
	if($result)
	echo "<script>;alert('Entry Updated Successfully');location='user_right.php?mode=setup';</script>";
	else
    echo "<script>;alert('Error in menu creation Try again');location='user_right.php?mode=setup';</script>";

}
if(isset($_GET['id']) && isset($_GET['delete']))
{
	 @mysql_query("delete from module where id='".$_GET['id']."'");
	 @mysql_query("delete from sub_module where module_id='".$_GET['id']."'");
	 echo "<script>;location='user_right.php?mode=setup';</script>";
}
else if(isset($_GET['id']) && isset($_GET['delete_sub']))
{
	 mysql_query("delete from sub_module where id='".$_GET['id']."'");
	 echo "<script>;location='user_right.php?mode=setup';</script>";
}
else if(isset($_GET['idd']) && isset($_GET['delete_account']))
{
	 @mysql_query("delete from user_right where login_id='".$_GET['idd']."'");
  	 @mysql_query("delete from login where id='".$_GET['idd']."'");
	 echo "<script>;alert('User Deleted Successfully');location='user_right.php?mode=view';</script>";
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
<script type="text/javascript">
function all_chk_sub_menu(main_menu_id,cnt_sub_menu) 
{ 
	if(document.getElementById("chk_main" + main_menu_id).checked==true)
	{
		var elements = document.getElementsByClassName("test" + main_menu_id);
		for(var i=0; i<elements.length; i++) 
		{
		elements[i].checked=true;
		}	
		
	}
	else  if(document.getElementById("chk_main" + main_menu_id).checked==false)
	{
		var elements = document.getElementsByClassName("test" + main_menu_id);
			for(var i=0; i<elements.length; i++) 
			{
			elements[i].checked=false;
			}	
	}
}
			
function perticulr_check(sub_menu_id,num_subsub)
{
	
			if(document.getElementById("check_i_sub_"+ sub_menu_id + num_subsub).checked==true)
			{
				for (var i=1; i<=num_subsub; i++) 
				{
				document.getElementById("check_subsub"+ sub_menu_id + i).checked=true;
				}
			}
			else
			{
				for (var i=1; i<=num_subsub; i++) 
				{
				document.getElementById("check_subsub"+ sub_menu_id + i).checked=false;
				}	
			}
				
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
      <div class="page-content" id="zoom_div">
         <div class="container-fluid">
     <?php menu(); ?> 
                          <?php 
						  if(isset($_GET['mode']))
						  {
							  if($_GET['mode']=='user')
							  {
								  ?>
                                  <form name="frm" action="Handler.php" method="post" >
                                   <div class="portlet box blue" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-user"></i>User wise</h4>
                                    </div>
                                    <div class="portlet-body">
								    <table width="100%" cellpadding="0" cellspacing="0" align="center">                  
                                    <tr>
                                    <td width="70%" colspan="2" align="center">
                                    <select class="m-wrap large"   name="mylogin" id="login_id" onChange="right_fetch();" >
                                    <option value="">---Select Login Id---</option> 
                                    <?php
                                    $rez=mysql_query("select distinct `id`,`login_id` from `login` ");
                                    while($ftc_name=mysql_fetch_array($rez))
                                    {
                                    $id = $ftc_name['id'];
                                    $login_id = $ftc_name['login_id'];
                                    echo '<option value="'.$id.'">'.$login_id.'</option>';                                   
                                    }
                                    ?>
                                    </select>
                                    </td>
                                    </tr>
                                    </table> 
                                    <div id="personal_data" align="center"></div>
                                    </div>
                                    </div> 
                                    </form>
                                    <?php
							  }
							  else if($_GET['mode']=='role')
							  {
								  ?>
                                   <form name="frm" action="Handler.php" method="post" >
                                    <div class="portlet box red" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-inbox"></i>Counter wise</h4>
                                    </div>
                                    <div class="portlet-body">
                                   <table width="100%" cellpadding="0" cellspacing="0" align="center">                  
                                    <tr>
                                    <td width="70%" colspan="2" align="center">
                                    <select class="m-wrap large" id="myrole"  name="role"  onChange="desgi_wise();" >
                                    <option value="">---Select Counter---</option> 
									<?php
                                    $rez=mysql_query("select distinct `id`,`name` from `counter` ");
                                    while($ftc_name=mysql_fetch_array($rez))
                                    {
                                    $id = $ftc_name['id'];
                                    $name = $ftc_name['name'];
                                    echo '<option value="'.$id.'">'.$name.'</option>';                                   
                                    }
                                    ?>
                                    </select>
                                    </td>
                                    </tr>
                                    </table> 
                                    <div id="role_data" align="center"></div>
                                    </div>
                                    </div>
                                    </form>
                                  <?php
							  }
							  else if($_GET['mode']=='view')
							  {
								?>
	                                <form name="frm" method="post" >
                                    <div class="portlet box yellow">
                                    <div class="portlet-title">
                                    <h4><i class="icon-home"></i>View Rights</h4>
                                    </div>
                                    <div class="portlet-body">
                      					<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
                                        <table class="table table-striped table-bordered table-advance table-hover" >
                                        <thead>
                                        <tr>
                                        <th>SL.</th>
                                        <th><i class="icon-user"></i> User Name</th>
                                        <th><i class="icon-briefcase"></i> Login-Id</th>
                                        <th><i class="icon-question-sign"></i> Designation </th>
                                        <th><i class="icon-trash"></i> Delete Account</th>
                                        <th><i class="icon-gift"></i> Ledger View</th>
                                        <th><i class="icon-lock"></i> Edit Password</th>
                                        </tr>
                                        </thead>
                                       <tbody>
                                        <?php
										$result=mysql_query("select * from login");										
										while ($row=mysql_fetch_array($result))
										{ 
										$i++;	
										$idd = $row['id'];
										$username= $row['username']; 
										$login=$row['login_id'];
										$counter_name=counterfun($row['counter_id']);	
										$ldrview=$row['ldrview'];											
										?>	
                                        <tr>								
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $login; ?></td>
                                        <td><?php echo $counter_name; ?></td>
                                      	<td>
                                       	<input type="hidden" name="l_idd<?php echo $i; ?>" value="<?php echo $idd; ?>" />
                                      <a class="btn mini red tooltips" data-placement="bottom" data-original-title="Tooltip in bottom"  title="permanently Delete Account" data-toggle="modal" href="#myModal1<?php echo $i; ?>" ><b><i class="icon-trash"></i></b></a>
                                            
                                            
                                             <div style="display: none;" id="myModal1<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $username; ?></b></span></h4>
                                    </div>
                                  <!--  <div class="modal-body">
                                    </div>-->
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <a type="submit"  href='user_right.php?delete_account=true&idd=<?php echo $row['id'];?>' id="refresh" class="btn red"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                    </div>
                                     </td>
                                     <td>
                                    <div class="controls">
                                    <div class="basic-toggle-button">
                                    <input type="checkbox" class="toggle" id="ldr_view<?php echo $i; ?>" value="<?php echo $i; ?>" onChange="fetch_ldrview(this.value);" <?php if($ldrview=='yes') { ?> checked="checked" <?php } ?> />
                                    </div>
                                    </div>
                                    
                                     </td>
                                     <td>
                                      <a class="btn mini yellow tooltips" data-placement="top" data-original-title="Tooltip in bottom"  title="Edit Password" data-toggle="modal" href="#myModal2<?php echo $i; ?>" ><b><i class="icon-edit"></i></b></a>
                                            
                                            
                                             <div style="display: none;" id="myModal2<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#FFB848"><i class="icon-refresh"></i> <b>Password Edit For <?php echo $username; ?></b></span></h4>
                                    </div>
                                   <div class="modal-body">
                                   <input type="password"  name="n_pass<?php echo $i; ?>"  title="3 characters minimum" placeholder="New Password" class="m-wrap large tooltips" data-placement="right" >
                                   <input type="password"  name="r_pass<?php echo $i; ?>"   title="3 characters minimum" placeholder="Confirm Password"  class="m-wrap large tooltips" data-placement="right">
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <button type="submit" name="edit_password<?php echo $i; ?>" class="btn yellow"><i class="icon-refresh"></i> Edit Password</button>
                                   </div>
                                   </div>
                                     </td>
                                        </tr>
                                        <?php
                                        }
										?>
									<input type="hidden" name="countlogin" value="<?php echo $i; ?>" />
									</tbody>
								</table>
                                </div>
                                    </div>
                                    </div>
                                    </form>
                                <?php  
							  }
							  else if($_GET['mode']=='setup')
							  {
								  ?>
                                    <form name="frm"  method="post" >
                                    <div class="portlet box grey" >
                                    <div class="portlet-title">
                                    <h4><i class="icon-star"></i>Menu Setup</h4>
                                    <h4 style="float:right;">Add or Delete Menu or Submenu</h4>
                                    </div>
                                    <div class="portlet-body">
								   <table class="table table-bordered table-condensed flip-content dataTable" style="width:100% !important;" align="center" >
									<thead>
										<tr>
											<th ><i class="icon-reorder"></i> Module</th>
											<th ><i class="icon-trash"></i> Delete</th>
											<th ><i class="icon-reorder"></i> Sub Module</th>
										</tr>
									</thead>
                                   <tbody>
                                    <?php
									$i=0;
									$result_module=mysql_query("select * from `module`");
									while($arr_module=mysql_fetch_array($result_module))
									{
										$module_id=$arr_module['id'];
										$mainmenu_name=$arr_module['mainmenu_name'];
										$i++;
								    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
								    $num_submodule=mysql_num_rows($result_sub);
									?>
										<tr>
											<tr>
											<td width="50%"><?php echo $mainmenu_name; ?></td>
											<td width="20%"> <a class="btn mini red tooltips" data-placement="bottom" data-original-title="Tooltip in bottom"  title="Delete Menu & its Submenu" data-toggle="modal" href="#myModal1<?php echo $i; ?>" ><b><i class="icon-trash"></i></b></a>
                                            
                                            
                                             <div style="display: none;" id="myModal1<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $mainmenu_name; ?></b></span></h4>
                                    </div>
                                  <!--  <div class="modal-body">
                                    </div>-->
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <a type="submit"  href='user_right.php?delete=true&id=<?php echo $module_id;?>' id="refresh" class="btn red"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                    </div>
                                    
                                            
                                            
                                            </td>
                                            <td width="30%"> <?php if($num_submodule>0) { ?> <a onclick="change_icon(<?php echo $i; ?>);" class="accordion-toggle btn yellow mini collapsed" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $i; ?>"><i id="myicon<?php echo $i; ?>" class="icon-plus"></i><?php } ?></a></td>
										</tr>
	                                     <tr>
											<td colspan="3" style="padding:0px;">
											<div id="<?php echo $i; ?>" class="accordion-body collapse">
                                             <table width="100%" style="background-color:#DFF0D8 !important;">
                                                <?php 
									    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
										while($arr_submodule=mysql_fetch_array($result_sub))
										{$k++;
											$submenu_name= $arr_submodule['submenu_name'];
											$sub_menu_id= $arr_submodule['id'];
										?>
									        <tr>
                                       		<td width="50%" style="padding-left:50px;"><?php echo $submenu_name; ?></td>
				  							<td width="20%"><a class="btn mini red tooltips" data-placement="bottom" data-original-title="Tooltip in bottom"  title="Delete Submenu" data-toggle="modal" href="#myModal2<?php echo $k; ?>" ><b><i class="icon-trash"></i></b></a>
                                            
                                           <div style="display: none;" id="myModal2<?php echo $k; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $submenu_name; ?></b></span></h4>
                                    </div>
                                  <!--  <div class="modal-body">
                                    </div>-->
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <a type="submit"  href='user_right.php?delete_sub=true&id=<?php echo $sub_menu_id;?>' id="refresh" class="btn red"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                    </div>
                                            
                                            
                                            </td>
                                            <td width="30%">&nbsp;</td>
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
                                    <tfoot>
                                    <tr>
                                    <td colspan="3"><tr>
                                    <td colspan="4">
                                    
                                    
                                     <div style="display: none;" id="myModal_addmenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#5CB85C"><i class="icon-th"></i></span></h4>
                                    </div>
                                    <div class="modal-body">
                                     <select name="menu_type" onChange="fetch_menulink(this.value);" class="m-wrap small"/>
                                    <option value="0">---Select Type---</option>
                                    <option value="1">Single Menu</option>
                                    <option value="2">Multiple Menu</option>
                                    </select>
                                   <input type="text" name="module_name" title="Name of Menu" class="m-wrap small" placeholder="Menu Name"/>
                                   <input type="text" name="module_link" id="menu_type" title="Like index.php or javascript:;"  class="m-wrap small" placeholder="Menu Link"/>
                                   <input type="text" name="module_icon" title="Like icon-edit or icon-search" class="m-wrap small" placeholder="Menu Icon"/>
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                    <button type="submit"  name="add_mainmenu" class="btn green"><i class="icon-ok"></i> Add</button>
                                    </div>
                                    </div>
                                    
                                      
                                     <div style="display: none;" id="myModal_submenu" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#4D90FE"><i class="icon-th-list"></i></span></h4>
                                    </div>
                                    <div class="modal-body">
                                    <select name="module_idd" title="Select menu in which you wants to create sub menu" class="m-wrap medium"/>
                                    <option value="0" >---Select Mainmenu---</option>
                                    <?php
                                    $rez=mysql_query("select `id`,`mainmenu_name` from `module` ");
                                    while($ftc_name=mysql_fetch_array($rez))
                                    {$idd=$ftc_name['id'];
									$mainmenu_name=$ftc_name['mainmenu_name'];
                                    echo '<option value='.$idd.'>'.$mainmenu_name.'</option>';
                                    }
                                    ?>
                                    </select>
                                    <input type="text" name="submodule_name" title="Submenu Name" class="m-wrap small" placeholder="SubMenu Name"/>
                                    <input type="text" name="submodule_link" title="Like submenu.php i.e. filename.php" class="m-wrap small" placeholder="SubMenu Link"/>
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                    <button type="submit"  name="add_submenu" class="btn blue"><i class="icon-ok"></i> Add</button>
                                    </div>
                                    </div>
                                    
                                    
                                    <a class="btn green" data-placement="bottom" data-toggle="modal" href="#myModal_addmenu" ><i class="icon-th"></i> Add Menu</a>
                                    
                                    <a class="btn blue" data-placement="bottom" data-toggle="modal" href="#myModal_submenu" ><i class="icon-th-list"></i> Add Submenu</a>
                                    
                                    </td>
                                    </tr>
                                    </tfoot>
                                     </tfoot>
								</table>
                                </div>
                                </div>
                                </form>
                                <?php
							  }
						  }
						  else
						  {
							  ?>
                            <form method="post" name="form_name"  action="Handler.php">
                            <table width="100%" style="margin-top:1%;" cellpadding="0" cellspacing="0"  align="center"> 
                            <tr>
                            <td colspan="2"><input type="text" required="required"  class="m-wrap medium"  name="user" placeholder="User Name" ></td>
                            </tr>
                            <tr>
                            <td colspan="2"><input type="text"  required="required" class="m-wrap medium"  name="login_id" placeholder="Login Id" ></td>
                            </tr>
                            <tr>
                            <td colspan="2"><input type="password"  required="required" class="m-wrap medium"   name="pass" placeholder="Password" ></td>
                            </tr>
                            <tr>
                            <td width="15%" id="counter_here">
                            <select name="counter_id" class="m-wrap medium"  required="required">
                            <option value=""> Select Counter</option>
                            <?php $sel1=mysql_query("select * from counter");
                            while($arr1=mysql_fetch_array($sel1))
                            {
                            echo '<option value="'.$arr1['id'].'">'.$arr1['name'].'</option>';
                            } ?>
                            </select>
                            </td>
                            <td>
                              <button class="btn green tooltips" data-placement="bottom" data-original-title="Tooltip in bottom"  title="Add New Counter" data-toggle="modal" href="#myModal1" style="margin-top:-1%"><b><i class="icon-inbox"></i></b></button>
                        
                                    <div style="display: none;" id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#35AA47"><i class="icon-inbox"></i> Counter Name</b></span></h4>
                                    </div>
                                    <div class="modal-body">
                                     <input type="text" id="counter" class="span12 m-wrap"  placeholder="Enter New Counter Name" />
                                    </div>
                                    <div class="modal-footer">
                                   <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <button type="submit"  onClick="add_desg();"  id="refresh"    data-dismiss="modal"  class="btn green"><i class="icon-ok"></i> Add Now</button>
                                    </div>
                                    </div>
                                    
                                      <div style="display: none;" id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#EE5F5B"><i class="icon-trash"></i></b></span></h4>
                                    </div>
                                    <div class="modal-footer">
                                   <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <button type="submit"  id="refresh"  onClick="delete_desg();"  data-dismiss="modal"  class="btn red"><i class="icon-trash"></i> Delete</button>
                                    </div>
                                    </div>
                           </td>       
                                    
                            </tr>
                            
                             <tr>
                            <td>
                         	<select name="ldrview" class="m-wrap medium"  required="required">
                            <option value=""> Ledger Accessibility</option>
 							<option value="yes">Yes</option>
                            <option value="no">No</option>                          
                            </select>
                            </td>
                            </tr>
                            
                            <tr>
                            <td><input type="text"  class="m-wrap medium"  name="email" placeholder="Email" ></td>
                            </tr>
                           
                            </table>
                            <button type="submit" class="btn green" name="create_login"><i class="icon-user"></i> Submit</button>
                           </table>   
                           <?php
						  }
						  ?>
    
                   
        </form>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
   <div class="footer">
     <?php footer();?>
   </div>
 <?php js(); ?> 
  <?php
	  if($status==1)
	  {
		 ?>
         <script>
		var my_activity='<h4 class="alert-heading"  ><i class="icon-remove"></i> Password Doesnot Matched</h4>';
		var my_details='<p style="font-style:italic"><i class="icon-pencil"></i>&nbsp;&nbsp;Try Again</p>';
		my_notification(my_activity,my_details);
		</script>
         <?php  
 		
	  }
	  else if($status==2)
	  {
		  ?>
         <script>
		var my_activity='<h4 class="alert-heading"  ><i class="icon-thumbs-up"></i> Password Changed Successfully.</h4>';
		var my_details='<p style="font-style:italic"><i class="icon-ok"></i>&nbsp;&nbsp;Updated</p>';
		my_notification(my_activity,my_details);
		</script>
         <?php   
	  }
	   else if($status==3)
	  {
		  ?>
         <script>
		var my_activity='<h4 class="alert-heading"  ><i class="icon-remove"></i> Error! Enter nothing.</h4>';
		var my_details='<p style="font-style:italic"><i class="icon-pencil"></i>&nbsp;&nbsp;Try Again</p>';
		my_notification(my_activity,my_details);
		</script>
         <?php   
	  }
	?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>