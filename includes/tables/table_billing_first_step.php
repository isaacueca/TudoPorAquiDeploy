<?
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
							if(trElements.item(i).childNodes[j].firstChild.id == "listing_id[]"){
								if(value == true) {
									trElements.item(i).childNodes[j].firstChild.checked = true;
									trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.className = 'bg-tablebilling-active';
									for(x=0; x < trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes.length; x++) {
										if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild){
											if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.name == "discountlisting_id[]"){
												trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.disabled= false;
											}
										}
									}
								} else {
									trElements.item(i).childNodes[j].firstChild.checked = false;
									trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.className = 'bg-tablebilling-inactive';
									for(x=0; x < trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes.length; x++) {
										if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild){
											if(trElements.item(i).childNodes[j].firstChild.parentNode.parentNode.childNodes[x].firstChild.name == "discountlisting_id[]"){
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
						if(obj.childNodes[i].firstChild.id == "listing_id[]") {
							if(obj.childNodes[i].firstChild.checked == true) {
								obj.className = 'bg-tablebilling-inactive';
								obj.childNodes[i].firstChild.checked = false;
								for(x=0; x < obj.childNodes.length; x++){
									if(obj.childNodes[x].firstChild){
										if(obj.childNodes[x].firstChild.name == "discountlisting_id[]"){
											obj.childNodes[x].firstChild.disabled= true;
										}
									}
								}
							} else {
								obj.childNodes[i].firstChild.checked = true;
								obj.className = 'bg-tablebilling-active';
								for(x=0; x < obj.childNodes.length; x++){
									if(obj.childNodes[x].firstChild){
										if(obj.childNodes[x].firstChild.name == "discountlisting_id[]"){
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

		if ($bill_info["listings"]) {
			?>
	<div class="hastable">
			<table border="0" cellpadding="2" cellspacing="2">
			<thead>
				<tr>
					<th>Estabelecimento</th>
                    <th>Tipo</th>
					<th><?=system_showText(LANG_LABEL_EXTRA_CATEGORY);?></th>
					<th><?=system_showText(LANG_LABEL_RENEWAL);?></th>
                    <th>Boleto</th>
                    <th>Fatura</th>
				</tr>
				</thead>
				<?
				foreach($bill_info["listings"] as $id => $info){
					$renewal_date_style = ($info["needtocheckout"] == "y") ? "color: #CC0000" : "";
					$checked = ($info["needtocheckout"] == "y") ? "checked" : "";
                    if (($info["tipo_assinante"] == "30") || ($info["tipo_assinante"] == "90") || ($info["tipo_assinante"] == "180") || ($info["tipo_assinante"] == "360")) {
					?>
					<tr class="<?=(($checked) ? ("bg-tablebilling-active"): ("bg-tablebilling-inactive"))?>">
						
                    	<td style="text-align: left; cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=$info["title"]?><?=($info["listingtemplate"]?"<span class=\"itemNote\">(".$info["listingtemplate"].")</span>":"");?></td>
						<td style="text-align: left; cursor: pointer;">
                        <? if ($info["tipo_assinante"] == "30") echo "Mensal"?>
                        <? if ($info["tipo_assinante"] == "90") echo "Trimestral"?>
                        <? if ($info["tipo_assinante"] == "180") echo "Semestral"?>
                        <? if ($info["tipo_assinante"] == "360") echo "Anual"?>
                        </td>
						<td style="cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=$info["extra_category_amount"]?></td>
						<td style="cursor: pointer; <?=$renewal_date_style?>" onclick="toggleLine(this.parentNode)"><?=(($info["renewal_date"] == "0000-00-00") ? system_showText(LANG_LABEL_NEW) : format_date($info["renewal_date"]))?></td>
				        <td style="text-align: center;"><u><a class="tooltip" href="<?=DEFAULT_URL?>/boleto/boleto_bancoob.php?id=<?=$id?>" target="_BLANK" title="imprimir boleto"><img border="0" src="<?=DEFAULT_URL?>/images/imprimir.gif" alt="imprimir boleto"></a></u></td>
                	    <td style="text-align: center;"><u><a class="tooltip" href="<?=DEFAULT_URL?>/membros/billing/invoice.php?id=<?=$id?>" target="_BLANK"  title="imprimir fatura"><img border="0" src="<?=DEFAULT_URL?>/images/imprimir.gif" alt="imprimir fatura"></a></u></td>
                    </tr>
                    
					<? }
				}
				?>
			</table>
		</div>
			<?
		} else {
			if ($overlisting_msg) {
				echo "<div class=\"response-msg notice ui-corner-all\">".$overlisting_msg."</div>";
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
