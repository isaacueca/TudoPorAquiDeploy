<?
	include("../../conf/loadconfig.inc.php");
	if (PAYMENT_FEATURE != "on") { exit; }
	if (INVOICEPAYMENT_FEATURE != "on") { exit; }
	sess_validateSession();
	$acctId = sess_getAccountIdFromSession();
	extract($_GET);
	extract($_POST);

	$url_redirect = "".DEFAULT_URL."/membros/billing";
	$url_base = "".DEFAULT_URL."/membros";
	$membros = 1;
 
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
					$arr_invoice["amount"]      = 80;
					$arr_invoice["currency"]    = INVOICEPAYMENT_CURRENCY;
					$arr_invoice["expire_date"] = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));

					$invoiceObj = new Invoice($arr_invoice);
                    
                    if (sess_getAccountIdFromSession() != $invoiceObj->getNumber("account_id")) $error = true;
                    
                    
					$invoiceObj->Save();

					
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

						$arr_invoice_listing["invoice_id"]    = $invoiceObj->getString("id");
						$arr_invoice_listing["listing_id"]    = $listingid;
						$arr_invoice_listing["listing_title"] = $listingObj->getString("title", false);
						$arr_invoice_listing["discount_id"]   = $listingObj->getString("discount_id");
						$arr_invoice_listing["level"]         = $listingObj->getString("level");
						$arr_invoice_listing["renewal_date"]  = $listingObj->getString("renewal_date");
						$arr_invoice_listing["categories"]    = ($category_amount) ? $category_amount : 0;
						$arr_invoice_listing["amount"]        = 0;

						$arr_invoice_listing["extra_categories"] = 0;
						if (($category_amount > 0) && (($category_amount - $levelObj->getFreeCategory($listingObj->getString("level"))) > 0)) {
							$arr_invoice_listing["extra_categories"] = $category_amount - $levelObj->getFreeCategory($listingObj->getString("level"));
						} else {
							$arr_invoice_listing["extra_categories"] = 0;
						}

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
            $enderecoestabelecimento  = $row["address"] . " " .$row["address2"]. '<br>'." " .$row["nomebairro"].", " .$row["nomecidade"]." - " .$row["nomeestado"] ;
            $cpfcnpj = $row["cnpj"];
            if($row["tipo_assinante"] == 30) $arr_invoice_listing[0]["amount"] = 50 + ($arr_invoice_listing["extra_categories"] * 5);	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
            if($row["tipo_assinante"] == 90) $arr_invoice_listing[0]["amount"] = 135 + ($arr_invoice_listing["extra_categories"] * 5);
            if($row["tipo_assinante"] == 180) $arr_invoice_listing[0]["amount"] = 255 + ($arr_invoice_listing["extra_categories"] * 5);
            if($row["tipo_assinante"] == 360) $arr_invoice_listing[0]["amount"] = 500 + ($arr_invoice_listing["extra_categories"] * 5);
            unset($listingObj);
		}



	include(INCLUDES_DIR."/views/view_invoice.php");

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
