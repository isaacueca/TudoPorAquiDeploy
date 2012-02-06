<?
	// Price description ---------------------------------------------
	$levelObj = new BannerLevel(EDIR_DEFAULT_LANGUAGE, true);
	$levelValue = $levelObj->getValues();
	unset($strArray);
	foreach ($levelValue as $value) {
		$strAux = $levelObj->showLevel($value).": <b>";
		if ($levelObj->getPrice($value) > 0) {
			$strAux .= $levelObj->getPrice($value);
		} else { 
			$strAux .= system_showText(LANG_LABEL_FREE);
		}
		$strAux .= "</b> ".system_showText(LANG_PER)." ";
		if (payment_getRenewalCycle("banner") > 1) {
			$strAux .= payment_getRenewalCycle("banner")." ";
			$strAux .= payment_getRenewalUnitName("banner")."s";
		}else {
			$strAux .= payment_getRenewalUnitName("banner");
		}
		$strAux2 = $levelObj->showLevel($value).": <b>";
		if ($levelObj->getImpressionPrice($value) > 0) {
			$strAux2 .= "R$ ".$levelObj->getImpressionPrice($value);
		} else { 
			$strAux2 .= system_showText(LANG_LABEL_FREE);
		}
		$strAux2 .= "</b> ".system_showText(LANG_EACH)." ".$levelObj->getImpressionBlock($value)." ".system_showText(LANG_IMPRESSIONSBLOCK);
		$strArray[] = $strAux;
		$strArray2[] = $strAux2;
		
	}
	// ---------------------------------------------------------------
?>

<?  // Account Search Javascript /////////////////////////////////////////////////////// ?>

<script type="text/javascript" src="<?=DEFAULT_URL?>/scripts/accountsearch.js"></script>

<?  //////////////////////////////////////////////////////////////////////////////////// ?>

<?  // Banner Javascript /////////////////////////////////////////////////////////////// ?>

<script language="javascript" src="<?=DEFAULT_URL?>/scripts/banner.js"></script>

<?  //////////////////////////////////////////////////////////////////////////////////// ?>

<script>
	function toogleTrans(obj) {
		if (obj.checked == true) {
			document.getElementById("trans_form").style.display = 'block';
		} else {
			document.getElementById("trans_form").style.display = 'none';
		}
	}
	function emptyDate(obj) {
		if (obj.value == "00/00/0000") {
			return true;
		} else {
			return false;
		}
	}
	$(document).ready(function(){
		$('a#showBanners').click(function(){
			if ($('#banners').hasClass('hidden')){
			$('#banners').addClass('show');
			$('#banners').show().removeClass('hidden');
			
			}
			else{
				$('#banners').addClass('hidden');
				$('#banners').hide().removeClass('show');
			}
		})
		
	})
	
</script>

<? 
	echo "<div class=\"response-msg notice ui-corner-all\"><span>* ".system_showText(LANG_LABEL_REQUIRED_FIELD)." </div>";
	if($message) { ?>
<div class="response-msg success ui-corner-all"><span><?=$message?></span></div>
<? } ?>
	<? if($error_message) { ?>
<div class="response-msg error ui-corner-all"><span><?=$error_message?></span></div>
<? } ?>


<? // Account Search ////////////////////////////////////////////////////////////////// ?>
<? if (!$membros) { ?>

	<?
	$acct_search_table_title = system_showText(LANG_SITEMGR_ACCOUNTSEARCH_SELECT)." ".system_showText(LANG_SITEMGR_BANNER);
	$acct_search_field_name = "account_id";
	$acct_search_field_value = $account_id;
	$acct_search_required_mark = false;
	$acct_search_form_width = "95%";
	$acct_search_cell_width = "";
	$return = system_generateAjaxAccountSearch($acct_search_table_title, $acct_search_field_name, $acct_search_field_value, $acct_search_required_mark, $acct_search_form_width, $acct_search_cell_width);
	echo $return;
	?>

<? } ?>

<? //////////////////////////////////////////////////////////////////////////////////// ?>
	<table cellpadding="0" cellspacing="0" border="0" class="standard-table">
		<tr>
			<th colspan="2" class="standard-tabletitle"><?=system_showText(LANG_BANNER_TYPE);?></th>
		</tr>
	</table>
        

	</table>

	<div id="banners" class="show" >
		<div class="container"><a class="thickbox" href="<?php echo DEFAULT_URL ?>/images/banner_front_page_top.gif"><img src="<?php echo DEFAULT_URL ?>/images/banner_front_page_top_thumb.gif" width="100" height="100" border="0"><div class="label_banner"> <?php echo utf8_decode("Página principal - topo")?></a></div></div>
		<div class="container"><a class="thickbox" href="<?php echo DEFAULT_URL ?>/images/banner_front_page_bottom.gif"><img src="<?php echo DEFAULT_URL ?>/images/banner_front_page_bottom_thumb.gif" width="100" height="100"><div class="label_banner"><?php echo utf8_decode("Página principal - rodapé")?></a></div></div>
		<div class="container"><a class="thickbox" href="<?php echo DEFAULT_URL ?>/images/banner_results_top.gif"><img src="<?php echo DEFAULT_URL ?>/images/banner_results_top_thumb.gif" width="100" height="100"><div class="label_banner"><?php echo utf8_decode("Página de resultados da busca - topo")?></a></div></div>
		<div class="container"><a class="thickbox" href="<?php echo DEFAULT_URL ?>/images/banner_results_bottom.gif"><img src="<?php echo DEFAULT_URL ?>/images/banner_results_bottom_thumb.gif" width="100" height="100"><div class="label_banner"><?php echo utf8_decode("Página de resultados da busca - rodapé")?></a></div></div>
		<div class="container"><a class="thickbox" href="<?php echo DEFAULT_URL ?>/images/banner_results_right.gif"><img src="<?php echo DEFAULT_URL ?>/images/banner_results_right_thumb.gif" width="100" height="100"><div class="label_banner"><?php echo utf8_decode("Página de resultados da busca - lado direito")?></a></div></div>
		<div style="clear:both"></div>
	</div>
			

	<div style="margin-left:40px">
		<? // ================== TYPE ==========================?>
		* <?=system_showText(LANG_LABEL_TYPE);?>:
			<?
            if(!isset($id) || ($id == null) || ($process == "signup")) {
                ?><td><?=$bannerTypeDropDown?></td><?
            } else {
                ?>
                    <?=$levelObj->showLevel($type)." (".$levelObj->getWidth($type)."px x ".$levelObj->getHeight($type)."px)"?>
                    <input type="hidden" name="type" value="<?=$type?>" />
                <?
            }
			?>
		</div>

	<table cellpadding="0" cellspacing="0" border="0" class="standard-table">
		<tr>
			<th colspan="2" class="standard-tabletitle"><?=system_showText(LANG_ORDER_BANNER);?></th>
		</tr>
		<? 
			if ((sess_isSitemgrLogged()) && (strpos($url_base, "/gerenciamento"))) {
			/* SITEMGR SECTION */
		?>
        <tr>
			<th><input type="radio" name="expiration_setting" value="0" id="expiration_setting" <?=(($unlimited_impressions == "y") ? "checked" : "" )?> onclick="bannerDisableRenewalDate()" class="inputRadio" /></th>
			<td>Visualiza&#231;&#245;es ilimitadas</td>
		</tr>
		<tr>
			<th><input type="radio" name="expiration_setting" value="1" id="expiration_setting" <?=(($unlimited_impressions == "n") ? "checked" : "" )?> onclick="bannerDisableRenewalDate()" class="inputRadio" /></th>
			<td><?=system_showText(LANG_LABEL_IMPRESSIONS);?>: <input type="text" name="impressions" id="impressions" value="<?=$impressions?>" maxlength="4" <?=((!$expiration_setting || $expiration_setting != BANNER_EXPIRATION_IMPRESSION) ? "disabled=true" : "")?> style="width:100px" /></td>
		</tr>
     
		<tr>
			<th>&nbsp;</th>
			<td><? echo implode(" <br /> ", $strArray2); ?></td>
		</tr>
        
 
		<? 
			/* MEMBERS SECTION */
			} elseif ((sess_isAccountLogged()) && (strpos($url_base, "/membros"))) {
		?>

		<tr>
			<th>
				<input <? if ($process == "signup") { echo "disabled=disabled"; } ?> type="radio" name="expiration_setting" id="expiration_setting" value="<?=BANNER_EXPIRATION_IMPRESSION?>" <?=(($expiration_setting == BANNER_EXPIRATION_IMPRESSION) ? "checked" : "checked" )?> onclick="bannerDisableRenewalDate()" class="inputRadio" />
				<? if ($process == "signup") { if ($expiration_setting == BANNER_EXPIRATION_IMPRESSION) { ?> <input type="hidden" name="expiration_setting" value="<?=BANNER_EXPIRATION_IMPRESSION?>" /> <? } } ?>
			</th>
			<td valign="top">
				<?=system_showText(LANG_LABEL_IMPRESSIONS)?>: <?=system_showText(LANG_ADD);?> <?=$bannerImpressionDropDown?><?=system_showText(LANG_IMPRESSIONPAIDOF);?>: <strong><?=(($impressions) ? $impressions : "0")?></strong>.
			</td>
		</tr>
        <tr>
        <th></th><td><b><div id="total"></div></b></td>
        </tr>

		<tr>
			<th>&nbsp;</th>
			<td><? echo implode(" <br /> ", $strArray2); ?></td>
		</tr>

		</tr>
	<? } ?>

	</table>
    <input type="hidden" id="typetype" value="1" />
    <script language=javascript runat=server>
    function CurrencyFormatted(amount)
{
	var i = parseFloat(amount);
	if(isNaN(i)) { i = 0.00; }
	var minus = '';
	if(i < 0) { minus = '-'; }
	i = Math.abs(i);
	i = parseInt((i + .005) * 100);
	i = i / 100;
	s = new String(i);
	if(s.indexOf('.') < 0) { s += ',00'; }
	if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
	s = minus + s;
	return s;
}

function calc()

{ 
   
var price;
switch(document.getElementById("typetype").value)
{
case "1":
  price = 0.080;
  break;
case "2":
  price = 0.030;
  break;
case "3":
  price = 0.010;
  break;
case "4":
  price = 0.005;
  break;
case "5":
  price = 0.015;
  break;
}
document.getElementById("total").innerHTML = "Total: R$ " + CurrencyFormatted(document.getElementById("unpaid_impressions").value * price);
document.getElementById("msgpagamento").innerHTML = "&#201; necess&#225;rio efetuar um pagamento no valor de R$ "+ CurrencyFormatted(document.getElementById("unpaid_impressions").value * price)+" para que os "+document.getElementById("unpaid_impressions").value+" cr&#233;ditos de visualiza&#231;&#245;es sejam liberados. ";
}

</script>


	<table cellpadding="0" cellspacing="0" border="0" class="standard-table">
		<tr>
			<th colspan="2" class="standard-tabletitle"><?=system_showText(LANG_BANNER_DETAIL_PLURAL)?></th>
		</tr>
		<?
		$array_edir_languagenames = explode(",", EDIR_LANGUAGENAMES);
		for ($i=0; $i<count(explode(",", EDIR_LANGUAGES)); $i++) {
			$labelsuffix = "";
			if ($i) $labelsuffix = $i;
			?>
			<tr>
				<th style="vertical-align:top"><? if (!$i) echo "*"; ?> <?=system_showText(LANG_LABEL_CAPTION)?><?=((count(explode(",", EDIR_LANGUAGES))>1)?(" (".$array_edir_languagenames[$i]."):"):(":"));?></th>
				<td>
					<input type="text" name="caption<?=$labelsuffix;?>" value="<?=${"caption".$labelsuffix}?>" class="input-form-banner" maxlength="25" /><span><?=system_showText(LANG_MSG_MAX_25_CHARS)?></span>
				</td>
			</tr>
			<?
		}
		?>
		<tr >
			<td nowrap style="display:none">
				<input type="radio" name="section" value="general" checked="checked" onclick="fillBannerCategorySelect('<?=DEFAULT_URL?>', this.form.category_id, this.value, this.form);" class="inputAlign" /> <?=system_showText(LANG_GENERALPAGES);?> 
				<input type="radio" name="section" value="listing" <? if ($section == "listing") echo "checked=\"checked\""; ?> onclick="fillBannerCategorySelect('<?=DEFAULT_URL?>', this.form.category_id, this.value, this.form);" class="inputAlign" /> <?=system_showText(LANG_LISTING_FEATURE_NAME);?>
			</td>
		</tr>
		<tr>
			<td nowrap style="display:none">
				<?=$categoryDropDown?>
			</td>
		</tr>
		<tr>
			<th class="wrap"><?=system_showText(LANG_OPENNEWWINDOW);?>:</th>
			<td>
				<div class="label-form">
					<input type="radio" name="target_window" value="1" <? if ($target_window == "1") echo "checked";?> class="inputAlign" /> <?=system_showText(LANG_NO);?>
					<input type="radio" name="target_window" value="2" <? if (($target_window == "2") || (!$target_window)) echo "checked";?> class="inputAlign" /> <?=system_showText(LANG_YES);?>
				</div>
			</td>
		</tr>
		<tr>
			<th style="vertical-align:top"><?=system_showText(LANG_LABEL_DESTINATION_URL)?>:</th>
			<td>
				<input style="width:400px" type="text" name="destination_url" value="<?=$destination_url?>" class="input-form-banner" maxlength="500" />
				<span><?=system_showText(LANG_MSG_MAX_500_CHARS)?></span>
			</td>
		</tr>
	</table>

	<div id="banner_with_images">
		<?
		$array_edir_languagenames = explode(",", EDIR_LANGUAGENAMES);
		$array_edir_languages = explode(",", EDIR_LANGUAGES);
		for ($i=0; $i<count($array_edir_languages); $i++) {
			$labelsuffix = "";
			if ($i) $labelsuffix = $i;
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="standard-table">
				<tr>
					<th style="vertical-align:top"><? if (!$i) echo "*"; ?> <?=system_showText(LANG_LABEL_FILE)?><?=((count(explode(",", EDIR_LANGUAGES))>1)?(" (".$array_edir_languagenames[$i]."):"):(":"));?></th>
					<td>
						<input type="file" name="file<?=$labelsuffix;?>" class="input-form-banner" />
						<span><?=system_showText(LANG_MSG_MAX_FILE_SIZE)?> <?=UPLOAD_MAX_SIZE;?> MB.</span>
						<span><?=system_showText(LANG_MSG_ALLOWED_FILE_TYPES)?>: SWF, GIF, JPEG</span>
						<span><b><?=system_showText(LANG_LABEL_WARNING)?>:</b></span>
						<span><?=system_showText(LANG_BANNERFILEHELP);?></span>
                        <span id="msgpagamento"></span>
					</td>
				</tr>
				<? if (${"image_id".$labelsuffix} > 0) { ?>
					<tr>
						<td colspan="2" class="standard-tableContent" style="text-align: center;">
							<a href="javascript:void(0);" onclick="javascript:window.open('<?=$url_base?>/banner/preview.php?id=<?=$id?>&lang=<?=$array_edir_languages[$i]?>', '', 'toolbar=0, location=0, directories=0, status=0, scrollbars=yes, width=800, height=400, screenX=0, screenY=0, menubar=0');" class="standardLINK"><?=system_showText(LANG_MSG_CLICK_TO_PREVIEW_THIS_BANNER);?></a>
						</td>
					</tr>
				<? } ?>
			</table>
			<?
		}
		?>
	</div>


		<table cellpadding="0" cellspacing="0" border="0" class="standard-table">

			<? if (
					(
						(!$thisBannerObject) ||
						(($expiration_setting == BANNER_EXPIRATION_IMPRESSION) && ($impressions <= 0)) ||
						(($expiration_setting == BANNER_EXPIRATION_RENEWAL_DATE) && ($thisBannerObject) && ($thisBannerObject->needToCheckOut())) ||
						($url_base == DEFAULT_URL."/gerenciamento") ||
						(($thisBannerObject) && ($thisBannerObject->getPrice() <= 0))
					)
					&&
					($process != "signup")
				) {
			?>

			<? } ?>
		</table>


<script language="javascript">
document.getElementById("impressions").disabled = false;
document.getElementById("unpaid_impressions").value = 1000;
document.getElementById("total").innerHTML = "Total: R$ 80,00";
document.getElementById("msgpagamento").innerHTML = "&#201; necess&#225;rio efetuar um pagamento no valor de R$ 80,00 para que os 1000 cr&#233;ditos de visualiza&#231;&#245;es sejam liberados.";
	var banner_tmp_form_images_content = document.getElementById("banner_with_images").innerHTML;
	var banner_tmp_form_text_content = document.getElementById("banner_with_text").innerHTML;
</script>


<script language="javascript" >
document.getElementById('unpaid_impressions').disabled = false;
document.getElementById('impressions').disabled = false;
	
	<?
	if ($type < 50)       echo "bannerDisableTextForm();";
	else if ($type >= 50) echo "bannerDisableImagesForm();";
	?>
	
</script>