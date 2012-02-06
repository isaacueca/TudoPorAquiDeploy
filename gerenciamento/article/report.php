<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/article/report.php
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
    # OBJECTS
    # ----------------------------------------------------------------------------------------------------
	if ($id) {
    $article = new Article($id);
	}	else {
		header("Location: ".DEFAULT_URL."/gerenciamento/index.php");
		exit;
	}

    $articleLevel = new ArticleLevel();
    $levelName = ucwords($articleLevel->getName($article->getNumber('level')));
    
    $status = new ItemStatus();
    $statusName = $status->getStatus($article->getString('status'));

    # ----------------------------------------------------------------------------------------------------
    # REPORT DATA
    # ----------------------------------------------------------------------------------------------------
    $reports = retrieveArticleReport($id);

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

		<? include(INCLUDES_DIR."/tables/table_article_submenu.php"); ?>

		<? if ($reports) { ?>
			<? include(INCLUDES_DIR."/tables/table_article_reports.php"); ?>
		<? } else { ?>
			<div class="response-msg inf ui-corner-all">
				<?=system_showText(LANG_SITEMGR_ARTICLE_NOREPORT)?>
			</div>
		<? } ?>

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