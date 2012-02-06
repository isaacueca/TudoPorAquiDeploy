				<span class="clear"></span>
    	</div>
        <?php include(INCLUDES_DIR."/code/statisticreport.php"); ?>

		<?php
            /* googlemap */
            if (strpos($_SERVER["PHP_SELF"], 'results.php') !== false) {

                if($itemRSSSection == 'listing')    $searchResults = $listings;
                if($itemRSSSection == 'classified') $searchResults = $classifieds;
                if($itemRSSSection == 'event')      $searchResults = $events;
                
                if(!isset($itemRSSSection) and ($promotions)) {
                    $searchResults = array();
                    $promotionTitle[] = array();
                    if ($promotions) {
                        foreach($promotions as $promotion){
                            $listings = $listingObj->retrieveListingsbyPromotion_id($promotion->getNumber("id"));            
                            foreach($listings as $listing){
                                $searchResults[] = $listing;
                                $promotionTitle[$listing->getNumber('id')] = $promotion->getString('name', true);
                            }
                        }
                    }
                }
                
                //include(INCLUDES_DIR.'/views/view_resultsmap.php');
            }
        ?>

		<?
		// GOOGLE ANALYTICS FEATURE 
		if (GOOGLE_ANALYTICS_ENABLED == "on") {
			$google_analytics_page = "front";
			include(INCLUDES_DIR."/code/google_analytics.php");
		}
		?>
         <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17085729-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</div>
<div>
	<center>
	<?php
	 //echo "XX".$tipo_assinante."XX".$listing->getString('tipo_assinante')."XX".$listing->getNumber("tipo_assinante");
    if (((strpos($_SERVER["PHP_SELF"], 'detail.php') == false) && (strpos($_SERVER["PHP_SELF"], 'blog.php') == false)) || ($listing->getString("tipo_assinante") == 1)) {
	
	if (strpos($_SERVER["PHP_SELF"], 'detail.php') == true) {
	?>
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-0774327494663941";
	/* Minisite-Rodape */
	google_ad_slot = "1490685212";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php
}
else {
	?>
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-0774327494663941";
	/* Principal-Rodape */
	google_ad_slot = "6026968135";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	<?php	
	
}
}
	?>
	</center>
	<br>
<div>

	</body>

</html>