<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*******************************************************************************
 * Additional code developed by:
 *  
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2013 DISPAGE.
 * 
 * 
 * This file has been modified as part of the "ModuleSurfer" project.
 ******************************************************************************/

require_once('soap/SoapHelperFunctions.php');
require_once('modules/Accounts/Account.php');


function validate_authenticated($session_id){
	if(!empty($session_id)){
	
		if(isset($_SESSION["authenticated_user_id"])){
	
			global $current_user;

			if (!@$current_user->id) {
				require_once('modules/Users/User.php');
				$current_user = new User();
				$current_user->retrieve($_SESSION['authenticated_user_id']);
			}
			login_success_language();
			return true;
		}
	
	}
	LogicHook::initialize();
	$GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
	return false;
}


function login_success_language () {

	global $current_language, $sugar_config, $app_strings, $app_list_strings;
	
	require_once("custom/include/EnhancedManager/EMLangManager.php");

	$current_language = EMLangManager::getCurLanguage();
	$app_strings = return_application_language($current_language);
	$app_list_strings = return_app_list_strings_language($current_language);
}


function get_entry_list ($session, $module_name, $query, $order_by, $offset, $max_results, $deleted, $searchFilter ) {

	global  $beanList, $beanFiles;
	
	$error = new SoapError();

	if(!validate_authenticated($session)){
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>'LBL_ERROR_MODULE_INVALID_LOGIN');
	}
    $using_cp = false;
	$field_name_map = array();

    if($module_name == 'CampaignProspects'){
        $module_name = 'Prospects';
        $using_cp = true;
    }
	if(empty($beanList[$module_name])){
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>'LBL_ERROR_MODULE_NOT_FOUND');
	}
	global $current_user;
	if(!check_modules_access($current_user, $module_name, 'read')){
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>'LBL_ERROR_MODULE_ACCESS_DENIED');
	}

	// If the maximum number of entries per page was specified, override the configuration value.
	if($max_results > 0){
		global $sugar_config;
		$sugar_config['list_max_entries_per_page'] = $max_results;
	}

	$class_name = $beanList[$module_name];
	require_once($beanFiles[$class_name]);

	eval('

class SugarBeanMSOverload extends '.$class_name.' {

	function get_list($order_by = "", $query = "", $row_offset = 0, $limit=-1, $max=-1, $show_deleted = 0, $singleSelect=false)
	{
		$GLOBALS["log"]->debug("get_list:  order_by = \'$order_by\' and query = \'$query\' and limit = \'$limit\'");
		if(isset($_SESSION[\'show_deleted\']))
		{
			$show_deleted = 1;
		}
		$order_by=$this->process_order_by($order_by, null);

		if($this->bean_implements(\'ACL\') && ACLController::requireOwner($this->module_dir, \'list\') )
		{
			global $current_user;
			$owner_where = $this->getOwnerWhere($current_user->id);
			
			//rrs - because $this->getOwnerWhere() can return \'\' we need to be sure to check for it and
			//handle it properly else you could get into a situation where you are create a where stmt like
			//WHERE .. AND \'\'

		}
		else {
			$owner_where = null;
		}
		if ($order_by) {
			if (preg_match(\'/.*order\s+by\s+/is\', $query)) {
				$queryOrderd = preg_replace(\'/(.*order\s+by\s+).*$/is\', \'\\1\'.$order_by, $query);
			}
			else {
				$queryOrderd = "$query ORDER BY $order_by";
			}
		}
		else {
			$queryOrderd = $query;
		}
		' . 

		'
		return $this->process_list_query($queryOrderd, $row_offset, $limit, $max, $owner_where);
	}

    function create_list_count_query($query)
    {
        // remove the \'order by\' clause which is expected to be at the end of the query
        $pattern = \'/\s(ORDER|GROUP) BY[^)]*$/is\';  // ignores the case
        $replacement = \'\';
        $query = preg_replace($pattern, $replacement, $query);
        //handle distinct clause
        $star = \'*\';
        if(substr_count(strtolower($query), \'distinct\')){
          	if (!empty($this->seed) && !empty($this->seed->table_name ))
          		$star = \'DISTINCT \' . $this->seed->table_name . \'.id\';
          	else
          		$star = \'DISTINCT \' . $this->table_name . \'.id\';

        }

    	// change the select expression to \'count(*)\'
    	$pattern = \'/SELECT(.*?)(\s){1}FROM(\s){1}/is\';  // ignores the case
    	$replacement = \'SELECT count(\' . $star . \') c FROM \';

    	//if the passed query has union clause then replace all instances of the pattern.
    	//this is very rare. I have seen this happening only from projects module.
    	//in addition to this added a condition that has  union clause and uses
    	//sub-selects.
    	if (strstr($query," UNION ALL ") !== false) {

    		//seperate out all the queries.
    		$union_qs=explode(" UNION ALL ", $query);
    		foreach ($union_qs as $key=>$union_query) {
        		$star = \'*\';
				preg_match($pattern, $union_query, $matches);
				if (!empty($matches)) {
					if (stristr($matches[0], "distinct")) {
			          	if (!empty($this->seed) && !empty($this->seed->table_name ))
			          		$star = \'DISTINCT \' . $this->seed->table_name . \'.id\';
			          	else
			          		$star = \'DISTINCT \' . $this->table_name . \'.id\';
					}
				} // if
    			$replacement = \'SELECT count(\' . $star . \') c FROM \';
    			$union_qs[$key] = preg_replace($pattern, $replacement, $union_query,1);
    		}
    		$modified_select_query=implode(" UNION ALL ",$union_qs);
    	} else {
	    	$modified_select_query = preg_replace($pattern, $replacement, $query,1);
    	}


		return $modified_select_query;
    }

}
	');
	
	$seed = new SugarBeanMSOverload();

	if(!$seed->ACLAccess('list'))
	{
		return array('result_count'=>-1, 'entry_list'=>array(), 'error'=>'LBL_ERROR_MODULE_ACCESS_DENIED');
	}
	if($query == ''){
		$where = '';
	}
	if($offset == '' || $offset == -1){
		$offset = 0;
	}

	   $response = $seed->get_list($order_by, $query, $offset,-1,-1,$deleted, true);

	$list = $response['list'];

	$output_list = array();

	// retrieve the vardef information on the bean's fields.
	$field_list = array();
	foreach($list as $value)
	{
		if(isset($value->emailAddress)){
			$value->emailAddress->handleLegacyRetrieve($value);
		}
		$value->fill_in_additional_detail_fields();
		$output_list[] = get_return_value($value, $module_name, true);
		if(empty($field_list)){
			$field_list = get_field_list($value);
			$field_name_map = $value->field_name_map;
		}
	}
	// Calculate the offset for the start of the next page
	$next_offset = $offset + sizeof($output_list);

	return array(
		'row_count' => $response['row_count'], 
		'result_count' => sizeof($output_list), 
		'next_offset' => $next_offset,
		'field_list' => $field_list, 
		'entry_list' => $output_list,
		'field_name_map' => $field_name_map,
	);
}


function handle_set_entries($module_name, $name_value_lists) {
	global $beanList, $beanFiles, $app_strings, $app_list_strings;

	validate_authenticated(session_id());

	$error = new SoapError();
	$ret_values = array();

	if(empty($beanList[$module_name])){
		$error->set_error('no_module');
		return array('ids'=>array(), 'error'=>$error->get_soap_array());
	}
	global $current_user;
	if(!check_modules_access($current_user, $module_name, 'write')){
		$error->set_error('no_access');
		return array('ids'=>-1, 'error'=>$error->get_soap_array());
	}

	$class_name = $beanList[$module_name];
	require_once($beanFiles[$class_name]);
	$ids = array();
	$count = 1;
	$total = sizeof($name_value_lists);
	foreach($name_value_lists as $name_value_list){
		$seed = new $class_name();

		$seed->update_vcal = false;

		foreach ($seed->field_defs as $f => $p) {
			if ($p['type'] == 'code') {
				$name = $p['name'];
				$seed->field_defs[$f]['type'] = 'varchar';
			}
		}
		foreach($name_value_list as $value){
			if($value['name'] == 'id'){
				$seed->retrieve($value['value']);
				break;
			}
		}
		foreach($name_value_list as $value) {
			$val = $value['value'];
			switch ($seed->field_name_map[$value['name']]['type']) {
				case 'enum':
					$vardef = $seed->field_name_map[$value['name']];
					if(isset($app_list_strings[$vardef['options']]) && (!is_scalar($value) || !isset($app_list_strings[$vardef['options']][$value])) ) {
						if ( in_array($val,$app_list_strings[$vardef['options']]) ){
							$val = array_search($val,$app_list_strings[$vardef['options']]);
						}
					}
					break;
				
				case 'bool':
					$val = ($val == $app_strings['LBL_SEARCH_DROPDOWN_YES']) ? 1 : 0;
					break;
			}
			$seed->$value['name'] = $val;
		}

		if($count == $total){
			$seed->update_vcal = false;
		}
		$count++;

		//Add the account to a contact
		if($module_name == 'Contacts'){
			$GLOBALS['log']->debug('Creating Contact Account');
			add_create_account($seed);
			$duplicate_id = check_for_duplicate_contacts($seed);
			if($duplicate_id == null){
				if($seed->ACLAccess('Save') && ($seed->deleted != 1 || $seed->ACLAccess('Delete'))){
					$seed->save();
					if($seed->deleted == 1){
						$seed->mark_deleted($seed->id);
					}
					$ids[] = $seed->id;
				}
			}
			else{
				//since we found a duplicate we should set the sync flag
				if( $seed->ACLAccess('Save')){
					$seed->id = $duplicate_id;
					$seed->contacts_users_id = $current_user->id;
					$seed->save();
					$ids[] = $duplicate_id;//we have a conflict
				}
			}
		}
		else if($module_name == 'Meetings' || $module_name == 'Calls'){
			//we are going to check if we have a meeting in the system
			//with the same outlook_id. If we do find one then we will grab that
			//id and save it
			if( $seed->ACLAccess('Save') && ($seed->deleted != 1 || $seed->ACLAccess('Delete'))){
				if(empty($seed->id) && !isset($seed->id)){
					if(!empty($seed->outlook_id) && isset($seed->outlook_id)){
						//at this point we have an object that does not have
						//the id set, but does have the outlook_id set
						//so we need to query the db to find if we already
						//have an object with this outlook_id, if we do
						//then we can set the id, otherwise this is a new object
						$order_by = "";
						$query = $seed->table_name.".outlook_id = '".$seed->outlook_id."'";
						$response = $seed->get_list($order_by, $query, 0,-1,-1,0);
						$list = $response['list'];
						if(count($list) > 0){
							foreach($list as $value)
							{
								$seed->id = $value->id;
								break;
							}
						}//fi
					}//fi
				}//fi
				if (empty($seed->reminder_time)) {
                    $seed->reminder_time = -1;
                }
				if($seed->reminder_time == -1){
					$defaultRemindrTime = $current_user->getPreference('reminder_time');
					if ($defaultRemindrTime != -1){
                        $seed->reminder_checked = '1';
                        $seed->reminder_time = $defaultRemindrTime;
					}
				}
				$seed->save();
				$ids[] = $seed->id;
				foreach($name_value_list as $value) {
					if ($value['name'] == 'contact_id') {
						if (!$seed->contacts) $seed->load_relationship('contacts');
						$seed->contacts->add($value['value']);
					}
				}
			}//fi
		}
		else
		{
			if( $seed->ACLAccess('Save') && ($seed->deleted != 1 || $seed->ACLAccess('Delete'))){
				$seed->save();
				$ids[] = $seed->id;
			}
		}
	}

	return array(
		'ids' => $ids,
		'error' => $error->get_soap_array()
	);
}

?>
