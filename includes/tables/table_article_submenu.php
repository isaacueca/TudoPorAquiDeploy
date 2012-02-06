<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_article_submenu.php
	# ----------------------------------------------------------------------------------------------------

?>
<div id="submenu_wrapper">
	<ul class="submenu_list">
		<li class="icon_home"><a href="<?=DEFAULT_URL?>/gerenciamento/estabelecimentos/blog/<?php echo $listing_id ?>"><?=ucwords(system_showText(LANG_SITEMGR_MENU_ARTICLESHOME))?></a></li>
		<li class="icon_add"><a href="<?=DEFAULT_URL?>/gerenciamento/blog/adicionar/<?php echo $listing_id ?>"><?=system_showText(LANG_SITEMGR_MENU_ADD)?></a></li>
	<!--	<li class="icon_search"><a href="<?=DEFAULT_URL?>/gerenciamento/article/search.php"><?=system_showText(LANG_SITEMGR_MENU_SEARCH)?></a></li> !-->
	<!--	<li class="icon_rating"><a href="<?=DEFAULT_URL?>/gerenciamento/review/index.php?item_type=article"><?=system_showText(LANG_SITEMGR_MENU_REVIEWS)?></a></li> !-->
	</ul>
	
	<div class="clearfix"></div>
	
</div>
