<?php

$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("tudoporaqui");


$question1 = "What is your favorite XXX?";
$question2 = "Pick a XXX:";
$question3 = "What XXX do you prefer?";
$question4 = "Pick a XXX you hate?";
$question5 = "What is the worst XXX?";
$question6 = "What XXX do you like best?";
$question7 = "Pick an item bellow:";
$question8 = "Pick the most important XXX?";
$question10 = "What is the most popular XXX?";
$question11 = "What is the healthiest XXX?";
$question12 = "Pick the most beautiful XXX?";
$question13 = "What is the most adorable XXX?";
$question14 = "Pick the ugliest XXX?";
$question15 = "Pick a elegant XXX?";
$question16 = "What is the most perfect XXX?";
$question17 = "What is the cleanest XXX?";
$question18 = "What is the most famous XXX?";
$question19 = "Pick a powerfull XXX:";
$question21 = "Pick a clever XXX:";
$question22 = "Pick a nice XXX:";
$question23 = "What XXX would make you happy?";
$question24 = "What is the scariest XXX?";
$question25 = "Pick the oddest XXX:";
$question26 = "Pick a good XXX:";
$question27 = "Pick a terrible XXX:";
$question28 = "Pick a bad XXX:";
$question29 = "Pick a strong XXX:";
$question30 = "What is the most difficult?";
$question31 = "What is the smartest XXX?";
$question31 = "What is the most reliable XXX?";


$handle = @fopen("Cat/beer.txt", "r");
if ($handle) {
	$i=0;
    while (($buffer = fgets($handle, 4096)) !== false) {
		if ($i==0) $repeat = $buffer;
		if ($i==1) $qt = split(",", $buffer);
		if ($i>1) if (trim($buffer)<>"") $resp[$i-2]= $buffer;
		$i++;
    }

		for ($i = 0; $j <= count($qt); $i++) {
							  //$query = "insert into intuition (question) values ('".$question."'); ";
echo $qt[$i]."<br>";
						//echo $query;
						//mysql_query($query, $mysql_access);


													}

	for ($i = 0; $j <= count($resp); $i++) {
						
echo $resp[$i]."<br>";
	}




    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}






  

?>

