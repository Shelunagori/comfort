<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
if(isset($_GET['id']) && isset($_GET['delete_bank']))
{
	$query = mysql_query("delete from bank_reg where id='".$_GET['id']."'");
	if($query)
	echo '<script>
	alert("Bank Deleted Successfully.");
	location="bank_menu.php?mode=view";
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
                        <div class="portlet box yellow" >
                        <div class="portlet-title">
                        <h4><i class="icon-edit"></i>Bank View</h4>
                        </div>
                        <div class="portlet-body form">
                       <table width="100%"  class="table table-condensed table-hover" style="border-collapse:collapse;">
                    	<thead>
                        <tr>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Account Number</th>
                        <th>Code</th>
                        <th>Delete</th>
                        </tr>
                    </thead>
                    	<tbody>
<?php 
                        $qry="select * from bank_reg";
                        $result=mysql_query($qry);
                        if($result)
                        {
                        while($row=mysql_fetch_array($result))
                        {
                        	$idd=$row['id'];
							$name=$row['name'];
							$branch=$row['branch'];
							$accno=$row['accno'];
							$code=$row['code'];
                     ?>
                            <tr>
                            <td><?php echo $name;?></td>
                            <td><?php echo $branch;?></td>
                            <td><?php echo $accno;?></td>
                            <td><?php echo $code;?></td>
                           	<td><a class="btn mini red"  role="button"  href="bank_menu.php?delete_bank=true&id=<?php echo $idd;?>" style="text-decoration:none;">
    							<i class="icon-trash"></i></a></td></tr> 	
                        <?php
                        }
                        }
					?>
                     </tbody>
                    </table>
                        </form>
                        </div>
                        </div>
                 <?php
				}
		}
		else
		{
		?>
        <form  name="form_name" action="Handler.php" class="form-horizontal"  method="post">
        <div class="portlet box blue">
        <div class="portlet-title">
        <h4><i class="icon-plus"></i>Bank</h4>
        </div>
        <div class="portlet-body form">
         <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
         
            
        <div class="control-group">
        <label class="control-label">Bank Name</label>
        <div class="controls">
       <input type="text" name="name"  class="span6 m-wrap" />
        </div>
        </div>    
         
        <div class="control-group">
        <label class="control-label">Branch Name</label>
        <div class="controls">
        <input type="text" name="branch"    class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Account Number</label>
        <div class="controls">
        <input type="text" name="accno"  class="span6 m-wrap" />
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Code</label>
        <div class="controls">
        <input type="text" name="code"  class="span6 m-wrap" />
        </div>
        </div>  
        
         
        <div class="control-group">
        <label class="control-label">IFSC Code</label>
        <div class="controls">
        <input type="text" name="ifsccode"   id="extra_hour_rate" class="span6 m-wrap" />
        </div>
        </div>  
        
        </table>
        <div class="form-actions">
        <button type="submit"   class="btn green" name="bank_reg"/><i class="icon-ok"></i> Submit</button>
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