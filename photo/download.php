<?php
   $key = $_GET["id"];
   $mysql_access = mysql_connect("localhost", "root", "cigano");
   mysql_select_db ("PrivatePhoto");
   $query = "SELECT photoid FROM `PrivatePhoto`.`URLKey` WHERE `key` = '".$key."'";
   $result = mysql_query($query, $mysql_access);
   

while($row = mysql_fetch_array($result))
  {
  $photoid = $row['photoid'].".png";
  }

mysql_close($con);

   if(isset($photoid) && file_exists($photoid)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
      switch(strtolower(substr(strrchr(basename($key),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
         case "pdf": $tipo="application/pdf"; break;
         case "exe": $tipo="application/octet-stream"; break;
         case "zip": $tipo="application/zip"; break;
         case "doc": $tipo="application/msword"; break;
         case "xls": $tipo="application/vnd.ms-excel"; break;
         case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
         case "gif": $tipo="image/gif"; break;
         case "png": $tipo="image/png"; break;
         case "jpg": $tipo="image/jpg"; break;
         case "mp3": $tipo="audio/mpeg"; break;
         case "php": // deixar vazio por seurança
         case "htm": // deixar vazio por seurança
         case "html": // deixar vazio por seurança
      }
      //header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
      //header("Content-Length: ".filesize($photoid)); // informa o tamanho do arquivo ao navegador
      //header("Content-Disposition: attachment; filename=".basename($photoid)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
      
	header ('Content-length: ' .filesize($image_file));
	header ('Content-type: image/jpeg');
	readfile($photoid); // lê o arquivo
      exit; // aborta pós-ações 
   }
?>
