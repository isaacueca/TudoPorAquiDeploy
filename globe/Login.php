<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("BNY");
 
$query = "SELECT id from user where login = '".$_GET['login']."' and password = '".$_GET['password']."' ";
$result = mysql_query($query, $mysql_access);

while($row = mysql_fetch_row($result))
  {
	  
	  echo $row[0];
  }


?>