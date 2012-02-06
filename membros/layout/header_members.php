<?
	header("Content-Type: text/html; charset=".EDIR_CHARSET, TRUE);

	include(INCLUDES_DIR."/code/headertag.php");
	include("../../conf/loadconfig.inc.php");
	require(EDIRECTORY_ROOT."/frontend/checkregbin.php");
	session_start();
	include(EDIRECTORY_ROOT."/includes/code/validate_querystring.php");
	include(EDIRECTORY_ROOT."/includes/code/validate_frontrequest.php");
?>
<?
if (sess_getAccountIdFromSession()) {
	$dbObjWelcome = db_getDBObJect();
	$sqlWelcome = "SELECT first_name, last_name FROM Contact WHERE account_id = ".sess_getAccountIdFromSession();
	$resultWelcome = $dbObjWelcome->query($sqlWelcome);
	$contactWelcome = mysql_fetch_assoc($resultWelcome);
		}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">

	<head>

		<link rel="shortcut icon" href="<?=DEFAULT_URL?>/images/favicon.ico">
		<title>Tudo Por Aqui - <?=$contactWelcome["first_name"]?> <?=$contactWelcome["last_name"]?></title>

		<? $headertag_description = (($headertag_description) ? ($headertag_description) : (EDIRECTORY_TITLE)); ?>
		<meta name="description" content="<?=$headertag_description?>" />

		<? $headertag_keywords = (($headertag_keywords) ? ($headertag_keywords) : (EDIRECTORY_TITLE)); ?>
		<meta name="keywords" content="<?=$headertag_keywords?>" />

		<meta http-equiv="Content-Type" content="text/html; charset=<?=EDIR_CHARSET;?>" />

		<meta name="ROBOTS" content="noindex, nofollow" />
		<script type="text/javascript">
			<!-- 
			DEFAULT_URL = "<?=DEFAULT_URL?>";  
			-->
		</script>		
		
	<link href="<?=DEFAULT_URL?>/layout/tpa_geral.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?=DEFAULT_URL?>/layout/general_structure.css" rel="stylesheet" type="text/css" media="all" />
	<?=system_getNoImageStyle($cssfile = true);?>
	<link href="<?=DEFAULT_URL?>/membros/layout/general_members.css" rel="stylesheet" type="text/css" media="all"/>
	<link href="<?=DEFAULT_URL?>/layout/admin/style.css" rel="stylesheet" media="all" />
	
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/jquery-1.3.2.js"></script>
	<script src="<?=DEFAULT_URL?>/scripts/jquery.thickbox.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/superfish.js"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/jquery-ui-1.7.2.js"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/tooltip.js"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/tablesorter.js"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/tablesorter-pager.js"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/admin/custom.js"></script>
	<script src="<?=DEFAULT_URL?>/scripts/lang.js.php" language="javascript" type="text/javascript"></script>
	<script src="<?=DEFAULT_URL?>/scripts/common.js" language="javascript" type="text/javascript"></script>
	<script src="<?=DEFAULT_URL?>/scripts/location.js" language="javascript" type="text/javascript"></script>
	<script src="<?=DEFAULT_URL?>/scripts/contactclick.js" language="javascript" type="text/javascript"></script>
	<script src="<?=DEFAULT_URL?>/scripts/cookies.js" language="javascript" type="text/javascript"></script>
    <script src="<?=DEFAULT_URL?>/scripts/jquery.cookie.js" type="text/javascript"></script>
	<script src="<?=DEFAULT_URL?>/scripts/jquery.form.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/jquery.selectbox.js"></script>
	<script type="text/javaScript" src="<?=DEFAULT_URL?>/scripts/calendardmy.js"></script>
	<link href="<?=DEFAULT_URL?>/scripts/thickbox.css" rel="stylesheet" type="text/css" media="all" />

	<!--[if IE 6]>
	<link href="css/ie6.css" rel="stylesheet" media="all" />
	
	<script src="js/pngfix.js"></script>
	<script>
	  /* EXAMPLE */
	  DD_belatedPNG.fix('.logo, .other ul#dashboard-buttons li a');

	</script>
	<![endif]-->
	<!--[if IE 7]>
	<link href="css/ie7.css" rel="stylesheet" media="all" />
	<![endif]-->

	<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/ckeditor.js"></script>
	<script src="<?=DEFAULT_URL?>/scripts/sample.js" type="text/javascript"></script>
	<link href="<?=DEFAULT_URL?>/layout/sample.css" rel="stylesheet" type="text/css" />
	</head>

	<body>


		<?

		if ((strpos($_SERVER["PHP_SELF"], "/".LISTING_FEATURE_NAME) !== false) || (strpos($_SERVER["PHP_SELF"], "claim.php") !== false)) { ?>
		<span class="isHidden" id="defaultURL"><?=DEFAULT_URL?></span>
		<? } ?>

	<div id="geral">
		<div id="login">
	
			<? if (!sess_getAccountIdFromSession()) 
			 { ?>
			
			<a href="<?=DEFAULT_URL?>/registro">Registro</a> 
			| <a id="" class="thickbox" href="<?=DEFAULT_URL?>/frontend/login.php?keepThis=true&height=220&width=400">
			Login
			 </a>
			 
			 <? } else { ?>
				
				
			<a href="<?=DEFAULT_URL?>/membros"> 
				Minha Conta</a> | <a href="<?=DEFAULT_URL?>/membros/logout.php"> <?=system_showText(LANG_BUTTON_LOGOUT)?></a>

			<? } ?>
		
		</div>


	<div id='buscaint'><div id='logop'><a href='<?=DEFAULT_URL?>/index.php'><img src='<?=DEFAULT_URL?>/images/logop.png' border='0' /></a></div>

	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-0774327494663941";
	/* Administrador-Topo */
	google_ad_slot = "1852937815";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>


<? //include(EDIRECTORY_ROOT."/search.php"); ?>
</div>

			<div id="domChunk"></div>
			<div id="consulta">


		<h5> <b> Seja bem vindo(a) <?=$contactWelcome["first_name"]?> <?=$contactWelcome["last_name"]?></b></h5> 


</div>
