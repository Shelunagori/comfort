<?php
		$connection=mysql_connect('localhost','root');
		mysql_select_db('comfort',$connection);
		//if(mysql_query($query,$connection))
		//{
		 	$today_date = date('Y-m-d');
			$result=mysql_query("select id from booking where travel_from<= '".$today_date."' and  travel_to>='".$today_date."' and booked_by='Ankit'");
			if(mysql_num_rows($result)!=0)
			{
				while($row= mysql_fetch_array($result))
				{
					echo "\$id=".$row['id']."<br />";
				}
			}
			
			mysql_close($connection);
?>