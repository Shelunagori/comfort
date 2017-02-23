<?php
require_once("config.php");
require_once("auth.php");
$login_id=$_GET['login_id'];  
$role_id=$_GET['role_id'];
if(!empty($login_id))  
{
?>
  <table class="table table table-bordered table-advance" style="width:100% !important;" align="center" >
									<thead>
										<tr>
											<th ><i class="icon-reorder"></i> Module</th>
											<th style="text-align:center"><i class="icon-check"></i> Status</th>
											<th ><i class="icon-sitemap"></i> Sub Module</th>
										</tr>
									</thead>
                                   <tbody>
                                    <?php
									$i=0;
									$result_module=mysql_query("select * from `module`");
									while($arr_module=mysql_fetch_array($result_module))
									{
										$i++;
										$z=0;
										$module_id=$arr_module['id'];
										$mainmenu_name=$arr_module['mainmenu_name'];
										
									$result_right=mysql_query("select * from `user_right` where `login_id`='".$login_id."' && `module_id`='".$module_id."'");
									$num_right=mysql_num_rows($result_right);
										
								    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
								    $num_submodule=mysql_num_rows($result_sub);
									
									
									?>
										<tr>
											<tr>
											<td width="25%"><?php echo $mainmenu_name; ?></td>
											<td width="25%" style="text-align:center;"><label style="width:100%; height:auto"><input type="checkbox" name="check_menu[]" value="<?php echo $module_id ?>" id="chk_main<?php echo $module_id ?>"   onclick="all_chk_sub_menu(<?php echo  $module_id; ?>,<?php echo $num_submodule; ?>)"  <?php if($num_right>0) { ?> checked="checked" <?php }?> ></label></td>
                                            <td width="50%"> <?php if($num_submodule>0) { ?> <a onclick="change_icon(<?php echo $i; ?>);" class="accordion-toggle btn yellow mini collapsed" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $i; ?>"><i id="myicon<?php echo $i; ?>" class="icon-plus"></i> Submodule<?php } ?></a></td>
										</tr>
	                                     <tr>
											<td colspan="3" style="padding:0px;">
											<div id="<?php echo $i; ?>" class="accordion-body collapse">
                                             <table width="100%" style="background-color:#DFF0D8 !important;">
                                                <?php 
									    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
										while($arr_submodule=mysql_fetch_array($result_sub))
										{
											$z++;
											$submenu_name= $arr_submodule['submenu_name'];
											$sub_menu_id= $arr_submodule['id'];
											
										$result_sub_right=mysql_query("select * from `user_right` where `login_id`='".$login_id."' && `submodule_id`='".$sub_menu_id."'");
									    $num_sub_right=mysql_num_rows($result_sub_right);
										
										$res_subsub=mysql_query("select `id` from `sub_submodule` where `submodule_id`='".$sub_menu_id."'");
										$count_subsub=mysql_num_rows($res_subsub);
										?>
									        <tr>
                                       		<td width="25%" style="padding-left:50px;"><?php echo $submenu_name; ?></td>
				  							<td width="25%" style="text-align:center;"><label style="width:100%;">
                                            <input onclick="perticulr_check(<?php echo $sub_menu_id; ?>,<?php echo $count_subsub; ?>);" type="checkbox" <?php if($num_sub_right>0) { ?> checked="checked" <?php } ?>  class="test<?php echo $module_id; ?>" id="check_i_sub_<?php echo $sub_menu_id; ?><?php echo $count_subsub; ?>" name="check_sub<?php echo $module_id; ?>[]" value="<?php echo $sub_menu_id; ?>"/></label></td>
                                            
                                            <td width="50%">
                                        	 <div class="controls" style="padding-left: 5%;">
                                            <?php 
										$result_subsub=mysql_query("select * from `sub_submodule` where `submodule_id`='".$sub_menu_id."'");
										while($arr_subsub=mysql_fetch_array($result_subsub))
										{
											$temp++;
									$user_subsub=mysql_query("select sub_submodule_id from `user_right` where `login_id`='".$login_id."' && `submodule_id`='".$sub_menu_id."' && `sub_submodule_id`='".$arr_subsub['id']."'");
										    $num_subsub=mysql_num_rows($user_subsub);
											?>
                                             <label class="checkbox inline" style="width:20%;">
                                             <input id="check_subsub<?php echo $sub_menu_id; ?><?php echo $temp; ?>" type="checkbox"  <?php if($num_subsub>0) { ?> checked="checked" <?php } ?> name="check_subsub<?php echo $module_id; ?><?php echo $sub_menu_id; ?>[]"  class="test<?php echo $module_id; ?>" value="<?php echo $arr_subsub['id']; ?>"/> <?php echo $arr_subsub['sub_submenu_name']; ?></label>
                                           
                                           
                                            <?php
										}
										$s=0;
										$temp=0;
										?>
                                         </div>
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
                                    <tfoot>
                                    <tr>
                                    <td colspan="3">
                                    <button type="submit"  style="margin-left:35%;" class="btn green" name="login_wise" ><i class="icon-ok"></i> Assign Rights</button>
                                    </td>
                                    </tr>
                                    </tfoot>
								</table>
 <?php
}
else if(!empty($role_id))
{
	?>
     <table class="table table table-bordered table-advance" style="width:100% !important;" align="center" >
									<thead>
										<tr>
											<th ><i class="icon-reorder"></i> Module</th>
											<th style="text-align:center"><i class="icon-check"></i> Status</th>
											<th ><i class="icon-sitemap"></i> Sub Module</th>
										</tr>
									</thead>
                                   <tbody>
                                    <?php
									$i=0;
									$result_module=mysql_query("select * from `module`");
									while($arr_module=mysql_fetch_array($result_module))
									{
										$i++;
										$z=0;
										$module_id=$arr_module['id'];
										$mainmenu_name=$arr_module['mainmenu_name'];
										
									$result_right=mysql_query("select * from `user_right` where `role_id`='".$role_id."' && `module_id`='".$module_id."'");
									$num_right=mysql_num_rows($result_right);
										
								    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
								    $num_submodule=mysql_num_rows($result_sub);
									?>
										<tr>
											<tr>
											<td width="25%"><?php echo $mainmenu_name; ?></td>
											<td width="25%" style="text-align:center;"><label style="width:100%; height:auto"><input type="checkbox" name="check_menu[]" value="<?php echo $module_id ?>" id="chk_main<?php echo $module_id ?>"   onclick="all_chk_sub_menu(<?php echo  $module_id; ?>,<?php echo $num_submodule; ?>)"  <?php if($num_right>0) { ?> checked="checked" <?php }?> ></label></td>
                                            <td width="50%"> <?php if($num_submodule>0) { ?> <a onclick="change_icon(<?php echo $i; ?>);" class="accordion-toggle btn red mini collapsed" data-toggle="collapse" data-parent="#accordion1" href="#<?php echo $i; ?>"><i id="myicon<?php echo $i; ?>" class="icon-plus"></i> Submodule<?php } ?></a></td>
										</tr>
	                                     <tr>
											<td colspan="3" style="padding:0px;">
											<div id="<?php echo $i; ?>" class="accordion-body collapse">
                                             <table width="100%" style="background-color:#DFF0D8 !important;">
                                                <?php 
									    $result_sub=mysql_query("select * from `sub_module` where `module_id`='".$module_id."'");
										while($arr_submodule=mysql_fetch_array($result_sub))
										{
											$z++;
											$submenu_name= $arr_submodule['submenu_name'];
											$sub_menu_id= $arr_submodule['id'];
											
										$result_sub_right=mysql_query("select * from `user_right` where `role_id`='".$role_id."' && `submodule_id`='".$sub_menu_id."'");
									    $num_sub_right=mysql_num_rows($result_sub_right);

										$res_subsub=mysql_query("select `id` from `sub_submodule` where `submodule_id`='".$sub_menu_id."'");
										$count_subsub=mysql_num_rows($res_subsub);
										?>
									        <tr>
                                       		<td width="25%" style="padding-left:50px;"><?php echo $submenu_name; ?></td>
				  							<td width="25%" style="text-align:center;"><label style="width:100%;">
                                            <input type="checkbox" <?php if($num_sub_right>0) { ?> checked="checked" <?php } ?>  id="check_i_sub_<?php echo $sub_menu_id; ?><?php echo $count_subsub; ?>" name="check_sub<?php echo $module_id; ?>[]" class="test<?php echo $module_id; ?>" onclick="perticulr_check(<?php echo $sub_menu_id; ?>,<?php echo $count_subsub; ?>);" value="<?php echo $sub_menu_id; ?>"/></label></td>
                                           
                                            
                                            <td width="50%">
                                        	 <div class="controls" style="padding-left: 5%;">
                                            <?php 
										$result_subsub=mysql_query("select * from `sub_submodule` where `submodule_id`='".$sub_menu_id."'");
										while($arr_subsub=mysql_fetch_array($result_subsub))
										{
										$temp++;
									$user_subsub=mysql_query("select sub_submodule_id from `user_right` where `role_id`='".$role_id."' && `submodule_id`='".$sub_menu_id."' && `sub_submodule_id`='".$arr_subsub['id']."'");
										    $num_subsub=mysql_num_rows($user_subsub);
											?>
                                             <label class="checkbox inline" style="width:20%;">
                                             <input type="checkbox" id="check_subsub<?php echo $sub_menu_id; ?><?php echo $temp; ?>"   <?php if($num_subsub>0) { ?> checked="checked" <?php } ?> name="check_subsub<?php echo $module_id; ?><?php echo $sub_menu_id; ?>[]"  class="test<?php echo $module_id; ?>" value="<?php echo $arr_subsub['id']; ?>"/> <?php echo $arr_subsub['sub_submenu_name']; ?></label>
                                           
                                           
                                            <?php
										}$temp=0;
										$s=0;
										?>
                                         </div>
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
                                    <tfoot>
                                    <tr>
                                    <td colspan="3">
                                    <button type="submit" style="margin-left:35%;" class="btn green" name="role_wise" ><i class="icon-ok"></i> Assign Rights</button>
                                    </td>
                                    </tr>
                                    </tfoot>
								</table>
	<?php
}