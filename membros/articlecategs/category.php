<?

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/articlecategs/category.php
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

	$url_redirect = "".DEFAULT_URL."/membros/articlecategs";
	$url_base = "".DEFAULT_URL."/membros";
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
	include(INCLUDES_DIR."/code/articlecategory.php");

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
			
			<div class="baseForm">

			<form name="category" action="<?=$_SERVER["PHP_SELF"]?>" method="post">
				<input type="hidden" id="id" name="id" value="<?=$id?>" />

				<div id="header-form">Categoria do Blog</div>
				<? if ($message_category) { ?>
					<div class="response-msg error ui-corner-all"><?=$message_category?></div>
				<? } ?>

				<? include(INCLUDES_DIR."/forms/form_articlecategory.php"); ?>
				<input type="hidden" name="account_id" value="<?=$acctId?>" />
				<input type="hidden" name="listing_id" value="<?=$listing_id?>" />

				<button type="submit" name="submit" value="Submit" class="ui-state-default ui-corner-all">Enviar</button>

			</form>
			
			<form action="<?=DEFAULT_URL?>/membros/blog/categorias/<?php echo $listing_id?>" method="get">

				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
	
				<button type="submit" name="cancel" value="Cancel" class="ui-state-default ui-corner-all">Cancelar</button>

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
				include(MEMBERS_EDIRECTORY_ROOT."/layout/footer.php");
			?>
