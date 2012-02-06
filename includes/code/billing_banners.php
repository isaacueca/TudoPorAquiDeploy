<?
	$max_item_sum = 50;
	extract($_POST);
	extract($_GET);

	if ($second_step && !$payment_method) {
		$payment_message = system_showText(LANG_MSG_NO_PAYMENT_METHOD_SELECTED);
	} else {

			/**
		* Banner bill information
		*******************************************************************************/

		if (!$second_step) {
			if (BANNER_FEATURE == "on") {
				$dbObject = db_getDBObject();
				$sql = "SELECT count(id) FROM Banner WHERE account_id = ".sess_getAccountIdFromSession();
				$result = $dbObject->query($sql);
				if ($row = mysql_fetch_array($result)) {
					$total_banner_sum = $row[0];
				}
				unset($dbObject);
				if ($total_banner_sum <= 50) {
					$banners = db_getFromDB("banner", "account_id", sess_getAccountIdFromSession(), "", "caption", "array");
				} else {
					$overbanner_msg = system_showText(LANG_MSG_OVERITEM_MORETHAN)." ".$max_item_sum." ".system_showText(LANG_BANNER_FEATURE_NAME_PLURAL).". ".system_showText(LANG_MSG_OVERITEM_CONTACTADMIN).".";
				}
			}
		} else {
			if ($banner_id) {
				for ($i=0; $i < count($banner_id); $i++) {
					$bannerObj = new Banner($banner_id[$i]);
					if (!is_valid_discount_code($discountbanner_id[$i], "banner", $banner_id[$i], $payment_message, $error_num)) {
						$payment_message = substr($payment_message, 0 ,-1);
						$payment_message .= " ".system_showText(LANG_ON_BANNER)." \"<b>".$bannerObj->getString("caption")."</b>\"<br />";
					} elseif (is_array($discountbanner_id)){
						$bannerObj->setString("discount_id", $discountbanner_id[$i]);
						$bannerObj->Save();
						unset($bannerObj);
					}
					$by_key = array("id", "account_id");
					$by_value = array(db_formatNumber($banner_id[$i]), sess_getAccountIdFromSession());
					$banners[] = db_getFromDB("banner", $by_key, $by_value, "1", "caption", "array");
				}
			}
		}

		if ($banners) {

			$bannerLevelObj = new BannerLevel();

			foreach ($banners as $each_banner) {

				if($each_banner["expiration_setting"] == BANNER_EXPIRATION_IMPRESSION){

					$each_banner["renewal_date"] = false;

				} elseif ($each_banner["expiration_setting"] == BANNER_EXPIRATION_RENEWAL_DATE){

					if ($second_step) {
						$auxBannerObj = new Banner($each_banner["id"]);
						$each_banner["renewal_date"] = $auxBannerObj->getNextRenewalDate();
						unset($auxBannerObj);
					}

				}

				// setting some of the bill information
				$bill_info["banners"]["{$each_banner["id"]}"]["caption"]            = htmlspecialchars($each_banner["caption"]);
				$bill_info["banners"]["{$each_banner["id"]}"]["level"]              = $bannerLevelObj->getLevel($each_banner["type"]);
				$bill_info["banners"]["{$each_banner["id"]}"]["level_number"]       = $each_banner["type"];
				$bill_info["banners"]["{$each_banner["id"]}"]["expiration_setting"] = $each_banner["expiration_setting"];
				$bill_info["banners"]["{$each_banner["id"]}"]["renewal_date"]       = $each_banner["renewal_date"];
				$bill_info["banners"]["{$each_banner["id"]}"]["discount_id"]        = $each_banner["discount_id"];
				$bill_info["banners"]["{$each_banner["id"]}"]["unpaid_impressions"] = $each_banner["unpaid_impressions"];
				$bill_info["banners"]["{$each_banner["id"]}"]["status"]             = $each_banner["status"];

				// Need To Check Out
				$thisBanner = new Banner($each_banner["id"]);
				if ($thisBanner->needToCheckOut()) $bill_info["banners"]["{$each_banner["id"]}"]["needtocheckout"] = "y";
				else $bill_info["banners"]["{$each_banner["id"]}"]["needtocheckout"] = "n";
				unset($thisBanner);

				// Bill pricing
				$thisBanner = new Banner($each_banner["id"]);
				$bill_info["banners"]["{$each_banner["id"]}"]["total_fee"] = $thisBanner->getPrice();
				unset($thisBanner);

				if ($bill_info["banners"]["{$each_banner["id"]}"]["total_fee"] <= 0) {
					unset($bill_info["banners"]["{$each_banner["id"]}"]);
					continue;
				}

				// Setting total bill
				if($bill_info["banners"]["{$each_banner["id"]}"]["total_fee"])
					$bill_info["total_bill"] += $bill_info["banners"]["{$each_banner["id"]}"]["total_fee"];

				// Money format for banner fees
				if($bill_info["banners"]["{$each_banner["id"]}"]["total_fee"])
					$bill_info["banners"]["{$each_banner["id"]}"]["total_fee"] = format_money($bill_info["banners"]["{$each_banner["id"]}"]["total_fee"]);

			}

			// There is no banner been payed.
			if (empty($bill_info["banners"])) unset($bill_info["banners"]);

		}

		// Money format for total bill
		$bill_info["total_bill"] = format_money($bill_info["total_bill"]);
		////////////////////////////////////////////////////////////////////////

		// INVOICE /////////////////////////////////////////////////////////////
		if ($second_step) {

			if (($payment_method == "invoice") && ($bill_info["total_bill"] > 0)) {

				if (($bill_info["listings"]) || ($bill_info["events"]) || ($bill_info["banners"]) || ($bill_info["classifieds"]) || ($bill_info["articles"]) || ($bill_info["custominvoices"])) {

					$invoiceStatusObj = new InvoiceStatus();
					$accountObj       = new Account($acctId);

					$arr_invoice["account_id"]  = $acctId;
					$arr_invoice["username"]    = $accountObj->getString("username");
					$arr_invoice["ip"]          = $_SERVER["REMOTE_ADDR"];
					$arr_invoice["date"]        = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
					$arr_invoice["status"]      = $invoiceStatusObj->getDefault();
					$arr_invoice["amount"]      = str_replace(",","",$bill_info["total_bill"]);
					$arr_invoice["currency"]    = INVOICEPAYMENT_CURRENCY;
					$arr_invoice["expire_date"] = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));

					$invoiceObj = new Invoice($arr_invoice);
					$invoiceObj->Save();

					$bill_info["invoice_number"] = $invoiceObj->getString("id");

					$levelObj = new ListingLevel();
					if ($bill_info["listings"]) foreach ($bill_info["listings"] as $id => $info) {

						$listingObj = new Listing($id);

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
						$arr_invoice_listing["listing_id"]    = $id;
						$arr_invoice_listing["listing_title"] = $listingObj->getString("title", false);
						$arr_invoice_listing["discount_id"]   = $listingObj->getString("discount_id");
						$arr_invoice_listing["level"]         = $listingObj->getString("level");
						$arr_invoice_listing["renewal_date"]  = $listingObj->getString("renewal_date");
						$arr_invoice_listing["categories"]    = ($category_amount) ? $category_amount : 0;
						$arr_invoice_listing["amount"]        = str_replace(",","",$info["total_fee"]);

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

					}

					if ($bill_info["events"]) foreach ($bill_info["events"] as $id => $info) {

						$eventObj = new Event($id);

						$arr_invoice_event["invoice_id"]   = $invoiceObj->getString("id");
						$arr_invoice_event["event_id"]     = $id;
						$arr_invoice_event["event_title"]  = $eventObj->getString("title",false);
						$arr_invoice_event["discount_id"]  = $eventObj->getString("discount_id");
						$arr_invoice_event["level"]        = $eventObj->getString("level");
						$arr_invoice_event["renewal_date"] = $eventObj->getString("renewal_date");
						$arr_invoice_event["amount"]       = str_replace(",","",$info["total_fee"]);

						$invoiceEventObj = new InvoiceEvent($arr_invoice_event);
						$invoiceEventObj->Save();

						unset($eventObj);
						unset($invoiceEventObj);

					}

					if ($bill_info["banners"]) foreach ($bill_info["banners"] as $id => $info) {

						$bannerObj = new Banner($id);

						$arr_invoice_banner["invoice_id"]     = $invoiceObj->getString("id");
						$arr_invoice_banner["banner_id"]      = $id;
						$arr_invoice_banner["banner_caption"] = $bannerObj->getString("caption",false);
						$arr_invoice_banner["discount_id"]    = $bannerObj->getString("discount_id");
						$arr_invoice_banner["level"]          = $bannerObj->getString("type");
						$arr_invoice_banner["renewal_date"]   = $bannerObj->getString("renewal_date");
						$arr_invoice_banner["impressions"]    = $bannerObj->getString("unpaid_impressions");
						$arr_invoice_banner["amount"]         = str_replace(",","",$info["total_fee"]);

						$invoiceBannerObj = new InvoiceBanner($arr_invoice_banner);
						$invoiceBannerObj->Save();

						unset($bannerObj);
						unset($invoiceBannerObj);

					}

					
				}

			}

		}
	
	}

?>
