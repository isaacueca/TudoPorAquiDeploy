<?php

	# ----------------------------------------------------------------------------------------------------
	# * FILE: /functions/permission_funct.php
	# ----------------------------------------------------------------------------------------------------
	function curPageURL() {
	 $pageURL = 'http';
	 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return urlencode($pageURL);
	}
	
	function permission_hasSMPerm() {
		if (($_SESSION[SESS_SM_ID])) {
			if (SITEMGR_PERMISSION_SECTION > 0) {
				for ($i=0; $i<SITEMGR_PERMISSION_SECTION; $i++) {
					unset($folders);
					$folders = permission_getSMPermFolders($i);
					if ($folders) {
						foreach ($folders as $folder) {
						/*	echo $i;
							echo '-';
							echo $folder;
							echo "<br>"; */
							if (strpos($_SERVER["PHP_SELF"], "/gerenciamento/".$folder."/") !== false) {
								$sess_sm_perm = decbin($_SESSION[SESS_SM_PERM]);
								while(strlen($sess_sm_perm) < SITEMGR_PERMISSION_SECTION) {
									$sess_sm_perm = "0".$sess_sm_perm;
								}
								
								$id = permission_getSMPermID($i);
								$id = decbin($id);
								while(strlen($id) < SITEMGR_PERMISSION_SECTION) {
									$id = "0".$id;
								}
							  $currentFile = $_SERVER["SCRIPT_NAME"];
							  $parts = explode('/', $currentFile);
							  $index = count($parts) - 1;
							  $current = $parts[$index];
							
							  if (($sess_sm_perm & $id) != $id)  {
									echo "no permission";
									//header("Location: ".DEFAULT_URL."/gerenciamento/");
									exit;
								}
							}
						}
					}
				}
			}
		}
	}
	
	function check_action_permission($section, $action, $menu = ''){
		    if (($_SESSION[SM_LOGGEDIN] == true) && ($_SESSION[SESS_SM_PERM_ACTION] != '')){
				$perms = array(
					'view' => 1,
					'edit' => 2,
					'add' => 4,
					'delete' => 8,
					'confirm' => 16
					);
				$mypermissions = array();
				$mypermissions = $_SESSION[SESS_SM_PERM_ACTION];
				if (is_array($mypermissions) == false) {
				}
				foreach ($mypermissions as $mypermission) {
					$mysection =  $mypermission[0];
					$mypermissionvalue = $mypermission[1];
			    	if ($section === $mysection){
				   		foreach ($perms as $pk => $pv) {
							if ($pk === $action){
	            				if ($mypermissionvalue & $pv){
									return 1;
								}
	            				else{
									$isallowed = false;
									if ($menu == 1){
										return false;
									}
									else{
										header("Location: ".DEFAULT_URL."/gerenciamento/index.php?mensagem=nao_autorizado");
										return false;
									}
								}
							}
	        			}	
					}
			 	}
			}
			elseif($_SESSION[SM_LOGGEDIN] == true){
				return 1;
			}
			else{
				return 0;
			}
	}

	function check_region_permission($cidade_id){
		$locais = array();
		$locais = $_SESSION[SESS_SM_LOCALIDADE];
		if (in_array($cidade_id, $locais)){
		//	echo 'yes';
		}
		else{
		//	echo 'no';
		//	header("Location: ".DEFAULT_URL."/gerenciamento/index.php?mensagem=nao_autorizado");
		}
	}
	
	function check_regions_permission($cidades){
		
		$locais = array();
		$locais = $_SESSION[SESS_SM_LOCALIDADE];
		foreach ($cidades as $cidade_id){
			if (in_array($cidade_id, $locais)){
			//	echo 'yes';
			}
			else{
				header("Location: ".DEFAULT_URL."/gerenciamento/index.php?mensagem=nao_autorizado");
			}
		}
	}


	function permission_hasSMPermSection($sectionid = false) {
		if ($sectionid) {
			if (($_SESSION[SESS_SM_ID])) {
				if (SITEMGR_PERMISSION_SECTION > 0) {
					for ($i=0; $i<SITEMGR_PERMISSION_SECTION; $i++) {
						$sess_sm_perm = decbin($_SESSION[SESS_SM_PERM]);
						while(strlen($sess_sm_perm) < SITEMGR_PERMISSION_SECTION) {
							$sess_sm_perm = "0".$sess_sm_perm;
						}
						$sectionid = decbin($sectionid);
						while(strlen($sectionid) < SITEMGR_PERMISSION_SECTION) {
							$sectionid = "0".$sectionid;
						}
						if (($sess_sm_perm & $sectionid) == $sectionid) {
							return true;
						}
					}
				}
			} 
			
			else {
				return true;
			}
		}
		return false;
	}

	function permission_getSMPermID($i) {
		$permission = constant("SITEMGR_PERMISSION_".$i);
		$permission = explode(",", $permission);
		return $permission[0];
	}

	function permission_getSMPermLabel($i) {
		$permission = constant("SITEMGR_PERMISSION_".$i);
		$permission = explode(",", $permission);
		return $permission[1];
	}

	function permission_getSMPermFolders($i) {
		$permission = constant("SITEMGR_PERMISSION_".$i);
		$permission = explode(",", $permission);
		for ($i=2; $i<count($permission); $i++) {
			$folders[] = $permission[$i];
		}
		return $folders;
	}
	
	function permission_getSMPermActions($i) {
		$permission = constant("SITEMGR_ACTIONS_PERMISSION_".$i);
		$permission = explode(",", $permission);
		for ($i=2; $i<count($permission); $i++) {
			$actions[] = $permission[$i];
		}
		return $actions;
	}
	

	function permission_getSMTable($account_permission) {

		$return = "";

		if (SITEMGR_PERMISSION_SECTION > 0) {

			if ($account_permission) {
				if (!is_array($account_permission)) {
					unset($accountpermission);
					$accountpermission = decbin($account_permission);
					unset($account_permission);
					while(strlen($accountpermission) < SITEMGR_PERMISSION_SECTION) {
						$accountpermission = "0".$accountpermission;
					}
					for ($i=0; $i<SITEMGR_PERMISSION_SECTION; $i++) {
						if ($accountpermission[SITEMGR_PERMISSION_SECTION-$i-1]) {
							$account_permission[] = permission_getSMPermID($i);
						}
					}
				}
			}

			if (strpos($_SERVER["PHP_SELF"], "/gerenciamento/manageaccount.php") === false) {

				$numbercols = 3;

				$returnjsselect = "";
				$returnjsunselect = "";
				
			
				$return .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" class=\"standard-table\">\n";
				$return .= "\t<tr>\n";
				$return .= "\t\t<th colspan=\"".($numbercols*2)."\" class=\"standard-tabletitle\">".system_showText(LANG_SITEMGR_SMACCOUNT_LABEL_SITEMANAGERPERMISSION)."</th>\n";
				$return .= "\t</tr>\n";

			
				$return .= "</table>\n";

				
					$return .= "<div id=\"tree1\">";
		if ($_SESSION[SESS_SM_TYPE] == "admin_local")
		{
			$cidades = $_SESSION[SESS_SM_LOCALIDADE];
			
			$sql_where = array();
			foreach ($cidades as $cidade){
				$sql_where[] = "Location_State.id = $cidade";
			}
		
			if ($sql_where) {
				$sqlwhere .= " ".implode(" OR ", $sql_where)." ";
			}
			
			$sql = "SELECT DISTINCT Location_Country.id, Location_Country.name FROM Location_Country left join Location_State on Location_State.country_id = Location_Country.id WHERE $sqlwhere";
			$db = db_getDBObject();
			$r = $db->query($sql);
			$return .= "<div style=\"color:#7d7d7d; margin-left:25px; font-weight:bold; margin-top:0px;\">";
			$return .= utf8_decode("Por favor, selecione abaixo a região a que a conta terá acesso");
			$return .= "</div>";
			$return .= "<ul>";
			while ($row = mysql_fetch_array($r)) { 
				$return .= "<li id=\"".$row['id']."\"><input type=\"checkbox\" id=\"chb-".$row['id']."\" name=\"selected_items[]\" value=\"".$row['id']."\" />".$row['name']."";
				$return .= "<ul>";
				$sql_cidade = "SELECT id,country_id, name FROM Location_State where country_id = $row[0]";
				$db_cidade = db_getDBObject();
				$r_cidade = $db->query($sql_cidade);
					while ($row_cidade = mysql_fetch_array($r_cidade)) { 
						if (in_array($row_cidade['id'], $cidades)){
							$return .= "<li id=\"".$row_cidade['id']."\"><input type=\"checkbox\" id=\"chb-".$row_cidade['id']."\" name=\"selected_items[]\" value=\"".$row_cidade['id']."\" />".$row_cidade['name']."</li>";
						}
					}
				$return .= "</li>";
				$return .= "</ul>";
			}
		}
		else
		{
			$sql = "SELECT id, name FROM Location_Country";
			$db = db_getDBObject();
			$r = $db->query($sql);
			$return .= "<div style=\"color:#7d7d7d; margin-left:25px; font-weight:bold; margin-top:0px;\">";
			$return .= utf8_decode("Por favor, selecione abaixo a região a que a conta terá acesso");
			$return .= "</div>";
			$return .= "<ul>";
			while ($row = mysql_fetch_array($r)) { 
				$return .= "<li id=\"".$row['id']."\"><input type=\"checkbox\" id=\"chb-".$row['id']."\" name=\"selected_items[]\" value=\"".$row['id']."\" />".$row['name']."";
				$return .= "<ul>";
				$sql_cidade = "SELECT id,country_id, name FROM Location_State where country_id = $row[0]";
				$db_cidade = db_getDBObject();
				$r_cidade = $db->query($sql_cidade);
					while ($row_cidade = mysql_fetch_array($r_cidade)) { 
						$return .= "<li id=\"".$row_cidade['id']."\"><input type=\"checkbox\" id=\"chb-".$row_cidade['id']."\" name=\"selected_items[]\" value=\"".$row_cidade['id']."\" />".$row_cidade['name']."</li>";
					}
				$return .= "</li>";
				$return .= "</ul>";	
			}
		}
		
		$return .= "</ul>";
		$return .= "</div>";
		$return .= "</tr></td>";
				
				$return .= "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\"><tr><td>";
				$return .= "</th>\n";
				$return .= "\t</tr>\n";
				$return .= "</td></tr></table><br/><br/>";
				
				/*		$return .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permissoes:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr></table><table style=\"margin-left:118px; margin-top:-10px\" ><tr>";
						
					for ($i=0; $i<SITEMGR_PERMISSION_SECTION; $i++) {

						if ($i%$numbercols==0) { $return .= "\t<tr>\n"; }
						

				

							$return .= "\t\t<td class=\"td-checkbox\">&nbsp;&nbsp;&nbsp;&nbsp;\n";
							$return .= "\t\t\t<input type=\"checkbox\" name=\"permission[]\" value=\"".permission_getSMPermID($i)."\" id=\"permission".permission_getSMPermID($i)."\" class=\"inputCheck\" ";
							$returnjsselect .= "\t\tdocument.getElementById(\"permission".permission_getSMPermID($i)."\").checked = true;\n";
							$returnjsunselect .= "\t\tdocument.getElementById(\"permission".permission_getSMPermID($i)."\").checked = false;\n";
							if ($account_permission) {
								if (is_array($account_permission)) {
									if (in_array(permission_getSMPermID($i), $account_permission)) {
										$return .= "checked ";
									}
								}
							}
							$return .= "/>&nbsp;\n";
							$return .= "\t\t</td>\n";
							$return .= "\t\t<td>\n";
							$return .= "\t\t\t".permission_getSMPermLabel($i)."\n";
							$return .= "\t\t<br><br></td>\n";

						if ($i%$numbercols==$numbercols-1) { $return .= "\t</tr>\n"; }

					} 

					if (SITEMGR_PERMISSION_SECTION%$numbercols!=0) {
						for ($i=SITEMGR_PERMISSION_SECTION%$numbercols; $i<$numbercols; $i++) {
							$return .= "\t\t<td>&nbsp;</td>\n\t\t<td>&nbsp;</td>\n";
						}
						$return .= "\t</tr>\n";
					}

				$return .= "</table>\n";

			
			
				
				$return .= "<script language=\"javascript\" type=\"text/javascript\">\n";
				$return .= "\tfunction selectAll() {\n";
				$return .= $returnjsselect;
				$return .= "\t}\n";
				$return .= "\tfunction unselectAll() {\n";
				$return .= $returnjsunselect;
				$return .= "\t}\n";
				$return .= "</script>\n";
				$return .= "<div class=\"selectAll\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onClick=\"selectAll();\">".system_showText(LANG_SITEMGR_LABEL_SELECTALL)."</a> / <a href=\"javascript:void(0);\" onClick=\"unselectAll();\">".system_showText(LANG_SITEMGR_LABEL_UNSELECTALL)."</a></div>\n";
*/
			} else {

				if ($account_permission) {
					if (is_array($account_permission)) {
						for ($i=0; $i<SITEMGR_PERMISSION_SECTION; $i++) {
							if (in_array(permission_getSMPermID($i), $account_permission)) {
								$return .= "<input type=\"hidden\" name=\"permission[]\" value=\"".permission_getSMPermID($i)."\" />\n";
							}
						}
					}
				}

			}

		}

		return $return;

	}

?>
