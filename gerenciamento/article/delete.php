<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/article/delete.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (ARTICLE_FEATURE != "on") { exit; }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();
	check_action_permission('estabelecimentos', 'delete');

	$url_redirect = "".DEFAULT_URL."/gerenciamento/article";
	$url_base = "".DEFAULT_URL."/gerenciamento";
	$sitemgr = 1;

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	if ($id) {
		$article = new Article($id);
	}	else {
		header("Location: ".DEFAULT_URL."/gerenciamento/article/index.php?message=".urlencode($message)."&screen=$screen&letra=$letra");
		exit;
	}

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$article = new Article($_POST['id']);
		$article->delete();
		$message = system_showText(LANG_SITEMGR_ARTICLE_SING)." ".system_showText(LANG_SITEMGR_WASSUCCESSDELETED);
		header("Location: ".DEFAULT_URL."/gerenciamento/article/".(($search_page) ? "search.php" : "index.php")."?message=".urlencode($message)."&screen=$screen&letra=$letra".(($url_search_params) ? "&$url_search_params" : "")."");
		exit;
	}

		# ----------------------------------------------------------------------------------------------------
		# HEADER
		# ----------------------------------------------------------------------------------------------------
		include(SM_EDIRECTORY_ROOT."/layout/header_manager.php");



	?>

		<div id="page-wrapper">

			<div id="main-wrapper">

			<?php 	include(SM_EDIRECTORY_ROOT."/menu.php"); ?>

				<div id="main-content"> 

					<div class="page-title ui-widget-content ui-corner-all">

						<div class="other_content">

			<? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>
			<? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
			<? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>
			
			<div class="baseForm">

			<form name="article" method="post">

				<input type="hidden" name="id" value="<?=$id?>" />
				<div id="header-form"><?=ucwords(system_showText(LANG_SITEMGR_DELETE))?> <?=system_showText(LANG_SITEMGR_ARTICLE_SING);?> - <?=$article->getString("title")?></div>
				<div class="response-msg inf ui-corner-all"><?=system_showText(LANG_SITEMGR_BLOG_DELETEQUESTION)?></div>
				<input type="hidden" name="letra" value="<?=$letra?>" />
				<input type="hidden" name="screen" value="<?=$screen?>" />
				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
				<button type="submit" value="Submit" class="ui-state-default ui-corner-all"><?=system_showText(LANG_SITEMGR_SUBMIT)?></button>
				<button type="button" value="Cancel" class="ui-state-default ui-corner-all" onclick="document.getElementById('formarticledeletecancel').submit();"><?=system_showText(LANG_SITEMGR_CANCEL)?></button>
			</form>
			<form id="formarticledeletecancel" action="<?=DEFAULT_URL?>/gerenciamento/article/<?=(($search_page) ? "search.php" : "index.php");?>" method="post">
				<input type="hidden" name="letra" value="<?=$letra?>" />
				<input type="hidden" name="screen" value="<?=$screen?>" />
				<input type="hidden" name="listing_id" value="<?=$listing_id?>" />
				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
			</form>
			

						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="clearfix"></div>
	<?
		# ----------------------------------------------------------------------------------------------------
		# FOOTER
		# ----------------------------------------------------------------------------------------------------
		include(SM_EDIRECTORY_ROOT."/layout/footer.php");
	?>