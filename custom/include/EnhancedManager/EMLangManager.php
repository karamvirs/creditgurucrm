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

class EMLangManager {

	public $availLanguages = array(
		'en_us',
	);

	public $lang, $json;


	function __construct () {

		$this->lang = $this->getLanguage();
		$this->json = getJSONobj();
	}

	public function getWelcomeLangs () {

		ob_start();
		if (file_exists('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManager.php')) {
			require_once('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManager.php');
		}
		if (!isset($app_strings['LBL_DISPAGE_MANAGER_WELCOME'])) {
			require_once('custom/Extension/application/Ext/Language/'.$this->lang.'.ExtensionManagerInstaller.php');
		}
		@ob_end_clean();

		return $this->json->encode($app_strings['LBL_DISPAGE_MANAGER_WELCOME']);
	}

	public function getCurLanguage () {

		global $sugar_config;

		if (isset($_SESSION['authenticated_user_language'])) {
			return $_SESSION['authenticated_user_language'];
		}
		require_once('config.php');
		return $sugar_config['default_language'];
	}

	public function getLanguage () {

		$lang = self::getCurLanguage();

		if (in_array($lang, $this->availLanguages)) {
			return $lang;
		}
		else {
			return $this->availLanguages[0];
		}
	}

	public function getJQGridLang () {

		$lang = strtolower(self::getCurLanguage());
		$checks = array_merge(
			array(str_replace('_', '-', $lang)),
			explode('_', $lang)
		);
		foreach ($checks as $l) {
			$langFile = "grid.locale-$l.js";
			if (file_exists("custom/include/EnhancedManager/js/i18n/$langFile")) {
				return $langFile;
			}
		}
		return 'grid.locale-en.js';
	}

}
?>
