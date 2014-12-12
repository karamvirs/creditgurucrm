<?php 
$obj = new RecordData();
if(isset($_REQUEST['method']) && $_REQUEST['method'] == 'get_data'){
	$obj->get_data();
}

class RecordData  {

	var $_db;
	var $_bean;

	var $focus_id;
	var $focus_type;
	
	
	public function __construct(){
		$this->_bean = new SugarBean();
		$this->_db = $this->_bean->db;
		$this->focus_id = strtolower($_REQUEST['focus_id']);
		$this->focus_type = strtolower($_REQUEST['focus_type']);
	}
	
	public function get_data(){
		$data = array();
		if($this->focus_type == 'accounts'){
			require_once('modules/Accounts/Account.php');
			$acc = new Account();
			$acc->retrieve($this->focus_id);
			$data[] = array(
				'name' => 'address_line1',
				'value' => $acc->billing_address_street
			);	
			$data[] = array(
				'name' => 'address_zip',
				'value' => $acc->billing_address_postalcode
			);	
			$data[] = array(
				'name' => 'address_state',
				'value' => $acc->billing_address_state
			);	
			$data[] = array(
				'name' => 'address_country',
				'value' => $acc->billing_address_country
			);
			$data[] = array(
				'name' => 'address_city',
				'value' => $acc->billing_address_city
			);	
		}else if($this->focus_type == 'leads'){
			require_once('modules/Leads/Lead.php');
			$lead = new Lead();
			$lead->retrieve($this->focus_id);
			$data[] = array(
				'name' => 'address_line1',
				'value' => $lead->primary_address_street
			);	
			$data[] = array(
				'name' => 'address_zip',
				'value' => $lead->primary_address_postalcode
			);	
			$data[] = array(
				'name' => 'address_state',
				'value' => $lead->primary_address_state
			);	
			$data[] = array(
				'name' => 'address_country',
				'value' =>  $lead->primary_address_country
			);
			$data[] = array(
				'name' => 'address_city',
				'value' =>  $lead->primary_address_city
			);
		}else if($this->focus_type == 'contacts'){
			require_once('modules/Contacts/Contact.php');
			$con = new Contact();
			$con->retrieve($this->focus_id);
			$data[] = array(
				'name' => 'address_line1',
				'value' => $con->primary_address_street
			);	
			$data[] = array(
				'name' => 'address_zip',
				'value' => $con->primary_address_postalcode
			);	
			$data[] = array(
				'name' => 'address_state',
				'value' => $con->primary_address_state
			);	
			$data[] = array(
				'name' => 'address_country',
				'value' =>  $con->primary_address_country
			);
			$data[] = array(
				'name' => 'address_city',
				'value' =>  $con->primary_address_city
			);
		}
		
		echo json_encode($data);
		die();
	}
}


?>