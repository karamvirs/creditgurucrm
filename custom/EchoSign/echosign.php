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

/**************************************************************************
 *
 * Name: EchoSign e-Signatures for SugarCRM
 * Version: 1.0.0
 * Date: 2011-05-25
 * Author: Epicom Corp.
 * Maintainer: support@epicom.com
 *
 * Based off EchoSign Document API Version 10 Methods  
 * (https://epicom.echosign.com/static/apiv10/apiMethods10.jsp)
 *
 *
 *
 ************************
 *
 * Document Methods
 *
 *   sendDocument
 *	 sendDocumentInteractive
 *   cancelDocument
 *	 sendReminder
 *
 *	 
 * Status Methods
 *
 *   getDocumentInfo
 *   getLatestDocument
 *   getDocumentByVersion
 *   getLatestImages
 *   getSigningUrl
 *
 *	 
 * User Methods
 *
 *   createUser
 *   verifyUser
 *   getUsersInAccount
 *   createAccount
 *
 *	 
 *******************************************************************************/


class EchoSign
{
	private $apiKey = '';
	private $url = 'https://secure.echosign.com/services/EchoSignDocumentService15?wsdl';
		
	public $result;
	public $error;
	public $msg = '';

	private $signedDocumentUrl = '';
	private $useCallBackMethod = false;
	
	private $s; 





	/**
	 *	Constructor
	 **/
	public function __construct()
	{	
		global $sugar_config;
		
		require_once('modules/Configurator/Configurator.php');
		$configurator = new Configurator();
		
		$echo_sign_settings = null;
		if(isset($configurator->config['echosign']))
	 		$echo_sign_settings = $configurator->config['echosign'];
 		
 		if(!$echo_sign_settings || !is_array($echo_sign_settings))
 			die('Echosign settings have not been setup. Ask your administrator to set them up.');
 		
 		if(isset($echo_sign_settings['wsdl_url']))
 			$this->url = $echo_sign_settings['wsdl_url'];
 		
 		
	
		$this->apiKey = $echo_sign_settings['api_key'];
		$this->useCallBackMethod = (!empty($echo_sign_settings['use_call_back_method']) && $echo_sign_settings['use_call_back_method'] == 1) ? true : false;
	
		try{
			$this->s = new SoapClient($this->url);
		}
		catch(Exception $e){
			$this->msg .=  'Error - '.$e->getMessage()."\r\n";	
			$this->error = 1;
		}
	
		// Uses the site_url from config.php --- if that is not set up correctly this will not work
		$site_url = $sugar_config['site_url'];
		if(substr($site_url, strlen($site_url)-1,1) != '/') $site_url .= '/';
		
		$sugar_extended_entry_points = array('6.3', '6.4', '6.5', '6.6');
		
		$this->signedDocumentUrl = in_array(substr($sugar_config['sugar_version'],0,3), $sugar_extended_entry_points) ? $site_url.'index.php?entryPoint=EchoSignUpdater' : $site_url.'echosign_updater_for62.php';
	}
		
		
		
	public function get_msg(){ return $this->msg; }
	
	
	
	
	/**********************************************************************************************************************
	 *	DOCUMENT METHODS
	 *
	 * sendDocument
	 * sendDocumentInteractive
	 * cancelDocument
	 * sendReminder
	 *
	  ***********************************************************************************************************************/
	
	
	/**
	 * Send Document 
	 *
	 *  Send Document is used to send a document out for signature. This is the main entry point into the EchoSign Document API. 
	 *    You will need to provide information about who the sender of the document is, who the recipient(s) are, the file(s) 
	 *	  that you'd like to send, and how you  want them signed. In addition, there is a variety of other optional flags that 
	 *	  control the workflow, described below. To retrieve the  signed final document, you may either poll for it using 
	 *	  getDocumentInfo or be notified using the CallbackInfo.
	 *
	 *
	 **/
	public function send_document($agreement)
	{
		if(!$this->s) return false;
	
		if($agreement->send_document_interactively){
			return $this->sendDocumentInteractive($agreement);
		}
		else
		{
			$params = array('apiKey' => $this->apiKey,
							'senderInfo' => $this->_get_sender_info($agreement),
							'documentCreationInfo' => $this->_getDocumentCreationInfo($agreement),
						);
	
			try{
				$result = $this->s->sendDocument($params);
				$this->msg .= "Document key is: {$result->documentKeys->DocumentKey->documentKey}<br />";
				
				return array('document_key' => $result->documentKeys->DocumentKey->documentKey);
				
			}
			catch(Exception $e){
				$this->msg .=  trim($e->getMessage())."\r\n";
				
				if(substr($this->msg, 0, 25) == "Invalid password for user") {
					$this->msg = substr_replace($this->msg, translate('LBL_ERROR_SENDING_ON_BEHALF_OF', 'echo_Agreements'), 0, 25);
				}
				else if(substr($this->msg,0,19) == 'Invalid email: null'){
					$this->msg = translate('LBL_ERROR_NO_EMAIL', 'echo_Agreements');
				}
				
				return false;
			}
		}
	}
	
	
	
	/**
	 * sendDocumentInteractive
	 *
	 *  sendDocumentInteractive is used to interactively send a document out for signature. 
	 *	You will need to provide information about who the sender of the document is, who the 
	 *	recipient(s) are, the file(s) that you'd like to send, and how you want them signed. In 
	 *	addition, there is a variety of other optional flags that control the workflow, described below. 
	 *	The resulting URL allows the user to complete any remaining steps of the sending process in a 
	 *	web browser. Additionally a code which can be embedded into existing pages is provided. 
	 *	To retrieve the signed final document, you may either poll for it using getDocumentInfo or 
	 *	be notified using the CallbackInfo.
	 *
	 *
	 **/
	public function sendDocumentInteractive($agreement)
	{
		$params = array('apiKey' => $this->apiKey,
						'senderInfo' => $this->_get_sender_info($agreement),
						'documentCreationInfo' => $this->_getDocumentCreationInfo($agreement),
						'sendDocumentInteractiveOptions' => $this->_getSendDocumentInteractiveOptions($agreement),
					);

		try{
			$return_data = array();
			
			$result = $this->s->sendDocumentInteractive($params);
			
			if($result && !empty($result->sendDocumentInteractiveResult))
			{
				if(!empty($result->sendDocumentInteractiveResult->errorMessage) || (!empty($result->sendDocumentInteractiveResult->errorCode) && $result->sendDocumentInteractiveResult->errorCode != 'OK')){
					$this->msg .=  trim($result->sendDocumentInteractiveResult->errorCode.' '.$result->sendDocumentInteractiveResult->errorMessage)."\r\n";
					return false;
				}else{
					$return_data['document_key'] = $result->sendDocumentInteractiveResult->documentKey->documentKey;
					$str_pos = strpos($result->sendDocumentInteractiveResult->embeddedCode, 'https:');
					$end_pos = strpos($result->sendDocumentInteractiveResult->embeddedCode, '><');
					
					$return_data['interactive_url'] = $result->sendDocumentInteractiveResult->url;
					$return_data['iframe_url'] = substr($result->sendDocumentInteractiveResult->embeddedCode, $str_pos, $end_pos - $str_pos-1);
					$return_data['record'] = $agreement->id;
				}
			}
			
			return $return_data;
		}
		catch(Exception $e){
			$this->msg .=  trim($e->getMessage())."\r\n";
			$this->error = 1;
			return false;
		}
	}
	
	
	
	
	
	/**
	 *	cancelDocument
	 *
	 *  cancelDocument can be used to abort the signature workflow for any document that you sent out using sendDocument. The sender 
	 *	and the recipient will be notified by email that the transaction has been cancelled, subject to the notification parameters 
	 *	described below. The documentKey is tied to the apiKey and is not valid with any other API key.
	 *
	 **/
	public function cancelDocument($document_key, $comment, $notify_signer)
	{
		if(!$this->s) return false;
		
		$params = array('apiKey' => $this->apiKey,
						'documentKey' => $document_key,
						'comment' => $comment,
						'notifySigner' => $notify_signer,
					);
			
						
		try{
			$result = $this->s->cancelDocument($params);
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}
	
	
	
	
	/**
	 *	sendReminder
	 *
	 * sendReminder can be used to a real time reminder for any document that you sent out using sendDocument. 
	 * The party whose turn it is to sign the document (which can either be the sender or the recipient) will 
	 * receive an email similar to the original request to sign that reminds them that their signature is required. 
	 * The documentKey is tied to the apiKey and is not valid with any other API key.
	 *
	 **/
	public function sendReminder($documentKey, $comment)
	{
		if(!$this->s) return false;
		
		$params = array('apiKey' => $this->apiKey,
						'documentKey' => $documentKey,
						'comment' => $comment,
					);
		try{
			$result = $this->s->sendReminder($params);
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}
	
	
	
	
	
	public function _getDocumentCreationInfo($agreement)
	{
		list($recipients, $ccs) = $this->_get_signers($agreement);
		
		$documentCreationInfo = array();
		$documentCreationInfo['fileInfos'] = $this->_get_file_info($agreement);
		$documentCreationInfo['message'] = $agreement->description;
		$documentCreationInfo['name'] = stripslashes(htmlspecialchars_decode($agreement->name, ENT_QUOTES));
		
		if(empty($documentCreationInfo['name']))
			$documentCreationInfo['name'] = stripslashes(htmlspecialchars_decode($agreement->document_name, ENT_QUOTES));
		
		$documentCreationInfo['signatureFlow'] = $this->_get_signature_order($agreement);
		$documentCreationInfo['signatureType'] = $agreement->signature_type;
		$documentCreationInfo['recipients'] = $recipients;
		$documentCreationInfo['locale'] = $agreement->document_language;
		
		if($this->useCallBackMethod){
			$documentCreationInfo['callbackInfo'] = array( 'signedDocumentUrl' => $this->signedDocumentUrl);
		}
		
		if(!empty($agreement->reminder_frequency)){ 
			$documentCreationInfo['reminderFrequency'] = $agreement->reminder_frequency;
		}
		
		if(count($ccs) > 0){
			$documentCreationInfo['ccs'] = $ccs;
		}
		
		if(!empty($agreement->days_until_signing_deadline) && (int) $agreement->days_until_signing_deadline > 0){
			$documentCreationInfo['daysUntilSigningDeadline'] = (int) $agreement->days_until_signing_deadline;
		}
		
		if($agreement->security_protect_signature || $agreement->security_protect_open){
			$documentCreationInfo['securityOptions'] = $this->_get_security_options($agreement);
		}
	
		return $documentCreationInfo;
	}
	
	
	public function _getSendDocumentInteractiveOptions($agreement)
	{
		$sendDocumentInteractiveOptions = array();
		$sendDocumentInteractiveOptions['authoringRequested'] = true;
		$sendDocumentInteractiveOptions['autoLoginUser'] = true;
		$sendDocumentInteractiveOptions['noChrome'] = true;
		
		return $sendDocumentInteractiveOptions;
	}
	
	
	

	/**********************************************************************************************************************	
	 *  STAUS METHODS
	 *
	 *
	 * getDocumentInfo
	 * getLatestDocument
	 * getDocumentByVersion
	 * getLatestDocumentUrl
	 * getLatestImages
	 * 
	  ***********************************************************************************************************************/
	
	
	
	/**
	 *	getDocumentInfo
	 *
	 *  getDocumentInfo can be used to retrieve the up-to-date status of documents. The documentKey is tied to the apiKey and 
	 *	is not valid with any other API key.
	 *
	 **/
	public function getDocumentInfo($documentKey)
	{
		if(!$this->s) return false;
		
		try{
			$result = $this->s->getDocumentInfo(array('apiKey' => $this->apiKey, 'documentKey' => $documentKey))->documentInfo;
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}
	
	
	
	
	/**
	 *	getLatestDocument
	 *
	 *  getLatestDocument can be used to retrieve the latest version of documents. The documentKey is tied to the apiKey and is 
	 *	not valid with any other API key.
	 *
	 **/
	public function getLatestDocument($documentKey)
	{
		if(!$this->s) return false;
		if(!$documentKey) return;
		
		$params = array('apiKey' => $this->apiKey,
						'documentKey' => $documentKey
					);
		
		try{
			$result = $this->s->getLatestDocument($params);
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}
	
	
	
	
	/**
	 *	getDocumentByVersion
	 *
	 *  getDocumentByVersion can be used to retrieve the content of a particular version of a document that was sent out for 
	 *	signature, using a version key returned  by getDocumentInfo. The versionKey is tied to the apiKey and is not valid with any 
	 *	other API key.
	 *
	 **/
	public function getDocumentByVersion($versionKey)
	{
		$params = array('apiKey' => $this->apiKey,
					'versionKey' => $versionKey
					);
	
		try{
			$result = $this->s->getDocumentByVersion($params);
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}
	 
	 
	 
	 /**
	 *	getLatestImages
	 *
	 *  getLatestImages can be used to retrieve the URLs for the images of a document, using a version key returned by getDocumentInfo. 
	 *	The documentKey is tied to the apiKey and is not valid with any other API key.
	 *
	 **/
	public function getLatestImages($documentKey)
	{
		if(!$this->s) return false;
		
		$params = array('apiKey' => $this->apiKey,
						'documentKey' => $documentKey,
					);
	
		try{
			$result = $this->s->getLatestImages($params);
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	}  
	 
	
	
	 
	/**
	 *	getSigningUrl
	 *
	 *
	 *
	 **/
	public function getSigningUrl($document_key)
	{
		$params = array('apiKey' => $this->apiKey,
					'documentKey' => $document_key,
					);
	
		try{
			$this->result = $this->s->getSigningUrl($params);
			if($this->result->getSigningUrlResult->errorCode == 'OK'){
				return $this->result->getSigningUrlResult->signingUrls->SigningUrl->esignUrl;
			}
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	} 
	
	
	
	
	
	
	/**********************************************************************************************************************	
	 *  USER METHODS
	 *
	 * createUser
	 * verifyUser
	 * getUsersInAccount
	 * createAccount
	 *
	  ***********************************************************************************************************************/



	/**
	 *	createUser
	 *
	 *	createUser can be used to create a new EchoSign user who can then become the sender of a document used in sendDocument. 
	 *	Note that you do not need to call createUser to create recipient users - EchoSign does not require the recipients to be 
	 *	registered users.
	 *
	 *  Please see our Single Sign On documentation for additional information about user management.
	 *
	 **/
	public function createUser($user)
	{
		global $current_user;
		
		$userCreationInfo = array();
		$userCreationInfo['email'] = $user->email1;
		$userCreationInfo['password'] = $this->genRandomString();
		$userCreationInfo['firstName'] = ($user->first_name) ? $user->first_name : 'Unknown';
		$userCreationInfo['lastName'] = $user->last_name;
		if($user->phone_work) $userCreationInfo['phone'] = $user->phone_work;
		if($user->title) $userCreationInfo['title'] = $user->title;
		
		
		$params = array('apiKey' => $this->apiKey, 'userInfo' => $userCreationInfo);
			
		try{
			$result = $this->s->createUser($params);
			if(!empty($result) && !empty($result->userKey)){
				$current_user->echosign_user_key_c = $result->userKey;
				$current_user->save();
			}
			
			return $result;
		}
		catch(Exception $e)
		{
			if(strstr($e->getMessage(), 'User already exists') !== false){		
				
				$sugar_user_beans = array();
				
				// get a list of the users in Sugar
				$sugar_user = new User();
				$sugar_user_beans = $sugar_user->get_full_list();
				foreach($sugar_user_beans as $b){
					require_once('modules/Users/User.php');
					$u = new User();
					$u->retrieve($b->id);
					$b->email1 = $u->email1;
				}
				
				
				$echo_users = $this->getUsersInAccount();
				if(!empty($echo_users) && 
						!empty($echo_users->getUsersInAccountResult) && 
						!empty($echo_users->getUsersInAccountResult->userListForAccount) && 
						is_array($echo_users->getUsersInAccountResult->userListForAccount->UserInfo)
				){
					
					foreach($echo_users->getUsersInAccountResult->userListForAccount->UserInfo as $index => $echo_user)
					{
						$sugar_user = $this->get_sugar_user_from_email($sugar_user_beans, $echo_user->email);
						if($sugar_user)
						{
							// update the sugar user 
							if($sugar_user->echosign_user_key_c != $echo_user->userKey){
								$sugar_user->echosign_user_key_c = $echo_user->userKey;
								$sugar_user->save();
							}
							
							// set the global current user echosign user key
							if($current_user->id == $sugar_user->id)
								$current_user->echosign_user_key_c = $echo_user->userKey;
						}					
					}
				}
			}
			else
			{
				$this->msg .=  $e->getMessage()."\r\n";	
				return false;
			}
		}
	} 
	
	
	
	
	public function get_sugar_user_from_email($sugar_users, $email){
		foreach($sugar_users as $user){
			if(strtolower($user->email1) === strtolower($email))
				return $user;
		}
	}
	
	
	
	
	
	/**
	 *	verifyUser
	 *
	 *
	 *
	 **/
	public function verifyUser()
	{
		$params = array('apiKey' => $this->apiKey,
					'email' => $email,
					'password' => $password
					);
	
		try{
			$result = $this->s->verifyUser($params);
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	} 
	
	
	
	
	
	/**
	 *	getUsersInAccount
	 *
	 *	getUsersInAccount lists all the users who are in the same account as that of the apiKey holder 
	 *	who makes the request. The userKey values obtained can then be used in getDocumentsForUser
	 *
	 **/
	public function getUsersInAccount()
	{
		if(!$this->s) return;
		
		$params = array('apiKey' => $this->apiKey);
	
		try{
			$result = $this->s->getUsersInAccount($params);
			return $result;
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	} 
	
	
	/**
	 *	createAccount
	 *
	 *
	 *
	 **/
	public function createAccount()
	{
		$params = array('apiKey' => $this->apiKey, );
	
		try{
			$result = $this->s->createAccount($params);
		}
		catch(Exception $e){
			$this->msg .=  $e->getMessage()."\r\n";	
			$this->error = 1;
		}
	} 


	
	
	

	
	
	/**********************************************************************************************************************
	 * HELPER FUNCTIONS
	 *  
	 *
	 ***********************************************************************************************************************/
	
	
	public function _get_file_info($agreement)
	{
		global $db, $sugar_config;
		
		$documents = $agreement->documents;
		
		$GLOBALS['log']->debug('EchoSign: '.count($documents).' document(s) found for this agreement');
		
		// need to sort by the date they were attached to the echosign agreement
		
		$documentArray = array();
		if(count($documents) === 1)
		{
			foreach($documents as $doc)
				$documentArray[] = $doc;
		}
		else
		{
			foreach($documents as $doc)
			{
				$GLOBALS['log']->debug('EchoSign: Grabbing modified date for document '.$doc->id);
			
				$query = "SELECT date_modified 
							FROM echo_agreemts_documents_c 
							WHERE echo_agree1b23cuments_idb = '".$db->quote($doc->id)."' 
								AND echo_agree3ec7eements_ida = '".$db->quote($agreement->id)."' AND deleted = 0";
							
				$res = $db->query($query);
				if($res){
					$result = $db->fetchByAssoc($res);
					if($result)
						$documentArray[$result['date_modified']] = $doc;
				}			
			}
		
			ksort($documentArray);
		}
		
				
		$GLOBALS['log']->debug('EchoSign: Adding '.count($documentArray).' document(s) to agreement after sorting');
		
		
		$files = array();
		foreach($documentArray as $doc){
			$files['FileInfo'][] = array('file' => sugar_file_get_contents(rtrim($sugar_config['upload_dir'], '/').'/'.$doc->document_revision_id), 'fileName' => $doc->filename);
			$GLOBALS['log']->debug('EchoSign: Adding '.$doc->filename.' to agreement.');
			$path = rtrim($sugar_config['upload_dir'], '/').'/'.$doc->document_revision_id;
			$GLOBALS['log']->debug('EchoSign: Path = '.$path);
		}
		
		$GLOBALS['log']->debug('EchoSign: Total files added ='.count($files));
		
		return $files;
	}
	
	
	
	
	public function _get_signers($agreement)
	{
		$signers = array();
		$the_signers = $agreement->signers;
		foreach($the_signers as $index => $signer){
			$this->add_signer_to_array($signers, $signer);
		}
		
		ksort($signers);
		
		$recipients['RecipientInfo'] = array();
		$ccs = array();
		foreach($signers as $index => $signer){
			if($signer->role === 'CC'){ 
				if($signer->email_address) $ccs[] = $signer->email_address;
				else if(strlen($signer->name) == strlen(preg_replace("/[^0-9]/", "", $signer->name)))
					$ccs[] = $signer->name;
			}
			else{
				if($signer->email_address) 
					$recipients['RecipientInfo'][] = array('email' => $signer->email_address, 'role' => strtoupper($signer->role));
				
				// otherwise we are sending a fax. approvers are skipped for faxes (not supported by api)
				else if(strlen($signer->name) == strlen(preg_replace("/[^0-9]/", "", $signer->name)) && strtolower($signer->role) != 'approver')
					$recipients['RecipientInfo'][] = array('fax' => $signer->name);
			}
		}
		
		
		return array($recipients, $ccs);
	}
	
	
	public function add_signer_to_array(&$signers, $signer){
		if(!isset($signers[$signer->signing_order])){
			$signers[$signer->signing_order] = $signer;
		}
		else{
			$signer->signing_order++;
			$this->add_signer_to_array($signers, $signer);
		}
	}	
	
	
	public function _get_sender_info($agreement)
	{					
		global $current_user;

		if(empty($current_user->echosign_user_key_c)){
			$result = $this->createUser($current_user);
		}
		
		//return (empty($current_user->echosign_user_key_c)) ? array('email' => strtolower($current_user->email1)) : array('userKey' => $current_user->echosign_user_key_c);
	
		// always use email to send docs
		return array('email' => strtolower($current_user->email1));
	}
	
	
	
	public function _get_signature_order($agreement)
	{
		return ($agreement->signature_flow) ? $agreement->signature_flow : 'SENDER_SIGNATURE_NOT_REQUIRED';
	}

	public function _get_security_options($agreement)
	{
		$securityOptions = array();
		$securityOptions['password'] = $agreement->security_password;
		$securityOptions['protectOpen'] = ($agreement->security_protect_open) ? true : false;
		
		if(!empty($agreement->security_protect_signature)){
			$securityOptions['passwordProtection'] = 'ALL_USERS';
		}	
		
		return $securityOptions;
	}
	
	
	
	
	// pseudo random passwords.... EchoSign doesn't actually require or need them saved in sugar.... 
	function genRandomString() {
   	 	$length = 10;
   	 	$ints = "0123456789";
   	 	$upper = "ABCDEFGHIJKLMNOPQRSTUVWXWY";
   	 	$lower = "abcdefghijklmnopqrstuvwxyz";
    	
		$i1 = $ints[mt_rand(0, 9)];
		$i2 = $ints[mt_rand(0,9)];
		$i3 = $ints[mt_rand(0,9)];
		$u1 = $upper[mt_rand(0,25)];
		$u2 = $upper[mt_rand(0,25)];
		$u3 = $upper[mt_rand(0,25)];
		$l1 = $lower[mt_rand(0,25)];
		$l2 = $lower[mt_rand(0,25)];
		$l3 = $lower[mt_rand(0,25)];
		$l4 = $lower[mt_rand(0,25)];
		
		$string = array($i1, $i2, $i3, $u1, $u2, $u3, $l1, $l2, $l3, $l4);
		shuffle($string);
		
		return implode('', $string);
	}
}