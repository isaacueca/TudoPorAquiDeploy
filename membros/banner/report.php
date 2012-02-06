<?
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (BANNER_FEATURE != "on") { exit; }

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	$url_base = "".DEFAULT_URL."/membros";
	$url_redirect = $url_base."/banner";
	$membros = 1;

    # ----------------------------------------------------------------------------------------------------
    # OBJECTS
    # ----------------------------------------------------------------------------------------------------
    $banner = new Banner($id);

    $bannerLevel = new BannerLevel();
    $levelName = ucwords($bannerLevel->getName($banner->getNumber('level')));
    
    $status = new ItemStatus();
    $statusName = $status->getStatus($banner->getString('status'));

    # ----------------------------------------------------------------------------------------------------
    # REPORT DATA
    # ----------------------------------------------------------------------------------------------------
    $reports = retrieveBannerReport($id);

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/header_members.php");
    

?>
<script language="JavaScript" src="../../../scripts/FusionCharts.js"></script>


	<div id="page-wrapper">

		<div id="main-wrapper">
		<?php 	include(MEMBERS_EDIRECTORY_ROOT."/menu.php"); ?>
			<div id="main-content"> 

				
				<div class="page-title ui-widget-content ui-corner-all">
					<div class="other_content">
		<? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>
		<? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
		<? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>


		<? if ($_GET["message"]) { ?>
		<div class="response-msg inf ui-corner-all"><?=urldecode($_GET["message"])?></div>
		<? } ?>

		<? if ($reports) { ?>
				<? include(INCLUDES_DIR."/tables/table_banner_reports.php"); ?>
		<? } else { ?>
			<div class="response-msg inf ui-corner-all">
				<?=system_showText(LANG_NO_REPORTS)?>
			</div>
		<? } ?>


						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>

