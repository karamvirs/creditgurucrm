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

require_once 'include/SugarObjects/SugarConfig.php';
if (file_exists('include/database/PearDatabase.php')) require_once('include/database/PearDatabase.php');
require_once("include/database/DBManager.php");
require_once('include/SugarLogger/LoggerManager.php');
require_once('include/utils.php');
require_once('include/utils/file_utils.php');
require_once('include/utils/sugar_file_utils.php');


class UltraLiteDB {

	private $ULDBObj;

	function __construct ($params = array()) {

		global $sugar_config, $log;

		if (!$log || !is_object($log)) {
			$log = LoggerManager::getLogger('SugarCRM');
		}
		if (!$params) {
			require_once('config.php');
			$params = $sugar_config['dbconfig'];
		}
		$my_db_manager = 'MysqlManager';
		if( $params['db_type'] == "mysql" ) {
			if (function_exists('mysqli_connect')) {
				$my_db_manager = 'MysqliManager';
			}
		}
		if( $params['db_type'] == "oci8" ){
			$my_db_manager = 'OracleManager';
		}
		elseif( $params['db_type'] == "mssql" ){
			
			require_once('include/database/DBManagerFactory.php');

			if (is_freetds() 
					&& (empty($config['db_mssql_force_driver']) || $config['db_mssql_force_driver'] == 'freetds' ))
				$my_db_manager = 'FreeTDSManager';
			elseif (function_exists('mssql_connect')
					&& (empty($config['db_mssql_force_driver']) || $config['db_mssql_force_driver'] == 'mssql' ))
				$my_db_manager = 'MssqlManager';
			else {
				$my_db_manager = 'SqlsrvManager';
			}
		}
		if (!class_exists('TimeDate')) require_once('include/TimeDate.php');
		require_once("include/database/{$my_db_manager}.php");
		$this->ULDBObj = new $my_db_manager;
	}

	public function dbConnect ($params) {
		
		return $this->ULDBObj->dbConnect($params);
	}

	public function fetchByAssoc ($res) {

		return $this->ULDBObj->fetchByAssoc($res);
	}

	public function fetchArray ($res) {

		return $this->ULDBObj->fetchArray($res);
	}

	public function fetchObject ($res) {

		return $this->ULDBObj->fetchObject($res);
	}

	public function query($query) {

		return $this->ULDBObj->query($query);
	}

    public function quote($string, $isLike = true) {

        return $this->ULDBObj->quote($string, $isLike);
    }

	public function limitQuery($sql, $start, $count, $dieOnError = false, $msg = '') {

		return $this->ULDBObj->limitQuery($sql, $start, $count, $dieOnError, $msg);
	}

	public function close () {

		return $this->ULDBObj->close();
	}

	public function create_guid() {

		$microTime = microtime();
		list($a_dec, $a_sec) = explode(" ", $microTime);

		$dec_hex = dechex($a_dec* 1000000);
		$sec_hex = dechex($a_sec);

		UltraLiteDB::ensure_length($dec_hex, 5);
		UltraLiteDB::ensure_length($sec_hex, 6);

		$guid = "";
		$guid .= $dec_hex;
		$guid .= UltraLiteDB::create_guid_section(3);
		$guid .= '-';
		$guid .= UltraLiteDB::create_guid_section(4);
		$guid .= '-';
		$guid .= UltraLiteDB::create_guid_section(4);
		$guid .= '-';
		$guid .= UltraLiteDB::create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= UltraLiteDB::create_guid_section(6);

		return $guid;

	}

	public function create_guid_section($characters) {

		$return = "";
		for($i=0; $i<$characters; $i++)
		{
			$return .= dechex(mt_rand(0,15));
		}
		return $return;
	}

	private function ensure_length(&$string, $length) {

		$strlen = strlen($string);
		if($strlen < $length)
		{
			$string = str_pad($string,$length,"0");
		}
		else if($strlen > $length)
		{
			$string = substr($string, 0, $length);
		}
	}
}


?>
