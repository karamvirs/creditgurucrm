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

$authorized = false;
$notAuthorized = true;

if (isset($_REQUEST['rCall'])) {
	switch ($_REQUEST['rCall']) {
		case 'followtwr': $authorized = true; break;
		case 'redpill': case 'theconstruct': $authorized = isset($_REQUEST['rParams']); break;
	}
}
elseif (isset($_REQUEST['sCall'])) {
	if (isset($_REQUEST['reqFiles'])) {
		if (!array_diff( $_REQUEST['reqFiles'],
			array(
			'custom/include/EnhancedManager/ErrorManager.php', 
			'custom/include/EnhancedManager/ExtensionManager.php', 
			'custom/include/EnhancedManager/InstallManager.php',
			'custom/include/EnhancedManager/dbLite.php'
			)
		)) {
			$authorized = true;
		}
	}
}
if (isset($paramArray['callFile']) && $paramArray['callFile'] == 'custom/include/EnhancedStudio/EnhancedStudioAdvanced.php') {
	$notAuthorized = false;
}
/* BEGIN ModuleSurfer ::TAG 0121r75k:: */
if (isset($_REQUEST['sCall'])) {
    if (isset($_REQUEST['reqFiles'])) {
        if (!array_diff( $_REQUEST['reqFiles'],
            array(
            'custom/include/ModuleSurfer/data/TSWrapper.php',
            'custom/include/ModuleSurfer/ModuleSurferManager.php',
            'custom/include/EnhancedManager/dbLite.php',
            'custom/include/ModuleSurfer/options.php', 
            )
        )) {
            $authorized = true;
        }
    }
}
/* END ModuleSurfer ::TAG 0121r75k:: */ 



if (!$authorized) {
	
require_once('custom/include/EnhancedManager/ErrorManager.php');
	ErrorManager::crash(3, 'Connection Error', "Request to '".@$_REQUEST['sCall'][0].@$_REQUEST['rCall']."' unauthorized");
}
if (!isset($paramArray['callFile'])) {
	$notAuthorized = false;
}		
if ($notAuthorized) {
	require_once('custom/include/EnhancedManager/ErrorManager.php');
	ErrorManager::crash(3, 'Connection Error', "Request to '".$paramArray['callFile']."' unauthorized");
}
?>