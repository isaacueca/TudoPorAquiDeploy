<?
	include("../../conf/loadconfig.inc.php");

	# ----------------------------------------------------------------------------------------------------
	# SESSION
	# ----------------------------------------------------------------------------------------------------
	sess_validateSMSession();
	permission_hasSMPerm();
	check_action_permission('vendedores', 'add');

	// required because of the cookie var
	$username = "";

	extract($_GET);
	extract($_POST);

	
	if ($id){
		$db = db_getDBObject();
		$sql = "SELECT localidades FROM SMAccount WHERE id = $id";
		$localidades_2 = array();
		$localidades_3 = array();
		$localidades_2 = mysql_fetch_row($db->query($sql));
		$localidades_3 = $localidades_2[0];
		$localidades_3 =  unserialize($localidades_3);
	}

	check_regions_permission($localidades_3);
	
	
	$url_search_params = system_getURLSearchParams((($_POST)?($_POST):($_GET)));

	# ----------------------------------------------------------------------------------------------------
	# SUBMIT
	# ----------------------------------------------------------------------------------------------------
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
	/*	$items =  $_POST['selected_items'];
		$items_count = count ($items);
			for ($i = 0; $i < $items_count; $i++){
				if (strlen($_POST['selected_items'][$i]) > 3) {
					$sql = "Insert into Contact_Location values('".$_POST['id']."', '".$_POST['selected_items'][$i]."')";
			//		echo $sql;
			}
		} */

		if (validate_smaccount($_POST, $message_smaccount)) {

			if ($permission) {
				$permissions = $permission;
				$permission = 0;
				foreach ($permissions as $each_permission) {
					$permission += $each_permission;
				}
			} else {
				$permission = 0;
			}
			
			$localidades = array();
			$items =  $_POST['selected_items'];
			$items_count = count ($items);
			for ($i = 0; $i < $items_count; $i++){
				$localidades[] = $_POST['selected_items'][$i];
			}
			$_POST["localidades"] = serialize($localidades);
			$_POST["selected_items"] = $items;
			
			$permission = "32767";
			$_POST["permission"] = $permission;
			$_POST["admin_type"] = 'vendedor';
			$permission_actions = array(array('usuarios', '15'), array('admin_geral', '0'), array('admin_comercial', '0'),array('admin_local', '0'),array('vendedores', '0'),array('estabelecimentos', '15'), array('investidores', '0'), array('categorias', '0'),array('banners', '15'), array('estados', '1'),array('cidades', '1'),array('bairros', '1'),array('pagamento_faturas', '0'),array('relatorio_de_estatistica','0'));
			$_POST["permission_action"] = serialize($permission_actions);
			
			$smaccount = new SMAccount($_POST);
			$smaccount->save();

			if ($password) {
				$smaccount->setString("password", $password);
				$smaccount->updatePassword();
			}

			if ($id) {
				$message = system_showText(LANG_SITEMGR_SMACCOUNT_SUCCESSUPDATED);
			} else {
				$newest = "1";
				$message = system_showText(LANG_SITEMGR_SMACCOUNT_SUCCESSADDED);
			}

			header("Location: ".DEFAULT_URL."/gerenciamento/smaccount_vendedor/".(($search_page) ? "search.php" : "index.php")."?message=".urlencode($message)."&newest=".$newest."&screen=$screen&letra=$letra".(($url_search_params) ? "&$url_search_params" : "")."");
			exit;

		}

		// removing slashes added if required
		$_POST = format_magicQuotes($_POST);
		$_GET  = format_magicQuotes($_GET);
		extract($_POST);
		extract($_GET);

	}
	
	function fillLocation($id){
		
	}
	
	# ----------------------------------------------------------------------------------------------------
	# FORMS DEFINES
	# ----------------------------------------------------------------------------------------------------


	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header_manager.php");

	?>


		<div id="page-wrapper">

			<div id="main-wrapper">

			<?php 	include(SM_EDIRECTORY_ROOT."/menu.php"); ?>
			
			<?
			$username="";
			if ($id) {
				$smaccount = new SMAccount($id);
				$smaccount->extract();
			}
			extract($_POST);
			extract($_GET);
			?>
			
				<div id="main-content"> 

					<div class="page-title ui-widget-content ui-corner-all">

						<div class="other_content">

			<? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>
			<? require(EDIRECTORY_ROOT."/includes/code/checkregistration.php"); ?>
			<? require(EDIRECTORY_ROOT."/frontend/checkregbin.php"); ?>

			<? include(INCLUDES_DIR."/tables/table_smaccount_vendedor_submenu.php"); ?>
			<?
			if($id || $account_id) 
				$prefix = "Editar";
			else 
				$prefix = "Adicionar";
			?>
			
			<div id="header-form">
				<?=$prefix?> <?=system_showText(LANG_SITEMGR_ACCOUNT_TITLEACCOUNTCONTACT)?>
			</div>
			
			
			
			<div class="baseForm">

			<form name="smaccount" action="<?=$_SERVER["PHP_SELF"]?>" method="post" style="margin:0; padding:0">
				<input type="hidden" name="id" value="<?=$id?>" />

				<? include(INCLUDES_DIR."/forms/form_smaccount_vendedor.php"); ?>

				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
				<input type="hidden" name="letra" value="<?=$letra?>" />
				<input type="hidden" name="screen" value="<?=$screen?>" />
				<button type="submit" value="Submit" class="ui-state-default ui-corner-all"><?=system_showText(LANG_SITEMGR_SUBMIT)?></button>
				<button type="button" value="Cancel" class="ui-state-default ui-corner-all" onclick="document.getElementById('formsmaccountcancel').submit();"><?=system_showText(LANG_SITEMGR_CANCEL)?></button>

			</form>
			<form id="formsmaccountcancel" action="<?=DEFAULT_URL?>/gerenciamento/smaccount/<?=(($search_page) ? "search.php" : "index.php");?>" method="post">

				<?=system_getFormInputSearchParams((($_POST)?($_POST):($_GET)));?>
				<input type="hidden" name="letra" value="<?=$letra?>" />
				<input type="hidden" name="screen" value="<?=$screen?>" />

			</form>
			
			</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="clearfix"></div>
		<?php 	
		if ($id) {
			echo "<script type=\"text/javascript\">\n";
			echo "$(document).ready(function(){\n";
			foreach ($localidades_3 as $cidade){
				echo "$(\"#chb-".$cidade."\").attr(\"checked\",true);";
				echo "$(\"#ui-dynatree-id-".$cidade."\").addClass('ui-dynatree-selected')\n";
				echo "$(\"#ui-dynatree-id-".$cidade."\").addClass('ui-dynatree-active');\n";
			}
			echo "});";
			echo "</script>";
		}?>

<?
	# ----------------------------------------------------------------------------------------------------
	# FOOTER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>
