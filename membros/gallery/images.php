<?

	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ------------------------------------$----------------------------------------------------------------
	extract($_GET);
	extract($_POST);

	$url_redirect = "".DEFAULT_URL."/membros/fotos";
	$url_base = "".DEFAULT_URL."/membros";
	$membros = 1;

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	$errorPage = "".DEFAULT_URL."/membros/gallery/index.php?screen=$screen&letra=$letra";
	if ($id) {
		$gallery = new Gallery($id);
		if ((!$gallery->getNumber("id")) || ($gallery->getNumber("id") <= 0)) {
			header("Location: ".$errorPage);
			exit;
		}
		if (sess_getAccountIdFromSession() != $gallery->getNumber("account_id")) {
			header("Location: ".$errorPage);
			exit;
		}
	} else {
		header("Location: ".$errorPage);
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
				<?php 				
					$listing = new Listing($empresaid);
					$empresa = $listing->getString("title");
					
					if ($listing_id){
						$listing2 = new Listing($listing_id);
						$empresa = $listing2->getString("title");
						
						$post = new Article($empresaid);
						$post_title = $post->getString("title");
				?>
				<div id="header-form">
					Fotos do artigo <? echo $post_title; ?>
				</div> 
				
				<?php }else{ ?>
			
					<div id="header-form">
						Fotos
					</div> 
			
				<?php } ?>
			
				<div class="clearfix"></div>

				<a class="btn ui-state-default ui-corner-all" href="<?=DEFAULT_URL?>/membros/fotos/adicionar/<?=$id?>/<?=$empresaid?>"><?=system_showText("Adicionar Foto")?><span class="ui-icon ui-icon-circle-plus"/></span></a>
				<div class="clearfix"></div>
				

				<? include(INCLUDES_DIR."/views/view_gallery.php"); ?>
				<div class="clearfix"></div><br/>
				<?php if ($listing_id){?>
					<a href="<?=DEFAULT_URL?>/membros/estabelecimentos/blog/<?php echo $listing_id?>" class="btn ui-state-default ui-corner-all">Voltar para a lista de artigos do Blog do Estabelecimento<span class="ui-icon ui-icon-circle-arrow-w"></span></a>
					<div class="clearfix"></div>
		
				<?php }?>
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

