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

	global $sugar_config, $sugar_version;

	if(!defined('sugarEntry'))define('sugarEntry', true);

    $unzip_subdir = preg_replace('#^.*[\\\\/]([^\\\\/]+)$#', '\\1', $_POST['unzip_dir']);

	require_once('include/dir_inc.php');
    require('sugar_version.php');

	$uploadDir = ($sugar_version < '6.4') ? $sugar_config['upload_dir'] : (isset($sugar_config['cache_dir']) ? $sugar_config['cache_dir'] : 'cache/');

	if (!class_exists('FilePreserve')) {
		$fileSource1 = $uploadDir."upgrades/temp/$unzip_subdir/custom/include/EnhancedManager/FilePreserve/FilePreserve.php";
		$fileSource2 = "custom/include/EnhancedManager/FilePreserve/FilePreserve.php";
		if (file_exists($fileSource1)) {
	    	require_once($fileSource1);
		}
		elseif (file_exists($fileSource2)) {
	    	require_once($fileSource2);
		}
		else {
			die("#120: FilePreserve file not found.");
		}
	}

    function pre_uninstall() {

        global $sugar_config;

		$cacheDir = isset($sugar_config['cache_dir']) ? $sugar_config['cache_dir'] : 'cache/';

		$file = new FilePreserve(array('uninstall' => true));

        
require_once("include/utils/sugar_file_utils.php");

$mf = $_POST["unzip_dir"]. "/manifest.php";
if (file_exists($mf)) {
	include($mf);
	foreach ($installdefs["copy"] as $f) {
		if (preg_match('#\.[^/.]+$#', $f["to"]) && !file_exists($f["to"])) {
			@sugar_touch($f["to"]);
		}
	}
}

        $file->addContent('/custom/modules/logic_hooks.php');
				
        $file->addContent('/include/globalControlLinks.php');
				
        $file->addContent('/include/MVC/View/SugarView.php');
				
        $file->addContent('/include/utils.php');
				
        $file->addContent('/modules/Administration/DisplayWarnings.php');
				
        $file->addContent('/modules/UpgradeWizard/preflight.php');
				
        $file->addContent('/modules/Users/authentication/AuthenticationController.php');
				

        rmdir_recursive($cacheDir . 'modules');
        rmdir_recursive($cacheDir . 'smarty');
    }

?>