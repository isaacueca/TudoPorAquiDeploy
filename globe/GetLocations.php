<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "SELECT location.latitude, location.longitude, location FROM `presentationlocation` inner join location on location.ID = presentationlocation.locationID WHERE presentationlocation.presentationID = ".$_GET['id'];
$result = mysql_query($query, $mysql_access);

echo "{";
$i=0;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 0) echo ",";
		echo "\"".$i."\":{";
		echo "\"latitude\":\"".$row[0]."\",";
		echo "\"longitude\":\"".$row[1]."\",";
		echo "\"location\":\"".$row[2]."\"";
		echo "}"; 
		$i++;
  }
echo "}";


?>