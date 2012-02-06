<div class="resultado" >
<div class="summaryDescription">
        <h2 <?=$templateCSSTitle;?>><?=$listingtemplate_title?></h2>
        <?php 	if ($listing->getNumber("tipo_assinante") != 2) { ?>
        <div id="estrelas"><?=$listingtemplate_review?></div>
        <?php } ?>

			<?=$listingtemplate_designations?>
			
		<?php 	if ($listingtemplate_address != null) { ?>
			<h4><?php echo utf8_decode("Endereço: ")?><?=$listingtemplate_address?> <?=$listingtemplate_address2?> - <?=$listingtemplate_location?></h4>
		<?php } ?>
		
		
		<?php 	if ($listingtemplate_phone != null) { ?>
		

			<h4><?=system_showText("Telefone")?>: <?=$listingtemplate_phone?></h4>
		<?php } ?>


	<!-- 	<?php 	if ($listingtemplate_fax != null) { ?>
	
			<h4><?=system_showText(LANG_LISTING_LETTERFAX)?>: <?=$listingtemplate_fax?></h4>

		<?php } ?>

		<?php 	if ($listingtemplate_url != null) { ?>

			<h4><?=system_showText(LANG_LISTING_LETTERWEBSITE)?>: <?=$listingtemplate_url?></h4>
		<?php } ?> -->	


			<?php 	if ($listingtemplate_email != null) { ?>

			<h3><?=$listingtemplate_email?></h3>

			<?php } ?>


		<?php 	if ($listing->getNumber("tipo_assinante") != 2) { ?>

<?=$listingdetailsbtn ?>
		
<?php } ?>
			
			

		</div>




</div>

