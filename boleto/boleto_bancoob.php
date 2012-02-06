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
	$listingid = $id;
    if ($listingid) {
		$invoiceStatusObj = new InvoiceStatus();
					$accountObj       = new Account($acctId);
					$arr_invoice["account_id"]  = $acctId;
					$arr_invoice["username"]    = $accountObj->getString("username");
					$arr_invoice["ip"]          = $_SERVER["REMOTE_ADDR"];
					$arr_invoice["date"]        = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
					$arr_invoice["status"]      = $invoiceStatusObj->getDefault();
                    
                    $levelObj = new ListingLevel();
                    $listingObj = new Listing($listingid);
                    
                        $dbObjCat = db_getDBObject();
						$sqlCat = "SELECT cat_1_id, cat_2_id, cat_3_id, cat_4_id, cat_5_id FROM Listing WHERE id = ".$listingObj->getString("id")."";
						$rCat = $dbObjCat->query($sqlCat);
						$row = mysql_fetch_assoc($rCat);
						$category_amount = 0;
						if ($row["cat_1_id"]) $category_amount++;
						if ($row["cat_2_id"]) $category_amount++;
						if ($row["cat_3_id"]) $category_amount++;
						if ($row["cat_4_id"]) $category_amount++;
						if ($row["cat_5_id"]) $category_amount++;
                      
                        $excategory = 0;
						if (($category_amount > 0) && (($category_amount - $levelObj->getFreeCategory($listingObj->getString("level"))) > 0)) {
							$excategory = $category_amount - $levelObj->getFreeCategory($listingObj->getString("level"));
						} else {
							$excategory = 0;
						}
                        
                 
                    if($listingObj->getString("tipo_assinante") == 30)  $amount = 50;	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
                    if($listingObj->getString("tipo_assinante") == 90)  $amount = 135;
                    if($listingObj->getString("tipo_assinante") == 180) $amount = 255;
                    if($listingObj->getString("tipo_assinante") == 360) $amount = 500;
                    $amount += (5 * $excategory);
                    $arr_invoice["amount"] = $amount;
                   	$arr_invoice["currency"]    = INVOICEPAYMENT_CURRENCY;
					$arr_invoice["expire_date"] = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
					$invoiceObj = new Invoice($arr_invoice);
                    $invoiceObj->Save();
                  
                    if (sess_getAccountIdFromSession() != $invoiceObj->getNumber("account_id")) $error = true;
                    
					                 
                        $arr_invoice_listing["invoice_id"]    = $invoiceObj->getString("id");
						$arr_invoice_listing["listing_id"]    = $listingid;
						$arr_invoice_listing["listing_title"] = $listingObj->getString("title", false);
						$arr_invoice_listing["discount_id"]   = $listingObj->getString("discount_id");
						$arr_invoice_listing["level"]         = $listingObj->getString("level");
						$arr_invoice_listing["renewal_date"]  = $listingObj->getString("renewal_date");
                        $arr_invoice_listing["dia_vencimento"]  = $listingObj->getString("dia_vencimento");
                        $diavencimento = $arr_invoice_listing["dia_vencimento"];  
                        $renewaldate = $arr_invoice_listing["renewal_date"];                        
						$arr_invoice_listing["categories"]    = ($category_amount) ? $category_amount : 0;
						$arr_invoice_listing["extra_categories"] = $excategory;                       
                        $arr_invoice_listing["amount"]    = $amount;
						$arr_invoice_listing["listingtemplate_title"] = "";
						if (LISTINGTEMPLATE_FEATURE == "on") {
							if ($listingObj->getString("listingtemplate_id")) {
								$listingTemplateObj = new ListingTemplate($listingObj->getString("listingtemplate_id"));
								$arr_invoice_listing["listingtemplate_title"] = $listingTemplateObj->getString("title", false);
							}
						}

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
		$contactObj = new Contact($invoiceObj->getString("account_id"));

		// Listing info
		$dbObj = db_getDBObject();
		$sql = "SELECT *,Location_Country.name as nomeestado, Location_State.name as nomecidade,Location_Region.name as nomebairro FROM Invoice_Listing 
inner join Listing on Invoice_Listing.listing_id = Listing.id 
left join Location_Country on Listing.estado_id = Location_Country.id 
left join Location_State on Listing.cidade_id = Location_State.id
left join Location_Region on Listing.bairro_id = Location_Region.id
WHERE invoice_id = '{$invoiceid}'";
		$rs = $dbObj->query($sql);

		$i=0;
		while($row = mysql_fetch_assoc($rs)){
			$listingObj = new Listing($row["listing_id"]);
			$arr_invoice_listing[$i] = $row;
			$arr_invoice_listing[$i]["renewal_date"] = format_date($row["renewal_date"]);

			if (LISTINGTEMPLATE_FEATURE == "on") {
				if ($listingObj->getNumber("listingtemplate_id")) {
					$listingTemplateObj = new ListingTemplate($listingObj->getNumber("listingtemplate_id"));
					$arr_invoice_listing[$i]["listingtemplate"] = $listingTemplateObj->getString("title");
				}
			}

			$arr_invoice_listing[$i++]["listing_title"] = $row["listing_title"];
            $listing_title = $row["listing_title"];
            $enderecoestabelecimento  = $row["address"] . " " .$row["address2"]." | " .$row["nomebairro"].", " .$row["nomecidade"]." - " .$row["nomeestado"] ;
            $cpfcnpj = $row["cnpj"];
            $tipo_assinante = $row["tipo_assinante"];
			unset($listingObj);
		}

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
//$taxa_boleto = 0;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
$i=7;
while (date("d", time() + ($i * 86400)) <> $diavencimento)   {
  $i++;
}
if ($renewaldate!="0000-00-00")

  $data_venc = date("d/m/Y", mktime(0, 0, 0, substr($renewaldate,5,2), substr($renewaldate,8,2), substr($renewaldate,0,4)));  // Prazo de X dias OU informe data: "13/04/2006";
 else
 
  $data_venc = date("d/m/Y", time() + ($i * 86400)); 
  
                //$data_venc =$listingObj->getString("renewal_date");                   



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
$dadosboleto["sacado"] = $listing_title." | ".$cpfcnpj."<br>".$enderecoestabelecimento;

$dadosboleto["endereco1"] = $contactObj->getString("address")." ".$contactObj->getString("address2");
$dadosboleto["endereco2"] = "";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Mensalidade referente a assinatura do site tudoporaqui.com";
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




