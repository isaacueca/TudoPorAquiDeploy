<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("UNFCU");



//echo $_GET['facebookid']; 

$query = "SELECT * FROM `user` where facebookID = '".$_GET['facebookid']."'";
$result = mysql_query($query, $mysql_access);
$num_rows = mysql_num_rows($result);
if ($num_rows > 0) echo "1"; else echo "0";
?>