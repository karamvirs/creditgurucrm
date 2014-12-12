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

// manifest file for information regarding application of new code
$manifest = array(
  // only install on the following regex sugar versions (if empty, no check)
  'acceptable_sugar_flavors' => array (
),
  'acceptable_sugar_versions' => array(
		'exact_matches' => array(),
		'regex_matches' => array(
            ''
          ),
  ),
 // name of new code
  'name' => 'Installer for Dispage Extension Manager',

  // description of new code
  'description' => 'Connects automatically to Dispage and downloads / installs the last version of DEM.',

  // author of new code
  'author' => 'Dispage - Patrizio Gelosi<support@dispage.com>',

  // date published
  'published_date' => '2012-07-17',

  // unistallable
  'is_uninstallable' => true,

  // version of code
  'version' => '1.0.11f',

  // type of code (valid choices are: full, langpack, module, patch, theme )
  'type' => 'module',

  // icon for displaying in UI (path to graphic contained within zip package)
  'icon' => ''
);

$installdefs = array (
  'id' => 'ExtensionManagerInstaller',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/AuthorizeCalls.php',
      'to' => 'custom/include/EnhancedManager/AuthorizeCalls.php',
    ),
    1 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/css/EnhancedManager.css',
      'to' => 'custom/include/EnhancedManager/css/EnhancedManager.css',
    ),
    2 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/css/EnhancedManager.ie6.7.css',
      'to' => 'custom/include/EnhancedManager/css/EnhancedManager.ie6.7.css',
    ),
    3 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/dbLite.php',
      'to' => 'custom/include/EnhancedManager/dbLite.php',
    ),
    4 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/EMLangManager.php',
      'to' => 'custom/include/EnhancedManager/EMLangManager.php',
    ),
    5 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/EnhancedManager.php',
      'to' => 'custom/include/EnhancedManager/EnhancedManager.php',
    ),
    6 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/ErrorManager.php',
      'to' => 'custom/include/EnhancedManager/ErrorManager.php',
    ),
    7 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/FilePreserve/FilePreserve.php',
      'to' => 'custom/include/EnhancedManager/FilePreserve/FilePreserve.php',
    ),
    8 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/error_icon.png',
      'to' => 'custom/include/EnhancedManager/img/error_icon.png',
    ),
    9 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/etype_err.png',
      'to' => 'custom/include/EnhancedManager/img/etype_err.png',
    ),
    10 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/etype_info.png',
      'to' => 'custom/include/EnhancedManager/img/etype_info.png',
    ),
    11 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/loading.gif',
      'to' => 'custom/include/EnhancedManager/img/loading.gif',
    ),
    12 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/powered-by-dispage.png',
      'to' => 'custom/include/EnhancedManager/img/powered-by-dispage.png',
    ),
    13 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/question.gif',
      'to' => 'custom/include/EnhancedManager/img/question.gif',
    ),
    14 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/question_icon.png',
      'to' => 'custom/include/EnhancedManager/img/question_icon.png',
    ),
    15 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/img/wrn-field.png',
      'to' => 'custom/include/EnhancedManager/img/wrn-field.png',
    ),
    16 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/InstallManager.php',
      'to' => 'custom/include/EnhancedManager/InstallManager.php',
    ),
    17 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/js/em-utilities.js',
      'to' => 'custom/include/EnhancedManager/js/em-utilities.js',
    ),
    18 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/js/emErrorMan.js',
      'to' => 'custom/include/EnhancedManager/js/emErrorMan.js',
    ),
    19 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/js/emLicense.js',
      'to' => 'custom/include/EnhancedManager/js/emLicense.js',
    ),
    20 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/js/emWelcome.js',
      'to' => 'custom/include/EnhancedManager/js/emWelcome.js',
    ),
    21 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/ultraLiteDB.php',
      'to' => 'custom/include/EnhancedManager/ultraLiteDB.php',
    ),
    22 => 
    array (
      'from' => '<basepath>/custom/include/EnhancedManager/XMLManager.php',
      'to' => 'custom/include/EnhancedManager/XMLManager.php',
    ),
    23 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/CHANGES',
      'to' => 'custom/include/jquery/boxy/CHANGES',
    ),
    24 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/LICENSE',
      'to' => 'custom/include/jquery/boxy/LICENSE',
    ),
    25 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/Rakefile',
      'to' => 'custom/include/jquery/boxy/Rakefile',
    ),
    26 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/README',
      'to' => 'custom/include/jquery/boxy/README',
    ),
    27 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/src/images',
      'to' => 'custom/include/jquery/boxy/src/images',
    ),
    28 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/src/javascripts/jquery.boxy.js',
      'to' => 'custom/include/jquery/boxy/src/javascripts/jquery.boxy.js',
    ),
    29 => 
    array (
      'from' => '<basepath>/custom/include/jquery/boxy/src/stylesheets/boxy.css',
      'to' => 'custom/include/jquery/boxy/src/stylesheets/boxy.css',
    ),
    30 => 
    array (
      'from' => '<basepath>/custom/include/jquery/jquery.min.js',
      'to' => 'custom/include/jquery/jquery.min.js',
    ),
    31 => 
    array (
      'from' => '<basepath>/custom/include/utils/ExtensionManagerUtils.php',
      'to' => 'custom/include/utils/ExtensionManagerUtils.php',
    ),
    32 => 
    array (
      'from' => '<basepath>/EMRequest.php',
      'to' => 'EMRequest.php',
    ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/application/app_strings_en_us.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
  ),
);


if (isset($tasks) && !empty($tasks) && preg_match('/^disable_/', $tasks[0])) {
		die('<script language="javascript">
		if (typeof jQuery != "undefined") {
			jQuery("#install_progress_bar").remove();
			jQuery("#displayLoglink").html("Extension Manager Installer cannot be disabled");
		}
		else {
			alert("Extension Manager Installer cannot be disabled");
		}
	</script>');
}
elseif (isset($mode) && $mode == 'Uninstall') {
	global $db;
	$resource = $db->query("SELECT extension_name FROM em_installed");
	while ($result = $db->fetchByAssoc($resource))
			$uninstall_modules_list[] = $result['extension_name'];

	if ($uninstall_modules_list)
			  echo "<br/>The following extensions are still installed:<ul><li>".join('</li><li>', $uninstall_modules_list)."</li></ul><br/><b>This can lead to a malfunction of the SugarCRM application.</b><br/>";
}
