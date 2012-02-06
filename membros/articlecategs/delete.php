<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /gerenciamento/articlecategs/delete.php
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

	$url_redirect = "".DEFAULT_URL."/membros/blog";
	$url_base = "".DEFAULT_URL."/membros";
	$sitemgr = 1;

	extract($_GET);
	extract($_POST);

	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	if ($id) {
		$category = new ArticleCategory($id);
	} else {
		$message = system_showText(LANG_SITEMGR_CATEGORY_NOTFOUND);
		header("Location: ".DEFAULT_URL."/membros/articlecategs/"."index.php?message=".urlencode($message)."&listing_id=".$listing_id."");
		exit;
	}

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$category = new ArticleCategory($_POST['id']);
		$category->delete();
		$message = system_showText('A Categoria selecionada foi excluída');
		header("Location: ".DEFAULT_URL."/membros/articlecategs/"."index.php?message=".urlencode($message)."&listing_id=".$listing_id."");
		exit;
	}

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
			
			<div class="baseForm">

			<form name="article" action="<?=$_SERVER["PHP_SELF"]?>" method="post">
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" id="listing_id" name="listing_id" value="<?=$listing_id?>" />
				<div id="header-form">Apagar Categoria do Blog</div>
				<div class="response-msg inf ui-corner-all"><?php echo utf8_decode("Remover Categoria do Blog?")?></div>
				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
				<button type="submit" class="ui-state-default ui-corner-all">Enviar</button>
			</form>
			
			<form action="<?=DEFAULT_URL?>/membros/blog/categorias/<?=$listing_id?>" method="get">
				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
				<button type="submit" class="ui-state-default ui-corner-all">Cancelar</button>
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

