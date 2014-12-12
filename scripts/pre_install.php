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
    require_once($uploadDir."upgrades/temp/$unzip_subdir/scripts/pre_uninstall.php");
    
    function pre_install() {

        global $db, $sugar_config;

		$cacheDir = isset($sugar_config['cache_dir']) ? $sugar_config['cache_dir'] : 'cache/';
       
        $file = new FilePreserve(array('source_dir' => preg_replace('#[\\\\/]+#', '/', $_POST['unzip_dir']), 'ignore_modulename' => true));

        		global $db;
		
		if (!$db->query("SELECT * FROM em_installed")) {
           $db->query($db->getHelper()->createTableSQLParams(
                "em_installed",
                array(
                    'id' => 
                        array (
                            'name' => 'id',
                            'type' => 'char',
                            'len' => 36,
                            'required'=>true,
                        ),
                    'sub_id' => 
                        array (
                            'name' => 'sub_id',
                            'type' => 'char',
                            'len' => 36,
                            'required'=>true,
                        ),
                   'parent_id' => 
                        array (
                            'name' => 'parent_id',
                            'type' => 'char',
                            'len' => 36,
                            'required'=>false,
                        ),
                        
                    'ntype' => 
                        array (
                            'name' => 'ntype',
                            'type' => 'tinyint',
                            'len' => 4,
                            'required'=>true,
                        ),
                    'extension_name' => 
                        array (
                            'name' => 'extension_name',
                            'type' => 'varchar',
                            'len' => 96,
                            'required'=>true,
                        ),
                    'relase' => 
                        array (
                            'name' => 'relase',
                            'type' => 'varchar',
                            'len' => 32,
                            'required'=>true,
                        ),
                    'version' => 
                        array (
                            'name' => 'version',
                            'type' => 'varchar',
                            'len' => 16,
                            'required'=>true,
                        ),
                    'installed' => 
                        array (
                            'name' => 'installed',
                            'type' => 'datetime',
                            'required'=>true,
                        ),
                    'updated' => 
                        array (
                            'name' => 'updated',
                            'type' => 'datetime',
                            'required'=>false,
                        ),
                    'expires' => 
                        array (
                            'name' => 'expires',
                            'type' => 'datetime',
                            'required'=>false,
                        ),
                    'extension_path' => 
                        array (
                            'name' => 'extension_path',
                            'type' => 'varchar',
                            'len' => 255,
                            'required'=>true,
                        ),
                    'description' => 
                        array (
                            'name' => 'description',
                            'type' => 'text',
                            'required'=>false,
                        ),
                    'add_info' => 
                        array (
                            'name' => 'add_info',
                            'type' => 'text',
                            'required'=>false,
                        ),
                ),
                array(
                    array('name' =>'primary_id', 'type' =>'primary', 'fields'=>array('id')),
                )
            ), true, "#110 Error during Installation : Unable to create table 'em_installed'");
        }
		if (!$db->query("SELECT * FROM em_events")) {
            $db->query($db->getHelper()->createTableSQLParams(
                "em_events",
                array(
                    'id' => 
                        array (
                            'name' => 'id',
                            'type' => 'char',
                            'len' => 36,
                            'required'=>true,
                        ),
                    'etype' => 
                        array (
                            'name' => 'etype',
                            'type' => 'tinyint',
                            'len' => 4,
                            'required'=>true,
                        ),
                    'eobject' => 
                        array (
                            'name' => 'eobject',
                            'type' => 'varchar',
                            'len' => 255,
                            'required'=>true,
                        ),
                     'etime' => 
                        array (
                            'name' => 'etime',
                            'type' => 'datetime',
                            'required'=>true,
                        ),
                     'description' => 
                        array (
                            'name' => 'description',
                            'type' => 'text',
                            'required'=>false,
                        ),
                ),
                array(
                    array('name' =>'primary_id', 'type' =>'primary', 'fields'=>array('id')),
                )
            ), true, "#110 Error during Installation : Unable to create table 'em_events'");
        }

		$file->addContent('/custom/modules/logic_hooks.php', array (
  'TAG 0121r75v' => 
  array (
    'content' => '    $enhancedManagerFile = "custom/include/EnhancedManager/EnhancedManager.php";
    $hook_array[\'after_login\'][] = Array(5, \'\', $enhancedManagerFile,\'EnhancedManager\', \'loginCheck\');
',
    'add_bottom' => '1',
  ),
) );

		
		$file->addContent('/include/globalControlLinks.php', array (
  'TAG 0121r759' => 
  array (
    'regexp' => '(\\$global_control_links\\[\'employees\'\\]\\s*=\\s*array\\(\\s*)',
    'content' => ' if (isset($_SESSION["topmenu_em"])) eval($_SESSION["topmenu_em"]);
',
    'put_back' => '1',
  ),
) );

		$tmpArray = array();
if ($GLOBALS['sugar_version'] >= '5.5.0') {
$tmpArray = array_merge($tmpArray, array (
  'TAG 0121r753' => 
  array (
    'regexp' => '(\\s*\\$this->_?trackView\\(\\);\\s*)',
    'content' => '        if(isset($_SESSION[\'opening_em\'])) eval($_SESSION[\'opening_em\']);
',
    'put_back' => '1',
  ),
  'TAG 0121r754' => 
  array (
    'regexp' => '(\\s*\\$this->includeClassicFile\\(\'modules\\/Administration\\/DisplayWarnings\\.php\'\\);\\s*)',
    'content' => '        if(isset($_SESSION[\'header_css_en\'])) eval($_SESSION[\'header_css_en\']);
',
    'put_back' => '1',
  ),
  'TAG 0121r755' => 
  array (
    'regexp' => '(\\s*if\\s*\\(\\$this->_getOption\\(\'show_javascript\'\\)\\)\\s*\\{\\s*)',
    'content' => '            if(isset($_SESSION[\'header_js_en\'])) eval($_SESSION[\'header_js_en\']);
',
  ),
));

}
if ($GLOBALS['sugar_version'] < '5.5.0') {
$tmpArray = array_merge($tmpArray, array (
  'TAG 0121r74r' => 
  array (
    'regexp' => '(\\s*function\\s*displayCSS\\(\\)\\s*\\{\\s*)',
    'content' => '        if(isset($_SESSION[\'opening_em\'])) eval($_SESSION[\'opening_em\']);
',
  ),
  'TAG 0121r74s' => 
  array (
    'regexp' => '(\\s*if\\s*\\(\\$this->_getOption\\(\'show_header\'\\)\\)\\s*\\{\\s*echo\\s*"<html><head>";\\s*\\}\\s*if\\s*\\(\\$this->_getOption\\(\'show_javascript\'\\)\\)\\s*\\{\\s*)',
    'content' => '            if(isset($_SESSION[\'header_js_en\'])) eval($_SESSION[\'header_js_en\']);
',
  ),
));

}

		$file->addContent('/include/MVC/View/SugarView.php', $tmpArray );

		$tmpArray = array();
if ($GLOBALS['sugar_version'] >= '6.2') {
$tmpArray = array_merge($tmpArray, array (
  'TAG 0121r7bi' => 
  array (
    'regexp' => '(require_once\\(\'include\\/utils\\/security_utils\\.php\'\\);\\s*)',
    'content' => 'if (file_exists(\'include/SugarCache/SugarCache.php\')) {
    require_once(\'include/SugarCache/SugarCache.php\');
}
',
  ),
));


		$file->addContent('/include/utils.php', $tmpArray );

		}


		$file->addContent('/modules/Administration/DisplayWarnings.php', array (
  'TAG 0121r761' => 
  array (
    'regexp' => '(\\s*unset\\(\\$_SESSION\\[\'administrator_error\'\\]\\);\\s*\\}\\s*)',
    'content' => 'if (isset($_SESSION["authenticated_user_id"])) {
 
        if(isset($_SESSION[\'ENM_start_up\'])) 
            eval($_SESSION[\'ENM_start_up\']);
        else
            displayAdminError(\'Could not connect to the Dispage Resource Center\');
}
',
  ),
) );

		
		$file->addContent('/modules/UpgradeWizard/preflight.php', array (
  'TAG 0121r7bx' => 
  array (
    'regexp' => '(\\s*\\$uwMain\\s*=\\s*\\$final\\.\\$form5;\\s*)',
    'content' => '    if (file_exists(\'custom/include/EnhancedManager/EnhancedManager.php\')) {
        $EMWarning = isset($GLOBALS[\'app_strings\'][\'LBL_DISPAGE_MANAGER\'][\'LBL_UPGRADE_WARNING\']) ? $GLOBALS[\'app_strings\'][\'LBL_DISPAGE_MANAGER\'][\'LBL_UPGRADE_WARNING\'] : "<span class=\'error\'><b>WARNING! One or more dispage extensions have not been uninstalled: this may lead to malfunctions after the SugarCRM upgrade.</b></span><br><br>Please follow <a style=\'font-size:11px;\'  href=\'http://www.dispage.com/wiki/Support:Upgrade_SugarCRM\' target=\'_blank\'>this link</a> for more details." ;
        $final = preg_replace(\'#<td [^>]*>&nbsp;</td>#\', $EMWarning, $final);
        if (strpos($final, $EMWarning) === false) $final .= $EMWarning;
    }
',
    'put_back' => '1',
  ),
) );

		
		$file->addContent('/modules/Users/authentication/AuthenticationController.php', array (
  'TAG 0121r764' => 
  array (
    'regexp' => '(\\s*\\$GLOBALS\\[\'module\'\\]\\s*=\\s*\'Users\';\\s*)',
    'content' => '                if(file_exists(\'custom/include/EnhancedManager/EnhancedManager.php\')) {
                    require_once(\'custom/include/EnhancedManager/EnhancedManager.php\');
                    $EM = new EnhancedManager;
                    $EM->loginCheck();
                }
',
    'put_back' => '1',
  ),
) );

		

        rmdir_recursive($cacheDir . 'modules');
        rmdir_recursive($cacheDir . 'smarty');

    }

?>
