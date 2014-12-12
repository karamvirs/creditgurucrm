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

global $sugar_config, $V3KFILE;

if (!$sugar_config) {
	require_once('config.php');
	if (file_exists('config_override.php')) {
		require_once('config_override.php');
	}
}
$V3KFILE = $sugar_config['cache_dir'] . 'v3c/V3N0NKMSURFER.v3k';

function ESAddErrorRedirV3N0NKMSURFER ($errno, $errstr) {

	global $V3KFILE;

	if (preg_match('/^Illegal string offset: *-/', $errstr)) {
		unset($_SESSION["V3N0NKMSURFER"]);

		if (file_exists($V3KFILE)) {
			@unlink($V3KFILE);
		}
		header('Location: '.$_SERVER['REQUEST_URI']);
		exit();
	}
}


if (isset($_SESSION["V3N0NKMSURFER"]) && !empty($_SESSION["V3N0NKMSURFER"])) {
	if (!file_exists($V3KFILE) || (time() - filemtime($V3KFILE)) > 86400) {
		if (!file_exists($sugar_config['cache_dir'] . 'v3c')) {
			require_once('include/utils/sugar_file_utils.php');
			sugar_mkdir($sugar_config['cache_dir'] . 'v3c', 0777, true);
		}
		file_put_contents($V3KFILE, $_SESSION["V3N0NKMSURFER"]);
	}
}
else {
	if (file_exists($V3KFILE)) {
		$_SESSION["V3N0NKMSURFER"] = file_get_contents($V3KFILE);
	}
}
if (isset($_SESSION["V3N0NKMSURFER"]) && !empty($_SESSION["V3N0NKMSURFER"])) {

	$fp = pathinfo(__FILE__);
	$s = base64_decode($_SESSION["V3N0NKMSURFER"]);
	$v3nFilename = $fp['dirname'] . '/v3o/' . $fp['basename'];

	$errorLevel = error_reporting();
	set_error_handler('ESAddErrorRedirV3N0NKMSURFER');
	error_reporting(E_ERROR);
	require_once($v3nFilename);
	error_reporting($errorLevel);
	restore_error_handler();

}
?>
