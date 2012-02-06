<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/tables/table_billing_first_step.php
	# ----------------------------------------------------------------------------------------------------

	if ((!$bill_info["listings"]) && (!$bill_info["events"]) && (!$bill_info["banners"]) && (!$bill_info["classifieds"]) && (!$bill_info["articles"]) && (!$bill_info["custominvoices"])) {
		echo "<div class=\"response-msg notice ui-corner-all\">".system_showText(LANG_MSG_NO_ITEMS_REQUIRING_PAYMENT)."</div>";
	} else {

?>

		<script>

			function toggleAll(obj, lnk){

				var value = obj.checked;
				var trElements = document.getElementsByTagName('tr');

				if(lnk == true){
					if(value == true){
						obj.checked = false;
						value = false;
					} else {
						obj.checked = true;
						value = true;
					}
				}

				for(i=0; i < trElements.length ; i++){
					for(j=0; j < trElements.item(i).childNodes.length; j++){
						if(trElements.item(i).childNodes[j].firstChild) {
							if(trElements.item(i).childNodes[j].firstChild.id == "banner_id[]"){
								if(value == true) {
									trElements.item(i).childNodes[j].firstChild.checked = true;
									trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.className = 'bg-tablebilling-active';
									for(x=0; x < trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes.length; x++) {
										if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild){
											if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.name == "discountbanner_id[]"){
												trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.disabled= false;
											}
										}
									}
								} else {
									trElements.item(i).childNodes[j].firstChild.checked = false;
									trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.className = 'bg-tablebilling-inactive';
									for(x=0; x < trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes.length; x++) {
										if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild){
											if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.name == "discountbanner_id[]"){
												trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.disabled= true;
											}
										}
									}
								}
							}
							
						}
					}
				}
			}

			function toggleLinebyChkBox(obj){
				if (obj.checked == true){
					obj.parentNode.parentNode.className = 'bg-tablebilling-active';
					for(x=0; x < obj.parentNode.parentNode.childNodes.length; x++){
						if(obj.parentNode.parentNode.childNodes[x].firstChild){
							if ((obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountlisting_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountevent_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountbanner_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountclassified_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountarticle_id[]")) {
								obj.parentNode.parentNode.childNodes[x].firstChild.disabled= false;
							}
						}
					}
				} else {
					obj.parentNode.parentNode.className = 'bg-tablebilling-inactive';
					for(x=0; x < obj.parentNode.parentNode.childNodes.length; x++){
						if(obj.parentNode.parentNode.childNodes[x].firstChild){
							if ((obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountlisting_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountevent_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountbanner_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountclassified_id[]") || (obj.parentNode.parentNode.childNodes[x].firstChild.name == "discountarticle_id[]")) {
								obj.parentNode.parentNode.childNodes[x].firstChild.disabled= true;
							}
						}
					}
				}
			}

			function toggleLine(obj){
				for(i=0; i < obj.childNodes.length; i++){
					if(obj.childNodes[i].firstChild) {
						if(obj.childNodes[i].firstChild.id == "banner_id[]") {
							if(obj.childNodes[i].firstChild.checked == true) {
								obj.className = 'bg-tablebilling-inactive';
								obj.childNodes[i].firstChild.checked = false;
								for(x=0; x < obj.childNodes.length; x++){
									if(obj.childNodes[x].firstChild){
										if(obj.childNodes[x].firstChild.name == "discountbanner_id[]"){
											obj.childNodes[x].firstChild.disabled= true;
										}
									}
								}
							} else {
								obj.childNodes[i].firstChild.checked = true;
								obj.className = 'bg-tablebilling-active';
								for(x=0; x < obj.childNodes.length; x++){
									if(obj.childNodes[x].firstChild){
										if(obj.childNodes[x].firstChild.name == "discountbanner_id[]"){
											obj.childNodes[x].firstChild.disabled= false;
										}
									}
								}
							}
						}
				
					}
				}
			}

		</script>
		<table border="0" cellpadding="2" cellspacing="2">
		</table><br/><br/>
		<?

		if ($bill_info["banners"]) {
			?>
<div class="hastable">
			<table border="0" cellpadding="2" cellspacing="2">
			<thead>
				<tr>
					<th><?=system_showText(LANG_BANNER_NAME);?></th>
					<th width="100"><?=system_showText(LANG_LABEL_IMPRESSIONS)?></th>
                    <th width="300"><?=system_showText(LANG_LABEL_LEVEL);?></th>
                    <th>Boleto</th>
                    <th>Fatura</th>
				</tr>
				</thead>
				<?
				foreach($bill_info["banners"] as $id => $info){
					$renewal_date_style = ($info["needtocheckout"] == "y") ? "color: #CC0000" : "";
					$checked = ($info["needtocheckout"] == "y") ? "checked" : "";
					?>
					<tr class="<?=(($checked) ? ("bg-tablebilling-active"): ("bg-tablebilling-inactive"))?>">
						<td style="text-align: left; cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=$info["caption"]?></td>
						<td style="cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=(($info["expiration_setting"] != BANNER_EXPIRATION_IMPRESSION) ? system_showText(LANG_LABEL_UNLIMITED) : $info["unpaid_impressions"])?></td>
						<td style="cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=ucwords($info["level"])?></td>
					    <td style="text-align: center;"><u><a class="tooltip" href="<?=DEFAULT_URL?>/boleto/boleto_bancoob_banner.php?id=<?=$id?>" target="_BLANK" title="imprimir boleto"><img border="0" src="<?=DEFAULT_URL?>/images/imprimir.gif" alt="imprimir boleto"></a></u></td>
                	    <td style="text-align: center;"><u><a class="tooltip" href="<?=DEFAULT_URL?>/membros/billing/invoice_banner.php?id=<?=$id?>" target="_BLANK"  title="imprimir fatura"><img border="0" src="<?=DEFAULT_URL?>/images/imprimir.gif" alt="imprimir fatura"></a></u></td>
                   </tr>
					<?
				}
				?>
			</table>
</div>
			<?
		} else {
			if ($overbanner_msg) {
				echo "<div class=\"response-msg notice ui-corner-all\">".$overbanner_msg."</div>";
			}
		}

	    include(INCLUDES_DIR."/forms/form_paymentmethod.php");

		?>

		<br />
		
				<input type="hidden" name="second_step" id="second_step" value="1" style="display: none" />
				<div class="clearfix"></div>
			
		<?

	}

?>
