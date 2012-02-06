<?php
// Nas versões do PHP anteriores a 4.1.0, deve ser usado $HTTP_POST_FILES
// ao invés de $_FILES.

$uploaddir = '/var/www/tudoporaqui/photo/';
$uploadfile = $uploaddir . $_FILES['userfile']['name'];

$key = rand();
$photoid = rand();
$minutes = 231123;
$message = "fuck you";


print "<pre>";
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploaddir . $photoid.".png")) {
    print "Upload efetuado com sucesso";
    //print_r($_FILES);
} else {
    print "Erro ao fazer upload";
    //print_r($_FILES);
}
print "</pre>";


$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("PrivatePhoto");





$query = "INSERT INTO `PrivatePhoto`.`URLKey` (";
$query .= "`key` ,";
$query .= "`photoid` ,";
$query .= "`minutes` ,";
$query .= "`message` ,";
$query .= "`started` ,";
$query .= "`end`";
$query .= ")";
$query .= "VALUES (";
$query .= "'".$key."','".$photoid."','".$minutes."','".$message."', NULL , NULL";
$query .= ");";


mysql_query($query, $mysql_access);


mysql_close($con);
?>
