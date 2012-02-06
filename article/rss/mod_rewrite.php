<?



	# ----------------------------------------------------------------------------------------------------
	# * FILE: /rss/mod_rewrite.php
	# ----------------------------------------------------------------------------------------------------

	# ----------------------------------------------------------------------------------------------------
	# CODE
	# ----------------------------------------------------------------------------------------------------
	if ($_GET["qs"]) {

		$qs = explode("_", $_GET["qs"]);

		if (!in_array("categorias", $qs) && !in_array("location", $qs) && (count($qs) == 1)) {

			$_GET["article"] = $qs[0];

		} elseif ((in_array("categorias", $qs) || in_array("location", $qs)) && (count($qs) > 1)) {

			$categoriaspos = array_search("categorias", $qs);
			if ($categoriaspos !== false) $categoriasposbegin = categoriaspos+1;
			$locationpos = array_search("location", $qs);
			if ($locationpos !== false) $locationposbegin = $locationpos+1;

			if ($categoriaspos === false) {
				$locationposend = count($qs)-1;
			} elseif ($locationpos === false) {
				$categoriasposend = count($qs)-1;
			} else {
				if ($categoriasposbegin > $locationposbegin) {
					$categoriasposend = count($qs)-1;
					$locationposend = $categoriaspos-1;
				} elseif ($locationposbegin > $categoriasposbegin) {
					$locationposend = count($qs)-1;
					$categoriasposend = $locationpos-1;
				}
			}

			if ($categoriaspos !== false) {
				for ($i=$categoriasposbegin; $i<=$categoriasposend; $i++) {
					if ($i == ($categoriasposbegin))   $_GET["category1"] = $qs[$i];
					if ($i == ($categoriasposbegin+1)) $_GET["category2"] = $qs[$i];
					if ($i == ($categoriasposbegin+2)) $_GET["category3"] = $qs[$i];
					if ($i == ($categoriasposbegin+3)) $_GET["category4"] = $qs[$i];
					if ($i == ($categoriasposbegin+4)) $_GET["category5"] = $qs[$i];
				}
			}

			if ($locationpos !== false) {
				for ($i=$locationposbegin; $i<=$locationposend; $i++) {
					if ($i == ($locationposbegin))   $_GET["country"] = $qs[$i];
					if ($i == ($locationposbegin+1)) $_GET["state"]   = $qs[$i];
					if ($i == ($locationposbegin+2)) $_GET["region"]  = $qs[$i];
					if ($i == ($locationposbegin+3)) $_GET["city"]    = $qs[$i];
					if ($i == ($locationposbegin+4)) $_GET["area"]    = $qs[$i];
				}
			}

		}

		unset($_GET["qs"], $qs);

	}

	# ----------------------------------------------------------------------------------------------------
	# MOD-REWRITE
	# ----------------------------------------------------------------------------------------------------
	include(ARTICLE_EDIRECTORY_ROOT."/mod_rewrite.php");

?>
