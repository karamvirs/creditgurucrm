<?php


/*******************************************************************************
 * This file is integral part of the project "Installer for Dispage Extension
 * Manager" for SugarCRM.
 * 
 * "Installer for Dispage Extension Manager" is a project created by: 
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2012 DISPAGE.
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

require_once('custom/include/EnhancedManager/XMLManager.php');

class ErrorManager {

	public static $availLanguages = array(
		'en_us',
	);

	public $lang;
	
	function __construct () {

		global $db;

		if (!$db) {
			require_once("custom/include/EnhancedManager/ultraLiteDB.php");
			$db = new ultraLiteDB;
		}
		$this->lang = $this->getLanguage();
	}

	public function crash ($type, $object, $description = '', $msg = '', $params = array()) {

		global $db;

		$callebByEMRequest = (basename($_SERVER['PHP_SELF']) == 'EMRequest.php');

		if ($callebByEMRequest && !headers_sent()) {
			new XMLManager;
		}
		if (!$msg) $msg = $object;

		echo "<error";
		if (isset($params['additionalProps'])) echo " ".$params['additionalProps'];
		echo ">".htmlentities($msg)."</error>";
		
		if (file_exists("custom/include/EnhancedManager/ultraLiteDB.php")) {

			if (!$db) {
				require_once("custom/include/EnhancedManager/ultraLiteDB.php");
				$db = new ultraLiteDB;
			}
			if (file_exists('custom/include/EnhancedManager/ExtensionManager.php')) {
				ErrorManager::saveMsg ($object, $type, $description);
			}
		}
		if ($callebByEMRequest) {
			exit();
		}
	}

	public function getLanguage () {

		if (in_array($_SESSION['authenticated_user_language'], ErrorManager::$availLanguages)) {
			return $_SESSION['authenticated_user_language'];
		}
		else {
			return ErrorManager::$availLanguages[0];
		}
	}

	public function loadAppStrings () {

		global $app_strings;

		ob_start();
		require_once('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManagerInstaller.php');
		if (file_exists('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManager.php')) {
			require_once('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManager.php');
		}
		@ob_end_clean();
	}

	public function manageMessageCode ($params) {

		global $app_strings;

		$this->loadAppStrings();

		$xm = new XMLManager;

		$object = $app_strings['LBL_DISPAGE_MANAGER'][$params['objectCode'].'_OBJECT'];
		$msg = @$params['msgCode'] ? $app_strings['LBL_DISPAGE_MANAGER'][$params['msgCode'].'_MSG'] : $object;

		if (@$params['description']) $description = $app_strings['LBL_DISPAGE_MANAGER'][$params['description']];
		else $description = '';
	
		$description = join('<br/>', array_filter(array($description, @$params['textualDescription'])));

		if (@$params['crash']) {
			if (!@$params['type']) $params['type'] = 3;
			$this->crash ($params['type'], $object, $description, $msg, @$params['additional']);
		}
		else {
			$xml['msg'] = $msg;
			if (isset($params['addElements'])) {
				$xml = array_merge($xml, $params['addElements']);
			}
			echo $xm->array2xml($xml);
			if (!@$params['type']) $params['type'] = 4;
			$this->saveMsg ($object, $params['type'], $description);
		}
	}

	public function saveMsg ($object, $type = 3, $description = '') {

		if (!file_exists('custom/include/EnhancedManager/ExtensionManager.php')) return;

		require_once('custom/include/EnhancedManager/ExtensionManager.php');
		ExtensionManager::addEventLog($type, $object, $description);

	}

	public function loginPopup () {

		unset($_SESSION["em_sent"]);
	}
}
?>
