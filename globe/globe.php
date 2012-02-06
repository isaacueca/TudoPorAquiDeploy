<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "select * from location ";
$result = mysql_query($query, $mysql_access);

echo "{";
$i=0;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 0) echo ",";
		echo "\"".$row[0]."\":{";
		echo "\"latitude\":\"".$row[1]."\",";
		echo "\"longitude\":\"".$row[2]."\",";
		echo "\"country\":\"".$row[3]."\",";
		echo "\"location\":\"".$row[4]."\"";
		echo "}"; 
		$i++;
  }
echo "}";


?>