<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/code/billing_twocheckout.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# INCLUDE
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/conf/payment_twocheckout.inc.php");

	extract($_POST);
	extract($_GET);

	if($x_response_code){

		$transaction_twocheckout["response_code"]         = $x_response_code;
		$transaction_twocheckout["response_subcode"]      = $x_response_subcode;
		$transaction_twocheckout["response_reason_code"]  = $x_response_reason_code;
		$transaction_twocheckout["response_reason_text"]  = $x_response_reason_text;
		$transaction_twocheckout["x_2checked"]            = $x_2checked;
		$transaction_twocheckout["x_MD5_Hash"]            = $x_MD5_Hash;
		$transaction_twocheckout["x_trans_id"]            = $x_trans_id;
		$transaction_twocheckout["x_amount"]              = $x_amount;
		$transaction_twocheckout["x_invoice_num"]         = $x_invoice_num;
		$transaction_twocheckout["x_first_name"]          = $x_first_name;
		$transaction_twocheckout["x_last_name"]           = $x_last_name;
		$transaction_twocheckout["x_phone"]               = $x_phone;
		$transaction_twocheckout["x_email"]               = $x_email;
		$transaction_twocheckout["x_address"]             = $x_address;
		$transaction_twocheckout["x_city"]                = $x_city;
		$transaction_twocheckout["x_state"]               = $x_state;
		$transaction_twocheckout["x_zip"]                 = $x_zip;
		$transaction_twocheckout["x_country"]             = $x_country;
		$transaction_twocheckout["trans_time"]            = date("Y-m-d H:i:s");

		$transaction["account_id"]           = $acctId;
		$accountObj                          = new Account($transaction["account_id"]);
		$transaction["username"]             = $accountObj->getString("username");
		$transaction["ip"]                   = $_SERVER["REMOTE_ADDR"];
		$transaction["transaction_id"]       = $transaction_twocheckout["x_trans_id"];
		$transaction["transaction_datetime"] = $transaction_twocheckout["trans_time"];
		$transaction["transaction_amount"]   = $transaction_twocheckout["x_amount"];
		$transaction["transaction_currency"] = TWOCHECKOUT_CURRENCY;
		$transaction["system_type"]          = "2checkout";
		$transaction["recurring"]            = "n";
		$transaction["notes"]                = "";

		if ($transaction_twocheckout["response_code"] == "1")     $transaction["transaction_status"] = system_showText(LANG_LABEL_APPROVED);
		elseif ($transaction_twocheckout["response_code"] == "2") $transaction["transaction_status"] = system_showText(LANG_LABEL_DECLINED);
		elseif ($transaction_twocheckout["response_code"] == "3") $transaction["transaction_status"] = "Error";

		if ($transaction_twocheckout["response_code"]) {

			if (($transaction_twocheckout["response_code"] && $transaction_twocheckout["response_code"] == "2") || ($x_2checked != "Y")) { // transaction failed.
			
				$payment_message = "<p class=\"errorMessage\">\n";

				$payment_message .= system_showText(LANG_LABEL_STATUS).": ".system_showText(LANG_LABEL_DECLINED)."<br />\n";
				$payment_message .= $transaction_twocheckout["response_reason_text"]."<br />\n";
				if ($process == "signup") $try_again_message = "<a href=\"".DEFAULT_URL."/membros/".$process."/payment.php?payment_method=twocheckout\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";
				elseif ($process == "claim") $try_again_message = "<a href=\"".DEFAULT_URL."/membros/".$process."/payment.php?payment_method=twocheckout&claimlistingid=".$claimlistingid."\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";
				else $try_again_message = "<a href=\"".DEFAULT_URL."/membros/billing/index.php\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";

			} elseif ((!$transaction_twocheckout["response_code"] || $transaction_twocheckout["response_code"] == "3") || ($x_2checked != "Y")) { // transaction failed.
			
				$payment_message = "<p class=\"errorMessage\">\n";

				$payment_message .= system_showText(LANG_LABEL_STATUS).":".system_showText(LANG_LABEL_ERROR)."<br />\n";
				$payment_message .= $transaction_twocheckout["response_reason_text"]."<br />\n";
				if ($process == "signup") $try_again_message = "<a href=\"".DEFAULT_URL."/membros/".$process."/payment.php?payment_method=twocheckout\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";
				elseif ($process == "claim") $try_again_message = "<a href=\"".DEFAULT_URL."/membros/".$process."/payment.php?payment_method=twocheckout&claimlistingid=".$claimlistingid."\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";
				else $try_again_message = "<a href=\"".DEFAULT_URL."/membros/billing/index.php\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a>\n";

			} elseif (($transaction_twocheckout["response_code"] == "1") && ($x_2checked == "Y")) { // APPROVED

				$payment_success = "y";
				
				$payment_message = "<p class=\"successMessage\">\n";

				$payment_message .= system_showText(LANG_LABEL_STATUS).": ".system_showText(LANG_LABEL_APPROVED)."<br />\n";
				$payment_message .= system_showText(LANG_LABEL_TRANSACTION_CODE).": ".$transaction["transaction_id"]."<br />\n";
				$payment_message .= $transaction_twocheckout["response_reason_text"]."<br />\n";
				if ($process == "claim") $payment_message .= "<br />\n".system_showText(LANG_MSG_TRANSACTIONS_MAY_NOT_OCCUR_IMMEDIATELY)."<br />\n".system_showText(LANG_MSG_AFTER_PAYMENT_IS_PROCESSED_INFO_ABOUT)."<br />\n".system_showText(LANG_MSG_MAY_BE_FOUND_IN_TRANSACTION_HISTORY)."\n";
				else $payment_message .= "<br />\n".system_showText(LANG_MSG_TRANSACTIONS_MAY_NOT_OCCUR_IMMEDIATELY)."<br />\n".system_showText(LANG_MSG_AFTER_PAYMENT_IS_PROCESSED_INFO_ABOUT)."<br />\n".system_showText(LANG_MSG_MAY_BE_FOUND_IN_YOUR)." <a href=\"".DEFAULT_URL."/membros/transactions/index.php\">".system_showText(LANG_LABEL_TRANSACTION_HISTORY).".</a>\n";

				$transaction["return_fields"] = system_array2nvp($transaction_twocheckout, " || ");
				$paymentLogObj = new PaymentLog($transaction);
				$paymentLogObj->Save();

				$listing_ids = split("::",$x_listing_ids);
				$listing_amounts = split("::",$x_listing_amounts);
				$event_ids = split("::",$x_event_ids);
				$event_amounts = split("::",$x_event_amounts);
				$banner_ids = split("::",$x_banner_ids);
				$banner_amounts = split("::",$x_banner_amounts);
				$classified_ids = split("::",$x_classified_ids);
				$classified_amounts = split("::",$x_classified_amounts);
				$article_ids = split("::",$x_article_ids);
				$article_amounts = split("::",$x_article_amounts);
				$custominvoice_ids = split("::",$x_custominvoice_ids);
				$custominvoice_amounts = split("::",$x_custominvoice_amounts);

				if (!empty($listing_ids[0])) {

					$listingStatus = new ItemStatus();

					$amountAux = 0;
					$levelObj = new ListingLevel();
					foreach($listing_ids as $each_listing_id){

						$listingObj = new Listing($each_listing_id);
						$listingObj->setString("renewal_date", $listingObj->getNextRenewalDate());
						$listingObj->setString("status", $listingStatus->getDefaultStatus());
						$listingObj->Save();

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

						$transaction_listing_log["payment_log_id"] = $paymentLogObj->getNumber("id");
						$transaction_listing_log["listing_id"]     = $each_listing_id;
						$transaction_listing_log["listing_title"]  = $listingObj->getString("title", false);
						$transaction_listing_log["level"]          = $listingObj->getString("level");
						$transaction_listing_log["renewal_date"]   = $listingObj->getString("renewal_date");
						$transaction_listing_log["discount_id"]    = $listingObj->getString("discount_id");
						$transaction_listing_log["categories"]     = ($category_amount) ? $category_amount : 0;
						$transaction_listing_log["amount"]         = str_replace(",","",$listing_amounts[$amountAux]);
						$amountAux++;

						$transaction_listing_log["extra_categories"] = 0;
						if (($category_amount > 0) && (($category_amount - $levelObj->getFreeCategory($listingObj->getString("level"))) > 0)) {
							$transaction_listing_log["extra_categories"] = $category_amount - $levelObj->getFreeCategory($listingObj->getString("level"));
						} else {
							$transaction_listing_log["extra_categories"] = 0;
						}

						$transaction_listing_log["listingtemplate_title"] = "";
						if (LISTINGTEMPLATE_FEATURE == "on") {
							if ($listingObj->getString("listingtemplate_id")) {
								$listingTemplateObj = new ListingTemplate($listingObj->getString("listingtemplate_id"));
								$transaction_listing_log["listingtemplate_title"] = $listingTemplateObj->getString("title", false);
							}
						}

						$paymentListingLogObj = new PaymentListingLog($transaction_listing_log);
						$paymentListingLogObj->Save();

					}

					unset($listingObj);

				}

				if (!empty($event_ids[0])) {

					$eventStatus = new ItemStatus();

					$amountAux = 0;
					foreach($event_ids as $each_event_id){

						$eventObj = new Event($each_event_id);
						$eventObj->setString("renewal_date", $eventObj->getNextRenewalDate());
						$eventObj->setString("status", $eventStatus->getDefaultStatus());
						$eventObj->Save();

						$transaction_event_log["payment_log_id"] = $paymentLogObj->getNumber("id");
						$transaction_event_log["event_id"]       = $each_event_id;
						$transaction_event_log["event_title"]    = $eventObj->getString("title",false);
						$transaction_event_log["level"]          = $eventObj->getString("level");
						$transaction_event_log["renewal_date"]   = $eventObj->getString("renewal_date");
						$transaction_event_log["discount_id"]    = $eventObj->getString("discount_id");
						$transaction_event_log["amount"]         = str_replace(",","",$event_amounts[$amountAux]);
						$amountAux++;

						$paymentEventLogObj = new PaymentEventLog($transaction_event_log);
						$paymentEventLogObj->Save();

					}

					unset($eventObj);

				}

				if (!empty($banner_ids[0])) {

					$bannerStatus = new ItemStatus();

					$amountAux = 0;
					foreach($banner_ids as $each_banner_id){

						$bannerObj = new Banner($each_banner_id);

						if($bannerObj->getString("expiration_setting") == BANNER_EXPIRATION_IMPRESSION){

							$sql = "UPDATE Banner set impressions = impressions + ".$bannerObj->getNumber("unpaid_impressions").", renewal_date = '0000-00-00', unpaid_impressions = 0 WHERE id = ".$bannerObj->getNumber("id");
							$dbObj = db_getDBObject();
							$result = $dbObj->query($sql);

							$id = $bannerObj->getNumber("id");
							$unpaid_impressions[$id] = $bannerObj->getNumber("unpaid_impressions");

						} elseif ($bannerObj->getString("expiration_setting") == BANNER_EXPIRATION_RENEWAL_DATE){

							$bannerObj->setString("renewal_date", $bannerObj->getNextRenewalDate());
							$bannerObj->setString("status", $bannerStatus->getDefaultStatus());
							$bannerObj->Save();

						}

						$transaction_banner_log["payment_log_id"] = $paymentLogObj->getNumber("id");
						$transaction_banner_log["banner_id"]      = $each_banner_id;
						$transaction_banner_log["banner_caption"] = $bannerObj->getString("caption",false);
						$transaction_banner_log["level"]          = $bannerObj->getString("type");
						$transaction_banner_log["renewal_date"]   = $bannerObj->getString("renewal_date");
						$transaction_banner_log["discount_id"]    = $bannerObj->getString("discount_id");
						$transaction_banner_log["impressions"]    = ($unpaid_impressions[$each_banner_id]) ? $unpaid_impressions[$each_banner_id] : 0;
						$transaction_banner_log["amount"]         = str_replace(",","",$banner_amounts[$amountAux]);
						$amountAux++;

						$paymentBannerLogObj = new PaymentBannerLog($transaction_banner_log);
						$paymentBannerLogObj->Save();

					}

					unset($bannerObj);

				}

				if (!empty($classified_ids[0])) {

					$classifiedStatus = new ItemStatus();

					$amountAux = 0;
					foreach($classified_ids as $each_classified_id){

						$classifiedObj = new Classified($each_classified_id);
						$classifiedObj->setString("renewal_date", $classifiedObj->getNextRenewalDate());
						$classifiedObj->setString("status", $classifiedStatus->getDefaultStatus());
						$classifiedObj->save();

						$transaction_classified_log["payment_log_id"]   = $paymentLogObj->getNumber("id");
						$transaction_classified_log["classified_id"]    = $each_classified_id;
						$transaction_classified_log["classified_title"] = $classifiedObj->getString("title",false);
						$transaction_classified_log["level"]            = $classifiedObj->getString("level");
						$transaction_classified_log["renewal_date"]     = $classifiedObj->getString("renewal_date");
						$transaction_classified_log["discount_id"]      = $classifiedObj->getString("discount_id");
						$transaction_classified_log["amount"]           = str_replace(",","",$classified_amounts[$amountAux]);
						$amountAux++;

						$paymentClassifiedLogObj = new PaymentClassifiedLog($transaction_classified_log);
						$paymentClassifiedLogObj->Save();

					}

					unset($classifiedObj);

				}

				if (!empty($article_ids[0])) {

					$articleStatus = new ItemStatus();

					$amountAux = 0;
					foreach($article_ids as $each_article_id){

						$articleObj = new Article($each_article_id);
						$articleObj->setString("renewal_date", $articleObj->getNextRenewalDate());
						$articleObj->setString("status", $articleStatus->getDefaultStatus());
						$articleObj->Save();

						$transaction_article_log["payment_log_id"] = $paymentLogObj->getNumber("id");
						$transaction_article_log["article_id"]     = $each_article_id;
						$transaction_article_log["article_title"]  = $articleObj->getString("title",false);
						$transaction_article_log["level"]          = $articleObj->getString("level");
						$transaction_article_log["renewal_date"]   = $articleObj->getString("renewal_date");
						$transaction_article_log["discount_id"]    = $articleObj->getString("discount_id");
						$transaction_article_log["amount"]         = str_replace(",","",$article_amounts[$amountAux]);
						$amountAux++;

						$paymentArticleLogObj = new PaymentArticleLog($transaction_article_log);
						$paymentArticleLogObj->Save();

					}

					unset($articleObj);

				}

				if (!empty($custominvoice_ids[0])) {

					$amountAux = 0;
					foreach($custominvoice_ids as $each_custominvoice_id){

						$customInvoiceObj = new CustomInvoice($each_custominvoice_id);
						$customInvoiceObj->setString("paid", "y");
						$customInvoiceObj->Save();

						$transaction_custominvoice_log["payment_log_id"]    = $paymentLogObj->getNumber("id");
						$transaction_custominvoice_log["custom_invoice_id"] = $each_custominvoice_id;
						$transaction_custominvoice_log["title"]             = $customInvoiceObj->getString("title");
						$transaction_custominvoice_log["date"]              = $customInvoiceObj->getString("date");
						$transaction_custominvoice_log["items"]             = $customInvoiceObj->getTextItems();
						$transaction_custominvoice_log["items_price"]       = $customInvoiceObj->getTextPrices();
						$transaction_custominvoice_log["amount"]            = str_replace(",","",$custominvoice_amounts[$amountAux]);
						$amountAux++;

						$paymentCustomInvoiceLogObj = new PaymentCustomInvoiceLog($transaction_custominvoice_log);
						$paymentCustomInvoiceLogObj->Save();

					}

					unset($customInvoiceObj);

				}

				$paymentLogObj->sendNotification();

			}

			$payment_message .= $try_again_message."</p>";

		} else {
			$payment_message .= "<p class=\"errorMessage\">\n";
			$payment_message .= system_showText(LANG_LABEL_STATUS).":".system_showText(LANG_LABEL_ERROR)."<br />\n";
			$payment_message .= system_showText(LANG_MSG_PAYMENT_GATEWAY_COULD_NOT_RESPOND)."<br />\n";
			$payment_message .= "<a href=\"".DEFAULT_URL."/membros/billing/index.php\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a></p>\n";
		}

	} else {
		$payment_message .= "<p class=\"errorMessage\">\n";
		$payment_message .= system_showText(LANG_LABEL_STATUS).":".system_showText(LANG_LABEL_ERROR)."<br />\n";
		$payment_message .= "The payment gateway is not available currently<br />\n";
		$payment_message .= "<a href=\"".DEFAULT_URL."/membros/billing/index.php\">".system_showText(LANG_MSG_CLICK_HERE_TO_TRY_AGAIN)."</a></p>\n";
	}

?>