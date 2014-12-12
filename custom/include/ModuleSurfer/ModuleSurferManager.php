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

require_once("custom/include/EnhancedManager/EMLangManager.php");


class ModuleSurferManager {

	public function saveSettings ($module, $settings = '', $disabled = '0') {

		global $db;

		$nowDate = date($GLOBALS['timedate']->get_db_date_time_format());
		$settings = addcslashes(urldecode($settings), "'");
		$outputResult = (basename($_SERVER['PHP_SELF']) == 'EMRequest.php');

		if (self::loadSettings($module)) {
			$addUpdate = $settings ? "settings = '$settings'," : "";
			$db->query("UPDATE dms_saved_layouts SET $addUpdate date_modified = '$nowDate', disabled = $disabled WHERE user_id = '".$_SESSION['authenticated_user_id']."' AND module_name = '$module'");
		}
		else {
			$id = method_exists($db, 'create_guid') ? $db->create_guid() : create_guid();

			$db->query("INSERT INTO dms_saved_layouts (id, user_id, date_entered, date_modified, module_name, settings, disabled) VALUES ('$id', '".$_SESSION['authenticated_user_id']."', '$nowDate', '$nowDate', '$module', '$settings', $disabled)");
		}
		if ($db->last_error) {
			error_log("\n". date("d/m/Y H:i:s")." - Dispage ModuleSurfer - #0470 Error Saving Layout:\n".$db->last_error, 3, "sugarcrm.log");
			if ($outputResult) echo "#0470: Error Saving Layout.";
		}
		else {
			if ($outputResult) echo "OK";
		}
	}

	public function loadSettings ($module) {

		global $db;

		$res = $db->query("SELECT settings, disabled FROM dms_saved_layouts WHERE user_id = '".$_SESSION['authenticated_user_id']."' AND module_name = '$module'");

		if ($settings = $db->fetchByAssoc($res, -1, false)) {
			return $settings;
		}
		else {
			return array();
		}
	}

	public function deleteSettings ($module) {

		global $db;

		$res = $db->query("DELETE FROM dms_saved_layouts WHERE user_id = '".$_SESSION['authenticated_user_id']."' AND module_name = '$module'");

		if ($db->last_error) {
			error_log("\n". date("d/m/Y H:i:s")." - Dispage ModuleSurfer - #0471 Error Restoring Layout to default:\n".$db->last_error, 3, "sugarcrm.log");
			echo "#0471: Error Restoring Layout to default.";
		}
		else {
			echo "OK";
		}
	}

	public function getDefaultLabels () {

		global $app_strings;

		return array(
			'current' => $app_strings['LBL_LISTVIEW_OPTION_CURRENT'],
			'all' => $app_strings['LBL_LISTVIEW_OPTION_ENTIRE'],
			'all_filter' => $app_strings['LBL_LISTVIEW_ALL'],
			'none' => $app_strings['LBL_LISTVIEW_NONE'],
			'yes' => $app_strings['LBL_SEARCH_DROPDOWN_YES'],
			'no' => $app_strings['LBL_SEARCH_DROPDOWN_NO'],
			'selected' => $app_strings['LBL_LISTVIEW_SELECTED_OBJECTS'],
		);
	}
}

?>
