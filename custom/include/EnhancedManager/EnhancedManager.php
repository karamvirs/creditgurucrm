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

	
require_once('include/nusoap/nusoap.php');

if (!@$sugar_config) {
	require_once('config.php');
	if (file_exists('config_override.php')) {
		require_once('config_override.php');
	}
}

class EnhancedManager {
	
	public $availMethods = array(
		'retrieveLoginData', 
		'addStartParams',
		'addSubrelId',
	);
	public static $tries = 2;
	public static $timeout = 5;
	public static $responseTimeout = 15;
	public static $encodeResponse = false;
	public static $proxyHost = false;
	public static $proxyPort = false;
	public static $proxyUsername = false;
	public static $proxyPassword = false;

	private $client;
	private $IP;
	private $result, $flushCache;

	private static $optionList = array(
		'tries',
		'timeout',
		'responseTimeout',
		'encodeResponse',
		'proxyHost',
		'proxyPort',
		'proxyUsername',
		'proxyPassword',
	);


	public function EnhancedManager () {
	
		global $sugar_config;

		$this->IP = isset($_SESSION['EMForceLocalhost']) ? $_SESSION['EMForceLocalhost'] : 'www.dispage.com';

		foreach (self::$optionList as $op) {
			$opConf = 'emOption' . ucfirst($op);
			if (isset($sugar_config['dispageExtMan'][$opConf])) {
				self::$$op = $sugar_config['dispageExtMan'][$opConf];
			}
		}
	}
	
	public function loginCheck () {
		
		global $sugar_config;

		$res = $this->connectHome('followtwr', array('name' => (self::$encodeResponse ? '4' : '1'), 'noHeader' => true));

		$emStoreFile = $sugar_config['cache_dir'] . 'EMCache/EMStore.php';

		if ($res && file_exists($emStoreFile)) {
			eval(file_get_contents($emStoreFile));
		}
		elseif ($this->result && (!file_exists($emStoreFile) || $this->flushCache)) {
			if (!file_exists($sugar_config['cache_dir'] . 'EMCache')) {
				require_once('include/utils/sugar_file_utils.php');
				sugar_mkdir($sugar_config['cache_dir'] . 'EMCache', 0777, true);
			}
			file_put_contents($emStoreFile, $this->result);
		}
	}

	public function callClient ($rFunc, $params = array(), $noEmpty = false) {

		global $EMNusoapNoEOF;

		$EMNusoapNoEOF = true;
		for ($i = 0; $i < self::$tries; $i++) {
			$this->result = $this->client->call(
				$rFunc,                     
				$params,    
				'uri:nebuchadnezzar',            
				'uri:nebuchadnezzar/'.$rFunc       
			);

			if (!$this->client->fault && !($err = $this->client->getError()) && !($noEmpty && !$this->result)) {
				break;
			}
		}
		$EMNusoapNoEOF = false;

		if ($this->client->fault) {
			error_log("\n". date("d/m/Y H:i:s")." - Connection Fault", 3, "sugarcrm.log");
			$this->crash("#0425: Connection Error - SOAP Fault");
			return -1;
		}

	    if ($err) {
	        error_log("\n". date("d/m/Y H:i:s")." - Error\n".print_r($err, true), 3, "sugarcrm.log");
	        error_log("\n". date("d/m/Y H:i:s")." - Error\n".html_entity_decode($this->client->getDebug()), 3, "SOAPerror.log");
			$this->crash("#0424: Connection Error - Unable to connect");
			return -1;
	    }
	}
	
	public function connectHome ($rFunc, $params = array()) {
			
		global $EMXMLMan;

		if (array_key_exists('noHeader', $params)) {
			$noHeader = $params['noHeader'];
			unset($params['noHeader']);
		}
		else $noHeader = null;

		$clientName = class_exists('nusoap_client') ? 'nusoap_client' : 'nusoapclient';
		$this->client = new $clientName('http://'.$this->IP.'/cmhrdis/dsp.php', false, self::$proxyHost, self::$proxyPort, self::$proxyUsername, self::$proxyPassword, self::$timeout, self::$responseTimeout);

		$err = $this->client->getError();
		if ($err) {
		    error_log("\n". date("d/m/Y H:i:s")." - Constructor error:".print_r($err, true), 3, "sugarcrm.log");
			$this->crash("#0426: Connection Error - SOAP Constructor error");
			return -1;
		}
		if ($rFunc == "redpill" && self::$encodeResponse) {
			$this->addEncodeParams($params);
		}
		if ($rFunc == "theconstruct") {
			$this->addParams($params);
		}
		if ($this->callClient($rFunc, $params)) {
			return -1;
		}
	    $new_result = $this->result;
		
		require_once("custom/include/EnhancedManager/XMLManager.php");

	    do {
			
			$EMXMLMan = new XMLManager($noHeader);

			if (!$this->result) {
				$this->crash("#0416: Empty Result Returned");
			}
			if (self::$encodeResponse && preg_match('#^[a-zA-Z0-9/+]+=*$#', $new_result)) {
				$tmp_result = base64_decode($new_result);
				if ($tmp_result !== false) $new_result = $tmp_result;
			}
			$this->result = $new_result;
	    	$ev_res = eval ($this->result);
			if (is_array($new_result)) {
				$this->crash($new_result['faultstring'], $new_result['detail']);
			}
			if ($ev_res === false) {
				if (self::$encodeResponse) {
					$this->crash("#0404: Unknown Error");
				}
				else {
					return $this->switch2Encoded($rFunc, $params);
				}
			}
			$noHeader = true;
	    }
	    while ($new_result != $this->result);

		if (isset($_SESSION["EM_force_reload"])) {
			unset($_SESSION["EM_force_reload"]);
			unset($_SESSION["em_sent"]);
			unset($_SESSION["ENM_disable"]);
		}
		return 0;
	}

	public function switch2Encoded ($rFunc, $params) {

		require_once('custom/include/utils/ExtensionManagerUtils.php');

		self::$encodeResponse = true;
		ExtensionManagerUtils::saveConfig(array('dispageExtMan' => array('emOptionEncodeResponse' => true)));

		if ($rFunc == 'followtwr') {
			return $this->connectHome('followtwr', array('name' => '4', 'noHeader' => true));
		} else {
			return $this->connectHome($rFunc, $params);
		}
	}

	public function getRemoteFile ($fileId, & $error, $params = array()) {
	
		$url = 'http://' . $this->IP . '/cmhrdis/drcGate.php?sessid='. $_SESSION['em_sid'] . '&id=' . $fileId;

		if ($params) {
			$url .= '&' . http_build_query($params, '', '&');
		}

		$parsedUrl = parse_url($url);
		$host = $parsedUrl['host'];
		if (isset($parsedUrl['path'])) {
			$path = $parsedUrl['path'];
		} else {
			$path = '/';
		}

		if (isset($parsedUrl['query'])) {
			$path .= '?' . $parsedUrl['query'];
		}

		if (isset($parsedUrl['port'])) {
			$port = $parsedUrl['port'];
		} else {
			$port = '80';
		}

		$timeout = 60;
		$response = '';

		$fp = @fsockopen($host, '80', $errno, $errstr, $timeout );

		if( !$fp ) {
		  $error = "LBL_UNABLE_TO_CONNECT";
		} else {
			fputs($fp, "GET $path HTTP/1.0\r\n" .
					 "Host: $host\r\n" .
					 "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.0.3) Gecko/20060426 Firefox/1.5.0.3\r\n" .
					 "Accept: */*\r\n" .
					 "Accept-Language: en-us,en;q=0.5\r\n" .
					 "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7\r\n" .
					 "Keep-Alive: 300\r\n" .
					 "Connection: keep-alive\r\n" .
					 "Referer: http://$host\r\n\r\n");

			while ( $line = fread( $fp, 4096 ) ) {
				$response .= $line;
			}

			fclose( $fp );

			$pos      = strpos($response, "\r\n\r\n");
			$response = substr($response, $pos + 4);
		}
		if (!$response) {
			$error = "LBL_EMPTY_RESPONSE";
		}
		if (preg_match('#^\s*<error>(.*?)</error>\s*$#s', $response, $capError)) {
			$error = $capError[1];
		}

		return $response;
	}


	public function getAdminUsers () {

		global $db;

		$res = array();
		$result = $db->query("SELECT id, user_name FROM users WHERE is_admin = 1 AND deleted = 0 AND id != '1'");
		while ($r = $db->fetchByAssoc($result)) {
			$res[$r['id']] = $r['user_name'];
		}
		return $res;
	}

	public function getUserData ($userId) {

		global $db, $sugar_config;

		$result = $db->query("SELECT is_admin, user_name FROM users WHERE id = '$userId'");
		if ($res = $db->fetchByAssoc($result)) {
			if ($res['is_admin'] && @$sugar_config["dispageExtMan"]["emOptionLowerAdmin"] && in_array($userId, $sugar_config["dispageExtMan"]["emOptionLowerAdmin"])) {
				$res['is_admin'] = 0;
			}
			return $res;
		}
	}

	public function isAdminEquiv () {

		global $current_user, $sugar_config;

		return is_admin($current_user) ? (!@$sugar_config["dispageExtMan"]["emOptionLowerAdmin"] || !in_array($current_user->id, $sugar_config["dispageExtMan"]["emOptionLowerAdmin"])) : false;
	}

	private function crash ($msg, $details = '') {

		require_once('custom/include/EnhancedManager/ErrorManager.php');
		ErrorManager::crash(3, $msg, $details);
	}

	private function addEncodeParams (& $paramArray) {

		$i = 1;
		while (count($paramArray) < 3) {
			$paramArray[$i++] = '';
		}
		$paramArray[$i] = '1';
	}
	
	public function addParams (& $paramArray) {

		global $sugar_config, $sugar_flavor, $sugar_build, $db;

		$vars['GLOBALS[_SESSION]'] = array('em_sid');
		if (!isset($_SESSION['em_sent'])) {

			include('sugar_version.php');
			require_once('config.php');
			require_once('custom/include/EnhancedManager/InstallManager.php');
			require_once("custom/include/EnhancedManager/ultraLiteDB.php");

			$db = new ultraLiteDB;
			$GLOBALS['em_package_list'] = InstallManager::getAllPackagesFromDB();
			$GLOBALS['userData'] = $this->getUserData($_SESSION['authenticated_user_id']);
			if (isset($sugar_config['dispageExtMan']['environment']) && $sugar_config['dispageExtMan']['environment'] == 'production') {
				$GLOBALS['userData']['user_name'] = md5($GLOBALS['userData']['user_name']);
			}

			$vars['GLOBALS[_SESSION]'] = array_merge($vars['GLOBALS[_SESSION]'], array('authenticated_user_id', 'authenticated_user_language'));
			$vars['GLOBALS[sugar_config]'] = array('unique_key', 'sugar_version');
			$vars['GLOBALS[sugar_config][dispageExtMan]'] = array('disautoupdate', 'environment');
			$vars['GLOBALS[userData]'] = array('user_name', 'is_admin');
			$vars['GLOBALS'] = array('sugar_flavor', 'sugar_build', 'em_package_list');
			$_SESSION['em_sent'] = 1;
		}
		$func = create_function('&$val,$key,$k', '$val=eval("return @$".$k."[$key];");');
		foreach ($vars as $k => $v) {
			$v = array_flip($v);
			array_walk($v, $func, $k);
			$vs = array_merge(@(array)$vs, $v);
		}
		$paramArray = array_merge(array("sk" => serialize($vs)), $paramArray);
	}

	public function retrieveLoginData () {

		global $paramArray, $sugar_config;

		require_once("include/dir_inc.php");
		require_once("include/utils/encryption_utils.php");
		require_once("config.php");
		
		$paramArray['emuser'] = $sugar_config['dispageExtMan']['username'];
		$paramArray['empwd'] = blowfishDecode(blowfishGetKey('encrypt_field'), $sugar_config['dispageExtMan']['password']);
		$paramArray['encodeResponse'] = @$sugar_config['dispageExtMan']['emOptionEncodeResponse'];

		if (@$paramArray['callMethod'] == __FUNCTION__) {
			$this->addStartParams();
		}
		else {
			$paramArray = array_merge($paramArray, array_diff_key((array)@$sugar_config["dispageExtMan"], array('username' => '', 'password' => '')));

			foreach (self::$optionList as $op) {
				$opConf = 'emOption' . ucfirst($op);
				if (!isset($paramArray[$opConf])) {
					$paramArray[$opConf] = self::$$op;
				}
			}

			unset($paramArray['callMethod']);
		}
	}

	public function addSubrelId () {

		global $paramArray;

		$paramArray['subrel_id'] = @$_SESSION['em_ext2install'][0]['subrel_id'];
		unset($paramArray['callMethod']);
	}

	public function addStartParams () {

		global $paramArray, $sugar_config;

		if (@$sugar_config['dispageExtMan']['serials']) {
			$paramArray['serials'] = preg_replace('/(^|&)/', '\\1x', http_build_query($sugar_config['dispageExtMan']['serials'], '', '&'));
		}
		unset($paramArray['callMethod']);
	}

	public function saveOptions($username, $password, $emautologin, $params = array()) {

		global $sugar_config, $sugar_version;
		
		require_once("include/Localization/Localization.php");
		require_once("include/utils/file_utils.php");
		require_once("include/utils.php");
		require_once("include/dir_inc.php");
		require_once("config.php");
		require_once("sugar_version.php");
		require_once("include/utils/encryption_utils.php");

		if ($username) $sugar_config["dispageExtMan"]["username"] = $username;
		if ($password) $sugar_config["dispageExtMan"]["password"] = blowfishEncode(blowfishGetKey("encrypt_field"), $password);
		$sugar_config["dispageExtMan"]["autologin"] = $emautologin;
		if ($params) {
			$sugar_config["dispageExtMan"] = array_merge($sugar_config["dispageExtMan"], $params);
		}
		if(!rebuildConfigFile($sugar_config, $sugar_version)) {
			$_SESSION["ENM_start_up"] .= '/* cutting-dhvjej4 */;displayAdminError("Unable to write into \"config.php\""); $_SESSION["ENM_start_up"] = preg_replace(\'#/\* cutting-dhvjej4 \*/.*$#\', \'\',  $_SESSION["ENM_start_up"])';
		}
	}
    
	public function getURLUniqueCode ($module) {

		global $db;

		require_once("custom/include/EnhancedManager/ultraLiteDB.php");
		if (!$db) {
			$db = new ultraLiteDB;
		}
		if (!$db) return create_guid_section(32);
		
		$result = $db->query("SELECT sub_id FROM em_installed WHERE extension_name = '$module'");
		$extension = $db->fetchByAssoc($result);

		if ($extension) {
			return str_replace('-', '', $extension['sub_id']);
		}
		else {
			return create_guid_section(32);
		}
	}

}
   
?>
