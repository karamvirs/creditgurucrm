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

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

if (isset($GLOBALS['js_version_key'])) {
	return;
}
global $sugar_config, $error_notice, $use_current_user_login, $module_menu, $db, $locale, $timedate, $current_user, $current_entity;

$GLOBALS['starttTime'] = microtime(true);

set_include_path(
    dirname(__FILE__) . '/../../..' . PATH_SEPARATOR .
    get_include_path()
);


require_once('config.php');

if(is_file('config_override.php')) {
	require_once('config_override.php');
}


require_once 'include/SugarObjects/SugarConfig.php';

require_once('include/utils.php');
clean_special_arguments();
clean_incoming_data();

setPhpIniSettings();

require_once('sugar_version.php');
if (file_exists('include/database/PearDatabase.php')) require_once('include/database/PearDatabase.php');
require_once('include/database/DBManager.php');
require_once('include/database/DBManagerFactory.php');

require_once('include/Localization/Localization.php');

require_once('include/SugarLogger/LoggerManager.php');

require_once('include/modules.php');
require_once('data/SugarBean.php');
require_once('include/SugarObjects/VardefManager.php');
require_once('include/SugarEmailAddress/SugarEmailAddress.php');
if ($sugar_version > '6.4') require_once('include/utils/sugar_file_utils.php');
require_once('include/Sugar_Smarty.php');
require_once('include/utils/LogicHook.php');

require_once('modules/UserPreferences/UserPreference.php');
require_once('modules/Users/User.php');

require_once('include/TimeDate.php');

require_once('include/utils/file_utils.php');

if (!defined('SUGAR_PATH')) {
    define('SUGAR_PATH', realpath(dirname(__FILE__) . '/../../..'));
}
require_once(SUGAR_PATH . '/include/SugarObjects/SugarRegistry.php');


$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');
$error_notice = '';
$use_current_user_login = false;
$module_menu = array();

if(isset($_GET['PHPSESSID'])){
    if(!empty($_COOKIE['PHPSESSID']) && strcmp($_GET['PHPSESSID'],$_COOKIE['PHPSESSID']) == 0) {
        session_id($_REQUEST['PHPSESSID']);
    }else{
        unset($_GET['PHPSESSID']);
    }
}
if(!empty($sugar_config['session_dir'])) {
	session_save_path($sugar_config['session_dir']);
}

$db = DBManagerFactory::getInstance();
$db->resetQueryCount();
$locale = new Localization();

$timedate = new TimeDate();

if (!isset ($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = '';
}
if ($GLOBALS['sugar_version'] > '6.2') {
	require_once('include/SugarObjects/LanguageManager.php');
}
$current_user = new User();
$current_entity = null;

$GLOBALS['sugar_version'] = $sugar_version;
$GLOBALS['sugar_flavor'] = $sugar_flavor;
$GLOBALS['timedate'] = $timedate;
$GLOBALS['js_version_key'] = md5($GLOBALS['sugar_config']['unique_key'].$GLOBALS['sugar_version']);

?>
