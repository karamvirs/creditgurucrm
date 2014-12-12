<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*************************************************************************
*
* ADOBE CONFIDENTIAL
* ___________________
*
*  Copyright 2012 Adobe Systems Incorporated
*  All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains
* the property of Adobe Systems Incorporated and its suppliers,
* if any.  The intellectual and technical concepts contained
* herein are proprietary to Adobe Systems Incorporated and its
* suppliers and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material
* is strictly forbidden unless prior written permission is obtained
* from Adobe Systems Incorporated.
**************************************************************************/
class EchoSignAdmin
{
	public $wsdl_url = 'https://secure.echosign.com/services/EchoSignDocumentService15?wsdl';

	private $sugar_smarty;

	// store all modules and what their parent classes are
	private $module_parent_classes = array();
	private $module_names = array();
	
	// Which parent class types can be recipients
	private $recipient_classes = array('Person');
	
	// Ignore these modules - These will not display in the "Add the send button to these modules:" section
	private $ignore_modules = array('echo_Agreements', 'echo_Events', 'echo_Recipients', 'Emails', 'Campaigns', 
									'Forecasts', 'Products', 'Reports', 'Documents', 'KBDocuments');

	private $updated = false;

	// the admin template page
	private $path_to_template = 'custom/modules/Administration/tpls/echo_administration.tpl';

	
	
	
	public function __construct()
	{
		global $current_user;
		
		
		// Only allow admin users access to this page
		if (!is_admin($current_user)) 
			sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
	
		require_once('modules/Configurator/Configurator.php');
		require_once('include/Sugar_Smarty.php');
		
		$this->sugar_smarty = new Sugar_Smarty();
		$this->init_stuff();
		
		$configurator = new Configurator();
		$override = $configurator->readOverride();
		
		// If first time, set up the default values....
		if(!isset($override['echosign'])) 
			$this->set_up_default_config_settings();
		
		////////////////////////////////////////////////////////////
		////////// UPDATE THE CONFIG_OVERRIDE VALUES ///////////////
		////////////////////////////////////////////////////////////
		$updated = false;
		if(isset($_POST['update']))
		{
			$this->update_config_settings();
		}
		////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////
		
		// will spit out an error if the api url is no good
		if(!empty($override['echosign']['api_key']))
			$this->sync_users();
		
		
		$this->setup_admin_stuff();
	}
	
	
	
	/* Sync Sugar Users w/ EchoSign users */
	private function sync_users()
	{
		require_once('modules/Users/User.php');	
		require_once('custom/EchoSign/echosign.php');
		
		$sugar_user_beans = array();
		$echosign_users = array();
		
		// get a list of the users in Sugar
		$sugar_user = new User();
		$sugar_user_beans = $sugar_user->get_full_list();
		foreach($sugar_user_beans as $b){
			$u = new User();
			$u->retrieve($b->id);
			$b->email1 = $u->email1;
		}
		
		
		// get all of the users listed in echosign
		$e = new EchoSign();
		$users = $e->getUsersInAccount();
		
		
		if(!empty($users) && 
				!empty($users->getUsersInAccountResult) && 
				!empty($users->getUsersInAccountResult->userListForAccount) && 
				is_array($users->getUsersInAccountResult->userListForAccount->UserInfo)
		){
			
			foreach($users->getUsersInAccountResult->userListForAccount->UserInfo as $index => $echo_user)
			{
				$sugar_user = $e->get_sugar_user_from_email($sugar_user_beans, $echo_user->email);
   		 		if($sugar_user)
   		 		{
					if($sugar_user->echosign_user_key_c != $echo_user->userKey){
						$sugar_user->echosign_user_key_c = $echo_user->userKey;
						$sugar_user->save();
					}
				}					
			}
		}
	}
	
	
	
	
	
	
	private function set_up_default_config_settings()
	{
		$GLOBALS['sugar_config']['echosign']['api_key'] = '';
		$GLOBALS['sugar_config']['echosign']['wsdl_url'] = $this->wsdl_url;
		$GLOBALS['sugar_config']['echosign']['use_call_back_method'] = 1;
		$GLOBALS['sugar_config']['echosign']['show_agreements_inline'] = 1;
		$GLOBALS['sugar_config']['echosign']['recipients'][1] = 'Contacts';
		$GLOBALS['sugar_config']['echosign']['recipients'][2] = 'Users';
		$GLOBALS['sugar_config']['echosign']['recipients'][3] = 'Email';
		$GLOBALS['sugar_config']['echosign']['show_api_url'] = false;
		$GLOBALS['sugar_config']['echosign']['lock_down_agreements'] = true;
		$GLOBALS['sugar_config']['echosign']['allow_approvers'] = 1;
	}
	
	
	private function update_config_settings()
	{
		global $beanList, $sugar_config;
		
		$api_key = isset($_POST['echosign_api_key']) ? $_POST['echosign_api_key'] : null;
		$wsdl_url = isset($_POST['echosign_wsdl_url']) ? $_POST['echosign_wsdl_url'] : $this->wsdl_url;
		$use_callback = isset($_POST['use_call_back_method']) ? 1 : 0;
		$inline = isset($_POST['show_agreements_inline']) ? 1 : 0;
		$recipients = isset($_POST['recipients']) ? $_POST['recipients'] : array();
		$button_enabled_modules = isset($_POST['button_enabled_modules']) ? $_POST['button_enabled_modules'] : array();
		$show_api_url = (isset($_POST['echosign_wsdl_url'])) ? true : false;
		$lock_down_agreements = isset($_POST['lock_down_agreements']) ? 1 : 0;
		$allow_approvers = isset($_POST['allow_approvers']) ? 1 : 0;
		
		
		$configurator = new Configurator();
		$configurator->config['echosign'] = array('api_key' => $api_key, 
												  'wsdl_url' => $wsdl_url,
												  'use_call_back_method' => $use_callback,
												  'show_agreements_inline' => $inline,
												  'recipients' => $this->set_recipients_for_save($recipients, $configurator),
												  'button_enabled_modules' => $this->set_enabled_modules_for_save($button_enabled_modules, $configurator),
												  'show_api_url' => $show_api_url,
												  'lock_down_agreements' => $lock_down_agreements,
												  'allow_approvers' => $allow_approvers,
											); 
		$configurator->handleOverride();
	
		$GLOBALS['sugar_config']['echosign']['api_key'] = $api_key;
		$GLOBALS['sugar_config']['echosign']['wsdl_url'] = $wsdl_url;
		$GLOBALS['sugar_config']['echosign']['use_call_back_method']= $use_callback;
		$GLOBALS['sugar_config']['echosign']['show_agreements_inline'] = $inline;
		$GLOBALS['sugar_config']['echosign']['recipients'] = $recipients;
		$GLOBALS['sugar_config']['echosign']['button_enabled_modules'] = $button_enabled_modules;
		$GLOBALS['sugar_config']['echosign']['show_api_url'] = $show_api_url;
		$GLOBALS['sugar_config']['echosign']['lock_down_agreements'] = $lock_down_agreements;
		$GLOBALS['sugar_config']['echosign']['allow_approvers'] = $allow_approvers;
		
		include_once ('modules/Administration/QuickRepairAndRebuild.php') ;
        $repair = new RepairAndClear();
		
		$class_names = array();
		foreach($this->module_parent_classes as $m => $parent_class){
			if(in_array($parent_class, $this->recipient_classes)){
				$class_names[] = $beanList[$m]; 
			}
		}
		
		// make sure the subpanels exists on the appropriate modules and that the dropdown of recipients is correct.
		$this->set_up_recipient_subpanels($recipients);
		
		$this->update_recipient_dropdown($recipients);
		$this->update_echosign_roles_dropdown($GLOBALS['sugar_config']['echosign']['allow_approvers']);
		$this->update_button_enabled_modules($button_enabled_modules);
		
		//$repair->repairAndClearAll(array('rebuildExtensions'), $class_names, true, false);
		//$repair->repairAndClearAll(array('rebuildExtensions'), $class_names, true, false);
		
		$this->updated = true;
	}
	
	
	private function update_button_enabled_modules($enabled_modules)
	{
		// nothing to do
	
	}
	
	
	
	private function update_recipient_dropdown($recipients)
	{
		require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
		require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');
        $parser = new ParserDropDown ( ) ;
        
        $dropdown = array();
        $dropdown['dropdown_name'] = 'echosign_parent_type_display';
        $dropdown['dropdown_lang'] = 'en_us';
        $dropdown['view_package'] = 'studio';
        $dropdown['module'] = 'ModuleBuilder';
        $dropdown['action'] = 'savedropdown';
        
        $list_values = array();
        $list_values[] = '[["-blank-",""]';
        foreach($recipients as $v)
        {
        	// email and users are not modules
        	$name = isset($this->module_names[$v]) ? htmlentities($this->module_names[$v]) : $v;
        	$list_values[] = '["'.$v.'","'.$name.'"]';	
        }
        $list_values[] = '["Fax","Fax"]]';
        
        $dropdown['list_value'] = implode(",", $list_values);
        
        $parser->saveDropDown($dropdown);
	}
	
	private function update_echosign_roles_dropdown($allow)
	{
		global $app_list_strings;
		
		if($allow && !empty($app_list_strings['echosign_role_list']['Approver']))
			return;
		
		if(!$allow && empty($app_list_strings['echosign_role_list']['Approver']))
			return;
			
		require_once('modules/ModuleBuilder/MB/ModuleBuilder.php');
		require_once('modules/ModuleBuilder/parsers/parser.dropdown.php');
        $parser = new ParserDropDown ( ) ;
        
        $dropdown = array();
        $dropdown['dropdown_name'] = 'echosign_role_list';
        $dropdown['dropdown_lang'] = 'en_us';
        $dropdown['view_package'] = 'studio';
        $dropdown['module'] = 'ModuleBuilder';
        $dropdown['action'] = 'savedropdown';
        
        $list_values = array();
        $list_values[] = '["Signer","Signer"]';
        $list_values[] = '["CC","CC"]';
        
        if($allow)
        	 $list_values[] = '["Approver","Approver"]';	
        
        $dropdown['list_value'] = '['.implode(",", $list_values).']';
        
        $parser->saveDropDown($dropdown);
	}
	
	
	
	private function set_recipients_for_save($new_recipients, $configurator)
	{
		if(isset($configurator->config['echosign']) && isset($configurator->config['echosign']['recipients'])){
			foreach($configurator->config['echosign']['recipients'] as $index => $value){
				if(!isset($new_recipients[$index]))
					$new_recipients[$index] = '';
			}
		}
		
		return $new_recipients;
	}
	
	
	private function set_enabled_modules_for_save($button_enabled_modules, $configurator)
	{
		if(isset($configurator->config['echosign']) && isset($configurator->config['echosign']['button_enabled_modules'])){
			foreach($configurator->config['echosign']['button_enabled_modules'] as $index => $value){
				if(!isset($button_enabled_modules[$index]))
					$button_enabled_modules[$index] = '';
			}
		}
		
		return $button_enabled_modules;
	}
	
	
	
	private function setup_admin_stuff()
	{
		global $sugar_config, $mod_strings, $app_strings, $beanList;

		$api_key = $wsdl_url = $echosign_quote_pdf = $use_call_back_method = $show_agreements_inline = $allow_approvers = '';
		$button_enabled_modules = array();
		$recipients = array();
		
		if(isset($GLOBALS['sugar_config']) && isset($GLOBALS['sugar_config']['echosign']))
		{ 
			$api_key = isset($GLOBALS['sugar_config']['echosign']['api_key']) ?  $GLOBALS['sugar_config']['echosign']['api_key'] : '';
			$wsdl_url = isset($GLOBALS['sugar_config']['echosign']['wsdl_url']) ?  $GLOBALS['sugar_config']['echosign']['wsdl_url'] : $this->wsdl_url;
			$recipients = isset($GLOBALS['sugar_config']['echosign']['recipients']) ?  $GLOBALS['sugar_config']['echosign']['recipients'] : array();
			$button_enabled_modules = isset($GLOBALS['sugar_config']['echosign']['button_enabled_modules']) ?  $GLOBALS['sugar_config']['echosign']['button_enabled_modules'] : array();
			$use_call_back_method = isset($GLOBALS['sugar_config']['echosign']['use_call_back_method']) ? $GLOBALS['sugar_config']['echosign']['use_call_back_method'] : '';
			$show_agreements_inline = isset($GLOBALS['sugar_config']['echosign']['show_agreements_inline']) ? $GLOBALS['sugar_config']['echosign']['show_agreements_inline'] : '';
			$lock_down_agreements = isset($GLOBALS['sugar_config']['echosign']['lock_down_agreements']) ? $GLOBALS['sugar_config']['echosign']['lock_down_agreements'] : true;
			$allow_approvers = isset($GLOBALS['sugar_config']['echosign']['allow_approvers']) ? $GLOBALS['sugar_config']['echosign']['allow_approvers'] : true;
		}
		
		$allow_approvers_checked = $allow_approvers ? 'checked="checked" ': '';
		$call_back_checked = $use_call_back_method ? 'checked="checked" ' : '';
		$inline_checked = $show_agreements_inline ? 'checked="checked" ' : '';
		$lock_down_agreements_checked = $lock_down_agreements ? 'checked="checked" ' : '';
		$show_api_url = isset($sugar_config['echosign']) && isset($sugar_config['echosign']['show_api_url']) ? $sugar_config['echosign']['show_api_url'] : false;
		
		
		$this->sugar_smarty->assign('MOD', $mod_strings);
		$this->sugar_smarty->assign('APP', $app_strings);
		$this->sugar_smarty->assign('API_KEY', $api_key);
		$this->sugar_smarty->assign('WSDL_URL', $wsdl_url);
		$this->sugar_smarty->assign('UPDATED', $this->updated);
		$this->sugar_smarty->assign('SHOW_API_URL', $show_api_url);
		
		$this->sugar_smarty->assign('USE_CALL_BACK_METHOD', $call_back_checked);
		$this->sugar_smarty->assign('SHOW_INLINE_AGREEMENTS', $inline_checked);
		$this->sugar_smarty->assign('LOCK_DOWN_AGREEMENTS_CHECKED', $lock_down_agreements_checked);
		$this->sugar_smarty->assign("RECIPIENTS_TABLE", $this->set_up_recipient_table($recipients));
		$this->sugar_smarty->assign('ALLOW_APPROVERS', $allow_approvers_checked);
		
		$js = "if(document.getElementById('echosign_api_key').value != ''){ ajaxStatus.flashStatus('".addslashes(translate('LBL_ECHOSIGN_SAVING'))."', 4000);}else{ alert('Please enter the EchoSign API key'); return false; }";
		$this->sugar_smarty->assign("CUSTOM_JS", $js);
	
		
		$this->sugar_smarty->display($this->path_to_template);	
	}
	
	
	
	private function set_up_recipient_subpanels($recipients)
	{
		global $beanList;
		
		$no_subpanel_modules = array('Email', 'Users');
	
		
		// delete the recipients layoutdefs and vardefs for modules not activitated.
		foreach($this->module_parent_classes as $m => $parent_class){
			if(in_array($parent_class, $this->recipient_classes)){
				if(!is_array($recipients) || count($recipients) < 1 || (is_array($recipients) && !in_array($m, $recipients))){
					if(file_exists('custom/Extension/modules/'.$m.'/Ext/Vardefs/echosign_'.strtolower($m).'.vardefs.php')){
						unlink('custom/Extension/modules/'.$m.'/Ext/Vardefs/echosign_'.strtolower($m).'.vardefs.php');
					}
				}
				if(!is_array($recipients) || count($recipients) < 1 || (is_array($recipients) && !in_array($m, $recipients))){
					if(file_exists('custom/Extension/modules/'.$m.'/Ext/Layoutdefs/echosign_'.strtolower($m).'.layoutdefs.php')){
						unlink('custom/Extension/modules/'.$m.'/Ext/Layoutdefs/echosign_'.strtolower($m).'.layoutdefs.php');
					}
				}
			}
		}
		
	
		if(is_array($recipients)){
			foreach($recipients as $index => $module){
				if(isset($beanList[$module]) && !in_array($module, $no_subpanel_modules)){
					//echo 'creating subpanels for '.$module.'<br />';
					$this->write_vardefs($module);
					$this->write_layoutdefs($module);
				}
			}
		}
	}
	
	
	private function write_vardefs($module)
	{
		$vardefs_file = 'custom/Extension/modules/'.$module.'/Ext/Vardefs/echosign_'.strtolower($module).'.vardefs.php';
		$vardefs_dir = 'custom/Extension/modules/'.$module.'/Ext/Vardefs';
	
		if(!file_exists($vardefs_file))
		{
			global $beanList;
			$bean = $beanList[$module];
			
			if(!is_dir($vardefs_dir))
				sugar_mkdir($vardefs_dir, null, true);
			
			
			$vardefs = '<?php
$dictionary[\''.$bean.'\'][\'fields\'][\'echo_Recipients\'] = array (
	\'name\' => \'echo_Recipients\',
	\'type\' => \'link\',
	\'relationship\' => \'echo_Recipients_'.strtolower($module).'_c\',
	\'module\'=>\'echo_Recipients\',
	\'bean_name\'=>\'echo_Recipients\',
	\'source\'=>\'non-db\',
	\'vname\'=>\'LBL_'.strtoupper($module).'\');
					 
					 
$dictionary[\''.$bean.'\'][\'relationships\'][\'echo_Recipients_'.strtolower($module).'_c\'] = array(
	\'lhs_module\'=> \''.$module.'\',
	\'lhs_table\'=> \''.strtolower($module).'\',
	\'lhs_key\' => \'id\',
	\'rhs_module\'=> \'echo_Recipients\',
	\'rhs_table\'=> \'echo_recipients\',
	\'rhs_key\' => \'parent_id\',
	\'relationship_type\'=>\'one-to-many\');
?>';
			
			sugar_file_put_contents($vardefs_file, $vardefs);
		}
	}
	
	
	private function write_layoutdefs($module)
	{
		$layoutdefs_file = 'custom/Extension/modules/'.$module.'/Ext/Layoutdefs/echosign_'.strtolower($module).'.layoutdefs.php';
		$layoutdefs_dir = 'custom/Extension/modules/'.$module.'/Ext/Layoutdefs';
		
		if(!file_exists($layoutdefs_file))
		{
			if(!is_dir($layoutdefs_dir))
				sugar_mkdir($layoutdefs_dir, null, true);
			
			
			$layoutdefs = '<?php
$layout_defs[\''.$module.'\'][\'subpanel_setup\'][\'echo_recipients\'] = array(
	\'order\' => 1,
	\'module\' => \'echo_Recipients\',
	\'subpanel_name\' => \'forRecipients\',
	\'sort_order\' => \'asc\',
	\'sort_by\' => \'id\',
	\'get_subpanel_data\' => \'echo_Recipients\',
	\'add_subpanel_data\' => \'parent_id\',
	\'title_key\' => \'EchoSign Agreements\',
	\'top_buttons\' => array(
		array(\'widget_class\' => \'SubPanelTopButtonEchoSignNewAgreement\'),
	),
);
?>';
			sugar_file_put_contents($layoutdefs_file, $layoutdefs);
			
		}
	}	
	
	
	
	
	// set up the module_parent_classes array
	private function init_stuff()
	{
		global $moduleList, $modInvisList, $beanFiles, $beanList;
		
		sort($moduleList);
		
		foreach($moduleList as $m){
			if(empty($modInvisList[$m])){
				
				if(isset($beanList[$m]))
				{
					$obj = $beanList[$m];
					
					if(file_exists($beanFiles[$obj]) && !isset($modInvisList[$m]) && !in_array($m,$this->ignore_modules)){
						include_once($beanFiles[$obj]);
						$bean = new $obj();
					
						$parent_class = get_parent_class($bean);
					
						$this->module_parent_classes[$m] = $parent_class;
						$this->module_names[$m] = translate('LBL_MODULE_NAME', $m);
						
						// custom modules end w/ _sugar, need to get the parent class of this obj (only care about people and companies)
						if(substr($parent_class, strlen($parent_class)-6) == '_sugar'){
							if(is_subclass_of($bean, 'Person'))
								$this->module_parent_classes[$m] = 'Person';
							else if(is_subclass_of($bean, 'Company'))
								$this->module_parent_classes[$m] = 'Company';
						}
					}
				}
			}
		}
	}
	
	
	
	
	// set up the recipients table - $modules_exempt_from_availability_check
	private function set_up_recipient_table($recipients)
	{
		$recipient_table = '<table>';
		
		foreach($this->module_parent_classes as $m => $parent_class)
		{
			if(in_array($parent_class, $this->recipient_classes)){
				$recipient_table .= '<tr><td><input type="checkbox" name="recipients[]" value="'.$m.'" ';
				if($this->echo_is_checked($m, $recipients)) $recipient_table .= 'checked="checked" ';
				$recipient_table .= '/></td><td>'.$this->module_names[$m].'</td></tr>';	
			}
		}
		
		$users_checked = $this->echo_is_checked('Users', $recipients) ? 'checked="checked" ' : '';
		$email_checked = $this->echo_is_checked('Email', $recipients) ? 'checked="checked" ' : '';
		
		$recipient_table .= '<tr><td><input type="checkbox" name="recipients[]" value="Users" '.$users_checked.'/></td><td>Users</td></tr>';
		$recipient_table .= '<tr><td><input type="checkbox" name="recipients[]" value="Email" '.$email_checked.'/></td><td>Email</td></tr>';
		$recipient_table .= '</table>';
		
		return $recipient_table;
	}
	
	
	
	
	
	
	private function echo_is_checked($val, $array)
	{
		if(empty($array)) return false;
		foreach($array as $k => $v){ if($v === $val) return true; }
		return false;
	}

}

$e = new EchoSignAdmin();

