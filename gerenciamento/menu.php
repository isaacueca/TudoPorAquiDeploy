<div id="sidebar">

			<div class="side-col ui-sortable">

				<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all">
					<div class="portlet-header ui-widget-header">Op&#231;&#245;es</div>
					<div class="portlet-content">
						<div id="accordion">
			<?
			unset($availablemodules);
			$availablemodules = 0;
			?>
			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_ACCOUNTS)) { ?>
							<div>
							 <h3><a href="<?=DEFAULT_URL?>/gerenciamento/account/"><?=system_showText(LANG_SITEMGR_NAVBAR_ACCOUNTS)?></a></h3>
								<div>
									<ul class="side-menu">
											<li><a href="<?=DEFAULT_URL?>/gerenciamento/conta">Minha Conta</a></li>
											<li><a href="<?=DEFAULT_URL?>/gerenciamento/usuarios"><?=system_showText(LANG_SITEMGR_NAVBAR_MEMBERACCOUNTS)?></a></li>
											<? if (check_action_permission('admin_geral', 'view', 1) == 1) {?>
												<li><a href="<?=DEFAULT_URL?>/gerenciamento/administradores"><?=system_showText("Administradores Gerais ")?></a></li>
											<?php } ?>
											<? if (check_action_permission('admin_comercial', 'view', 1) == 1) {?>
												<li><a href="<?=DEFAULT_URL?>/gerenciamento/administradores-comerciais"><?=system_showText("Administradores Comerciais")?></a></li>
											<?php } ?>
											<? if (check_action_permission('admin_local', 'view', 1) == 1) {?>
												<li><a href="<?=DEFAULT_URL?>/gerenciamento/administradores-locais"><?=system_showText("Administradores Locais")?></a></li>
											<?php } ?>
											<? if (check_action_permission('vendedores', 'view', 1) == 1) {?>
												<li><a href="<?=DEFAULT_URL?>/gerenciamento/administradores-vendedores"><?=system_showText("Vendedores")?></a></li>
											<?php } ?>
											<? if (check_action_permission('investidor', 'view', 1) == 1) {?>
												<li><a href="<?=DEFAULT_URL?>/gerenciamento/smaccount_investidor"><?=system_showText("Investidores")?></a></li>
											<?php } ?>
									</ul>
								</div>		
							</div>
			<? } ?>

							<div>
								<h3><a href="#">Diret&#243;rio</a></h3>
								<div>
									<ul class="side-menu">
			<?
			unset($availablemodules);
			$availablemodules = 0;
			?>
			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_LISTINGS)) { ?>
				<li><a href="<?=DEFAULT_URL?>/gerenciamento/estabelecimentos">Estabelecimentos</a></li>
				<? $availablemodules++; ?>
			<? } ?>
			<? if (check_action_permission('categorias', 'view', 1) == 1) {?>
				<li><a href="<?=DEFAULT_URL?>/gerenciamento/categorias"><?=system_showText(LANG_SITEMGR_NAVBAR_CATEGORIES);?> </a></li>
				<? $availablemodules++; ?>
			<? } ?>
			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_GALLERIES)) { ?>
				<!-- <li><a href="<?=DEFAULT_URL?>/gerenciamento/gallery/"><?=system_showText(LANG_SITEMGR_NAVBAR_GALLERY)?></a></li> -->
				<? $availablemodules++; ?>
			<? } ?>
			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_LISTINGS)) { ?>
				<!-- <li><a href="<?=DEFAULT_URL?>/gerenciamento/promotion/"><?=system_showText(LANG_SITEMGR_NAVBAR_PROMOTION);?></a></li> -->
				<? $availablemodules++; ?>
			<? } ?>

			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_BANNERS)) { ?>
				<? if (BANNER_FEATURE == "on") { ?>
					<li><a href="<?=DEFAULT_URL?>/gerenciamento/banner/"><?=system_showText(LANG_SITEMGR_NAVBAR_BANNER);?><? if (DEMO_MODE) { ?><span>*</span><? } ?></a></li>
					<? $availablemodules++; ?>
				<? } ?>
			<? } ?>

            <!--     <li><a href="<?=DEFAULT_URL?>/gerenciamento/clientes/">Clientes<? if (DEMO_MODE) { ?><span>*</span><? } ?></a></li> -->
					<? $availablemodules++; ?>
			<?
			if (!$availablemodules) {
				?><li class="noModules"><?=system_showText(LANG_SITEMGR_NAVBAR_NOMODULES)?></li><?
			}
			unset($availablemodules);
			?>					</ul>
								</div>
							</div>

			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_LOCATIONS)) { ?>

				<div>

									<h3><a href="<?=DEFAULT_URL?>/gerenciamento/localidades/"><?=system_showText(LANG_SITEMGR_NAVBAR_LOCATIONS)?></a></h3>
														<div>
													<ul class="side-menu">
														<li><a href="<?=DEFAULT_URL?>/gerenciamento/localidades/estados"><?=system_showText(LANG_SITEMGR_NAVBAR_COUNTRIES)?></a></li>
														<li><a href="<?=DEFAULT_URL?>/gerenciamento/localidades/cidades"><?=system_showText(LANG_SITEMGR_NAVBAR_STATES)?></a></li>
														<li><a href="<?=DEFAULT_URL?>/gerenciamento/localidades/bairros"><?=system_showText(LANG_SITEMGR_NAVBAR_CITIES)?></a></li>
													</ul>
												</div>
											</div>	
			<? } ?>

			
			<? if (permission_hasSMPermSection(SITEMGR_PERMISSION_PAYMENT)) { ?>
				<? if (check_action_permission('categorias', 'view', 1) == 1) {?>
			
			<div>
				<? if (PAYMENT_FEATURE == "on") { ?>
							<h3><a href="#"><?=system_showText(LANG_SITEMGR_NAVBAR_PAYMENT)?></a></h3>
								<div>
									<ul class="side-menu">
									<!--	<? if ((MANUALPAYMENT_FEATURE == "on") || (CREDITCARDPAYMENT_FEATURE == "on")) { ?>
											<li><a href="<?=DEFAULT_URL?>/gerenciamento/transacoes"><?=system_showText(LANG_SITEMGR_NAVBAR_TRANSACTIONHISTORY)?></a></li>
										<? } ?> -->
						
										<? if (INVOICEPAYMENT_FEATURE == "on") { ?>
											<li><a href="<?=DEFAULT_URL?>/gerenciamento/historico-de-faturas"><?=system_showText(LANG_SITEMGR_NAVBAR_INVOICEHISTORY)?></a></li>
										<? } ?>
										<? if ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on")) { ?>
											<? if (CUSTOM_INVOICE_FEATURE == "on") { ?>
										<!--	<li><a href="<?=DEFAULT_URL?>/gerenciamento/custominvoices/index.php"><?=system_showText(LANG_SITEMGR_NAVBAR_CREATEINVOICE)?></a></li> !-->
											<? } ?>
										<? } ?>
										<? if ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on")) { ?>
										<!--	<li><a href="<?=DEFAULT_URL?>/gerenciamento/discountcode/"><?=ucwords(system_showText(LANG_LABEL_DISCOUNTCODE))?></a></li> -->
										<? } ?>
									</ul>
					</div>
				<? } ?>
			
				</div>
				<? } ?>
				
			<? } ?>
			<? if (check_action_permission('relatorio_de_estatistica', 'view', 1) == 1) {?>
		
					<div>
		
					<h3><a href="<?=DEFAULT_URL?>/gerenciamento/relatorios"><?=system_showText(LANG_SITEMGR_NAVBAR_REPORTS)?></a></h3>
							<div>
								<ul class="side-menu">
									<li><a href="<?=DEFAULT_URL?>/gerenciamento/relpalavrachave"><?=system_showText("Palavras-chave")?></a></li>
								</ul>
                                <ul class="side-menu">
									<li><a href="<?=DEFAULT_URL?>/gerenciamento/relviewresult"><?=system_showText("Acessos Resultado Busca")?></a></li>
								</ul>
       	                        <ul class="side-menu">
									<li><a href="<?=DEFAULT_URL?>/gerenciamento/relminisite"><?=system_showText("Acessos Mini-site")?></a></li>
								</ul>
                                <ul class="side-menu">
									<li><a href="<?=DEFAULT_URL?>/gerenciamento/relclicksite"><?=system_showText("Clicks Website")?></a></li>
								</ul>
							</div>
					</div>	
			<? } ?>
			

					<!-- 		<div>
					<h3><a href="#">Config</a></h3>
								<div>
									<ul class="side-menu">
										<li><a href="<?=DEFAULT_URL?>/gerenciamento/prefs/">Config</a></li>
									
									</ul>
								</div>
							</div>	
							
														<div>
					<h3><a href="#">Conteudo</a></h3>
								<div>
									<ul class="side-menu">
										<li><a href="<?=DEFAULT_URL?>/gerenciamento/content/index.php">Conteudo</a></li>
									</ul>
								</div>
							</div>	
					<div>
					<h3><a href="#">Notification</a></h3>
								<div>
									<ul class="side-menu">
										<li><a href="<?=DEFAULT_URL?>/gerenciamento/emailnotifications/">Notificacao</a></li>
									</ul>
								</div>
					</div>	 -->
									
						</div>
					</div>
				</div>

				
			</div>
			<div class="clearfix"></div>
		
	</div> 	
	
	<script type="text/javascript">
		$(document).ready(function(){
			
			<? if ((strpos($_SERVER["PHP_SELF"], "gerenciamento/manageaccount.php") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/account") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/smaccount") !== false)) { ?>
				$('#accordion').accordion( { animated: 'false' } );
    			$('#accordion').accordion("activate", 0);			
			<? } ?>
			
			<? if ((strpos($_SERVER["PHP_SELF"], "gerenciamento/listing") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/listingcategs") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/gallery") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/promotion") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/banner") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/client") !== false)  ) { ?>
				$('#accordion').accordion("option", "animated", 0 );
				$('#accordion').accordion("activate", 1);	
				$('#accordion').accordion("option", "animated", "slide" );

			<? } ?>
			
			<? if ((strpos($_SERVER["PHP_SELF"], "gerenciamento/locations") !== false) ) { ?>
				$('#accordion').accordion("option", "animated", 0 );
				$('#accordion').accordion("activate", 2);
				$('#accordion').accordion("option", "animated", "slide" );			
			<? } ?>
			
			<? if ((strpos($_SERVER["PHP_SELF"], "gerenciamento/transactions") !== false) || (strpos($_SERVER["PHP_SELF"], "gerenciamento/invoices") !== false) ) { ?>
				$('#accordion').accordion("option", "animated", 0 );
				$('#accordion').accordion("activate", 3);
				$('#accordion').accordion("option", "animated", "slide" );			
			<? } ?>
			
			<? if ((strpos($_SERVER["PHP_SELF"], "gerenciamento/reports") !== false) ) { ?>
				$('#accordion').accordion("option", "animated", 0 );
				$('#accordion').accordion("activate", 4);	
				$('#accordion').accordion("option", "animated", "slide" );		
			<? } ?>
		});
	</script>
	