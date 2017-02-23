<?php 
require_once("config.php");
require_once("function.php");
require_once("auth.php");
require_once("myscript.php");
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
<script>
function my_reading()
{
 var op_km=eval(document.getElementById("opening_km").value);
 var cl_km=eval(document.getElementById("closing_km").value);
if(op_km>cl_km)
{
alert("Closing KM. must be greater than Opening KM.");	
document.getElementById("closing_km").value='';}
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
     <?php temp(); ?>
     <?php
	 if(isset($_GET['mode']))
	 {
		 if(isset($_POST['fuel_edit']))
		 {             
			 				$q1=""; $q2="";
			 				if(!empty($_POST['car_id']))
							{
							$car_id=$_POST['car_id'];
							$q1=" `car_id` = '".$car_id."' ";
							}
							if(!empty($_POST['date_from']) && !empty($_POST['date_to']))
							{
								if($q1=="")
								{
									$q2=" `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
								}
								else
								{
									$q2=" AND `date` between '".datefordb($_POST['date_from'])."' and '".datefordb($_POST['date_to'])."' ";
								}
							}
							if($q1=="" && $q2=="")
							$qry ="select * from `fuel` ";
							else 
							$qry="select * from `fuel` where ";
							$sql=$qry.$q1.$q2;
 							$result=mysql_query($sql);
							if($result)
							{
              
			 ?>
            <div class="portlet box yellow">
            <div class="portlet-title">
            <h4><i class="icon-edit"></i>Fuel Edit</h4>
            </div>
            <div class="portlet-body form">
                
                <div style="width:100%; overflow-x:scroll; overflow-y:hidden; margin:10px!important">
                <table width="100%" class="table table-bordered table-hover" id="sample_1" style="border-collapse:collapse; ">
                <thead>
                    <tr>
                    <th >S. No.</th>
                    <th >Supplier Name</th>
                    <th >Date</th>
                    <th >Car Number</th>
                    <th >Previous Reading</th>
                    <th >Current Reading</th>
                    <th >Fuel Qty</th>
                    <th >Fuel Amount</th>
                    <th >Edit</th>
                    </tr>
                </thead>
                <tbody>
                 <?php           
                    while($row=mysql_fetch_array($result))
                    {
						$i++;
                   ?>
                        <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo fetchsuppliername($row['supplier_id']);?></td>
                        <td><?php echo dateforview($row['date']);?></td>
                        <td><?php echo fetchcarno($row['car_id']);?></td>
                        <td><?php echo $row['opening_km'];?></td>
                        <td><?php echo $row['closing_km'];?></td>
                        <td><?php echo $row['fuel_qty'];?></td>
                        <td><?php echo $row['fuel_amount'];?></td>
                        <td><a href="update_fuel.php?id=<?php echo $row['id'];?>" class="btn mini red" style="text-decoration:none;" target="_blank"><i class="icon-edit"></i></a></td>
                        </tr>
                    <?php
                    }
                ?>
                  </tbody>
                  </table> 
                  <?php
					}
				?>
                 </div>
                 
                </div>
                </div> 
             <?php
		 }
		 else if($_GET['mode']=='edit')
		 {
			 ?>
           <form method="post" class="form-horizontal" name="add_form">
          
            <div class="portlet box yellow">
            <div class="portlet-title">
            <h4><i class="icon-edit"></i>Fuel Edit</h4>
            </div>
            <div class="portlet-body form">
          
            <div class="control-group">
            <label class="control-label">Car No.</label>
            <div class="controls">
            <select name="car_id" class="span6 m-wrap chosen" onChange="fetch_reading(this.value);" >	
            <option value="">---select car---</option>
            <?php 
            $result= mysql_query("select distinct `id`,`name` from car_reg");
            while($row=mysql_fetch_array($result))
            {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            }
            ?>
            </select>
            </div>
            </div>   
            
            <div class="control-group">
            <label class="control-label">Date From</label>
            <div class="controls">
            <input type="text" name="date_from" class="span6 m-wrap date-picker" onClick="mydatepick();"/>
            </div>
            </div>    
            
            <div class="control-group">
            <label class="control-label">Date To</label>
            <div class="controls">
            <input type="text" name="date_to" class="span6 m-wrap date-picker" onClick="mydatepick();"/>
            </div>
            </div>    
              
            <div class="form-actions">
            <button type="submit"   class="btn green" name="fuel_edit"/><i class="icon-ok"></i> Submit</button>
            <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
            </div>
             
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
        <h4><i class="icon-plus"></i> Fuel</h4>
        </div>
        <div class="portlet-body form">
         
        <div class="control-group">
        <label class="control-label">Supplier Name</label>
        <div class="controls">
        <?php
		$res_supp_id=mysql_query("select distinct `id` from `supplier_type` where `name`='Fuel'");
		$row_supp_id=mysql_fetch_array($res_supp_id);
		?>
        <select name="supplier_id" class="span6 m-wrap chosen" >	
        <option value="">---select supplier---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from supplier_reg where `supplier_type_id`='".$row_supp_id['id']."'");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>
        
        <div class="control-group">
        <label class="control-label">Date</label>
        <div class="controls">
        <input type="text" name="date" class="span6 m-wrap date-picker" onClick="mydatepick();"/>
        </div>
        </div>    
        
        <div class="control-group">
        <label class="control-label">Car No.</label>
        <div class="controls">
        <select name="car_id" class="span6 m-wrap chosen" onChange="fetch_reading(this.value);" >	
	    <option value="">---select car---</option>
        <?php 
        $result= mysql_query("select distinct `id`,`name` from car_reg");
        while($row=mysql_fetch_array($result))
        {
        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        ?>
        </select>
        </div>
        </div>   
                     
        <div class="control-group">
        <label class="control-label"> Previous Reading</label>
        <div class="controls">
        <input type="text"  id="opening_km" name="opening_km" readonly class="span6 m-wrap" />
        </div>
        </div>    

		<div class="control-group">
        <label class="control-label"> Current Reading</label>
        <div class="controls">
        <input type="text" id="closing_km" name="closing_km" autocomplete="off" onKeyUp="allLetter(this.value,this.id)" onBlur="my_reading();"  class="span6 m-wrap" />
        </div>
        </div>  
        
		<div class="control-group">
        <label class="control-label">Fuel Type</label>
        <div class="controls">
        <select name="fuel_type" class="span6 m-wrap" required onChange="fetch_price(this.value);">	
	    <option value="">---select fuel type---</option>
        <option value="Petrol">Petrol</option>
        <option value="Diesel">Diesel</option>
        </select>
        </div>
        </div> 
        
          
        <div class="control-group">
        <label class="control-label">Price (Rs)</label>
        <div class="controls"  id="price_place">
        </div>
        </div> 
        
        <div class="control-group">
        <label class="control-label">Fuel Amount.</label>
        <div class="controls">
        <input type="text" name="fuel_amount" id="fuel_amount" autocomplete="off" onKeyUp="allLetter(this.value,this.id)" class="span6 m-wrap" >	
        </div>
        </div> 
        
        <div class="control-group">
        <label class="control-label">Remarks</label>
        <div class="controls">
        <input type="text" name="remarks" class="span6 m-wrap" >	
        </div>
        </div> 
        
        
        <div class="form-actions">
        <button type="submit"   class="btn green" name="fuel_reg"/><i class="icon-ok"></i> Submit</button>
        <button type="reset"   class="btn yellow" /><i class="icon-retweet"></i> Reset</button>
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