<?
	session_start();
	include("../conf/loadconfig.inc.php");
	include(LISTING_EDIRECTORY_ROOT."/mod_rewrite.php");
	include(EDIRECTORY_ROOT."/includes/code/validate_querystring.php");
	include(EDIRECTORY_ROOT."/includes/code/validate_frontrequest.php");


	# ----------------------------------------------------------------------------------------------------
	# LISTING
	# ----------------------------------------------------------------------------------------------------
	if (($_GET["id"]) || ($_POST["id"])) {
		$id = $_GET["id"] ? $_GET["id"] : $_POST["id"];
		$listing = new Listing($id);
		$level = new ListingLevel(EDIR_DEFAULT_LANGUAGE, true);
		unset($listingMsg);
		if ((!$listing->getNumber("id")) || ($listing->getNumber("id") <= 0)) {
			$listingMsg = ucwords(LISTING_FEATURE_NAME)." not found!";
		} elseif ($listing->getString("status") != "A") {
			$listingMsg = ucwords(LISTING_FEATURE_NAME)." not available!";
		} elseif ($level->getDetail($listing->getNumber("level")) != "y") {
			$listingMsg = ucwords(LISTING_FEATURE_NAME)." not available!";
		} else {
			report_newRecord("listing", $id, LISTING_REPORT_DETAIL_VIEW);
		}
	} else {
		header("Location: ".LISTING_DEFAULT_URL."/");
		exit;
	}
	
	# ----------------------------------------------------------------------------------------------------
	# BLOG DETAILS?
	# ----------------------------------------------------------------------------------------------------
	$is_blog_details = 0;
	if (($_GET["post_id"]) || ($_POST["post_id"])) {
		$is_blog_details = 1;
		$id = $_GET["post_id"] ? $_GET["post_id"] : $_POST["post_id"];
		$article = new Article($id);
		$level = new ArticleLevel(EDIR_DEFAULT_LANGUAGE, true);
		unset($articleMsg);
		if ((!$article->getNumber("id")) || ($article->getNumber("id") <= 0)) {
			$articleMsg = ucwords(ARTICLE_FEATURE_NAME)." not found!";
		} elseif ($article->getString("status") != "A") {
			$articleMsg = ucwords(ARTICLE_FEATURE_NAME)." not available!";
		} elseif ($article->getString("publication_date") > date("Y-m-d")) {
			$articleMsg = ucwords(ARTICLE_FEATURE_NAME)." not available!";
		} elseif ($level->getDetail($article->getNumber("level")) != "y") {
			$articleMsg = ucwords(ARTICLE_FEATURE_NAME)." not available!";
		} else {
			report_newRecord("article", $id, ARTICLE_REPORT_DETAIL_VIEW);
		}
	}
	
	# ----------------------------------------------------------------------------------------------------
	# REVIEWS
	# ----------------------------------------------------------------------------------------------------
	if ($id)  $sql_where[] = " item_type = 'article' AND item_id = ".db_formatNumber($id)." ";
	if (true) $sql_where[] = " review IS NOT NULL AND review != '' ";
	if (true) $sql_where[] = " approved = '1' ";
	if ($sql_where) $sqlwhere .= " ".implode(" AND ", $sql_where)." ";
	$pageObj  = new pageBrowsing("Review", $screen, 3, "added DESC", "", "", $sqlwhere);
	$reviewsArr = $pageObj->retrievePage("object");
	
	
	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	if (($listing->getNumber("id")) && ($listing->getNumber("id") > 0)) {
		$listCategs = $listing->getCategories();
		if ($listCategs) {
			foreach ($listCategs as $listCateg) {
				$category_id[] = $listCateg->getNumber("id");
			}
		}
	}
	$_POST["category_id"] = $category_id;
	$extrastyle = array(DEFAULT_URL."/layout/detail.css", DEFAULT_URL."/layout/template.css");
	$banner_section = "listing";
	$headertag_title = (($listing->getString("seo_title"))?($listing->getString("seo_title")):($listing->getString("title")));
	$headertag_description = (($listing->getStringLang(EDIR_LANGUAGE, "seo_description"))?($listing->getStringLang(EDIR_LANGUAGE, "seo_description")):($listing->getStringLang(EDIR_LANGUAGE, "description")));
	$headertag_keywords = (($listing->getStringLang(EDIR_LANGUAGE, "seo_keywords"))?($listing->getStringLang(EDIR_LANGUAGE, "seo_keywords")):(str_replace(" || ", ", ", $listing->getStringLang(EDIR_LANGUAGE, "keywords"))));
	include(EDIRECTORY_ROOT."/layout/header_details.php");

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	require(EDIRECTORY_ROOT."/frontend/checkregbin.php");

	# ----------------------------------------------------------------------------------------------------
	# BODY
	# ----------------------------------------------------------------------------------------------------
	include(EDIRECTORY_ROOT."/frontend/body/listing_blog.php");
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	$banner_section = "listing";
	include(EDIRECTORY_ROOT."/layout/footer.php");

?>
