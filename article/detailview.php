<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /article/detailview.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# AUX
	# ----------------------------------------------------------------------------------------------------
	require(EDIRECTORY_ROOT."/frontend/checkregbin.php");

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	if (!$articleMsg) {
		$user = true;
		include(INCLUDES_DIR."/views/view_article_detail_".$article->getNumber("level").".php");
	} else {
		echo "<p class=\"errorMessage\">".$articleMsg."</p>";
	}

?>
