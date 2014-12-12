<?php


/*******************************************************************************
 * This file is integral part of the project "ModuleSurfer" for SugarCRM.
 * 
 * "ModuleSurfer" is a project created by: 
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2013 DISPAGE.
 * 
 * The contents of this file are released under the GNU General Public License
 * version 3 as published by the Free Software Foundation that can be found on
 * the "LICENSE.txt" file which is integral part of the SUGARCRM(TM) project. If
 * the file is not present, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You may not use the present file except in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Dispage" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Dispage".
 * 
 ******************************************************************************/

require_once('custom/include/ModuleSurfer/data/TSWrapper.php');


class ModuleSurferOptions {

	public static $excludeModules = array('Home', 'Dashboard', 'Calendar', 'Configurator', 'DocumentRevisions', 'Emails', 'EmailMarketing', 'iFrames', 'Feeds', 'EmailTemplates', 'Activities', 'Project', 'ProspectLists', 'Forecasts', 'ModuleBuilder', 'KBDocuments', 'Quotas', 'ReportMaker', 'Reports', 'Studio', 'SugarFeed', 'TeamNotices', 'UpgradeWizard');


	
	public function displayOptions () {

		global $_SESSION, $moduleList, $moduleTabMap, $sugar_config, $current_user;

		require_once('include/utils.php');
		require_once('include/modules.php');
		require_once('config.php');

		require_once('custom/include/utils/EnhancedGraphUtils.php');

		$ts = new TSWrapper();

		$app_strings = return_application_language($lang = $_SESSION['authenticated_user_language']);
		if (!isset($app_strings['LBL_MODULESURFER'])) $app_strings = return_application_language($lang = 'en_us');
		$app_list_strings = return_app_list_strings_language($lang);

		$msLang = $app_strings['LBL_MODULESURFER'];
		$msLangOptions = $msLang['LBL_OPTIONS'];

		$msModules = array_diff(array_merge($moduleList, array_keys($moduleTabMap)), self::$excludeModules);
		sort($msModules);

		$scrollRows = @$sugar_config['dispageModuleSurfer']['global']['scrollRows'] ? $sugar_config['dispageModuleSurfer']['global']['scrollRows'] : 50;
		$msDisableTips = @$sugar_config['dispageModuleSurfer']['global']['disableTips'] ? " checked='checked'" : "";
		$msManualDisableChecked = @$sugar_config['dispageModuleSurfer']['global']['disableManual'] ? " checked='checked'" : "";
		$disableCurrencyRepl = @$sugar_config['dispageModuleSurfer']['global']['disableCurrencyRepl'] ? " checked='checked'" : "";


		if (!$msDisableTips) {
			$globalOptionTooltip = '<span class="em-question-point wtooltip" title="'.$msLangOptions['TIP_GLOBAL'].'"></span>';		
			$moduleTooltip = '<span class="em-question-point wtooltip" title="'.$msLangOptions['TIP_MODULE'].'"></span>';		
		}
		else {
			$globalOptionTooltip = $moduleTooltip = '';
		}

		$res = "
<script language='javascript'>



function msOptionModuleChange () {
	d$('.ms-option-panels').css('display', 'none');
	d$('#ms-option-panel-'+d$('#ms-options-module-selector').val()).css('display', 'block');
}
function msResetForm () {

	document.extoptions.reset();
	if (d$.browser.msie) {
		d$('#ms-options-module-selector').val(d$('#ms-options-module-selector > option:first-child').text());
	}
	msOptionModuleChange();

}


extMan.afterShowOptionCode = 'msOptionModuleChange();';

d$(document).ready( function () {
	GRUtils.addTooltips();
	d$('#em-tabs').tabs({select: function(event, ui) {
		GRUtils.tooltipCheck();
	}});


});
</script>
<form name='extoptions' id='extoptions' method='post'><div id='em-tabs'>
<style>
select {
	font-size: 11px !important;
}
.em-options-title {
	font-size:13px;
	font-weight:bold;
}

.ms-field-container {
	height: 210px;
	overflow-y: auto;
}
.ms-field-inner {
	margin: 6px;
}

#em-tabs a {
	background:none;
}
#em-tabs .em-extoptions-panels {
	margin-top:20px;
}
</style>
	<ul>
		<li><a href='#em-global-options'>{$msLangOptions['LBL_GLOBAL']}</a></li>
		<li><a href='#em-module-specific-options'>{$msLangOptions['LBL_MODULE_SPECIFIC']}</a></li>
	</ul>
	<div id='em-global-options' class='ui-widget-content ui-corner-all em-extoptions-panels'>
		<div class='em-options-title'>{$msLangOptions['LBL_GLOBAL_OPTIONS']}$globalOptionTooltip</div>
		<div class='em-extoptions-line em-extoptions-underline'>
			<div class='em-extoptions-label'>{$msLangOptions['SCROLL_ROWS']}</div>
			<div class='em-extoptions-elem'><input type='text' name='ms_scroll_rows' size='4' value='$scrollRows'/></div>
		</div>";

		$res .= "
		<div class='em-extoptions-line em-extoptions-underline'>
			<div class='em-extoptions-label'>{$msLangOptions['DISABLE_TIPS']}</div>
			<div class='em-extoptions-elem'><input name='ms_disable_tips' type='checkbox' value='1' $msDisableTips/></div>
		</div>
		<div class='em-extoptions-line em-extoptions-underline'>
			<div class='em-extoptions-label'>{$msLangOptions['DISABLE_CHECKING']}</div>
			<div class='em-extoptions-elem'><input name='ms_manual_disable' type='checkbox' value='1' $msManualDisableChecked/></div>
		</div>";

		$res .= "
		<div class='em-extoptions-line em-extoptions-underline'>
			<div class='em-extoptions-label'>" . (isset($msLangOptions['DISABLE_CURRENCY_REPLACEMENT']) ? $msLangOptions['DISABLE_CURRENCY_REPLACEMENT'] : 'Disable currency comma replacement') . "</div>
			<div class='em-extoptions-elem'><input name='ms_disable_currency_repl' type='checkbox' value='1' $disableCurrencyRepl/></div>
		</div>";

		$res .= "
	</div>
	<div id='em-module-specific-options' class='ui-widget-content ui-corner-all em-extoptions-panels'>
		<div class='em-options-title'>{$msLangOptions['LBL_MODULE_SPECIFIC_OPTIONS']}$moduleTooltip</div>
		<div class='em-extoptions-line'>{$msLangOptions['LBL_MODULE']}: <select id='ms-options-module-selector' onchange='msOptionModuleChange()'>";
		foreach ($msModules as $k => $m) {
			$label = isset($app_list_strings['moduleList'][$m]) ? $app_list_strings['moduleList'][$m] : $m;
			$res .= "<option value='$m'>$label</option>";
		}
		$res .= "</select></div>";
		foreach ($msModules as $m) {
			$res .= "<div class='ms-option-panels' id='ms-option-panel-$m' style='display:none;'>
			<div class='em-extoptions-line em-extoptions-underline'>
				<div class='em-extoptions-label'>{$msLang['LBL_TPL']['LBL_DISABLE_MODULESURFER']}</div>
				<div class='em-extoptions-elem'><input name='ms_module_disable[$m]' type='checkbox' value='1'";
			if (@$sugar_config['dispageModuleSurfer'][$m]['disable']) {
				$res .= " checked='checked'";
			}
			$res .= "/></div>
			</div>";
			$res .= "<div class='em-extoptions-line'>{$msLangOptions['SET_READONLY_COLUMNS']}:</div>
			<div class='ms-field-container ui-widget-content ui-corner-all'>
				<div class='ms-field-inner'>";
			$ts->module = $m;
			$prefKey = $current_user->user_name.'_PREFERENCES';
			if (isset($_SESSION[$prefKey]) && isset($_SESSION[$prefKey]['global']) && isset($_SESSION[$prefKey]['global'][$ts->module.'Q'])) {
				$ts->userPreferences = $_SESSION[$prefKey]['global'][$ts->module.'Q'];
			}
			$mod_strings = return_module_language($lang, $m);
			$k = 0;
			foreach ($ts->getDisplayColumns(true, true) as $col => $prop) {
				$colName = @$mod_strings[$prop['label']];
				if (!$colName) $colName = @$app_strings[$prop['label']];
				if (!trim($colName)) $colName = $col;

				$res .= "
					<div class='em-extoptions-line em-extoptions-underline' style='margin-bottom:2px;'>
						<div class='em-extoptions-label'>$colName</div>
						<div class='em-extoptions-elem'><input name='ms_col_readonly[$m][$col]' type='checkbox' value='1'";
				if (@$sugar_config['dispageModuleSurfer'][$m]['readonly'][$col]) {
					$res .= " checked='checked'";
				}
				$res .= "/></div>
					</div>";		
				$k++;
			}
			$res .= "</div>
			</div>
		</div>";


		}
		$res .= "</div>
	<div class='em-extoptions-line em-extoptions-buttons'>
		<div class='em-extoptions-elem'>
			<input class='button' type='button' value='{$app_strings['LBL_SAVE_BUTTON_LABEL']}' onclick='extMan.EMExtOptionsSave();'>
			<input class='button' type='button' value='{$msLangOptions['LBL_RESTORE']}' onclick='msResetForm();'>
			<input class='button' type='button' value='{$app_strings['LBL_CANCEL_BUTTON_LABEL']}' onclick='d$(\".close\").trigger(\"click\");'>
		</div>
	</div>
</div></form>";

		echo $res;
	}

	public function saveOptions () {

		global $sugar_config, $paramArray;

		require("sugar_version.php");
		require_once('include/utils.php');
		require_once('config.php');

		$EMXMLMan = new XMLManager;

		unset($sugar_config['dispageModuleSurfer']);

		if (!isset($sugar_config['dispageModuleSurfer'])) $sugar_config['dispageModuleSurfer'] = array();
		if (!isset($sugar_config['dispageModuleSurfer']['global'])) $sugar_config['dispageModuleSurfer']['global'] = array();

		$sugar_config['dispageModuleSurfer']['global']['scrollRows'] = @$paramArray['ms_scroll_rows'];
		$sugar_config['dispageModuleSurfer']['global']['disableTips'] = @$paramArray['ms_disable_tips'];
		$sugar_config['dispageModuleSurfer']['global']['disableManual'] = @$paramArray['ms_manual_disable'];

		$sugar_config['dispageModuleSurfer']['global']['disableCurrencyRepl'] = @$paramArray['ms_disable_currency_repl'];

		if (@$paramArray['ms_module_disable']) {
			foreach ($paramArray['ms_module_disable'] as $m => $v) {
				@$sugar_config['dispageModuleSurfer'][$m]['disable'] = $v;
			}
		}
		if (isset($paramArray['ms_col_readonly'])) {
			foreach ($paramArray['ms_col_readonly'] as $m => $col) {
				foreach ($col as $n => $v) {
					if ($v != 'default') $sugar_config['dispageModuleSurfer'][$m]['readonly'][$n] = $v;

				}
			}
		}
		if(!rebuildConfigFile($sugar_config, $sugar_version)) {
			$xmlArray['error'] = "Unable to write into config file";
		}
		else {
			$xmlArray['msg'] = "OK";
		}
		echo $EMXMLMan->array2xml($xmlArray);
	}
}

?>
