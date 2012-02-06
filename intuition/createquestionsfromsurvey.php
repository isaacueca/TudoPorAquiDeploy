<?php
//delete FROM `IntuitionSurvey2` WHERE questiontext like '%if any%'
//delete answer = 'None'

$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("Intuition");

$query = "select * from IntuitionSurvey2;";

$result = mysql_query($query, $mysql_access);
   $x=0;
   while($row = mysql_fetch_row($result))
  {
	        $i = 0;
			unset($ans);
			unset($votes);
			$query2 = "select * from IntuitionAnswer2 where QuestionID='".$row[0]."';";
			$result2 = mysql_query($query2, $mysql_access);
			while($row2 = mysql_fetch_row($result2))
			  {
				$ans[$i]=$row2[1];
				$votes[$i]=$row2[2];
				$i++;
			  }



			$sort[0] = "";
			$sort[1] = rand(0,count($ans));
			while ($ans[$sort[1]] == "") $sort[1] = rand(0,count($ans));
			$sort[2] = rand(0,count($ans));
			while (($ans[$sort[2]] == "") || ($sort[2] == $sort[1])) $sort[2] = rand(0,count($ans));
			$sort[3] = rand(0,count($ans));
			while (($ans[$sort[3]] == "") || ($sort[3] == $sort[1]) || ($sort[3] == $sort[2])) $sort[3] = rand(0,count($ans));
			$sort[4] = rand(0,count($ans));
			while (($ans[$sort[4]] == "") || ($sort[4] == $sort[1]) || ($sort[4] == $sort[2]) || ($sort[4] == $sort[3])) $sort[4] = rand(0,count($ans));
			$sort[5] = rand(0,count($ans));
			while (($ans[$sort[5]] == "") || ($sort[5] == $sort[1]) || ($sort[5] == $sort[2]) || ($sort[5] == $sort[3]) || ($sort[5] == $sort[4])) $sort[5] = rand(0,count($ans));
			$sort[6] = rand(0,count($ans));
			while (($ans[$sort[6]] == "") || ($sort[6] == $sort[1]) || ($sort[6] == $sort[2]) || ($sort[6] == $sort[3]) || ($sort[6] == $sort[4]) || ($sort[6] == $sort[5])) $sort[6] = rand(0,count($ans));

			 $query2 = "insert into intuition values (null,'".str_replace("'", "''", $row[1])."',".$row[6].",1,'".$row[4]."',".$row[0].",1,'".$ans[$sort[1]]."','".$ans[$sort[2]]."','".$ans[$sort[3]]."','".$ans[$sort[4]]."','".$ans[$sort[5]]."','".$ans[$sort[6]]."',0,0,0,0,0,0,".$votes[$sort[1]].",".$votes[$sort[2]].",".$votes[$sort[3]].",".$votes[$sort[4]].",".$votes[$sort[5]].",".$votes[$sort[6]].")";
			 
			 //echo $query2;
			 $x++;
			 //if ($x==10) exit;
			 mysql_query($query2, $mysql_access);




  }




  

?>

