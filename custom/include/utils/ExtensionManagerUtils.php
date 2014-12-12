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

global $sugar_version;

require("sugar_version.php");
require_once('include/utils.php');
require_once("include/utils/file_utils.php");
require_once("include/Localization/Localization.php");


class ExtensionManagerUtils {

	public function recursiveConfigMerge ($c, $keys = array()) {

		if (is_array($c)) {
			foreach ($c as $k => $v) {
				self::recursiveConfigMerge($v, array_merge($keys, array("'$k'")));
			}
		}
		else {
			eval("@\$GLOBALS['sugar_config'][".join("][", $keys)."] = '".addcslashes($c, "'")."';");
		}
	}
	
	public function saveConfig ($config) {

		global $sugar_config, $sugar_version;

		self::recursiveConfigMerge($config);
		rebuildConfigFile($sugar_config, $sugar_version);
	}

		
	public function deleteConfig ($list) {

		global $sugar_config, $sugar_version;

		foreach ($list as $l) {
			eval("unset($l);");
		}
		rebuildConfigFile($sugar_config, $sugar_version);
	}

}
