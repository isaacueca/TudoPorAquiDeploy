<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /order_banner.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# LOAD CONFIG
	# ----------------------------------------------------------------------------------------------------
	include("./conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	session_start();

	# ----------------------------------------------------------------------------------------------------
	# VALIDATION
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/includes/code/validate_frontrequest.php");

	# ----------------------------------------------------------------------------------------------------
	# VALIDATE FEATURE
	# ----------------------------------------------------------------------------------------------------
	if (BANNER_FEATURE != "on") { exit; }
	$banLevelObj = new BannerLevel();
	$banLevelValue = $banLevelObj->getValues();
	if (!in_array($type, $banLevelValue)) {
		header("Location: ".DEFAULT_URL."/advertise.php?banner");
		exit;
	}

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if (($_SERVER['REQUEST_METHOD'] == "POST")) {

		$request_method_seckey = "post";
		include(EDIRECTORY_ROOT."/includes/code/seckey.php");

		$validate_account = validate_addAccount($_POST, $message_account);
		$validate_contact = validate_form("contact", $_POST, $message_contact);
		$validate_banner = validate_form("banner", $_POST, $message_banner);
		$validate_discount = is_valid_discount_code($_POST["discount_id"], "banner", $_POST["id"], $message_discount, $discount_error_num);

		if ($boolean_seckey && $validate_account && $validate_contact && $validate_banner && $validate_discount) {

			$account = new Account($_POST);
			$account->save();

			$contact = new Contact($_POST);
			$contact->setNumber("account_id", $account->getNumber("id"));
			$contact->save();

			$banner = new Banner($_POST);
			$banner->setNumber("account_id", $account->getNumber("id"));
			if (!$banner->hasImpressions()) {
				$banner->setNumber("unpaid_impressions", 0);
				$banner->setString("unlimited_impressions", "y");
			} else {
				$banner->setString("unlimited_impressions", "n");
			}
			$banner->Save();

			/**************************************************************************************************/
			/*                                                                                                */
			/* E-mail notify                                                                                  */
			/*                                                                                                */
			/**************************************************************************************************/
			setting_get("sitemgr_send_email",$sitemgr_send_email);
			setting_get("sitemgr_email",$sitemgr_email);
			$sitemgr_emails = split(",",$sitemgr_email);
			if ($sitemgr_emails[0]) $sitemgr_email = $sitemgr_emails[0];
			setting_get("sitemgr_account_email",$sitemgr_account_email);
			$sitemgr_account_emails = split(",",$sitemgr_account_email);
			setting_get("sitemgr_banner_email",$sitemgr_banner_email);
			$sitemgr_banner_emails = split(",",$sitemgr_banner_email);

			// sending e-mail to user //////////////////////////////////////////////////////////////////////////
			if ($emailNotificationObj = system_checkEmail(SYSTEM_BANNER_SIGNUP, $contact->getString("lang"))) {
				$subject = $emailNotificationObj->getString("subject");
				$body = $emailNotificationObj->getString("body");
				$body = str_replace("ACCOUNT_USERNAME",$_POST["username"],$body);
				$body = str_replace("ACCOUNT_PASSWORD",$_POST["password"],$body);
				$body = system_replaceEmailVariables($body, $banner->getNumber('id'), 'banner');
				$subject = system_replaceEmailVariables($subject, $banner->getNumber('id'), 'banner');
				$body = html_entity_decode($body);
				$subject = html_entity_decode($subject);
				//system_mail($contact->getString("email"), $subject, $body, EDIRECTORY_TITLE." <$sitemgr_email>", $emailNotificationObj->getString("content_type"), "", $emailNotificationObj->getString("bcc"), $error);
			}
			////////////////////////////////////////////////////////////////////////////////////////////////////

			// site manager warning message ////////////////////////////////////////////////////////////////////
			$sitemgr_msg = "
				<html>
					<head>
						<style>
							.email_style_settings{
								font-size:12px;
								font-family:Verdana, Arial, Sans-Serif;
								color:#000;
							}
						</style>
					</head>
					<body>
						<div class=\"email_style_settings\">

							Site Manager,<br /><br />
							New signup in ".EDIRECTORY_TITLE.".<br /><br />
							Account:<br /><br />";
							$sitemgr_msg .= "<b>Username: </b>".$account->getString("username")."<br />";
							$sitemgr_msg .= "<b>First name: </b>".$contact->getString("first_name")."<br />";
							$sitemgr_msg .= "<b>Last name: </b>".$contact->getString("last_name")."<br />";
							$sitemgr_msg .= "<b>Company: </b>".$contact->getString("company")."<br />";
							$sitemgr_msg .= "<b>Address: </b>".$contact->getString("address")." ".$contact->getString("address2")."<br />";
							$sitemgr_msg .= "<b>City: </b>".$contact->getString("city")."<br />";
							$sitemgr_msg .= "<b>State: </b>".$contact->getString("state")."<br />";
							$sitemgr_msg .= "<b>".ucwords(ZIPCODE_LABEL).": </b>".$contact->getString("zip")."<br />";
							$sitemgr_msg .= "<b>Country: </b>".$contact->getString("country")."<br />";
							$sitemgr_msg .= "<b>Phone: </b>".$contact->getString("phone")."<br />";
							$sitemgr_msg .= "<b>E-mail: </b>".$contact->getString("email")."<br />";
							$sitemgr_msg .= "<br /><a href=\"".DEFAULT_URL."/gerenciamento/account/view.php?id=".$account->getNumber("id")."\" target=\"_blank\">".DEFAULT_URL."/gerenciamento/account/view.php?id=".$account->getNumber("id")."</a><br /><br />";
							$sitemgr_msg .= ucwords(BANNER_FEATURE_NAME).":<br /><br />";
							$sitemgr_msg .= "<b>Caption: </b>".$banner->getString("caption")."<br />";
							$sitemgr_msg .= "<br /><a href=\"".DEFAULT_URL."/gerenciamento/banner/view.php?id=".$banner->getNumber("id")."\" target=\"_blank\">".DEFAULT_URL."/gerenciamento/banner/view.php?id=".$banner->getNumber("id")."</a><br /><br />
						</div>
					</body>
				</html>";
			if ($sitemgr_send_email == "on") {
				if ($sitemgr_emails[0]) {
					foreach ($sitemgr_emails as $sitemgr_email) {
						//system_mail($sitemgr_email, "[".EDIRECTORY_TITLE."] Signup Notification", $sitemgr_msg, EDIRECTORY_TITLE." <$sitemgr_email>", "text/html", '', '', $error);
					}
				}
			}
			if ($sitemgr_account_emails[0]) {
				foreach ($sitemgr_account_emails as $sitemgr_account_email) {
					//system_mail($sitemgr_account_email, "[".EDIRECTORY_TITLE."] Signup Notification", $sitemgr_msg, EDIRECTORY_TITLE." <$sitemgr_account_email>", "text/html", '', '', $error);
				}
			}
			if ($sitemgr_banner_emails[0]) {
				foreach ($sitemgr_banner_emails as $sitemgr_banner_email) {
					//system_mail($sitemgr_banner_email, "[".EDIRECTORY_TITLE."] Signup Notification", $sitemgr_msg, EDIRECTORY_TITLE." <$sitemgr_banner_email>", "text/html", '', '', $error);
				}
			}
			////////////////////////////////////////////////////////////////////////////////////////////////////

			if ($checkout) $payment_method = "checkout";

			sess_registerAccountInSession($account->getString("username"));
			setcookie("username", $account->getString("username"), time()+60*60*24*30, "".EDIRECTORY_FOLDER."/membros");

			if ($payment_method == "checkout") {
				header("Location: ".DEFAULT_URL."/membros/banner/edit.php?id=".$banner->getNumber("id")."&process=signup");
			} elseif ($payment_method == "invoice") {
				header("Location: ".DEFAULT_URL."/membros/signup/invoice.php");
			} else {
				header("Location: ".DEFAULT_URL."/membros/signup/payment.php?payment_method=".$payment_method);
			}
			exit;

		} else {
			// removing slashes added if required
			$_POST = format_magicQuotes($_POST);
			$_GET  = format_magicQuotes($_GET);
			extract($_POST);
			extract($_GET);
		}

	}

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------

	if (!$expiration_setting) $expiration_setting = BANNER_EXPIRATION_RENEWAL_DATE;

	$bannerLevelObj = new BannerLevel();
	$levelValue = $bannerLevelObj->getValues();

	$formloginaction = ((SSL_ENABLED == "on" && FORCE_MEMBERS_SSL == "on") ? SECURE_URL : NON_SECURE_URL)."/membros/login.php?destiny=".EDIRECTORY_FOLDER."/membros/banner/add.php";

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	$extrastyle = DEFAULT_URL."/layout/general_order.css";
	include(EDIRECTORY_ROOT."/layout/header.php");

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	require(EDIRECTORY_ROOT."/frontend/checkregbin.php");

?>

	<script language="javascript" type="text/javascript">
		<!--

		function orderCalculate() {
			var xmlhttp;
			try {
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {
						xmlhttp = false;
					}
				}
			}
			if (document.getElementById("check_out_payment")) document.getElementById("check_out_payment").className = "isHidden";
			if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isHidden";
			if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").style.display = "";
			if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").innerHTML = "<?=system_showText(LANG_WAITLOADING)?>";
			if (xmlhttp) {
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4) {
						if (xmlhttp.status == 200) {
							var price = xmlhttp.responseText;
							<? if ((PAYMENT_FEATURE == "on") && ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on"))) { ?>
								if (price > 0) {
									if (document.getElementById("check_out_payment")) document.getElementById("check_out_payment").className = "isVisible";
									if (document.getElementById("checkoutpayment_total")) document.getElementById("checkoutpayment_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+price.substring(0, price.length-2)+"."+price.substring(price.length-2, price.length);
								} else {
									if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isVisible";
									if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?><?=system_showText(LANG_FREE)?>";
								}
							<? } else { ?>
								if (document.getElementById("check_out_free")) document.getElementById("check_out_free").className = "isVisible";
								if (price > 0) {
									if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?>"+price.substring(0, price.length-2)+"."+price.substring(price.length-2, price.length);
								} else {
									if (document.getElementById("checkoutfree_total")) document.getElementById("checkoutfree_total").innerHTML = "<strong><?=system_showText(LANG_TOTALPRICEAMOUNT)?>: </strong><?=CURRENCY_SYMBOL?><?=system_showText(LANG_FREE)?>";
								}
							<? } ?>
							if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").style.display = "none";
							if (document.getElementById("loadingOrderCalculate")) document.getElementById("loadingOrderCalculate").innerHTML = "";
						}
					}
				}
				var get_type = 0;
				if (document.order_banner.type) get_type = document.order_banner.type.value;
				var get_expiration_setting = 0;
				if (document.order_banner.expiration_setting) get_expiration_setting = document.order_banner.expiration_setting.value;
				var get_unpaid_impressions = 0;
				if (document.order_banner.unpaid_impressions) get_unpaid_impressions = document.order_banner.unpaid_impressions.value;
				var get_discount_id = "";
				if (document.order_banner.discount_id) get_discount_id = document.order_banner.discount_id.value;
				xmlhttp.open("GET", "<?=DEFAULT_URL;?>/ordercalculateprice.php?item=banner&type="+get_type+"&expiration_setting="+get_expiration_setting+"&unpaid_impressions="+get_unpaid_impressions+"&discount_id="+get_discount_id, true);
				xmlhttp.send(null);
			}
		}

		function switchFormUserDisplay(user) {
			if (user == "newuser") {
				document.getElementById("formFacebookUser").className = "isHidden";
				document.getElementById("formOpenIDUser").className = "isHidden";
				document.getElementById("formDirectoryUser").className = "isHidden";
				document.getElementById("formNewUser").className = "isVisible";
			}
			if (user == "directoryuser") {
				document.getElementById("formFacebookUser").className = "isHidden";
				document.getElementById("formOpenIDUser").className = "isHidden";
				document.getElementById("formDirectoryUser").className = "isVisible";
				document.getElementById("formNewUser").className = "isHidden";
			}
			if (user == "openiduser") {
				document.getElementById("formFacebookUser").className = "isHidden";
				document.getElementById("formOpenIDUser").className = "isVisible";
				document.getElementById("formDirectoryUser").className = "isHidden";
				document.getElementById("formNewUser").className = "isHidden";
			}
			if (user == "facebookuser") {
				document.getElementById("formFacebookUser").className = "isVisible";
				document.getElementById("formOpenIDUser").className = "isHidden";
				document.getElementById("formDirectoryUser").className = "isHidden";
				document.getElementById("formNewUser").className = "isHidden";
			}
		}

		function typeSwitch(type, expiration_setting) {
			<?
			foreach ($levelValue as $value) {
				echo "var impressions_".$value."_".BANNER_EXPIRATION_RENEWAL_DATE." = 0;";
				echo "var impressions_".$value."_".BANNER_EXPIRATION_IMPRESSION." = ".$bannerLevelObj->getImpressionBlock($value).";";
			}
			?>
			document.order_banner.type.value = type;
			document.order_banner.expiration_setting.value = expiration_setting;
			document.order_banner.unpaid_impressions.value = eval("impressions_" + type + "_" + expiration_setting);
			orderCalculate();
			document.formDirectory.action = "<?=$formloginaction?>&query=type=" + type + "&expiration_setting=" + expiration_setting;
			document.formOpenID.action = "<?=$formloginaction?>&query=type=" + type + "&expiration_setting=" + expiration_setting;
		}

		//-->
	</script>

	<?
	$checkoutpayment_class = "isHidden";
	$checkoutfree_class = "isHidden";
	?>

	<ul class="standardStep">
		<li class="standardStepAD"><?=system_showText(LANG_EASYANDFAST)?> <span><?=system_showText(LANG_THREESTEPS)?> &raquo;</span></li>
		<li class="stepActived"><span>1</span>&nbsp;<?=system_showText(LANG_ORDER)?></li>
		<li><span>2</span>&nbsp;<?=system_showText(LANG_CHECKOUT)?></li>
		<li><span>3</span>&nbsp;<?=system_showText(LANG_CONFIGURATION)?></li>
	</ul>

	<table border="0" cellpadding="0" cellspacing="0" class="orderTable">
		<tr>
			<th><h2 class="standardSubTitle"><?=system_showText(LANG_SELECTPACKAGE)?></h2></th>
			<td><h2 class="standardSubTitle"><?=system_showText(LANG_ALREADYHAVEACCOUNT)?></h2></td>
		</tr>
		<tr>
			<td>

				<table align="center" cellspacing="2" cellpadding="2" border="0" class="standardChooseLevel">
					<? foreach ($levelValue as $value) { ?> 
						<tr>
							<th class="chooseLevel"><?=$bannerLevelObj->showLevel($value)?></th>
							<th class="radioChooseLevel"><input type="radio" name="type_expiration_setting" value="<?=$value?>_<?=BANNER_EXPIRATION_RENEWAL_DATE?>" <? if (($value == $type) && (BANNER_EXPIRATION_RENEWAL_DATE == $expiration_setting)) { echo "checked=\"checked\""; } ?> onclick="typeSwitch('<?=$value?>', '<?=BANNER_EXPIRATION_RENEWAL_DATE?>');" /></th>
							<td>
								<?
									if ($bannerLevelObj->getPrice($value) > 0) echo CURRENCY_SYMBOL.$bannerLevelObj->getPrice($value);
									else echo CURRENCY_SYMBOL.system_showText(LANG_FREE);
									echo " ".system_showText(LANG_PER)." ";
									if (payment_getRenewalCycle("banner") > 1) {
										echo payment_getRenewalCycle("banner")." ";
										echo payment_getRenewalUnitName("banner")."s";
									}else {
										echo payment_getRenewalUnitName("banner");
									}
								?>
							</td>
							<th class="radioChooseLevel"><input type="radio" name="type_expiration_setting" value="<?=$value?>_<?=BANNER_EXPIRATION_IMPRESSION?>" <? if (($value == $type) && (BANNER_EXPIRATION_IMPRESSION == $expiration_setting)) { echo "checked=\"checked\""; } ?> onclick="typeSwitch('<?=$value?>', '<?=BANNER_EXPIRATION_IMPRESSION?>');" /></th>
							<td>
								<?
								if ($bannerLevelObj->getImpressionPrice($value) > 0) echo CURRENCY_SYMBOL.$bannerLevelObj->getImpressionPrice($value);
								else echo CURRENCY_SYMBOL.system_showText(LANG_FREE);
								echo " ".system_showText(LANG_PER)." ".$bannerLevelObj->getImpressionBlock($value)." ".system_showText(LANG_IMPRESSIONS);
								?>
							</td>
						</tr>
					<? } ?>
				</table>

			</td>
			<td class="orderUserTable">

				<table align="center" border="0" cellpadding="0" cellspacing="0">

					<tr>
						<th class="radioChooseLevel"><input type="radio" name="usertype" value="newuser" checked="checked" onclick="javascript:switchFormUserDisplay('newuser');" /></th>
						<td class="warning"><?=system_showText(LANG_ACCOUNTNEWUSER)?></td>
					</tr>

					<tr>
						<th class="radioChooseLevel"><input type="radio" name="usertype" value="directoryuser" <? if ($usertype == "directoryuser") echo "checked=\"checked\""; ?> onclick="javascript:switchFormUserDisplay('directoryuser');" /></th>
						<td><?=system_showText(LANG_ACCOUNTDIRECTORYUSER)?></td>
					</tr>

					<?
					setting_get("foreignaccount_openid", $foreignaccount_openid);
					if ($foreignaccount_openid == "on") {
						?>
						<tr>
							<th class="radioChooseLevel"><input type="radio" name="usertype" value="openiduser" <? if ($usertype == "openiduser") echo "checked=\"checked\""; ?> onclick="javascript:switchFormUserDisplay('openiduser');" /></th>
							<td><?=system_showText(LANG_ACCOUNTOPENIDUSER)?></td>
						</tr>
						<?
					}
					?>

					<?
					setting_get("foreignaccount_facebook", $foreignaccount_facebook);
					setting_get("foreignaccount_facebook_apikey", $foreignaccount_facebook_apikey);
					if (($foreignaccount_facebook == "on") && ($foreignaccount_facebook_apikey)) {
						?>
						<tr>
							<th class="radioChooseLevel"><input type="radio" name="usertype" value="facebookuser" <? if ($usertype == "facebookuser") echo "checked=\"checked\""; ?> onclick="javascript:switchFormUserDisplay('facebookuser');" /></th>
							<td><?=system_showText(LANG_ACCOUNTFACEBOOKUSER)?></td>
						</tr>
						<?
					}
					?>

					<tr>
						<td colspan="2">

							<div id="formDirectoryUser" class="<? if ($usertype == "directoryuser") echo "isVisible"; else echo "isHidden"; ?>">

								<form name="formDirectory" method="post" action="<?=$formloginaction;?>&query=type=<?=($_POST["type"]?$_POST["type"]:$_GET["type"])?>&expiration_setting=<?=($_POST["expiration_setting"]?$_POST["expiration_setting"]:$_GET["expiration_setting"])?>">

									<input type="hidden" name="userform" value="directory" />

									<?
									$membros_section = true;
									$automatically = false;
									include(INCLUDES_DIR."/forms/form_login.php");
									?>

								</form>

							</div>

						</td>
					</tr>

					<tr>
						<td colspan="2">

							<div id="formOpenIDUser" class="<? if ($usertype == "openiduser") echo "isVisible"; else echo "isHidden"; ?>">

								<form name="formOpenID" method="post" action="<?=$formloginaction;?>&query=type=<?=($_POST["type"]?$_POST["type"]:$_GET["type"])?>&expiration_setting=<?=($_POST["expiration_setting"]?$_POST["expiration_setting"]:$_GET["expiration_setting"])?>">

									<input type="hidden" name="userform" value="openid" />

									<? include(INCLUDES_DIR."/forms/form_openidlogin.php"); ?>

								</form>

							</div>

						</td>
					</tr>

					<tr>
						<td colspan="2">

							<div id="formFacebookUser" class="<? if ($usertype == "facebookuser") echo "isVisible"; else echo "isHidden"; ?>">

								<? include(INCLUDES_DIR."/forms/form_facebooklogin.php"); ?>

							</div>

						</td>
					</tr>

				</table>

			</td>
		</tr>
	</table>

	<div id="formNewUser" class="<? if ((!$usertype) || ($usertype == "newuser")) echo "isVisible"; else echo "isHidden"; ?>">

		<? if ($message_account || $message_banner || $message_discount || $message_contact) { ?>
			<table align="center" border="0" cellpadding="2" cellspacing="2" class="standardMessage">
				<? if ($message_account) { ?>
					<tr>
						<th colspan="2" class="SIGNUPTable-title errorTitle"><?=system_showText(LANG_ACCOUNTINFO)?></th>
					</tr>
					<tr>
						<td colspan="2" class="errorMessage"><?=$message_account?></td>
					</tr>
				<? } ?>
				<? if ($message_banner || $message_discount) { ?>
					<tr>
						<th colspan="2" class="SIGNUPTable-title errorTitle"><?=system_showText(LANG_BANNERINFO_ERROR)?></th>
					</tr>
					<? if ($message_banner) { ?>
						<tr>
							<td colspan="2" class="errorMessage"><?=$message_banner?></td>
						</tr>
					<? } ?>
					<? if ($message_discount) { ?>
						<tr>
							<td colspan="2" class="errorMessage"><?=$message_discount?></td>
						</tr>
					<? } ?>
				<? } ?>
				<? if ($message_contact) { ?>
					<tr>
						<th colspan="2" class="SIGNUPTable-title errorTitle"><?=system_showText(LANG_BILLINGINFO_ERROR)?></th>
					</tr>
					<tr>
						<td colspan="2" class="errorMessage"><?=$message_contact?></td>
					</tr>
				<? } ?>
			</table>
		<? } ?>

		<form name="order_banner" action="<?=$_SERVER["PHP_SELF"]?>" method="post" class="standardForm">

			<input type="hidden" name="ieBugFix" value="1" />

			<input type="hidden" name="signup" value="true" />
			<input type="hidden" name="type" id="type" value="<?=$type?>" />
			<input type="hidden" name="expiration_setting" id="expiration_setting" value="<?=$expiration_setting?>" />
			<input type="hidden" name="unpaid_impressions" id="unpaid_impressions" value="<?=$unpaid_impressions?>" />

			<script language="javascript" type="text/javascript" src="<?=DEFAULT_URL?>/scripts/checkpasswordstrength.js"></script>

			<table align="center" border="0" cellpadding="2" cellspacing="2" class="standardSIGNUPTable">
				<tr>
					<th colspan="2" class="SIGNUPTable-title"><h2 class="standardSubTitle"><?=system_showText(LANG_ACCOUNTINFO)?> <span><?=system_showText(LANG_ACCOUNTINFOMSG)?></span></h2></th>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_USERNAME)?>:</th>
					<td>
						<input type="text" name="username" value="<?=$username?>" maxlength="<?=USERNAME_MAX_LEN?>" class="input-form-account" />
						<span><?=system_showText(LANG_USERNAME_MSG1)." ".USERNAME_MIN_LEN." ".system_showText(LANG_USERNAME_MSG2)." ".USERNAME_MAX_LEN." ".system_showText(LANG_USERNAME_MSG3)?></span>
					</td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_PASSWORD)?>:</th>
					<td>
						<input type="password" autocomplete="off" name="password" maxlength="<?=PASSWORD_MAX_LEN?>" class="input-form-account" onkeyup="checkPasswordStrength(this.value, '<?=EDIRECTORY_FOLDER;?>')" />
						<div class="checkPasswordStrength">
							<span><?=system_showText(LANG_LABEL_PASSWORDSTRENGTH);?>:</span>
							<div id="checkPasswordStrength" class="strengthNoPassword">&nbsp;</div>
						</div>
						<span><?=system_showText(LANG_PASSWORD_MSG1)." ".PASSWORD_MIN_LEN." ".system_showText(LANG_PASSWORD_MSG2)." ".PASSWORD_MAX_LEN." ".system_showText(LANG_PASSWORD_MSG3)?></span>
					</td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_RETYPEPASSWORD)?>:</th>
					<td><input type="password" autocomplete="off" name="retype_password" class="input-form-account" /></td>
				</tr>
				<tr>
					<th><input type="checkbox" name="agree_tou" value="1" <?=($agree_tou) ? "checked=\"checked\"" : ""?> class="inputRadio" /></th>
					<td><a href="javascript: void(0);" onclick="window.open('<?=DEFAULT_URL?>/terms.php', 'popup', 'toolbar=0, location=0, directories=0, status=0, width=650, height=500, screenX=0, screenY=0, menubar=0, no-resizable, scrollbars=yes')"><?=system_showText(LANG_IGREETERMS)?></a></td>
				</tr>
				<tr>
					<th colspan="2" class="SIGNUPTable-title"><h2 class="standardSubTitle"><?=system_showText(LANG_BANNERINFO)?></h2></th>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_CAPTION)?>:</th>
					<td><input type="text" name="caption" value="<?=$caption?>" maxlength="25" class="input-form-banner" /></td>
				</tr>
				<? if (PAYMENT_FEATURE == "on") { ?>
					<? if ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on")) { ?>
						<tr>
							<th><?=ucwords(system_showText(LANG_LABEL_DISCOUNTCODE))?>:</th>
							<td><input type="text" name="discount_id" value="<?=$discount_id?>" class="input-form-banner" maxlength="10" onblur="orderCalculate();" /></td>
						</tr>
					<? } ?>
				<? } ?>
				<tr>
					<th colspan="2" class="SIGNUPTable-title"><h2 class="standardSubTitle"><?=system_showText(LANG_BILLINGINFO)?><span>(<?=system_showText(LANG_BILLINGINFO_MSG1)." ".system_showText(LANG_BILLINGINFO_MSG2_BANNER)?>)</span></h2></th>
				</tr>
				<tr>
					<th class="textTop">* <?=system_showText(LANG_LABEL_LANGUAGE);?>:</th>
					<td>
						<?=language_langOptions($lang);?>
						<span><?=system_showText(LANG_LABEL_LANGUAGETIP)?></span>
					</td>
				</tr>
				<tr>
					<th>* <?=system_showText(LANG_LABEL_FIRSTNAME)?>:</th>
					<td><input type="text" name="first_name" value="<?=$first_name?>" /></td>
				</tr>
				<tr>
					<th>* <?=system_showText(LANG_LABEL_LASTNAME)?>:</th>
					<td><input type="text" name="last_name" value="<?=$last_name?>" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_COMPANY)?>:</th>
					<td><input type="text" name="company" value="<?=$company?>" /></td>
				</tr>
				<tr>
					<th valign="top"><?=system_showText(LANG_LABEL_ADDRESS)?>:</th>
					<td><input type="text" name="address" value="<?=$address?>" maxlength="50" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_ADDRESSOPTIONAL)?>:</th>
					<td><input type="text" name="address2" value="<?=$address2?>" maxlength="50" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_CITY)?>:</th>
					<td><input type="text" name="city" value="<?=$city?>" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_STATE)?>:</th>
					<td><input type="text" name="state" value="<?=$state?>" /></td>
				</tr>
				<tr>
					<th><?=ucwords(ZIPCODE_LABEL)?>:</th>
					<td><input type="text" name="zip" value="<?=$zip?>" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_COUNTRY)?>:</th>
					<td><input type="text" name="country" value="<?=$country?>" /></td>
				</tr>
				<tr>
					<th><?=system_showText(LANG_LABEL_PHONE)?>:</th>
					<td><input type="text" name="phone" value="<?=$phone?>" /></td>
				</tr>
				<tr>
					<th>* <?=system_showText(LANG_LABEL_EMAIL)?>:</th>
					<td><input type="text" name="email" value="<?=$email?>" /></td>
				</tr>
			</table>

			<? include(EDIRECTORY_ROOT."/includes/code/seckey.php"); ?>

			<input type="hidden" name="ieBugFix" value="1" />

			<div id="loadingOrderCalculate" class="loadingOrderCalculate"><?=system_showText(LANG_WAITLOADING)?></div>

			<? if (PAYMENT_FEATURE == "on") { ?>
				<? if ((CREDITCARDPAYMENT_FEATURE == "on") || (INVOICEPAYMENT_FEATURE == "on")) { ?>
					<div id="check_out_payment" class="<?=$checkoutpayment_class?>">
						<div id="checkoutpayment_total" class="orderTotalAmount"></div>
						<? include(INCLUDES_DIR."/forms/form_paymentmethod.php"); ?>
						<p class="standardButton">
							<button type="submit" name="continue" value="<?=system_showText(LANG_BUTTON_CONTINUE)?>"><?=system_showText(LANG_BUTTON_CONTINUE)?></button>
						</p>
					</div>
				<? } ?>
			<? } ?>

			<div id="check_out_free" class="<?=$checkoutfree_class?>">
				<div id="checkoutfree_total" class="orderTotalAmount"></div>
					<p class="standardButton">
						<button type="submit" name="checkout" value="<?=system_showText(LANG_BUTTON_CONTINUE)?>"><?=system_showText(LANG_BUTTON_CONTINUE)?></button>
					</p>
			</div>

		</form>

	</div>

	<script language="javascript" type="text/javascript">
		orderCalculate();
	</script>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/layout/footer.php");
?>
