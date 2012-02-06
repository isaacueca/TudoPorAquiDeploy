<?

	/*==================================================================*\
	######################################################################
	#                                                                    #
	# SisDir Class- System of Class Online 2009           #
	#                                                                    #
	#                #
	#                       #
	#                                                                    #
	# ---------------- 2009 - this file is used in php. ----------------- #
	#                                                                    #
	# http://wxw.google.cn / wxw.msn.cn #
	######################################################################
	\*==================================================================*/

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /body/classified_detail.php
	# ----------------------------------------------------------------------------------------------------

?>

	<div class="sidebar">
		<? include(CLASSIFIED_EDIRECTORY_ROOT."/join.php"); ?>
		<div class="baseBannerFeatured"><? include(EDIRECTORY_ROOT."/frontend/banner_featured.php"); ?></div>
		<div class="baseSponsoredLinks"><? include(EDIRECTORY_ROOT."/frontend/banner_sponsoredlinks.php"); ?></div>
		<? include(EDIRECTORY_ROOT."/frontend/googleads.php"); ?>
	</div>

	<div class="mainContent">
		<? include(EDIRECTORY_ROOT."/frontend/breadcrumb.php"); ?>
		<? include(CLASSIFIED_EDIRECTORY_ROOT."/detailview.php"); ?>
	</div>