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

require_once('include/MVC/Controller/SugarController.php');
class echo_AgreementsController extends SugarController
{

	private $getSigningUrl_attempts = 50;



	public function __construct(){
		parent::__construct();
	}


	// Load the interactive view
	public function action_Interactive()
	{
		$GLOBALS['module'] = 'echo_Agreements';
		$GLOBALS['action'] = 'Interactive';
		$this->view = 'Interactive';
	}
	
	// Load the preview and postition view
	public function action_Preview()
	{
		$GLOBALS['module'] = 'echo_Agreements';
		$GLOBALS['action'] = 'Preview';
		$this->view = 'Preview';
	}
	
	
	// Call the checkStatus method and load the detail view
	public function action_CheckStatus()
	{
		$GLOBALS['action'] = 'DetailView';
       	$GLOBALS['module'] = 'echo_Agreements';
       	$this->bean->checkStatus();
		$this->view = 'Detail';
	}
	
	public function action_UpdateStatus(){
		$this->bean = new echo_Agreements();
		$this->bean->retrieve($_REQUEST['record']);
		
		$status = $this->bean->checkStatus();
		$return_data = array();
		$return_data['status_id'] = $status;
		echo json_encode($return_data);
	}
	
	
	// Call the SendReminder method and load the detail view
	public function action_SendReminder()
	{
		$GLOBALS['action'] = 'DetailView';
       	$GLOBALS['module'] = 'echo_Agreements';
       	$this->bean->SendReminder();
		$this->view = 'Detail';
	}
	
	
	// Call the cancel method and load the detail view.
	public function action_Cancel()
	{
		$GLOBALS['action'] = 'DetailView';
       	$GLOBALS['module'] = 'echo_Agreements';
       	$this->bean->cancel();
		$this->view = 'Detail';
	}





	/**
	 *	EchoSignNow
	 *
	 *  After sending the agreement, if the Host Signing for the Current Signer is checked, a popup
	 *  is opened w/ this url (index.php?module=echo_Agreements&action=EchoSignNow&to_pdf=1&record=xyz
	 *
	 *  Try getting the sigining url... it may take a minute or two for echosign to create the document and the url
	 *
	 **/
	public function action_EchoSignNow()
	{
		// It takes a little bit of time for EchoSign to get the url generated. Attemp to grab it $getSigningUrl_attempts times
		for($i = 0; $i < $this->getSigningUrl_attempts; $i++){
			echo ' ';
			$this->bean->signing_url = $this->bean->getSigningUrl($this->bean->document_key);
			if(!empty($this->bean->signing_url)){
				header("Location: ".$this->bean->signing_url);
				break;
			}
		}	
		if(empty($this->bean->signing_url)){
			die(translate('LBL_ERROR_SIGNING_URL'));
		}
	}
	
	

	
	
	
	/**
	 *	action_NewAgreement
	 *
	 *  For each type of recipient, on the subpanel there is a custom button to create an agreement. 
	 *  Clicking that button will call this action that creates a new agreement and attaches that
	 *  person to the agreement. 
	 **/
	public function action_NewAgreement()
	{
		if(empty($_POST['parent_id']) || empty($_POST['parent_type']))
		{
			$GLOBALS['action'] = 'index';
       		$GLOBALS['module'] = 'echo_Agreements';
			$this->view = 'List';
		}
		else
		{
			global $beanList, $beanFiles, $current_user;

			$parent_module = $_POST['parent_type'];
			$class_name = $beanList[$parent_module];
			$class_file_path = $beanFiles[$class_name];
			require_once($class_file_path);
			$obj = new $class_name();
			$obj->retrieve($_POST['parent_id']);
			
			// Create the agreement
			$a = new echo_Agreements();
			$a->document_name = $obj->name.' Agreement';
			$a->description = 'Please review and sign this document.';
			$a->assigned_user_id = $current_user->id;
			$a->save();
		
		
			// attach the account if the object has the account_id set (leads and contacts)
			if(!empty($obj->account_id)){
				$a->load_relationship('echo_agreements_accounts');
				$a->echo_agreements_accounts->add($obj->account_id);
			}
		
		
			// If the object in question has an email, then attach them as the first recipient.
			if(!empty($obj->id) && !empty($obj->email1))
			{	
				include_once('modules/echo_Recipients/echo_Recipients.php');
			
				$e = new echo_Recipients();
				$e->assigned_user_id = $current_user->id;
				
				$e->parent_type = $_POST['parent_type'];
				$e->parent_name = $obj->name;
				$e->parent_id = $obj->id;
				
				$e->email_address = $obj->email1;
				$e->role = 'Signer';
				$e->signing_order = 1;
				$e->save();
			
				$a->load_relationship('echo_agreements_echo_recipients');
				$a->echo_agreements_echo_recipients->add($e->id);
			}
		
			
			header("Location: index.php?module=echo_Agreements&action=DetailView&record=".$a->id);
		}
	}
	
	
	
	
	
	
	
	
	/**
	 *	action_CheckHasDocsAndRecipients
	 *
	 *	called via the send document button
	 *
	 **/
	public function action_SendDocumentAjax()
	{
		$check = $this->validate_agreement();
		
		$check['success'] = 0;
		$check['host_signing_for_first_signer'] = $this->bean->host_signing_for_first_signer;
		$check['record'] = $this->bean->id;
		
		require_once('custom/EchoSign/Browser.php');
		$browser = new Browser();
		$check['mobile'] = $browser->isMobile();
		
		// If the agreement has at least one document and one recipient attached, try to send it
		if($check['all_good'])
		{
			$result = $this->bean->sendDocument();
			if(!$result)
			{ 
//				$check['msg'] = $this->bean->echoSign->get_msg();
				
				// replace generic error for locale w/ upgrade msg
				if(strstr($check['msg'], 'is not a valid locale') !== false)
				{
					$check['msg'] = translate('LBL_OTHER_LANGUAGES');
				}
			}
			else
			{
				$check['success'] = 1;
				
				// if host signing and mobile, grab the url
				if($this->bean->host_signing_for_first_signer && $check['mobile']){
				
					// it takes echosign a little bit of time to process the documents and create a signing url
					for($i = 0; $i < $this->getSigningUrl_attempts; $i++){
						$check['host_signing_url'] = $this->bean->getSigningUrl($this->bean->document_key);
						if(!empty($check['host_signing_url']))
							break;
					}
				}
				
				
				if($this->bean->send_document_interactively){
					$check['iframe_url'] = str_replace('embed/', '', $result['iframe_url']);
					$check['interactive_url'] = $result['interactive_url'];
					$check['sendInteractively'] = true;
				}
			}
		}
		
		echo json_encode($check);
	}
	
	
	
	
	
	
	/**
	 *	validate_agreement
	 *
	 *  make sure the agreement has recpients and a document attached to it
	 *  Also make sure that the expiration date is not in the past.
	 *
	 **/
	private function validate_agreement()
	{
		global $timedate, $current_user;
		
		$return_data = array();
		$return_data['all_good'] = false;
		
		
		if(empty($this->bean->signers))
			$this->bean->signers = $this->bean->get_linked_beans('echo_agreements_echo_recipients', 'echo_Recipients');
 		
 		if(empty($this->bean->documents))
	 		$this->bean->documents = $this->bean->get_linked_beans('echo_agreements_documents', 'Document');	
 		
		
		$num_documents = count($this->bean->documents);

		$num_signers = 0;
		foreach($this->bean->signers as $index => $signer){
			if(strtolower($signer->role) == 'signer' || strtolower($signer->role) == 'approver'){ 
				$num_signers++;
			}
		}
		
		if(!$num_signers || !$num_documents)
		{
			if(count($this->bean->signers) < 1 && !$num_documents)
				$return_data['msg'] = translate('LBL_ERROR_NO_DOC_NO_RECIPIENT');
			else if(!$num_signers && count($this->bean->signers) > 0)
				$return_data['msg'] = translate('LBL_ERROR_NO_RECIPIENT');
			else if(!$num_signers)
				$return_data['msg'] = translate('LBL_ERROR_NO_RECIPIENT');
			else if(!$num_documents)
				$return_data['msg'] = translate('LBL_ERROR_NO_DOC');
		}
		else
		{
			$return_data['all_good'] = true;
		}
		
		return $return_data;
	}
	
	
	
	
	
	
	/**
	 *	CreateAgreementFromModule
	 *
	 *  You used to be able to add a little button to any module that would
	 *  create a new agreement. This was removed in the v2 version.
	 *  The only place you can still create an agreement from a module is the Quotes module.
	 *
	 **/
	public function action_CreateAgreementFromModule()
	{
		if((empty($_REQUEST['return_module']) && empty($_REQUEST['parent_module'])) || empty($_REQUEST['record']))
		{
			$GLOBALS['action'] = 'index';
       		$GLOBALS['module'] = 'echo_Agreements';
			$this->view = 'List';
		}
		else if((isset($_REQUEST['parent_module']) && $_REQUEST['parent_module'] == 'Quotes') || (isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Quotes'))
		{
			$_REQUEST['to_pdf'] = 1;
			$_REQUEST['sugarpdf'] = isset($_REQUEST['custom_sugarpdf']) ? $_REQUEST['custom_sugarpdf'] : $_REQUEST['return_action'];
			$GLOBALS['module'] = 'Quotes';
			$this->view = 'quotepdf';
		}
		else
		{
			$record = $_REQUEST['record'];
			$module = !empty($_REQUEST['return_module']) ? $_REQUEST['return_module'] : $_REQUEST['parent_module'];
			
			global $beanList, $beanFiles, $current_user;

			$bean = $beanList[$module];
			if(file_exists($beanFiles[$bean]))
			{
				include_once($beanFiles[$bean]);
			
				$obj = new $bean();
				$obj->retrieve($record);
				
				if($obj && $obj->id)
				{	
					// Create the Agreement 
					include_once('modules/echo_Agreements/echo_Agreements.php');
					$a = new echo_Agreements();
					$a->document_name = $obj->name;
					$a->assigned_user_id = $current_user->id;
					$a->save(false);
					
					// redirect to the detail view
					header("Location: index.php?module=echo_Agreements&action=DetailView&record=".$a->id);
				}
				else
				{
					$GLOBALS['module'] = 'echo_Agreements';
					$GLOBALS['action'] = 'index';
					$this->view = 'List';
				}
			}
			else{
				$GLOBALS['module'] = 'echo_Agreements';
				$GLOBALS['action'] = 'index';
				$this->view = 'List';
			}
		}
	}
}
