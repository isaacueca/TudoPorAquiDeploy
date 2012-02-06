<?php 
//include("InsertUser.php"); 
include("GetQuestions.php"); 

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>UNFCU tab page demo</title>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="ajax.js"></script>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<style type="text/css">
	a{
		text-decoration: none;
		color: blue;
	}
	a:hover{
		text-decoration: underline;
		color: olive;
	}
	</style>
	<script type="text/javascript">
	$(document).ready(function () {
		$("#tabs").tabs();
	});

	function updateStatus(){
		var status  =   document.getElementById('status').value;

		$.ajax({
			type: "POST",
			url: "<?=$fbconfig['baseUrl']?>/ajax.php",
			data: "status=" + status,
			success: function(msg){
				alert(msg);
			},
			error: function(msg){
				alert(msg);
			}
		});
	}
	function updateStatusViaJavascriptAPICalling(){
		var status  =   document.getElementById('status').value;
		FB.api('/me/feed', 'post', { message: status }, function(response) {
			if (!response || response.error) {
				alert('Error occured');
			} else {
				alert('Status updated Successfully');
			}
		});
	}
	function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){        
		FB.ui({ method : 'feed', 
		message: userPrompt,
		link   :  hrefLink,
		caption:  hrefTitle
	});
	//http://developers.facebook.com/docs/reference/dialogs/feed/

	/* 
	* Deprecated code
	FB.ui(
	{
	method: 'stream.publish',
	message: '',
	attachment: {
	name: name,
	caption: '',
	description: (description),
	href: hrefLink
	},
	action_links: [
	{ text: hrefTitle, href: hrefLink }
	],
	user_prompt_message: userPrompt
	},
	function(response) {

}); */
}
function publishStream(){
	streamPublish("Stream Publish", 'Thinkdiff.net is simply awesome. I just learned how to develop Iframe+Jquery+Ajax base facebook application development using php sdk 3.0. ', 'Checkout the Tutorial', 'http://wp.me/pr3EW-sv', "Demo Facebook Application Tutorial");
}
function increaseIframeSize(w,h){
	var obj =   new Object;
	obj.width=w;
	obj.height=h;
	FB.Canvas.setSize(obj);
}

function newInvite(){
	var receiverUserIds = FB.ui({ 
		method : 'apprequests',
		message: 'come on man checkout my application. visit http://thinkdiff.net',
	},
	function(receiverUserIds) {
		console.log("IDS : " + receiverUserIds.request_ids);
	}
);
//http://developers.facebook.com/docs/reference/dialogs/requests/
}

window.fbAsyncInit = function() {
	FB.Canvas.setSize();
}
// Do things that will sometimes call sizeChangeCallback()
function sizeChangeCallback() {
	FB.Canvas.setSize();
}
</script>
</head>
<body>
	<div id="fb-root"></div>
	<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript">
	FB.init({
		appId  : '<?=$fbconfig['appid']?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
	FB.Canvas.setAutoResize();
	</script>


	<script>
	$(document).ready(function(){
		$('.error').hide(); 
		$('.error2').hide(); 
		location.href = "template#logo";
	}); 
	function submitForm(){
				
			var FirstName     = $('#FirstName').attr('value');  
			var LastName     = $('#LastName').attr('value'); 
			var Address1     = $('#Address').attr('value');  
			var Email     = $('#Email').attr('value');

			
			$.ajax({  
				type: "POST",  
				url: "InsertUser.php",  
				data: "FirstName="+ FirstName +"& LastName="+ LastName +"& Address1="+ Address1 +"& Email="+ Email,  
				success: function(){ 
					window.location = "http://www.globo.com";
				}  
			});  
			return false;
	
		}

		</script>
		<?php
	/*	$query = mysql_query("SELECT * FROM user WHERE Email = 'ismalakazel@gmail.com' ") or die(mysql_error());

$row = mysql_fetch_array( $query );
// Print out the contents of the entry 
print_r($row);
echo "Name: ".$row['FirstName'];
echo " gmail: ".$row['FacebookID'];*/
?>
<style>
* {
	margin:0;
	padding:0;
}	
</style>
<div id="wrapper">
	<div id="logo"><img src="images/logo.png" /></div><br />		
	<div class="form">
		<form name="register" method="post" action="InsertUser.php">

			<fieldset id="fieldset1" style="float:left">
				<legend><span>Section I of III</span><spa><br /><span>Personal Registration</span></legend>
					<p id="name_error" class="error">Please, complete the required fields.</p>			      
					<p id="name_error" class="error2">Please, you must agree to the terms of the program.</p>			      
					<ol>
						<li>
							<label for="FirstName">First Name<em>*</em></label>
							<input size="40px" name="FirstName" id="FirstName"/>	
						</li>
						<li>
							<label for="Lastname">Last Name<em>*</em></label>
							<input size="40px" name="LastName" id="LasName"/>
						</li>
						<li>
							<label for="Middle">Middle<em>*</em></label>
							<input size="25px" name="Middle" id="Middle"/>
						</li>
						<li>
							<label for="Address1">Address<em>*</em></label>
							<input size="55px" name="Address1" id="Address1"/>
						</li>
						<li>
							<label for="City">City</label>
							<select id="City"><br /> 
								<option selected value="">City...</option>
								<option value="Abilene">Abilene</option><br /> 
								<option value="Akron">Akron</option><br /> 
								<option value="Albuquerque">Albuquerque</option><br /> 
								<option value="Alexandria">Alexandria</option><br /> 
								<option value="Allentown">Allentown</option><br /> 
								<option value="Amarillo">Amarillo</option><br /> 
								<option value="Anaheim">Anaheim</option><br /> 
								<option value="Anchorage">Anchorage</option><br /> 
								<option value="Ann Arbor">Ann Arbor</option><br /> 
								<option value="Antioch">Antioch</option><br /> 
								<option value="Arlington">Arlington</option><br /> 
								<option value="Arlington">Arlington</option><br /> 
								<option value="Arvada">Arvada</option><br /> 
								<option value="Athens">Athens</option><br /> 
								<option value="Atlanta">Atlanta</option><br /> 
								<option value="Augusta">Augusta</option><br /> 
								<option value="Aurora">Aurora</option><br /> 
								<option value="Aurora">Aurora</option><br /> 
								<option value="Austin">Austin</option><br /> 
								<option value="Bakersfield">Bakersfield</option><br /> 
								<option value="Baltimore">Baltimore</option><br /> 
								<option value="Baton Rouge">Baton Rouge</option><br /> 
								<option value="Beaumont">Beaumont</option><br /> 
								<option value="Bellevue">Bellevue</option><br /> 
								<option value="Berkeley">Berkeley</option><br /> 
								<option value="Billings">Billings</option><br /> 
								<option value="Birmingham">Birmingham</option><br /> 
								<option value="Boise">Boise</option><br /> 
								<option value="Boston">Boston</option><br /> 
								<option value="Boulder">Boulder</option><br /> 
								<option value="Bridgeport">Bridgeport</option><br /> 
								<option value="Brownsville">Brownsville</option><br /> 
								<option value="Buffalo">Buffalo</option><br /> 
								<option value="Burbank">Burbank</option><br /> 
								<option value="Cambridge">Cambridge</option><br /> 
								<option value="Cape Coral">Cape Coral</option><br /> 
								<option value="Carrollton">Carrollton</option><br /> 
								<option value="Cary">Cary</option><br /> 
								<option value="Cedar Rapids">Cedar Rapids</option><br /> 
								<option value="Centennial">Centennial</option><br /> 
								<option value="Chandler">Chandler</option><br /> 
								<option value="Charleston">Charleston</option><br /> 
								<option value="Charlotte">Charlotte</option><br /> 
								<option value="Chattanooga">Chattanooga</option><br /> 
								<option value="Chesapeake">Chesapeake</option><br /> 
								<option value="Chicago">Chicago</option><br /> 
								<option value="Chula Vista">Chula Vista</option><br /> 
								<option value="Cincinnati">Cincinnati</option><br /> 
								<option value="Clarksville">Clarksville</option><br /> 
								<option value="Clearwater">Clearwater</option><br /> 
								<option value="Cleveland">Cleveland</option><br /> 
								<option value="Colorado Springs">Colorado Springs</option><br /> 
								<option value="Columbia">Columbia</option><br /> 
								<option value="Columbia">Columbia</option><br /> 
								<option value="Columbus">Columbus</option><br /> 
								<option value="Columbus">Columbus</option><br /> 
								<option value="Concord">Concord</option><br /> 
								<option value="Coral Springs">Coral Springs</option><br /> 
								<option value="Corona">Corona</option><br /> 
								<option value="Corpus Christi">Corpus Christi</option><br /> 
								<option value="Costa Mesa">Costa Mesa</option><br /> 
								<option value="Dallas">Dallas</option><br /> 
								<option value="Daly City">Daly City</option><br /> 
								<option value="Davenport">Davenport</option><br /> 
								<option value="Dayton">Dayton</option><br /> 
								<option value="Denton">Denton</option><br /> 
								<option value="Denver">Denver</option><br /> 
								<option value="Des Moines">Des Moines</option><br /> 
								<option value="Detroit">Detroit</option><br /> 
								<option value="Downey">Downey</option><br /> 
								<option value="Durham">Durham</option><br /> 
								<option value="El Monte">El Monte</option><br /> 
								<option value="El Paso">El Paso</option><br /> 
								<option value="Elgin">Elgin</option><br /> 
								<option value="Elizabeth">Elizabeth</option><br /> 
								<option value="Elk Grove">Elk Grove</option><br /> 
								<option value="Erie">Erie</option><br /> 
								<option value="Escondido">Escondido</option><br /> 
								<option value="Eugene">Eugene</option><br /> 
								<option value="Evansville">Evansville</option><br /> 
								<option value="Fairfield">Fairfield</option><br /> 
								<option value="Fayetteville">Fayetteville</option><br /> 
								<option value="Flint">Flint</option><br /> 
								<option value="Fontana">Fontana</option><br /> 
								<option value="Fort Collins">Fort Collins</option><br /> 
								<option value="Fort Lauderdale">Fort Lauderdale</option><br /> 
								<option value="Fort Wayne">Fort Wayne</option><br /> 
								<option value="Fort Worth">Fort Worth</option><br /> 
								<option value="Fremont">Fremont</option><br /> 
								<option value="Fresno">Fresno</option><br /> 
								<option value="Frisco">Frisco</option><br /> 
								<option value="Fullerton">Fullerton</option><br /> 
								<option value="Gainesville">Gainesville</option><br /> 
								<option value="Garden Grove">Garden Grove</option><br /> 
								<option value="Garland">Garland</option><br /> 
								<option value="Gilbert">Gilbert</option><br /> 
								<option value="Glendale">Glendale</option><br /> 
								<option value="Glendale">Glendale</option><br /> 
								<option value="Grand Prairie">Grand Prairie</option><br /> 
								<option value="Grand Rapids">Grand Rapids</option><br /> 
								<option value="Green Bay">Green Bay</option><br /> 
								<option value="Greensboro">Greensboro</option><br /> 
								<option value="Gresham">Gresham</option><br /> 
								<option value="Hampton">Hampton</option><br /> 
								<option value="Hartford">Hartford</option><br /> 
								<option value="Hayward">Hayward</option><br /> 
								<option value="Henderson">Henderson</option><br /> 
								<option value="Hialeah">Hialeah</option><br /> 
								<option value="High Point">High Point</option><br /> 
								<option value="Hollywood">Hollywood</option><br /> 
								<option value="Honolulu b[?]">Honolulu b[?]</option><br /> 
								<option value="Houston">Houston</option><br /> 
								<option value="Huntington Beach">Huntington Beach</option><br /> 
								<option value="Huntsville">Huntsville</option><br /> 
								<option value="Independence">Independence</option><br /> 
								<option value="Indianapolis">Indianapolis</option><br /> 
								<option value="Inglewood">Inglewood</option><br /> 
								<option value="Irvine">Irvine</option><br /> 
								<option value="Irving">Irving</option><br /> 
								<option value="Jackson">Jackson</option><br /> 
								<option value="Jacksonville">Jacksonville</option><br /> 
								<option value="Jersey City">Jersey City</option><br /> 
								<option value="Joliet">Joliet</option><br /> 
								<option value="Kansas City">Kansas City</option><br /> 
								<option value="Kansas City">Kansas City</option><br /> 
								<option value="Killeen">Killeen</option><br /> 
								<option value="Knoxville">Knoxville</option><br /> 
								<option value="Lafayette">Lafayette</option><br /> 
								<option value="Lakewood">Lakewood</option><br /> 
								<option value="Lancaster">Lancaster</option><br /> 
								<option value="Lansing">Lansing</option><br /> 
								<option value="Laredo">Laredo</option><br /> 
								<option value="Las Vegas">Las Vegas</option><br /> 
								<option value="Lewisville">Lewisville</option><br /> 
								<option value="Lexington">Lexington</option><br /> 
								<option value="Lincoln">Lincoln</option><br /> 
								<option value="Little Rock">Little Rock</option><br /> 
								<option value="Long Beach">Long Beach</option><br /> 
								<option value="Los Angeles">Los Angeles</option><br /> 
								<option value="Louisville">Louisville</option><br /> 
								<option value="Lowell">Lowell</option><br /> 
								<option value="Lubbock">Lubbock</option><br /> 
								<option value="Madison">Madison</option><br /> 
								<option value="Manchester">Manchester</option><br /> 
								<option value="McAllen">McAllen</option><br /> 
								<option value="McKinney">McKinney</option><br /> 
								<option value="Memphis">Memphis</option><br /> 
								<option value="Mesa">Mesa</option><br /> 
								<option value="Mesquite">Mesquite</option><br /> 
								<option value="Miami">Miami</option><br /> 
								<option value="Miami Gardens">Miami Gardens</option><br /> 
								<option value="Midland">Midland</option><br /> 
								<option value="Milwaukee">Milwaukee</option><br /> 
								<option value="Minneapolis">Minneapolis</option><br /> 
								<option value="Miramar">Miramar</option><br /> 
								<option value="Mobile">Mobile</option><br /> 
								<option value="Modesto">Modesto</option><br /> 
								<option value="Montgomery">Montgomery</option><br /> 
								<option value="Moreno Valley">Moreno Valley</option><br /> 
								<option value="Murfreesboro">Murfreesboro</option><br /> 
								<option value="Naperville">Naperville</option><br /> 
								<option value="Nashville">Nashville</option><br /> 
								<option value="New Haven">New Haven</option><br /> 
								<option value="New Orleans">New Orleans</option><br /> 
								<option value="New York">New York</option><br /> 
								<option value="Newark">Newark</option><br /> 
								<option value="Newport News">Newport News</option><br /> 
								<option value="Norfolk">Norfolk</option><br /> 
								<option value="Norman">Norman</option><br /> 
								<option value="North Las Vegas">North Las Vegas</option><br /> 
								<option value="Norwalk">Norwalk</option><br /> 
								<option value="Oakland">Oakland</option><br /> 
								<option value="Oceanside">Oceanside</option><br /> 
								<option value="Odessa">Odessa</option><br /> 
								<option value="Oklahoma City">Oklahoma City</option><br /> 
								<option value="Olathe">Olathe</option><br /> 
								<option value="Omaha">Omaha</option><br /> 
								<option value="Ontario">Ontario</option><br /> 
								<option value="Orange">Orange</option><br /> 
								<option value="Orlando">Orlando</option><br /> 
								<option value="Overland Park">Overland Park</option><br /> 
								<option value="Oxnard">Oxnard</option><br /> 
								<option value="Palm Bay">Palm Bay</option><br /> 
								<option value="Palmdale">Palmdale</option><br /> 
								<option value="Pasadena">Pasadena</option><br /> 
								<option value="Pasadena">Pasadena</option><br /> 
								<option value="Paterson">Paterson</option><br /> 
								<option value="Pembroke Pines">Pembroke Pines</option><br /> 
								<option value="Peoria">Peoria</option><br /> 
								<option value="Peoria">Peoria</option><br /> 
								<option value="Philadelphia">Philadelphia</option><br /> 
								<option value="Phoenix">Phoenix</option><br /> 
								<option value="Pittsburgh">Pittsburgh</option><br /> 
								<option value="Plano">Plano</option><br /> 
								<option value="Pomona">Pomona</option><br /> 
								<option value="Pompano Beach">Pompano Beach</option><br /> 
								<option value="Port St. Lucie">Port St. Lucie</option><br /> 
								<option value="Portland">Portland</option><br /> 
								<option value="Providence">Providence</option><br /> 
								<option value="Provo">Provo</option><br /> 
								<option value="Pueblo">Pueblo</option><br /> 
								<option value="Raleigh">Raleigh</option><br /> 
								<option value="Rancho Cucamonga">Rancho Cucamonga</option><br /> 
								<option value="Reno">Reno</option><br /> 
								<option value="Richardson">Richardson</option><br /> 
								<option value="Richmond">Richmond</option><br /> 
								<option value="Richmond">Richmond</option><br /> 
								<option value="Riverside">Riverside</option><br /> 
								<option value="Rochester">Rochester</option><br /> 
								<option value="Rochester">Rochester</option><br /> 
								<option value="Rockford">Rockford</option><br /> 
								<option value="Roseville">Roseville</option><br /> 
								<option value="Round Rock">Round Rock</option><br /> 
								<option value="Sacramento">Sacramento</option><br /> 
								<option value="Salem">Salem</option><br /> 
								<option value="Salinas">Salinas</option><br /> 
								<option value="Salt Lake City">Salt Lake City</option><br /> 
								<option value="San Antonio">San Antonio</option><br /> 
								<option value="San Bernardino">San Bernardino</option><br /> 
								<option value="San Buenaventura (Ventura)">San Buenaventura (Ventura)</option><br /> 
								<option value="San Diego">San Diego</option><br /> 
								<option value="San Francisco">San Francisco</option><br /> 
								<option value="San Jose">San Jose</option><br /> 
								<option value="Santa Ana">Santa Ana</option><br /> 
								<option value="Santa Clara">Santa Clara</option><br /> 
								<option value="Santa Clarita">Santa Clarita</option><br /> 
								<option value="Santa Rosa">Santa Rosa</option><br /> 
								<option value="Savannah">Savannah</option><br /> 
								<option value="Scottsdale">Scottsdale</option><br /> 
								<option value="Seattle">Seattle</option><br /> 
								<option value="Shreveport">Shreveport</option><br /> 
								<option value="Simi Valley">Simi Valley</option><br /> 
								<option value="Sioux Falls">Sioux Falls</option><br /> 
								<option value="South Bend">South Bend</option><br /> 
								<option value="Spokane">Spokane</option><br /> 
								<option value="Springfield">Springfield</option><br /> 
								<option value="Springfield">Springfield</option><br /> 
								<option value="Springfield">Springfield</option><br /> 
								<option value="St. Louis">St. Louis</option><br /> 
								<option value="St. Paul">St. Paul</option><br /> 
								<option value="St. Petersburg">St. Petersburg</option><br /> 
								<option value="Stamford">Stamford</option><br /> 
								<option value="Sterling Heights">Sterling Heights</option><br /> 
								<option value="Stockton">Stockton</option><br /> 
								<option value="Sunnyvale">Sunnyvale</option><br /> 
								<option value="Syracuse">Syracuse</option><br /> 
								<option value="Tacoma">Tacoma</option><br /> 
								<option value="Tallahassee">Tallahassee</option><br /> 
								<option value="Tampa">Tampa</option><br /> 
								<option value="Tempe">Tempe</option><br /> 
								<option value="Thornton">Thornton</option><br /> 
								<option value="Thousand Oaks">Thousand Oaks</option><br /> 
								<option value="Toledo">Toledo</option><br /> 
								<option value="Topeka">Topeka</option><br /> 
								<option value="Torrance">Torrance</option><br /> 
								<option value="Tucson">Tucson</option><br /> 
								<option value="Tulsa">Tulsa</option><br /> 
								<option value="Vallejo">Vallejo</option><br /> 
								<option value="Vancouver">Vancouver</option><br /> 
								<option value="Victorville">Victorville</option><br /> 
								<option value="Virginia Beach">Virginia Beach</option><br /> 
								<option value="Visalia">Visalia</option><br /> 
								<option value="Waco">Waco</option><br /> 
								<option value="Warren">Warren</option><br /> 
								<option value="Washington">Washington</option><br /> 
								<option value="Waterbury">Waterbury</option><br /> 
								<option value="West Covina">West Covina</option><br /> 
								<option value="West Jordan">West Jordan</option><br /> 
								<option value="West Valley City">West Valley City</option><br /> 
								<option value="Westminster">Westminster</option><br /> 
								<option value="Wichita">Wichita</option><br /> 
								<option value="Wichita Falls">Wichita Falls</option><br /> 
								<option value="Wilmington">Wilmington</option><br /> 
								<option value="Winston-Salem">Winston-Salem</option><br /> 
								<option value="Worcester">Worcester</option><br /> 
								<option value="Yonkers">Yonkers</option><br /> 
							</select><br />						</li>
							<li>
								<label for="State">State</label>
								<select name="State" size="1">
									<option selected value="">State...</option>
									<option value="ZZ">None</option>
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
							</li>
							<li>
								<label for="PostalCode">Postal Code</label>
								<input name="PostalCode" />
							</li>
							<li>
								<label for="Country">Country</label>
								<select name="Country">
									<option selected value="">Country...</option>
									<option value="ZZ">None</option>
									<option value="AF">Afghanistan</option>
									<option value="AX">Ã…Land Islands</option>
									<option value="AL">Albania</option>
									<option value="DZ">Algeria</option>
									<option value="AS">American Samoa</option>
									<option value="AD">Andorra</option>
									<option value="AO">Angola</option>
									<option value="AI">Anguilla</option>
									<option value="AQ">Antarctica</option>
									<option value="AG">Antigua And Barbuda</option>
									<option value="AR">Argentina</option>
									<option value="AM">Armenia</option>
									<option value="AW">Aruba</option>
									<option value="AU">Australia</option>
									<option value="AT">Austria</option>
									<option value="AZ">Azerbaijan</option>
									<option value="BS">Bahamas</option>
									<option value="BH">Bahrain</option>
									<option value="BD">Bangladesh</option>
									<option value="BB">Barbados</option>
									<option value="BY">Belarus</option>
									<option value="BE">Belgium</option>
									<option value="BZ">Belize</option>
									<option value="BJ">Benin</option>
									<option value="BM">Bermuda</option>
									<option value="BT">Bhutan</option>
									<option value="BO">Bolivia</option>
									<option value="BA">Bosnia And Herzegovina</option>
									<option value="BW">Botswana</option>
									<option value="BV">Bouvet Island</option>
									<option value="BR">Brazil</option>
									<option value="IO">British Indian Ocean Territory</option>
									<option value="BN">Brunei Darussalam</option>
									<option value="BG">Bulgaria</option>
									<option value="BF">Burkina Faso</option>
									<option value="BI">Burundi</option>
									<option value="KH">Cambodia</option>
									<option value="CM">Cameroon</option>
									<option value="CA">Canada</option>
									<option value="CV">Cape Verde</option>
									<option value="KY">Cayman Islands</option>
									<option value="CF">Central African Republic</option>
									<option value="TD">Chad</option>
									<option value="CL">Chile</option>
									<option value="CN">China</option>
									<option value="CX">Christmas Island</option>
									<option value="CC">Cocos (Keeling) Islands</option>
									<option value="CO">Colombia</option>
									<option value="KM">Comoros</option>
									<option value="CG">Congo</option>
									<option value="CD">Congo, The Democratic Republic Of The</option>
									<option value="CK">Cook Islands</option>
									<option value="CR">Costa Rica</option>
									<option value="CI">Cote D'Ivoire</option>
									<option value="HR">Croatia</option>
									<option value="CU">Cuba</option>
									<option value="CY">Cyprus</option>
									<option value="CZ">Czech Republic</option>
									<option value="DK">Denmark</option>
									<option value="DJ">Djibouti</option>
									<option value="DM">Dominica</option>
									<option value="DO">Dominican Republic</option>
									<option value="EC">Ecuador</option>
									<option value="EG">Egypt</option>
									<option value="SV">El Salvador</option>
									<option value="GQ">Equatorial Guinea</option>
									<option value="ER">Eritrea</option>
									<option value="EE">Estonia</option>
									<option value="ET">Ethiopia</option>
									<option value="FK">Falkland Islands (Malvinas)</option>
									<option value="FO">Faroe Islands</option>
									<option value="FJ">Fiji</option>
									<option value="FI">Finland</option>
									<option value="FR">France</option>
									<option value="GF">French Guiana</option>
									<option value="PF">French Polynesia</option>
									<option value="TF">French Southern Territories</option>
									<option value="GA">Gabon</option>
									<option value="GM">Gambia</option>
									<option value="GE">Georgia</option>
									<option value="DE">Germany</option>
									<option value="GH">Ghana</option>
									<option value="GI">Gibraltar</option>
									<option value="GR">Greece</option>
									<option value="GL">Greenland</option>
									<option value="GD">Grenada</option>
									<option value="GP">Guadeloupe</option>
									<option value="GU">Guam</option>
									<option value="GT">Guatemala</option>
									<option value=" Gg">Guernsey</option>
									<option value="GN">Guinea</option>
									<option value="GW">Guinea-Bissau</option>
									<option value="GY">Guyana</option>
									<option value="HT">Haiti</option>
									<option value="HM">Heard Island And Mcdonald Islands</option>
									<option value="VA">Holy See (Vatican City State)</option>
									<option value="HN">Honduras</option>
									<option value="HK">Hong Kong</option>
									<option value="HU">Hungary</option>
									<option value="IS">Iceland</option>
									<option value="IN">India</option>
									<option value="ID">Indonesia</option>
									<option value="IR">Iran, Islamic Republic Of</option>
									<option value="IQ">Iraq</option>
									<option value="IE">Ireland</option>
									<option value="IM">Isle Of Man</option>
									<option value="IL">Israel</option>
									<option value="IT">Italy</option>
									<option value="JM">Jamaica</option>
									<option value="JP">Japan</option>
									<option value="JE">Jersey</option>
									<option value="JO">Jordan</option>
									<option value="KZ">Kazakhstan</option>
									<option value="KE">Kenya</option>
									<option value="KI">Kiribati</option>
									<option value="KP">Korea, Democratic People'S Republic Of</option>
									<option value="KR">Korea, Republic Of</option>
									<option value="KW">Kuwait</option>
									<option value="KG">Kyrgyzstan</option>
									<option value="LA">Lao People'S Democratic Republic</option>
									<option value="LV">Latvia</option>
									<option value="LB">Lebanon</option>
									<option value="LS">Lesotho</option>
									<option value="LR">Liberia</option>
									<option value="LY">Libyan Arab Jamahiriya</option>
									<option value="LI">Liechtenstein</option>
									<option value="LT">Lithuania</option>
									<option value="LU">Luxembourg</option>
									<option value="MO">Macao</option>
									<option value="MK">Macedonia, The Former Yugoslav Republic Of</option>
									<option value="MG">Madagascar</option>
									<option value="MW">Malawi</option>
									<option value="MY">Malaysia</option>
									<option value="MV">Maldives</option>
									<option value="ML">Mali</option>
									<option value="MT">Malta</option>
									<option value="MH">Marshall Islands</option>
									<option value="MQ">Martinique</option>
									<option value="MR">Mauritania</option>
									<option value="MU">Mauritius</option>
									<option value="YT">Mayotte</option>
									<option value="MX">Mexico</option>
									<option value="FM">Micronesia, Federated States Of</option>
									<option value="MD">Moldova, Republic Of</option>
									<option value="MC">Monaco</option>
									<option value="MN">Mongolia</option>
									<option value="MS">Montserrat</option>
									<option value="MA">Morocco</option>
									<option value="MZ">Mozambique</option>
									<option value="MM">Myanmar</option>
									<option value="NA">Namibia</option>
									<option value="NR">Nauru</option>
									<option value="NP">Nepal</option>
									<option value="NL">Netherlands</option>
									<option value="AN">Netherlands Antilles</option>
									<option value="NC">New Caledonia</option>
									<option value="NZ">New Zealand</option>
									<option value="NI">Nicaragua</option>
									<option value="NE">Niger</option>
									<option value="NG">Nigeria</option>
									<option value="NU">Niue</option>
									<option value="NF">Norfolk Island</option>
									<option value="MP">Northern Mariana Islands</option>
									<option value="NO">Norway</option>
									<option value="OM">Oman</option>
									<option value="PK">Pakistan</option>
									<option value="PW">Palau</option>
									<option value="PS">Palestinian Territory, Occupied</option>
									<option value="PA">Panama</option>
									<option value="PG">Papua New Guinea</option>
									<option value="PY">Paraguay</option>
									<option value="PE">Peru</option>
									<option value="PH">Philippines</option>
									<option value="PN">Pitcairn</option>
									<option value="PL">Poland</option>
									<option value="PT">Portugal</option>
									<option value="PR">Puerto Rico</option>
									<option value="QA">Qatar</option>
									<option value="RE">Reunion</option>
									<option value="RO">Romania</option>
									<option value="RU">Russian Federation</option>
									<option value="RW">Rwanda</option>
									<option value="SH">Saint Helena</option>
									<option value="KN">Saint Kitts And Nevis</option>
									<option value="LC">Saint Lucia</option>
									<option value="PM">Saint Pierre And Miquelon</option>
									<option value="VC">Saint Vincent And The Grenadines</option>
									<option value="WS">Samoa</option>
									<option value="SM">San Marino</option>
									<option value="ST">Sao Tome And Principe</option>
									<option value="SA">Saudi Arabia</option>
									<option value="SN">Senegal</option>
									<option value="CS">Serbia And Montenegro</option>
									<option value="SC">Seychelles</option>
									<option value="SL">Sierra Leone</option>
									<option value="SG">Singapore</option>
									<option value="SK">Slovakia</option>
									<option value="SI">Slovenia</option>
									<option value="SB">Solomon Islands</option>
									<option value="SO">Somalia</option>
									<option value="ZA">South Africa</option>
									<option value="GS">South Georgia And The South Sandwich Islands</option>
									<option value="ES">Spain</option>
									<option value="LK">Sri Lanka</option>
									<option value="SD">Sudan</option>
									<option value="SR">Suriname</option>
									<option value="SJ">Svalbard And Jan Mayen</option>
									<option value="SZ">Swaziland</option>
									<option value="SE">Sweden</option>
									<option value="CH">Switzerland</option>
									<option value="SY">Syrian Arab Republic</option>
									<option value="TW">Taiwan, Province Of China</option>
									<option value="TJ">Tajikistan</option>
									<option value="TZ">Tanzania, United Republic Of</option>
									<option value="TH">Thailand</option>
									<option value="TL">Timor-Leste</option>
									<option value="TG">Togo</option>
									<option value="TK">Tokelau</option>
									<option value="TO">Tonga</option>
									<option value="TT">Trinidad And Tobago</option>
									<option value="TN">Tunisia</option>
									<option value="TR">Turkey</option>
									<option value="TM">Turkmenistan</option>
									<option value="TC">Turks And Caicos Islands</option>
									<option value="TV">Tuvalu</option>
									<option value="UG">Uganda</option>
									<option value="UA">Ukraine</option>
									<option value="AE">United Arab Emirates</option>
									<option value="GB">United Kingdom</option>
									<option value="US">United States</option>
									<option value="UM">United States Minor Outlying Islands</option>
									<option value="UY">Uruguay</option>
									<option value="UZ">Uzbekistan</option>
									<option value="VU">Vanuatu</option>
									<option value="VE">Venezuela</option>
									<option value="VN">Viet Nam</option>
									<option value="VG">Virgin Islands, British</option>
									<option value="VI">Virgin Islands, U.S.</option>
									<option value="WF">Wallis And Futuna</option>
									<option value="EH">Western Sahara</option>
									<option value="YE">Yemen</option>
									<option value="ZM">Zambia</option>
									<option value="ZW">Zimbabwe</option>
								</select>
							</li>
							<li>
								<label for="Phone">Phone</label>
								<input name="Phone" />
							</li>
							<li>
								<label for="Email">Email<em>*</em></label>
								<input size="40" name="Email" id="Email" />
							</li>
							<li>
								<label style="width:auto" for="Digits">UNFCU 7-Digit Member Number<em>*</em></label>
								<input size="7" maxlength="7" id="Digits" id="Digits" />
							</li>
							<input type="checkbox" id="checkbox">&nbsp;&nbsp;&nbsp;<label style="width:400px">I am at least 18 and agree to terms and conditions of the program</label></input>
							<br />		
							<br />		

						</ol>

						<legend><span>Parent / Guardian Information</span></legend>
						<ol>
							<li>
								<label style="width:210px" for="ParentGuardian1">Parent/Guardian Name<em>*</em></label>
								<input size="50px" style="width:260px" name="ParentGuardian" id="ParentGuardian"/>	
							</li>
							<li>
								<label style="width:210px" for="ParentGuardian2">Parent/Guardian Name<em>*</em></label>
								<input size="50px"  style="width:260px"  style="width:230px"name="ParentGuardian" id="ParentGuardian"/>	
							</li>
							<li>
								<label style="width:210px" for="Address2">Address (<span style="font-size:9px;font-weight:bold">if different than previous</span>)</label>
								<input size="60px"  style="width:310px" name="Address2" id="Address2"/>
							</li>
							<li>
								<label for="City2">City</label>
								<select name="City2"><br /> 
									<option selected value="">City...</option>
									<option value="Abilene">Abilene</option><br /> 
									<option value="Akron">Akron</option><br /> 
									<option value="Albuquerque">Albuquerque</option><br /> 
									<option value="Alexandria">Alexandria</option><br /> 
									<option value="Allentown">Allentown</option><br /> 
									<option value="Amarillo">Amarillo</option><br /> 
									<option value="Anaheim">Anaheim</option><br /> 
									<option value="Anchorage">Anchorage</option><br /> 
									<option value="Ann Arbor">Ann Arbor</option><br /> 
									<option value="Antioch">Antioch</option><br /> 
									<option value="Arlington">Arlington</option><br /> 
									<option value="Arlington">Arlington</option><br /> 
									<option value="Arvada">Arvada</option><br /> 
									<option value="Athens">Athens</option><br /> 
									<option value="Atlanta">Atlanta</option><br /> 
									<option value="Augusta">Augusta</option><br /> 
									<option value="Aurora">Aurora</option><br /> 
									<option value="Aurora">Aurora</option><br /> 
									<option value="Austin">Austin</option><br /> 
									<option value="Bakersfield">Bakersfield</option><br /> 
									<option value="Baltimore">Baltimore</option><br /> 
									<option value="Baton Rouge">Baton Rouge</option><br /> 
									<option value="Beaumont">Beaumont</option><br /> 
									<option value="Bellevue">Bellevue</option><br /> 
									<option value="Berkeley">Berkeley</option><br /> 
									<option value="Billings">Billings</option><br /> 
									<option value="Birmingham">Birmingham</option><br /> 
									<option value="Boise">Boise</option><br /> 
									<option value="Boston">Boston</option><br /> 
									<option value="Boulder">Boulder</option><br /> 
									<option value="Bridgeport">Bridgeport</option><br /> 
									<option value="Brownsville">Brownsville</option><br /> 
									<option value="Buffalo">Buffalo</option><br /> 
									<option value="Burbank">Burbank</option><br /> 
									<option value="Cambridge">Cambridge</option><br /> 
									<option value="Cape Coral">Cape Coral</option><br /> 
									<option value="Carrollton">Carrollton</option><br /> 
									<option value="Cary">Cary</option><br /> 
									<option value="Cedar Rapids">Cedar Rapids</option><br /> 
									<option value="Centennial">Centennial</option><br /> 
									<option value="Chandler">Chandler</option><br /> 
									<option value="Charleston">Charleston</option><br /> 
									<option value="Charlotte">Charlotte</option><br /> 
									<option value="Chattanooga">Chattanooga</option><br /> 
									<option value="Chesapeake">Chesapeake</option><br /> 
									<option value="Chicago">Chicago</option><br /> 
									<option value="Chula Vista">Chula Vista</option><br /> 
									<option value="Cincinnati">Cincinnati</option><br /> 
									<option value="Clarksville">Clarksville</option><br /> 
									<option value="Clearwater">Clearwater</option><br /> 
									<option value="Cleveland">Cleveland</option><br /> 
									<option value="Colorado Springs">Colorado Springs</option><br /> 
									<option value="Columbia">Columbia</option><br /> 
									<option value="Columbia">Columbia</option><br /> 
									<option value="Columbus">Columbus</option><br /> 
									<option value="Columbus">Columbus</option><br /> 
									<option value="Concord">Concord</option><br /> 
									<option value="Coral Springs">Coral Springs</option><br /> 
									<option value="Corona">Corona</option><br /> 
									<option value="Corpus Christi">Corpus Christi</option><br /> 
									<option value="Costa Mesa">Costa Mesa</option><br /> 
									<option value="Dallas">Dallas</option><br /> 
									<option value="Daly City">Daly City</option><br /> 
									<option value="Davenport">Davenport</option><br /> 
									<option value="Dayton">Dayton</option><br /> 
									<option value="Denton">Denton</option><br /> 
									<option value="Denver">Denver</option><br /> 
									<option value="Des Moines">Des Moines</option><br /> 
									<option value="Detroit">Detroit</option><br /> 
									<option value="Downey">Downey</option><br /> 
									<option value="Durham">Durham</option><br /> 
									<option value="El Monte">El Monte</option><br /> 
									<option value="El Paso">El Paso</option><br /> 
									<option value="Elgin">Elgin</option><br /> 
									<option value="Elizabeth">Elizabeth</option><br /> 
									<option value="Elk Grove">Elk Grove</option><br /> 
									<option value="Erie">Erie</option><br /> 
									<option value="Escondido">Escondido</option><br /> 
									<option value="Eugene">Eugene</option><br /> 
									<option value="Evansville">Evansville</option><br /> 
									<option value="Fairfield">Fairfield</option><br /> 
									<option value="Fayetteville">Fayetteville</option><br /> 
									<option value="Flint">Flint</option><br /> 
									<option value="Fontana">Fontana</option><br /> 
									<option value="Fort Collins">Fort Collins</option><br /> 
									<option value="Fort Lauderdale">Fort Lauderdale</option><br /> 
									<option value="Fort Wayne">Fort Wayne</option><br /> 
									<option value="Fort Worth">Fort Worth</option><br /> 
									<option value="Fremont">Fremont</option><br /> 
									<option value="Fresno">Fresno</option><br /> 
									<option value="Frisco">Frisco</option><br /> 
									<option value="Fullerton">Fullerton</option><br /> 
									<option value="Gainesville">Gainesville</option><br /> 
									<option value="Garden Grove">Garden Grove</option><br /> 
									<option value="Garland">Garland</option><br /> 
									<option value="Gilbert">Gilbert</option><br /> 
									<option value="Glendale">Glendale</option><br /> 
									<option value="Glendale">Glendale</option><br /> 
									<option value="Grand Prairie">Grand Prairie</option><br /> 
									<option value="Grand Rapids">Grand Rapids</option><br /> 
									<option value="Green Bay">Green Bay</option><br /> 
									<option value="Greensboro">Greensboro</option><br /> 
									<option value="Gresham">Gresham</option><br /> 
									<option value="Hampton">Hampton</option><br /> 
									<option value="Hartford">Hartford</option><br /> 
									<option value="Hayward">Hayward</option><br /> 
									<option value="Henderson">Henderson</option><br /> 
									<option value="Hialeah">Hialeah</option><br /> 
									<option value="High Point">High Point</option><br /> 
									<option value="Hollywood">Hollywood</option><br /> 
									<option value="Honolulu b[?]">Honolulu b[?]</option><br /> 
									<option value="Houston">Houston</option><br /> 
									<option value="Huntington Beach">Huntington Beach</option><br /> 
									<option value="Huntsville">Huntsville</option><br /> 
									<option value="Independence">Independence</option><br /> 
									<option value="Indianapolis">Indianapolis</option><br /> 
									<option value="Inglewood">Inglewood</option><br /> 
									<option value="Irvine">Irvine</option><br /> 
									<option value="Irving">Irving</option><br /> 
									<option value="Jackson">Jackson</option><br /> 
									<option value="Jacksonville">Jacksonville</option><br /> 
									<option value="Jersey City">Jersey City</option><br /> 
									<option value="Joliet">Joliet</option><br /> 
									<option value="Kansas City">Kansas City</option><br /> 
									<option value="Kansas City">Kansas City</option><br /> 
									<option value="Killeen">Killeen</option><br /> 
									<option value="Knoxville">Knoxville</option><br /> 
									<option value="Lafayette">Lafayette</option><br /> 
									<option value="Lakewood">Lakewood</option><br /> 
									<option value="Lancaster">Lancaster</option><br /> 
									<option value="Lansing">Lansing</option><br /> 
									<option value="Laredo">Laredo</option><br /> 
									<option value="Las Vegas">Las Vegas</option><br /> 
									<option value="Lewisville">Lewisville</option><br /> 
									<option value="Lexington">Lexington</option><br /> 
									<option value="Lincoln">Lincoln</option><br /> 
									<option value="Little Rock">Little Rock</option><br /> 
									<option value="Long Beach">Long Beach</option><br /> 
									<option value="Los Angeles">Los Angeles</option><br /> 
									<option value="Louisville">Louisville</option><br /> 
									<option value="Lowell">Lowell</option><br /> 
									<option value="Lubbock">Lubbock</option><br /> 
									<option value="Madison">Madison</option><br /> 
									<option value="Manchester">Manchester</option><br /> 
									<option value="McAllen">McAllen</option><br /> 
									<option value="McKinney">McKinney</option><br /> 
									<option value="Memphis">Memphis</option><br /> 
									<option value="Mesa">Mesa</option><br /> 
									<option value="Mesquite">Mesquite</option><br /> 
									<option value="Miami">Miami</option><br /> 
									<option value="Miami Gardens">Miami Gardens</option><br /> 
									<option value="Midland">Midland</option><br /> 
									<option value="Milwaukee">Milwaukee</option><br /> 
									<option value="Minneapolis">Minneapolis</option><br /> 
									<option value="Miramar">Miramar</option><br /> 
									<option value="Mobile">Mobile</option><br /> 
									<option value="Modesto">Modesto</option><br /> 
									<option value="Montgomery">Montgomery</option><br /> 
									<option value="Moreno Valley">Moreno Valley</option><br /> 
									<option value="Murfreesboro">Murfreesboro</option><br /> 
									<option value="Naperville">Naperville</option><br /> 
									<option value="Nashville">Nashville</option><br /> 
									<option value="New Haven">New Haven</option><br /> 
									<option value="New Orleans">New Orleans</option><br /> 
									<option value="New York">New York</option><br /> 
									<option value="Newark">Newark</option><br /> 
									<option value="Newport News">Newport News</option><br /> 
									<option value="Norfolk">Norfolk</option><br /> 
									<option value="Norman">Norman</option><br /> 
									<option value="North Las Vegas">North Las Vegas</option><br /> 
									<option value="Norwalk">Norwalk</option><br /> 
									<option value="Oakland">Oakland</option><br /> 
									<option value="Oceanside">Oceanside</option><br /> 
									<option value="Odessa">Odessa</option><br /> 
									<option value="Oklahoma City">Oklahoma City</option><br /> 
									<option value="Olathe">Olathe</option><br /> 
									<option value="Omaha">Omaha</option><br /> 
									<option value="Ontario">Ontario</option><br /> 
									<option value="Orange">Orange</option><br /> 
									<option value="Orlando">Orlando</option><br /> 
									<option value="Overland Park">Overland Park</option><br /> 
									<option value="Oxnard">Oxnard</option><br /> 
									<option value="Palm Bay">Palm Bay</option><br /> 
									<option value="Palmdale">Palmdale</option><br /> 
									<option value="Pasadena">Pasadena</option><br /> 
									<option value="Pasadena">Pasadena</option><br /> 
									<option value="Paterson">Paterson</option><br /> 
									<option value="Pembroke Pines">Pembroke Pines</option><br /> 
									<option value="Peoria">Peoria</option><br /> 
									<option value="Peoria">Peoria</option><br /> 
									<option value="Philadelphia">Philadelphia</option><br /> 
									<option value="Phoenix">Phoenix</option><br /> 
									<option value="Pittsburgh">Pittsburgh</option><br /> 
									<option value="Plano">Plano</option><br /> 
									<option value="Pomona">Pomona</option><br /> 
									<option value="Pompano Beach">Pompano Beach</option><br /> 
									<option value="Port St. Lucie">Port St. Lucie</option><br /> 
									<option value="Portland">Portland</option><br /> 
									<option value="Providence">Providence</option><br /> 
									<option value="Provo">Provo</option><br /> 
									<option value="Pueblo">Pueblo</option><br /> 
									<option value="Raleigh">Raleigh</option><br /> 
									<option value="Rancho Cucamonga">Rancho Cucamonga</option><br /> 
									<option value="Reno">Reno</option><br /> 
									<option value="Richardson">Richardson</option><br /> 
									<option value="Richmond">Richmond</option><br /> 
									<option value="Richmond">Richmond</option><br /> 
									<option value="Riverside">Riverside</option><br /> 
									<option value="Rochester">Rochester</option><br /> 
									<option value="Rochester">Rochester</option><br /> 
									<option value="Rockford">Rockford</option><br /> 
									<option value="Roseville">Roseville</option><br /> 
									<option value="Round Rock">Round Rock</option><br /> 
									<option value="Sacramento">Sacramento</option><br /> 
									<option value="Salem">Salem</option><br /> 
									<option value="Salinas">Salinas</option><br /> 
									<option value="Salt Lake City">Salt Lake City</option><br /> 
									<option value="San Antonio">San Antonio</option><br /> 
									<option value="San Bernardino">San Bernardino</option><br /> 
									<option value="San Buenaventura (Ventura)">San Buenaventura (Ventura)</option><br /> 
									<option value="San Diego">San Diego</option><br /> 
									<option value="San Francisco">San Francisco</option><br /> 
									<option value="San Jose">San Jose</option><br /> 
									<option value="Santa Ana">Santa Ana</option><br /> 
									<option value="Santa Clara">Santa Clara</option><br /> 
									<option value="Santa Clarita">Santa Clarita</option><br /> 
									<option value="Santa Rosa">Santa Rosa</option><br /> 
									<option value="Savannah">Savannah</option><br /> 
									<option value="Scottsdale">Scottsdale</option><br /> 
									<option value="Seattle">Seattle</option><br /> 
									<option value="Shreveport">Shreveport</option><br /> 
									<option value="Simi Valley">Simi Valley</option><br /> 
									<option value="Sioux Falls">Sioux Falls</option><br /> 
									<option value="South Bend">South Bend</option><br /> 
									<option value="Spokane">Spokane</option><br /> 
									<option value="Springfield">Springfield</option><br /> 
									<option value="Springfield">Springfield</option><br /> 
									<option value="Springfield">Springfield</option><br /> 
									<option value="St. Louis">St. Louis</option><br /> 
									<option value="St. Paul">St. Paul</option><br /> 
									<option value="St. Petersburg">St. Petersburg</option><br /> 
									<option value="Stamford">Stamford</option><br /> 
									<option value="Sterling Heights">Sterling Heights</option><br /> 
									<option value="Stockton">Stockton</option><br /> 
									<option value="Sunnyvale">Sunnyvale</option><br /> 
									<option value="Syracuse">Syracuse</option><br /> 
									<option value="Tacoma">Tacoma</option><br /> 
									<option value="Tallahassee">Tallahassee</option><br /> 
									<option value="Tampa">Tampa</option><br /> 
									<option value="Tempe">Tempe</option><br /> 
									<option value="Thornton">Thornton</option><br /> 
									<option value="Thousand Oaks">Thousand Oaks</option><br /> 
									<option value="Toledo">Toledo</option><br /> 
									<option value="Topeka">Topeka</option><br /> 
									<option value="Torrance">Torrance</option><br /> 
									<option value="Tucson">Tucson</option><br /> 
									<option value="Tulsa">Tulsa</option><br /> 
									<option value="Vallejo">Vallejo</option><br /> 
									<option value="Vancouver">Vancouver</option><br /> 
									<option value="Victorville">Victorville</option><br /> 
									<option value="Virginia Beach">Virginia Beach</option><br /> 
									<option value="Visalia">Visalia</option><br /> 
									<option value="Waco">Waco</option><br /> 
									<option value="Warren">Warren</option><br /> 
									<option value="Washington">Washington</option><br /> 
									<option value="Waterbury">Waterbury</option><br /> 
									<option value="West Covina">West Covina</option><br /> 
									<option value="West Jordan">West Jordan</option><br /> 
									<option value="West Valley City">West Valley City</option><br /> 
									<option value="Westminster">Westminster</option><br /> 
									<option value="Wichita">Wichita</option><br /> 
									<option value="Wichita Falls">Wichita Falls</option><br /> 
									<option value="Wilmington">Wilmington</option><br /> 
									<option value="Winston-Salem">Winston-Salem</option><br /> 
									<option value="Worcester">Worcester</option><br /> 
									<option value="Yonkers">Yonkers</option><br /> 
								</select><br />						</li>
								<li>
									<label for="State2">State</label>
									<select name="State2" size="1">
										<option selected value="">State...</option>
										<option value="ZZ">None</option>
										<option value="AL">Alabama</option>
										<option value="AK">Alaska</option>
										<option value="AZ">Arizona</option>
										<option value="AR">Arkansas</option>
										<option value="CA">California</option>
										<option value="CO">Colorado</option>
										<option value="CT">Connecticut</option>
										<option value="DE">Delaware</option>
										<option value="FL">Florida</option>
										<option value="GA">Georgia</option>
										<option value="HI">Hawaii</option>
										<option value="ID">Idaho</option>
										<option value="IL">Illinois</option>
										<option value="IN">Indiana</option>
										<option value="IA">Iowa</option>
										<option value="KS">Kansas</option>
										<option value="KY">Kentucky</option>
										<option value="LA">Louisiana</option>
										<option value="ME">Maine</option>
										<option value="MD">Maryland</option>
										<option value="MA">Massachusetts</option>
										<option value="MI">Michigan</option>
										<option value="MN">Minnesota</option>
										<option value="MS">Mississippi</option>
										<option value="MO">Missouri</option>
										<option value="MT">Montana</option>
										<option value="NE">Nebraska</option>
										<option value="NV">Nevada</option>
										<option value="NH">New Hampshire</option>
										<option value="NJ">New Jersey</option>
										<option value="NM">New Mexico</option>
										<option value="NY">New York</option>
										<option value="NC">North Carolina</option>
										<option value="ND">North Dakota</option>
										<option value="OH">Ohio</option>
										<option value="OK">Oklahoma</option>
										<option value="OR">Oregon</option>
										<option value="PA">Pennsylvania</option>
										<option value="RI">Rhode Island</option>
										<option value="SC">South Carolina</option>
										<option value="SD">South Dakota</option>
										<option value="TN">Tennessee</option>
										<option value="TX">Texas</option>
										<option value="UT">Utah</option>
										<option value="VT">Vermont</option>
										<option value="VA">Virginia</option>
										<option value="WA">Washington</option>
										<option value="WV">West Virginia</option>
										<option value="WI">Wisconsin</option>
										<option value="WY">Wyoming</option>
									</select>
								</li>
								<li>
									<label for="PostalCode2">Postal Code</label>
									<input id="PostalCode2" />
								</li>
								<li>
									<label for="Country2">Country</label>
									<select name="Country2">
										<option selected value="">Country...</option>
										<option value="ZZ">None</option>
										<option value="AF">Afghanistan</option>
										<option value="AX">Ã…Land Islands</option>
										<option value="AL">Albania</option>
										<option value="DZ">Algeria</option>
										<option value="AS">American Samoa</option>
										<option value="AD">Andorra</option>
										<option value="AO">Angola</option>
										<option value="AI">Anguilla</option>
										<option value="AQ">Antarctica</option>
										<option value="AG">Antigua And Barbuda</option>
										<option value="AR">Argentina</option>
										<option value="AM">Armenia</option>
										<option value="AW">Aruba</option>
										<option value="AU">Australia</option>
										<option value="AT">Austria</option>
										<option value="AZ">Azerbaijan</option>
										<option value="BS">Bahamas</option>
										<option value="BH">Bahrain</option>
										<option value="BD">Bangladesh</option>
										<option value="BB">Barbados</option>
										<option value="BY">Belarus</option>
										<option value="BE">Belgium</option>
										<option value="BZ">Belize</option>
										<option value="BJ">Benin</option>
										<option value="BM">Bermuda</option>
										<option value="BT">Bhutan</option>
										<option value="BO">Bolivia</option>
										<option value="BA">Bosnia And Herzegovina</option>
										<option value="BW">Botswana</option>
										<option value="BV">Bouvet Island</option>
										<option value="BR">Brazil</option>
										<option value="IO">British Indian Ocean Territory</option>
										<option value="BN">Brunei Darussalam</option>
										<option value="BG">Bulgaria</option>
										<option value="BF">Burkina Faso</option>
										<option value="BI">Burundi</option>
										<option value="KH">Cambodia</option>
										<option value="CM">Cameroon</option>
										<option value="CA">Canada</option>
										<option value="CV">Cape Verde</option>
										<option value="KY">Cayman Islands</option>
										<option value="CF">Central African Republic</option>
										<option value="TD">Chad</option>
										<option value="CL">Chile</option>
										<option value="CN">China</option>
										<option value="CX">Christmas Island</option>
										<option value="CC">Cocos (Keeling) Islands</option>
										<option value="CO">Colombia</option>
										<option value="KM">Comoros</option>
										<option value="CG">Congo</option>
										<option value="CD">Congo, The Democratic Republic Of The</option>
										<option value="CK">Cook Islands</option>
										<option value="CR">Costa Rica</option>
										<option value="CI">Cote D'Ivoire</option>
										<option value="HR">Croatia</option>
										<option value="CU">Cuba</option>
										<option value="CY">Cyprus</option>
										<option value="CZ">Czech Republic</option>
										<option value="DK">Denmark</option>
										<option value="DJ">Djibouti</option>
										<option value="DM">Dominica</option>
										<option value="DO">Dominican Republic</option>
										<option value="EC">Ecuador</option>
										<option value="EG">Egypt</option>
										<option value="SV">El Salvador</option>
										<option value="GQ">Equatorial Guinea</option>
										<option value="ER">Eritrea</option>
										<option value="EE">Estonia</option>
										<option value="ET">Ethiopia</option>
										<option value="FK">Falkland Islands (Malvinas)</option>
										<option value="FO">Faroe Islands</option>
										<option value="FJ">Fiji</option>
										<option value="FI">Finland</option>
										<option value="FR">France</option>
										<option value="GF">French Guiana</option>
										<option value="PF">French Polynesia</option>
										<option value="TF">French Southern Territories</option>
										<option value="GA">Gabon</option>
										<option value="GM">Gambia</option>
										<option value="GE">Georgia</option>
										<option value="DE">Germany</option>
										<option value="GH">Ghana</option>
										<option value="GI">Gibraltar</option>
										<option value="GR">Greece</option>
										<option value="GL">Greenland</option>
										<option value="GD">Grenada</option>
										<option value="GP">Guadeloupe</option>
										<option value="GU">Guam</option>
										<option value="GT">Guatemala</option>
										<option value=" Gg">Guernsey</option>
										<option value="GN">Guinea</option>
										<option value="GW">Guinea-Bissau</option>
										<option value="GY">Guyana</option>
										<option value="HT">Haiti</option>
										<option value="HM">Heard Island And Mcdonald Islands</option>
										<option value="VA">Holy See (Vatican City State)</option>
										<option value="HN">Honduras</option>
										<option value="HK">Hong Kong</option>
										<option value="HU">Hungary</option>
										<option value="IS">Iceland</option>
										<option value="IN">India</option>
										<option value="ID">Indonesia</option>
										<option value="IR">Iran, Islamic Republic Of</option>
										<option value="IQ">Iraq</option>
										<option value="IE">Ireland</option>
										<option value="IM">Isle Of Man</option>
										<option value="IL">Israel</option>
										<option value="IT">Italy</option>
										<option value="JM">Jamaica</option>
										<option value="JP">Japan</option>
										<option value="JE">Jersey</option>
										<option value="JO">Jordan</option>
										<option value="KZ">Kazakhstan</option>
										<option value="KE">Kenya</option>
										<option value="KI">Kiribati</option>
										<option value="KP">Korea, Democratic People'S Republic Of</option>
										<option value="KR">Korea, Republic Of</option>
										<option value="KW">Kuwait</option>
										<option value="KG">Kyrgyzstan</option>
										<option value="LA">Lao People'S Democratic Republic</option>
										<option value="LV">Latvia</option>
										<option value="LB">Lebanon</option>
										<option value="LS">Lesotho</option>
										<option value="LR">Liberia</option>
										<option value="LY">Libyan Arab Jamahiriya</option>
										<option value="LI">Liechtenstein</option>
										<option value="LT">Lithuania</option>
										<option value="LU">Luxembourg</option>
										<option value="MO">Macao</option>
										<option value="MK">Macedonia, The Former Yugoslav Republic Of</option>
										<option value="MG">Madagascar</option>
										<option value="MW">Malawi</option>
										<option value="MY">Malaysia</option>
										<option value="MV">Maldives</option>
										<option value="ML">Mali</option>
										<option value="MT">Malta</option>
										<option value="MH">Marshall Islands</option>
										<option value="MQ">Martinique</option>
										<option value="MR">Mauritania</option>
										<option value="MU">Mauritius</option>
										<option value="YT">Mayotte</option>
										<option value="MX">Mexico</option>
										<option value="FM">Micronesia, Federated States Of</option>
										<option value="MD">Moldova, Republic Of</option>
										<option value="MC">Monaco</option>
										<option value="MN">Mongolia</option>
										<option value="MS">Montserrat</option>
										<option value="MA">Morocco</option>
										<option value="MZ">Mozambique</option>
										<option value="MM">Myanmar</option>
										<option value="NA">Namibia</option>
										<option value="NR">Nauru</option>
										<option value="NP">Nepal</option>
										<option value="NL">Netherlands</option>
										<option value="AN">Netherlands Antilles</option>
										<option value="NC">New Caledonia</option>
										<option value="NZ">New Zealand</option>
										<option value="NI">Nicaragua</option>
										<option value="NE">Niger</option>
										<option value="NG">Nigeria</option>
										<option value="NU">Niue</option>
										<option value="NF">Norfolk Island</option>
										<option value="MP">Northern Mariana Islands</option>
										<option value="NO">Norway</option>
										<option value="OM">Oman</option>
										<option value="PK">Pakistan</option>
										<option value="PW">Palau</option>
										<option value="PS">Palestinian Territory, Occupied</option>
										<option value="PA">Panama</option>
										<option value="PG">Papua New Guinea</option>
										<option value="PY">Paraguay</option>
										<option value="PE">Peru</option>
										<option value="PH">Philippines</option>
										<option value="PN">Pitcairn</option>
										<option value="PL">Poland</option>
										<option value="PT">Portugal</option>
										<option value="PR">Puerto Rico</option>
										<option value="QA">Qatar</option>
										<option value="RE">Reunion</option>
										<option value="RO">Romania</option>
										<option value="RU">Russian Federation</option>
										<option value="RW">Rwanda</option>
										<option value="SH">Saint Helena</option>
										<option value="KN">Saint Kitts And Nevis</option>
										<option value="LC">Saint Lucia</option>
										<option value="PM">Saint Pierre And Miquelon</option>
										<option value="VC">Saint Vincent And The Grenadines</option>
										<option value="WS">Samoa</option>
										<option value="SM">San Marino</option>
										<option value="ST">Sao Tome And Principe</option>
										<option value="SA">Saudi Arabia</option>
										<option value="SN">Senegal</option>
										<option value="CS">Serbia And Montenegro</option>
										<option value="SC">Seychelles</option>
										<option value="SL">Sierra Leone</option>
										<option value="SG">Singapore</option>
										<option value="SK">Slovakia</option>
										<option value="SI">Slovenia</option>
										<option value="SB">Solomon Islands</option>
										<option value="SO">Somalia</option>
										<option value="ZA">South Africa</option>
										<option value="GS">South Georgia And The South Sandwich Islands</option>
										<option value="ES">Spain</option>
										<option value="LK">Sri Lanka</option>
										<option value="SD">Sudan</option>
										<option value="SR">Suriname</option>
										<option value="SJ">Svalbard And Jan Mayen</option>
										<option value="SZ">Swaziland</option>
										<option value="SE">Sweden</option>
										<option value="CH">Switzerland</option>
										<option value="SY">Syrian Arab Republic</option>
										<option value="TW">Taiwan, Province Of China</option>
										<option value="TJ">Tajikistan</option>
										<option value="TZ">Tanzania, United Republic Of</option>
										<option value="TH">Thailand</option>
										<option value="TL">Timor-Leste</option>
										<option value="TG">Togo</option>
										<option value="TK">Tokelau</option>
										<option value="TO">Tonga</option>
										<option value="TT">Trinidad And Tobago</option>
										<option value="TN">Tunisia</option>
										<option value="TR">Turkey</option>
										<option value="TM">Turkmenistan</option>
										<option value="TC">Turks And Caicos Islands</option>
										<option value="TV">Tuvalu</option>
										<option value="UG">Uganda</option>
										<option value="UA">Ukraine</option>
										<option value="AE">United Arab Emirates</option>
										<option value="GB">United Kingdom</option>
										<option value="US">United States</option>
										<option value="UM">United States Minor Outlying Islands</option>
										<option value="UY">Uruguay</option>
										<option value="UZ">Uzbekistan</option>
										<option value="VU">Vanuatu</option>
										<option value="VE">Venezuela</option>
										<option value="VN">Viet Nam</option>
										<option value="VG">Virgin Islands, British</option>
										<option value="VI">Virgin Islands, U.S.</option>
										<option value="WF">Wallis And Futuna</option>
										<option value="EH">Western Sahara</option>
										<option value="YE">Yemen</option>
										<option value="ZM">Zambia</option>
										<option value="ZW">Zimbabwe</option>
									</select>
								</li>
								<li>
									<label for="Phone2">Phone</label>
									<input name="Phone2" />
								</li>
								<li>
									<label for="Email2">Email<em>*</em></label>
									<input size="40" name="Email2" id="Email2" />
								</li>
								<li>
									<label style="width:270px" for="Digits2">UNFCU 7-Digit Member Number<br />(if applicable)</label>
									<input size="7" maxlength="7" name="Digits2" id="Digits2" />
								</li>
								<br />		

							</ol>

							<legend><span>High School Information</span></legend>
							<ol>
								<li>
									<label style="width:210px" for="Highschool">High School/<br/>Secondary School Name<em>*</em></label>
									<input size="42px" name="Highschool" id="Highschool"/>	
								</li>
								<li>
									<label style="width:120px" for="SchoolAddress">Address</label>
									<input size="60px" name="SchoolAddress" id="SchoolAddress"/>	
								</li>
								<li>
									<label for="City3">City</label>
									<select name="City3"><br /> 
										<option selected value="">City...</option>
										<option value="Abilene">Abilene</option><br /> 
										<option value="Akron">Akron</option><br /> 
										<option value="Albuquerque">Albuquerque</option><br /> 
										<option value="Alexandria">Alexandria</option><br /> 
										<option value="Allentown">Allentown</option><br /> 
										<option value="Amarillo">Amarillo</option><br /> 
										<option value="Anaheim">Anaheim</option><br /> 
										<option value="Anchorage">Anchorage</option><br /> 
										<option value="Ann Arbor">Ann Arbor</option><br /> 
										<option value="Antioch">Antioch</option><br /> 
										<option value="Arlington">Arlington</option><br /> 
										<option value="Arlington">Arlington</option><br /> 
										<option value="Arvada">Arvada</option><br /> 
										<option value="Athens">Athens</option><br /> 
										<option value="Atlanta">Atlanta</option><br /> 
										<option value="Augusta">Augusta</option><br /> 
										<option value="Aurora">Aurora</option><br /> 
										<option value="Aurora">Aurora</option><br /> 
										<option value="Austin">Austin</option><br /> 
										<option value="Bakersfield">Bakersfield</option><br /> 
										<option value="Baltimore">Baltimore</option><br /> 
										<option value="Baton Rouge">Baton Rouge</option><br /> 
										<option value="Beaumont">Beaumont</option><br /> 
										<option value="Bellevue">Bellevue</option><br /> 
										<option value="Berkeley">Berkeley</option><br /> 
										<option value="Billings">Billings</option><br /> 
										<option value="Birmingham">Birmingham</option><br /> 
										<option value="Boise">Boise</option><br /> 
										<option value="Boston">Boston</option><br /> 
										<option value="Boulder">Boulder</option><br /> 
										<option value="Bridgeport">Bridgeport</option><br /> 
										<option value="Brownsville">Brownsville</option><br /> 
										<option value="Buffalo">Buffalo</option><br /> 
										<option value="Burbank">Burbank</option><br /> 
										<option value="Cambridge">Cambridge</option><br /> 
										<option value="Cape Coral">Cape Coral</option><br /> 
										<option value="Carrollton">Carrollton</option><br /> 
										<option value="Cary">Cary</option><br /> 
										<option value="Cedar Rapids">Cedar Rapids</option><br /> 
										<option value="Centennial">Centennial</option><br /> 
										<option value="Chandler">Chandler</option><br /> 
										<option value="Charleston">Charleston</option><br /> 
										<option value="Charlotte">Charlotte</option><br /> 
										<option value="Chattanooga">Chattanooga</option><br /> 
										<option value="Chesapeake">Chesapeake</option><br /> 
										<option value="Chicago">Chicago</option><br /> 
										<option value="Chula Vista">Chula Vista</option><br /> 
										<option value="Cincinnati">Cincinnati</option><br /> 
										<option value="Clarksville">Clarksville</option><br /> 
										<option value="Clearwater">Clearwater</option><br /> 
										<option value="Cleveland">Cleveland</option><br /> 
										<option value="Colorado Springs">Colorado Springs</option><br /> 
										<option value="Columbia">Columbia</option><br /> 
										<option value="Columbia">Columbia</option><br /> 
										<option value="Columbus">Columbus</option><br /> 
										<option value="Columbus">Columbus</option><br /> 
										<option value="Concord">Concord</option><br /> 
										<option value="Coral Springs">Coral Springs</option><br /> 
										<option value="Corona">Corona</option><br /> 
										<option value="Corpus Christi">Corpus Christi</option><br /> 
										<option value="Costa Mesa">Costa Mesa</option><br /> 
										<option value="Dallas">Dallas</option><br /> 
										<option value="Daly City">Daly City</option><br /> 
										<option value="Davenport">Davenport</option><br /> 
										<option value="Dayton">Dayton</option><br /> 
										<option value="Denton">Denton</option><br /> 
										<option value="Denver">Denver</option><br /> 
										<option value="Des Moines">Des Moines</option><br /> 
										<option value="Detroit">Detroit</option><br /> 
										<option value="Downey">Downey</option><br /> 
										<option value="Durham">Durham</option><br /> 
										<option value="El Monte">El Monte</option><br /> 
										<option value="El Paso">El Paso</option><br /> 
										<option value="Elgin">Elgin</option><br /> 
										<option value="Elizabeth">Elizabeth</option><br /> 
										<option value="Elk Grove">Elk Grove</option><br /> 
										<option value="Erie">Erie</option><br /> 
										<option value="Escondido">Escondido</option><br /> 
										<option value="Eugene">Eugene</option><br /> 
										<option value="Evansville">Evansville</option><br /> 
										<option value="Fairfield">Fairfield</option><br /> 
										<option value="Fayetteville">Fayetteville</option><br /> 
										<option value="Flint">Flint</option><br /> 
										<option value="Fontana">Fontana</option><br /> 
										<option value="Fort Collins">Fort Collins</option><br /> 
										<option value="Fort Lauderdale">Fort Lauderdale</option><br /> 
										<option value="Fort Wayne">Fort Wayne</option><br /> 
										<option value="Fort Worth">Fort Worth</option><br /> 
										<option value="Fremont">Fremont</option><br /> 
										<option value="Fresno">Fresno</option><br /> 
										<option value="Frisco">Frisco</option><br /> 
										<option value="Fullerton">Fullerton</option><br /> 
										<option value="Gainesville">Gainesville</option><br /> 
										<option value="Garden Grove">Garden Grove</option><br /> 
										<option value="Garland">Garland</option><br /> 
										<option value="Gilbert">Gilbert</option><br /> 
										<option value="Glendale">Glendale</option><br /> 
										<option value="Glendale">Glendale</option><br /> 
										<option value="Grand Prairie">Grand Prairie</option><br /> 
										<option value="Grand Rapids">Grand Rapids</option><br /> 
										<option value="Green Bay">Green Bay</option><br /> 
										<option value="Greensboro">Greensboro</option><br /> 
										<option value="Gresham">Gresham</option><br /> 
										<option value="Hampton">Hampton</option><br /> 
										<option value="Hartford">Hartford</option><br /> 
										<option value="Hayward">Hayward</option><br /> 
										<option value="Henderson">Henderson</option><br /> 
										<option value="Hialeah">Hialeah</option><br /> 
										<option value="High Point">High Point</option><br /> 
										<option value="Hollywood">Hollywood</option><br /> 
										<option value="Honolulu b[?]">Honolulu b[?]</option><br /> 
										<option value="Houston">Houston</option><br /> 
										<option value="Huntington Beach">Huntington Beach</option><br /> 
										<option value="Huntsville">Huntsville</option><br /> 
										<option value="Independence">Independence</option><br /> 
										<option value="Indianapolis">Indianapolis</option><br /> 
										<option value="Inglewood">Inglewood</option><br /> 
										<option value="Irvine">Irvine</option><br /> 
										<option value="Irving">Irving</option><br /> 
										<option value="Jackson">Jackson</option><br /> 
										<option value="Jacksonville">Jacksonville</option><br /> 
										<option value="Jersey City">Jersey City</option><br /> 
										<option value="Joliet">Joliet</option><br /> 
										<option value="Kansas City">Kansas City</option><br /> 
										<option value="Kansas City">Kansas City</option><br /> 
										<option value="Killeen">Killeen</option><br /> 
										<option value="Knoxville">Knoxville</option><br /> 
										<option value="Lafayette">Lafayette</option><br /> 
										<option value="Lakewood">Lakewood</option><br /> 
										<option value="Lancaster">Lancaster</option><br /> 
										<option value="Lansing">Lansing</option><br /> 
										<option value="Laredo">Laredo</option><br /> 
										<option value="Las Vegas">Las Vegas</option><br /> 
										<option value="Lewisville">Lewisville</option><br /> 
										<option value="Lexington">Lexington</option><br /> 
										<option value="Lincoln">Lincoln</option><br /> 
										<option value="Little Rock">Little Rock</option><br /> 
										<option value="Long Beach">Long Beach</option><br /> 
										<option value="Los Angeles">Los Angeles</option><br /> 
										<option value="Louisville">Louisville</option><br /> 
										<option value="Lowell">Lowell</option><br /> 
										<option value="Lubbock">Lubbock</option><br /> 
										<option value="Madison">Madison</option><br /> 
										<option value="Manchester">Manchester</option><br /> 
										<option value="McAllen">McAllen</option><br /> 
										<option value="McKinney">McKinney</option><br /> 
										<option value="Memphis">Memphis</option><br /> 
										<option value="Mesa">Mesa</option><br /> 
										<option value="Mesquite">Mesquite</option><br /> 
										<option value="Miami">Miami</option><br /> 
										<option value="Miami Gardens">Miami Gardens</option><br /> 
										<option value="Midland">Midland</option><br /> 
										<option value="Milwaukee">Milwaukee</option><br /> 
										<option value="Minneapolis">Minneapolis</option><br /> 
										<option value="Miramar">Miramar</option><br /> 
										<option value="Mobile">Mobile</option><br /> 
										<option value="Modesto">Modesto</option><br /> 
										<option value="Montgomery">Montgomery</option><br /> 
										<option value="Moreno Valley">Moreno Valley</option><br /> 
										<option value="Murfreesboro">Murfreesboro</option><br /> 
										<option value="Naperville">Naperville</option><br /> 
										<option value="Nashville">Nashville</option><br /> 
										<option value="New Haven">New Haven</option><br /> 
										<option value="New Orleans">New Orleans</option><br /> 
										<option value="New York">New York</option><br /> 
										<option value="Newark">Newark</option><br /> 
										<option value="Newport News">Newport News</option><br /> 
										<option value="Norfolk">Norfolk</option><br /> 
										<option value="Norman">Norman</option><br /> 
										<option value="North Las Vegas">North Las Vegas</option><br /> 
										<option value="Norwalk">Norwalk</option><br /> 
										<option value="Oakland">Oakland</option><br /> 
										<option value="Oceanside">Oceanside</option><br /> 
										<option value="Odessa">Odessa</option><br /> 
										<option value="Oklahoma City">Oklahoma City</option><br /> 
										<option value="Olathe">Olathe</option><br /> 
										<option value="Omaha">Omaha</option><br /> 
										<option value="Ontario">Ontario</option><br /> 
										<option value="Orange">Orange</option><br /> 
										<option value="Orlando">Orlando</option><br /> 
										<option value="Overland Park">Overland Park</option><br /> 
										<option value="Oxnard">Oxnard</option><br /> 
										<option value="Palm Bay">Palm Bay</option><br /> 
										<option value="Palmdale">Palmdale</option><br /> 
										<option value="Pasadena">Pasadena</option><br /> 
										<option value="Pasadena">Pasadena</option><br /> 
										<option value="Paterson">Paterson</option><br /> 
										<option value="Pembroke Pines">Pembroke Pines</option><br /> 
										<option value="Peoria">Peoria</option><br /> 
										<option value="Peoria">Peoria</option><br /> 
										<option value="Philadelphia">Philadelphia</option><br /> 
										<option value="Phoenix">Phoenix</option><br /> 
										<option value="Pittsburgh">Pittsburgh</option><br /> 
										<option value="Plano">Plano</option><br /> 
										<option value="Pomona">Pomona</option><br /> 
										<option value="Pompano Beach">Pompano Beach</option><br /> 
										<option value="Port St. Lucie">Port St. Lucie</option><br /> 
										<option value="Portland">Portland</option><br /> 
										<option value="Providence">Providence</option><br /> 
										<option value="Provo">Provo</option><br /> 
										<option value="Pueblo">Pueblo</option><br /> 
										<option value="Raleigh">Raleigh</option><br /> 
										<option value="Rancho Cucamonga">Rancho Cucamonga</option><br /> 
										<option value="Reno">Reno</option><br /> 
										<option value="Richardson">Richardson</option><br /> 
										<option value="Richmond">Richmond</option><br /> 
										<option value="Richmond">Richmond</option><br /> 
										<option value="Riverside">Riverside</option><br /> 
										<option value="Rochester">Rochester</option><br /> 
										<option value="Rochester">Rochester</option><br /> 
										<option value="Rockford">Rockford</option><br /> 
										<option value="Roseville">Roseville</option><br /> 
										<option value="Round Rock">Round Rock</option><br /> 
										<option value="Sacramento">Sacramento</option><br /> 
										<option value="Salem">Salem</option><br /> 
										<option value="Salinas">Salinas</option><br /> 
										<option value="Salt Lake City">Salt Lake City</option><br /> 
										<option value="San Antonio">San Antonio</option><br /> 
										<option value="San Bernardino">San Bernardino</option><br /> 
										<option value="San Buenaventura (Ventura)">San Buenaventura (Ventura)</option><br /> 
										<option value="San Diego">San Diego</option><br /> 
										<option value="San Francisco">San Francisco</option><br /> 
										<option value="San Jose">San Jose</option><br /> 
										<option value="Santa Ana">Santa Ana</option><br /> 
										<option value="Santa Clara">Santa Clara</option><br /> 
										<option value="Santa Clarita">Santa Clarita</option><br /> 
										<option value="Santa Rosa">Santa Rosa</option><br /> 
										<option value="Savannah">Savannah</option><br /> 
										<option value="Scottsdale">Scottsdale</option><br /> 
										<option value="Seattle">Seattle</option><br /> 
										<option value="Shreveport">Shreveport</option><br /> 
										<option value="Simi Valley">Simi Valley</option><br /> 
										<option value="Sioux Falls">Sioux Falls</option><br /> 
										<option value="South Bend">South Bend</option><br /> 
										<option value="Spokane">Spokane</option><br /> 
										<option value="Springfield">Springfield</option><br /> 
										<option value="Springfield">Springfield</option><br /> 
										<option value="Springfield">Springfield</option><br /> 
										<option value="St. Louis">St. Louis</option><br /> 
										<option value="St. Paul">St. Paul</option><br /> 
										<option value="St. Petersburg">St. Petersburg</option><br /> 
										<option value="Stamford">Stamford</option><br /> 
										<option value="Sterling Heights">Sterling Heights</option><br /> 
										<option value="Stockton">Stockton</option><br /> 
										<option value="Sunnyvale">Sunnyvale</option><br /> 
										<option value="Syracuse">Syracuse</option><br /> 
										<option value="Tacoma">Tacoma</option><br /> 
										<option value="Tallahassee">Tallahassee</option><br /> 
										<option value="Tampa">Tampa</option><br /> 
										<option value="Tempe">Tempe</option><br /> 
										<option value="Thornton">Thornton</option><br /> 
										<option value="Thousand Oaks">Thousand Oaks</option><br /> 
										<option value="Toledo">Toledo</option><br /> 
										<option value="Topeka">Topeka</option><br /> 
										<option value="Torrance">Torrance</option><br /> 
										<option value="Tucson">Tucson</option><br /> 
										<option value="Tulsa">Tulsa</option><br /> 
										<option value="Vallejo">Vallejo</option><br /> 
										<option value="Vancouver">Vancouver</option><br /> 
										<option value="Victorville">Victorville</option><br /> 
										<option value="Virginia Beach">Virginia Beach</option><br /> 
										<option value="Visalia">Visalia</option><br /> 
										<option value="Waco">Waco</option><br /> 
										<option value="Warren">Warren</option><br /> 
										<option value="Washington">Washington</option><br /> 
										<option value="Waterbury">Waterbury</option><br /> 
										<option value="West Covina">West Covina</option><br /> 
										<option value="West Jordan">West Jordan</option><br /> 
										<option value="West Valley City">West Valley City</option><br /> 
										<option value="Westminster">Westminster</option><br /> 
										<option value="Wichita">Wichita</option><br /> 
										<option value="Wichita Falls">Wichita Falls</option><br /> 
										<option value="Wilmington">Wilmington</option><br /> 
										<option value="Winston-Salem">Winston-Salem</option><br /> 
										<option value="Worcester">Worcester</option><br /> 
										<option value="Yonkers">Yonkers</option><br /> 
									</select><br />						</li>
									<li>
										<label for="State3">State</label>
										<select name="State3" size="1">
											<option selected value="">State...</option>
											<option value="ZZ">None</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC">North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
									</li>
									<li>
										<label for="PostalCode3">Postal Code</label>
										<input name="PostalCode3" />
									</li>
									<li>
										<label for="Country3">Country</label>
										<select name="Country3">
											<option selected value="">Country...</option>
											<option value="ZZ">None</option>
											<option value="AF">Afghanistan</option>
											<option value="AX">Ã…Land Islands</option>
											<option value="AL">Albania</option>
											<option value="DZ">Algeria</option>
											<option value="AS">American Samoa</option>
											<option value="AD">Andorra</option>
											<option value="AO">Angola</option>
											<option value="AI">Anguilla</option>
											<option value="AQ">Antarctica</option>
											<option value="AG">Antigua And Barbuda</option>
											<option value="AR">Argentina</option>
											<option value="AM">Armenia</option>
											<option value="AW">Aruba</option>
											<option value="AU">Australia</option>
											<option value="AT">Austria</option>
											<option value="AZ">Azerbaijan</option>
											<option value="BS">Bahamas</option>
											<option value="BH">Bahrain</option>
											<option value="BD">Bangladesh</option>
											<option value="BB">Barbados</option>
											<option value="BY">Belarus</option>
											<option value="BE">Belgium</option>
											<option value="BZ">Belize</option>
											<option value="BJ">Benin</option>
											<option value="BM">Bermuda</option>
											<option value="BT">Bhutan</option>
											<option value="BO">Bolivia</option>
											<option value="BA">Bosnia And Herzegovina</option>
											<option value="BW">Botswana</option>
											<option value="BV">Bouvet Island</option>
											<option value="BR">Brazil</option>
											<option value="IO">British Indian Ocean Territory</option>
											<option value="BN">Brunei Darussalam</option>
											<option value="BG">Bulgaria</option>
											<option value="BF">Burkina Faso</option>
											<option value="BI">Burundi</option>
											<option value="KH">Cambodia</option>
											<option value="CM">Cameroon</option>
											<option value="CA">Canada</option>
											<option value="CV">Cape Verde</option>
											<option value="KY">Cayman Islands</option>
											<option value="CF">Central African Republic</option>
											<option value="TD">Chad</option>
											<option value="CL">Chile</option>
											<option value="CN">China</option>
											<option value="CX">Christmas Island</option>
											<option value="CC">Cocos (Keeling) Islands</option>
											<option value="CO">Colombia</option>
											<option value="KM">Comoros</option>
											<option value="CG">Congo</option>
											<option value="CD">Congo, The Democratic Republic Of The</option>
											<option value="CK">Cook Islands</option>
											<option value="CR">Costa Rica</option>
											<option value="CI">Cote D'Ivoire</option>
											<option value="HR">Croatia</option>
											<option value="CU">Cuba</option>
											<option value="CY">Cyprus</option>
											<option value="CZ">Czech Republic</option>
											<option value="DK">Denmark</option>
											<option value="DJ">Djibouti</option>
											<option value="DM">Dominica</option>
											<option value="DO">Dominican Republic</option>
											<option value="EC">Ecuador</option>
											<option value="EG">Egypt</option>
											<option value="SV">El Salvador</option>
											<option value="GQ">Equatorial Guinea</option>
											<option value="ER">Eritrea</option>
											<option value="EE">Estonia</option>
											<option value="ET">Ethiopia</option>
											<option value="FK">Falkland Islands (Malvinas)</option>
											<option value="FO">Faroe Islands</option>
											<option value="FJ">Fiji</option>
											<option value="FI">Finland</option>
											<option value="FR">France</option>
											<option value="GF">French Guiana</option>
											<option value="PF">French Polynesia</option>
											<option value="TF">French Southern Territories</option>
											<option value="GA">Gabon</option>
											<option value="GM">Gambia</option>
											<option value="GE">Georgia</option>
											<option value="DE">Germany</option>
											<option value="GH">Ghana</option>
											<option value="GI">Gibraltar</option>
											<option value="GR">Greece</option>
											<option value="GL">Greenland</option>
											<option value="GD">Grenada</option>
											<option value="GP">Guadeloupe</option>
											<option value="GU">Guam</option>
											<option value="GT">Guatemala</option>
											<option value=" Gg">Guernsey</option>
											<option value="GN">Guinea</option>
											<option value="GW">Guinea-Bissau</option>
											<option value="GY">Guyana</option>
											<option value="HT">Haiti</option>
											<option value="HM">Heard Island And Mcdonald Islands</option>
											<option value="VA">Holy See (Vatican City State)</option>
											<option value="HN">Honduras</option>
											<option value="HK">Hong Kong</option>
											<option value="HU">Hungary</option>
											<option value="IS">Iceland</option>
											<option value="IN">India</option>
											<option value="ID">Indonesia</option>
											<option value="IR">Iran, Islamic Republic Of</option>
											<option value="IQ">Iraq</option>
											<option value="IE">Ireland</option>
											<option value="IM">Isle Of Man</option>
											<option value="IL">Israel</option>
											<option value="IT">Italy</option>
											<option value="JM">Jamaica</option>
											<option value="JP">Japan</option>
											<option value="JE">Jersey</option>
											<option value="JO">Jordan</option>
											<option value="KZ">Kazakhstan</option>
											<option value="KE">Kenya</option>
											<option value="KI">Kiribati</option>
											<option value="KP">Korea, Democratic People'S Republic Of</option>
											<option value="KR">Korea, Republic Of</option>
											<option value="KW">Kuwait</option>
											<option value="KG">Kyrgyzstan</option>
											<option value="LA">Lao People'S Democratic Republic</option>
											<option value="LV">Latvia</option>
											<option value="LB">Lebanon</option>
											<option value="LS">Lesotho</option>
											<option value="LR">Liberia</option>
											<option value="LY">Libyan Arab Jamahiriya</option>
											<option value="LI">Liechtenstein</option>
											<option value="LT">Lithuania</option>
											<option value="LU">Luxembourg</option>
											<option value="MO">Macao</option>
											<option value="MK">Macedonia, The Former Yugoslav Republic Of</option>
											<option value="MG">Madagascar</option>
											<option value="MW">Malawi</option>
											<option value="MY">Malaysia</option>
											<option value="MV">Maldives</option>
											<option value="ML">Mali</option>
											<option value="MT">Malta</option>
											<option value="MH">Marshall Islands</option>
											<option value="MQ">Martinique</option>
											<option value="MR">Mauritania</option>
											<option value="MU">Mauritius</option>
											<option value="YT">Mayotte</option>
											<option value="MX">Mexico</option>
											<option value="FM">Micronesia, Federated States Of</option>
											<option value="MD">Moldova, Republic Of</option>
											<option value="MC">Monaco</option>
											<option value="MN">Mongolia</option>
											<option value="MS">Montserrat</option>
											<option value="MA">Morocco</option>
											<option value="MZ">Mozambique</option>
											<option value="MM">Myanmar</option>
											<option value="NA">Namibia</option>
											<option value="NR">Nauru</option>
											<option value="NP">Nepal</option>
											<option value="NL">Netherlands</option>
											<option value="AN">Netherlands Antilles</option>
											<option value="NC">New Caledonia</option>
											<option value="NZ">New Zealand</option>
											<option value="NI">Nicaragua</option>
											<option value="NE">Niger</option>
											<option value="NG">Nigeria</option>
											<option value="NU">Niue</option>
											<option value="NF">Norfolk Island</option>
											<option value="MP">Northern Mariana Islands</option>
											<option value="NO">Norway</option>
											<option value="OM">Oman</option>
											<option value="PK">Pakistan</option>
											<option value="PW">Palau</option>
											<option value="PS">Palestinian Territory, Occupied</option>
											<option value="PA">Panama</option>
											<option value="PG">Papua New Guinea</option>
											<option value="PY">Paraguay</option>
											<option value="PE">Peru</option>
											<option value="PH">Philippines</option>
											<option value="PN">Pitcairn</option>
											<option value="PL">Poland</option>
											<option value="PT">Portugal</option>
											<option value="PR">Puerto Rico</option>
											<option value="QA">Qatar</option>
											<option value="RE">Reunion</option>
											<option value="RO">Romania</option>
											<option value="RU">Russian Federation</option>
											<option value="RW">Rwanda</option>
											<option value="SH">Saint Helena</option>
											<option value="KN">Saint Kitts And Nevis</option>
											<option value="LC">Saint Lucia</option>
											<option value="PM">Saint Pierre And Miquelon</option>
											<option value="VC">Saint Vincent And The Grenadines</option>
											<option value="WS">Samoa</option>
											<option value="SM">San Marino</option>
											<option value="ST">Sao Tome And Principe</option>
											<option value="SA">Saudi Arabia</option>
											<option value="SN">Senegal</option>
											<option value="CS">Serbia And Montenegro</option>
											<option value="SC">Seychelles</option>
											<option value="SL">Sierra Leone</option>
											<option value="SG">Singapore</option>
											<option value="SK">Slovakia</option>
											<option value="SI">Slovenia</option>
											<option value="SB">Solomon Islands</option>
											<option value="SO">Somalia</option>
											<option value="ZA">South Africa</option>
											<option value="GS">South Georgia And The South Sandwich Islands</option>
											<option value="ES">Spain</option>
											<option value="LK">Sri Lanka</option>
											<option value="SD">Sudan</option>
											<option value="SR">Suriname</option>
											<option value="SJ">Svalbard And Jan Mayen</option>
											<option value="SZ">Swaziland</option>
											<option value="SE">Sweden</option>
											<option value="CH">Switzerland</option>
											<option value="SY">Syrian Arab Republic</option>
											<option value="TW">Taiwan, Province Of China</option>
											<option value="TJ">Tajikistan</option>
											<option value="TZ">Tanzania, United Republic Of</option>
											<option value="TH">Thailand</option>
											<option value="TL">Timor-Leste</option>
											<option value="TG">Togo</option>
											<option value="TK">Tokelau</option>
											<option value="TO">Tonga</option>
											<option value="TT">Trinidad And Tobago</option>
											<option value="TN">Tunisia</option>
											<option value="TR">Turkey</option>
											<option value="TM">Turkmenistan</option>
											<option value="TC">Turks And Caicos Islands</option>
											<option value="TV">Tuvalu</option>
											<option value="UG">Uganda</option>
											<option value="UA">Ukraine</option>
											<option value="AE">United Arab Emirates</option>
											<option value="GB">United Kingdom</option>
											<option value="US">United States</option>
											<option value="UM">United States Minor Outlying Islands</option>
											<option value="UY">Uruguay</option>
											<option value="UZ">Uzbekistan</option>
											<option value="VU">Vanuatu</option>
											<option value="VE">Venezuela</option>
											<option value="VN">Viet Nam</option>
											<option value="VG">Virgin Islands, British</option>
											<option value="VI">Virgin Islands, U.S.</option>
											<option value="WF">Wallis And Futuna</option>
											<option value="EH">Western Sahara</option>
											<option value="YE">Yemen</option>
											<option value="ZM">Zambia</option>
											<option value="ZW">Zimbabwe</option>
										</select>
									</li>
									<li>
										<label style="width:210px"for="Graduation">Expected Graduation Date</label>
										<input size="11px" name="Graduation" id="Graduation"/>
									</li>
									<li>
										<label style="width:210px"for="GPA">Current High School/<br/>Secondary School GPA</label>
										<input size="11px" name="GPA" id="GPA"/>
									</li>	
									<br />		
								</ol>
								<legend><span>Currently, I am enrolled in my:</span></legend>		      
								<ol id="radio">
									<li>
										<input type="radio" style="margin:0" name="Radio1" value="1st Year of High School/Secondary School" > <label> 1st Year of High School/Secondary School</label></input>					
									</li>
									<li>
										<input type="radio" style="margin:0" name="Radio2" value="2nd Year of High School/Secondary School" > <label> 2nd Year of High School/Secondary School
										</label></input>					
									</li>
									<li>
										<input type="radio" style="margin:0" name="Radio3" value="3rd Year of High School/Secondary School" > <label> 3rd Year of High School/Secondary School
										</label></input>					
									</li>
									<li>
										<input type="radio" style="margin:0" name="Radio4" value="Final Year of High School/Secondary School" > <label> Final Year of High School/Secondary School
										</label></input>					
									</li>
									<li>
										<label> Other, Please indicate:</label><input style="margin:0 20px	"type="text" name="Other" value="" id=""/>				
									</li>
								</ol>
								<div id="buttons">
									<a onClick="next(1)"><input type="button" name="submit" class="next" value=""/></a>
								</div>
								<!--<a href="template.php">section 1</a> - <a href="Questions.php">section 2</a> - <a href="section3.php">section 3</a> - <a href="section4.php">section 4</a> - <a href="section5.php">section 5</a>-->

							</fieldset>


<!-- END FIELDSET1 -->

<fieldset id="fieldset2" style="float:left">
	<legend><span>Section II of III</span><br/><span>Enter your contact information in the fields bellow.</span></legend>
	<ol>
		<li>
			<label>Please complete an essay in the space provided on one of the three topics detailed below. The essay 
				must consist of a minimum of 500 words and maximum of 1000 words and can be written in English, 
				Spanish, French, Chinese, Russian and Arabic. Please label and attach any additional pages needed to 
				complete this essay. Please inc</label>

				<label><span>Topic 1:</span><br/><br/>What could your generation do to prepare for their financial future in this current economic time?</label>

				<label><span>Topic 2:</span><br/><br/>If you were in charge of the World Bank, how would you allocate funds within your country, city or
					local community? What areas do you think would benefit from having monetary funds distributed to 
					them, and why? Ex: education, health, child care, tourism…etc</label>

					<label><span>Topic 3:</span><br/><br/>
						Should wealthy nations be required to share their wealth among poorer nations by providing such things
						as food and education? Or is it a responsibility of the governments of poorer nations to look after their
						citizens themselves? What are your thoughts? Explain</label>
					</li>
					<li>
						<textarea rows="25" cols="60" name="Essay" value="" >"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain..."
						</textarea>
					</li>
				</ol>
				<div id="buttons">
					<a onClick="next(2)"><input type="button" name="submit" class="next" value=""/></a>
					<a onClick="back(1)"><input type="button" name="submit" class="preview" value=""/></a>
				</div>
			</fieldset>


			<fieldset id="fieldset3">
				<legend><span>Section III of III</span><br/><span>Picture your answer</span></legend>
				<ol>
					<?php
				$i=0;
				while($row = mysql_fetch_row($result))
				{
					if ($i != 0)
						echo '<legend><br /><span>'.$i." - ".$row[0].'</span></legend><br/><textarea rows="10" cols="45" ></textarea>';
					$i++;
				}
				?>
			</ol>
			<div id="buttons">
				<a><input type="submit" name="submit" class="" value=""/></a>
				<a onClick="back(2)"><input type="button" name="submit" class="preview" value=""/></a>
			</div>
		</fieldset>





















	</form>
</div>
</div>
</body>
</html>