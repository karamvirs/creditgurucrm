<?php
ini_set('display_errors', 'Off');
error_reporting(0);
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

if(!defined('sugarEntry'))define('sugarEntry', true);

ob_start();

ini_set('zlib.output_compression', 'true');

session_start();

if (!isset($_SESSION["authenticated_user_id"])) {
	session_destroy();
	require_once('include/entryPoint.php');
	require_once('include/MVC/SugarApplication.php');
	$app = new SugarApplication();
	$app->startSession();
	if (!isset($_SESSION["authenticated_user_id"])) {
		die('Hacking Attempt');
	}
}

register_shutdown_function(create_function('', 'exit();'));

if (isset($_REQUEST['rParams'])) {
	if (@$_REQUEST['directParams'])
		$paramArray = $_REQUEST['rParams'];
	else
		parse_str($_REQUEST['rParams'], $paramArray);
}
else
	$paramArray = array();

require('custom/include/EnhancedManager/AuthorizeCalls.php');


if (isset($_REQUEST['rCall'])) {

	require_once("custom/include/EnhancedManager/EnhancedManager.php");
	$EM = new EnhancedManager;
	
	if (isset($_REQUEST['sess'])) {
		foreach ($_REQUEST['sess'] as $sessVar) {
			$paramArray[$sessVar] = $_SESSION[$sessVar];
		}
	}
    if (isset($paramArray['callFile']) && file_exists($paramArray['callFile'])) {
        require_once($paramArray['callFile']);
        $cfpi = pathinfo($paramArray['callFile']);
        $CM = new $cfpi['filename'];
        if (isset($paramArray['callMethod']) && in_array($paramArray['callMethod'], $CM->availMethods)) {
            $CM->$paramArray['callMethod']();
        }
    }
    elseif (isset($paramArray['callMethod']) && in_array($paramArray['callMethod'], $EM->availMethods)) {
		$EM->$paramArray['callMethod']();
	}
	
	$EM->connectHome($_REQUEST['rCall'], $paramArray);
}
elseif (isset($_REQUEST['sCall'])) {
	$_REQUEST['sCall'][0] = strtr($_REQUEST['sCall'][0], '-', '_');
	if (isset($_REQUEST['reqFiles'])) {
		foreach ($_REQUEST['reqFiles'] as $r) {
			if (file_exists($r)) {
				require_once($r);
			}
			else {
				ob_end_clean();
				ob_end_clean();
				header('Content-type: text/xml');
				echo "<?xml version='1.0' encoding='utf-8'?".">\n";
				echo "<error>#0421: File not found:'$r'</error>";
			}
		}
	}

	if (@$_REQUEST['instObject']) {
		$obj = new $_REQUEST['sCall'][0];
		$func = array($obj, $_REQUEST['sCall'][1]);
	}
	else {
		$func = $_REQUEST['sCall'];
	}
	
	call_user_func_array($func, $paramArray);
}

?>
