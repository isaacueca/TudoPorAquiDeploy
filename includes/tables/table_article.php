<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_article.php
	# ----------------------------------------------------------------------------------------------------

?>

<ul class="standard-iconDESCRIPTION">
	<li class="view-icon"><?=system_showText(LANG_LABEL_VIEW);?></li>
	<li class="edit-icon"><?=system_showText(LANG_LABEL_EDIT);?></li>
	<li class="gallery-icon"><?=system_showText(LANG_LABEL_GALLERY);?></li>
	<li class="rating-icon"><?=system_showText(LANG_REVIEW);?></li>
	<? if (strpos($url_base, "/gerenciamento")) { ?>
		<li class="unpaid-icon"><?=system_showText(LANG_LABEL_UNPAID);?></li>
		<li class="transaction-icon"><?=system_showText(LANG_LABEL_TRANSACTION);?></li>
	<? } ?>
	<li class="delete-icon"><?=system_showText(LANG_LABEL_DELETE);?></li>
</ul>

<? if($message) { ?>
	<div class="response-msg success ui-corner-all"><?=$message?></div>
<? } ?>

<div class="hastable">

	<table border="0" cellpadding="2" cellspacing="2" id="sort-table">
		<thead>

			<tr>
				<th class="header"><?=system_showText(LANG_ARTICLE_TITLE);?></th>
				<? if (strpos($url_base, "/gerenciamento")) { ?>
						<th class="header"><?=system_showText(LANG_LABEL_ACCOUNT);?></th>
				<? } else { ?>
					<th class="header"><?=system_showText(LANG_LABEL_RENEWAL);?></th>
					<? } ?>
					<th class="header"><?=system_showText(LANG_LABEL_STATUS);?></th>
					<? if (strpos($url_base, "/gerenciamento")) { ?>
						<th class="header">&nbsp;</th>
					<? } else { ?>
							<th class="header">&nbsp;</th>
					<? } ?>
			</tr>
		</thead>

	<?
	$hascharge = false;
	$hastocheckout = false;
	if ($articles) foreach ($articles as $article) {

		$id = $article->getNumber("id");
		$level = new ArticleLevel(EDIR_DEFAULT_LANGUAGE, true);
		$articleImages = $level->getImages($article->getNumber("level"));
		if ($article->needToCheckOut()) {
			if ($article->getPrice() > 0)  $hascharge = true;
			$hastocheckout = true;
		}

		$db = db_getDBObject();

		// ---------------- //

		$sql = "SELECT payment_log_id FROM Payment_Article_Log WHERE article_id = $id ORDER BY renewal_date DESC LIMIT 1";
		$r = $db->query($sql);
		$aux_transaction_data = mysql_fetch_assoc($r);

		if($aux_transaction_data) {
			$sql = "SELECT id, transaction_datetime FROM Payment_Log WHERE id = {$aux_transaction_data["payment_log_id"]}";
			$r = $db->query($sql);
			$transaction_data = mysql_fetch_assoc($r);
		} else {
			unset($transaction_data);
		}

		// ---------------- //

		$sql = "SELECT IA.invoice_id, IA.article_id, I.id, I.status, I.payment_date FROM Invoice I, Invoice_Article IA WHERE IA.article_id = $id AND I.status = 'R' AND I.id = IA.invoice_id ORDER BY I.payment_date DESC LIMIT 1";
		$r = $db->query($sql);
		$invoice_data = mysql_fetch_assoc($r);

		// ---------------- //

		list($t_month,$t_day,$t_year)     = split ("/",format_date($transaction_data["transaction_datetime"], DEFAULT_DATE_FORMAT, "datetime"));
		list($i_month,$i_day,$i_year)     = split ("/",format_date($invoice_data["payment_date"], DEFAULT_DATE_FORMAT,"datetime"));
		list($t_hour,$t_minute,$t_second) = split (":",format_date($transaction_data["transaction_datetime"], "H:i:s", "datetime"));
		list($i_hour,$i_minute,$i_second) = split (":",format_date($invoice_data["payment_date"], "H:i:s", "datetime"));

		$t_ts_date = mktime((int)$t_hour,(int)$t_minute,(int)$t_second,(int)$t_month,(int)$t_day,(int)$t_year);
		$i_ts_date = mktime((int)$i_hour,(int)$i_minute,(int)$i_second,(int)$i_month,(int)$i_day,(int)$i_year);

		if (PAYMENT_FEATURE == "on") {
			if (((MANUALPAYMENT_FEATURE == "on") || (CREDITCARDPAYMENT_FEATURE == "on")) && (INVOICEPAYMENT_FEATURE == "on")) {
				if($t_ts_date < $i_ts_date){
					if($invoice_data["id"]) $history_lnk = DEFAULT_URL."/gerenciamento/invoices/view.php?id=".$invoice_data["id"];
					else unset($history_lnk);
				} else {
					if($transaction_data["id"]) $history_lnk = DEFAULT_URL."/gerenciamento/transactions/view.php?id=".$transaction_data["id"];
					else unset($history_lnk);
				}
			} elseif ((MANUALPAYMENT_FEATURE == "on") || (CREDITCARDPAYMENT_FEATURE == "on")) {
				if($transaction_data["id"]) $history_lnk = DEFAULT_URL."/gerenciamento/transactions/view.php?id=".$transaction_data["id"];
				else unset($history_lnk);
			} elseif (INVOICEPAYMENT_FEATURE == "on") {
				if($invoice_data["id"]) $history_lnk = DEFAULT_URL."/gerenciamento/invoices/view.php?id=".$invoice_data["id"];
				else unset($history_lnk);
			} else {
				unset($history_lnk);
			}
		} else {
			unset($history_lnk);
		}


	?>

		<tr>
			<td>
				<?
				if (strpos($url_base, "/gerenciamento")) {
					if ($article->needToCheckOut()) {
						echo "<img src=\"".DEFAULT_URL."/images/icon_unpaid.gif\" border=\"0\" alt=\"".system_showText(LANG_MSG_UNPAID_ITEM)."\" title=\"".system_showText(LANG_MSG_UNPAID_ITEM)."\" />";
					} else {
						echo "<img src=\"".DEFAULT_URL."/images/icon_unpaid_off.gif\" border=\"0\" alt=\"".system_showText(LANG_MSG_NO_CHECKOUT_NEEDED)."\" title=\"".system_showText(LANG_MSG_NO_CHECKOUT_NEEDED)."\" />";
					}
				}
				?>
				<a href="<?=$url_redirect?>/view.php?id=<?=$id?>&screen=<?=$screen?>&letra=<?=$letra?><?=(($url_search_params) ? "&$url_search_params" : "")?>" class="link-table"><?=$article->getString("title");?></a>
			</td>
			<td>
				<? if (strpos($url_base, "/gerenciamento")) { ?>
					<? if ($article->getNumber("account_id")) { ?>
						<a href="<?=$url_base?>/account/view.php?id=<?=$article->getNumber("account_id")?>" class="link-table">
							<?
							$account = db_getFromDB("account", "id", db_formatNumber($article->getNumber("account_id")));
							echo system_showAccountUserName($account->getString("username"));
							?>
						</a>
					<? } else { ?>
						<em><?=system_showText(LANG_SITEMGR_ACCOUNTSEARCH_NOOWNER)?></em>
					<? } ?>
				<? } else { ?>
					<?
					if ($article->hasRenewalDate()) {
						$renewal_date = format_date($article->getString("renewal_date"));
						if ($renewal_date) echo $renewal_date;
						else echo system_showText(LANG_LABEL_NEW);
					} else {
						echo "---";
					}
					?>
				<? } ?>
			</td>
			<td>
				<a href="<?=$url_redirect?>/settings.php?id=<?=$id?>" class="link-table"><? $status = new ItemStatus(); echo $status->getStatusWithStyle($article->getString("status")); ?></a>
			</td>
			<td nowrap>

				<a class="tooltip" href="<?=$url_redirect?>/view.php?id=<?=$id?>&listing_id=<?=$listing_id?>" class="link-table" title="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ARTICLE)?>">
					<img src="<?=DEFAULT_URL?>/images/bt_view.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ARTICLE)?>" title="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ARTICLE)?>" />
				</a>

				<a class="tooltip" href="<?=$url_redirect?>/article.php?id=<?=$id?>&listing_id=<?=$listing_id?>" class="link-table" title="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_THIS_ARTICLE)?>">
					<img src="<?=DEFAULT_URL?>/images/bt_edit.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_THIS_ARTICLE)?>" title="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_THIS_ARTICLE)?>" />
				</a>
			
				<? if ((ARTICLE_MAX_GALLERY > 0) && (($articleImages > 0) || ($articleImages == -1))) { ?>
					<a class="tooltip" href="<?=$url_redirect?>/gallery.php?item_type=article&item_id=<?=$id?>&listing_id=<?=$listing_id?>" class="link-table" title="<?=system_showText(LANG_MSG_CLICK_TO_ADD_EDIT_PHOTO_GALLERY_THIS_ARTICLE)?>">
						<img src="<?=DEFAULT_URL?>/images/icon_gallery.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_ADD_EDIT_PHOTO_GALLERY_THIS_ARTICLE)?>" title="<?=system_showText(LANG_MSG_CLICK_TO_ADD_EDIT_PHOTO_GALLERY_THIS_ARTICLE)?>" />
					</a>
				<? } else { ?>
					<a class="tooltip" href="#" class="link-table" title="<?=system_showText(LANG_PHOTO_GALLERY_NOT_AVAILABLE_FOR_ARTICLE)?>">
						<img src="<?=DEFAULT_URL?>/images/icon_gallery_off.gif" border="0" alt="<?=system_showText(LANG_PHOTO_GALLERY_NOT_AVAILABLE_FOR_ARTICLE)?>" title="<?=system_showText(LANG_PHOTO_GALLERY_NOT_AVAILABLE_FOR_ARTICLE)?>" />
					</a>
				<? } ?>
				<!-->
				<a class="tooltip" href="<?=$url_redirect?>/seocenter.php?id=<?=$id?>&screen=<?=$screen?>&letra=<?=$letra?><?=(($url_search_params) ? "&$url_search_params" : "")?>" class="link-table" title="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_SEOCENTER)?>">
					<img src="<?=DEFAULT_URL?>/images/icon_seo.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_SEOCENTER)?>" title="<?=system_showText(LANG_MSG_CLICK_TO_EDIT_SEOCENTER)?>" />
				</a>
				!-->
				
				<?
				$db = db_getDBObject();
				$sql ="SELECT * FROM Review WHERE item_type = 'article' AND item_id = '".$article->getString("id")."' LIMIT 1";
				$r = $db->query($sql);
				if(mysql_affected_rows() > 0) {
					?>
				<a class="tooltip" href="<?=$url_base?>/review/index.php?item_type=article&item_id=<?=$id?>&filter_id=1&item_screen=<?=$screen?>&item_letra=<?=$letra?><?=(($url_search_params) ? "&$url_search_params" : "")?>" class="link-table" title="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ITEM_REVIEWS);?>">
						<img src="<?=DEFAULT_URL?>/images/img_rateMiniStarOn.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ITEM_REVIEWS);?>" title="<?=system_showText(LANG_MSG_CLICK_TO_VIEW_THIS_ITEM_REVIEWS);?>" />
					</a> 
					<?
				} else {
					?>
					<a class="tooltip" href="#" class="link-table" title="<?=system_showText(LANG_MSG_ITEM_REVIEWS_NOT_AVAILABLE);?>">
						<img src="<?=DEFAULT_URL?>/images/img_rateMiniStarOff.gif" border="0" alt="<?=system_showText(LANG_MSG_ITEM_REVIEWS_NOT_AVAILABLE);?>" title="<?=system_showText(LANG_MSG_ITEM_REVIEWS_NOT_AVAILABLE);?>" />
					</a>	
					<?
				
				}
				?>
				<!--
				<? if($history_lnk && strpos($url_base, "/gerenciamento")) { ?>
					<a class="tooltip" href="<?=$history_lnk?>" class="link-table">
						<img src="<?=DEFAULT_URL?>/images/icon_coin.gif" border="0" alt="<?=system_showText(LANG_HISTORY_FOR_THIS_ARTICLE)?>" title="<?=system_showText(LANG_HISTORY_FOR_THIS_ARTICLE)?>" />
					</a>
				<? } elseif(strpos($url_base, "/gerenciamento")) { ?>
					<img src="<?=DEFAULT_URL?>/images/icon_coin_off.gif" border="0" alt="<?=system_showText(LANG_HISTORY_NOT_AVAILABLE_FOR_ARTICLE)?>" title="<?=system_showText(LANG_HISTORY_NOT_AVAILABLE_FOR_ARTICLE)?>" />
				<? } ?>
				!-->
				<a class="tooltip" href="<?=$url_redirect?>/delete.php?id=<?=$id?>&listing_id=<?=$listing_id?>" class="link-table"  title="<?=system_showText(LANG_MSG_CLICK_TO_DELETE_THIS_ARTICLE)?>" >
					<img src="<?=DEFAULT_URL?>/images/bt_delete.gif" border="0" alt="<?=system_showText(LANG_MSG_CLICK_TO_DELETE_THIS_ARTICLE)?>" title="<?=system_showText(LANG_MSG_CLICK_TO_DELETE_THIS_ARTICLE)?>" />
				</a>

			</td>
		</tr>

		<?
		}
	?>

</table>
</div>