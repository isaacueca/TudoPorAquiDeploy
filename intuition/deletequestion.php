<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("LogicDiner");
$query = "update IntQuestion set deleted = 1 where id=".$_GET['id'];
mysql_query($query, $mysql_access);

header('Location:http://tudoporaqui.com.br/intuition/showquestion.php');
?>