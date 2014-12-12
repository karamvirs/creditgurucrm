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

$GLOBALS['TSWrapper'] = true;

require_once('include/entryPoint.php');
require_once('include/resource/ResourceManager.php');

require_once('custom/include/EnhancedManager/XMLManager.php');


class TSWrapper extends XMLManager {

	private $exportWhere, $hasCompoundName, $isActivity;
    private $setCompleteModules = array('Calls', 'Meetings', 'Notes', 'Tasks');

	private $compNameModules = array('Contacts', 'Leads');

	public $module, $userPreferences, $lang, $json;

	public static $availLanguages = array(
		'en_us',
	);

	
	function __construct () {

		global $current_user, $sugar_flavor;

		if (!isset($_REQUEST['noXML'])) {
			parent::__construct();
		}	
		$current_user->retrieve($_SESSION['authenticated_user_id']);

		if (isset($_REQUEST['module'])) {
			$this->module = $_REQUEST['module'];
			$this->exportWhere = $_SESSION[$this->module.'2_QUERY'];
			$this->hasCompoundName = in_array($this->module, $this->compNameModules);
			$this->isActivity = in_array($this->module, $this->setCompleteModules);
		}
		$prefKey = $current_user->user_name.'_PREFERENCES';
		if (isset($_SESSION[$prefKey]) && isset($_SESSION[$prefKey]['global']) && isset($_SESSION[$prefKey]['global'][$this->module.'Q'])) {
			$this->userPreferences = $_SESSION[$prefKey]['global'][$this->module.'Q'];
		}
		$this->loadSOAPFunctions ();

		$this->lang = $this->getLanguage();

	}

	public function getLanguage () {

		if (in_array($_SESSION['authenticated_user_language'], self::$availLanguages)) {
			return $_SESSION['authenticated_user_language'];
		}
		else {
			return self::$availLanguages[0];
		}
	}

	private function JSON2Array ($req) {

		$dReq = html_entity_decode($req);

		return $this->json->decode($dReq);
	}

	public function getError ($errorLabel) {

		ob_start();
		require_once('custom/Extension/application/Ext/Language/'.$this->lang.'.ModuleSurfer.php');
		ob_end_clean();
		if (isset($app_strings['LBL_MODULESURFER']['LBL_ERRORS'][$errorLabel])) {
			return $app_strings['LBL_MODULESURFER']['LBL_ERRORS'][$errorLabel];
		}
		else {
			 return $app_strings['LBL_MODULESURFER']['LBL_ERRORS']['LBL_ERROR_UNKNOWN'];
		}

	}

	private function loadSOAPFunctions () {

		global $resourceManager;

		require_once('soap/SoapError.php');

		$resourceManager = ResourceManager::getInstance();
		$resourceManager->setup($this->module);

		require_once('custom/include/ModuleSurfer/SugarUsers.php');
	}

	private function queryFilter ($query) {

		return preg_replace('/\border +by[^)]+$/is', '', $query);
	}

	private function whereFilter ($query) {

		$finalWords = array('where', 'group', 'order', 'having', 'limit');
		$kw = 'e5DcKe1iy';

		$finalWordsString = join(", ", array_map(create_function('$v', 'return "\"$v\"";'), $finalWords));
		$kwReplace = join(", ", array_map(create_function('$v', 'return "\"'.$kw.'$v\"";'), $finalWords));

		$query = preg_replace('/(\(((?>[^()]+)|(?R))*\))/es', 'str_ireplace(array('.$finalWordsString.'), array('.$kwReplace.'), \'\\1\')', $query);
		$query = preg_replace(array(
				'/^.*?\bwhere\b/is',
				'/\b(?>'.join('|', $finalWords).').*$/is',
			), '', $query);

		return str_replace($kw, '', $query);
	}

	public function getDisplayColumns ($uppercase = false, $returnValues = false) {

		global $current_user;

		if (!$returnValues && isset($this->userPreferences['displayColumns'])) {
			$columnFields = explode('|', $this->userPreferences['displayColumns']);
		}
		else {
			$columnFields = array();
		}
		$foundViewDefs = false;

		if (!$columnFields || !array_filter($columnFields)) {
			if(file_exists('custom/modules/' . $this->module. '/metadata/listviewdefs.php')){
				$metadataFile = 'custom/modules/' . $this->module . '/metadata/listviewdefs.php';
				$foundViewDefs = true;
			}else{
				if(file_exists('custom/modules/'.$this->module.'/metadata/metafiles.php')){
					eval(preg_replace(array('/^\s*<\?php/i', '/\?>\s*$/i'), '', file_get_contents('custom/modules/'.$this->module.'/metadata/metafiles.php')));
					if(!empty($metafiles[$this->module]['listviewdefs'])){
						$metadataFile = $metafiles[$this->module]['listviewdefs'];
						$foundViewDefs = true;
					}
				}elseif(file_exists('modules/'.$this->module.'/metadata/metafiles.php')){
					eval(preg_replace(array('/^\s*<\?php/i', '/\?>\s*$/i'), '', file_get_contents('modules/'.$this->module.'/metadata/metafiles.php')));
					if(!empty($metafiles[$this->module]['listviewdefs'])){
						$metadataFile = $metafiles[$this->module]['listviewdefs'];
						$foundViewDefs = true;
					}
				}
			}
			if(!$foundViewDefs && file_exists('modules/'.$this->module.'/metadata/listviewdefs.php')){
					$metadataFile = 'modules/'.$this->module.'/metadata/listviewdefs.php';
			}
			if (!isset($metadataFile)) {
				return array();
			}
			eval(preg_replace(array('/^\s*<\?php/i', '/\?>\s*$/i'), '', file_get_contents($metadataFile)));
			
			$columnFields = (array)$listViewDefs[$this->module];

			if (!$returnValues) {
				$columnFields = array_keys($columnFields);
			}
		}
		return $uppercase ? $columnFields : array_map('strtolower', $columnFields);
	}

	private function getOrderBy ($sidx, $sord) {

		if (!$sidx && isset($this->userPreferences['orderBy'])) {
			$sidx = $this->userPreferences['orderBy'];
		}
		if (!$sord && isset($this->userPreferences['sortOrder'])) {
			$sord = $this->userPreferences['sortOrder'];
		}

		if ($sidx) return strtolower($sidx). ' ' . preg_replace('/,\s*$/', '', $sord);
	}



	public function countRows () {

		global $db;

		require_once('data/SugarBean.php');

		$query = SugarBean::create_list_count_query($this->origQuery);
		$result = $db->query($query);
		$res = $db->fetchByAssoc($result);
		
		return $res['c'];
	}

	public function listView () {

		global $app_strings;

		$this->json = getJSONobj();
		extract(array_intersect_key($_REQUEST, array_flip(array('msCols', 'page', 'rows', 'sidx', 'sord'))));

		$GLOBALS['module'] = $this->module;
		if ($rows < 0) $rows = 0;
		
		$filterVal = array_merge(array('id'), array_intersect($this->getDisplayColumns(), $this->JSON2Array($msCols)));

		$orderBy = $this->getOrderBy($sidx, $sord);

		$start = $rows * $page - $rows;
		if ($start < 0) $start = 0;

		$SOAPRes = get_entry_list(session_id(), $this->module, $this->exportWhere, $orderBy, $start, $rows, '', $searchFilter );

		if (isset($SOAPRes['error'])) {

			$res['error'] = $this->getError($SOAPRes['error']);
		}
		else {

			$total_pages = $rows > 0 ? ceil($SOAPRes['row_count'] / $rows) : 0;
			if ($page > $total_pages) $page = $total_pages;

			$res['page'] = $page;
			$res['total'] = $total_pages;
			$res['records'] = $SOAPRes['row_count'];
			
			foreach ($SOAPRes['entry_list'] as $i => $row) {
				$res['row'][$i]['id'] = $row['id'];
				foreach ($filterVal as $var) {
					if ($this->hasCompoundName && $var == 'name') {
						$value = $row['name_value_list']['first_name']['value'] . '&nbsp;' . $row['name_value_list']['last_name']['value'];
					}
					elseif ($this->isActivity && $var == 'parent_name') {
                        $value = "<a href=\"index.php?record={$row['name_value_list']['parent_id']['value']}&ms_id_name=parent_id&module={$row['name_value_list']['parent_type']['value']}&action=DetailView\">{$row['name_value_list'][$var]['value']}</a>";
                     }
					else {
						$type = $SOAPRes['field_list'][$var]['type'];
						$value = @$row['name_value_list'][$var]['value'];

						switch ($type) {
							case 'multienum':
								if ($multValue = unencodeMultienum($value)) {
									$resValue = array();
									foreach ($multValue as $val) {
										$opt = array_values(array_filter($SOAPRes['field_list'][$var]['options'], create_function('$v', 'return $v["name"] == "'.$val.'";')));
										if ($opt) {
											$resValue[] = $opt[0]['value'];			
										}
									}
									$value = join(',', $resValue);
								}
								break;

							case 'enum':
								$opt = array_values(array_filter($SOAPRes['field_list'][$var]['options'], create_function('$v', 'return $v["name"] == "'.$value.'";')));
								if ($opt) {
									$value = $opt[0]['value'];			
								}
								break;

							case 'bool':
								$value = $value ? $app_strings['LBL_SEARCH_DROPDOWN_YES'] : $app_strings['LBL_SEARCH_DROPDOWN_NO'];
								break;

							case 'relate':
								if (isset($SOAPRes['field_name_map'][$var]) && isset($SOAPRes['field_name_map'][$var]['module'])) {
									$relField = $SOAPRes['field_name_map'][$var];
									$relModule = $relField['module'];
									if ($relModule && $relModule != 'Users') {
										$idName = $relField['id_name'];
										$id = isset($row['name_value_list'][$idName]) ? $row['name_value_list'][$idName]['value'] : '';
										$value = "<a href=\"index.php?record=$id&ms_id_name=$idName&module=$relModule&action=DetailView\">$value</a>";
									}
								}
								break;

							case 'currency':
								$value = preg_replace('/[.,](?=\d{3})/', '', $value);
								break;

							case 'code':
								$value = preg_replace(array('/<td\b/i', '/<\/td>/i'), array('<th', '</th>'), $value);
								break;

							default:
								if ($var == 'parent_name' && isset($row['name_value_list']['parent_id']) && isset($row['name_value_list']['parent_type'])) {
									$value = "<a href=\"index.php?record={$row['name_value_list']['parent_id']['value']}&ms_id_name=parent_id&module={$row['name_value_list']['parent_type']['value']}&action=DetailView\">$value</a>";
								}
								break;
						}
					}
					$res['row'][$i]['cell'][] = $value;
				}
				$res['row'][$i]['cell'][] = '';


			}
		}
		$resXML = $this->array2xml($res);
		echo $resXML;
	}

	public function editRecord () {

		global $disable_num_format, $sugar_config;

		$nameValueList = array(array('name' => 'id', 'value' => $_REQUEST['id']));
		$disable_num_format = true;

		foreach ($this->getDisplayColumns(true, true) as $colName => $field) {
			if (isset($_REQUEST[$colName])) {
				$value = $_REQUEST[$colName];
				if (preg_match('/<a\s+href=[\'"]index\.php\?record=([^&]*)&ms_id_name=([^&]*)[^>]*>([^<]*)/i', html_entity_decode($value), $cap)) {
					$nameValueList[] = array('name' => $cap[2], 'value' => $cap[1]);
					$value = $cap[3];
				}
				if (is_array($value)) {
					$value = encodeMultienumValue($value);
				}
				$lColName = strtolower($colName);
				$nameValueList[] = array('name' => $lColName, 'value' => $value);
				switch ($colName) {
					case "NAME":
						if ($this->hasCompoundName) {
							$dummy = array_pop($nameValueList);
							if (strpos($value, '&nbsp;') !== false) {
								$cap = explode('&nbsp;', $value);
								$nameValueList[] = array('name' => 'first_name', 'value' => $cap[0]);
								$nameValueList[] = array('name' => 'last_name', 'value' => $cap[1]);
							}
						}
						break;
					case "CREATED_BY_NAME":
						$nameValueList[] = array('name' => 'created_by', 'value' => $value);						
						break;
					case "ASSIGNED_USER_NAME": 
						$nameValueList[] = array('name' => 'assigned_user_id', 'value' => $value);						
						break;
				}
				if (isset($field['currency_format']) && $field['currency_format']) {
					if (!isset($sugar_config['dispageModuleSurfer']) || !isset($sugar_config['dispageModuleSurfer']['global']) || !$sugar_config['dispageModuleSurfer']['global']['disableCurrencyRepl']) {
						$value = str_replace(',', '.', $value);
					}
					$nameValueList[] = array('name' => preg_replace('/_usdollar$/', '', $lColName), 'value' => $value);
					$nameValueList[] = array('name' => 'currency', 'value' => '');
				}
			}
		}
		$res = handle_set_entries($this->module, array($nameValueList));
		
		@ob_end_clean();
		@ob_end_clean();

		if ($res['error']['number'] == -1) {
			echo "OK";
		}
		else {
			echo "(".$res['error']['number'].") ".$res['error']['name']."\r\n".$res['error']['description'];
		}
	}
}
?>
