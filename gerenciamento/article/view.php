<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/article/view.php
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
	check_action_permission('estabelecimentos', 'view');

	$url_redirect = "".DEFAULT_URL."/gerenciamento/article";
	$url_base = "".DEFAULT_URL."/gerenciamento";
	$sitemgr = 1;

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	$errorPage = DEFAULT_URL."/gerenciamento/article/index.php?message=".urlencode($message)."&screen=$screen&letra=$letra";
	if ($id) {
		$article = new Article($id);
		if ((!$article->getNumber("id")) || ($article->getNumber("id") <= 0)) {
			header("Location: ".$errorPage);
			exit;
		}
	} else {
		header("Location: ".$errorPage);
		exit;
	}

	if ($article->getNumber("account_id")) $account = new Account($article->getNumber("account_id"));

	$level = new ArticleLevel();
	$articleImages = $level->getImages($article->getNumber("level"));

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

			<? if($article->getString("id") == 0){ ?>
				<p class="errorMessage"><?=system_showText(LANG_SITEMGR_ARTICLE_MIGHTBEDELETED)?></p>
			<? } else { ?>

				<? include(INCLUDES_DIR."/tables/table_article_submenu.php"); ?>

				<div id="header-view"><?=system_showText(LANG_SITEMGR_MANAGE)?> <?=system_showText(LANG_SITEMGR_ARTICLE_SING)?> - <?=$article->getString("title")?></div>
					<div style="float: left; width: 313px;">
						
						<a class="btn2 ui-state-default ui-corner-all"  href="<?=DEFAULT_URL?>/gerenciamento/article/article.php?id=<?=$article->getNumber("id")?>&listing_id=<?=$listing_id?>">
						<?=system_showText(LANG_ARTICLE_EDIT_INFORMATION);?>
						<span class="ui-icon ui-icon-pencil"/></span>
						</a>
						
						<a class="btn2 ui-state-default ui-corner-all"  href="<?=DEFAULT_URL?>/gerenciamento/article/delete.php?id=<?=$article->getNumber("id")?>&listing_id=<?=$listing_id?>">
						<?=system_showText(LANG_ARTICLE_DELETE);?>
						<span class="ui-icon ui-icon-circle-minus"/></span>
						</a>
						
					</div>
					<div style="float: left; width: 313px;">
					
					<? if ((ARTICLE_MAX_GALLERY > 0) && (($articleImages > 0) || ($articleImages == -1))) { ?>


					<? } ?>
			
					<a class="btn2 ui-state-default ui-corner-all"  href="<?=DEFAULT_URL?>/gerenciamento/article/settings.php?id=<?=$article->getNumber("id")?>&listing_id=<?=$listing_id?>">
					<?=utf8_decode("Configuração");?>
					<span class="ui-icon ui-icon-pencil"/></span>
					</a>
			
					<a class="btn2 ui-state-default ui-corner-all" href="javascript:void(0);" onclick="javascript:window.open('<?=DEFAULT_URL?>/gerenciamento/article/preview.php?id=<?=$article->getNumber("id")?>', '', 'toolbar=0, location=0, directories=0, status=0, scrollbars=yes, width=800, height=400, screenX=0, screenY=0, menubar=0');" >
					<?=system_showText(LANG_MSG_CLICK_TO_PREVIEW_THIS_ARTICLE);?>
					<span class="ui-icon ui-icon-search"/></span>
					</a>
					
				</div>
				
				<div style="clear:both"></div>


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