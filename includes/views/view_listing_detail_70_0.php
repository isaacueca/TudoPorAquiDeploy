	<? if (!strpos($_SERVER["PHP_SELF"], "print.php")) { ?>
		<div id="estabelecimento">
		<div id="estabelecimento_header">
			<div class="estabelecimento_title">
				<h1><?=$listingtemplate_title?></h1>
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
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$listingtemplate_image?>
		</div>
	
		<?= $listingtemplate_review_bellow_title ?>
       
	<div class="sidebar-actions">
		<a onclick="tb_show('', '<?php echo DEFAULT_URL ?>/listing/reviewformpopup.php?width=740&amp;height=430&amp;item_type=listing&amp;item_id=<?php echo $listing->getNumber("id")?>');void(0);" href="javascript:void(0)" title="De sua nota" class="nota">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> <?php echo system_showText("Avaliar") ?></strong>
		</a>
        
 <? if($listing->getNumber("tipo_assinante") != 0) { ?>	
		<?=$listingtemplate_icon_navbar?>
 <? } ?>
	</div>

</div>	

<div id="info">

	    <? if(($listingtemplate_address) || ($listingtemplate_address2) || ($listingtemplate_location)) echo "<address>\n"; ?>

		<? if ($listingtemplate_address) { ?>
			<h2 class="infol"><?php echo utf8_decode("Endereço:") ?></h2>
			<strong class="info1"><?=$listingtemplate_address?></strong><br/>
		<? } ?>

		<? if ($listingtemplate_address2) { ?>
			<h2 class="infol">&nbsp;</h2>
			<strong class="info1"><?=$listingtemplate_address2?></strong><br/>
		<? } ?>

		<? if ($listingtemplate_location) { ?>
            <h2 class="infol"><?php echo utf8_decode("Bairro:") ?></h2>
			<strong class="info1"><?=$listingtemplate_location?></strong><br/>
		<? } ?>
		
		<? if ($listingtemplate_locationzip) { ?>
            <h2 class="infol"><?php echo utf8_decode("CEP:") ?></h2>
            <strong class="info1"><?=$listingtemplate_locationzip?></strong><br/>
		<? } ?>

		<? if(($listingtemplate_address) || ($listingtemplate_address2) || ($listingtemplate_location)) echo "</address>\n"; ?>

		<? if ($listingtemplate_description) { ?>
			<!-- <p class="summaryDescription" <?=$templateCSSText;?>><?=$listingtemplate_description?></p>
			!-->
		<? }?>
		<? if ($listingtemplate_url) { ?><h2 class="infol">Site:</h2><strong class="info1"><?=$listingtemplate_url?></strong><br/><? } ?>
		<? if ($listingtemplate_phone) { ?><h2 class="infol">Telefone:</h2><strong class="info1"><?=$listingtemplate_phone?></strong><br/><? } ?>
		<? if ($listingtemplate_fax) { ?><h2 class="infol">Fax:</h2><strong class="info1"><?=$listingtemplate_fax?></strong><br/><? } ?>
		<? if ($listingtemplate_email) { ?><h2 class="infol">E-Mail:</h2><strong class="info1"><?=$listingtemplate_email?></strong>&nbsp;<br/><span class="infol">&nbsp;</span><a href="javascript:void(0)" onclick="if ((document.getElementById('recados').style.display == 'none')) {(document.getElementById('recados').style.display = '');  $('#from').focus();} else {(document.getElementById('recados').style.display = 'none');}">Enviar email</a> &nbsp;<br/><span class="infol">&nbsp;</span>
		
		<? } ?>
    
		<?  if (($error == "") || ($error=="Sua mensagem foi enviada. Obrigado.")) {?>
		    <script language="javascript">
		        document.getElementById('recados').style.display = 'none';
		    </script>
		<? }  ?>

    		<? if ($error) {$message_style = "errorMessage"; if ($error=="Sua mensagem foi enviada. Obrigado.") $message_style = "successMessage";?>
            <p class="<?=$message_style?>"><?=$error?></p>
			<? } ?>
			
       <div id="recados" style="display:none">
		<div class="formDetail">
			<div id="estabelecimentos_email_top">
			</div>
			<div id="estabelecimentos_email">

				<form name="mail" method="post" action="<?=$_SERVER["PHP_SELF"]?>?id=<?=$_GET["id"]?>#info">
					<div>
						<? foreach ($_GET as $key => $value) print "<input type=\"hidden\" name=\"$key\" value=\"$value\" />"; ?>
						<input type="hidden" name="id" value="<?=$_GET["id"]?>" />
						<input type="hidden" name="id" value="<?=$_GET["id"]?>" />
						<input type="hidden" name="to" value="<?=htmlentities($listing->getString("email"))?>" />
		
						<label for="from">Seu Email</label>
						<input type="text" name="from" id="from" value="<?=$from?>" />
						<br />
						<label for="subject">Assunto</label>
						<input type="text" name="subject" id="subject" value="<?=$subject?>" />
						<br />
						<label for="body">Mensagem</label>
						<textarea name="body" rows="5" id="body" cols=""><?=$body?></textarea>
						<br class="clear" />
						<br/>
						<div class="captchaImage"><img src="<?=DEFAULT_URL?>/includes/code/captcha.php" border="0" /></div>
						<input type="text" name="captchatext" value="" class="formCode" />
						<div id="enviar_email">
							<span class="enviar_email">
								<? if ($user){ ?>
									<button type="submit" value="Send">Enviar</button>
									<? } else { ?>
									<button type="button" value="Send">Enviar</button>
									<? } ?>
							</span>
						</div>
						<br class="clear" />
			</div>
		</form>
			<div id="estabelecimentos_email_bottom">
			</div>
		</div>
	</div>
</div>
<div style="clear:both"></div>

  
	<iframe scrolling="no" id="f13882223958e3" name="f1940498adaa7a4" style="border: medium none; overflow: hidden; height: 24px; width: 580px;" class="fb_ltr" src="http://www.facebook.com/plugins/like.php?href=<?php echo curPageURL();?>&amp;postmessage&amp;href=<?php echo curPageURL();?>&amp;action=recommend&amp;layout=standard&amp;locale=pt_BR&amp;node_type=link&amp;sdk=joey&amp;show_faces=true&amp;width=580"></iframe>
	<div style="margin:15px 0 15px 0">
		<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo curPageURL();?>" data-count="horizontal" data-via="Tudoporaqui">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>		
    </div>
	<? if ($listingtemplate_attachment_file) { ?>
           	<h3 class="detailTitle" <?=$templateCSSLabel;?>><?=ucfirst(system_showText(LANG_LABEL_ADDITIONALINFORMATION))?></h3>
			<?=$listingtemplate_attachment_file?>
		<? } ?>

		<? if ($listingtemplate_long_description) { ?>
			<br/><br/><p><? echo str_replace("<br />", "", html_entity_decode($listingtemplate_long_description)); ?></p>
		<? } ?>

		<? if ($listingtemplate_hours_work) { ?>
			<h3 class="detailTitle" <?=$templateCSSLabel;?>><?=system_showText(LANG_LISTING_HOURS_OF_WORK)?></h3>
			<p><?=$listingtemplate_hours_work?></p>
		<? } ?>

		<? if ($listingtemplate_locations) { ?>
			<h3 class="detailTitle" <?=$templateCSSLabel;?>><?=system_showText(LANG_LOCATIONS)?></h3>
			<p><?=$listingtemplate_locations?></p>
		<? } ?>

		<?=$templateExtraFields;?>

	<?
		$pos = strpos($listingtemplate_summary_review,"(0 avalia");
		
		if (($listingtemplate_summary_review)) { ?>
		<div id="facebook_comments">
			<fb:comments xid="<?php echo urlencode(curPageURL())?>"  url="<?php echo urldecode(curPageURL())?>"  width="410"></fb:comments>
		</div>
		<div class="detailRatings">
       
        	<br/>
			<h3 class="detailTitle" <?=$templateCSSLabel;?>><?=ucfirst(system_showText('Avalia&#231;&#245;es'))?><?=$listingtemplate_summary_review?></h3>
			<? if ($listingtemplate_review) { ?>
				<?=$listingtemplate_review?>
			<? } ?>
             <? if ($pos == true) { ?>
        		<?= $item_noreview ?>
        	<? } ?>
		</div>
	<? } ?>
	</div>
<div id="right_details_position">
	
		<div id="mapa_outline">
			<div id='map' name='map' class='googleBase'></div> 
			<?=$listingtemplate_google_maps?>
		</div>
		
 <? if($listing->getNumber("tipo_assinante") != 0) { ?>
		<?php if ($listingtemplate_client!="") { ?>
		<h3 class="detailTitle" <?=$templateCSSLabel;?>>Clientes</h3>
		<?php } ?>
		<div class="detailGallery">
			<?=$listingtemplate_client?>
		</div>

<?php if ($listingtemplate_gallery!="") { ?>
		<h3 class="detailTitle" <?=$templateCSSLabel;?>>Fotos</h3>
		<?php } ?>
		<div class="detailGallery">
			<?=$listingtemplate_gallery?>
		</div>

		<? if ($listingtemplate_video_snippet) { ?>
			<h3 class="detailTitle" <?=$templateCSSLabel;?>><?=system_showText(LANG_LABEL_VIDEO);?></h3>
			<div class="videoDetail">
				<?=$listingtemplate_video_snippet?>
			</div>
		<? } ?>
<? } ?>
	</div>


</div>


<script type="text/javascript">

function compartilharTwitter(){
			var twitterObj = {};
			twitterObj.titulo = document.title.replace(/(\s-\s|\s*)\d{2}\/\d{2}\/\d{4}.*?$/g,'');
			twitterObj.url = location.href;		
			twitterObj.shortUrl = twitterObj.url;
			var twitterpost;
			twitterpost = '#Tudoporaqui';
			twitterpost = (/#Tudoporaqui/i).test(twitterpost)?twitterpost:(twitterpost+' #Tudoporaqui');
			var twitterWindow = function(u){
				if(u) {
					window.open( u, "compartilheTwitter" );
					return;
				}
				var postMax = 136 - twitterObj.shortUrl.length - twitterpost.length; 
				if('cfg.titulo'.length < postMax) {
					twitterpost = twitterObj.titulo+' '+twitterObj.shortUrl+' '+twitterpost;
				} else {
					twitterpost = (new RegExp('(.{0,'+postMax+'})\\b')).exec(twitterObj.titulo)[1].replace(/[ \t]*$/,'') + '\u2026 ' + cfg.shortUrl +' '+ twitterpost;
				}
				var url = "http://twitter.com/home?status="+encodeURIComponent(twitterpost.replace());
				window.open( url, "compartilheTwitter" );
			}
			twitterWindow();
}

</script>

<div id="fb-root"></div>

<script>
  window.fbAsyncInit = function() {
    FB.init({appId: '151047404923101', status: true, cookie: true,
             xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/pt_BR/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());
</script>




<? } else{ ?>
	<br/>
	<div style="float:left;margin-left:10px; width:300px">
		<h2 style="font-size:1.5em"><?=$listingtemplate_title?></h2>
		<br/>
			<? if(($listingtemplate_address) || ($listingtemplate_address2) || ($listingtemplate_location)) echo "<address>\n"; ?>

			<? if ($listingtemplate_address) { ?>
				<span class="infol"><?php echo utf8_decode("Endereço:") ?></span>
				<span class="info1"><?=$listingtemplate_address?></span><br/>
			<? } ?>

			<? if ($listingtemplate_address2) { ?>
				<span class="info1"><?=$listingtemplate_address2?></span><br/>
			<? } ?>

			<? if ($listingtemplate_location) { ?><br/>
			<span class="infol"><b><?php echo utf8_decode("Bairro:") ?></b></span>
				<span class="info1"><?=$listingtemplate_location?></span><br/>
			<? } ?>

			<? if ($listingtemplate_locationzip) { ?>
			<br/><span class="infol"><b><?php echo utf8_decode("CEP:") ?></b></span> <?=$listingtemplate_locationzip?><br/>
			<? } ?>

			<? if(($listingtemplate_address) || ($listingtemplate_address2) || ($listingtemplate_location)) echo "</address>\n"; ?>

			<? if ($listingtemplate_description) { ?>
				<!-- <p class="summaryDescription" <?=$templateCSSText;?>><?=$listingtemplate_description?></p>
				!-->
			<? }?>

			<? if ($listingtemplate_phone) { ?><br/><span class="infol"><b>Telefone:</b></span><span class="telefone"> <?=$listingtemplate_phone?></span><br/><? } ?>
			<? if ($listingtemplate_fax) { ?><br/><span class="infol"><b>Fax:</b></span> <?=$listingtemplate_fax?><br/><? } ?>
			<? if ($listingtemplate_url) { ?><br/><span class="infol"><b>Site:</b></span>  <?=$listingtemplate_url?><br/><? } ?>
			<? if ($listingtemplate_email) { ?><br/><span class="infol"><b>E-Mail:</b></span><?=$listingtemplate_email?><br/>
			<? if ($listingtemplate_locations) { ?>
				<br/><span class="infol"><b>Localizacao:</b></span><?=$listingtemplate_locations?>
			<? } ?>
			<? } ?>	
			<br/>
			
			</div>
			
			<div style="float:right">

			<div id="mapa_outline">
				<div id='map' name='map' class='googleBase'></div> 
					<?=$listingtemplate_google_maps?>
				</div>
			</div>
			
			<div style="clear:both">
				
			<div style="margin-left:10px">
				<? if ($listingtemplate_long_description) { ?>
					<br></br><p><? echo str_replace("<br />", "", html_entity_decode($listingtemplate_long_description)); ?></p>
					<? } ?>
			</div>

<? } ?>