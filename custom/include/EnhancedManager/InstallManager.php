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

global $sugar_config;
require_once('config.php');
require_once('include/dir_inc.php');
require_once('include/utils/sugar_file_utils.php');

class InstallManager {

	private $package;
	private $res2Validate = array();

	function __construct () {

		if (!isset($_SESSION['em_ext2install'])) {
			$_SESSION['em_ext2install'] = array();
		}
		if (isset($_SESSION['uninstall_aborted'])) {
			$this->loadDb();
			$this->removeFromTable(array('id' => $_SESSION['uninstall_aborted']));
			unset($_SESSION['uninstall_aborted']);
		}
		elseif ((!isset($GLOBALS['log']) || !$GLOBALS['log'] || !is_object($GLOBALS['log'])) && class_exists('LoggerManager')) {
			$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');
		}
	}

	private function loadDb () {

		global $db;

		if ($db) return;
		require_once('custom/include/EnhancedManager/ultraLiteDB.php');
		$db = new ultraLiteDB;
	}

	public function getUploadDir () {

		global $sugar_config, $sugar_version;

		if (!isset($sugar_version)) require('sugar_version.php');

		return ($sugar_version < '6.4') ? $sugar_config['upload_dir'] : (isset($sugar_config['cache_dir']) ? $sugar_config['cache_dir'] : 'cache/');
	}

	public function savePackage ($filename, $content) {

		$uploadDir = $this->getUploadDir();

		if (!file_exists($uploadDir)) {
			require_once('dir_inc.php');
			mkdir_recursive($uploadDir);
		}
		$filename = $uploadDir . $filename;
		if (file_exists($filename)) unlink($filename);
		file_put_contents($filename, $content);
	}

	public function & getNextPackage () {

		if (isset($_SESSION['em_ext2install']) && isset($_SESSION['em_ext2install'][0])) {
			return $_SESSION['em_ext2install'][0];
		}
		return array();
	}

	public function shiftNextPackage () {

		$res = array_shift($_SESSION['em_ext2install']);
		$this->deletePackage($res['ext_id']);

		return $res;
	}

	public function addPackage ($params) {

		foreach ($_SESSION['em_ext2install'] as &$package) {
			if (@$package['ext_id'] == @$params['ext_id']) {
				$package = $params;
				return;
			}
		}
		array_unshift($_SESSION['em_ext2install'], $params);
	}

	public function echoInstallingPackage ($params) {

		global $sugar_config, $EMXMLMan;

		if (!$EMXMLMan) {
			require_once("custom/include/EnhancedManager/XMLManager.php");
			$EMXMLMan = new XMLManager;
		}
		if (!isset($params['extension_name']) || !$params['extension_name']) {
			require_once('custom/include/EnhancedManager/ErrorManager.php');
			$erm = new ErrorManager;
			$erm->loadAppStrings();
			echo $EMXMLMan->array2xml(array('msg' => $GLOBALS['app_strings']['LBL_DISPAGE_MANAGER_WELCOME']['updateCompleteMsg']));
			return;
		}
		$this->loadDb();
		$upgrade = $this->getPackageFromDB($params['ext_id']);

		if (isset($params['add_info']) && preg_match('/ForceURI *= *([^;]+);/', $params['add_info'], $capURI)) {
			$packageURI = $capURI[1];
		}
		else {
			$packageURI = strtolower(str_replace(' ', '-', $params['extension_name']));
		}
		$xmlArray['package'] = "<br/><b><a href='http://www.dispage.com/products/$packageURI' target='_blank'><span id='emsu-extension-name'>$params[extension_name]</span></a>";

		if (isset($params['add_info'])) {
			$nLic = preg_match_all('/LicenseResource *(?>\[ *([^\]]*) *\] *)?= *([^;]+);/', $params['add_info'], $capture, PREG_SET_ORDER);
			if (!$upgrade || preg_match('/ForceLicense *;/', $params['add_info']) || $nLic > 1) {
				if ($capture[0][1]) {
					foreach ($capture as $c) {
						if ($c[1] == $params['extens_version']) {
							unset($xmlArray['license_urls']);
							break;
						}
						$xmlArray['license_urls'][] = array(
							'version_name' => $c[1], 
							'version_license' => $c[2], 
						);
					}
					if (isset($xmlArray['license_urls']) && preg_match('/VersionInfo *= *([^;]+);/', $params['add_info'], $capVer)) {
						$xmlArray['version_info'] = $capVer[1];
					}
				}
				elseif ($capture[0][2]) {
					$xmlArray['license'] = $capture[0][2];
				}
			}
			if (isset($xmlArray['license_urls'])) {
				$xmlArray['old_version'] = $params['extens_version'];
			}
			else {
				$xmlArray['package'] .= " $params[extens_version]";
				if (!@$sugar_config['dispageExtMan']['serials'][$params['subrel_id']]) {
					$xmlArray['new_version'] = $params['extens_version'];
				}
			}
			if (!@$sugar_config['dispageExtMan']['environment'] && preg_match('/\b(?>paid|demo)\b/', $params['extens_version'])) {
				$xmlArray['ask_environment'] = 1;
			}
			$xmlArray['package'] .= "</b><br/>Release: $params[subrel_name]";
			if (preg_match('/ChangelogResource *= *([^;]+);/', $params['add_info'], $capture)) {
				$xmlArray['package'] .= " (Check the <a href=\"$capture[1]\" target=\"_blank\">Changelog</a>)"; 
			}
		}
		else {
			$xmlArray['package'] .= " $params[extens_version]</b><br/>ver. $params[subrel_name]";
		}
		$xmlArray['package'] .= "<br/>";

		if (@$params['warning']) {
			$xmlArray['warning'] = $params['warning'];
		}
		if ($upgrade) {
			$xmlArray['is_upgrade'] = 1;
		}
		if (count($_SESSION['em_ext2install']) > 1) {
			$xmlArray['get_next'] = '';
		}
		echo $EMXMLMan->array2xml($xmlArray);
	}

	public function movePackage ($packageId) {

		foreach ($_SESSION['em_ext2install'] as $k => $package) {
			if ($package['ext_id'] == $packageId) {
				array_splice($_SESSION['em_ext2install'], 0, 0, array_splice($_SESSION['em_ext2install'], $k, 1));
				break;
			}
		}
	}

	public function deletePackage ($packageId) {

		$_SESSION['em_ext2install'] = array_filter($_SESSION['em_ext2install'], create_function('$v', 'return @$v["ext_id"] != "'.$packageId.'";'));
	}

	public function addRes2Validate ($IMCopy) {

		foreach ($IMCopy as $res) {
			if (preg_match('/\.(?>js|css)$/i', $res['to'])) {
				$this->res2Validate[] = $res['to'];
			}
		}
	}

	public function echoNextPackage ($packageId = '') {

		if ($packageId) {
			$this->movePackage($packageId);
		}
		$this->echoInstallingPackage($this->getNextPackage());
	}

	public function downloadNextPackage ($params = array()) {

		global $app_strings, $sugar_config, $current_user;

		require_once('custom/include/EnhancedManager/EnhancedManager.php');
		require_once('custom/include/EnhancedManager/ErrorManager.php');

		$em = new EnhancedManager;
		$erm = new ErrorManager;

		$this->package = & $this->getNextPackage();

		if (isset($params['env']) && $params['env'] || isset($params['serial']) && $params['serial']) {
			require_once('custom/include/utils/ExtensionManagerUtils.php');

			if (isset($params['env']) && $params['env']) $newConfig['dispageExtMan']['environment'] = $params['env'];
			if (isset($params['serial']) && $params['serial'] && $this->package['subrel_id']) $newConfig['dispageExtMan']['serials'][$this->package['subrel_id']] = $params['serial'];

			ExtensionManagerUtils::saveConfig($newConfig);
		}
		if (!@$params['env'] && @$sugar_config['dispageExtMan']['environment']) {
			$params['env'] = $sugar_config['dispageExtMan']['environment'];
		}
		if (@$params['env'] != 'production') {
			$uData = $em->getUserData($_SESSION['authenticated_user_id']);
			$params['uname'] = $uData['user_name'];
		}
		require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManagerInstaller.php');
		if (file_exists('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManager.php')) {
			require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManager.php');
		}
		if (@$params['ver']) {
			$this->package['extens_version'] = $params['ver'];
		}
		else {
			$params['ver'] = $this->package['extens_version'];
		}
		$this->savePackage($this->package['filename'], $em->getRemoteFile($this->package['subrel_id'], $error, $params));

		if ($error) {
			$erm->manageMessageCode(array(
				'objectCode' => $error,
				'crash' => 1,
			));
		}
		else {
			$erm->manageMessageCode(array(
				'objectCode' => 'LBL_DOWNLOADED_SUCCESSFULLY',
				'textualDescription' => sprintf($app_strings['LBL_DISPAGE_MANAGER']['LBL_DOWNLOADED_PACKAGE'], $this->package['extension_name'].' '.$this->package['subrel_name']),
			));
		}
	}

	public function installNextPackage () {

		global $sugar_config, $app_strings;

		require_once('custom/include/EnhancedManager/ErrorManager.php');

		$erm = new ErrorManager;

		try {
			$package = $this->shiftNextPackage();
			$this->uninstallPackage($package['ext_id'], true);
			$this->package = $package;
			$this->installPackage();
		}
		catch (Exception $e) {

			$erm->manageMessageCode(array(
				'objectCode' => 'LBL_INSTALLED_WITH_ERROR',
				'crash' => 1,
				'description' => $php_errormsg
			));
		}

		ob_start();
		require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManager.php');
		require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManagerInstaller.php');
		@ob_end_clean();

		$msgParams = array(
			'objectCode' => 'LBL_INSTALLED_SUCCESSFULLY',
			'textualDescription' => sprintf($app_strings['LBL_DISPAGE_MANAGER']['LBL_INSTALLED_PACKAGE'], $this->package['extension_name'].' '.$this->package['subrel_name']),
		);
		if ($this->res2Validate) {
			$msgParams['addElements'] = array('res2val' => $this->res2Validate);
		}
		$erm->manageMessageCode($msgParams);
	}

	private function execScript ($unzipDir, $scriptName, $evalAs = '') {

		$file = "$unzipDir/scripts/$scriptName.php";

		if (!isset($_POST['unzip_dir'])) $_POST['unzip_dir'] = $unzipDir;

		if(is_file($file)) {
			if ($evalAs) {
				eval(''.preg_replace(array('/function\s+'.$scriptName.'\s*\(/', '/^\s*<\?php/i', '/\?>\s*$/'), array('function '.$evalAs.' ('), file_get_contents($file)));
				$evalAs();
			}
			else {
				include($file);
				$scriptName();
			}
   		}
	}

	public function installPackage () {

        global $sugar_config;
        global $mod_strings, $timezones, $beanFiles;
        global $current_language, $locale, $current_user, $system_config, $current_entity, $db, $timedate, $beanList;

		@require_once('include/entryPoint.php');
		require_once('ModuleInstall/ModuleInstaller.php');
		require_once('include/utils/zip_utils.php');
		require_once('include/utils/file_utils.php');
		require_once('modules/Users/authentication/AuthenticationController.php');

		$authController = new AuthenticationController((!empty($GLOBALS['sugar_config']['authenticationClass'])? $GLOBALS['sugar_config']['authenticationClass'] : 'SugarAuthenticate'));
		$GLOBALS['current_user'] = new User();
		if(isset($_SESSION['authenticated_user_id'])){ 
			if (!isset($GLOBALS['app'])) {
				require_once('include/MVC/SugarApplication.php');
				$GLOBALS['app'] = new SugarApplication();
			}
			$authController->sessionAuthenticate();
		}

		$uploadDir = $this->getUploadDir();
        $base_upgrade_dir = $uploadDir . "upgrades";
		$_REQUEST['install_file'] = "$base_upgrade_dir/EMRestore/".$this->package['filename'];

        $base_tmp_upgrade_dir = "$base_upgrade_dir/temp";

        $mi = new ModuleInstaller();
        $mi->silent = true;
        $mod_strings = return_module_language($current_language, "Administration");
		$_POST['unzip_dir'] = $unzip_dir = mk_temp_dir( $base_tmp_upgrade_dir );
		
		$this->package['unzipDir'] = $unzip_dir;
		$this->package['restoreDir'] = preg_replace('/\.zip$/', '-restore', $_REQUEST['install_file']);
		$this->package['baseDir'] = preg_replace('/\.zip$/', '-base', $_REQUEST['install_file']);

		unzip($uploadDir . $this->package['filename'], $unzip_dir );
		unlink($uploadDir . $this->package['filename']);

		$_POST['id_name'] = $id_name = $this->package['extension_name'];
		$version = $this->package['subrel_name'];
		$previous_install = array();
		$previous_version = (empty($previous_install['version'])) ? '' : $previous_install['version'];
		$previous_id = (empty($previous_install['id'])) ? '' : $previous_install['id'];

		$this->execScript($unzip_dir, 'pre_install');

		ob_start();
		if(!empty($previous_version)){
			@$mi->install($unzip_dir, true, $previous_version);
		}
		else {
			@$mi->install($unzip_dir);
		}

		$this->execScript($unzip_dir, 'post_install');

		if (!isset($this->package['baseDir'])) {
			$this->package['baseDir'] = preg_replace('/\.zip$/', '-restore', $_REQUEST['install_file']);
		}
		if (!file_exists($this->package['baseDir'])) {
			sugar_mkdir($this->package['baseDir'], 0777, true);
		}
		if (file_exists("$unzip_dir/scripts")) {
			copy_recursive("$unzip_dir/scripts", $this->package['baseDir'].'/scripts');
		}
		copy("$unzip_dir/manifest.php", $this->package['baseDir'].'/manifest.php');

		rmdir_recursive($unzip_dir);

		$this->addResources2Validate($mi);
		$this->addPackage2Validate();
	}

	public function addResources2Validate ($mi) {

		global $resources2Validate;

		if (@$resources2Validate) {
			$res2Validate = array_map(create_function('$v', 'return array("to" => $v);'), $resources2Validate);
		}
		else {
			$res2Validate = array();
		}
		$res2Validate = array_merge($res2Validate, (array)@$mi->installdefs['copy']);

		if ($res2Validate) {
			$this->addRes2Validate($res2Validate);
		}
	}

	public function uninstallPackage ($packageId, $isUpgrade = false) {

		global $sugar_config, $app_strings;

		require_once('custom/include/EnhancedManager/ErrorManager.php');

		$erm = new ErrorManager;

		try {
			$this->package = $this->getPackageFromDB($packageId);
			if (!$this->package) {
				if ($isUpgrade)  {
					return;
				}
				else {
					throw new Exception('No package Returned');
				}
			}
			$this->package['baseDir'] = preg_replace('/-restore$/', '-base', $this->package['extension_path']);
			if (!file_exists($this->package['baseDir'])) {
				copy_recursive($this->package['extension_path'], $this->package['baseDir']);
			}
			if ($isUpgrade && !file_exists($this->package['baseDir'] . "/manifest.php")) {
				return;
			}
			$_POST['id_name'] = $id_name = $this->package['extension_name'];

			$this->execScript($this->package['baseDir'], 'pre_uninstall', $isUpgrade ? 'uninstall_pre_uninstall' : '');

			$_SESSION['uninstall_aborted'] = $this->package['id'];
			$this->uninstall();
			unset($_SESSION['uninstall_aborted']);

			$this->execScript($this->package['baseDir'], 'post_uninstall', $isUpgrade ? 'uninstall_post_uninstall' : '');

			rmdir_recursive($this->package['baseDir']);
			rmdir_recursive($this->package['extension_path']);
		}
		catch (Exception $e) {

			$erm->manageMessageCode(array(
				'objectCode' => 'LBL_UNINSTALLED_WITH_ERROR',
				'crash' => 1,
				'description' => $php_errormsg
			));
		}

		if ($isUpgrade) {
			return;
		}
		$this->removeFromTable($this->package);
		if (@$sugar_config['dispageExtMan']['serials'][$this->package['sub_id']]) {
			require_once('custom/include/utils/ExtensionManagerUtils.php');
			ExtensionManagerUtils::deleteConfig(array("\$sugar_config['dispageExtMan']['serials']['".$this->package['sub_id']."']"));
		}

		@unlink($sugar_config['cache_dir'].'upload/'.preg_replace('#^.*[\\\\/]+([^\\\\/]+)-restore$#', '\\1.zip', $this->package['extension_path']));

		if (file_exists('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManager.php')) {
			require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManager.php');
			require_once('custom/Extension/application/Ext/Language/'.$erm->lang.'.ExtensionManagerInstaller.php');

			$erm->manageMessageCode(array(
				'objectCode' => 'LBL_UNINSTALLED_SUCCESSFULLY',
				'textualDescription' => sprintf($app_strings['LBL_DISPAGE_MANAGER']['LBL_UNINSTALLED_PACKAGE'], $this->package['extension_name'].' '.$this->package['subrel_name']),
			));
			$_SESSION['EM2Send'] = array(array(
				'sub_id' => $this->package['sub_id'],
				'uninstall' => true,
			));
		}
		else {
			ob_end_clean();
			ob_end_clean();
			header('Content-type: text/xml');
			echo "<?xml version='1.0' encoding='utf-8'?".">\n";
			echo '<addeval>'.htmlentities('document.location.href="index.php?disable_em=0"; -1;').'</addeval>';
			exit();
		}
	}

	private function uninstall () {

        global $sugar_config;
        global $mod_strings, $timezones, $beanFiles;
        global $current_language, $locale, $current_user, $system_config, $current_entity, $db, $timedate, $beanList;

		@require_once('include/entryPoint.php');
		require_once('ModuleInstall/ModuleInstaller.php');
		require_once('include/utils/zip_utils.php');
		require_once('include/utils/file_utils.php');
		require_once('modules/Users/authentication/AuthenticationController.php');

		$_REQUEST['install_file'] = preg_replace('/-restore$/', '.dmy', $this->package['extension_path']);

        $mi = new ModuleInstaller();
        $mi->silent = true;

		ob_start();
		@$mi->uninstall($this->package['baseDir']);
	}

	private function addPackage2Validate () {

		$_SESSION['EM2Validate'] = $this->package;
	}
	
	public function updateVersionTable ($ext_id, $params) {

		global $db;
		
		$update = join(', ', array_map(create_function('$k,$v', 'return "$k = \'$v\'";'), array_keys($params), $params));
		$db->query("UPDATE em_installed SET
			$update, 
			updated = CURRENT_TIMESTAMP
			WHERE id = '$ext_id'
		");
	}
	
	public function add2Table ($package) {

		global $db;
		
		$package['expires'] = @$package['expires'] ? "'".$package['expires']."'" : "NULL";

		if ($this->getPackageFromDB($package['ext_id'])) {
			$db->query("UPDATE em_installed SET
				sub_id = '".$package['subrel_id']."',
				parent_id = '".$package['parent_id']."',
				relase = '".$package['subrel_name']."', 
				version = '".$package['extens_version']."', 
				updated = CURRENT_TIMESTAMP,
				expires = ".$package['expires'].",
				extension_path = '".$package['restoreDir']."', 
				description = '".@$db->quote($package['description'])."', 
				add_info = '".@$db->quote($package['add_info'])."'
			WHERE id = '".$package['ext_id']."'
			");
		}
		else {
			$db->query("INSERT INTO em_installed (id, sub_id, parent_id, ntype, extension_name, relase, version, installed, updated, expires, extension_path, description, add_info) VALUES (
				'".$package['ext_id']."', 
				'".$package['subrel_id']."', 
				'".$package['parent_id']."', 
				0, 
				'".$package['extension_name']."', 
				'".$package['subrel_name']."', 
				'".$package['extens_version']."', 
				CURRENT_TIMESTAMP, 
				CURRENT_TIMESTAMP,
				".$package['expires'].",
				'".$package['restoreDir']."', 
				'".@$db->quote($package['description'])."', 
				'".@$db->quote($package['add_info'])."'
			)
			");
		}
		if (@$package['parent_id']) {
			$db->query("UPDATE em_installed SET ntype = 1 WHERE id = '$package[parent_id]'");
		}
	}

	public function removeFromTable ($package) {

		global $db;
		
		$result = $db->query("
SELECT em2.id , COUNT(em3.id) as cnt
FROM em_installed em
JOIN em_installed em2 ON em.parent_id = em2.id
JOIN em_installed em3 ON em3.parent_id = em2.id
WHERE em.id = '$package[id]'
		");
		$children = $db->fetchByAssoc($result);
		if ($children['cnt'] == 1) {
			$db->query("UPDATE em_installed SET ntype = 0 WHERE id = '$children[id]'");
		}

		$db->query("DELETE FROM em_installed WHERE id = '$package[id]'");
	}

	public function getPackageFromDB ($packageId) {

		global $db;

		$result = $db->query("SELECT * FROM em_installed WHERE id = '$packageId'");
		return $db->fetchByAssoc($result);
	}

	public function getAllPackagesFromDB () {

		global $db;

		$result = $db->query("SELECT id, sub_id, version FROM em_installed");
		$r = array();

		while ($res = $db->fetchByAssoc($result)) {
			$r[$res['sub_id']] = array(
				'rel_id' => $res['id'],
				'version' => $res['version']
			);
		}
		return $r;
	}

	public function validateAllInstallations () {

		global $sugar_config, $sugar_version;

		require_once('custom/include/EnhancedManager/ErrorManager.php');
		$erm = new ErrorManager;

		$_SESSION['EM2Send'] = array();

		$package = (key($_SESSION['EM2Validate']) === 0) ? $_SESSION['EM2Validate'][0] : $_SESSION['EM2Validate'];
			
		$EM2Send['subrel_id'] = $package['subrel_id'];

		if (!file_exists($package['baseDir'])) {
			$package['baseDir'] = $package['restoreDir'];
		}
		if ($error = $this->validateInstallation($package)) {
			$EM2Send['validated'] = false;
			$EM2Send['error'] = $error;
			$_SESSION['EM2Send'][] = $EM2Send;
			$erm->manageMessageCode(array(
				'objectCode' => 'LBL_VALIDATED_WITH_ERROR',
				'crash' => 1,
				'description' => $error['errorCode'],
				'textualDescription' => $error['textualDescription']
			));
		}
		$msgArray = array(
			'objectCode' => 'LBL_VALIDATED_SUCCESSFULLY',
		);
		if ($_SESSION['em_ext2install'] && $package['extension_name'] != 'Extension Manager' ) {
			$msgArray['addElements']['addeval'] = "if (!instConsole.isRepairing) {instConsole.loadingStep = instConsole.getStageIndex('installNext')}";
		}
		$erm->manageMessageCode($msgArray);
		$EM2Send['validated'] = true;
		$_SESSION['EM2Send'][] = $EM2Send;

		if (($upgrade = $this->getPackageFromDB($package['ext_id'])) && $upgrade['sub_id'] != $package['subrel_id']) {

			if (!$sugar_config) include ('config.php');
			if (!$sugar_version) include ('sugar_version.php');
			if (isset($sugar_config['dispageExtMan']) && isset($sugar_config['dispageExtMan']['serials']) && isset($sugar_config['dispageExtMan']['serials'][$upgrade['sub_id']]) && $sugar_config['dispageExtMan']['serials'][$upgrade['sub_id']]) {
				
				require_once('include/utils.php');
				require_once("include/utils/file_utils.php");
				require_once("include/Localization/Localization.php");
				$sugar_config['dispageExtMan']['serials'][$package['subrel_id']] = $sugar_config['dispageExtMan']['serials'][$upgrade['sub_id']];
				unset($sugar_config['dispageExtMan']['serials'][$upgrade['sub_id']]);

				rebuildConfigFile($sugar_config, $sugar_version);
			}
		}
		$this->add2Table($package);

		unset($_SESSION['EM2Validate']);
	}

	private function validateInstallation ($package) {

		global $sugar_version;

		require('sugar_version.php');
		
		$baseDir = $package['baseDir'];
		$manifestFile = "$baseDir/manifest.php";

		if (!is_readable($manifestFile)) return array(
			'errorCode' => 'LBL_VALIDATED_ERROR_MANIFEST'
		);
		
		include($manifestFile);

		if (!@$installdefs['copy']) return '';

		foreach ($installdefs['copy'] as $f) {
			
			if (!file_exists($f['to'])) return array(
				'errorCode' => 'LBL_VALIDATED_ERROR_FILE_NOT_FOUND',
				'textualDescription' => $f['to']
			);
			if (!is_readable($f['to'])) return array(
				'errorCode' => 'LBL_VALIDATED_ERROR_FILE_NOT_ACCESSIBLE',
				'textualDescription' => $f['to']
			);
		}
	}

}

?>
