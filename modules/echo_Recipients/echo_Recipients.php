<?php
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
 
require_once('modules/echo_Recipients/echo_Recipients_sugar.php');
class echo_Recipients extends echo_Recipients_sugar {
	
	public $agreement_status;
	
	
	function echo_Recipients(){	
		parent::echo_Recipients_sugar();
	}
	
	
	function save($notify = false)
	{
		if(!empty($this->parent_name))
		{
			$this->name = $this->parent_name;
			$email = new EmailAddress();          
        	$this->email_address = $email->getPrimaryAddress($this, $this->parent_id, $this->parent_type);
		}
		else if(isset($_REQUEST['fax_number'])){
			$this->name = preg_replace("/[^0-9]/", "", $_REQUEST['fax_number']);	
		}
		else{
			$this->name = $this->email_address;
		}
	
		$this->signing_order = ($this->role === 'CC') ? null : $this->_get_next_signing_order();
		
		
		if(empty($this->assigned_user_id)){
			global $current_user;
			$this->assigned_user_id = $current_user->id;
			
		}
		
		if(!empty($this->name))
			parent::save($notify);
			
	}
	
	
	function get_list_view_data()
	{
		$fields = parent::get_list_view_data();
		$fields['AGREEMENT_DATE_SIGNED'] = null;
		$fields['AGREEMENT_DATE_SENT'] = null;
		$fields['AGREEMENT_STATUS'] = null;
		
		$this->load_relationship('echo_agreements_echo_recipients');
		$agreements = $this->echo_agreements_echo_recipients->get();
		if(count($agreements) > 0){
			$agreement = new echo_Agreements();
			$agreement->retrieve($agreements[0]);
			
			$fields['AGREEMENT_DATE_SIGNED'] = $agreement->date_signed;
			$fields['AGREEMENT_DATE_SENT'] = $agreement->date_sent;
			$fields['AGREEMENT_STATUS'] = $agreement->status;
		}
		
		return $fields;
	}
	
	
	function fill_in_additional_detail_fields(){
		parent::fill_in_additional_detail_fields();
		
		$this->load_relationship('echo_agreements_echo_recipients');
		$agreements = $this->echo_agreements_echo_recipients->get();
		if(count($agreements) > 0){
			$agreement = new echo_Agreements();
			$agreement->retrieve($agreements[0]);
			$this->agreement_date_signed = $agreement->date_signed;
			$this->agreement_date_sent = $agreement->date_sent;
			$this->agreement_status = $agreement->status;
		}
	}
	
	
	
	
	private function _get_next_signing_order()
	{
		$signing_number = 1;
		$agreement_id = null;
		
		// saving it from the editview
		if(!empty($this->echo_agree6a54eements_ida) && !is_object($this->echo_agree6a54eements_ida)){
			$agreement_id = $this->echo_agree6a54eements_ida;
		}
		// saving it from the subpanel
		else if(isset($_POST['return_module']) && $_POST['return_module'] == 'echo_Agreements'){
			$agreement_id = $_POST['return_id'];
		}
	
		if($agreement_id)
		{
			$agreement = new echo_Agreements();
			$agreement->retrieve($agreement_id);if($agreement && $agreement->id)
			{
				$recipients = $agreement->get_linked_beans('echo_agreements_echo_recipients', 'echo_Recipients');	
				foreach($recipients as $index => $r)
				{
					if($r->signing_order >= $signing_number)
						$signing_number = $r->signing_order+1;
				}
			}
		}
		
		return $signing_number;
	}
	
}
?>