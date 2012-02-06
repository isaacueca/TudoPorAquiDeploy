<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/articlecategs/index.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("../../conf/loadconfig.inc.php");
	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	$url_redirect = "".DEFAULT_URL."/membros/blog";
	$url_base = "".DEFAULT_URL."/membros";

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	extract($_POST);
	extract($_GET);

	// Page Browsing /////////////////////////////////////////
	$sql_where[] = " account_id = $acctId ";
	if ($sql_where) $where .= " ".implode(" AND ", $sql_where)." ";
	
	$pageObj  = new pageBrowsing("ArticleCategory", $screen, 200, "title, id", "title", $letra, $where);
	$categories = $pageObj->retrievePage();

	$paging_url = DEFAULT_URL."/membros/articlecategs/index.php?category_id=".$category_id;

	// Letters Menu
	$letras = $pageObj->getString("letras");
	foreach($letras as $each_letra)
	if($each_letra == "#") $letras_menu .= "<a href=\"$paging_url\" ".((!$letra) ? "class=\"firstLetter\"" : "" ).">".strtoupper($each_letra)."</a>";
	else $letras_menu .= "<a href=\"$paging_url&letra=".$each_letra."\" ".(($each_letra == $letra) ? "style=\"color:#EF413D\"" : "" ).">".strtoupper($each_letra)."</a>";

	# PAGES DROP DOWN ----------------------------------------------------------------------------------------------
	$pagesDropDown = $pageObj->getPagesDropDown($_GET, $paging_url, $screen, system_showText(LANG_SITEMGR_PAGING_GOTOPAGE)." ", "this.form.submit();");
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

			<? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>
			<? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
			<? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>

			<? include(INCLUDES_DIR."/tables/table_article_category_submenu.php"); ?>

			<br />

			<? include(INCLUDES_DIR."/tables/table_articlecategory.php"); ?>


							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
<?
	include(MEMBERS_EDIRECTORY_ROOT."/layout/footer.php");
?>