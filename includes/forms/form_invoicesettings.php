<div id="header-form">
	<?=system_showText(LANG_SITEMGR_INVOICE_MODIFYINVOICESTATUS)?> - <?=$invoiceObj->getString("id")?>
</div>
<? if ($message_invoicesettings) { ?>
	<div id="warning" class="errorMessage">
		<?=$message_invoicesettings?>
	</div>
<? } ?>
<table cellpadding="2" cellspacing="0" class="table-form table-form-margin">
	<tr class="tr-form">
		<td align="right" class="td-form">
			<div class="label-form">
				<?=system_showText(LANG_SITEMGR_STATUS)?>:
			</div>
		</td>
		<td align="left" class="td-form" style="width:80px;" colspan="2">
			<?=$statusDropDown?>
		</td>
    </tr>
    	<tr class="tr-form">
		<td align="right" class="td-form">
			<div class="label-form">
				 Comissão Administrador:
			</div>
		</td>
        <td align="left" class="td-form">
			<?=$dropadminlocal?>
		</td>
		<td align="left" class="td-form">
		<div>
        <select name="comissaoadmin" id="comissaoadmin"style="width:80px;">
        <option <? if($invoiceObj->getString("comissaoadmin")==0) echo selected ?> value="0">0%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==5) echo selected ?> value="5">5%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==10) echo selected ?> value="10">10%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==15) echo selected ?> value="15">15%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==20) echo selected ?> value="20">20%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==25) echo selected ?> value="25">25%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==30) echo selected ?> value="30">30%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==35) echo selected ?> value="35">35%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==40) echo selected ?> value="40">40%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==45) echo selected ?> value="45">45%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==50) echo selected ?> value="50">50%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==55) echo selected ?> value="55">55%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==60) echo selected ?> value="60">60%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==65) echo selected ?> value="65">65%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==70) echo selected ?> value="70">70%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==75) echo selected ?> value="75">75%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==80) echo selected ?> value="80">80%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==85) echo selected ?> value="85">85%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==90) echo selected ?> value="90">90%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==95) echo selected ?> value="95">95%</option>
        <option <? if($invoiceObj->getString("comissaoadmin")==100) echo selected  ?> value="100">100%</option>
       </select>
        </div>
		</td>
    </tr>
    	<tr class="tr-form">
		<td align="right" class="td-form">
			<div class="label-form">
				 Comissão Vendedor:
			</div>
		</td>
        <td align="left" class="td-form">
			<?=$dropvendedor?>
		</td>
		<td align="left" class="td-form">
		<div>
        <select name="comissaovendedor" id="comissaovendedor" style="width:80px;">
         <option <? if($invoiceObj->getString("comissaovendedor")==0) echo selected ?> value="0">0%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==5) echo selected ?> value="5">5%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==10) echo selected ?> value="10">10%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==15) echo selected ?> value="15">15%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==20) echo selected ?> value="20">20%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==25) echo selected ?> value="25">25%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==30) echo selected ?> value="30">30%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==35) echo selected ?> value="35">35%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==40) echo selected ?> value="40">40%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==45) echo selected ?> value="45">45%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==50) echo selected ?> value="50">50%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==55) echo selected ?> value="55">55%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==60) echo selected ?> value="60">60%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==65) echo selected ?> value="65">65%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==70) echo selected ?> value="70">70%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==75) echo selected ?> value="75">75%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==80) echo selected ?> value="80">80%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==85) echo selected ?> value="85">85%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==90) echo selected ?> value="90">90%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==95) echo selected ?> value="95">95%</option>
        <option <? if($invoiceObj->getString("comissaovendedor")==100) echo selected  ?> value="100">100%</option>
       </select>
        </div>
		</td>
    </tr>
    <tr class="tr-form">
		<td align="right" class="td-form">
			<div class="label-form">
				 Comissão Investidor:
			</div>
		</td>
        <td align="left" class="td-form">
			<?=$dropinvestidor?>
		</td>
		<td align="left" class="td-form">
		<div>
        <select name="comissaoinvestidor" id="comissaoinvestidor" style="width:80px;">
        <option <? if($invoiceObj->getString("comissaoinvestidor")==0) echo selected ?> value="0">0%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==5) echo selected ?> value="5">5%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==10) echo selected ?> value="10">10%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==15) echo selected ?> value="15">15%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==20) echo selected ?> value="20">20%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==25) echo selected ?> value="25">25%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==30) echo selected ?> value="30">30%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==35) echo selected ?> value="35">35%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==40) echo selected ?> value="40">40%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==45) echo selected ?> value="45">45%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==50) echo selected ?> value="50">50%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==55) echo selected ?> value="55">55%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==60) echo selected ?> value="60">60%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==65) echo selected ?> value="65">65%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==70) echo selected ?> value="70">70%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==75) echo selected ?> value="75">75%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==80) echo selected ?> value="80">80%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==85) echo selected ?> value="85">85%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==90) echo selected ?> value="90">90%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==95) echo selected ?> value="95">95%</option>
        <option <? if($invoiceObj->getString("comissaoinvestidor")==100) echo selected ?> value="100">100%</option>
       </select>
        </div>
		</td>
    </tr>
    <tr>
    <td colspan="3">
    <font size="3" color="red">Ao colocar o Status como recebido, automaticamente o estabelecimento será ativado</font>
    </td>
    </tr>
</table>