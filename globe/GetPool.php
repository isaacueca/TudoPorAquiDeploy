<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "SELECT * from pool where presentationID = '".$_GET['id']."' ";
$result = mysql_query($query, $mysql_access);

echo "{";
$i=1;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 1) echo ",";
		echo "\"".$i."\":{";
		echo "\"question\":\"".$row[0]."\",";
		echo "\"answer1\":\"".$row[1]."\",";
		echo "\"answer2\":\"".$row[2]."\",";
		echo "\"answer3\":\"".$row[3]."\"";
		echo "\"answer4\":\"".$row[4]."\"";
		echo "\"answer5\":\"".$row[5]."\"";
		echo "\"answer6\":\"".$row[6]."\"";
		echo "}"; 
		$i++;
  }
echo "}";

?>