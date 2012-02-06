<?php

$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("Intuition");

$question[0] = "";
$question[1] = "What is your favorite XXX?";
$question[2] = "What is the most common XXX?";
$question[3] = "What XXX do you prefer?";
$question[4] = "Pick a XXX you hate?";
$question[5] = "Choose the worst XXX?";
$question[6] = "What XXX do you like best?";
$question[7] = "Select the best XXX?";
$question[8] = "Select the funniest XXX?";
$question[9] = "Pick the most important XXX?";
$question[10] = "What is the most popular XXX?";
$question[11] = "Select the healthiest XXX?";
$question[12] = "Pick the most beautiful XXX?";
$question[13] = "What is the most adorable XXX?";
$question[14] = "Pick the ugliest XXX?";
$question[15] = "Select a elegant XXX?";
$question[16] = "Select a XXX:";
$question[17] = "What is the cleanest XXX?";
$question[18] = "What is the most famous XXX?";
$question[19] = "Pick the most powerfull XXX:";
$question[20] = "Pick a clever XXX:";
$question[21] = "Choose a nice XXX:";
$question[22] = "Pick a XXX?";
$question[23] = "What is the scariest XXX?";
$question[24] = "Pick the oddest XXX:";
$question[25] = "Choose a good XXX:";
$question[26] = "Pick a terrible XXX:";
$question[27] = "Pick a bad XXX:";
$question[28] = "Pick a strong XXX:";
$question[29] = "Choose a XXX?";
$question[30] = "Select the smartest XXX?";
$question[31] = "What is the most reliable XXX?";
$question[32] = "Select the coolest XXX?";
$question[33] = "What is the cutest XXX?";


$signal[0] = "";
$signal[1] =  1; 
$signal[2] =  1; 
$signal[3] =  1; 
$signal[4] =  2; 
$signal[5] =  2; 
$signal[6] =  1; 
$signal[7] =  1; 
$signal[8] =  1; 
$signal[9] =  1; 
$signal[10] = 1; 
$signal[11] = 1; 
$signal[12] = 1; 
$signal[13] = 1; 
$signal[14] = 2; 
$signal[15] = 1; 
$signal[16] = 1; 
$signal[17] = 1; 
$signal[18] = 1; 
$signal[19] = 1; 
$signal[20] = 1; 
$signal[21] = 1; 
$signal[22] = 1; 
$signal[23] = 1; 
$signal[24] = 2; 
$signal[25] = 1; 
$signal[26] = 2; 
$signal[27] = 2; 
$signal[28] = 1; 
$signal[29] = 1; 
$signal[30] = 1; 
$signal[31] = 1;
$signal[32] = 1;
$signal[33] = 1;
$signal[34] = 1;

foreach (glob("Cat/*.txt") as $filename) { 

$handle = @fopen($filename, "r");
$filename = str_replace("Cat/", "", $filename); 
$filename = str_replace(".txt", "", $filename); 

		if ($handle) {
				$i=0;
				unset($resp);
				unset($qt);
				while (($buffer = fgets($handle, 4096)) !== false) {
					if ($i==0) $repeat = trim($buffer);
					if ($i==1) $qt = split(",", $buffer);
					if ($i>1) if (trim($buffer)<>"") $resp[$i-2]= trim($buffer);
					$i++;
				}


           for ($y = 0; $y <= $repeat; $y++){
				for ($i = 0; $i <= count($qt); $i++) {

						$sort[0] = "";
						$sort[1] = rand(1,count($resp));
						while ($resp[$sort[1]] == "") $sort[1] = rand(1,count($resp));
						$sort[2] = rand(1,count($resp));
						while (($resp[$sort[2]] == "") || ($sort[2] == $sort[1])) $sort[2] = rand(1,count($resp));
						$sort[3] = rand(1,count($resp));
						while (($resp[$sort[3]] == "") || ($sort[3] == $sort[1]) || ($sort[3] == $sort[2])) $sort[3] = rand(1,count($resp));
						$sort[4] = rand(1,count($resp));
						while (($resp[$sort[4]] == "") || ($sort[4] == $sort[1]) || ($sort[4] == $sort[2]) || ($sort[4] == $sort[3])) $sort[4] = rand(1,count($resp));
						$sort[5] = rand(1,count($resp));
						while (($resp[$sort[5]] == "") || ($sort[5] == $sort[1]) || ($sort[5] == $sort[2]) || ($sort[5] == $sort[3]) || ($sort[5] == $sort[4])) $sort[5] = rand(1,count($resp));
						$sort[6] = rand(1,count($resp));
						while (($resp[$sort[6]] == "") || ($sort[6] == $sort[1]) || ($sort[6] == $sort[2]) || ($sort[6] == $sort[3]) || ($sort[6] == $sort[4]) || ($sort[6] == $sort[5])) $sort[6] = rand(1,count($resp));

						


						$respfinal[0] = "";
						for ($x=1; $x<=6;$x++) {
							$respfinal[$x] = str_replace("'", "''", $resp[$sort[$x]]); 
						}

						if (($signal[$qt[$i]]) == 1)  {
									$score[0] = "";
									for ($x=1; $x<=6;$x++) {
										if ($sort[$x] == 1) $score[$x] = rand(10,rand(20,40));
										if ($sort[$x] == 2) $score[$x] = rand(5,rand(10,30));
										if ($sort[$x] == 3) $score[$x] = rand(3,rand(5,rand(8,20)));
										if (($sort[$x] > 3) && ($sort[$x] < 8)) $score[$x] = rand(rand(2,5),12-$sort[$x]);
										if ($sort[$x] >= 8) $score[$x] = rand(rand(0,3),rand(3,10));
									}
						}
						
						if (($signal[$qt[$i]]) == 2)  {
									$score[0] = "";
									for ($x=1; $x<=6;$x++) {
										if ($sort[$x] == 1) $score[$x] = rand(1,rand(1,8));
										if ($sort[$x] == 2) $score[$x] = rand(1,rand(1,8));
										if ($sort[$x] == 3) $score[$x] = rand(2,rand(5,rand(2,10)));
										if (($sort[$x] > 3) && ($sort[$x] < 8)) $score[$x] = rand(rand(2,10),rand(7,10)+$sort[$x]);
										if ($sort[$x] >= 8) $score[$x] = rand(rand(0,5),rand(5,20));
									}
						}
						





						$questiondesc = trim(str_replace("XXX", $filename, $question[$qt[$i]]));
						$query = "insert into intuition values (null,'".str_replace("'", "''", $questiondesc)."',0,1,'".$filename."',".$qt[$i].",'Felipe','".$respfinal[1]."','".$respfinal[2]."','".$respfinal[3]."','".$respfinal[4]."','".$respfinal[5]."','".$respfinal[6]."',0,0,0,0,0,0,".$score[1].",".$score[2].",".$score[3].",".$score[4].",".$score[5].",".$score[6].")";
						if ($i<100) echo $query;
						if ($questiondesc != "") mysql_query($query, $mysql_access);
						
													}

		   }

			
				if (!feof($handle)) {
					echo "Error: unexpected fgets() fail\n";
				}
				fclose($handle);
		}


}





  

?>

