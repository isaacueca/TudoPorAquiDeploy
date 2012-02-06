<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_articlecategory.php
	# ----------------------------------------------------------------------------------------------------
?>

<? if ($message == 'LANG_SITEMGR_CATEGORY_DELETED') { ?>
	<div class="response-msg success ui-corner-all"><?php echo utf8_decode('A Categoria selecionada foi excluída com sucesso.');?></div>
<? } ?>

<? if ($message == 'LANG_SITEMGR_CATEGORY_SUCCESSADDED') { ?>
	<div class="response-msg success ui-corner-all"><?php echo utf8_decode('A Categoria foi adicionada com sucesso.');?></div>
<? } ?>

<? if ($categories) { ?>

	<ul class="standard-iconDESCRIPTION">
		<li class="edit-icon">Editar</li>
		<li class="delete-icon">Apagar</li>
	</ul>
	
	<div class="hastable">

		<table id="sort-table">
		<thead>
		<tr>
			<th>Nome da Categoria</th>

			<th style="width: 200px;">&nbsp;</th>
		</tr>
		</thead>
		<?
		foreach ($categories as $category) {
			$id = $category->getNumber("id");
			$subcategories = db_getFromDB("articlecategory", "category_id", $id, "all", "title");
			?>

			<tr>
				<td>
					<? if ($path_count < 2) { ?>
						<a href="<?=$url_redirect?>/index.php?category_id=<?=$id?>" class="link-table"><?=$category->getString("title");?></a>
					<? } else { ?>
						<?=$category->getString("title");?>
					<? } ?>
				</td>

				<td nowrap="nowrap">



					<a class="tooltip" href="<?=$url_redirect?>/categoria/editar/<?=$id?>/<?=$listing_id?>"  title="Editar" class="link-table">
						<img src="<?=DEFAULT_URL?>/images/bt_edit.gif" border="0" alt="<?=system_showText(LANG_SITEMGR_CATEGORY_CLICK_TOEDIT)?>"  />
					</a>

					<a class="tooltip"  href="<?=$url_redirect?>/categoria/apagar/<?=$id?>/<?=$listing_id?>" title="Apagar" class="link-table">
						<img src="<?=DEFAULT_URL?>/images/bt_delete.gif" border="0" alt="<?=system_showText(LANG_SITEMGR_CATEGORY_CLICK_TODELETE)?>"  />
					</a>

				</td>
			</tr>

			<?
			}
		?>

	</table>
</div>
<? } else { ?>
	<div class="response-msg inf ui-corner-all"><?=system_showText(LANG_SITEMGR_ARTICLE_CATEGORY_NORECORD)?></div>
<? } ?>
