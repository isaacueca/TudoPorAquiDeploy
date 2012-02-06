<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form_login.php
	# ----------------------------------------------------------------------------------------------------

?>

<input type="hidden" name="destiny" value="<?=$destiny?>" />
<input type="hidden" name="query" value="<?=urlencode($query)?>" />

<? $style = ($special_message || $message_login) ? "display:visible;" : "display:none;"; ?>

<? if ($special_message) { ?><p class="errorMessage" style="<?=$style?>"><?=$special_message?></p><? } ?>
<? if ($message_login) { ?><p class="errorMessage" style="<?=$style?>"><?=$message_login?></p><? } ?>

<?
$defaultusername = $username;
$defaultpassword = "";

/*if (DEMO_MODE) {
	if ($membros_section) {
		$defaultusername = "demo";
		$defaultpassword = "abc123";
	} elseif ($sitemgr_section) {
		$defaultusername = "sitemgr";
		$defaultpassword = "abc123";
	}
} */

?>

    
                  <div class="content_front">
                    <div class="blue_box">
                    <table>
                    <tr>
                        <td colspan="2">Usu&#225;rio</td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="input"><input type="text" name="username" id="username" value="<?=$defaultusername?>" class="text"/></span></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?=system_showText(LANG_LABEL_PASSWORD);?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span class="input"><input type="password" autocomplete="off" name="password" id="password" class="text" value="<?=$defaultpassword?>" /></span></td>
                    </tr>
                    <tr>
                    <td>
                    <input type="checkbox" name="automatic_login" value="1" <?=$checked?> class="inputAuto" /><?=system_showText(LANG_AUTOLOGIN);?>
                    </td>
                    <td rowspan="2">
                    <div >
                    <input type="image"   src="<? echo DEFAULT_URL;?>/images/entrar.png" value="submit" />
                    </div>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2">
                    <a class="linkLogin" href="<? echo DEFAULT_URL;?>/membros/esqueceu-a-senha" style="line-height:300%;" >Esqueceu a senha?</a>
                    </td>
                    </tr>
                    </table>
                       
                             				    
                    </div>

                </div>
	
	<script type="text/javascript">
	$(document).ready(function() { 
	    setTimeout
               (
                       function()
                       {
						document.getElementById('username').focus();
                       },
                       400
               );
	document.getElementById('username').focus();

	});

	</script>
