<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("LogicDiner");
 
$query = "select * from IntQuestion where Deleted = 0 order by rand() limit 30";
$result = mysql_query($query, $mysql_access);
echo "{\"records\":[";
$i=0;
while($row = mysql_fetch_row($result))
  {
	    if ($i != 0) echo ",";
		echo "{";
		echo "\"id\":\"".$row[0]."\",";
		echo "\"question\":\"".removebadcharacters($row[1])."\",";
		echo "\"totalviews\":\"".$row[2]."\",";
		echo "\"totalviewsfake\":\"".$row[3]."\",";
		echo "\"quality\":\"".$row[4]."\",";
		echo "\"category\":\"".$row[5]."\",";
		echo "\"questionid\":\"".$row[6]."\",";
		echo "\"source\":\"".$row[7]."\",";
		echo "\"status\":\"".$row[8]."\",";
		echo "\"answer1\":\"".$row[9]."\",";
		echo "\"answer2\":\"".removebadcharacters($row[10])."\",";
		echo "\"answer3\":\"".removebadcharacters($row[11])."\",";
		echo "\"answer4\":\"".removebadcharacters($row[12])."\",";
		echo "\"answer5\":\"".removebadcharacters($row[13])."\",";
		echo "\"answer6\":\"".removebadcharacters($row[14])."\",";
		echo "\"qtanswer1\":\"".($row[15] + $row[20])."\",";
		echo "\"qtanswer2\":\"".($row[16] + $row[21])."\",";
		echo "\"qtanswer3\":\"".($row[17] + $row[22])."\",";
		echo "\"qtanswer4\":\"".($row[18] + $row[23])."\",";
		echo "\"qtanswer5\":\"".($row[19] + $row[24])."\",";
		echo "\"qtanswer6\":\"".($row[20] + $row[25])."\"";
		echo "}";
		$i++;

  }
 echo "]}";


 function removebadcharacters($var){
	$var = str_replace("\n","",$var);
	$var = str_replace("\"","'",$var);
	return $var;
 }



?>