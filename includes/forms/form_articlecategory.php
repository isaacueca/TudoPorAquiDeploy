<?
	# ----------------------------------------------------------------------------------------------------
	# * FILE: /includes/forms/form_articlecategory.php
	# ----------------------------------------------------------------------------------------------------

?>

<script language="javascript" type="text/javascript" src="<?=DEFAULT_URL?>/scripts/common.js"></script>

<table cellpadding="2" cellspacing="0" class="table-form" style="margin-bottom:10px">

	<tr class="tr-form">
		<td align="right" class="td-form">
			<div class="label-form">* Nome da Categoria:</div>
		</td>
		<td align="left" class="td-form">
			<input type="text" name="title" class="input-form-article" value="<?=$title?>" OnBlur="easyFriendlyUrl(this.value, 'friendly_url', '<?=FRIENDLYURL_VALIDCHARS?>\n', '<?=FRIENDLYURL_SEPARATOR?>');" /><br />
		</td>
	</tr>
</table>


