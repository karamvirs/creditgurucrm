<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
* Comments go here
* Created By Superlative Code
* 1/20/2012
**/

//Require Files
require_once("modules/sc_StripePayments/lib/Stripe.php");
require_once("modules/sc_StripePayments/sc_StripePayments.php");
require_once('data/SugarBean.php');

//Debug Code


class Payments  {
	/**
	* Definitions
	**/
	var $test_mode = true;
	var $_db;
	var $_bean;
	var $settings;
	//TODO
	var $focus_id;
	var $focus_type;
	var $payment_record_id;
	
	/**
	* Methods
	**/
	
	public function __construct(){
		$this->_bean = new SugarBean();
		$this->_db = $this->_bean->db;
		$this->get_settings();
		Stripe::setApiKey($this->settings['secret_key']);
		$this->focus_id = strtolower($_REQUEST['focus_id']);
		$this->focus_type = strtolower($_REQUEST['focus_type']);
	}
	
	/**
	* Public
	**/
	
	public function make_charge($data){
		// Use Stripe's bindings...
		$_charge = Stripe_Charge::create(array('card' => $data['stripeToken'], 'amount' => $this->convert_to_cents($data['amount']), 'currency' => $this->settings['currency']));
		$string = (string)$_charge;
		$charge = json_decode($string, true);
		$this->handle_response($charge);
		//Continue Here
		return $this->payment_record_id;
	}
	
	public function create_charge_api($focus_type, $focus_id, $stripe_token){
		$this->focus_type = $focus_type;
		$this->focus_id = $focus_id;
		$_charge = Stripe_Charge::create(array('card' => $stripe_token, 'amount' => $this->convert_to_cents($data['amount']), 'currency' => $this->settings['currency']));
		$string = (string)$_charge;
		$charge = json_decode($string, true);
		return $this->handle_response($charge);
	}
	
	/**
	* Private
	**/
	
	//TODO
	private function handle_response($charge){
		require_once("modules/sc_StripePayments/ResponseMap.php");
		//CONVERT RESPONSE TO SUGAR FIELDS
		$data = array();
		foreach($charge as $key => $val){
			if(is_array($val)){
				foreach($val as $subkey => $subval){
					if(isset($map[$key . '.' . $subkey])){
						$new_val = $map[$key . '.' . $subkey]['name'];
						$convert_function = $map[$key . '.' . $subkey]['convert_function'];
						if($convert_function !== false && method_exists($this, $convert_function)){
							$data[$new_val] = $this->$convert_function($subval);
						}else{
							$data[$new_val] = $subval;
						}	
					}
				}
			}else{
				if(isset($map[$key])){
					$new_val = $map[$key]['name'];
					$convert_function = $map[$key]['convert_function'];
					if($convert_function !== false && method_exists($this, $convert_function)){
						$data[$new_val] = $this->$convert_function($val);
					}else{
						$data[$new_val] = $val;
					}	
				}
			}
		}
		var_dump($data);
		$this->save_to_sugar($data);
		return true;
	}
	
	//TODO
	private function save_to_sugar($data){
		//USE CONVERTED RESPONSE TO SAVE TO NEW StipePayment Bean
		$sp = new sc_StripePayments();
		$sp->name = 'Payment ' . $data['stripe_id'];
		foreach($data as $field => $value){
			if(!is_null($value) && !empty($value) && property_exists($sp, $field)){
				echo "GF :: " . $value;
				$sp->{$field} = $value;
			}else{
				echo "IO :: " . $value;
			}
		}
		$sp->save();
		$this->payment_record_id = $sp->id;
		if($rel_table = $this->get_rel_table()){
			$sp->load_relationship($rel_table);
			$sp->{$rel_table}->add($this->focus_id);
		}
		return true;
	}
	
	private function get_rel_table(){
		switch(strtolower($this->focus_type)){
			case 'accounts':
				return 'sc_stripepayments_accounts';
			case 'contacts':
				return 'sc_stripepayments_contacts';
			case 'leads':
				return 'sc_stripepayments_leads';
			default:
			 	return false;		
		}
	}
	
	private function get_settings(){
		require_once('modules/sc_StripePayments/config.php');
		$this->settings = $settings;
	}
	
	private function get_settings_db(){
		$sql = trim("
			SELECT
				*
			FROM
				config
			WHERE
				name LIKE 'sc_%'
				AND
				category LIKE 'Stripe'	
		");
		$results = $this->_db->query($sql);
		$settings = array();
		while($row = $this->_db->fetchByAssoc($results)){
			$key = str_ireplace('sc_', '', $row['name']);
			$settings[] = $row['value'];
		}
		return $this->settings = $settings;
	}
	
	//Converts SugarBean MySQL Results to an Array
	private function convert_results_to_array($results){
		$data = array();
		while($row = $this->_db->fetchByAssoc($results)){
			$data[] = $row;
		}
		return $data;
	}
	
	private function convert_to_cents($str){
		$float = (float) preg_replace('/[^0-9.]/', '', $str);
		$cents = round($float * 100);
		return $cents;
	}
	
	private function convert_cents_to_currency($cents){
		$float = (float) $cents;
		$cur = round($float / 100, 2);
		return $cur;
	}
}


?>