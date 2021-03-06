<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /membros/classified/report.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (CLASSIFIED_FEATURE != "on") { exit; }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	$url_base = "".DEFAULT_URL."/membros";

    # ----------------------------------------------------------------------------------------------------
    # OBJECTS
    # ----------------------------------------------------------------------------------------------------
    $classified = new Classified($id);

    $classifiedLevel = new ClassifiedLevel();
    $levelName = ucwords($classifiedLevel->getName($classified->getNumber('level')));
    
    $status = new ItemStatus();
    $statusName = $status->getStatus($classified->getString('status'));

    # ----------------------------------------------------------------------------------------------------
    # REPORT DATA
    # ----------------------------------------------------------------------------------------------------
    $reports = retrieveClassifiedReport($id);

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/header.php");

	# ----------------------------------------------------------------------------------------------------
	# NAVBAR
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/navbar.php");
?>

			<div class="mainContentExtended">

				<? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>
				<? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
				<? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>

				<h1 class="standardTitle"><?=system_showText(LANG_CLASSIFIED_TRAFFIC_REPORT)?> - <span><?=$classified->getString("title")?></span></h1>

					<? if ($reports) { ?>
						<? include(INCLUDES_DIR."/tables/table_classified_reports.php"); ?>
					<? } else { ?>
						<div class="response-msg inf ui-corner-all"><?=system_showText(LANG_NO_REPORTS)?></div>
					<? } ?>

			</div>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/footer.php");
?>