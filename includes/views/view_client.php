<?
$langIndex = language_getIndex(EDIR_LANGUAGE);

if (count($client->image) > 0) {
	$col = 0;
?>

		<div class="clientDetail" style="float:left; width: 5px;">&nbsp;</div>

			<?
	for ($i=0; $i<count($client->image); $i++) {
		if ($col == 0) {
			echo "";
		}
		$col++;
		?>

		<div class="clientDetail" style="float:left; width: <?=(IMAGE_GALLERY_THUMB_WIDTH+10)?>px;">

			<?
			if (strpos($_SERVER["PHP_SELF"], "preview.php") === false) {
			//	$clientImageLink = $url_redirect."/image.php?client_image_id=".$client->image[$i]["id"]."&id=".$client->getNumber("id").";
				$clientImageLink = $url_redirect."/imagem/".$client->image[$i]["id"]."/".$client->getNumber("id");
				$clientImageStyle = "";
			} else {
				$clientImageLink = "javascript:void(0);";
				$clientImageStyle = "cursor: default;";
			}
			?>
			<a href="<?=$clientImageLink?>" style="height:<?=(IMAGE_GALLERY_THUMB_HEIGHT+10)?>px; <?=$clientImageStyle?>">

				<?
				$imageObj = new Image($client->image[$i]["thumb_id"]);
				if ($imageObj->imageExists()) {
					echo "<span class=\"clientImgThumb\">".$imageObj->getTag(true, IMAGE_GALLERY_THUMB_WIDTH, IMAGE_GALLERY_THUMB_HEIGHT, $client->image[$i]["thumb_caption".$langIndex])."</span>";
				} else {
					echo "<span class=\"errorMessage\">".system_showText(LANG_MSG_ERRORNOTHUMBIMAGE)."</span>";
				}
				?>

			</a>
	
			<? if ($client->image[$i]['thumb_caption'.$langIndex]) { ?>

				<a href="<?=$clientImageLink?>" <?=(($clientImageStyle) ? ("style=\"".$clientImageStyle."\"") : (""))?>>

					<span style="width: <?=(IMAGE_GALLERY_THUMB_WIDTH+10)?>px; width:expression(<?=IMAGE_GALLERY_THUMB_WIDTH+10?>);"><?=$client->image[$i]['thumb_caption'.$langIndex]?></span>

				</a>

			<? } ?>

		</div>

		<?
		if ($col == 4) {
			echo "<br class=\"clear\" /><br class=\"clear\" />";
			$col = 0;
		}
	}
} else {
	echo "<div class=\"response-msg notice ui-corner-all\">".system_showText("Nenhum cliente foi adicionado a esta empresa.")."</div>";
}

?>
<div style="clear:both;"></div>