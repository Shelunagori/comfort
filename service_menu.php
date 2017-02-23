<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
if(isset($_GET['idd']) && isset($_GET['delete_service']))
{
	$query = mysql_query("delete from service where id='".$_GET['idd']."'");
	if($query)
	echo '<script>
	alert("Service Deleted Successfully.");
	location="service_menu.php?mode=view";
	</script>';
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
     <?php temp(); ?>
    	<?php
		if(isset($_GET['mode']))
		{
		 if($_GET['mode']=='view')
			{
				?>
                <form  name="form_name" action="Handler.php" class="form-horizontal"  method="post"> 
                <div class="portlet box yellow">
                <div class="portlet-title">
                <h4><i class="icon-table"></i>Service</h4>
                </div>
                <div class="portlet-body form">	
                		<table width="100%"  class="table table-condensed table-hover" style="border-collapse:collapse;">
                    	<thead>
                        <tr>
                        <th>SL.</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Edit|Delete</th>
                        </tr>
                  		</thead>
                    	<tbody>
<?php 
                        $result=mysql_query("select * from service");
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {$i++;
                        	$idd=$row['id'];
							$name=$row['name'];
							$type=$row['type'];
                     ?>
                            <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $name;?></td>
                            <td><?php echo $type;?></td>
                           	<td><a class="btn mini yellow tooltips" data-toggle="modal"  role="button" data-placement="top" title="Edit Service"  href="#myModal_first<?php echo $i; ?>"  style="text-decoration:none;">
    							<i class="icon-edit"></i></a>
                                
                                   <div style="display: none;" id="myModal_first<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#FFB848"><i class="icon-edit"></i> <b>Edit <?php echo $name; ?></b></span></h4>
                                    </div>
                                   <div class="modal-body">
                                   
                                <div class="control-group">
                                <label class="control-label">Service Name</label>
                                <div class="controls">
                                <input type="text"  name="s_name<?php echo $i; ?>"   class="span6 m-wrap" value="<?php echo $name; ?>" >
                                </div>
                                </div>  
                                
                                <div class="control-group">
                                <label class="control-label">Service Type</label>
                                <div class="controls">
                                <select name="s_type<?php echo $i; ?>"  class="m-wrap large" placeholder="Service Name">
                                <option value="">---select type---</option>
                                <option value="intercity" <?php if($type=='intercity') { ?> selected <?php } ?>>Intercity</option>
                                <option value="incity"  <?php if($type=='incity') { ?> selected <?php } ?>>Incity</option>
                                </select>
                                </div>
                                </div>  
                                <input type="hidden" name="service_id<?php echo $i; ?>" value="<?php echo $idd; ?>" />
                                </div>
                                
                                
                                <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                <button type="submit" name="update_service<?php echo $i; ?>" class="btn yellow"><i class="icon-question-sign"></i> Save Change</button>
                                </div>
                                   
                                </div>
                                
                                
                                
                                <a class="btn mini red tooltips" data-placement="bottom" title="Delete Service" href="#myModal_second<?php echo $i; ?>"  role="button" data-toggle="modal" style="text-decoration:none;">
    							<i class="icon-trash"></i></a>
                                
                                  <div style="display: none;" id="myModal_second<?php echo $i; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 id="myModalLabel1"><span style="color:#EE5F5B"><i class="icon-trash"></i> <b><?php echo $name; ?></b></span></h4>
                                    </div>
                                  <!--  <div class="modal-body">
                                    </div>-->
                                    <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>	
                                   <a type="submit"  href='service_menu.php?delete_service=true&idd=<?php echo $idd;?>' id="refresh" class="btn red"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                    </div>
							</td></tr> 	
                        <?php
                        }
                        }
					?>
                     </tbody>
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
        <form  name="form_name" action="Handler.php" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Service</h4>
        </div>
        <div class="portlet-body form">
       
       	<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
       
 	    <div class="control-group">
        <label class="control-label">Service Name</label>
        <div class="controls">
        <input type="text" name="name"  class="span6 m-wrap" />
        </div>
        </div>  
        
	    <div class="control-group">
        <label class="control-label">Service Type</label>
        <div class="controls">
        <select  name="type"  class="span6 m-wrap" >
        <option value="">---select type---</option>
        <option value="intercity">Intercity</option>
        <option value="incity">Incity</option>
        </select>
        </div>
        </div>
        
        </table>
        
        <div class="form-actions">
        <button type="submit"   class="btn green" name="service_reg"/><i class="icon-ok"></i> Submit</button>
        </div>
        </div>
        </div> 
        </form>
        <?php	
		}
		?>
        </div>
        </div>
        </div>
   <!-- BEGIN FOOTER -->
   
<div class="footer">
<?php footer();?>
</div>
<?php js(); ?> 
<?php autocomplete(); ?>
   <!-- END JAVASCRIPTS -->   
</body>
<!-- END BODY -->
</html>