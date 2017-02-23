 <?php
 require_once("config.php");
 $find =$_GET['con'];
 if($find!="")
 {
 ?>    
   <table width="90%" border="0">
   <center>
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="60%">&nbsp;</td>
 </tr>
  <td colspan="2">&nbsp;</td>
  </tr>
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
											<th width="50%" >Module</th>
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
										 $module_id = $arr_module['id'];
									?>
										<tr>
											<tr>
											<td><?php echo $arr_module['menu_name']; ?></td>
                                            <?php
											$result = mysql_query(" select * from `login` where `login_name` = '$find'  ");	
											$ftc_data1=mysql_fetch_array($result);
											$id = $ftc_data1['id'];
											
											$result1 = mysql_query(" select * from `module_privilege` where `login_id` = '$id' && `module_id`='$module_id'  ");	
											$arr_module2=mysql_num_rows($result1);
										
											?>
                                            
											<td style="text-align:center;"><label style="width:100%;"><input type="checkbox"  name="check[]" value="<?php echo $arr_module['id']; ?>" <?php if(!empty($arr_module2)){ ?> checked <?php  } ?> ></label></td>
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
									$id_submodule = $arr_sub_module['id'];
										?>
                                   <tr><td width="50%" style="background-color:#DFF0D8;"><?php echo $arr_sub_module['sub_module_name']; ?></td>
                                     <?php
											$result = mysql_query(" select * from `login` where `login_name` = '$find'  ");	
											$ftc_data1=mysql_fetch_array($result);
											$id = $ftc_data1['id'];
											
											$result1 = mysql_query(" select * from `sub_module_assign` where `login_id` = '$id' && `submodule_id`='$id_submodule'  ");	
											$arr_module_assign1=mysql_num_rows($result1);
											$arr_module_assign=mysql_fetch_array($result1);
											?>
                                   <td style="text-align:center; width:25% !important;background-color:#DFF0D8;">
              <label style="width:100%;"><input type="checkbox" name="check_sub<?php echo $k ?>"  value="<?php echo $arr_sub_module['id']; ?>" <?php if(!empty($arr_module_assign1)){ ?> checked <?php  } ?>></label>
              </td>
                                   
                                     <td style="text-align:center; width:25% !important;background-color:#DFF0D8 !important;">
                                     <table width="100%" align="center">
                                     <tr>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox"  <?php if($arr_module_assign['add']==1){ ?> checked="checked" <?php  } ?> name="check_sub_check_add<?php echo $k ?>"  value="<?php echo $status ?>" />&nbsp;<i class="icon-plus" style="color:#5CB85C !important;"></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox"  <?php if($arr_module_assign['edit']==1){ ?> checked="checked" <?php  } ?>  name="check_sub_check_edit<?php echo $k ?>"  value="<?php echo $status ?>" />&nbsp;<i class="icon-edit" style="color:#FFB848 !important;" ></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox"  <?php if($arr_module_assign['delete']==1){ ?> checked="checked" <?php  } ?> name="check_sub_check_delete<?php echo $k ?>"  value="<?php echo $status ?>" />&nbsp;<i class="icon-trash" style="color:#EE5F5B !important;"></i></label></td>
                                     <td style="background-color:#DFF0D8;"><label ><input type="checkbox"  <?php if($arr_module_assign['view']==1){ ?> checked="checked" <?php  } ?> name="check_sub_check_search<?php echo $k ?>"  value="<?php echo $status ?>"/>&nbsp;<i class="icon-search" style="color:#4D90FE !important;"></i></label></td>
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
       <div class="form-actions">
                              <button type="submit"  style="margin-left:35%" name="update" value="Save"  class="btn green" /><i class="icon-question-sign"></i> Save Change</button>
                 </div>
								</div>
							</div>
						</td>
  <tr>
  </center>
</table>
      <?php
 }
       
                     