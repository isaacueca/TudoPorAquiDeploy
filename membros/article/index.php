<?

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /membros/article/index.php
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
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	$url_redirect = "".DEFAULT_URL."/membros/article";
	$url_base = "".DEFAULT_URL."/membros";
	$membros = 1;

	// Page Browsing /////////////////////////////////////////
	$sql_where[] = "account_id = $acctId";
	if ($listing_id){
		$sql_where[] = "listing_id = $listing_id";
	}
	if ($sql_where) $where .= " ".implode(" AND ", $sql_where)." ";

	$pageObj = new pageBrowsing("Article", $screen, 200, (($_GET["newest"])?("id DESC"):("level DESC, title")), "title", $letra, $where);
	$articles = $pageObj->retrievePage();

	$paging_url = DEFAULT_URL."/membros/article/index.php";
	
	// Letters Menu
	$letras = $pageObj->getString("letras");
	foreach ($letras as $each_letra) {
		if ($each_letra == "#") {
			$letras_menu .= "<a href=\"$paging_url\" ".((!$letra) ? "class=\"firstLetter\"" : "" ).">".strtoupper($each_letra)."</a>";
		} else {
			$letras_menu .= "<a href=\"$paging_url?letra=".$each_letra."\" ".(($each_letra == $letra) ? "style=\"color:red\"" : "" ).">".strtoupper($each_letra)."</a>";
		}
	}

	# PAGES DROP DOWN ----------------------------------------------------------------------------------------------
	$pagesDropDown = $pageObj->getPagesDropDown($_GET, $paging_url, $screen, system_showText(LANG_PAGING_GOTOPAGE).": ", "this.form.submit();");
	# --------------------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(MEMBERS_EDIRECTORY_ROOT."/layout/header_members.php");

	?>

		<div id="page-wrapper">

			<div id="main-wrapper">

				<?php 	include(MEMBERS_EDIRECTORY_ROOT."/menu.php"); ?>

				<div id="main-content"> 

					<div class="page-title ui-widget-content ui-corner-all">

						<div class="other_content">
							<? include(INCLUDES_DIR."/tables/table_blog_submenu.php"); ?>

				<?
					$contentObj = new Content("", EDIR_LANGUAGE);
					$content = $contentObj->retrieveContentByType("Manage Articles");
					if ($content) {
						echo "<blockquote>";
							echo "<div class=\"dynamicContent\">".$content."</div>";
						echo "</blockquote>";
					}
				?>

				<? if ($articles) { ?>

					<? $hascharge = false; ?>
					<? $hastocheckout = false; ?>

					<? include(INCLUDES_DIR."/tables/table_article.php"); ?>

					<? if (!($process == "signup")) { ?>

						<? if ($hastocheckout) { ?>
							<? if ($hascharge) { ?>
								<? if ((PAYMENT_FEATURE == "on") && ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on"))) { ?>

									<div class="response-msg notice ui-corner-all">
										<?=system_showText(LANG_MSG_ARTICLES_ARE_ACTIVATED_BY);?> <strong><?=system_showText(LANG_LABEL_SITE_MANAGER)?></strong> <?=system_showText(LANG_MSG_ONLY_PROCCESS_COMPLETE)?></td>

									</div>

								<? } ?>
							<? } ?>
						<? } ?>

					<? } ?>

					<? } else { ?>
						<div class="response-msg inf ui-corner-all"><?=system_showText(LANG_NO_ARTICLES_IN_THE_SYSTEM)?></div>
					<? } ?>


				<?
					$contentObj = new Content("", EDIR_LANGUAGE);
					$content = $contentObj->retrieveContentByType("Manage Articles Bottom");
					if ($content) {
						echo "<blockquote>";
							echo "<div class=\"dynamicContent\">".$content."</div>";
						echo "</blockquote>";
					}
				?>

								</div>
							</div>
						</div>
					</div>
				</div>
			<div class="clearfix"></div>