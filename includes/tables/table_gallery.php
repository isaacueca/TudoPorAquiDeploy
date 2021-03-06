<?


	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_gallery.php
	# ----------------------------------------------------------------------------------------------------

?>

<ul class="standard-iconDESCRIPTION">
	<li class="view-icon"><?=system_showText(LANG_LABEL_VIEW);?></li>
	<li class="edit-icon"><?=system_showText(LANG_LABEL_EDIT);?></li>
	<li class="gallery-icon"><?=system_showText(LANG_LABEL_IMAGE_PLURAL)?></li>
	<li class="delete-icon"><?=system_showText(LANG_LABEL_DELETE);?></li>
</ul>

<? if ($message) { ?>
	<div class="response-msg success ui-corner-all"><?=$message?></div>
<? } ?>
<div class="hastable">
<table border="0" cellpadding="2" cellspacing="2" >
<thead>
	<tr>
		<th><?=system_showText(LANG_GALLERY_TITLE);?></th>
		<? if (strpos($url_base, "/gerenciamento")) { ?>
			<th style="width: 70px;"><?=system_showText(LANG_LABEL_ACCOUNT);?></th>
		<? } ?>
		<th style="width: 80px;">&nbsp;</th>
	</tr>
</thead>
	<?
	foreach($galleries as $gallery) {
		$id = $gallery->getNumber("id");?>

		<tr>
			<td>
				<a href="<?=$url_redirect?>/view.php?id=<?=$id?>&screen=<?=$screen?>&letra=<?=$letra?><?=(($url_search_params) ? "&$url_search_params" : "")?>" class="link-table"><? echo $gallery->getString("title");?></a>
			</td>
			<? if (strpos($url_base, "/gerenciamento")) { ?>
			<td>
					<? if ($gallery->getNumber("account_id")) { ?>
						<a href="<?=$url_base?>/account/view.php?id=<?=$gallery->getNumber("account_id")?>" class="link-table">
							<?
							$account = db_getFromDB("account", "id", db_formatNumber($gallery->getNumber("account_id")));
							echo system_showAccountUserName($account->getString("username"));
							?>
						</a>
					<? } else { ?>
						<em><?=system_showText(LANG_SITEMGR_NOOWNER)?></em>
					<? } ?>
			</td>
			<? } ?>
			<td nowrap="nowrap">

				<a class="tooltip"  title="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_GALLERY)?>"  href="<?=$url_redirect?>/visualizar/<?=$id?>" class="link-table">
					<img src="<?=DEFAULT_URL?>/images/bt_view.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_GALLERY)?>" />
				</a>

				<a class="tooltip" title="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_THIS_GALLERY)?>"  href="<?=$url_redirect?>/editar/<?=$id?>" class="link-table">
					<img src="<?=DEFAULT_URL?>/images/bt_edit.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_THIS_GALLERY)?>"  />
				</a>

				<a class="tooltip"  title="<?=system_showText(LANG_MSG_CLICKTOMANAGEGALLERYIMAGES)?>" href="<?=$url_redirect?>/imagens/<?=$id?>" class="link-table">
					<img src="<?=DEFAULT_URL?>/images/icon_gallery.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICKTOMANAGEGALLERYIMAGES)?>" />
				</a>

				<a class="tooltip" title="<?=system_showText(LANG_MSG_CLICK_TO_DELETE_THIS_GALLERY)?>"  href="<?=$url_redirect?>/apagar/<?=$id?>" class="link-table">
					<img src="<?=DEFAULT_URL?>/images/bt_delete.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_DELETE_THIS_GALLERY)?>"  />
				</a>

			</td>
		</tr>
		<?
		}
	?>

</table></div>