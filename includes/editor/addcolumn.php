<?php

# ----------------------------------------------------------------------------------------------------
# LOAD CONFIG
# ----------------------------------------------------------------------------------------------------
include("../../conf/loadconfig.inc.php");

session_start();
if (!$_SESSION[SM_LOGGEDIN] && !$_SESSION[SESS_ACCOUNT_ID]) exit;

include_once ('./config.php');
include_once('./editor_functions.php');
include_once ('./includes/common.php');
include_once ('./lang/'.$lang_include);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $lang['titles']['insert_column']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="<?php echo WP_WEB_DIRECTORY; ?>dialoge_theme.css" type="text/css" />
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogEditorShared.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo WP_WEB_DIRECTORY; ?>js/dialogShared.js"></script>
<script type="text/javascript" language="JavaScript">
<!--//
function end() {
	if (document.getElementById('addleft').checked) {
		action="addleft"
	} else if (document.getElementById('addright').checked) {
		action="addright"
	}
	parentWindow.wp_processColumn(obj, action);
	window.close();
	return false;
}
//-->
</script>
</head>
<body onLoad="hideLoadMessage();">
<?php include('./includes/load_message.php'); ?>
<div class="dialog_content" align="center"> 
	<form name="add_form" id="add_form" onSubmit="return end()">
		<fieldset>
		<legend><?php echo $lang['column_placement']; ?></legend>
		<table id="background" width="100%" border="0" cellspacing="3" cellpadding="0">
			<tr> 
				<td><p> 
						<input id="addleft" type="radio" name="where" value="addabove" checked="checked" />
						<?php echo $lang['left_of_selection']; ?></p>
					<p> 
						<input id="addright" type="radio" name="where" value="addbelow" />
						<?php echo $lang['right_of_selection']; ?></p></td>
			</tr>
		</table>
		</fieldset>
		<br />
		<div align="center"> 
			<button type="submit" id="ok" value="<?php echo $lang['ok']; ?>"><?php echo $lang['ok']; ?></button>
			&nbsp; 
			<button type="button" onClick="window.close();"><?php echo $lang['cancel']; ?></button>
		</div>
	</form>
</div>
</body>
</html>
