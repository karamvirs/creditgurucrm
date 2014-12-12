<?php
ini_set('display_errors', 'Off');

error_reporting(0);
if(!defined('sugarEntry'))define('sugarEntry', true);
define('nocrm', true);
require_once('include/utils.php');
require_once('include/SugarObjects/VardefManager.php');
require_once('config.php');
require_once('config_override.php');
require_once('include/SugarObjects/SugarConfig.php'); 
require_once('include/utils/file_utils.php');
require_once('include/utils/sugar_file_utils.php');
require_once('include/utils/LogicHook.php');
require_once('include/SugarLogger/LoggerManager.php');
require_once('include/SugarObjects/LanguageManager.php');
$GLOBALS['log'] = LoggerManager::getLogger('SugarCRM');
require_once('include/TimeDate.php');
require_once('include/database/DBManagerFactory.php');
require_once('data/SugarBean.php');
require_once('include/SugarObjects/templates/basic/Basic.php');
require_once('include/clean.php');
require_once('include/SugarEmailAddress/SugarEmailAddress.php');
require_once('include/Localization/Localization.php');
$locale = new Localization();
require_once('modules/UserPreferences/UserPreference.php');
require_once('./modules/sc_StripePayments/Payments.php'); 
$timedate = TimeDate::getInstance();

$db = DBManagerFactory::getInstance();
$GLOBALS['db'] = $db;
if(isset($_GET['method']) && $_GET['method'] == 'refund' && !empty($_GET['token'])){
	refund_charge();
}else{
	process_form();
}
  
function process_form(){
	
	$payments = new Payments();
	$data = $_POST;
	//print_r($data);
	$record_id = $payments->make_charge($data);
	//die($record_id);
	if(!is_array($record_id)){
		//header('Location: payment_success.php');
		//header('Location: index.php?module=sc_StripePayments&action=DetailView&record='.$record_id);
		die("<h1>Thank you, payment successful.</h1>");
	}else{
		die($record_id['message']);
	}
	
}

function refund_charge(){
	$payments = new Payments();
	$token = $_GET['token'];
	$record_id = $payments->refund_charge($token);
	//die($record_id);
	if(!is_array($record_id)){
		header('Location: index.php?module=sc_StripePayments&action=DetailView&record='.$record_id);
		die();
	}else{
		die($record_id['message']);
	}

}

?>
