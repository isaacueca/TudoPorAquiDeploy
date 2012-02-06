<?

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /membros/article/delete.php
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

	$url_redirect = "".DEFAULT_URL."/membros/estabelecimentos/blog/$listing_id";
	$url_base = "".DEFAULT_URL."/membros";
	$membros = 1;

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	if ($id) {
		$article = new Article($id);
		if (sess_getAccountIdFromSession() != $article->getNumber("account_id")) {
			header("Location: ".DEFAULT_URL."/membros/article/index.php?screen=$screen&letra=$letra");
			exit;
		}
	} else {
		header("Location: ".DEFAULT_URL."/membros/article/index.php?screen=$screen&letra=$letra");
		exit;
	}
	

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$article = new Article($_POST['id']);
		$article->delete();
		header("Location: ".DEFAULT_URL."/membros/estabelecimentos/blog/$listing_id");
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

				<div id="header-form"><?=system_showText(LANG_ARTICLE_DELETE_INFORMATION)?> - <strong><?=$article->getString("title")?></div>

				<div class="response-msg inf ui-corner-all"><?=system_showText(LANG_ARTICLE_DELETE_CONFIRM)?></div>
				
				<div class="baseButtons">

				<form title="article" method="post">

					<input type="hidden" name="id" value="<?=$id?>" />
					<input type="hidden" name="letra" value="<?=$letra?>" />
					<input type="hidden" name="screen" value="<?=$screen?>" />

							<button class="ui-state-default ui-corner-all"  type="submit" value="Submit"><?=system_showText(LANG_BUTTON_SUBMIT)?></button>
							<button class="ui-state-default ui-corner-all" type="button" onclick="document.getElementById('formarticledeletecancel').submit();" value="Cancel"><?=system_showText(LANG_BUTTON_CANCEL)?></button>

				</form>
	
				<form action="<?=DEFAULT_URL?>/membros/estabelecimentos/blog/<?=$listing_id?>" id="formarticledeletecancel"  method="post">
					<input type="hidden" name="letra" value="<?=$letra?>" />
					<input type="hidden" name="screen" value="<?=$screen?>" />
					<input type="hidden" name="listing_id" value="<?=$listing_id?>" />
					
				</form>
				
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="clearfix"></div>