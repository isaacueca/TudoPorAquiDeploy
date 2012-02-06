<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("UNFCU");
 
$query = "insert into user values(null,'".$_GET['FacebookID']."','".$_GET['FirstName']."','".$_GET['LastName']."','".$_GET['Address1']."','".$_GET['Address2']."','".$_GET['PostalCode']."','".$_GET['State']."','".$_GET['Country']."','".$_GET['Email']."','".$_GET['Phone']."'); ";
mysql_query($query, $mysql_access);

$result = mysql_query("SELECT LAST_INSERT_ID();", $mysql_access);
$row = mysql_fetch_row($result);
echo $row[0];

?>