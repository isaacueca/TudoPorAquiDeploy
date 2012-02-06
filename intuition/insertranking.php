<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("LogicDiner");
$query = "Select ID from Users where FirstName = '".$_GET['name']."'";
$result = mysql_query($query, $mysql_access);
$row = mysql_fetch_row($result);

if ($row[0]=="") {
	$query = "insert into Users(ID,FirstName) values(null,'".$_GET['name']."');";
	mysql_query($query, $mysql_access);
	$query = "insert into Score(GameID, LevelID, UserID, ScoreAll) values(1,0,".mysql_insert_id().",".$_GET['score'].")";
	mysql_query($query, $mysql_access);
	$query = "insert into IntAnswer values(".$_GET['questionid'].",".mysql_insert_id().",".$_GET['answer'].")";
	mysql_query($query, $mysql_access);
}
else {
	$query = "Select ScoreAll from Score where UserID=".$row[0];
	$result = mysql_query($query, $mysql_access);
	$rowscore = mysql_fetch_row($result);
	if (intval($rowscore[0]) < intval($_GET['score'])){
		$query = "Update Score set ScoreAll = ".$_GET['score']." where UserID=".$row[0];
		$result = mysql_query($query, $mysql_access);
	}
	$query = "insert into IntAnswer values(".$_GET['questionid'].",".$row[0].",".$_GET['answer'].")";
	mysql_query($query, $mysql_access);
}
//echo $query;
header('Location:http://tudoporaqui.com.br/intuition/showquestion.php');
?>