<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/views/view_article_detail_50.php
	# ----------------------------------------------------------------------------------------------------

?>

<div class="detail">

	<? if (!strpos($_SERVER["PHP_SELF"], "print.php")) { ?>

	<? } ?>

	<div class="detailContent">

		<h2><?=$article->getString("title");?></h2>

		<?
		if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "<p class=\"complementaryInfo\">\n"; 
		if ($article->getString("publication_date", true)) {
			echo system_showText(LANG_ARTICLE_PUBLISHED).": ".$article->getDate("publication_date");
		}
		if ($article->getString("author", true)) {
			echo " ".system_showText(LANG_BY)." ";
			if (($user) && ($article->getString("author_url", true))) {
				echo "<a href=\"".$article->getString("author_url", true)."\" target=\"_blank\">\n";
			}
			echo $article->getString("author", true);
			if (($user) && ($article->getString("author_url", true))) {
				echo "</a>\n";
			}
		}
		if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "</p>\n";
		?>
		
		<? if($article->getString("content")) { ?><p class="detailSpacer"><?=nl2br($article->getStringLang(EDIR_LANGUAGE, "content", true))?></p><? } ?>		

	</div>

	<?
	setting_get("review_article_enabled", $review_enabled);
	if ($review_enabled == "on") {
		$item_id   = $id;
		$item_type = 'article';
		include(INCLUDES_DIR."/views/view_review.php");
		$summary_review .= $item_review;
		$item_review = "";
		$detail_review = "";
		if ($reviewsArr) {
			foreach ($reviewsArr as $each_rate) {
				if ($each_rate->getString("review")) {
					$each_rate->extract();
					include(INCLUDES_DIR."/views/view_review_detail.php");
					$detail_review .= $item_reviewcomment;
					$item_reviewcomment = "";
				}
			}
		}
		?>

		<?
	}
	?>

</div>