<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "SELECT *  FROM `presentation` where userID = '1' ";
$result = mysql_query($query, $mysql_access);

echo "{";
$i=1;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 1) echo ",";
		echo "\"".$i."\":{";
		echo "\"latitude\":\"".$row[0]."\",";
		echo "\"longitude\":\"".$row[1]."\",";
		echo "\"country\":\"".$row[2]."\",";
		echo "\"location\":\"".$row[3]."\",";
		echo "\"file\":\"".$row[4]."\"";
		echo "}"; 
		$i++;
  }
echo "}";

?>