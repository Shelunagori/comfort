<?php
	require '../connection.php';
	include("excelwriter.inc.php");
	session_start();
	$name=$_SESSION['name'];
	$enrol=$_SESSION['enrol'];
	$branch=$_SESSION['branch'];
	$year=$_SESSION['year'];
	$sem=$_SESSION['sem'];
	$barcode=$_SESSION['barcode'];
	$room=$_SESSION['room'];
	
	$selen=mysql_query("select enrol_id from barcode_number where barcode='$barcode'");
	$arren=mysql_fetch_array($selen);
	$en_id=$arren['enrol_id'];
	
	$fileName = "data.xls";
	$excel = new ExcelWriter($fileName);
	
$databaseobject = new DatabaseConnect();
	
	if($excel==false)	
	{
		echo $excel->error;
		die;
	}
	
	if($_SESSION['sem']==$sem || $_SESSION['name']==$name || $_SESSION['year']==$year || $_SESSION['branch']==$branch  || $_SESSION['barcode']==$barcode  || $_SESSION['enrol']==$enrol  || $_SESSION['room']==$room);
			{
			$supplier_reg=array(
					"<b> Id </b>",
					"<b> Name </b>",
					"<b> Enrolment Number </b>",
					"<b> Year </b>",
					"<b> Semester </b>",
					"<b> Room Number </b>"
					
					);
	
		 $excel->writeLine($supplier_reg, array('text-align'=>'center', 'color'=> 'blue','font-size'=> '15px'));

	  if($_SESSION['room'] && $_SESSION['name'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['branch']  == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where room_number='$room' && name like '%$name
%' &&  year='$year' && enrol_number='$enrol' && semester='$sem' && barcode='$bacode' && branch_id='$branch'");
	 }
	 
			 //******************** 6 ************************  6 ******************************//

	  else if($_SESSION['name'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['branch']  == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name
%' &&  year='$year' && enrol_number='$enrol' && semester='$sem' && barcode='$bacode' && branch_id='$branch'");
	 }
	  else if($_SESSION['room'] && $_SESSION['name'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['branch']  == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where room_number='$room' && name like '%$name
%' &&  year='$year' && semester='$sem' && barcode='$bacode' && branch_id='$branch'");
	 }
	  else if($_SESSION['room'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['branch']  == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where room_number='$room' &&  year='$year' && enrol_number='$enrol' && semester='$sem' && barcode='$bacode' && branch_id='$branch'");
	 }
	
	
	 //******************** 5 ************************  5 ******************************//


	 else if($_SESSION['barcode'] && $_SESSION['name'] && $_SESSION['room'] && $_SESSION['year'] && $_SESSION['sem']  == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' && name like '%$name%' &&  year='$year' && room_number='$room' && semester='$sem'");
	 }
	 else if($_SESSION['barcode'] && $_SESSION['room'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem']  == true)
	 {
		$result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' && room_number='$room'
 &&  year='$year' && enrol_number='$enrol' && semester='$sem'");
	 }
	    else if($_SESSION['barcode'] && $_SESSION['name'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem']  == true)
	 {
		$result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' && name like '%$name%' && room_number='$room' &&  year='$year' && enrol_number='$enrol' && semester='$sem'");
	 }
	 else if($_SESSION['barcode'] && $_SESSION['room'] && $_SESSION['name'] && $_SESSION['branch'] && $_SESSION['sem']  == true)
	 {
		$result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' && room_number='$room'
 &&  name like '%$name%' && branch_id='$branch' && semester='$sem'");
	 }
	 //******************** 4 ************************  4 ******************************//


	  else if($_SESSION['name'] && $_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] == true)
	 {
		  $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year='$yr' &&  name like '%$name
%'' && enrol_number='$enrol' &&  semester='$seme'");
	 }
		 else if($_SESSION['name'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] == true)
	 {
		  $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year='$yr' &&  name like '%$name
%'' && barcode='$barcode' &&  semester='$seme'");
	 }
		 else if($_SESSION['name'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		  $result=$databaseobject->execute_query_return=mysql_query("select * from `dexambarcode` where barcode='$barcode' &&  name like '%$name
%'' && room_number='$room' &&  semester='$seme'");
	 }
	 		 else if($_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] && $_SESSION['room'] == true)
	 {
		$result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year='$yr' &&  room_number='$room' && enrol_number='$enrol' &&  semester='$seme'");
	 }
		 else if($_SESSION['enrol'] && $_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' &&  room_number='$room' && enrol_number='$enrol' &&  semester='$seme'");
	 }
	  else if($_SESSION['name'] && $_SESSION['branch'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		  $result=$databaseobject->execute_query_return=mysql_query("select * from `dexambarcode` where barcode='$barcode' &&  name like '%$name
%'' && room_number='$room' &&  branch_id='$branch'");
	 }
	  else if($_SESSION['enrol'] && $_SESSION['barnch'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' &&  room_number='$room' && enrol_number='$enrol' &&  branch_id='$branch'");
	 }
	 else if($_SESSION['year'] && $_SESSION['barnch'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode='$barcode' &&  room_number='$room' && year='$year' &&  branch_id='$branch'");
	 }
	
	 
	 	//******************** 3 ************************  3 ******************************//

	 
	  else if($_SESSION['name'] && $_SESSION['enrol'] && $_SESSION['year'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name
%' &&  year='$year' && enrol_number='$enrol'");
	 }
	  else if($_SESSION['enrol'] && $_SESSION['year'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where semester='$sem' &&  year='$year' && enrol_number='$enrol'");
	 }
	 	 else if($_SESSION['year'] && $_SESSION['sem'] && $_SESSION['barcode'] == true)
	 {
 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where semester='$sem' &&  year='$year' && barcode='$barcode'");	 }
	  else if($_SESSION['sem'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where semester='$sem' &&  barcode='$barcode' && room_number='$room'");
	 }	 
	  else if($_SESSION['name'] && $_SESSION['sem'] && $_SESSION['barcode'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  semester='$sem' && barcode='$barcode'");	 }
	  else if($_SESSION['name'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  barcode='$barcode' && room_number='$room'");
	 }
	   else if($_SESSION['enrol'] && $_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		  $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number='$enrol' &&  barcode='$barcode' && room_number='$room'");
	 }
	   else if($_SESSION['name'] && $_SESSION['branch'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  branch_id='$branch' && room_number='$room'");
	 }
     else if($_SESSION['enrol'] && $_SESSION['branch'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number='$enrol' &&  branch_id='$branch' && room_number='$room'");
	 }
	   else if($_SESSION['year'] && $_SESSION['branch'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year='$year' &&  branch_id='$branch' && room_number='$room'");
	 }
	   else if($_SESSION['sem'] && $_SESSION['branch'] && $_SESSION['room'] == true)
	 {
	 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where semester='$sem' &&  branch_id='$branch' && room_number='$room'");
	 }
	 	 
	 //******************** 2 ************************  2 ******************************
		

	 else if($_SESSION['name'] && $_SESSION['enrol'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  enrol_number='$enrol'");
	 }
	else if($_SESSION['name'] && $_SESSION['year'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  year='$year'");
	 }
	 else if($_SESSION['name'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  semester='$sem'");
	 }
	 else if($_SESSION['name'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  barcode='$barcode'");
	 }
	  else if($_SESSION['name'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  room_number='$room'");
	 }
	 
	 else if($_SESSION['enrol'] && $_SESSION['year'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number=$enrol &&  year='$year'");
	 }
	 else if($_SESSION['enrol'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number=$enrol &&  semester='$sem'");
	 }
	 else if($_SESSION['enrol'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number=$enrol &&  barcode='$barcode'");
	 }
	  else if($_SESSION['enrol'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number=$enrol &&  room_number='$room'");
	 }
	 else if($_SESSION['name'] && $_SESSION['branch'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  branch_id='$branch'");
	 }
	  else if($_SESSION['branch'] && $_SESSION['enrol'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch' &&  enrol_number='$enrol'");
	 }
	else if($_SESSION['branch'] && $_SESSION['year'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch' &&  year='$year'");
	 }
	 else if($_SESSION['branch'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch' &&  semester='$sem'");
	 }
	 else if($_SESSION['branch'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch' &&  barcode='$barcode'");
	 }
	  else if($_SESSION['branch'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch' &&  room_number='$room'");
	 }
/* 	 else if($_SESSION['name'] && $_SESSION['sub'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%' &&  subject_code='$sub'");
	 }
	  else if($_SESSION['branch'] && $_SESSION['sub'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch='$branch' &&  subject_code='$sub'");
	 }
	else if($_SESSION['sub'] && $_SESSION['enrol'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where subject_code='$sub' &&  enrol_number='$enrol'");
	 }
	else if($_SESSION['sub'] && $_SESSION['year'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where subject_code='$sub' &&  year='$year'");
	 }
	 else if($_SESSION['sub'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where subject_code='$sub' &&  semester='$sem'");
	 }
	 else if($_SESSION['sub'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where subject_code='$sub' &&  barcode='$barcode'");
	 }
	  else if($_SESSION['sub'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where subject_code='$sub' &&  room_number='$room'");
	 }*/
	 	 elseif($_SESSION['year'] && $_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year=$year &&  semester='$sem'");
	 }
	 else if($_SESSION['year'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year=$year &&  barcode='$barcode'");
	 }
	  else if($_SESSION['year'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year=$year &&  room_number='$room'");
	 }
	 
	 else if($_SESSION['sem'] && $_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode=$barcode &&  semester='$sem'");
	 }
	  else if($_SESSION['sem'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode=$barcode &&  semester='$sem'");
	 }
	 else if($_SESSION['barcode'] && $_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where barcode=$barcode &&  room_number='$room'");
	 }
	 

//******************** 1 ************************  1 ******************************8

	 else if($name)
	 {
		$result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where name like '%$name%'");
	 }
     else if($enrol)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where enrol_number='$enrol'");
	 }
	 else if($branch)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where branch_id='$branch'");
	 }
	 else if($year)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where year='$year'");
	 }
	 else if($_SESSION['sem'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where semester='$sem'");
	 }
	 else if($_SESSION['barcode'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where id='$en_id'");
	 }
	  else if($_SESSION['room'] == true)
	 {
		 $result=$databaseobject->execute_query_return=mysql_query("select * from `exambarcode` where room_number='$room'");
	 }
				
	

		if(mysql_num_rows($result)>0)
				{
					while($row = mysql_fetch_array($result))
					{
						$array = array();
						for ($i = 0; $i <=5; $i++) 
						{
								$array[]=$row[$i];
						}
						$excel->writeLine($array, array('text-align'=>'center'));
					}
				
			}
			
			$databaseobject->close_connection();
		
				}
		
	
	
	$excel->close();
	echo "Data written to file $fileName Successfully.";

	readfile($fileName);
?>
<br />
Click <a href="data.xls" >Here </a> to download File..

