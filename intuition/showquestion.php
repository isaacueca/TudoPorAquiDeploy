<?php
$mysql_access = mysql_connect("localhost", "root", "cigano");
mysql_select_db ("LogicDiner");
 
$query = "select * from IntQuestion where Deleted = 0 order by rand() limit 1";
$result = mysql_query($query, $mysql_access);
$row = mysql_fetch_row($result);


$query = "update IntQuestion set TotalViews = TotalViews + 1 where ID=".$row[0];
mysql_query($query, $mysql_access);

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";

echo "<html>";
echo "<body>";
echo "<h1>Intuition</h1>";
echo "<form name='intuition'>";
echo "<b>User: </b><input type=text name='user'>&nbsp;&nbsp;&nbsp;";
echo "Current Score: <input type=text size='2' name='score' style='border: none'>&nbsp;&nbsp;&nbsp;";
echo "<b>Record: </b><input type=text size='2' name='highscore' style='border: none'><br><br>";

echo "Question ID: <b>".$row[0]."</b><br>";
echo "<b><input type='text' size=100 name='questiontext' value='".$row[1]."'></b><br>";
echo "<input type='radio' name='question' value='1'/>&nbsp;<input type='text' name='question1' size=60 value='".$row[9]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[21])."' name='answer1'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score1' style='border: none'><br>";
echo "<input type='radio' name='question' value='2'/>&nbsp;<input type='text' name='question2' size=60 value='".$row[10]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[22])."' name='answer2'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score2' style='border: none'><br>";
echo "<input type='radio' name='question' value='3'/>&nbsp;<input type='text' name='question3' size=60 value='".$row[11]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[23])."' name='answer3'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score3' style='border: none'><br>";
echo "<input type='radio' name='question' value='4'/>&nbsp;<input type='text' name='question4' size=60 value='".$row[12]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[24])."' name='answer4'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score4' style='border: none'><br>";
echo "<input type='radio' name='question' value='5'/>&nbsp;<input type='text' name='question5' size=60 value='".$row[13]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[25])."' name='answer5'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score5' style='border: none'><br>";
echo "<input type='radio' name='question' value='6'/>&nbsp;<input type='text' name='question6' size=60 value='".$row[14]."'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' value='".base64_encode($row[26])."' name='answer6'>&nbsp;&nbsp;<input type=text style=\"visibility:hidden\" size='2' name='score6' style='border: none'><br><br>";


echo "<input type=BUTTON value='Submit' name='mySubmit' onClick='ShowResults();'>&nbsp;&nbsp;<input type=BUTTON value='Save' name='mySave' onClick='SaveAnswerQuestion();'>&nbsp;&nbsp;<input type=BUTTON value='Delete' name='deletebt' onClick='DeleteQuestion();'><br><br>";


echo "<b>Ranking</b>";

echo "<table><tr><td>Name</td><td>Score</td></tr>";
$queryuser = "SELECT FirstName, ScoreAll FROM Score inner join Users on Score.UserID = Users.ID order by ScoreAll desc";
$resultuser = mysql_query($queryuser, $mysql_access);

 while($rowuser = mysql_fetch_row($resultuser))
  {
echo "<tr><td>".$rowuser[0]."&nbsp;&nbsp;</td><td>".$rowuser[1]."</td></tr>";
  }
  echo "</table>";

echo "<script type=\"text/javascript\" src='base.js'></script>";
echo "<script type=\"text/javascript\">";
echo "if (Get_Cookie('user')==null) document.intuition.user.value=''; else document.intuition.user.value=Get_Cookie('user');";

echo "function getCheckedValue(radioObj) {";
echo "	if(!radioObj)";
echo "		return \"\";";
echo "	var radioLength = radioObj.length;";
echo "	if(radioLength == undefined)";
echo "		if(radioObj.checked)";
echo "			return radioObj.value;";
echo "		else";
echo "			return \"\";";
echo "	for(var i = 0; i < radioLength; i++) {";
echo "		if(radioObj[i].checked) {";
echo "			return radioObj[i].value;";
echo "		}";
echo "	}";
echo "	return \"\";";
echo "}";


echo "function SaveQuestion() {";
echo "window.location='http://www.tudoporaqui.com.br/intuition/UpdateQuestion.php?id=".$row[0]."&answer1='+escape(document.intuition.question1.value)+'&answer2='+escape(document.intuition.question2.value)+'&answer3='+escape(document.intuition.question3.value)+'&answer4='+escape(document.intuition.question4.value)+'&answer5='+escape(document.intuition.question5.value)+'&answer6='+escape(document.intuition.question6.value)+'&question='+escape(document.intuition.questiontext.value);";
echo "}";


echo "function SaveAnswer() {";
echo "window.location='http://www.tudoporaqui.com.br/intuition/UpdateAnswer.php?id=".$row[0]."&answer1='+escape(document.intuition.question1.value)+'&answer2='+escape(document.intuition.question2.value)+'&answer3='+escape(document.intuition.question3.value)+'&answer4='+escape(document.intuition.question4.value)+'&answer5='+escape(document.intuition.question5.value)+'&answer6='+escape(document.intuition.question6.value)+'&answerfake1='+document.intuition.answer1.value+'&answerfake2='+document.intuition.answer2.value+'&answerfake3='+document.intuition.answer3.value+'&answerfake4='+document.intuition.answer4.value+'&answerfake5='+document.intuition.answer5.value+'&answerfake6='+document.intuition.answer6.value+'&question='+document.intuition.questiontext.value;";
echo "}";

echo "function SaveAnswerQuestion() {";
echo "if (document.intuition.mySubmit.value=='Submit') SaveQuestion(); else SaveAnswer();";
echo "}";

echo "function DeleteQuestion() {";
echo "if (confirm('Are you sure?')) window.location='http://www.tudoporaqui.com.br/intuition/DeleteQuestion.php?id=".$row[0]."';";
echo "}";

echo "function ShowResults() {";

echo "if (document.intuition.mySubmit.value=='Submit') { ";

echo "if (getCheckedValue(document.intuition.question)=='') {alert('Select a answer'); return;} ";
echo "if (document.intuition.user.value=='') {alert('User cannot be blank'); return;} ";

echo "document.intuition.mySubmit.value='Next';";
//echo "document.intuition.deletebt.style.visibility = 'visible';";

echo "document.intuition.answer1.value=decode(document.intuition.answer1.value);";
echo "document.intuition.answer2.value=decode(document.intuition.answer2.value);";
echo "document.intuition.answer3.value=decode(document.intuition.answer3.value);";
echo "document.intuition.answer4.value=decode(document.intuition.answer4.value);";
echo "document.intuition.answer5.value=decode(document.intuition.answer5.value);";
echo "document.intuition.answer6.value=decode(document.intuition.answer6.value);";
echo "document.intuition.answer1.style.visibility = 'visible';";
echo "document.intuition.answer2.style.visibility = 'visible';";
echo "document.intuition.answer3.style.visibility = 'visible';";
echo "document.intuition.answer4.style.visibility = 'visible';";
echo "document.intuition.answer5.style.visibility = 'visible';";
echo "document.intuition.answer6.style.visibility = 'visible';";
echo "document.intuition.score1.style.visibility = 'visible';";
echo "document.intuition.score2.style.visibility = 'visible';";
echo "document.intuition.score3.style.visibility = 'visible';";
echo "document.intuition.score4.style.visibility = 'visible';";
echo "document.intuition.score5.style.visibility = 'visible';";
echo "document.intuition.score6.style.visibility = 'visible';";

echo "var contador1 = 0;";
echo "if (Number(document.intuition.answer1.value) < Number(document.intuition.answer2.value)) contador1 = contador1 + 1;";
echo "if (Number(document.intuition.answer1.value) < Number(document.intuition.answer3.value)) contador1 = contador1 + 1;";
echo "if (Number(document.intuition.answer1.value) < Number(document.intuition.answer4.value)) contador1 = contador1 + 1;";
echo "if (Number(document.intuition.answer1.value) < Number(document.intuition.answer5.value)) contador1 = contador1 + 1;";
echo "if (Number(document.intuition.answer1.value) < Number(document.intuition.answer6.value)) contador1 = contador1 + 1;";

echo "var contador2 = 0;";
echo "if (Number(document.intuition.answer2.value) < Number(document.intuition.answer1.value)) contador2 = contador2 + 1;";
echo "if (Number(document.intuition.answer2.value) < Number(document.intuition.answer3.value)) contador2 = contador2 + 1;";
echo "if (Number(document.intuition.answer2.value) < Number(document.intuition.answer4.value)) contador2 = contador2 + 1;";
echo "if (Number(document.intuition.answer2.value) < Number(document.intuition.answer5.value)) contador2 = contador2 + 1;";
echo "if (Number(document.intuition.answer2.value) < Number(document.intuition.answer6.value)) contador2 = contador2 + 1;";

echo "var contador3 = 0;";
echo "if (Number(document.intuition.answer3.value) < Number(document.intuition.answer1.value)) contador3 = contador3 + 1;";
echo "if (Number(document.intuition.answer3.value) < Number(document.intuition.answer2.value)) contador3 = contador3 + 1;";
echo "if (Number(document.intuition.answer3.value) < Number(document.intuition.answer4.value)) contador3 = contador3 + 1;";
echo "if (Number(document.intuition.answer3.value) < Number(document.intuition.answer5.value)) contador3 = contador3 + 1;";
echo "if (Number(document.intuition.answer3.value) < Number(document.intuition.answer6.value)) contador3 = contador3 + 1;";

echo "var contador4 = 0;";
echo "if (Number(document.intuition.answer4.value) < Number(document.intuition.answer1.value)) contador4 = contador4 + 1;";
echo "if (Number(document.intuition.answer4.value) < Number(document.intuition.answer2.value)) contador4 = contador4 + 1;";
echo "if (Number(document.intuition.answer4.value) < Number(document.intuition.answer3.value)) contador4 = contador4 + 1;";
echo "if (Number(document.intuition.answer4.value) < Number(document.intuition.answer5.value)) contador4 = contador4 + 1;";
echo "if (Number(document.intuition.answer4.value) < Number(document.intuition.answer6.value)) contador4 = contador4 + 1;";

echo "var contador5 = 0;";
echo "if (Number(document.intuition.answer5.value) < Number(document.intuition.answer1.value)) contador5 = contador5 + 1;";
echo "if (Number(document.intuition.answer5.value) < Number(document.intuition.answer2.value)) contador5 = contador5 + 1;";
echo "if (Number(document.intuition.answer5.value) < Number(document.intuition.answer3.value)) contador5 = contador5 + 1;";
echo "if (Number(document.intuition.answer5.value) < Number(document.intuition.answer4.value)) contador5 = contador5 + 1;";
echo "if (Number(document.intuition.answer5.value) < Number(document.intuition.answer6.value)) contador5 = contador5 + 1;";

echo "var contador6 = 0;";
echo "if (Number(document.intuition.answer6.value) < Number(document.intuition.answer1.value)) contador6 = contador6 + 1;";
echo "if (Number(document.intuition.answer6.value) < Number(document.intuition.answer2.value)) contador6 = contador6 + 1;";
echo "if (Number(document.intuition.answer6.value) < Number(document.intuition.answer3.value)) contador6 = contador6 + 1;";
echo "if (Number(document.intuition.answer6.value) < Number(document.intuition.answer4.value)) contador6 = contador6 + 1;";
echo "if (Number(document.intuition.answer6.value) < Number(document.intuition.answer5.value)) contador6 = contador6 + 1;";



echo "if (Number(contador1) == 0) document.intuition.score1.value = '100';";
echo "if (Number(contador1) == 1) document.intuition.score1.value = '50';";
echo "if (Number(contador1) == 2) document.intuition.score1.value = '10';";
echo "if (Number(contador1) == 3) document.intuition.score1.value = '5';";
echo "if (Number(contador1) == 4) document.intuition.score1.value = '1';";
echo "if (Number(contador1) == 5) document.intuition.score1.value = 'reset';";


echo "if (Number(contador2) == 0) document.intuition.score2.value = '100';";
echo "if (Number(contador2) == 1) document.intuition.score2.value = '50';";
echo "if (Number(contador2) == 2) document.intuition.score2.value = '10';";
echo "if (Number(contador2) == 3) document.intuition.score2.value = '5';";
echo "if (Number(contador2) == 4) document.intuition.score2.value = '1';";
echo "if (Number(contador2) == 5) document.intuition.score2.value = 'reset';";



echo "if (Number(contador3) == 0) document.intuition.score3.value = '100';";
echo "if (Number(contador3) == 1) document.intuition.score3.value = '50';";
echo "if (Number(contador3) == 2) document.intuition.score3.value = '10';";
echo "if (Number(contador3) == 3) document.intuition.score3.value = '5';";
echo "if (Number(contador3) == 4) document.intuition.score3.value = '1';";
echo "if (Number(contador3) == 5) document.intuition.score3.value = 'reset';";


echo "if (Number(contador4) == 0) document.intuition.score4.value = '100';";
echo "if (Number(contador4) == 1) document.intuition.score4.value = '50';";
echo "if (Number(contador4) == 2) document.intuition.score4.value = '10';";
echo "if (Number(contador4) == 3) document.intuition.score4.value = '5';";
echo "if (Number(contador4) == 4) document.intuition.score4.value = '1';";
echo "if (Number(contador4) == 5) document.intuition.score4.value = 'reset';";


echo "if (Number(contador5) == 0) document.intuition.score5.value = '100';";
echo "if (Number(contador5) == 1) document.intuition.score5.value = '50';";
echo "if (Number(contador5) == 2) document.intuition.score5.value = '10';";
echo "if (Number(contador5) == 3) document.intuition.score5.value = '5';";
echo "if (Number(contador5) == 4) document.intuition.score5.value = '1';";
echo "if (Number(contador5) == 5) document.intuition.score5.value = 'reset';";


echo "if (Number(contador6) == 0) document.intuition.score6.value = '100';";
echo "if (Number(contador6) == 1) document.intuition.score6.value = '50';";
echo "if (Number(contador6) == 2) document.intuition.score6.value = '10';";
echo "if (Number(contador6) == 3) document.intuition.score6.value = '5';";
echo "if (Number(contador6) == 4) document.intuition.score6.value = '1';";
echo "if (Number(contador6) == 5) document.intuition.score6.value = 'reset';";


echo "Set_Cookie('user',document.intuition.user.value,30, '/', '', '');";
echo "if (Get_Cookie('Score') == '') Set_Cookie('Score',Number(0),30, '/', '', '');";
echo "if (Get_Cookie('HighScore') == '') Set_Cookie('HighScore',Number(0),30, '/', '', '');";

echo "document.intuition.score1.style.color = 'black';";
echo "document.intuition.score2.style.color = 'black';";
echo "document.intuition.score3.style.color = 'black';";
echo "document.intuition.score4.style.color = 'black';";
echo "document.intuition.score5.style.color = 'black';";
echo "document.intuition.score6.style.color = 'black';";

echo "if (getCheckedValue(document.intuition.question) == 1) {document.intuition.score1.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold'; if (document.intuition.score1.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score1.value),30, '/', '', '');}";
echo "if (getCheckedValue(document.intuition.question) == 2) {document.intuition.score2.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold';if (document.intuition.score2.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score2.value),30, '/', '', '');}";
echo "if (getCheckedValue(document.intuition.question) == 3) {document.intuition.score3.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold';if (document.intuition.score3.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score3.value),30, '/', '', '');}";
echo "if (getCheckedValue(document.intuition.question) == 4) {document.intuition.score4.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold';if (document.intuition.score4.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score4.value),30, '/', '', '');}";
echo "if (getCheckedValue(document.intuition.question) == 5) {document.intuition.score5.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold';if (document.intuition.score5.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score5.value),30, '/', '', '');}";
echo "if (getCheckedValue(document.intuition.question) == 6) {document.intuition.score6.style.color = 'red'; document.intuition.score1.style.fontWeight = 'bold'; if (document.intuition.score6.value=='reset') Set_Cookie('Score',Number(0),30, '/', '', ''); else Set_Cookie('Score',Number(Get_Cookie('Score'))+Number(document.intuition.score6.value),30, '/', '', '');}";
echo "if (Number(Get_Cookie('Score')) > Number(Get_Cookie('HighScore'))) Set_Cookie('HighScore',Number(Get_Cookie('Score')),30, '/', '', '');"; 

echo "} else { ";// end clicking submit
	
echo "document.intuition.submit(); "; //next question

echo "window.location='http://www.tudoporaqui.com.br/intuition/insertranking.php?name='+document.intuition.user.value+'&questionid=".$row[0]."&answer='+getCheckedValue(document.intuition.question)+'&score='+Get_Cookie('HighScore');";

echo "}  "; 
echo "if (Get_Cookie('Score') != null) document.intuition.score.value = Get_Cookie('Score');";
echo "if (Get_Cookie('HighScore') != null) document.intuition.highscore.value = Get_Cookie('HighScore');";
echo "} ";//end function show results
echo "if (Get_Cookie('Score') != null) document.intuition.score.value = Get_Cookie('Score');";
echo "if (Get_Cookie('HighScore') != null) document.intuition.highscore.value = Get_Cookie('HighScore');";
echo "</script>";


echo "</form>";

echo "</body>";
echo "</html>";

?>