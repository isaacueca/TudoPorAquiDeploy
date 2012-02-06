<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("UNFCU");
 
$query = "SELECT ID, QuestionText, PhotoQuestion FROM `question` order by PhotoQuestion";
$result = mysql_query($query, $mysql_access);

echo "{";
$i=0;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 0) echo ",";
		echo "\"".$i."\":{";
		echo "\"ID\":\"".$row[0]."\",";
		echo "\"QuestionText\":\"".$row[1]."\",";
		echo "\"PhotoQuestion\":\"".$row[2]."\",";
	    echo "}"; 
		$i++;
  }
echo "}";


?>