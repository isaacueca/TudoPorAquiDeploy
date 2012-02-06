<?
    include("../../conf/loadconfig.inc.php");

    # ----------------------------------------------------------------------------------------------------
    # SESSION
    # ----------------------------------------------------------------------------------------------------
    sess_validateSMSession();
    permission_hasSMPerm();
	check_action_permission('relatorio_de_estatistica', 'view');

    # ----------------------------------------------------------------------------------------------------
    # CODE
    # ----------------------------------------------------------------------------------------------------
    $chartColors     = array();
    $chartColors[1]  = "336699";
    $chartColors[2]  = "6699CC";
    $chartColors[3]  = "339933";
    $chartColors[4]  = "00CC00";
    $chartColors[5]  = "CC3300";
    $chartColors[6]  = "FF6600";
    $chartColors[7]  = "FF9933";
    $chartColors[8]  = "CC9966";
    $chartColors[9]  = "999999";
    $chartColors[10]  = "996699";
    $chartColors[11] = "9999FF";
    $chartColors[12] = "339999";
    $chartColors[13] = "A5A469";
    $chartColors[14] = "000000";
    $chartColors[15] = "666666";

    $listing_ids[] = "";
  /*  $modules[] = "l";
    if(EVENT_FEATURE == "on")       $modules[] = "e";
    if(CLASSIFIED_FEATURE == "on")  $modules[] = "c";
    if(ARTICLE_FEATURE == "on")     $modules[] = "a"; */

    # ----------------------------------------------------------------------------------------------------
    # GET DATABASE
    # ----------------------------------------------------------------------------------------------------
    $db = db_getDBObject();

	# ----------------------------------------------------------------------------------------------------
	# HEADER
	# ----------------------------------------------------------------------------------------------------
	include(SM_EDIRECTORY_ROOT."/layout/header_manager.php");
?>


<div id="page-wrapper">

	<div id="main-wrapper">
	
	<?php 	include(SM_EDIRECTORY_ROOT."/menu.php"); ?>
	
		<div id="main-content"> 

			<div class="page-title ui-widget-content ui-corner-all">

				<div class="other_content">

        <? require(EDIRECTORY_ROOT."/gerenciamento/registration.php"); ?>

        <?
            $sql = "SELECT DISTINCT YEAR(`day`) AS `year` FROM `Report_Statistic` ORDER BY `year` DESC";
            $result = mysql_query($sql);        
            $years = array();
            if($result){
                while($row = mysql_fetch_array($result)) {
                    $years[] = $row['year'];
                }
            }
            
             if (($_GET["year"]) && ($_GET['month']) && is_numeric($_GET["year"]) && is_numeric($_GET['month'])) {
            }
            else
            {
                 $_GET["year"] = date("Y"); 
        $_GET['month'] = date("m")-1;
            }
        ?>
        
        <? if(count($years) > 0) { ?>
        <div class="reportPeriod">
				<form name='searchStatistReport' method='get'>
				<table class="reportForm" cellpadding="0" cellspacing="0">
					<tr>
					
						<td class="right" valign="top">
	<label><?=system_showText(LANG_SITEMGR_REPORT_LABEL_MONTH)?>: </label>
																			<select name='month'>
												<option value='1'  <?=($_GET['month'] ==  1) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_JANUARY)?></option>
												<option value='2'  <?=($_GET['month'] ==  2) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_FEBRUARY)?></option>
												<option value='3'  <?=($_GET['month'] ==  3) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_MARCH)?></option>
												<option value='4'  <?=($_GET['month'] ==  4) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_APRIL)?></option>
												<option value='5'  <?=($_GET['month'] ==  5) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_MAY)?></option>
												<option value='6'  <?=($_GET['month'] ==  6) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_JUNE)?></option>
												<option value='7'  <?=($_GET['month'] ==  7) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_JULY)?></option>
												<option value='8'  <?=($_GET['month'] ==  8) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_AUGUST)?></option>
												<option value='9'  <?=($_GET['month'] ==  9) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_SEPTEMBER)?></option>
												<option value='10' <?=($_GET['month'] == 10) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_OCTOBER)?></option>
												<option value='11' <?=($_GET['month'] == 11) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_NOVEMBER)?></option>
												<option value='12' <?=($_GET['month'] == 12) ? "selected='selected'" : ""; ?>><?=system_showText(LANG_SITEMGR_REPORT_DECEMBER)?></option>
										</select>

										<label><?=system_showText(LANG_SITEMGR_REPORT_LABEL_YEAR)?>: </label>
										<select name='year'>
												<? foreach($years as $year) { ?>
														<option value='<?=$year;?>' <?=($_GET['year'] == $year) ? "selected='selected'" : ""; ?>><?=$year;?></option>
												<? } ?>
										</select>
											
										
								
						</td>
						<td class="right">
							<button class="ui-state-default ui-corner-all" value="Submit" name="changelogin" type="submit">Buscar</button>
						</td>
					</tr>
				</table>
				</form>
			</div>
        <? } else { ?>
            <div class="response-msg inf ui-corner-all"><?=system_showText(LANG_SITEMGR_REPORT_REPORTEMPTYMESSAGE)?></div>
        <? } 
       
       
        ?>

        <? if (($_GET["year"]) && ($_GET['month']) && is_numeric($_GET["year"]) && is_numeric($_GET['month'])) {
                $sql = "SELECT title, `listing_id`, SUM(`detail_view`) AS quantity FROM `Report_Listing_Monthly` inner join `Listing` on Listing.id = Report_Listing_Monthly.listing_id WHERE YEAR(`day`) = '".$_GET["year"]."' AND MONTH(`day`) = '".$_GET["month"]."' GROUP BY `listing_id` ORDER BY `quantity` DESC LIMIT 0, 30 ";
                $result = mysql_query($sql);
                if($result) {
                   ?>
                    <div id="module_<?=$listing_id;?>" >
                        <div class='default-report'>
                            <table cellpadding='0' cellspacing='0' border='1' class='highlight-report'>
                                <tbody>
                                        <tr>
                                            <td class='right'>
                                                <table cellpadding="2" cellspacing="2" class="">
                                                    <?
                                                    while($row = mysql_fetch_array($result)) {
                                                        echo "<tr><td>", $row["title"], '</td><td>&nbsp;&nbsp;<b>',$row["quantity"], '</b></td></tr>';
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <? } } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="clearfix"></div>

<?

    # ----------------------------------------------------------------------------------------------------
    # FOOTER
    # ----------------------------------------------------------------------------------------------------
    include(SM_EDIRECTORY_ROOT."/layout/footer.php");
?>