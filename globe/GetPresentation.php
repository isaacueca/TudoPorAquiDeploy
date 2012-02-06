<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "SELECT title, style, date, count(presentationid) as contador from presentation left join presentationlocation on presentation.id = presentationlocation.presentationid group by presentationid ";
$result = mysql_query($query, $mysql_access);

echo "{";
$i=1;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 1) echo ",";
		echo "\"".$i."\":{";
		//echo "\"id\":\"".$row[0]."\",";
		echo "\"title\":\"".$row[0]."\",";
		echo "\"style\":\"".$row[1]."\",";
		echo "\"contador\":\"".$row[3]."\",";
		//echo "\"featured\":\"".$row[2]."\",";
		echo "\"date\":\"".$row[2]."\"";
		echo "}"; 
		$i++;
  }
echo "}";

?>