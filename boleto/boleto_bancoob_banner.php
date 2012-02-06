<?
	include("../conf/loadconfig.inc.php");
	if (PAYMENT_FEATURE != "on") { exit; }
	if (INVOICEPAYMENT_FEATURE != "on") { exit; }
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();
	extract($_GET);
	extract($_POST);

	$membros = 1;
	# ----------------------------------------------------------------------------------------------------
	# * CODE
	# ----------------------------------------------------------------------------------------------------  
	$error = false;
	$bannerid = $id;
    if ($bannerid) {
		$invoiceStatusObj = new InvoiceStatus();
		$accountObj       = new Account($acctId);
		$arr_invoice["account_id"]  = $acctId;
		$arr_invoice["username"]    = $accountObj->getString("username");
		$arr_invoice["ip"]          = $_SERVER["REMOTE_ADDR"];
		$arr_invoice["date"]        = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
		$arr_invoice["status"]      = $invoiceStatusObj->getDefault();
        $bannerObj = new Banner($bannerid);
                 
        //Home Page Topo: R$ 80.00 cada 1000 blocos de visualizações 
        //Home Page Rodapé: R$ 30.00 cada 1000 blocos de visualizações 
        //Resultado Da Busca - Topo: R$ 10.00 cada 1000 blocos de visualizações 
        //Resultado Da Busca - Rodapé: R$ 5.00 cada 1000 blocos de visualizações 
        //Resultados Da Busca - Lado Direito: R$ 15.00 cada 1000 blocos de visualizações
                   
        if($bannerObj->getString("type") == 1)  $amount = 0.080;
        if($bannerObj->getString("type") == 2)  $amount = 0.030;
        if($bannerObj->getString("type") == 3)  $amount = 0.010;
        if($bannerObj->getString("type") == 4)  $amount = 0.005;
        if($bannerObj->getString("type") == 5)  $amount = 0.015;
        $amount = $bannerObj->getString("unpaid_impressions") * $amount;
        $unpaid_impressions = $bannerObj->getString("unpaid_impressions");
        $arr_invoice["amount"] = $amount;
        $arr_invoice["currency"]    = INVOICEPAYMENT_CURRENCY;
		$arr_invoice["expire_date"] = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
		$invoiceObj = new Invoice($arr_invoice);
        $invoiceObj->Save();
        if (sess_getAccountIdFromSession() != $invoiceObj->getNumber("account_id")) $error = true;
                         
        $arr_invoice_banner["invoice_id"]     = $invoiceObj->getString("id");
		$arr_invoice_banner["banner_id"]      = $id;
		$arr_invoice_banner["banner_caption"] = $bannerObj->getString("caption",false);
		$arr_invoice_banner["discount_id"]    = $bannerObj->getString("discount_id");
		$arr_invoice_banner["level"]          = $bannerObj->getString("type");
		$arr_invoice_banner["renewal_date"]   = $bannerObj->getString("renewal_date");
		$arr_invoice_banner["impressions"]    = $bannerObj->getString("unpaid_impressions");
		$arr_invoice_banner["amount"]         = $amount;

		$invoiceBannerObj = new InvoiceBanner($arr_invoice_banner);
		$invoiceBannerObj->Save();

						unset($bannerObj);
						unset($invoiceBannerObj);

						$invoiceListingObj = new InvoiceListing($arr_invoice_listing);
						$invoiceListingObj->Save();

						unset($listingObj);
						unset($invoiceListingObj);

					

	} else {
		$error = true;
	}
    $invoiceid = $invoiceObj->getString("id");
	if (!$error) {

		// Invoice info
		if ($invoiceObj->getString("status") == "N") $invoiceObj->setString("status","P");
		$invoiceObj->Save();

		// Account info
		$contactObj = new Contact($acctId);

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 7;
//$taxa_boleto = 0;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400)); 
  
$valor_cobrado = format_money($invoiceObj->getString("amount")); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(".", ",",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
//$valor_boleto="1,00";

$dadosboleto["nosso_numero"] =  date("y", time()).$invoiceObj->getString("id");  // Até 8 digitos, sendo os 2 primeiros o ano atual (Ex.: 08 se for 2008)
$dadosboleto["numero_documento"] = $invoiceObj->getString("id");	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $amount.",00";

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $contactObj->getString("first_name")." ".$contactObj->getString("last_name");

$dadosboleto["endereco1"] = $contactObj->getString("address")." ".$contactObj->getString("address2");
$dadosboleto["endereco2"] = "";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento referente a ".$unpaid_impressions." visualizações de Banner no site tudoporaqui.com";
$dadosboleto["demonstrativo2"] = "";
//$dadosboleto["demonstrativo3"] = "";

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Receber até 07 dias após o vencimento";
$dadosboleto["instrucoes2"] = "- Responsável: ".$contactObj->getString("first_name")." ".$contactObj->getString("last_name");
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: atendimento@tudoporaqui.com.br";
//$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] =" ";
$dadosboleto["aceite"] = "N";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS ESPECIFICOS DO SICOOB
$dadosboleto["modalidade_cobranca"] = "01";
$dadosboleto["numero_parcela"] = "001";


// DADOS DA SUA CONTA - BANCO SICOOB
$dadosboleto["agencia"] = "3240"; // Num da agencia, sem digito
$dadosboleto["conta"] = "7652"; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - SICOOB
$dadosboleto["convenio"] = "7652";  // Num do convênio - REGRA: No máximo 7 dígitos
$dadosboleto["carteira"] = "1";

// SEUS DADOS
$dadosboleto["identificacao"] = "Tudo Por Aqui";
$dadosboleto["cpf_cnpj"] = "03.247.197/0001-56";
$dadosboleto["endereco"] = "Rua Presidente Prudente de Moraes, 985";
$dadosboleto["cidade_uf"] = "Joinville - SC";
$dadosboleto["cedente"] = " SLG - Tudo Por Aqui";

// NÃO ALTERAR!
include("include/funcoes_bancoob.php");
include("include/layout_bancoob.php");

	} else {
		?>
		<html>
			<head>
				<title><?=system_showText(LANG_LABEL_ERROR)?></title>
			</head>
			<body>
				<?=system_showText(LANG_MSG_ACCESS_NOT_ALLOWED)?>
			</body>
		</html>
		<?
	}

?>




