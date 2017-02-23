<?php
require_once ("config.php");
require_once("function.php");
require_once("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Comfort | Backup</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
  <?php css(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php navi_bar(); ?>
   <div class="page-container row-fluid">
      <!-- END SIDEBAR -->
      <?php navi_menu(); ?>
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <div class="container-fluid">
     <?php menu(); ?>
     	<div class="row-fluid">
         <?php
backup_tables($dbHost,$dbUser,$dbPass,$dbName);
/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

    $link = mysql_connect($host,$user,$pass);
    mysql_select_db($name,$link);
   
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while($row = mysql_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
   
    //cycle through
    foreach($tables as $table)
    {
        $result = mysql_query('SELECT * FROM '.$table);
         $num_fields = mysql_num_fields($result);
        //$return.= 'DROP TABLE '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
       
        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = mysql_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++)
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }   
    $file_name='Comfort-db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
    //save file
    $handle = fopen($file_name,'w+');
   
    fwrite($handle,$return);
   
    fclose($handle);

?>
<div id="txt"></div>
<br/>
<a  href="<?php echo $file_name; ?>" class="btn green" id="filename" download="<?php echo $name; ?>.sql"><i class="icon-download-alt"></i> Click here for download database.</a>
<?php
}
?>

<script src="assets/js/jquery-1.8.3.min.js"></script>
<script>
$(document).ready(function() {
var typingTimer;                //timer identifier
var doneTypingInterval = 2000;  //time in ms, 5 second for example

$('#filename').click(function(){
   clearTimeout(typingTimer);
    if ($('#filename').val) {
         typingTimer = setTimeout(function(){
            //do stuff here e.g ajax call etc....
        
           var file_name=$("#filename").attr("href");
          
             query="?file_name="+file_name;
           $('#txt').load('unlink_backup_file.php'+query);
          
       }, doneTypingInterval);
    }
});


});

</script>
	<div class="clearfix"></div>
     
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