<?php if ($_GET['post_id'] == null) {?>

<div id="estabelecimento">
		<div id="estabelecimento_header">
			<div class="estabelecimento_title">
				<h1>
				   	<a href="<?php echo DEFAULT_URL ?>/listing/detail.php?id=<?php echo $_GET['id']?>">
					<?=$listingtemplate_title?>
					</a>
				</h1>
			</div>
		
			<div class="estabelecimento_social_icons">
				<span class="titulo">Compartilhar</span>
				<ul>
					<li class="social_orkut"> 
						<a title="Compartilhar no Orkut" target="_blank" href="http://promote.orkut.com/preview?nt=orkut.com&amp;tt=<?=$listingtemplate_title?>&amp;du=<?php echo curPageURL();?>"><span class="social_icon"></span></a>
					</li>
					<li class="social_facebook"> 
						<a title="Compartilhar no Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo curPageURL();?>"><span class="social_icon"></span></a>					</li>
					<li class="social_twitter"> 
						<a title="Compartilhar no Twitter" href="javascript:void(0)" onclick="compartilharTwitter(0)"> <span class="social_icon"></span></a>
					</li>
					<li class="impressora"> 
						<a title="Imprimir" target="_blank" href="<?php echo DEFAULT_URL ?>/listing/print.php?id=<?=$_GET["id"]?>"><span class="social_icon"></span></a>
					</li>
				</ul>
				<div style="clear:both"></div>
			</div>
		</div>
		
		<div style="clear:both"></div>
		
<div id="esq">
		<div class="imgDetail">
			<a href="<?php echo DEFAULT_URL ?>/listing/detail.php?id=<?php echo $_GET['id']?>">
		   	
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$listingtemplate_image?>
			</a>
		</div>
		
		<?= $listingtemplate_review_bellow_title ?>

		<div class="sidebar-actions">
			<a  onclick="tb_show('', '<?php echo DEFAULT_URL ?>/listing/reviewformpopup.php?width=740&amp;height=400&amp;item_type=listing&amp;item_id=<?php echo $listing->getNumber("id")?>');void(0);" href="javascript:void(0)" title="De sua nota" class="nota">
				<span> <?php echo system_showText("Avaliar") ?></span>
			</a>
			<?=$listingtemplate_icon_navbar?>
		</div>

</div>	

<div id="blog_background">

	<div id="info_blog">
		<?php 

		function ConvertDate($sql_date) {
	    $date=strtotime($sql_date);
	    $final_date=date("j F, Y", $date);
	    return $final_date;
	    }
	    if (count($posts) >= 1){
			$url = DEFAULT_URL;
			foreach ($posts as $post){
				if ($_GET['categoryid']){
					if ($post['category_id'] == $_GET['categoryid']){
						$article = new Article($post['id']); ?>
						<div class='post_title'><?=$article->getString("title");?></div>
						<?
						if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "<p class=\"complementaryInfo\">\n"; 
						if ($article->getString("publication_date", true)) {
							echo system_showText(LANG_ARTICLE_PUBLISHED).": ".$article->getDate("publication_date");
						}
						if ($article->getString("author", true)) {
							echo " ".system_showText(LANG_BY)." ";
							if (($user) && ($article->getString("author_url", true))) {
								echo "<a href=\"".$article->getString("author_url", true)."\" target=\"_blank\">\n";
							}
							echo $article->getString("author", true);
							if (($user) && ($article->getString("author_url", true))) {
								echo "</a>\n";
							}
						}
						echo "<span class=\"post_category\"><a href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$post['category_id']."> - ".$post['category_title']."</a></span>";
						
						if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "</p>\n";
						?>

						<? if($article->getString("content")) { ?>
							<?
							$imageObj = new Image($article->getNumber("image_id"));
							if ($imageObj->imageExists()) {
								echo "<div class=\"imgDetail\">";
								echo $imageObj->getTag(true, IMAGE_EVENT_FULL_WIDTH, IMAGE_EVENT_FULL_HEIGHT, $article->getString("title"));
								echo "</div>";
								if ($article->getString("image_attribute")) {
									echo "<p class=\"complementaryInfo\">".$article->getString("image_attribute")."</p>";
								}
								if ($article->getString("image_caption")) {
									echo "<p class=\"complementaryInfo\">".$article->getString("image_caption")."</p>";
								}
							}
							?>

							<?
							$articleGallery = "";
							$articleGallery = system_showFrontGallery($article->getGalleries(), $article->getNumber("level"), $user, 4, "article");
							if ($articleGallery!="") {
								?>
								<div class="detailGallery">
									<?=$articleGallery?>
								</div>
								<?
							}
							?>
								<div class="post_content">
									<?=($article->getString("content", false))?>
									<div style="margin-top:10px">
										<?php $item_id=$post['id']; $item_type="article"; include(INCLUDES_DIR."/views/view_review.php");?>
										<?php echo "<a href=".$url."/listing/blog.php?id=".$_GET["id"]."&post_id=".$post['id'].">";?>
											<?php echo utf8_decode(Comentários);  echo "(".$review_amount.")"?>
										</a>
									</div>
								</div>

	
						<? 	} ?>
			<?php 	
					}
				} 
				else{
					$article = new Article($post['id']); ?>
					<div class='post_title'><?=$article->getString("title");?></div>
					<?
					if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "<p class=\"complementaryInfo\">\n"; 
					if ($article->getString("publication_date", true)) {
						echo system_showText(LANG_ARTICLE_PUBLISHED).": ".$article->getDate("publication_date");
					}
					if ($article->getString("author", true)) {
						echo " ".system_showText(LANG_BY)." ";
						if (($user) && ($article->getString("author_url", true))) {
						echo "<a href=\"".$article->getString("author_url", true)."\" target=\"_blank\">\n";
						}
						echo $article->getString("author", true);
						if (($user) && ($article->getString("author_url", true))) {
							echo "</a>\n";
						}
						echo "<span class=\"post_category\"><a href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$post['category_id']."> - ".$post['category_title']."</a></span>";
						
					}
					if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "</p>\n";
					?>
					<?
					$imageObj = new Image($article->getNumber("image_id"));
					if ($imageObj->imageExists()) {
						echo "<div class=\"imgDetail\">";
						echo $imageObj->getTag(true, IMAGE_EVENT_FULL_WIDTH, IMAGE_EVENT_FULL_HEIGHT, $article->getString("title"));
						echo "</div>";
						if ($article->getString("image_attribute")) {
							echo "<p class=\"complementaryInfo\">".$article->getString("image_attribute")."</p>";
						}
						if ($article->getString("image_caption")) {
							echo "<p class=\"complementaryInfo\">".$article->getString("image_caption")."</p>";
						}
					}
					?>

					<?
					$articleGallery = "";
					$articleGallery = system_showFrontGallery($article->getGalleries(), $article->getNumber("level"), $user, 4, "article");
					if ($articleGallery!="") {
						?>
						<div class="detailGallery">
							<?=$articleGallery?>
						</div>
						<?
					}
					?>

					<? if($article->getString("content")) { ?>
							<div class="post_content">
								<?=($article->getString("content", false))?>
								<div style="margin-top:10px">
									<?php $item_id=$post['id']; $item_type="article"; include(INCLUDES_DIR."/views/view_review.php");?>
									<?php echo "<a href=".$url."/listing/blog.php?id=".$_GET["id"]."&post_id=".$post['id'].">";?>
										<?php echo utf8_decode(Comentários);  echo "(".$review_amount.")"?>
									</a>
								</div>
							</div>
							
					<? 	} ?>
		<?php 
					
				}
				
			}
		}
		else{
			echo "<div class='post_title'>".utf8_decode('Não há nenhum artigo no publicado no momento')."</div>";
			echo "<a href=\"javascript:history.back(-1)\">voltar</a>";
		}

		?>

	</div>
<div id="blog_categories_list">
		<div class="title">Categorias</div>
		<?php 
		
		if (count($blogcategories) >= 1){
			foreach ($blogcategories as $category){
				echo "<div class=\"category_title\">";
				if($category['id'] == $_GET['categoryid']){
					echo "<br/><a class=\"selected\" href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$category['id'].">";
				}else{
					echo "<br/><a href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$category['id'].">";
				}
				echo "- ".$category['title'];
				echo "</a>";
				echo "</div>";
			}
		}
			
		?>

</div>

<div style="clear:both"></div>
</div>
</div>

<?php }else {?>
	<div id="estabelecimento">
			<div id="estabelecimento_header">
				<div class="estabelecimento_title">
					<h1>
					   	<a href="<?php echo DEFAULT_URL ?>/listing/detail.php?id=<?php echo $_GET['id']?>">
						<?=$listingtemplate_title?>
						</a>
					</h1>
				</div>

				<div class="estabelecimento_social_icons">
					<span class="titulo">Compartilhar</span>
					<ul>
						<li class="social_orkut"> 
							<a title="Compartilhar no Orkut" target="_blank" href="http://promote.orkut.com/preview?nt=orkut.com&amp;tt=<?=$listingtemplate_title?>&amp;du=<?php echo curPageURL();?>"><span class="social_icon"></span></a>
						</li>
						<li class="social_facebook"> 
							<a title="Compartilhar no Facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo curPageURL();?>"><span class="social_icon"></span></a>					</li>
						<li class="social_twitter"> 
							<a title="Compartilhar no Twitter" href="javascript:void(0)" onclick="compartilharTwitter(0)"> <span class="social_icon"></span></a>
						</li>
						<li class="impressora"> 
							<a title="Imprimir" target="_blank" href="<?php echo DEFAULT_URL ?>/listing/print.php?id=<?=$_GET["id"]?>"><span class="social_icon"></span></a>
						</li>
					</ul>
					<div style="clear:both"></div>
				</div>
			</div>

			<div style="clear:both"></div>

	<div id="esq">
			<div class="imgDetail">
				<a href="<?php echo DEFAULT_URL ?>/listing/detail.php?id=<?php echo $_GET['id']?>">

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$listingtemplate_image?>
				</a>
			</div>

			<?= $listingtemplate_review_bellow_title ?>

			<div class="sidebar-actions">
				<a  onclick="tb_show('', '<?php echo DEFAULT_URL ?>/listing/reviewformpopup.php?width=740&amp;height=400&amp;item_type=listing&amp;item_id=<?php echo $listing->getNumber("id")?>');void(0);" href="javascript:void(0)" title="De sua nota" class="nota">
					<span> <?php echo system_showText("Avaliar") ?></span>
				</a>
				<?=$listingtemplate_icon_navbar?>
			</div>

	</div>	

	<div id="blog_background">

		<div id="info_blog">
			<?php 

			function ConvertDate($sql_date) {
		    $date=strtotime($sql_date);
		    $final_date=date("j F, Y", $date);
		    return $final_date;
		    }
		
		   	$article = new Article($_GET['post_id']);
		
			?>
							<div class='post_title'><?=$article->getString("title");?></div>
							<?
							if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "<p class=\"complementaryInfo\">\n"; 
							if ($article->getString("publication_date", true)) {
								echo system_showText(LANG_ARTICLE_PUBLISHED).": ".$article->getDate("publication_date");
							}
							if ($article->getString("author", true)) {
								echo " ".system_showText(LANG_BY)." ";
								if (($user) && ($article->getString("author_url", true))) {
								echo "<a href=\"".$article->getString("author_url", true)."\" target=\"_blank\">\n";
								}
								echo $article->getString("author", true);
								if (($user) && ($article->getString("author_url", true))) {
									echo "</a>\n";
								}
							}
							echo "<span class=\"post_category\"><a href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$post['category_id']."> - ".$article->getCategoryName()."</a></span>";
							
							if (($article->getString("publication_date", true)) || ($article->getString("author", true))) echo "</p>\n";
							?>
							<?
							$imageObj = new Image($article->getNumber("image_id"));
							if ($imageObj->imageExists()) {
								echo "<div class=\"imgDetail\">";
								echo $imageObj->getTag(true, IMAGE_EVENT_FULL_WIDTH, IMAGE_EVENT_FULL_HEIGHT, $article->getString("title"));
								echo "</div>";
								if ($article->getString("image_attribute")) {
									echo "<p class=\"complementaryInfo\">".$article->getString("image_attribute")."</p>";
								}
								if ($article->getString("image_caption")) {
									echo "<p class=\"complementaryInfo\">".$article->getString("image_caption")."</p>";
								}
							}
							?>

							<?
							$articleGallery = "";
							$articleGallery = system_showFrontGallery($article->getGalleries(), $article->getNumber("level"), $user, 4, "article");
							if ($articleGallery!="") {
								?>
								<div class="detailGallery">
									<?=$articleGallery?>
								</div>
								<?
							}
							?>
							<? if($article->getString("content")) { ?>
									<div class="post_content">
										<?=($article->getString("content", false))?>
									</div>
							<? 	} ?>

								<div class="detailRatings">
								<h3 class="detailTitle" <?=$templateCSSLabel;?>>
									<?php echo utf8_decode(Comentários);?> 
									<span class="complementaryInfo"><?=$summary_review?></span>
								</h3>
									<? if ($detail_review) { ?>
										<?=$detail_review?>
									<? } ?>
									<? if ($listingtemplate_review) { ?>
										<?=$listingtemplate_review?>
									<? } ?>
						             <? if ($pos == true) { ?>
						        		<?= $item_noreview ?>
						        	<? } ?>
									<?
										$item_id   = $_GET['post_id'];
										$item_type = 'article';
										include(INCLUDES_DIR."/views/view_review.php");
										$summary_review .= $item_review;
										$item_review = "";
										$detail_review = "";
										if ($reviewsArr) {
											foreach ($reviewsArr as $each_rate) {
												if ($each_rate->getString("review")) {
													$each_rate->extract();
													include(INCLUDES_DIR."/views/view_review_detail.php");
													$detail_review .= $item_reviewcomment;
													$item_reviewcomment = "";
												}
											}
										}
									?>

								</div>
											
								</a>
								<a class="nota" title="Comente" href="javascript:void(0)" onclick="tb_show('', '<?php echo $url?>/article/reviewformpopup.php?width=740&amp;height=400&amp;item_type=article&amp;item_id=<?php echo $_GET['post_id']?>');void(0);">
									<span> <?php echo utf8_decode('Deixar comentário');?></span>
								</a>
								


		</div>
		
		<div id="blog_categories_list">
			<div class="title">Categorias</div>
			<?php 

			if (count($blogcategories) >= 1){
				foreach ($blogcategories as $category){
					echo "<div class=\"category_title\">";
					if($category['id'] == $_GET['categoryid']){
						echo "<br/><a class=\"selected\" href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$category['id'].">";
					}else{
						echo "<br/><a href=".$url."/listing/blog.php?id=".$_GET["id"]."&categoryid=".$category['id'].">";
					}
					echo "- ".$category['title'];
					echo "</a>";
					echo "</div>";
				}
			}

			?>

	</div>

	<div style="clear:both"></div>
	</div>
	</div>
	
	<script type='text/javascript' src='<?=DEFAULT_URL?>/scripts/jquery.scrollTo-1.4.2-min.js'></script>
			
	<script type="text/javascript">
		$(document).ready(function(){
			$(window).scrollTo('.detailRatings');
		});
	</script>
	
	<?php }?>
