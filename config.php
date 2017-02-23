<?php
error_reporting(0);
ini_set('display_errors', 0);
date_default_timezone_set('asia/kolkata');
//ini_set('max_execution_time', 100000);
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName ='sbcomfort';
$con = @mysql_connect($dbHost, $dbUser, $dbPass) or die('Error Connecting to MySQL DataBase' .mysql_error());
@mysql_select_db($dbName,$con);
?>