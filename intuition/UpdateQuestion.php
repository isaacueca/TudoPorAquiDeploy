<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("LogicDiner");
$query = "update IntQuestion set Status=1, Answer1='".urldecode($_GET['answer1'])."',Answer2='".urldecode($_GET['answer2'])."',Answer3='".urldecode($_GET['answer3'])."',Answer4='".urldecode($_GET['answer4'])."',Answer5='".urldecode($_GET['answer5'])."',Answer6='".urldecode($_GET['answer6'])."',Question='".urldecode($_GET['question'])."' where ID=".$_GET['id'];
mysql_query($query, $mysql_access);

header('Location:http://tudoporaqui.com.br/intuition/showquestion.php');
?>